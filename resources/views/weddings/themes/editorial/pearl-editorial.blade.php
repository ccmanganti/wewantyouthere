{{-- PEARL ATELIER: high-contrast black-and-white fashion editorial, magazine spreads and velvet reveal. --}}
<header class="pa-hero ce2-section" id="pa-cover" data-preview-section="couple">
    <nav class="pa-nav"><span>ARE ONE</span><span>THE WEDDING ISSUE · VOL. 01</span><a href="#pa-rsvp">REPLY ↗</a></nav>
    <div class="pa-hero-type"><span>OUR WEDDING DAY</span>
        <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><i>&amp;</i><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
        <p class="pa-script" data-field="cover_tagline">{{ $copy('cover_tagline','An extraordinary kind of love.') }}</p>
    </div>
    <div class="pa-hero-art">
        @include('weddings.themes.editorial.photo', ['slot'=>'hero','class'=>'pa-hero-photo','eager'=>true])
        <div class="pa-pearl-thread" aria-hidden="true"></div>
        <div class="pa-hero-label"><span>LIMITED EDITION</span><span data-field="event_date">{{ $display('event_date','December 12, 2027') }}</span></div>
    </div>
    <div class="pa-hero-footer"><span>THE BEGINNING OF FOREVER</span><a href="#pa-letter">DISCOVER THE STORY ↓</a><span data-field="venue_name">{{ $copy('venue_name','The Grand Estate') }}</span></div>
</header>

<section class="pa-letter ce2-section" id="pa-letter" data-preview-section="couple">
    <span class="pa-issue">I / THE INVITATION</span>
    <div class="pa-letter-head"><h2 data-field="welcome_heading">{{ $copy('welcome_heading','Dearest friends,') }}</h2><p class="pa-hand">You're invited.</p></div>
    <div class="pa-letter-grid"><div><p data-field="host_message">{{ $copy('host_message',"We are overjoyed to invite you to celebrate a new beginning with us. Your presence is what makes it special.") }}</p><p class="pa-letter-caption">A LOVE LETTER, WITH ALL OUR HEARTS</p></div>
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_one','class'=>'pa-letter-photo'])</div>
</section>

<section class="pa-spread ce2-section" id="pa-story" data-preview-section="couple">
    <div class="pa-spread-copy"><span class="pa-issue">II / THE EDITORIAL</span><h2 data-field="story_heading">{{ $copy('story_heading','A love worth remembering.') }}</h2>
        <blockquote data-field="hero_quote">{{ $copy('hero_quote','It was always you.') }}</blockquote>
        <p data-field="couple_story">{{ $copy('couple_story',"In between the ordinary days, we found our extraordinary story.") }}</p>
        <span class="pa-spread-number">01 — 02</span>
    </div>
    <div class="pa-spread-images">
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_two','class'=>'pa-spread-shot pa-spread-shot-first'])
        @include('weddings.themes.editorial.photo', ['slot'=>'editorial_portrait','class'=>'pa-spread-shot pa-spread-shot-second'])
    </div>
</section>

<section class="pa-date ce2-section" id="pa-date" data-preview-section="ceremony">
    <div class="pa-date-heading"><span class="pa-issue">III / THE DATE</span><h2>Mark this<br><i>moment.</i></h2></div>
    <div class="pa-date-issue"><span>THE DATE</span><strong data-field="event_date">{{ $display('event_date','December 12, 2027') }}</strong><p data-field="date_caption">{{ $copy('date_caption','A day that belongs to us.') }}</p>
        <span class="pa-date-divider"></span><span>THE CEREMONY</span><strong data-field="event_time">{{ $display('event_time','3:00 PM') }}</strong>
        <div class="pa-mini-calendar" data-ce2-calendar></div>
    </div>
</section>

<section class="pa-venue ce2-section" id="pa-venue" data-preview-section="ceremony">
    <div class="pa-venue-top"><span class="pa-issue">IV / THE LOCATION</span><h2>Save the place.</h2></div>
    <div class="pa-venue-layout">
        @include('weddings.themes.editorial.photo', ['slot'=>'venue_ceremony','class'=>'pa-venue-photo'])
        <div class="pa-venue-places"><div><span>01 / THE CEREMONY</span><h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Grand Chapel') }}</h3><p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful place to exchange vows') }}</p></div>
            <div data-preview-section="reception" @if(!$visible('reception')) hidden @endif><span>02 / THE RECEPTION</span><h3 data-field="reception_venue">{{ $copy('reception_venue','The Grand Estate') }}</h3><p data-field="reception_address">{{ $copy('reception_address','Dinner and dancing') }}</p><p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p></div>
        </div>
    </div>
</section>

@if($premiumAccess && ($visible('ceremony_details') || $isPreview))
<section class="pa-ceremony ce2-section" id="pa-ceremony" data-preview-section="ceremony" data-premium-section="ceremony_details" @if(!$visible('ceremony_details')) hidden @endif>
    <span class="pa-issue">A PERSONAL NOTE</span><h2 data-field="ceremony_type">{{ $copy('ceremony_type','The ceremony') }}</h2><p data-field="ceremony_notes">{{ $copy('ceremony_notes','A beautiful note for a special moment.') }}</p>
</section>
@endif
@include('weddings.themes.editorial.maps', ['mapClass'=>'pa-maps'])

