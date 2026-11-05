@extends('layouts.wwyt')
@section('body_class', 'builder-page')
@section('robots', 'noindex,nofollow')
@section('title', 'Build Your Wedding Invitation | We Want You There')
@section('meta_description', 'Create your wedding website step by step. Choose the sections, enter wedding details and see every change in the live preview.')

@push('styles')
@include('weddings.partials.editor-styles')
@include('weddings.partials.invitation-theme-styles')
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.themes.royal-v3-styles')
@include('weddings.partials.photo-builder-styles')
@include('weddings.partials.royal-preview-refine-styles')
@endif
@include('weddings.partials.editor-uri-styles')
@endpush

@section('content')
@php
    $defaultSelections = [
        'couple' => true, 'ceremony' => true, 'reception' => true,
        'entourage' => false,
        'program' => (($template->settings['theme'] ?? '') === 'royal_burgundy'),
        'guests' => true, 'details' => true,
    ];
    $currentSectionSelection = [];
    foreach ($groups as $key => $group) {
        $currentSectionSelection[$key] = !($group['hideable'] ?? false)
            || ($draft['sections'][$key] ?? $defaultSelections[$key] ?? false);
    }
@endphp
<div class="builder-app" id="wedding-builder" data-template="{{ $template->slug }}" data-mobile-view="edit" data-photos-enabled="{{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? '1' : '0' }}" data-photo-upload-url="{{ route('wedding.photos.upload', $template->slug) }}" data-generate-url="{{ route('wedding.messages.generate', $template->slug) }}">
    {{-- The entire workspace uses ONE compact toolbar. The public topbar
         is hidden only on this route, freeing vertical room for both panes. --}}
    <header class="builder-utility" aria-label="Invitation builder toolbar">
        <div class="builder-identity">
            <a class="builder-brand" href="{{ route('home') }}" aria-label="We Want You There homepage">
                <img class="builder-brand-full" src="{{ asset('brand/wwyt/logo-white.png') }}"
                     alt="We Want You There" width="160" height="40">
                <img class="builder-brand-icon" src="{{ asset('brand/wwyt/favicon.png') }}"
                     alt="" width="36" height="36">
            </a>
            <span class="builder-toolbar-divider" aria-hidden="true"></span>
            <a class="builder-back" href="{{ route('marketing.templates') }}" title="Back to templates"
               aria-label="Back to templates"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
               <span>Templates</span></a>
            <div class="builder-title"><strong title="{{ $template->name }}">{{ $template->name }}</strong></div>
        </div>
        <nav class="wizard-strip" aria-label="Invitation creation steps">
            <button type="button" class="wizard-step is-current" data-step-navigation="sections" title="Choose sections" aria-label="Choose sections" aria-current="step">
                <span class="step-dot">1</span> <span class="wizard-step-label">Choose sections</span>
            </button>
            <span class="wizard-arrow" aria-hidden="true">›</span>
            <button type="button" class="wizard-step" data-step-navigation="details" title="Add your details" aria-label="Add your details" disabled>
                <span class="step-dot">2</span> <span class="wizard-step-label">Add your details</span>
            </button>
            @if(($template->settings['theme'] ?? '') === 'royal_burgundy')
            <span class="wizard-arrow" aria-hidden="true">›</span>
            <button type="button" class="wizard-step" data-step-navigation="refine" title="Fine-tune template" aria-label="Fine-tune template" disabled>
                <span class="step-dot">3</span> <span class="wizard-step-label">Fine-tune template</span>
            </button>
            <span class="wizard-arrow" aria-hidden="true">›</span>
            <button type="button" class="wizard-step" data-step-navigation="photos" title="Add your photos" aria-label="Add your photos" disabled>
                <span class="step-dot">4</span> <span class="wizard-step-label">Add your photos</span>
            </button>
            @endif
            <span class="wizard-arrow" aria-hidden="true">›</span>
            <button type="button" class="wizard-step" data-step-navigation="publish" title="Review and publish" aria-label="Review and publish" disabled>
                <span class="step-dot">{{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? 5 : 3 }}</span> <span class="wizard-step-label">Review & publish</span>
            </button>
        </nav>
        <div class="builder-utility-right">
            <div class="draft-indicator" id="draft-indicator" data-state="saving" role="status" aria-live="polite">Saving draft...</div>
            <div class="builder-mobile-switch" role="group" aria-label="Mobile workspace view">
                <button type="button" id="mobile-edit" aria-pressed="true">Edit</button>
                <button type="button" id="mobile-preview" aria-pressed="false">Preview</button>
            </div>
            <form id="cancel-builder-form" method="POST" action="{{ route('wedding.cancel', $template->slug) }}">@csrf
                <button class="cancel-btn" type="submit" id="cancel-builder" title="Cancel building">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i><span>Cancel building</span>
                </button>
            </form>
        </div>
    </header>

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
                    <span class="stage-kicker">Step {{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? '01 / 05' : '01 / 03' }} · Make it personal</span>
                    <h1 id="section-stage-title">What would you like to include?</h1>
                    <p>Select the sections that belong in your wedding invitation. You can change this later without losing what you've typed.</p>
                    <div class="preview-link-tip"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i> Select a section to highlight exactly where it appears in your live preview.</div>
                </div>
                <div class="stage-scroll">
                    <div class="selector-intro">
                        <span class="selector-icon" aria-hidden="true"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></span>
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
                    <button type="button" class="btn" id="sections-next">Continue to details <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </section>

            <section class="editor-stage" data-stage="details" aria-labelledby="detail-stage-title">
                <div class="group-headline">
                    <span class="group-count" id="group-counter">Your details</span>
                    <h2 id="detail-stage-title">The happy couple</h2>
                    <p id="group-subtitle">The essential details for this part of your celebration.</p>
                    <div class="preview-link-tip"><i class="fa-solid fa-hand-pointer" aria-hidden="true"></i> Click text in the preview to edit it here. Use <strong>Generate</strong> for optional message ideas.</div>
                </div>
                <div class="group-tabs" id="group-tabs" aria-label="Question sections">
                    @foreach($groups as $key => $group)
                        <button type="button" class="group-tab" data-group-tab="{{ $key }}">{{ $group['title'] }}</button>
                    @endforeach
                </div>
                <div class="stage-scroll detail-scroll" id="detail-scroll">
                    @foreach($groups as $key => $group)
                        @php
                            $isRoyalBuilder = ($template->settings['theme'] ?? '') === 'royal_burgundy';
                            $coreKeys = $isRoyalBuilder
                                ? config('wedding_editor_basics.'.$key, [])
                                : $group['questions']->pluck('key')->all();
                            $parentKeys = ['bride_mother','bride_father','groom_mother','groom_father'];
                            // Every wedding theme uses the same sensible visual
                            // grouping, regardless of its original question order.
                            // Unlisted template-specific questions follow in their
                            // existing order; no questions are added or discarded.
                            $layoutKeys = config('wedding_editor_layout.'.$key, []);
                            $coreQuestions = $group['questions']
                                ->filter(fn ($question) => in_array($question->key, $coreKeys, true) && (!$isRoyalBuilder || !in_array($question->key, $parentKeys, true)))
                                ->sortBy(function ($question) use ($layoutKeys, $coreKeys) {
                                    $priority = array_search($question->key, $layoutKeys, true);
                                    if ($priority !== false) return $priority;
                                    $originalPosition = array_search($question->key, $coreKeys, true);
                                    return count($layoutKeys) + ($originalPosition === false ? count($coreKeys) : $originalPosition);
                                })->values();
                            $parentQuestions = $isRoyalBuilder && $key === 'couple'
                                ? $group['questions']->filter(fn ($question) => in_array($question->key, $parentKeys, true))
                                    ->sortBy(fn ($question) => array_search($question->key, $parentKeys))->values()
                                : collect();
                        @endphp
                        <div class="question-group" data-question-group="{{ $key }}" data-group-description="{{ $group['description'] }}">
                            @if($key === 'couple')
                                <p class="basic-intro">Start with your names and invitation message. You can personalize the smaller details later.</p>
                            @endif
                            <div class="question-grid">
                                @foreach($coreQuestions as $question)
                                    @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                @endforeach
                                @if($parentQuestions->isNotEmpty())
                                <div class="family-option full">
                                    <label class="family-toggle">
                                        <input type="checkbox" id="include-parents" name="show_parents" value="1"
                                            @checked(old('show_parents', $draft['answers']['_show_parents'] ?? false))>
                                        <span><strong>Include parents' names</strong>
                                            <small>Optional. Turn off to omit parents from the invitation.</small></span>
                                    </label>
                                    <div class="family-fields" id="family-fields" hidden>
                                        <p class="family-fields-intro">Only names you provide will be shown. Leave any parent blank.</p>
                                        <div class="question-grid">
                                            @foreach($parentQuestions as $question)
                                                @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="stage-footer">
                    <button type="button" class="back-btn" id="details-previous"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</button>
                    <button type="button" class="btn" id="details-next">Next section <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </section>

            @if(($template->settings['theme'] ?? '') === 'royal_burgundy')
                @include('weddings.partials.royal-preview-refine-stage')
                @include('weddings.partials.photo-builder-stage')
            @endif

            <section class="editor-stage" data-stage="publish" aria-labelledby="publish-stage-title">
                <div class="stage-top">
                    <span class="stage-kicker">Step {{ ($template->settings['theme'] ?? '') === 'royal_burgundy' ? '05 / 05' : '03 / 03' }} · Final review</span>
                    <h2 id="publish-stage-title">Review before you share.</h2>
                    <p>Check the essentials, your personal messages and the full invitation preview before publishing.</p>
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
                    <div class="final-review-summary" aria-labelledby="final-review-essential-title">
                        <div class="final-review-heading">
                            <h3 id="final-review-essential-title">Wedding information</h3>
                            <button type="button" class="review-edit-link" data-review-edit="details">Edit basics</button>
                        </div>
                        <div class="final-review-grid" id="review-essentials"></div>
                    </div>
                    <div class="final-review-summary" aria-labelledby="final-review-messages-title">
                        <div class="final-review-heading">
                            <h3 id="final-review-messages-title">Messages and quotes</h3>
                            @if(($template->settings['theme'] ?? '') === 'royal_burgundy')
                                <button type="button" class="review-edit-link" data-review-edit="refine">Fine-tune wording</button>
                            @endif
                        </div>
                        <div id="review-messages" class="review-message-list"></div>
                    </div>
                    <div class="final-review-preview">
                        <strong>Review the full wedding website</strong>
                        <p>Scroll the live preview beside this checklist, or expand it for a closer look. Only sections you have selected will be published.</p>
                        <button type="button" class="review-preview-button" id="review-open-preview">
                            <i class="fa-solid fa-expand" aria-hidden="true"></i> Open full preview
                        </button>
                    </div>
                    <h3 style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#9f353c;margin:17px 0 12px">Sections you selected</h3>
                    <ul class="review-list" id="review-sections" aria-label="Selected sections"></ul>
                    <details class="review-plan-info">
                        <summary>What's included with the free website?</summary>
                        <div class="plan-grid">
                        <div class="plan-card">
                            <span class="pill">Available now</span>
                            <h3>Free invitation</h3>
                            <div class="plan-price">₱0</div>
                            <ul>
                                <li>Custom shareable website link</li>
                                <li>Downloadable invitation QR code</li>
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
                                <li>Guest-specific QR codes & personalized links</li>
                                <li>Maps and enhanced directions</li>
                                <li>RSVP dashboard & email alerts</li>
                                <li>Excel exports and extra editing</li>
                                <li>Paper, animated & video output</li>
                            </ul>
                        </div>
                    </div>
                    </details>
                    <div class="launch-note"><strong>No checkout yet.</strong> The premium features above are planned, not available for purchase. The button below publishes the free website only. If you aren't signed in, we'll ask you to create an account first.</div>
                </div>
                <div class="stage-footer">
                    <button type="button" class="back-btn" id="publish-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to photos</button>
                    <button type="submit" class="btn" id="publish-free">Publish free invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
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
                <button type="button" class="preview-expand-btn" id="preview-expand"
                    aria-pressed="false" title="Use the full workspace to inspect the invitation">
                    <i class="fa-solid fa-expand" aria-hidden="true"></i>
                    <span>Expand</span>
                </button>
            </div>
            <div class="preview-highlight-help" id="preview-highlight-help" role="status" aria-live="polite">
                <i class="fa-solid fa-crosshairs" aria-hidden="true"></i>
                <span id="preview-highlight-status">Click text in the invitation to edit it. Your preview stays where you left it.</span>
            </div>
            <div class="preview-scroll" id="preview-scroll">
                <div id="preview-website">
                    <div class="preview-comparison" id="preview-comparison">
                        <div class="compare-block"><span class="small-badge">FREE WEBSITE</span><strong class="comparison-name">Amelia & Gabriel</strong><span>Essentials and your chosen sections</span></div>
                        <div class="compare-block premium"><span class="small-badge">PREMIUM CONCEPT</span><strong class="comparison-name">Amelia & Gabriel</strong><span>Advanced RSVP, extra formats and more (soon)</span></div>
                    </div>
                    <div class="preview-canvas">
                        @include('weddings.partials.invitation', ['answers' => $draft['answers'] ?? [], 'sections' => $currentSectionSelection, 'questions' => $questions, 'isPreview' => true, 'template' => $template, 'photoUrls' => $photoUrls ?? []])
                    </div>
                </div>
                <div id="preview-paper" hidden>
                    <div class="preview-locked"><div><span class="icon" aria-hidden="true"><i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i></span><h3>Printed invitations</h3><p>Print-ready paper invitations are a planned premium format. Editing and exports will be added in a later phase.</p><span class="pill">Coming soon</span></div></div>
                </div>
                <div id="preview-animated" hidden>
                    <div class="preview-locked"><div><span class="icon" aria-hidden="true"><i class="fa-solid fa-film" aria-hidden="true"></i></span><h3>Animated & video invitations</h3><p>Photo animations and personalized video invitations are planned premium formats, not yet available to export.</p><span class="pill">Coming soon</span></div></div>
                </div>
            </div>
            <div class="preview-bottom">
                <span><span class="preview-dot" aria-hidden="true"></span><span id="preview-caption">Live preview · Changes saved on this browser</span></span>
                <span>{{ $template->name }}</span>
            </div>
        </aside>
    </form>
</div>
@endsection

@push('scripts')
@include('weddings.partials.editor-script')
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.partials.photo-builder-script')
@include('weddings.themes.royal-v3-script')
@endif
@endpush
