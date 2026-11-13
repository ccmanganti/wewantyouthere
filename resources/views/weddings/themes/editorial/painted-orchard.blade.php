{{-- SECRET GARDEN: cinematic landscape, arched conservatory panels, gate opening and floating floral compositions. --}}
<header class="po-hero ce2-section" id="po-garden" data-preview-section="couple" style="--po-forest:url('{{ $decoration('forest') }}')">
    <div class="po-forest-light" aria-hidden="true"></div>
    <nav class="po-nav"><span>THE SECRET GARDEN</span><a href="#po-rsvp">JOIN US <span>✧</span></a></nav>
    <div class="po-hero-arch"><div class="po-hero-flowers po-flowers-top" style="background-image:url('{{ $decoration('flowers') }}')" aria-hidden="true"></div>
        <span class="po-eyebrow">YOU ARE INVITED TO THE WEDDING OF</span>
        <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><i>&amp;</i><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
        <span class="po-leaf-symbol" aria-hidden="true">❀</span>
        <p data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
        <small data-field="venue_name">{{ $copy('venue_name','The Enchanted Gardens') }}</small>
        <div class="po-hero-flowers po-flowers-bottom" style="background-image:url('{{ $decoration('flowers') }}')" aria-hidden="true"></div>
    </div>
    <a class="po-hero-next" href="#po-welcome">FOLLOW THE GARDEN PATH <span aria-hidden="true">↓</span></a>
</header>

<section class="po-welcome ce2-section" id="po-welcome" data-preview-section="couple">
    <div class="po-floating-leaves" style="background-image:url('{{ $decoration('blooms') }}')" aria-hidden="true"></div>
    <div class="po-welcome-text"><span class="po-eyebrow">A BEAUTIFUL STORY UNFOLDS</span>
        <h2 data-field="welcome_heading">{{ $copy('welcome_heading','Welcome to our forever') }}</h2>
        <p data-field="host_message">{{ $copy('host_message','Beneath the trees and among our favorite people, our next chapter begins. We would love to celebrate with you.') }}</p></div>
    <div class="po-portrait-cluster">
        @include('weddings.themes.editorial.photo', ['slot'=>'hero','class'=>'po-portrait po-portrait-arch','eager'=>true])
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_one','class'=>'po-portrait po-portrait-small'])
    </div>
    <blockquote data-field="hero_quote">{{ $copy('hero_quote','The best things grow with time and love.') }}</blockquote>
</section>

<section class="po-story ce2-section" id="po-story" data-preview-section="couple">
    <div class="po-story-photo-panel" style="background-image:url('{{ $decoration('garden') }}')">
        @include('weddings.themes.editorial.photo', ['slot'=>'story_one','class'=>'po-story-photo'])
    </div>
    <div class="po-story-paper"><span class="po-eyebrow">OUR FAVORITE CHAPTER</span><h2 data-field="story_heading">{{ $copy('story_heading','The story of us') }}</h2>
        <p data-field="couple_story">{{ $copy('couple_story','Every winding road brought us to the same place: home, together.') }}</p>
        <span class="po-story-signature" aria-hidden="true">❦</span>
    </div>
</section>

<section class="po-date ce2-section" id="po-when" data-preview-section="ceremony">
    <div class="po-date-frame"><span class="po-eyebrow">THE DAY OUR FOREVER BEGINS</span>
        <div class="po-date-heart" aria-hidden="true">♥</div>
        <h2 data-field="event_date">{{ $display('event_date','December 12, 2027') }}</h2>
        <p data-field="date_caption">{{ $copy('date_caption','A special day to bloom forever.') }}</p>
        <div class="po-date-calendar" data-ce2-calendar></div>
        <p data-field="event_time">{{ $display('event_time','3:00 PM') }}</p>
    </div>
</section>

<section class="po-venue ce2-section" id="po-where" data-preview-section="ceremony">
    <div class="po-venue-heading"><span class="po-eyebrow">AMONG THE FLOWERS</span><h2>Where we'll say “I do”</h2></div>
    <div class="po-venue-columns">
        <article class="po-venue-card">
            @include('weddings.themes.editorial.photo', ['slot'=>'venue_ceremony','class'=>'po-venue-image'])
            <div class="po-venue-note"><span>THE CEREMONY</span><h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Garden Chapel') }}</h3>
                <p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful garden setting') }}</p></div>
        </article>
        <article class="po-venue-card" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
            @include('weddings.themes.editorial.photo', ['slot'=>'venue_reception','class'=>'po-venue-image'])
            <div class="po-venue-note"><span>THE CELEBRATION</span><h3 data-field="reception_venue">{{ $copy('reception_venue','The Glass Conservatory') }}</h3>
                <p data-field="reception_address">{{ $copy('reception_address','Dinner and dancing') }}</p>
                <p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p></div>
        </article>
    </div>
</section>

@if($premiumAccess && ($visible('ceremony_details') || $isPreview))
<section class="po-ceremony ce2-section" data-preview-section="ceremony" data-premium-section="ceremony_details" @if(!$visible('ceremony_details')) hidden @endif>
    <span class="po-eyebrow">BEFORE THE VOWS</span><h2 data-field="ceremony_type">{{ $copy('ceremony_type','A garden ceremony') }}</h2>
    <p data-field="ceremony_notes">{{ $copy('ceremony_notes','A little note for our wedding day.') }}</p>
</section>
@endif
@include('weddings.themes.editorial.maps', ['mapClass'=>'po-maps'])

