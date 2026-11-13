{{-- BOTANICAL JOURNAL: a tactile scrapbook with turning pages, pressed flowers, taped photos and torn-edge notes. --}}
<nav class="og-nav"><a href="#og-cover">THE BOTANICAL JOURNAL <span>✿</span></a><details><summary>EXPLORE +</summary><div><a href="#og-calendar">The date</a><a href="#og-venue">The venues</a><a href="#og-look">Dress code</a><a href="#og-rsvp">RSVP</a></div></details></nav>
<header class="og-cover ce2-section" id="og-cover" data-preview-section="couple">
    <div class="og-leaf-spread" aria-hidden="true" style="background-image:url('{{ $decoration('botanical') }}')"></div>
    <div class="og-cover-left">
        <div class="og-paper-label"><span>THE ART OF GROWING TOGETHER</span><strong>OUR WEDDING JOURNAL</strong><span>VOL. 01 — FOREVER</span></div>
        @include('weddings.themes.editorial.photo', ['slot'=>'hero','class'=>'og-cover-photo','eager'=>true])
        <div class="og-photo-tape" aria-hidden="true"></div>
    </div>
    <div class="og-cover-right">
        <div class="og-flower-mark" aria-hidden="true">✿</div>
        <p class="og-overline">A CELEBRATION AMONG THE FLOWERS</p>
        <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><em>&amp;</em><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
        <p class="og-date" data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
        <p class="og-location" data-field="venue_name">{{ $copy('venue_name','The Garden Estate') }}</p>
        <a href="#og-note">TURN THE PAGE <span aria-hidden="true">↘</span></a>
    </div>
</header>

<section class="og-welcome ce2-section" id="og-note" data-preview-section="couple">
    <div class="og-notebook">
        <span class="og-tab">01 / A NEW CHAPTER</span>
        <div class="og-pressed" aria-hidden="true" style="background-image:url('{{ $decoration('pressed') }}')"></div>
        <div class="og-hand-note"><h2 data-field="welcome_heading">{{ $copy('welcome_heading','Dear favorite people,') }}</h2>
            <p data-field="host_message">{{ $copy('host_message',"We're celebrating the beautiful season of life that has brought us here. We hope you'll be there.") }}</p>
            <p class="og-signature">With love, always.</p>
        </div>
        <div class="og-memory-row">
            @include('weddings.themes.editorial.photo', ['slot'=>'portrait_one','class'=>'og-memory og-memory-a','caption'=>$copy('editorial_caption_one','The first little moment')])
            @include('weddings.themes.editorial.photo', ['slot'=>'portrait_two','class'=>'og-memory og-memory-b','caption'=>$copy('editorial_caption_two','The happiest adventure')])
        </div>
    </div>
</section>

<section class="og-story ce2-section" id="og-story" data-preview-section="couple">
    <span class="og-overline">GROWING TOGETHER</span>
    <div class="og-story-layout">
        @include('weddings.themes.editorial.photo', ['slot'=>'story_one','class'=>'og-story-photo'])
        <div class="og-story-copy"><h2 data-field="story_heading">{{ $copy('story_heading','Our favorite chapter') }}</h2>
            <p data-field="couple_story">{{ $copy('couple_story','Somewhere between everyday adventures and shared dreams, we found our forever.') }}</p>
            <p class="og-handwritten" data-field="hero_quote">{{ $copy('hero_quote','To grow, together.') }}</p></div>
    </div>
</section>

<section class="og-calendar ce2-section" id="og-calendar" data-preview-section="ceremony">
    <div class="og-calendar-left"><span class="og-tab">02 / SAVE OUR DATE</span>
        <h2>Mark your calendar</h2><p data-field="date_caption">{{ $copy('date_caption','A day for love to bloom.') }}</p>
        <p class="og-calendar-date" data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
        <p data-field="event_time">{{ $display('event_time','3:00 PM') }}</p>
    </div>
    <div class="og-calendar-right"><div class="og-calendar-illustration" aria-hidden="true" style="background-image:url('{{ $decoration('botanical') }}')"></div>
        <div class="og-mini-calendar" data-ce2-calendar></div>
    </div>
