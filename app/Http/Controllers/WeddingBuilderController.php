<?php

namespace App\Http\Controllers;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\InvitationSlugRedirect;
use App\Models\User;
use App\Support\InvitationAccounts;
use App\Support\InvitationWebsiteManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class WeddingBuilderController extends Controller
{
    public function home(): View
    {
        $templates = InvitationTemplate::query()
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->where('status', 'published')
            ->orderBy('name')
            ->get();

        return view('welcome', compact('templates'));
    }

    public function editor(string $slug): View
    {
        $template = InvitationTemplate::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->firstOrFail();

        $questions = $template->eventType->questions()
            ->where('is_enabled', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group_key');

        $groups = collect(config('wedding_builder.groups'))->map(function ($group, $key) use ($questions) {
            return array_merge($group, [
                'key' => $key,
                'questions' => $questions->get($key, collect()),
            ]);
        })->filter(fn ($group) => $group['questions']->isNotEmpty());

        $draft = session('wedding_builder_draft', []);
        $draft = ($draft['template_id'] ?? null) === $template->id ? $draft : [];

        return view('weddings.editor', compact('template', 'groups', 'draft', 'questions'));
    }

    /**
     * Public availability check for a couple's preferred invitation URL.
     * The database unique index and publish validation are authoritative.
     */
    public function slugAvailability(Request $request): JsonResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'min:3', 'max:72', 'regex:/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/D'],
        ]);

        return response()->json([
            'available' => ! InvitationWebsiteManager::slugTaken($data['slug']),
        ]);
    }

    public function qrCode(Request $request, string $slug): Response
    {
        $website = InvitationWebsite::query()->where('slug', $slug)
            ->where('status', 'published')->firstOrFail();

        // Use the configured application URL rather than an untrusted Host header.
        $link = rtrim(config('app.url'), '/') . '/i/' . rawurlencode($website->slug);
        $svg = (new QRCode(new QROptions([
            'outputBase64' => false,
            'addQuietzone' => true,
            'quietzoneSize' => 4,
            'drawLightModules' => true,
            'scale' => 10,
        ])))->render($link);

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Content-Disposition' => ($request->boolean('download') ? 'attachment' : 'inline')
                . '; filename="' . $website->slug . '-qr.svg"',
            'Cache-Control' => 'public, max-age=3600',
            'X-Content-Type-Options' => 'nosniff',
            'X-Robots-Tag' => 'noindex',
        ]);
    }

    public function publish(Request $request, string $slug): RedirectResponse
    {
        if (Auth::check() && ! InvitationAccounts::canCreateWebsite($request->user())) {
            return redirect('/app/invitations')
                ->withErrors(['account' => 'Your free account already has one website. Manage or delete it before creating another.']);
        }

        $template = InvitationTemplate::query()
            ->where('slug', $slug)->where('status', 'published')->where('is_premium', false)
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->firstOrFail();

        $base = $request->validate([
            'slug' => ['nullable', 'string', 'min:3', 'max:72', 'regex:/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/D', Rule::unique('invitation_websites', 'slug')],
            'answers' => ['required', 'array'],
            'sections' => ['nullable', 'array'],
            'sections.*' => ['nullable', Rule::in(['0', '1', 0, 1])],
        ]);

        if (isset($base['slug']) && InvitationWebsiteManager::slugTaken($base['slug'])) {
            return back()->withErrors(['slug' => 'This invitation link is already reserved. Choose another one.'])->withInput();
        }

        $allowedGroups = config('wedding_builder.groups');
        $sections = [];
        foreach ($allowedGroups as $key => $group) {
            $sections[$key] = ! ($group['hideable'] ?? false)
                || $request->input("sections.$key", '1') === '1';
        }

        $rules = [];
        foreach ($template->eventType->questions()->where('is_enabled', true)->get() as $question) {
            $group = $allowedGroups[$question->group_key] ?? null;
            if (! $group || ! $sections[$question->group_key]) {
                continue;
            }

            $type = match ($question->type) {
                'date' => 'date',
                'time' => 'date_format:H:i',
                'number' => 'integer|min:0|max:100000',
                'url' => 'url:http,https',
                'email' => 'email',
                default => 'string',
            };
            $rules['answers.'.$question->key] = array_merge(
                [$question->is_required ? 'required' : 'nullable', $type],
                in_array($question->type, ['text', 'textarea', 'email', 'url']) ? ['max:2000'] : [],
            );
        }
        $validated = $request->validate($rules);
        $answers = array_filter($validated['answers'] ?? [], fn ($value) => $value !== null && $value !== '');
        $pending = [
            'template_id' => $template->id,
            'slug' => $base['slug'] ?? null,
            'answers' => $answers,
            'sections' => $sections,
        ];

        $request->session()->put('pending_wedding', $pending);
        $request->session()->forget('pending_wedding_attempted');
        $request->session()->put('wedding_builder_draft', $pending);

        return Auth::check()
            ? $this->complete($request)
            : redirect('/app/register')->with('status', 'Create your free account to publish your invitation.');
    }

    public function cancel(Request $request, string $slug): RedirectResponse
    {
        $template = InvitationTemplate::query()->where('slug', $slug)->firstOrFail();

        foreach (['pending_wedding', 'wedding_builder_draft'] as $key) {
            if (($request->session()->get($key)['template_id'] ?? null) === $template->id) {
                $request->session()->forget($key);
            }
        }

        $request->session()->forget('pending_wedding_attempted');

        return redirect()->route('home')
            ->with('clear_wedding_draft', $template->slug)
            ->with('status', 'Your draft was discarded. You can start a new invitation anytime.');
    }

    public function complete(Request $request): RedirectResponse
    {
        abort_unless(Auth::check(), 403);
        $pending = $request->session()->get('pending_wedding');

        if (! is_array($pending) || ! isset($pending['template_id'], $pending['answers'], $pending['sections'])) {
            return redirect()->route('home')->with('status', 'Select a template to get started.');
        }

        $template = InvitationTemplate::query()
            ->whereKey($pending['template_id'])
            ->where('status', 'published')->where('is_premium', false)
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding'))
            ->firstOrFail();

        $names = collect([$pending['answers']['bride_name'] ?? '', $pending['answers']['groom_name'] ?? ''])
            ->filter()->implode(' & ');
        $title = $names !== '' ? $names . ' — Wedding Invitation' : 'Our Wedding Invitation';
        $requestedSlug = $pending['slug'] ?? null;

        $slug = $requestedSlug ?: Str::slug(($names ?: 'our-wedding')) . '-' . Str::lower(Str::random(8));

        try {
            // Locking the owner row serializes concurrent publish requests from the same
            // free account. A client-side disabled button cannot enforce the quota.
            $website = DB::transaction(function () use ($request, $template, $pending, $title, $slug) {
                $owner = User::query()->lockForUpdate()->findOrFail($request->user()->id);

                if (! InvitationAccounts::canCreateWebsite($owner)) {
                    throw ValidationException::withMessages([
                        'account' => 'Your free plan allows one website. Delete your existing invitation before creating another.',
                    ]);
                }

                if (InvitationWebsiteManager::slugTaken($slug)) {
                    throw ValidationException::withMessages([
                        'slug' => 'This link is no longer available. Please choose a different one.',
                    ]);
                }

                return InvitationWebsite::create([
                    'user_id' => $owner->id,
                    'invitation_template_id' => $template->id,
                    'name' => $title,
                    'slug' => $slug,
                    'answers' => array_merge(
                        $pending['answers'],
                        ['_sections' => $pending['sections']],
                    ),
                    'status' => 'published',
                ]);
            });
        } catch (ValidationException $error) {
            $destination = isset($error->errors()['account'])
                ? '/app/invitations'
                : route('wedding.editor', $template->slug);

            return redirect($destination)->withErrors($error->errors());
        }

        $request->session()->forget(['pending_wedding', 'wedding_builder_draft', 'pending_wedding_attempted']);
        return redirect()->route('wedding.show', $website->slug)
            ->with('status', 'Your free wedding website is live!')
            ->with('clear_wedding_draft', $template->slug);
    }

    public function show(string $slug): View | RedirectResponse
    {
        $website = InvitationWebsite::with('template.eventType')
            ->where('slug', $slug)->where('status', 'published')->first();

        if (! $website) {
            $redirect = InvitationSlugRedirect::query()->with('website')
                ->where('slug', $slug)->firstOrFail();

            abort_unless($redirect->website?->status === 'published', 404);

            return redirect()->route('wedding.show', ['slug' => $redirect->website->slug], 301);
        }

        abort_unless(
            $website->template?->eventType?->slug === 'wedding'
            && ($website->template->settings['renderer'] ?? '') === 'builtin_wedding',
            404,
        );

        return view('weddings.show', [
            'website' => $website,
            'answers' => $website->answers ?? [],
            'sections' => ($website->answers ?? [])['_sections'] ?? [],
            'questions' => $website->template->eventType->questions()->where('is_enabled', true)->orderBy('sort_order')->get()->groupBy('group_key'),
        ]);
    }
}
