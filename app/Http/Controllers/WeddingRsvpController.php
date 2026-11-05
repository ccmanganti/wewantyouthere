<?php

namespace App\Http\Controllers;

use App\Models\InvitationWebsite;
use App\Support\InvitationPremium;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WeddingRsvpController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $website = InvitationWebsite::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        abort_unless(InvitationPremium::has($website->user, $website->template), 403, 'RSVP is a premium invitation feature.');

        $answers = $website->answers ?? [];
        if (filled($answers['rsvp_deadline'] ?? null)) {
            try {
                if (CarbonImmutable::parse($answers['rsvp_deadline'])->endOfDay()->isPast()) {
                    throw ValidationException::withMessages(['attendance' => 'RSVPs for this wedding have closed. Please contact the couple.']);
                }
            } catch (ValidationException $e) {
                throw $e;
            } catch (\Throwable $e) {
                // An invalid stored date must not prevent guest response.
            }
        }

        // Per-invitation allowance, never a global headcount or paid seat limit.
        $maximum = max(1, min(12, (int) ($answers['guest_limit'] ?? 3)));
        $data = $request->validate([
            'guest_name' => ['required','string','min:2','max:120'],
            'attendance' => ['required',Rule::in(['attending','declined'])],
            'party_size' => ['nullable','integer','min:1','max:'.$maximum],
            'message' => ['nullable','string','max:500'],
            'website' => ['nullable','size:0'], // honeypot
        ]);

        if ($data['attendance'] === 'attending' && empty($data['party_size'])) {
            throw ValidationException::withMessages(['party_size' => 'Select how many guests will attend, including you.']);
        }

        $rsvp = $website->rsvps()->create([
            'guest_name' => trim($data['guest_name']),
            'attendance' => $data['attendance'],
            'guest_count' => $data['attendance'] === 'declined' ? 0 : (int) $data['party_size'],
            'message' => trim($data['message'] ?? '') ?: null,
        ]);

        // Never lose a saved RSVP if the mail transport is unavailable.
        // Notifications go to the verified account owner, not a guest-entered address.
        try {
            $ownerEmail = $website->user?->email;
            if ($ownerEmail && filter_var($ownerEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::raw(
                    "A new RSVP was received for {$website->name}.\n\n"
                    . "Guest: {$rsvp->guest_name}\n"
                    . "Response: {$rsvp->attendance}\n"
                    . "Guests attending: {$rsvp->guest_count}\n"
                    . "Message: " . ($rsvp->message ?: 'None') . "\n\n"
                    . "Review RSVPs: " . route('wedding.rsvps.manage', $website),
                    static function ($message) use ($ownerEmail) {
                        $message->to($ownerEmail)->subject('New guest RSVP — We Want You There');
                    },
                );
            }
        } catch (\Throwable $error) {
            Log::warning('Premium RSVP saved but email notification failed', [
                'invitation_id' => $website->id, 'rsvp_id' => $rsvp->id,
            ]);
        }

        return redirect()->route('wedding.show', $website->slug)
            ->with('rsvp_success', $data['attendance'] === 'attending'
                ? 'Thank you! Your attendance has been recorded.'
                : 'Thank you for letting us know. Your response has been recorded.');
    }

    public function manage(Request $request, InvitationWebsite $website): View
    {
        abort_unless((int) $website->user_id === (int) $request->user()->id, 403);
        abort_unless(InvitationPremium::has($request->user(), $website->template), 403, 'RSVP management requires premium.');

        return view('weddings.rsvps.index', [
            'website' => $website,
            'responses' => $website->rsvps()->latest()->paginate(25),
            'attending' => $website->rsvps()->where('attendance', 'attending')->sum('guest_count'),
            'declined' => $website->rsvps()->where('attendance', 'declined')->count(),
        ]);
    }
}
