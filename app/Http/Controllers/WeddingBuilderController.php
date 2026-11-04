<?php

namespace App\Http\Controllers;

use App\Models\EventQuestion;
use App\Models\EventType;
use App\Models\InvitationTemplate;
use App\Models\InvitationWebsite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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

    public function publish(Request $request, string $slug): RedirectResponse
    {
        $template = InvitationTemplate::query()
            ->where('slug', $slug)->where('status', 'published')->where('is_premium', false)
            ->whereHas('eventType', fn ($query) => $query->where('slug', 'wedding')->where('is_active', true))
            ->firstOrFail();

        $request->validate([
            'answers' => ['required', 'array'],
            'sections' => ['nullable', 'array'],
            'sections.*' => ['nullable', Rule::in(['0', '1', 0, 1])],
        ]);

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
            'answers' => $answers,
            'sections' => $sections,
        ];

        $request->session()->put('pending_wedding', $pending);
        $request->session()->put('wedding_builder_draft', $pending);

        return Auth::check()
            ? $this->complete($request)
            : redirect()->route('wedding.register')->with('status', 'Create your free account to publish your invitation.');
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
        $slug = Str::slug(($names ?: 'our-wedding')) . '-' . Str::lower(Str::random(8));

        $website = InvitationWebsite::create([
            'user_id' => $request->user()->id,
            'invitation_template_id' => $template->id,
            'name' => $title,
            'slug' => $slug,
            'answers' => array_merge(
                $pending['answers'],
                ['_sections' => $pending['sections']],
            ),
            'status' => 'published',
        ]);

        $request->session()->forget(['pending_wedding', 'wedding_builder_draft']);
        return redirect()->route('wedding.show', $website->slug)->with('status', 'Your free wedding website is live!');
    }

    public function show(string $slug): View
    {
        $website = InvitationWebsite::with('template.eventType')
            ->where('slug', $slug)->where('status', 'published')->firstOrFail();

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
