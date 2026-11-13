{{-- DESTINATION TICKET: a continuous travel document, airport departures board and passport-stamped itinerary. --}}
<nav class="dt-nav"><a href="#dt-pass">WWYT AIRLINES <span>✈</span></a><span>FLIGHT TO FOREVER / 001</span><a href="#dt-rsvp">CHECK IN ↗</a></nav>
<header class="dt-pass ce2-section" id="dt-pass" data-preview-section="couple">
    <div class="dt-departures"><div><span>DEPARTURES</span><strong>LOVE</strong><small>STATUS: ON TIME</small></div><div><span>DESTINATION</span><strong>FOREVER</strong><small>GATE: TOGETHER</small></div></div>
    <div class="dt-passport">
        <div class="dt-ticket-head"><span>WEDDING BOARDING PASS</span><span>FIRST CLASS · 001</span></div>
        <div class="dt-route-icon" aria-hidden="true">✈ <span>— — —</span> ♥</div>
        <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><em>and</em><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
        <div class="dt-ticket-details"><div><small>FLIGHT DATE</small><strong data-field="event_date">{{ $display('event_date','December 12, 2027') }}</strong></div><div><small>DEPARTURE TIME</small><strong data-field="event_time">{{ $display('event_time','3:00 PM') }}</strong></div><div><small>DESTINATION</small><strong data-field="venue_name">{{ $copy('venue_name','The Lake House') }}</strong></div></div>
        <div class="dt-ticket-tear"><span>PLEASE KEEP THIS TICKET</span><span>✈ 001 — ONE LOVE</span></div>
    </div>
    <div class="dt-hero-photo-wrap">
        @include('weddings.themes.editorial.photo', ['slot'=>'hero','class'=>'dt-hero-photo','eager'=>true])
        <div class="dt-photo-badge">LOVE IS THE DESTINATION</div>
    </div>
    <a class="dt-next" href="#dt-journey">BEGIN THE JOURNEY ↓</a>
</header>

<section class="dt-journey ce2-section" id="dt-journey" data-preview-section="couple">
    <div class="dt-section-number">01 / WELCOME ABOARD</div><div class="dt-journey-title"><h2 data-field="welcome_heading">{{ $copy('welcome_heading','Our greatest adventure begins.') }}</h2>
        <p data-field="host_message">{{ $copy('host_message',"Pack your joy and join us as we embark on the most meaningful journey of our lives. We would love to have you with us.") }}</p></div>
    <div class="dt-boarding-stamps"><span>ARRIVAL</span><span>LOVE LETTER</span><span>FOREVER</span></div>
    <div class="dt-journey-photos">
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_one','class'=>'dt-memory-photo dt-memory-a'])
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_two','class'=>'dt-memory-photo dt-memory-b'])
    </div>
    <div class="dt-story-note"><span>OUR TRAVEL DIARY</span><h3 data-field="story_heading">{{ $copy('story_heading','Every road led to us.') }}</h3><p data-field="couple_story">{{ $copy('couple_story','From the first hello to every beautiful adventure, we knew we were on the right path.') }}</p></div>
</section>

<section class="dt-map-day ce2-section" id="dt-date" data-preview-section="ceremony">
    <div class="dt-map-graphic" style="background-image:url('{{ $decoration('destination') }}')" aria-hidden="true"></div>
    <div class="dt-date-pass"><span class="dt-section-number">02 / YOUR TRAVEL DETAILS</span><h2>Save the date</h2>
        <strong data-field="event_date">{{ $display('event_date','December 12, 2027') }}</strong>
        <p data-field="date_caption">{{ $copy('date_caption','This is the adventure of a lifetime.') }}</p>
        <div class="dt-calendar" data-ce2-calendar></div>
        <div class="dt-date-route"><div><small>ARRIVE BY</small><p data-field="event_time">{{ $display('event_time','3:00 PM') }}</p></div><div><small>FLIGHT STATUS</small><p>BOARDING SOON</p></div></div>
    </div>
