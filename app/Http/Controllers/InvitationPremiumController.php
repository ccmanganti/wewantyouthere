<?php

namespace App\Http\Controllers;

use App\Models\InvitationTemplate;
use App\Models\InvitationTemplatePurchase;
use App\Support\InvitationPremium;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class InvitationPremiumController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $template = InvitationTemplate::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        return view('weddings.premium-upgrade', [
            'template' => $template,
            'features' => InvitationPremium::FEATURES,
            'hasPremium' => InvitationPremium::has($request->user(), $template),
            'checkoutReady' => InvitationPremium::isAvailable(),
        ]);
    }

    public function checkout(Request $request, string $slug): RedirectResponse
    {
        $template = InvitationTemplate::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        if (InvitationPremium::has($request->user(), $template)) {
            return redirect()->route('wedding.editor', $template->slug)
                ->with('status', 'Premium features are already available in your account.');
        }

        if (!InvitationPremium::isAvailable()) {
            return back()->withErrors(['checkout' => 'Secure checkout is being configured. No payment has been taken.']);
        }

        $price = (int) $template->premium_price_cents;
        abort_if($price < 100, 422, 'Set a valid premium price in the admin template settings first.');

        $purchase = InvitationTemplatePurchase::create([
            'user_id' => $request->user()->id,
            'invitation_template_id' => $template->id,
            'amount_cents' => $price,
            'currency' => $template->premium_currency ?: 'PHP',
            'status' => 'pending',
        ]);

        $response = Http::withToken(config('services.stripe.secret'))
            ->asForm()->timeout(15)->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'client_reference_id' => (string) $purchase->id,
                'customer_email' => $request->user()->email,
                'success_url' => route('premium.success', $template->slug) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('premium.show', $template->slug),
                'metadata' => ['purchase_id' => (string) $purchase->id],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($purchase->currency),
                        'unit_amount' => $purchase->amount_cents,
                        'product_data' => ['name' => $template->name . ' — premium features'],
                    ],
                    'quantity' => 1,
                ]],
            ]);

        if (!$response->successful() || !preg_match('~^https://checkout\.stripe\.com/~', $response->json('url', ''))) {
            $purchase->update(['status' => 'failed']);
            report(new \RuntimeException('Stripe Checkout session could not be created: ' . $response->status()));
            return back()->withErrors(['checkout' => 'Checkout could not start. Please try again later. No payment was taken.']);
        }

        $purchase->update(['provider_session_id' => (string) $response->json('id')]);
        return redirect()->away((string) $response->json('url'));
    }

    public function success(Request $request, string $slug): View
    {
        $template = InvitationTemplate::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        $purchase = InvitationTemplatePurchase::query()
            ->where('user_id', $request->user()->id)
            ->where('invitation_template_id', $template->id)
            ->where('provider_session_id', (string) $request->query('session_id'))
            ->firstOrFail();

        // Reconcile the success redirect with Stripe's actual payment status.
        // The redirect alone is never proof of payment.
        if ($purchase->status !== 'paid' && filled(config('services.stripe.secret'))) {
            $response = Http::withToken(config('services.stripe.secret'))->timeout(12)
                ->get('https://api.stripe.com/v1/checkout/sessions/' . rawurlencode($purchase->provider_session_id));
            if ($response->successful()) $this->confirmPaid($response->json());
        }

        return view('weddings.premium-success', [
            'template' => $template,
            'paid' => $purchase->fresh()->status === 'paid',
        ]);
    }

    public function webhook(Request $request): \Illuminate\Http\Response
    {
        $secret = config('services.stripe.webhook_secret');
        abort_unless(filled($secret), 503);
        $header = $request->header('Stripe-Signature', '');
        $signature = collect(explode(',', $header))->mapWithKeys(function ($part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, '');
            return [$key => $value];
        })->all();
        $timestamp = $signature['t'] ?? '';
        $v1 = $signature['v1'] ?? '';
        abort_unless(ctype_digit((string) $timestamp) && abs(time() - (int) $timestamp) <= 300, 400);
        $signed = $timestamp . '.' . $request->getContent();
        abort_unless(hash_equals(hash_hmac('sha256', $signed, $secret), (string) $v1), 400);

        $event = json_decode($request->getContent(), true);
        abort_unless(is_array($event), 400);

        if (in_array($event['type'] ?? '', ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)) {
            $this->confirmPaid($event['data']['object'] ?? []);
        } elseif (($event['type'] ?? '') === 'checkout.session.expired') {
            InvitationTemplatePurchase::query()->where('provider_session_id', (string) ($event['data']['object']['id'] ?? ''))
                ->where('status', 'pending')->update(['status' => 'expired']);
        }
        return response('OK');
    }

    private function confirmPaid(array $session): void
    {
        if (($session['payment_status'] ?? '') !== 'paid' || ($session['mode'] ?? '') !== 'payment') return;
        $sessionId = (string) ($session['id'] ?? '');
        $purchaseId = (int) ($session['metadata']['purchase_id'] ?? $session['client_reference_id'] ?? 0);
        if (!$sessionId || !$purchaseId) return;

        DB::transaction(function () use ($session, $sessionId, $purchaseId) {
            $purchase = InvitationTemplatePurchase::query()->lockForUpdate()->find($purchaseId);
            if (!$purchase || $purchase->status === 'paid') return;
            if ($purchase->provider_session_id && $purchase->provider_session_id !== $sessionId) return;
            if ($purchase->amount_cents !== (int) ($session['amount_total'] ?? -1)) return;
            if (strtolower($purchase->currency) !== strtolower((string) ($session['currency'] ?? ''))) return;
            if (!in_array($purchase->status, ['pending', 'expired'], true)) return;

            $purchase->update([
                'provider_session_id' => $sessionId,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        });
    }
}