</section>

<section class="og-venue ce2-section" id="og-venue" data-preview-section="ceremony">
    <div class="og-venue-note"><span class="og-tab">03 / THE GARDEN PATH</span>
        <h2>Where to find us</h2>
        <p class="og-field-label">CEREMONY</p><h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Garden Chapel') }}</h3><p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful place beneath the trees') }}</p>
        <p class="og-field-label">CELEBRATION</p><h3 data-field="reception_venue">{{ $copy('reception_venue','The Garden Estate') }}</h3><p data-field="reception_address">{{ $copy('reception_address','Join us for an evening of joy') }}</p><p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p>
    </div>
    <div class="og-venue-stack">
        @include('weddings.themes.editorial.photo', ['slot'=>'venue_ceremony','class'=>'og-venue-photo og-venue-photo-a','caption'=>'01 · THE CEREMONY'])
        @include('weddings.themes.editorial.photo', ['slot'=>'venue_reception','class'=>'og-venue-photo og-venue-photo-b','caption'=>'02 · THE RECEPTION'])
    </div>
</section>

@if($premiumAccess && ($visible('ceremony_details') || $isPreview))
<section class="og-ceremony-notes ce2-section" data-preview-section="ceremony" data-premium-section="ceremony_details" @if(!$visible('ceremony_details')) hidden @endif>
    <span class="og-tab">THE CEREMONY</span><h2 data-field="ceremony_type">{{ $copy('ceremony_type','Our vows') }}</h2><p data-field="ceremony_notes">{{ $copy('ceremony_notes','A special note for the day.') }}</p>
</section>
@endif
@include('weddings.themes.editorial.maps', ['mapClass'=>'og-maps'])

@if($premiumAccess && ($visible('program') || $isPreview))
<section class="og-timeline ce2-section" id="og-program" data-preview-section="program" data-premium-section="program" @if(!$visible('program')) hidden @endif>
    <span class="og-tab">04 / THE CELEBRATION</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','A day in bloom') }}</h2>
    <div class="og-timeline-list">
        @foreach([['guest_arrival_time','2:00 PM','guest_arrival_note','Welcome garden cocktails'],['event_time','3:00 PM','ceremony_timeline_note','Promises beneath the trees'],['reception_time','6:00 PM','reception_timeline_note','Dinner, stories and laughter'],['celebration_time','9:00 PM','celebration_timeline_note','Dancing under the stars']] as [$time,$fallbackTime,$note,$fallbackNote])
        <div><span class="og-bloom-dot" aria-hidden="true">✿</span><strong data-field="{{ $time }}">{{ $display($time,$fallbackTime) }}</strong><p data-field="{{ $note }}">{{ $copy($note,$fallbackNote) }}</p></div>
        @endforeach
    </div>
    <p class="og-program-notes" data-field="event_schedule">{{ $copy('event_schedule','') }}</p>
</section>
@endif

@if($premiumAccess && ($visible('entourage') || $isPreview))
<section class="og-people ce2-section" id="og-people" data-preview-section="entourage" data-premium-section="entourage" @if(!$visible('entourage')) hidden @endif>
    <span class="og-tab">05 / OUR PEOPLE</span><h2 data-field="entourage_heading">{{ $copy('entourage_heading','The hands that helped us grow') }}</h2>
    <div class="og-people-grid"><div><span>PRINCIPAL SPONSORS</span><p data-field="principal_sponsors">{{ $copy('principal_sponsors','Our honored ninongs and ninangs') }}</p></div>
    <div><span>BRIDESMAIDS</span><p data-field="bridesmaids">{{ $copy('bridesmaids','The loveliest friends') }}</p></div>
    <div><span>GROOMSMEN</span><p data-field="groomsmen">{{ $copy('groomsmen','The finest friends') }}</p></div></div>