</section>

<section class="dt-destination ce2-section" id="dt-venue" data-preview-section="ceremony">
    <span class="dt-section-number">03 / DESTINATION DETAILS</span><h2>The place we'll say “I do”</h2>
    <div class="dt-destination-card">
        @include('weddings.themes.editorial.photo', ['slot'=>'venue_ceremony','class'=>'dt-venue-photo'])
        <div><span>01 · CEREMONY STOP</span><h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Lake Chapel') }}</h3><p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful destination for our vows') }}</p></div>
    </div>
    <div class="dt-destination-card dt-destination-reverse">
        @include('weddings.themes.editorial.photo', ['slot'=>'venue_reception','class'=>'dt-venue-photo'])
        <div><span>02 · RECEPTION STOP</span><h3 data-field="reception_venue">{{ $copy('reception_venue','The Lakeside Estate') }}</h3><p data-field="reception_address">{{ $copy('reception_address','Dinner and dancing by the water') }}</p><p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p></div>
    </div>
</section>

@if($premiumAccess && $visible('ceremony_details'))
<section class="dt-ceremony ce2-section" data-preview-section="ceremony" data-premium-section="ceremony_details"><span class="dt-section-number">TRAVEL ADVISORY</span>
    <h2 data-field="ceremony_type">{{ $copy('ceremony_type','Our ceremony') }}</h2><p data-field="ceremony_notes">{{ $copy('ceremony_notes','A note for our passengers.') }}</p>
</section>
@endif
@include('weddings.themes.editorial.maps', ['mapClass'=>'dt-maps'])

@if($premiumAccess && $visible('program'))
<section class="dt-itinerary ce2-section" id="dt-itinerary" data-preview-section="program" data-premium-section="program">
    <span class="dt-section-number">04 / THE FLIGHT ITINERARY</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','Our wedding itinerary') }}</h2>
    <div class="dt-flight-path">
        @foreach([['guest_arrival_time','2:00 PM','guest_arrival_note','Guest check-in'],['event_time','3:00 PM','ceremony_timeline_note','The wedding ceremony'],['reception_time','6:00 PM','reception_timeline_note','Dinner and celebration'],['celebration_time','9:00 PM','celebration_timeline_note','Late-night departures']] as [$time,$fallbackTime,$note,$fallbackNote])
        <div class="dt-flight-stop"><span class="dt-flight-dot" aria-hidden="true">✈</span><strong data-field="{{ $time }}">{{ $display($time,$fallbackTime) }}</strong><p data-field="{{ $note }}">{{ $copy($note,$fallbackNote) }}</p></div>
        @endforeach
    </div>
    <p class="dt-program-extra" data-field="event_schedule">{{ $copy('event_schedule','') }}</p>
</section>
@endif

@if($premiumAccess && $visible('entourage'))
<section class="dt-crew ce2-section" id="dt-crew" data-preview-section="entourage" data-premium-section="entourage">
    <span class="dt-section-number">05 / OUR MOST IMPORTANT CREW</span><h2 data-field="entourage_heading">{{ $copy('entourage_heading','Meet our favorite people') }}</h2>
    <div class="dt-crew-manifest"><div><span>VIP PASSENGERS</span><h3>Principal sponsors</h3><p data-field="principal_sponsors">{{ $copy('principal_sponsors','Our honored ninongs and ninangs') }}</p></div>
        <div><span>THE BRIDAL CREW</span><h3>Bridesmaids</h3><p data-field="bridesmaids">{{ $copy('bridesmaids','Our favorite ladies') }}</p></div>
        <div><span>THE GROOM CREW</span><h3>Groomsmen</h3><p data-field="groomsmen">{{ $copy('groomsmen','Our favorite gentlemen') }}</p></div></div>
</section>
@endif

