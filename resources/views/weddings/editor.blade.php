@extends('layouts.wwyt')
@section('body_class', 'builder-page')
@section('robots', 'noindex,nofollow')
@section('title', 'Build Your Wedding Invitation | We Want You There')
@section('meta_description', 'Create your wedding website step by step. Choose the sections, enter wedding details and see every change in the live preview.')

@push('styles')
@include('weddings.partials.editor-styles')
@include('weddings.partials.invitation-theme-styles')
@include('weddings.partials.editor-uri-styles')
@endpush

@section('content')
@php
    $defaultSelections = [
        'couple' => true, 'ceremony' => true, 'reception' => true,
        'entourage' => false, 'program' => false, 'guests' => true, 'details' => true,
    ];
    $currentSectionSelection = [];
    foreach ($groups as $key => $group) {
        $currentSectionSelection[$key] = !($group['hideable'] ?? false)
            || ($draft['sections'][$key] ?? $defaultSelections[$key] ?? false);
    }
@endphp
<div class="builder-app" id="wedding-builder" data-template="{{ $template->slug }}" data-mobile-view="edit">
    <div class="builder-utility">
        <div class="builder-title">
            <a class="builder-back" href="{{ route('home') }}#templates" title="Back to templates">← Templates</a>
            <span aria-hidden="true" style="color:#67575b">/</span>
            <div><strong>{{ $template->name }}</strong><small>Your wedding invitation workspace</small></div>
        </div>
        <div class="builder-utility-right">
            <div class="draft-indicator" id="draft-indicator" data-state="saving" role="status" aria-live="polite">Saving draft...</div>
            <div class="builder-mobile-switch" role="group" aria-label="Mobile workspace view">
                <button type="button" id="mobile-edit" aria-pressed="true">Edit</button>
                <button type="button" id="mobile-preview" aria-pressed="false">Preview</button>
            </div>
            <form id="cancel-builder-form" method="POST" action="{{ route('wedding.cancel', $template->slug) }}">@csrf
                <button class="cancel-btn" type="submit" id="cancel-builder">Cancel building</button>
            </form>
        </div>
    </div>

    <nav class="wizard-strip" aria-label="Invitation creation steps">
        <button type="button" class="wizard-step is-current" data-step-navigation="sections" aria-current="step">
            <span class="step-dot">1</span> Choose sections
        </button>
        <span class="wizard-arrow" aria-hidden="true">›</span>
        <button type="button" class="wizard-step" data-step-navigation="details" disabled>
            <span class="step-dot">2</span> Add your details
        </button>
        <span class="wizard-arrow" aria-hidden="true">›</span>
        <button type="button" class="wizard-step" data-step-navigation="publish" disabled>
            <span class="step-dot">3</span> Review & publish
        </button>
    </nav>

    @if($errors->any())
    <div class="alert" style="margin:0 14px;border-radius:0;color:#9b282b;background:#fcebe7" role="alert">
        Please check the highlighted fields. {{ $errors->first() }}
    </div>
    @endif

    <form id="wedding-form" class="builder-columns" action="{{ route('wedding.publish', $template->slug) }}" method="POST" novalidate>
        @csrf
        <div class="editor-pane" aria-label="Invitation editor">
            <section class="editor-stage is-active" data-stage="sections" aria-labelledby="section-stage-title">
                <div class="stage-top">
                    <span class="stage-kicker">Step 01 / 03 · Make it personal</span>
                    <h1 id="section-stage-title">What would you like to include?</h1>
                    <p>Select the sections that belong in your wedding invitation. You can change this later without losing what you've typed.</p>
                </div>
                <div class="stage-scroll">
                    <div class="selector-intro">
                        <span class="selector-icon" aria-hidden="true">✦</span>
                        <div><strong>Start with the essentials.</strong><p>The couple and ceremony are always included. Add only what feels right for your celebration.</p></div>
                    </div>
                    <div class="section-choice-grid">
                        @foreach($groups as $key => $group)
                            @php
                                $fixed = !($group['hideable'] ?? false);
                                $selected = $currentSectionSelection[$key];
                                $sectionInfo = [
                                    'couple' => ['01', 'Your names, parents and love story'],
                                    'ceremony' => ['02', 'Wedding date, ceremony details and location'],
                                    'reception' => ['03', 'Reception, directions and accommodation'],
                                    'entourage' => ['04', 'Sponsors, ninong, ninang and wedding party'],
                                    'program' => ['05', 'Timeline, activities and reception program'],
                                    'guests' => ['06', 'Guest policies, RSVP information and contacts'],
                                    'details' => ['07', 'Dress code, gift preferences and FAQs'],
                                ];
                                [$number, $description] = $sectionInfo[$key] ?? ['✦', $group['description']];
                            @endphp
                            <label class="section-choice" data-choice-card="{{ $key }}" data-required="{{ $fixed ? 'true' : 'false' }}">
                                <span class="choice-top">
                                    <span class="choice-icon" aria-hidden="true">{{ $number }}</span>
                                    @if($fixed)
                                        <input type="checkbox" checked disabled aria-label="{{ $group['title'] }} is always included">
                                    @else
                                        <input type="checkbox" data-section-toggle="{{ $key }}" {{ $selected ? 'checked' : '' }} aria-label="Include {{ $group['title'] }}">
                                    @endif
                                </span>
                                <strong>{{ $group['title'] }}</strong>
                                <small>{{ $description }}</small>
                                @if($fixed)<span class="always">Always included</span>@endif
                                <input type="hidden" data-section-input="{{ $key }}" name="sections[{{ $key }}]" value="{{ $selected ? '1' : '0' }}">
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="stage-footer">
                    <p id="section-selection-count">Choose your sections to continue.</p>
                    <button type="button" class="btn" id="sections-next">Continue to details →</button>
                </div>
            </section>

            <section class="editor-stage" data-stage="details" aria-labelledby="detail-stage-title">
                <div class="group-headline">
                    <span class="group-count" id="group-counter">Your details</span>
                    <h2 id="detail-stage-title">The happy couple</h2>
                    <p id="group-subtitle">Only the questions for this section are shown.</p>
                </div>
                <div class="group-tabs" id="group-tabs" aria-label="Question sections">
                    @foreach($groups as $key => $group)
                        <button type="button" class="group-tab" data-group-tab="{{ $key }}">{{ $group['title'] }}</button>
                    @endforeach
                </div>
                <div class="stage-scroll detail-scroll" id="detail-scroll">
                    @foreach($groups as $key => $group)
                        @php
                            $all = $group['questions']->values();
                            $primaryQuestions = $all->filter(fn ($question, $index) => $index < 4 || $question->is_required);
                            $advancedQuestions = $all->reject(fn ($question, $index) => $index < 4 || $question->is_required);
                        @endphp
                        <div class="question-group" data-question-group="{{ $key }}" data-group-description="{{ $group['description'] }}">
                            <div class="question-grid">
                                @foreach($primaryQuestions as $question)
                                    @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                @endforeach
                                @if($advancedQuestions->isNotEmpty())
                                    <div class="advanced-fields" data-advanced-fields="{{ $key }}">
                                        @foreach($advancedQuestions as $question)
                                            @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @if($advancedQuestions->isNotEmpty())
                                <button type="button" class="expand-questions" data-expand-questions="{{ $key }}" aria-expanded="false">＋ Add more {{ strtolower($group['title']) }} details ({{ $advancedQuestions->count() }})</button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="stage-footer">
                    <button type="button" class="back-btn" id="details-previous">← Back</button>
                    <button type="button" class="btn" id="details-next">Next section →</button>
                </div>
            </section>

            <section class="editor-stage" data-stage="publish" aria-labelledby="publish-stage-title">
                <div class="stage-top">
                    <span class="stage-kicker">Step 03 / 03 · Almost there</span>
                    <h2 id="publish-stage-title">It's ready to share.</h2>
                    <p>Review your invitation, compare free and premium features, then publish your free website. No payment required.</p>
                </div>
                <div class="stage-scroll">
                    <div class="custom-link-panel">
                        <label for="invitation-slug" class="custom-link-label">Your personalized invitation link</label>
                        <p>Choose a short, memorable address. This will be the link guests use to visit your wedding website and scan your QR code.</p>
                        <div class="custom-link-field">
                            <span class="url-prefix">{{ parse_url(config('app.url'), PHP_URL_HOST) ?: 'wewantyouthere.com' }}/i/</span>
                            <input id="invitation-slug" name="slug" type="text" inputmode="url" autocapitalize="none" spellcheck="false"
                                autocomplete="off" minlength="3" maxlength="72" pattern="[a-z0-9]+(-[a-z0-9]+)*"
                                value="{{ old('slug', $draft['slug'] ?? '') }}"
                                placeholder="andrea-and-miguel" required
                                aria-describedby="slug-availability" data-availability-url="{{ route('wedding.slugAvailability') }}"
                                data-invitation-base="{{ rtrim(config('app.url'), '/') }}/i/">
                        </div>
                        <div class="slug-feedback" id="slug-availability" role="status" aria-live="polite">
                            Use lowercase letters, numbers and hyphens only.
                        </div>
                        @error('slug')<div class="field-error" role="alert">{{ $message }}</div>@enderror
                        <div class="full-url-preview">Full address: <span id="full-invitation-url"></span></div>
                        <div class="full-url-preview qr-note">A downloadable QR code will be generated automatically once your invitation is published.</div>
                    </div>
                    <h3 style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#9f353c;margin:0 0 12px">Your invitation includes</h3>
                    <ul class="review-list" id="review-sections" aria-label="Selected sections"></ul>
                    <div class="plan-grid">
                        <div class="plan-card">
                            <span class="pill">Available now</span>
                            <h3>Free invitation</h3>
                            <div class="plan-price">₱0</div>
                            <ul>
                                <li>Shareable website link</li>
                                <li>Wedding details & entourage</li>
                                <li>Venue & event program</li>
                                <li>Mobile-friendly invitation</li>
                                <li>We Want You There branding</li>
                            </ul>
                        </div>
                        <div class="plan-card premium">
                            <span class="pill">Coming soon</span>
                            <h3>Premium invitation</h3>
                            <div class="plan-price">Pricing later</div>
                            <ul>
                                <li>QR and guest-specific links</li>
                                <li>Maps and enhanced directions</li>
                                <li>RSVP dashboard & email alerts</li>
                                <li>Excel exports and extra editing</li>
                                <li>Paper, animated & video output</li>
                            </ul>
                        </div>
                    </div>
                    <div class="launch-note"><strong>No checkout yet.</strong> The premium features above are planned, not available for purchase. The button below publishes the free website only. If you aren't signed in, we'll ask you to create an account first.</div>
                </div>
                <div class="stage-footer">
                    <button type="button" class="back-btn" id="publish-back">← Edit details</button>
                    <button type="submit" class="btn" id="publish-free">Publish free invitation →</button>
                </div>
            </section>
        </div>

        <aside class="preview-pane" aria-label="Live invitation preview">
            <div class="preview-top">
                <div><strong>Live invitation preview</strong><small>Watch your edits appear instantly</small></div>
                <div class="preview-switch" role="tablist" aria-label="Invitation format preview">
                    <button type="button" role="tab" aria-selected="true" data-preview-format="website">Website</button>
                    <button type="button" role="tab" aria-selected="false" data-preview-format="paper">Paper ◇</button>
                    <button type="button" role="tab" aria-selected="false" data-preview-format="animated">Animated / Video ◇</button>
                </div>
            </div>
            <div class="preview-scroll" id="preview-scroll">
                <div id="preview-website">
                    <div class="preview-comparison" id="preview-comparison">
                        <div class="compare-block"><span class="small-badge">FREE WEBSITE</span><strong class="comparison-name">Amelia & Gabriel</strong><span>Essentials and your chosen sections</span></div>
                        <div class="compare-block premium"><span class="small-badge">PREMIUM CONCEPT</span><strong class="comparison-name">Amelia & Gabriel</strong><span>Advanced RSVP, extra formats and more (soon)</span></div>
                    </div>
                    <div class="preview-canvas">
                        @include('weddings.partials.invitation', ['answers' => $draft['answers'] ?? [], 'sections' => $currentSectionSelection, 'questions' => $questions, 'isPreview' => true])
                    </div>
                </div>
                <div id="preview-paper" hidden>
                    <div class="preview-locked"><div><span class="icon">✉</span><h3>Printed invitations</h3><p>Print-ready paper invitations are a planned premium format. Editing and exports will be added in a later phase.</p><span class="pill">Coming soon</span></div></div>
                </div>
                <div id="preview-animated" hidden>
                    <div class="preview-locked"><div><span class="icon">✧</span><h3>Animated & video invitations</h3><p>Photo animations and personalized video invitations are planned premium formats, not yet available to export.</p><span class="pill">Coming soon</span></div></div>
                </div>
            </div>
            <div class="preview-bottom">
                <span><span class="preview-dot" aria-hidden="true"></span><span id="preview-caption">Live preview · Changes saved on this browser</span></span>
                <span>Ever After · Classic Ivory</span>
            </div>
        </aside>
    </form>
</div>
@endsection

@push('scripts')
@include('weddings.partials.editor-script')
@endpush