</section>
@endif

<section class="og-album ce2-section" id="og-photos" data-preview-section="couple"><span class="og-tab">06 / OUR MEMORIES</span>
    <h2 data-field="gallery_heading">{{ $copy('gallery_heading','Little moments, great love') }}</h2>
    <div class="og-scrapbook-grid">
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_one','class'=>'og-scrapbook-photo og-scrapbook-photo-a'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_two','class'=>'og-scrapbook-photo og-scrapbook-photo-b'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_three','class'=>'og-scrapbook-photo og-scrapbook-photo-c'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_four','class'=>'og-scrapbook-photo og-scrapbook-photo-d'])
    </div>
    <p class="og-handwritten" data-field="gallery_quote">{{ $copy('gallery_quote','All of our beautiful seasons led us here.') }}</p>
</section>

@if($visible('details') || $isPreview)
<section class="og-attire ce2-section" id="og-look" data-preview-section="details" @if(!$visible('details')) hidden @endif><span class="og-tab">07 / THE LITTLE DETAILS</span>
    <div class="og-attire-card"><div class="og-attire-bow" aria-hidden="true"></div><h2 data-field="dress_heading">{{ $copy('dress_heading','What to wear') }}</h2>
        <p data-field="dress_code">{{ $copy('dress_code','Garden formal') }}</p>
        <p data-field="color_motif">{{ $copy('color_motif','Sage, burgundy, olive and cream') }}</p>
        <div class="og-palette" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
        <h3>With gratitude</h3><p data-field="gift_message">{{ $copy('gift_message','The greatest gift is celebrating with you.') }}</p>
        @if($validExternal('gift_registry_url'))<a href="{{ $validExternal('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">Wedding registry ↗</a>@endif
    </div>
</section>
@endif

@if($premiumAccess && ($visible('guests') || $isPreview))
<section class="og-rsvp ce2-section" id="og-rsvp" data-preview-section="guests" data-premium-section="guests" @if(!$visible('guests')) hidden @endif>
    <div class="og-rsvp-notebook"><span class="og-tab">08 / A LITTLE REPLY</span><h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','Will you join our garden party?') }}</h2>
        <p data-field="rsvp_message">{{ $copy('rsvp_message','Kindly let us know if we should save you a place.') }}</p>
        @include('weddings.themes.editorial.rsvp', ['formClass'=>'og-rsvp-form','submitLabel'=>'Save my seat'])
    </div>
</section>
@endif

<footer class="og-footer ce2-section"><span>THE END OF THIS PAGE · THE START OF FOREVER</span>
    <h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> <em>&amp;</em> <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2>
    <p data-field="closing_message">{{ $copy('closing_message','And the best is yet to come.') }}</p><a href="#og-cover">BACK TO THE FIRST PAGE ↑</a>
</footer>

{{-- The guest must OPEN THE BOOK. A page-turn replaces any envelope intro. --}}
<div class="og-intro ce2-intro" id="ce2-intro" @if($isPreview) hidden @endif>
    <div class="og-book-shadow"><button type="button" class="og-book-trigger" data-ce2-open aria-label="Open the wedding journal">
        <span class="og-book-back"></span><span class="og-book-pages"></span>
        <span class="og-book-cover"><span>THE BOTANICAL JOURNAL</span><strong>{{ $copy('bride_name','Amelia') }} <i>&amp;</i> {{ $copy('groom_name','Gabriel') }}</strong><small>OUR WEDDING STORY · VOL. I</small><span class="og-book-flower" aria-hidden="true">✿</span></span>
        <span class="og-book-first-page"><span>YOU ARE INVITED</span><strong>{{ $date->format('F j, Y') }}</strong></span>
    </button></div>
</div>