<section class="dt-photo-diary ce2-section" id="dt-diary" data-preview-section="couple">
    <div class="dt-photo-diary-title"><span class="dt-section-number">06 / THE JOURNEY IN PICTURES</span><h2 data-field="gallery_heading">{{ $copy('gallery_heading','Our favorite postcards') }}</h2></div>
    <div class="dt-postcards">
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_one','class'=>'dt-postcard dt-postcard-1','caption'=>'POSTCARD 001'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_two','class'=>'dt-postcard dt-postcard-2','caption'=>'POSTCARD 002'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_three','class'=>'dt-postcard dt-postcard-3','caption'=>'POSTCARD 003'])
    </div><p data-field="gallery_quote">{{ $copy('gallery_quote','We have traveled so far just to find each other.') }}</p>
</section>

@if($visible('details'))
<section class="dt-dress ce2-section" id="dt-dress" data-preview-section="details">
    <div class="dt-dress-card"><span class="dt-section-number">07 / WHAT TO PACK</span><h2 data-field="dress_heading">{{ $copy('dress_heading','Dress code') }}</h2>
        <p data-field="dress_code">{{ $copy('dress_code','Elegant destination attire') }}</p><p data-field="color_motif">{{ $copy('color_motif','Ivory, sand, navy and slate') }}</p>
        <div class="dt-dress-colors" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
        <h3>A little note on gifts</h3><p data-field="gift_message">{{ $copy('gift_message','Your company is the best souvenir.') }}</p>
        @if($validExternal('gift_registry_url'))<a href="{{ $validExternal('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">VIEW THE REGISTRY ↗</a>@endif
    </div>
</section>
@endif

@if($premiumAccess && $visible('guests'))
<section class="dt-rsvp ce2-section" id="dt-rsvp" data-preview-section="guests" data-premium-section="guests">
    <div class="dt-rsvp-heading"><span>08 / FINAL CHECK-IN</span><h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','Ready for takeoff?') }}</h2>
        <p data-field="rsvp_message">{{ $copy('rsvp_message','Confirm your place on the most special flight of our lives.') }}</p></div>
    <div class="dt-rsvp-ticket"><div class="dt-rsvp-ticket-head"><span>BOARDING PASS / RSVP</span><span>FOREVER CLASS</span></div>
        @include('weddings.themes.editorial.rsvp', ['formClass'=>'dt-rsvp-form','submitLabel'=>'CONFIRM MY BOARDING PASS'])
        <div class="dt-rsvp-barcode" aria-hidden="true"></div></div>
</section>
@endif

<footer class="dt-footer ce2-section"><span>THANK YOU FOR BEING PART OF OUR JOURNEY</span><h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> ✈ <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2>
    <p data-field="closing_message">{{ $copy('closing_message','Our favorite journey begins with you there.') }}</p><a href="#dt-pass">RETURN TO DEPARTURES ↑</a></footer>

{{-- A boarding pass physically tears along the perforation on click. --}}
<div class="dt-intro ce2-intro" id="ce2-intro" @if($isPreview) hidden @endif>
    <button type="button" class="dt-boarding-trigger" data-ce2-open aria-label="Board our wedding invitation">
        <span class="dt-intro-header"><small>WE WANT YOU THERE · AIRLINES</small><strong>BOARDING PASS</strong><em>✈</em></span>
        <span class="dt-intro-body"><small>PASSENGERS</small><strong>{{ $copy('bride_name','Amelia') }} &amp; {{ $copy('groom_name','Gabriel') }}</strong><span>DESTINATION: FOREVER</span><small>DATE: {{ $date->format('d M Y') }}</small></span>
        <span class="dt-intro-stub"><span>FLIGHT 001</span><span class="dt-intro-code" aria-hidden="true"></span><strong>CLICK TO BOARD</strong></span>
    </button>
    <div class="dt-takeoff-trail" aria-hidden="true">✈</div>
</div>