@if($premiumAccess && ($visible('program') || $isPreview))
<section class="po-program ce2-section" id="po-program" data-preview-section="program" data-premium-section="program" @if(!$visible('program')) hidden @endif>
    <span class="po-eyebrow">FOLLOW THE PETAL PATH</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','The celebration awaits') }}</h2>
    <div class="po-path">
        @foreach([['guest_arrival_time','2:00 PM','guest_arrival_note','Welcome to our garden'],['event_time','3:00 PM','ceremony_timeline_note','Our ceremony'],['reception_time','6:00 PM','reception_timeline_note','Dinner and dancing'],['celebration_time','9:00 PM','celebration_timeline_note','A night among the stars']] as [$time,$timeFallback,$note,$noteFallback])
        <article><span aria-hidden="true">✿</span><strong data-field="{{ $time }}">{{ $display($time,$timeFallback) }}</strong><p data-field="{{ $note }}">{{ $copy($note,$noteFallback) }}</p></article>
        @endforeach
    </div>
    <p data-field="event_schedule" class="po-program-extra">{{ $copy('event_schedule','') }}</p>
</section>
@endif

@if($premiumAccess && ($visible('entourage') || $isPreview))
<section class="po-people ce2-section" id="po-people" data-preview-section="entourage" data-premium-section="entourage" @if(!$visible('entourage')) hidden @endif>
    <div class="po-people-arch"><span class="po-eyebrow">OUR BEAUTIFUL COMMUNITY</span>
        <h2 data-field="entourage_heading">{{ $copy('entourage_heading','The people beside us') }}</h2>
        <div class="po-people-list"><div><h3>Principal sponsors</h3><p data-field="principal_sponsors">{{ $copy('principal_sponsors','Our beloved ninongs and ninangs') }}</p></div>
        <div><h3>Bridesmaids</h3><p data-field="bridesmaids">{{ $copy('bridesmaids','Our lovely friends') }}</p></div>
        <div><h3>Groomsmen</h3><p data-field="groomsmen">{{ $copy('groomsmen','Our dearest friends') }}</p></div></div>
    </div>
</section>
@endif

<section class="po-gallery ce2-section" id="po-gallery" data-preview-section="couple">
    <span class="po-eyebrow">A GARDEN OF MEMORIES</span><h2 data-field="gallery_heading">{{ $copy('gallery_heading','Every bloom has a story') }}</h2>
    <div class="po-window-gallery">
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_one','class'=>'po-window po-window-first'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_two','class'=>'po-window po-window-second'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_three','class'=>'po-window po-window-third'])
    </div>
    <p data-field="gallery_quote">{{ $copy('gallery_quote',"Our story keeps growing with every beautiful moment.") }}</p>
</section>

@if($visible('details') || $isPreview)
<section class="po-dress ce2-section" id="po-dress" data-preview-section="details" @if(!$visible('details')) hidden @endif>
    <span class="po-eyebrow">BEFORE YOU JOIN OUR GARDEN</span><h2 data-field="dress_heading">{{ $copy('dress_heading','A note on attire') }}</h2>
    <p data-field="dress_code">{{ $copy('dress_code','Garden formal') }}</p>
    <p data-field="color_motif">{{ $copy('color_motif','Peach, moss, champagne and sage') }}</p>
    <div class="po-dress-flowers" aria-hidden="true" style="background-image:url('{{ $decoration('blooms') }}')"></div>
    <div class="po-color-petals" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
    <div class="po-gift-note"><h3>Gifts, with love</h3><p data-field="gift_message">{{ $copy('gift_message','Being with us is the loveliest gift.') }}</p>
    @if($validExternal('gift_registry_url'))<a href="{{ $validExternal('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">Wedding registry ↗</a>@endif</div>
</section>
@endif

@if($premiumAccess && ($visible('guests') || $isPreview))
<section class="po-rsvp ce2-section" id="po-rsvp" data-preview-section="guests" data-premium-section="guests" style="--po-rsvp-bg:url('{{ $decoration('forest') }}')" @if(!$visible('guests')) hidden @endif>
    <div class="po-rsvp-arch"><span class="po-eyebrow">WE'VE SAVED YOU A PLACE</span>
        <h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','Meet us beneath the blossoms') }}</h2>
        <p data-field="rsvp_message">{{ $copy('rsvp_message',"Will we see you at our garden celebration?") }}</p>
        @include('weddings.themes.editorial.rsvp', ['formClass'=>'po-rsvp-form','submitLabel'=>'Accept our invitation'])
    </div>
</section>
@endif

<footer class="po-footer ce2-section"><span>THE GARDEN GROWS A LITTLE BRIGHTER WITH YOU</span><h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2>
    <p data-field="closing_message">{{ $copy('closing_message',"And so the next chapter blooms.") }}</p><a href="#po-garden">RETURN TO THE GARDEN ↑</a></footer>

{{-- Two botanical conservatory gates unfold toward the guest. No envelope or skip. --}}
<div class="po-intro ce2-intro" id="ce2-intro" data-intro-kind="conservatory-gate" @if($isPreview) hidden @endif>
    <button type="button" class="po-gate-trigger" data-garden-gate-open aria-label="Open the garden gates to our invitation">
        <span class="po-gate-glow" aria-hidden="true"></span>
        <span class="po-gate-card"><small>BEHIND THESE GATES</small><strong>{{ $copy('bride_name','Amelia') }} &amp; {{ $copy('groom_name','Gabriel') }}</strong><em>{{ $date->format('F j, Y') }}</em></span>
        <span class="po-gate po-gate-left" style="background-image:linear-gradient(#0b241d80,#0b241d80),url('{{ $decoration('forest') }}')" aria-hidden="true"></span>
        <span class="po-gate po-gate-right" style="background-image:linear-gradient(#0b241d80,#0b241d80),url('{{ $decoration('forest') }}')" aria-hidden="true"></span>
        <span class="po-gate-emblem" aria-hidden="true">❀</span>
        <span class="po-gate-invite">OPEN THE GARDEN GATES</span>
    </button>
</div>
