@extends('layouts.wwyt')
@section('body_class', 'builder-page')
@section('robots', 'noindex,nofollow')
@section('title', 'Build Your Wedding Invitation | We Want You There')
@section('meta_description', 'Create your wedding website step by step. Choose the sections, enter wedding details and see every change in the live preview.')

@push('styles')
@include('weddings.partials.editor-styles')
@include('weddings.partials.invitation-theme-styles')
@if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.themes.royal-v3-styles')
@else
@include('weddings.themes.curated-editorial-styles')
@endif
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
        'program' => false,
        'guests' => false, 'video' => false, 'details' => true,
    ];
    $currentSectionSelection = [];
    foreach ($groups as $key => $group) {
        $currentSectionSelection[$key] = !($group['hideable'] ?? false)
            || ($draft['sections'][$key] ?? $defaultSelections[$key] ?? false);
        if (!$hasPremium && in_array($key, ['entourage','program','guests','video'], true)) {
            $currentSectionSelection[$key] = false;
        }
    }
    $premiumAccess = $hasPremium;
    $currentSectionSelection['maps'] = $hasPremium && ($draft['sections']['maps'] ?? false);
    $currentSectionSelection['ceremony_details'] = $hasPremium && ($draft['sections']['ceremony_details'] ?? false);
@endphp
<div class="builder-app" id="wedding-builder" data-template="{{ $template->slug }}" data-has-premium="{{ $hasPremium ? '1' : '0' }}" data-upgrade-url="{{ route('premium.show', $template->slug) }}" data-mobile-view="edit" data-photos-enabled="{{ in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true) ? '1' : '0' }}" data-photo-upload-url="{{ route('wedding.photos.upload', $template->slug) }}" data-generate-url="{{ route('wedding.messages.generate', $template->slug) }}">
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
            @if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
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
                <span class="step-dot">{{ in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true) ? 5 : 3 }}</span> <span class="wizard-step-label">Review & publish</span>
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

    <dialog id="premium-unlock-dialog" class="premium-unlock-dialog" aria-labelledby="premium-modal-title">
      <button type="button" class="premium-modal-close" data-premium-close aria-label="Close upgrade dialog"><i class="fa-solid fa-xmark"></i></button>
      <div class="premium-dialog-icon"><i class="fa-solid fa-gem"></i></div>
      <span class="premium-dialog-overline">OPTIONAL PREMIUM UPGRADE</span>
      <h2 id="premium-modal-title">Make your invitation even more personal.</h2>
      <p id="premium-modal-description">Unlock premium features for {{ $template->name }}. Your free invitation remains available.</p>
      <div class="premium-dialog-price">{{ \App\Support\InvitationPremium::price($template) }} <small>one-time payment</small></div>
      @auth
        <a class="premium-dialog-main" href="{{ route('premium.show', $template->slug) }}">View upgrade and purchase <i class="fa-solid fa-arrow-right"></i></a>
      @else
        <a class="premium-dialog-main" href="{{ url('/app/login') }}">Log in to purchase <i class="fa-solid fa-arrow-right"></i></a>
        <a class="premium-dialog-alt" href="{{ url('/app/register') }}">Create your free account</a>
      @endauth
      <button type="button" class="premium-dialog-skip" data-premium-close>Continue using the free editor</button>
    </dialog>

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
                    <span class="stage-kicker">Step {{ in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true) ? '01 / 05' : '01 / 03' }} · Make it personal</span>
                    <h1 id="section-stage-title">What would you like to include?</h1>
                    <p>Choose what goes into your invitation.</p>
                    <div class="preview-link-tip"><i class="fa-solid fa-crosshairs" aria-hidden="true"></i> Select a section to find it in the preview.</div>
                </div>
                <div class="stage-scroll">
                    <div class="selector-intro">
                        <span class="selector-icon" aria-hidden="true"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></span>
                        <div><strong>Start with the essentials.</strong><p>Premium extras are optional.</p></div>
                    </div>
                    <div class="section-choice-grid">
                        @foreach($groups as $key => $group)
                            @php
                                $fixed = !($group['hideable'] ?? false);
                                $premiumFeature = ['entourage'=>'entourage','program'=>'program','guests'=>'rsvp','video'=>'video'][$key] ?? null;
                                $premiumLocked = $premiumFeature && !$hasPremium;
                                $selected = $currentSectionSelection[$key];
                                $sectionInfo = [
                                    'couple' => ['01', 'Your names, parents and love story'],
                                    'ceremony' => ['02', 'Wedding date, ceremony details and location'],
                                    'reception' => ['03', 'Reception, directions and accommodation'],
                                    'entourage' => ['04', 'Sponsors, ninong, ninang and wedding party'],
                                    'program' => ['05', 'Timeline, activities and reception program'],
                                    'guests' => ['06', 'Guest policies, RSVP information and contacts'],
                                    'details' => ['07', 'Dress code, gift preferences and FAQs'],
                                    'video' => ['08', 'Your prenup, wedding teaser or video message'],
                                ];
                                [$number, $description] = $sectionInfo[$key] ?? ['✦', $group['description']];
                            @endphp
                            <label class="section-choice {{ $premiumLocked ? 'premium-locked-card' : '' }}" data-choice-card="{{ $key }}" data-required="{{ $fixed ? 'true' : 'false' }}" @if($premiumLocked) data-locked-feature="{{ $premiumFeature }}" tabindex="0" role="button" @endif>
                                <span class="choice-top">
                                    <span class="choice-icon" aria-hidden="true">{{ $number }}</span>
                                    @if($fixed)
                                        <input type="checkbox" checked disabled aria-label="{{ $group['title'] }} is always included">
                                    @elseif($premiumLocked)
                                        <input type="checkbox" data-section-toggle="{{ $key }}" disabled aria-label="{{ $group['title'] }} requires premium">
                                    @else
                                        <input type="checkbox" data-section-toggle="{{ $key }}" {{ $selected ? 'checked' : '' }} aria-label="Include {{ $group['title'] }}">
                                    @endif
                                </span>
                                <strong>{{ $group['title'] }}</strong>
                                <small>{{ $description }}</small>
                                @if($fixed)<span class="always">Always included</span>@endif
                                @if($premiumFeature)
                                    <span class="premium-feature-tag"><i class="fa-solid {{ $premiumLocked ? 'fa-lock' : 'fa-gem' }}" aria-hidden="true"></i> {{ $premiumLocked ? 'Premium · Unlock' : 'Premium included' }}</span>
                                @endif
                                <input type="hidden" data-section-input="{{ $key }}" name="sections[{{ $key }}]" value="{{ $selected ? '1' : '0' }}">
                            </label>
                        @endforeach
                        @foreach(['maps','ceremony_details'] as $featureKey)
                            @php
                                $feature = \App\Support\InvitationPremium::FEATURES[$featureKey === 'ceremony_details' ? 'ceremony' : 'maps'];
                                $locked = !$hasPremium;
                            @endphp
                            <label class="section-choice {{ $locked ? 'premium-locked-card' : '' }}" data-choice-card="{{ $featureKey }}" @if($locked) data-locked-feature="{{ $featureKey === 'ceremony_details' ? 'ceremony' : 'maps' }}" role="button" tabindex="0" @endif>
                                <span class="choice-top"><span class="choice-icon"><i class="fa-solid {{ $feature['icon'] }}"></i></span>
                                    <input type="checkbox" data-section-toggle="{{ $featureKey }}" {{ $locked ? 'disabled' : '' }}
                                        @checked($currentSectionSelection[$featureKey]) aria-label="Include {{ $feature['name'] }}">
                                </span>
                                <strong>{{ $feature['name'] }}</strong>
                                <small>{{ $feature['detail'] }}</small>
                                <span class="premium-feature-tag"><i class="fa-solid {{ $locked ? 'fa-lock' : 'fa-gem' }}"></i> {{ $locked ? 'Premium · Unlock' : 'Premium included' }}</span>
                                <input type="hidden" data-section-input="{{ $featureKey }}" name="premium_options[{{ $featureKey }}]" value="{{ $currentSectionSelection[$featureKey] ? '1' : '0' }}">
                            </label>
                        @endforeach
                    </div>
                    @unless($hasPremium)
                        <p class="premium-selector-note">Unlock optional extras anytime.</p>
                    @endunless
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
                    <div class="preview-link-tip"><i class="fa-solid fa-hand-pointer" aria-hidden="true"></i> Click preview text to edit it.</div>
                </div>
                <div class="group-tabs" id="group-tabs" aria-label="Question sections">
                    @foreach($groups as $key => $group)
                        <button type="button" class="group-tab" data-group-tab="{{ $key }}">{{ $group['title'] }}</button>
                    @endforeach
                </div>
                <div class="stage-scroll detail-scroll" id="detail-scroll">
                    @foreach($groups as $key => $group)
                        @php
                            $isRoyalBuilder = in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true);
                            $coreKeys = $isRoyalBuilder
                                ? config('wedding_editor_basics.'.$key, [])
                                : $group['questions']->pluck('key')->all();
                            $parentKeys = ['bride_mother','bride_father','groom_mother','groom_father'];
                            // Same ordering engine powers all invitation event types.
                            $coreQuestions = \App\Support\InvitationFormLayout::orderedQuestions(
                                $group['questions']
                                    ->filter(fn ($question) => in_array($question->key, $coreKeys, true) && (!$isRoyalBuilder || !in_array($question->key, $parentKeys, true)))
                                    ->values(),
                                $template->eventType->slug,
                            );
                            $parentQuestions = $isRoyalBuilder && $key === 'couple'
                                ? $group['questions']->filter(fn ($question) => in_array($question->key, $parentKeys, true))
                                    ->sortBy(fn ($question) => array_search($question->key, $parentKeys))->values()
                                : collect();
                        @endphp
                        <div class="question-group" data-question-group="{{ $key }}" data-group-description="{{ $group['description'] }}">
                            @if($key === 'couple')
                                <p class="basic-intro">Start with your names and message.</p>
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

            @if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
                @include('weddings.partials.royal-preview-refine-stage')
                @include('weddings.partials.photo-builder-stage')
            @endif

            <section class="editor-stage" data-stage="publish" aria-labelledby="publish-stage-title">
                <div class="stage-top">
                    <span class="stage-kicker">Step {{ in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true) ? '05 / 05' : '03 / 03' }} · Final review</span>
                    <h2 id="publish-stage-title">Review before you share.</h2>
                    <p>Check your details and preview before publishing.</p>
                </div>
                <div class="stage-scroll">
                    <div class="custom-link-panel">
                        <label for="invitation-slug" class="custom-link-label">Your personalized invitation link</label>
                        <p>This is the link you'll share with guests.</p>
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
                        <div class="full-url-preview qr-note">Your QR code is created when you publish.</div>
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
                            @if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
                                <button type="button" class="review-edit-link" data-review-edit="refine">Fine-tune wording</button>
                            @endif
                        </div>
                        <div id="review-messages" class="review-message-list"></div>
                    </div>
                    <div class="final-review-preview">
                        <strong>Review the full wedding website</strong>
                        <p>Inspect your invitation before sharing.</p>
                        <button type="button" class="review-preview-button" id="review-open-preview">
                            <i class="fa-solid fa-expand" aria-hidden="true"></i> Open full preview
                        </button>
                    </div>
                    <h3 style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:#9f353c;margin:17px 0 12px">Sections you selected</h3>
                    <ul class="review-list" id="review-sections" aria-label="Selected sections"></ul>

                    <p class="publish-free-note"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Free publishing requires no payment. <a href="{{ route('premium.show', $template->slug) }}" target="_blank" rel="noopener">Optional upgrade</a></p>
                </div>
                <div class="stage-footer">
                    <button type="button" class="back-btn" id="publish-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to photos</button>
                    <button type="submit" class="btn" id="publish-free">Publish free invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </section>
        </div>

        <aside class="preview-pane" aria-label="Live invitation preview">
            <div class="preview-top">
                <div><strong>Live preview</strong></div>
                <button type="button" class="preview-expand-btn" id="preview-expand"
                    aria-pressed="false" title="Use the full workspace to inspect the invitation">
                    <i class="fa-solid fa-expand" aria-hidden="true"></i>
                    <span>Expand</span>
                </button>
            </div>
            <div class="preview-highlight-help" id="preview-highlight-help" role="status" aria-live="polite">
                <i class="fa-solid fa-crosshairs" aria-hidden="true"></i>
                <span id="preview-highlight-status">Click invitation text to edit.</span>
            </div>
            <div class="preview-scroll" id="preview-scroll">
                <div id="preview-website">
                    <div class="preview-canvas">
                        @include('weddings.partials.invitation', ['answers' => $draft['answers'] ?? [], 'sections' => $currentSectionSelection, 'questions' => $questions, 'isPreview' => true, 'template' => $template, 'photoUrls' => $photoUrls ?? []])
                    </div>
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
@if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
@include('weddings.partials.photo-builder-script')
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.themes.royal-v3-script')
@else
@include('weddings.themes.curated-editorial-script')
@endif
@endif
@endpush
