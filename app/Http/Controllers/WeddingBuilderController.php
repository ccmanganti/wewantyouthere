<?php

namespace App\Http\Controllers;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use App\Models\InvitationSlugRedirect;
use App\Models\WeddingMessageTemplate;
use App\Models\User;
use App\Support\InvitationAccounts;
use App\Support\InvitationWebsiteManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
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
            ->where('settings->renderer', 'builtin_wedding')
            ->orderBy('name')
            ->get();

        $canCreate = ! Auth::check() || InvitationAccounts::canCreateWebsite(Auth::user());

        return view('marketing.home', compact('templates', 'canCreate'));
    }

    public function editor(string $slug): View | RedirectResponse
    {
        if (Auth::check() && ! InvitationAccounts::canCreateWebsite(Auth::user())) {
            return redirect('/app/invitations')->with('status', 'Your free plan already has one invitation. You can edit or delete it from My Invitations.');
        }

        $template = InvitationTemplate::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
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


        $photoSlots = config('wedding_photos', []);
        $photos = session('wedding_uploads.' . $template->id, []);
        $photoUrls = [];
        foreach ($photos as $slot => $item) {
            if (isset($photoSlots[$slot], $item['path']) && Storage::disk('local')->exists($item['path'])) {
                $photoUrls[$slot] = route('wedding.photos.draft', ['slug' => $template->slug, 'slot' => $slot]);
            }
        }

        return view('weddings.editor', compact('template', 'groups', 'draft', 'questions', 'photos', 'photoSlots', 'photoUrls'));
    }

    /**
     * Read-only generator for original, hand-authored wedding wording.
     * Its field whitelist prevents arbitrary category or database access.
     */
    public function generateMessage(Request $request, string $slug): JsonResponse
    {
        $template = InvitationTemplate::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('settings->renderer', 'builtin_wedding')
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->firstOrFail();

        $fieldCategories = config('wedding_message_fields', []);
        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(array_keys($fieldCategories))],
            'exclude' => ['nullable', 'integer', 'min:1'],
        ]);
        $field = $validated['field'];

        abort_unless(
            $template->eventType->questions()
                ->where('key', $field)->where('is_enabled', true)->exists(),
            404,
        );

        $suggestions = WeddingMessageTemplate::query()
            ->where('category', $fieldCategories[$field]);
        if (!empty($validated['exclude'])) {
            $suggestions->where('id', '!=', (int) $validated['exclude']);
        }

        $suggestion = $suggestions->inRandomOrder()->first();

        if (!$suggestion) {
            return response()->json([
                'message' => 'Suggestions are not available yet. Please ask the site administrator to seed the wedding message library.',
            ], 503)->header('Cache-Control', 'no-store');
        }

        return response()->json([
            'id' => $suggestion->id,
            'content' => $suggestion->content,
        ])->header('Cache-Control', 'no-store');
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
            ->where('settings->renderer', 'builtin_wedding')
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->firstOrFail();

        $base = $request->validate([
            'slug' => ['nullable', 'string', 'min:3', 'max:72', 'regex:/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/D', Rule::unique('invitation_websites', 'slug')],
            'answers' => ['required', 'array'],
            'show_parents' => ['nullable', Rule::in(['0', '1', 0, 1])],
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
        // Persist the explicit opt-in; users may supply some names, or omit them
        // all without showing placeholder family cards on the published site.
        $answers['_show_parents'] = $request->boolean('show_parents') && (($template->settings['theme'] ?? '') === 'royal_burgundy');

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


        $mediaKey = 'wedding_uploads.' . $template->id;
        foreach ($request->session()->get($mediaKey, []) as $photo) {
            if (isset($photo['path'])) Storage::disk('local')->delete($photo['path']);
        }
        $request->session()->forget($mediaKey);
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

                $website = InvitationWebsite::create([
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

                // Copy private session photos into owner-scoped permanent storage.
                // If a file cannot be copied, rollback the database publication.
                $draftPhotos = $request->session()->get('wedding_uploads.' . $template->id, []);
                $manifest = [];
                foreach (config('wedding_photos', []) as $slot => $definition) {
                    $photo = $draftPhotos[$slot] ?? null;
                    if (! $photo) continue;
                    if (! isset($photo['path'], $photo['mime']) || ! Storage::disk('local')->exists($photo['path'])) {
                        throw new RuntimeException('An invitation photo is missing. Please re-upload it.');
                    }
                    $extension = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$photo['mime']] ?? null;
                    if (! $extension) throw new RuntimeException('Unsupported invitation image type.');
                    $destination = 'wedding-sites/' . $website->id . '/' . $slot . '.' . $extension;
                    if (! Storage::disk('local')->copy($photo['path'], $destination)) {
                        throw new RuntimeException('Unable to save a wedding photograph. Please try again.');
                    }
                    $manifest[$slot] = ['path' => $destination, 'mime' => $photo['mime']];
                }
                if ($manifest) $website->update(['media' => $manifest]);

                return $website;
            });
        } catch (ValidationException $error) {
            $destination = isset($error->errors()['account'])
                ? '/app/invitations'
                : route('wedding.editor', $template->slug);

            return redirect($destination)->withErrors($error->errors());
        } catch (RuntimeException $error) {
            return redirect()->route('wedding.editor', $template->slug)
                ->withErrors(['photos' => $error->getMessage()]);
        }


        $mediaKey = 'wedding_uploads.' . $template->id;
        foreach ($request->session()->get($mediaKey, []) as $photo) {
            if (isset($photo['path'])) Storage::disk('local')->delete($photo['path']);
        }
        $request->session()->forget($mediaKey);
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

        $photoUrls = [];
        foreach ($website->media ?? [] as $slot => $photo) {
            if (array_key_exists($slot, config('wedding_photos', []))) {
                $photoUrls[$slot] = route('wedding.photos.site', ['slug' => $website->slug, 'slot' => $slot])
                    . '?v=' . rawurlencode(basename($photo['path'] ?? '0'));
            }
        }

        return view('weddings.show', [
            'photoUrls' => $photoUrls,
            'template' => $website->template,
            'website' => $website,
            'answers' => $website->answers ?? [],
            'sections' => ($website->answers ?? [])['_sections'] ?? [],
            'questions' => $website->template->eventType->questions()->where('is_enabled', true)->orderBy('sort_order')->get()->groupBy('group_key'),
        ]);
    }
}
