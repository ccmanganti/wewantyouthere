@php
    $isPreview = $isPreview ?? false;
    $answers = $answers ?? [];
    $sections = $sections ?? [];
    $display = function (string $key, string $fallback = '') use ($answers, $isPreview): string {
        $value = $answers[$key] ?? '';
        if (is_array($value)) $value = implode(', ', $value);
        return trim((string) $value) !== '' ? (string) $value : ($isPreview ? $fallback : '');
    };
@endphp
<div class="wedding-invite" id="wedding-invite">
    <section class="invite-cover" data-preview-section="couple">
        <div class="ornament ornament-top" aria-hidden="true">❧</div>
        <p class="invite-eyebrow">TOGETHER WITH OUR FAMILIES</p>
        <div class="invite-divider"></div>
        <p class="invite-small">THE WEDDING OF</p>
        <h1><span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span> <i>&</i> <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span></h1>
        <p class="invite-message" data-field="host_message" data-fallback="With joyful hearts, we invite you to celebrate the beginning of our forever.">{{ $display('host_message','With joyful hearts, we invite you to celebrate the beginning of our forever.') }}</p>
        <div class="invite-divider"></div>
        <p class="invite-date" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date','December 12, 2027') }}</p>
        <p class="invite-small" data-field="venue_name" data-fallback="THE GLASS GARDEN">{{ $display('venue_name','THE GLASS GARDEN') }}</p>
        @include('weddings.partials.extras', ['group' => 'couple'])
        <div class="ornament ornament-bottom" aria-hidden="true">❧</div>
    </section>
    <section class="invite-section" data-preview-section="ceremony">
        <p class="invite-eyebrow">THE BEGINNING OF FOREVER</p><h2>Our wedding day</h2>
        <p data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date','December 12, 2027') }}</p>
        <p class="invite-small" data-field="event_time" data-fallback="03:00 PM">{{ $display('event_time','03:00 PM') }}</p>
        <div class="invite-divider"></div>
        <h3>Ceremony</h3><p data-field="ceremony_venue" data-fallback="St. John the Baptist Church">{{ $display('ceremony_venue','St. John the Baptist Church') }}</p>
        <p class="subtle" data-field="ceremony_address" data-fallback="Our ceremony venue">{{ $display('ceremony_address','Our ceremony venue') }}</p>
        @include('weddings.partials.extras', ['group' => 'ceremony'])
    </section>
    <section class="invite-section invite-tinted" data-preview-section="reception" @if(!($sections['reception'] ?? true)) hidden @endif>
        <p class="invite-eyebrow">AFTER WE SAY I DO</p><h2>Celebrate with us</h2>
        <p data-field="reception_venue" data-fallback="The Glass Garden">{{ $display('reception_venue','The Glass Garden') }}</p>
        <p class="subtle" data-field="reception_address" data-fallback="An evening to remember">{{ $display('reception_address','An evening to remember') }}</p>
        <p class="invite-small" data-field="reception_time" data-fallback="06:00 PM">{{ $display('reception_time','06:00 PM') }}</p>
        @include('weddings.partials.extras', ['group' => 'reception'])
    </section>
    <section class="invite-section" data-preview-section="entourage" @if(!($sections['entourage'] ?? true)) hidden @endif>
        <p class="invite-eyebrow">OUR BELOVED FAMILY & FRIENDS</p><h2>Our entourage</h2>
        <div class="invite-two-cols">
            <div><h3>Principal sponsors</h3><p class="pre-line" data-field="principal_sponsors" data-fallback="Our Ninongs & Ninangs">{{ $display('principal_sponsors','Our Ninongs & Ninangs') }}</p></div>
            <div><h3>Best man & maid of honor</h3><p data-field="best_man" data-fallback="Best Man">{{ $display('best_man','Best Man') }}</p><p data-field="maid_of_honor" data-fallback="Maid of Honor">{{ $display('maid_of_honor','Maid of Honor') }}</p></div>
            <div><h3>Groomsmen</h3><p class="pre-line" data-field="groomsmen" data-fallback="Our closest friends">{{ $display('groomsmen','Our closest friends') }}</p></div>
            <div><h3>Bridesmaids</h3><p class="pre-line" data-field="bridesmaids" data-fallback="Our dearest friends">{{ $display('bridesmaids','Our dearest friends') }}</p></div>
        </div>
        @include('weddings.partials.extras', ['group' => 'entourage'])
    </section>
    <section class="invite-section invite-tinted" data-preview-section="program" @if(!($sections['program'] ?? true)) hidden @endif>
        <p class="invite-eyebrow">A DAY TO REMEMBER</p><h2>Our celebration</h2>
        <p class="pre-line" data-field="event_schedule" data-fallback="2:00 PM — Guest arrival&#10;3:00 PM — Wedding ceremony&#10;6:00 PM — Dinner & celebration">{{ $display('event_schedule','2:00 PM — Guest arrival'."\n".'3:00 PM — Wedding ceremony'."\n".'6:00 PM — Dinner & celebration') }}</p>
        @include('weddings.partials.extras', ['group' => 'program'])
    </section>
    <section class="invite-section" data-preview-section="guests" @if(!($sections['guests'] ?? true)) hidden @endif>
        <p class="invite-eyebrow">BE OUR GUEST</p><h2>Kindly RSVP</h2>
        <p data-field="rsvp_message" data-fallback="Your presence would mean the world to us.">{{ $display('rsvp_message','Your presence would mean the world to us.') }}</p>
        <p class="invite-small">Please respond by <span data-field="rsvp_deadline" data-fallback="our RSVP deadline">{{ $display('rsvp_deadline','our RSVP deadline') }}</span>.</p>
        <p class="subtle">Online RSVP collection is a premium feature coming soon.</p>
        @include('weddings.partials.extras', ['group' => 'guests'])
    </section>
    <section class="invite-section invite-tinted" data-preview-section="details" @if(!($sections['details'] ?? true)) hidden @endif>
        <p class="invite-eyebrow">A FEW LOVELY DETAILS</p><h2>Before the big day</h2>
        <h3>Dress code</h3><p data-field="dress_code" data-fallback="Formal garden attire">{{ $display('dress_code','Formal garden attire') }}</p>
        <h3>Wedding motif</h3><p data-field="color_motif" data-fallback="Sage, ivory & champagne">{{ $display('color_motif','Sage, ivory & champagne') }}</p>
        <h3>Gifts</h3><p class="pre-line" data-field="gift_message" data-fallback="Your presence is the greatest gift.">{{ $display('gift_message','Your presence is the greatest gift.') }}</p>
        @include('weddings.partials.extras', ['group' => 'details'])
    </section>
    <div class="invite-footer"><span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span> & <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span><small>WITH LOVE, ALWAYS</small></div>
</div>
