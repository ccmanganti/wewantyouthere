<section class="editor-stage" data-stage="refine" aria-labelledby="refine-stage-title">
    <div class="stage-top">
        <span class="stage-kicker">Step 03 / 05 · Fine-tune your invitation</span>
        <h2 id="refine-stage-title">Make it yours, down to the details.</h2>
        <p>Your essential details are already in place. Everything here is optional—click any part of the invitation to edit its wording.</p>
    </div>
    <div class="stage-scroll rb-refine-scroll">
        <div class="rb-refine-tip">
            <i class="fa-solid fa-hand-pointer" aria-hidden="true"></i>
            <div>
                <strong>Click text in the live preview to edit it.</strong>
                <span>Or open one of the categories below. Generate can suggest a quote or message from our collection. Unused optional details can be left empty.</span>
            </div>
        </div>
        <div class="rb-refine-headline">OPTIONAL PERSONALIZATION</div>
        <div class="fine-tune-categories" id="fine-tune-categories">
            @foreach($groups as $key => $group)
                @php
                    $coreKeys = config('wedding_editor_basics.'.$key, []);
                    $legacy = ['bride_full_name','groom_full_name','bride_parents','groom_parents'];
                    $extras = $group['questions']->filter(fn ($question) =>
                        !in_array($question->key, $coreKeys, true) && !in_array($question->key, $legacy, true));
                @endphp
                @if($extras->isNotEmpty())
                <details class="fine-tune-category" data-fine-tune-group="{{ $key }}">
                    <summary data-fine-tune-trigger="{{ $key }}">
                        <span class="fine-tune-category-title">{{ $group['title'] }}</span>
                        <span class="fine-tune-category-count">{{ $extras->count() }} optional items</span>
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </summary>
                    <p class="fine-tune-category-description">Customize only what matters to you; the example wording can be kept as-is.</p>
                    <div class="question-grid fine-tune-question-grid">
                        @foreach($extras as $question)
                            @include('weddings.partials.editor-question', ['question' => $question, 'draft' => $draft])
                        @endforeach
                    </div>
                </details>
                @endif
            @endforeach
        </div>
        <details class="rb-refine-explore">
            <summary><i class="fa-solid fa-location-crosshairs" aria-hidden="true"></i> Jump to a part of your preview</summary>
            <div class="rb-refine-grid">
                @foreach([
                    ['cover', 'Opening cover', 'fa-envelope-open-text'],
                    ['location-details', 'Ceremony and reception', 'fa-location-dot'],
                    ['the-timeline', 'Event program', 'fa-clock'],
                    ['our-story', 'Our story', 'fa-heart'],
                    ['our-people', 'Family and entourage', 'fa-people-group'],
                    ['rsvp', 'Guests and RSVP', 'fa-envelope-open-text'],
                ] as [$target, $label, $icon])
                    <button type="button" class="rb-refine-jump" data-refine-section="{{ $target }}">
                        <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                        <span>{{ $label }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    </button>
                @endforeach
            </div>
        </details>
        <div class="rb-refine-feature">
            <div class="rb-refine-feature-copy">
                <span class="rb-refine-headline">GUEST FIRST IMPRESSION</span>
                <h3>See how guests will open it.</h3>
                <p>The published invitation begins with a closed, floating envelope. Your guests click the envelope to open the wedding website.</p>
                <button type="button" class="rb-refine-replay" id="preview-envelope-intro">
                    <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i> Preview envelope
                </button>
            </div>
            <img src="{{ asset('wedding/royal-burgundy/envelope-front.webp') }}"
                 alt="" width="230" height="170" loading="lazy">
        </div>
    </div>
    <div class="stage-footer">
        <button type="button" class="back-btn" id="refine-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Basic details</button>
        <button type="button" class="btn" id="refine-next">Next: your photos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</section>
