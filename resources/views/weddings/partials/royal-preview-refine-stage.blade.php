<section class="editor-stage" data-stage="refine" aria-labelledby="refine-stage-title">
    <div class="stage-top">
        <span class="stage-kicker">Step 03 / 05 · The finishing touches</span>
        <h2 id="refine-stage-title">See how your story unfolds.</h2>
        <p>Explore your invitation as a guest would. Choose a section to jump to it, then return to Details to change its wording.</p>
    </div>
    <div class="stage-scroll rb-refine-scroll">
        <div class="rb-refine-tip">
            <i class="fa-solid fa-eye" aria-hidden="true"></i>
            <div>
                <strong>You're looking at the actual invitation website.</strong>
                <span>Try the navigation, scroll through the sections, and review your ceremony, sponsors, program and RSVP details before adding photos.</span>
            </div>
        </div>
        <div class="rb-refine-headline">EXPLORE YOUR SECTIONS</div>
        <div class="rb-refine-grid">
            @foreach([
                ['wedding-home', 'Opening cover', 'fa-envelope-open-text'],
                ['wedding-ceremony', 'Ceremony', 'fa-church'],
                ['wedding-date', 'Wedding date', 'fa-calendar-days'],
                ['wedding-program', 'Timing & program', 'fa-clock'],
                ['wedding-reception', 'Venues', 'fa-location-dot'],
                ['wedding-details', 'Dress code & details', 'fa-user-tie'],
                ['wedding-story', 'Our story', 'fa-heart'],
                ['wedding-entourage', 'Family & entourage', 'fa-people-group'],
                ['wedding-guests', 'Guests & RSVP', 'fa-envelope-open-text'],
            ] as [$target, $label, $icon])
                <button type="button" class="rb-refine-jump" data-refine-section="{{ $target }}">
                    <i class="fa-solid {{ $icon }}" aria-hidden="true"></i>
                    <span>{{ $label }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </button>
            @endforeach
        </div>
        <div class="rb-refine-feature">
            <div class="rb-refine-feature-copy">
                <span class="rb-refine-headline">GUEST FIRST IMPRESSION</span>
                <h3>Open it like a real invitation.</h3>
                <p>Preview the beautiful burgundy envelope opening, complete with paper textures and a wax seal. The published invitation begins with a closed envelope; guests click Open Invitation to reveal the page.</p>
                <button type="button" class="rb-refine-replay" id="preview-envelope-intro">
                    <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i> Preview envelope
                </button>
            </div>
            <img src="{{ asset('wedding/royal-burgundy/envelope-front.webp') }}"
                 alt="" width="230" height="170" loading="lazy">
        </div>
        <div class="rb-refine-note">
            <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
            <span>Ready for images? Your cover, photo sections and venue placements are all handled in the next step. You can publish without photos and add them later.</span>
        </div>
    </div>
    <div class="stage-footer">
        <button type="button" class="back-btn" id="refine-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Edit details</button>
        <button type="button" class="btn" id="refine-next">Next: add images <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </div>
</section>