@if($premiumAccess && ($visible('program') || $isPreview))
<section class="pa-program ce2-section" id="pa-program" data-preview-section="program" data-premium-section="program" @if(!$visible('program')) hidden @endif>
    <div class="pa-program-photo">
        @include('weddings.themes.editorial.photo', ['slot'=>'story_one','class'=>'pa-program-image'])
        <span class="pa-program-side">THE MOST WONDERFUL DAY</span>
    </div>
    <div class="pa-program-copy"><span class="pa-issue">V / THE PROGRAM</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','Program of the day') }}</h2>
        <div class="pa-program-table">
            @foreach([['guest_arrival_time','2:00 PM','guest_arrival_note','Guest arrival'],['event_time','3:00 PM','ceremony_timeline_note','The ceremony'],['reception_time','6:00 PM','reception_timeline_note','Dinner and celebration'],['celebration_time','9:00 PM','celebration_timeline_note','Last dance']] as [$time,$fallbackTime,$note,$fallbackNote])
            <div><strong data-field="{{ $time }}">{{ $display($time,$fallbackTime) }}</strong><span data-field="{{ $note }}">{{ $copy($note,$fallbackNote) }}</span></div>
            @endforeach
        </div>
        <p class="pa-program-extra" data-field="event_schedule">{{ $copy('event_schedule','') }}</p>
    </div>
</section>
@endif

@if($premiumAccess && ($visible('entourage') || $isPreview))
<section class="pa-people ce2-section" id="pa-people" data-preview-section="entourage" data-premium-section="entourage" @if(!$visible('entourage')) hidden @endif>
    <span class="pa-issue">VI / THE PEOPLE</span><h2 data-field="entourage_heading">{{ $copy('entourage_heading','Our inner circle.') }}</h2>
    <div class="pa-people-columns"><div><h3>Principal sponsors</h3><p data-field="principal_sponsors">{{ $copy('principal_sponsors','Our honored ninongs and ninangs') }}</p></div><div><h3>Bridesmaids</h3><p data-field="bridesmaids">{{ $copy('bridesmaids','The best women') }}</p></div><div><h3>Groomsmen</h3><p data-field="groomsmen">{{ $copy('groomsmen','The best men') }}</p></div></div>
</section>
@endif

<section class="pa-gallery ce2-section" id="pa-gallery" data-preview-section="couple">
    <span class="pa-issue">VII / THE ARCHIVE</span><h2 data-field="gallery_heading">{{ $copy('gallery_heading','An intimate collection.') }}</h2>
    <div class="pa-gallery-grid">
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_one','class'=>'pa-gallery-photo pa-gallery-first'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_two','class'=>'pa-gallery-photo pa-gallery-second'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_three','class'=>'pa-gallery-photo pa-gallery-third'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_four','class'=>'pa-gallery-photo pa-gallery-fourth'])
    </div>
    <p data-field="gallery_quote">{{ $copy('gallery_quote','The moments we never want to forget.') }}</p>
</section>

@if($visible('details') || $isPreview)
<section class="pa-attire ce2-section" id="pa-attire" data-preview-section="details" @if(!$visible('details')) hidden @endif>
    <div class="pa-attire-title"><span class="pa-issue">VIII / THE DETAILS</span><h2 data-field="dress_heading">{{ $copy('dress_heading','Dress beautifully.') }}</h2></div>
    <div class="pa-attire-info"><p data-field="dress_code">{{ $copy('dress_code','Formal evening attire') }}</p><p data-field="color_motif">{{ $copy('color_motif','Pearl, black, emerald and champagne') }}</p>
        <div class="pa-swatches" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
        <h3>Our wishes</h3><p data-field="gift_message">{{ $copy('gift_message','Your presence is everything to us.') }}</p>
        @if($validExternal('gift_registry_url'))<a href="{{ $validExternal('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">VIEW REGISTRY ↗</a>@endif</div>
</section>
@endif

@if($premiumAccess && ($visible('guests') || $isPreview))
<section class="pa-rsvp ce2-section" id="pa-rsvp" data-preview-section="guests" data-premium-section="guests" @if(!$visible('guests')) hidden @endif>
    <div class="pa-rsvp-black"><span>IX / KINDLY REPLY</span><h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','You are invited.') }}</h2><p data-field="rsvp_message">{{ $copy('rsvp_message','The next chapter would not be the same without you.') }}</p></div>
    <div class="pa-rsvp-white">@include('weddings.themes.editorial.rsvp', ['formClass'=>'pa-rsvp-form','submitLabel'=>'CONFIRM ATTENDANCE'])</div>
</section>
@endif

<footer class="pa-footer ce2-section"><span>THE END OF THIS ISSUE · THE BEGINNING OF US</span><h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> / <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2>
    <p data-field="closing_message">{{ $copy('closing_message','Always, together.') }}</p><a href="#pa-cover">BACK TO THE COVER ↑</a></footer>

{{-- A cinema-editorial opening: velvet curtains pull away to reveal a monochrome portrait. --}}
<div class="pa-intro ce2-intro" id="ce2-intro" @if($isPreview) hidden @endif>
    <button type="button" class="pa-curtain-trigger" data-ce2-open aria-label="Reveal our wedding invitation">
        <span class="pa-intro-photo" style="background-image:url('{{ $decoration('cinema') }}')" aria-hidden="true"></span>
        <span class="pa-intro-copy"><small>THE WEDDING ISSUE</small><strong>{{ $copy('bride_name','Amelia') }} &amp; {{ $copy('groom_name','Gabriel') }}</strong><em>AN EDITORIAL ROMANCE</em><span>REVEAL OUR INVITATION</span></span>
        <span class="pa-curtain pa-curtain-left" aria-hidden="true"></span><span class="pa-curtain pa-curtain-right" aria-hidden="true"></span>
        <span class="pa-intro-pearl" aria-hidden="true">◉</span>
    </button>
</div>
