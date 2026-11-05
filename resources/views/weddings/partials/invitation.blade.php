@php
    $isPreview = $isPreview ?? false;
    $answers = $answers ?? [];
    $sections = $sections ?? [];

    $display = function (string $key, string $fallback = '') use ($answers, $isPreview): string {
        $value = $answers[$key] ?? '';
        if (is_array($value)) $value = implode(', ', $value);
        $value = trim((string) $value);

        if ($value === '') return $isPreview ? $fallback : '';

        if (in_array($key, ['event_date', 'rsvp_deadline'], true) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            try { return \Carbon\Carbon::createFromFormat('!Y-m-d', $value)->format('F j, Y'); }
            catch (\Throwable $e) { return $value; }
        }

        if (in_array($key, ['event_time', 'reception_time', 'guest_arrival_time', 'celebration_time', 'after_party_time', 'first_dance_time'], true) && preg_match('/^\d{2}:\d{2}$/', $value)) {
            try { return \Carbon\Carbon::createFromFormat('!H:i', $value)->format('g:i A'); }
            catch (\Throwable $e) { return $value; }
        }

        return $value;
    };
@endphp
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
    @include('weddings.themes.royal-burgundy')
@else
<div class="wedding-invite" id="wedding-invite">
    <nav class="invite-site-nav" aria-label="Wedding website sections">
        <a href="#wedding-home" class="invite-logo">
            <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name', 'Amelia') }}</span>
            <span class="invite-logo-and"> & </span>
            <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name', 'Gabriel') }}</span>
        </a>
        <div class="invite-site-links">
            <a href="#wedding-ceremony">When & where</a>
            <a href="#wedding-reception" data-nav-section="reception" @if(!($sections['reception'] ?? true)) hidden @endif>Reception</a>
            <a href="#wedding-entourage" data-nav-section="entourage" @if(!($sections['entourage'] ?? true)) hidden @endif>Entourage</a>
            <a href="#wedding-program" data-nav-section="program" @if(!($sections['program'] ?? true)) hidden @endif>Program</a>
            <a href="#wedding-guests" data-nav-section="guests" @if(!($sections['guests'] ?? true)) hidden @endif>Guests</a>
            <a href="#wedding-details" data-nav-section="details" @if(!($sections['details'] ?? true)) hidden @endif>Details</a>
        </div>
    </nav>

    <section class="invite-cover" id="wedding-home" data-preview-section="couple">
        <div class="invite-hero-flourish invite-hero-flourish-left" aria-hidden="true">❦</div>
        <div class="invite-hero-flourish invite-hero-flourish-right" aria-hidden="true">❦</div>
        <div class="invite-hero-content">
            <span class="invite-eyebrow">WITH LOVE AND JOY</span>
            <div class="invite-divider"></div>
            <p class="invite-small">TOGETHER WITH OUR FAMILIES, WE INVITE YOU TO CELEBRATE</p>
            <h1 class="invite-couple-names">
                <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name', 'Amelia') }}</span>
                <i>&</i>
                <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name', 'Gabriel') }}</span>
            </h1>
            <p class="invite-message" data-field="host_message" data-fallback="The beginning of our forever. Join us for a celebration of love, family, and the memories we'll make together.">{{ $display('host_message', "The beginning of our forever. Join us for a celebration of love, family, and the memories we'll make together.") }}</p>
            <div class="invite-divider"></div>
            <p class="invite-date" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date', 'December 12, 2027') }}</p>
            <p class="invite-location" data-field="venue_name" data-fallback="THE GLASS GARDEN">{{ $display('venue_name', 'THE GLASS GARDEN') }}</p>
            <a class="invite-scroll-link" href="#wedding-ceremony">Explore our wedding <span aria-hidden="true">↓</span></a>
            <div class="invite-hero-extra">
                @include('weddings.partials.extras', ['group' => 'couple'])
            </div>
        </div>
    </section>

    <section class="invite-section invite-ceremony" id="wedding-ceremony" data-preview-section="ceremony">
        <div class="invite-section-inner">
            <div class="invite-section-heading">
                <span class="invite-eyebrow">THE BEGINNING OF FOREVER</span>
                <h2>Our wedding day</h2>
                <p>We would be delighted to celebrate this special moment with you.</p>
            </div>
            <div class="invite-content-column">
                <div class="invite-detail-item">
                    <span class="invite-detail-number">01 / THE DATE</span>
                    <p class="invite-featured" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date', 'December 12, 2027') }}</p>
                    <p class="invite-small" data-field="event_time" data-fallback="03:00 PM">{{ $display('event_time', '03:00 PM') }}</p>
                </div>
                <div class="invite-detail-item">
                    <span class="invite-detail-number">02 / THE CEREMONY</span>
                    <p class="invite-featured" data-field="ceremony_venue" data-fallback="A beautiful place to say I do">{{ $display('ceremony_venue', 'A beautiful place to say I do') }}</p>
                    <p class="invite-muted pre-line" data-field="ceremony_address" data-fallback="Our ceremony venue">{{ $display('ceremony_address', 'Our ceremony venue') }}</p>
                </div>
                <div class="invite-more-details">
                    @include('weddings.partials.extras', ['group' => 'ceremony'])
                </div>
            </div>
        </div>
    </section>

    <section class="invite-section invite-reception invite-tinted" id="wedding-reception" data-preview-section="reception" @if(!($sections['reception'] ?? true)) hidden @endif>
        <div class="invite-section-inner">
            <div class="invite-section-heading">
                <span class="invite-eyebrow">THEN, LET'S CELEBRATE</span>
                <h2>The reception</h2>
                <p>Come for the love, stay for the laughter, and celebrate with us.</p>
            </div>
            <div class="invite-content-column">
                <div class="invite-detail-item">
                    <span class="invite-detail-number">THE CELEBRATION</span>
                    <p class="invite-featured" data-field="reception_venue" data-fallback="The Glass Garden">{{ $display('reception_venue', 'The Glass Garden') }}</p>
                    <p class="invite-muted pre-line" data-field="reception_address" data-fallback="An evening to remember">{{ $display('reception_address', 'An evening to remember') }}</p>
                    <p class="invite-small" data-field="reception_time" data-fallback="06:00 PM">{{ $display('reception_time', '06:00 PM') }}</p>
                </div>
                <div class="invite-more-details">
                    @include('weddings.partials.extras', ['group' => 'reception'])
                </div>
            </div>
        </div>
    </section>

    <section class="invite-section invite-entourage" id="wedding-entourage" data-preview-section="entourage" @if(!($sections['entourage'] ?? true)) hidden @endif>
        <div class="invite-centered-section">
            <span class="invite-eyebrow">THE PEOPLE BY OUR SIDE</span>
            <h2>Our entourage</h2>
            <p class="invite-section-lead">For the wonderful people sharing in the joy of our special day.</p>
            <div class="invite-two-cols">
                <div>
                    <h3>Principal Sponsors</h3>
                    <p class="pre-line" data-field="principal_sponsors" data-fallback="Our beloved Ninongs & Ninangs">{{ $display('principal_sponsors', 'Our beloved Ninongs & Ninangs') }}</p>
                </div>
                <div>
                    <h3>Best Man & Maid of Honor</h3>
                    <p data-field="best_man" data-fallback="Best Man">{{ $display('best_man', 'Best Man') }}</p>
                    <p data-field="maid_of_honor" data-fallback="Maid of Honor">{{ $display('maid_of_honor', 'Maid of Honor') }}</p>
                </div>
                <div>
                    <h3>Groomsmen</h3>
                    <p class="pre-line" data-field="groomsmen" data-fallback="Our closest friends">{{ $display('groomsmen', 'Our closest friends') }}</p>
                </div>
                <div>
                    <h3>Bridesmaids</h3>
                    <p class="pre-line" data-field="bridesmaids" data-fallback="Our dearest friends">{{ $display('bridesmaids', 'Our dearest friends') }}</p>
                </div>
            </div>
            <div class="invite-more-details">
                @include('weddings.partials.extras', ['group' => 'entourage'])
            </div>
        </div>
    </section>

    <section class="invite-section invite-program invite-tinted" id="wedding-program" data-preview-section="program" @if(!($sections['program'] ?? true)) hidden @endif>
        <div class="invite-centered-section">
            <span class="invite-eyebrow">A DAY TO REMEMBER</span>
            <h2>Our celebration</h2>
            <p class="invite-section-lead">A few special moments to look forward to.</p>
            <div class="invite-program-line">
                <p class="pre-line" data-field="event_schedule" data-fallback="2:00 PM — Guest arrival&#10;3:00 PM — Wedding ceremony&#10;6:00 PM — Dinner & celebration">{{ $display('event_schedule', '2:00 PM — Guest arrival'."\n".'3:00 PM — Wedding ceremony'."\n".'6:00 PM — Dinner & celebration') }}</p>
            </div>
            <div class="invite-more-details">
                @include('weddings.partials.extras', ['group' => 'program'])
            </div>
        </div>
    </section>

    <section class="invite-section invite-guests" id="wedding-guests" data-preview-section="guests" @if(!($sections['guests'] ?? true)) hidden @endif>
        <div class="invite-centered-section">
            <span class="invite-eyebrow">WE WANT YOU THERE</span>
            <h2>Be our guest</h2>
            <p class="invite-section-lead" data-field="rsvp_message" data-fallback="We hope you can join us to make this day even more special.">{{ $display('rsvp_message', 'We hope you can join us to make this day even more special.') }}</p>
            <div class="invite-guest-note">
                <span>Kindly let us know by</span>
                <strong data-field="rsvp_deadline" data-fallback="our RSVP deadline">{{ $display('rsvp_deadline', 'our RSVP deadline') }}</strong>
            </div>
            <p class="invite-muted">Online RSVP collection is an upcoming feature. Please contact the couple directly for now.</p>
            <div class="invite-more-details">
                @include('weddings.partials.extras', ['group' => 'guests'])
            </div>
        </div>
    </section>

    <section class="invite-section invite-details invite-tinted" id="wedding-details" data-preview-section="details" @if(!($sections['details'] ?? true)) hidden @endif>
        <div class="invite-centered-section">
            <span class="invite-eyebrow">THE LITTLE DETAILS</span>
            <h2>Before the big day</h2>
            <p class="invite-section-lead">Here is everything you might need to know.</p>
            <div class="invite-two-cols">
                <div>
                    <h3>Dress code</h3>
                    <p data-field="dress_code" data-fallback="Formal garden attire">{{ $display('dress_code', 'Formal garden attire') }}</p>
                </div>
                <div>
                    <h3>Color motif</h3>
                    <p data-field="color_motif" data-fallback="Sage, ivory & champagne">{{ $display('color_motif', 'Sage, ivory & champagne') }}</p>
                </div>
            </div>
            <div class="invite-gift-note">
                <h3>With love and gratitude</h3>
                <p class="pre-line" data-field="gift_message" data-fallback="Your presence is the greatest gift of all.">{{ $display('gift_message', 'Your presence is the greatest gift of all.') }}</p>
            </div>
            <div class="invite-more-details">
                @include('weddings.partials.extras', ['group' => 'details'])
            </div>
        </div>
    </section>

    @include('weddings.partials.premium-video')
    <footer class="invite-footer">
        <span class="invite-eyebrow">THANK YOU FOR BEING PART OF OUR STORY</span>
        <p class="invite-footer-names">
            <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name', 'Amelia') }}</span>
            <i>&</i>
            <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name', 'Gabriel') }}</span>
        </p>
        <small>WITH LOVE, ALWAYS</small>
        <a href="#wedding-home" class="invite-top-link">↑ Back to the top</a>
    </footer>
</div>
@endif
