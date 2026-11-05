{{-- 01 GRAND: photographic wedding cover --}}
<section class="rbv-grand rbv-cover" id="cover" data-preview-section="couple">
    <span class="rbv-eyebrow" data-field="cover_eyebrow">{{ $copy('cover_eyebrow','A CELEBRATION OF LOVE') }}</span>
    <div class="rbv-cover-title"><span class="rbv-script">The</span><h1>WEDDING</h1><span class="rbv-script">day</span></div>
    <figure class="rbv-photo rbv-cover-photo" data-photo-slot="hero">
        @if($image('hero','couple.webp','grand-doors.webp'))<img src="{{ $image('hero','couple.webp','grand-doors.webp') }}" alt="Wedding portrait" data-slot-img="hero" fetchpriority="high">@else<div class="rbv-photo-empty">YOUR WEDDING PORTRAIT</div>@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="hero"><i class="fa-solid fa-camera"></i> Cover photograph</button>@endif
        <figcaption data-field="cover_tagline">{{ $copy('cover_tagline','ONE LOVE. ONE PROMISE. ONE FOREVER.') }}</figcaption>
    </figure>
    <p class="rbv-names"><span data-field="bride_name">{{ $personal('bride_name','Amelia') }}</span> <b>♥</b> <span data-field="groom_name">{{ $personal('groom_name','Gabriel') }}</span></p>
    <p class="rbv-date-text" data-field="event_date">{{ $dateText }}</p>
    <img class="rbv-botanical rbv-small-botanical" src="{{ $art('botanical.webp','botanical-engraving.webp') }}" alt="" loading="lazy">
    <a class="rbv-scroll-down" href="#welcome-note">Discover our story <i class="fa-solid fa-arrow-down"></i></a>
</section>

{{-- 02 INFO: invitation message --}}
<section class="rbv-info rbv-welcome" id="welcome-note" data-preview-section="couple">
    <div class="rbv-inner"><span class="rbv-eyebrow">TO OUR DEAREST FAMILY &amp; FRIENDS</span>
        <h2 class="rbv-title" data-field="welcome_heading">{{ $copy('welcome_heading',"You're invited.") }}</h2>
        <p class="rbv-copy" data-field="host_message">{{ $copy('host_message','Together with our families, it is with so much love and happiness that we invite you to be part of our wedding day.') }}</p>
        <p class="rbv-copy" data-field="welcome_secondary">{{ $copy('welcome_secondary','Your presence will make our beginning even more beautiful.') }}</p>
        <span class="rbv-divider" aria-hidden="true">✦</span>
    </div>
</section>

{{-- 03 GRAND: layered editorial photographs, all couple photos editable --}}
<section class="rbv-grand rbv-editorial" id="portrait-collection" data-preview-section="couple">
    <img class="rbv-overlay-art rbv-overlay-left" src="{{ $art('art_left.jpg','botanical-engraving.webp') }}" alt="" loading="lazy">
    <span class="rbv-eyebrow">A FEW OF OUR FAVORITE MOMENTS</span>
    <h2 class="rbv-title" data-field="editorial_heading">{{ $copy('editorial_heading','Little things, great love.') }}</h2>
    <div class="rbv-photo-pair">
        @foreach([['portrait_two','gallery-couple-walking.webp','Every path led us to you.','editorial_caption_one'],['editorial_portrait','gallery-couple-close.webp','Always, together.','editorial_caption_two']] as [$slot,$asset,$caption,$key])
        <figure class="rbv-photo" data-photo-slot="{{ $slot }}">
            @if($image($slot,$asset,'grand-doors.webp'))<img src="{{ $image($slot,$asset,'grand-doors.webp') }}" data-slot-img="{{ $slot }}" alt="Romantic photograph" loading="lazy">@else<div class="rbv-photo-empty">YOUR PHOTOGRAPH</div>@endif
            <figcaption data-field="{{ $key }}">{{ $copy($key,$caption) }}</figcaption>
            @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera"></i> Replace</button>@endif
        </figure>
        @endforeach
    </div>
    <p class="rbv-quote" data-field="editorial_quote">{{ $copy('editorial_quote','“You are my favorite chapter.”') }}</p>
</section>

{{-- 04 INFO: story with 3 independent editable chapters --}}
<section class="rbv-info" id="our-story" data-preview-section="couple">
    <div class="rbv-inner"><span class="rbv-eyebrow">THE STORY BEHIND OUR FOREVER</span>
        <h2 class="rbv-title" data-field="story_heading">{{ $copy('story_heading','How it all began.') }}</h2>
        <p class="rbv-copy" data-field="couple_story">{{ $copy('couple_story','Our story grew through shared laughter, beautiful surprises and ordinary days that became our favorites.') }}</p>
        <div class="rbv-chapters">
        @foreach([
            ['01','story_chapter_one_heading','When we met','love_story_start','It began with a hello that became something extraordinary.'],
            ['02','story_chapter_two_heading','The little moments','love_story_growing','We found a home in every journey, memory and laugh.'],
            ['03','story_chapter_three_heading','Our promise','love_story_proposal','And now, our favorite adventure begins with an “I do.”']
        ] as [$num,$headingKey,$heading,$bodyKey,$body])
            <article><span>CHAPTER {{ $num }}</span><h3 data-field="{{ $headingKey }}">{{ $copy($headingKey,$heading) }}</h3><p data-field="{{ $bodyKey }}">{{ $copy($bodyKey,$body) }}</p></article>
        @endforeach
        </div>
        <figure class="rbv-photo rbv-story-keepsake" data-photo-slot="story_three">
            @if($image('story_three','gallery-couple-soft.webp','grand-doors.webp'))<img src="{{ $image('story_three','gallery-couple-soft.webp','grand-doors.webp') }}" data-slot-img="story_three" alt="A special chapter in our story" loading="lazy">@else<div class="rbv-photo-empty">OUR FAVORITE MEMORY</div>@endif
            @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="story_three"><i class="fa-solid fa-camera"></i> Add photo</button>@endif
        </figure>
        <blockquote data-field="hero_quote">{{ $copy('hero_quote','The best thing to hold onto in life is each other.') }}</blockquote>
    </div>
</section>

{{-- 05 GRAND: antique doorway art and editable portrait overlay --}}
<section class="rbv-grand rbv-doors" id="the-doors" data-preview-section="couple">
    <figure class="rbv-doors-photo" data-photo-slot="portrait_one">
        @if($image('portrait_one','doors.webp','grand-doors.webp'))<img src="{{ $image('portrait_one','doors.webp','grand-doors.webp') }}" data-slot-img="portrait_one" alt="Elegant doorway or couple portrait" loading="lazy">@else<img src="{{ $art('doors.webp','grand-doors.webp') }}" alt="Decorative burgundy doors" loading="lazy">@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="portrait_one"><i class="fa-solid fa-camera"></i> Replace</button>@endif
    </figure>
    <div class="rbv-door-caption"><span class="rbv-eyebrow">A NEW CHAPTER BEGINS</span><h2 data-field="door_heading">{{ $copy('door_heading','The doors to forever.') }}</h2></div>
</section>

{{-- 06 INFO: live wedding calendar --}}
<section class="rbv-info rbv-calendar-section" id="the-date" data-preview-section="ceremony">
    <div class="rbv-inner"><span class="rbv-eyebrow">MARK THE MOMENT</span>
        <h2 class="rbv-title" data-rbv-month>{{ $date->format('F') }}</h2>
        <p class="rbv-calendar-year" data-rbv-year>{{ $date->format('Y') }}</p>
        <div class="rbv-calendar" data-rbv-date="{{ $date->format('Y-m-d') }}">
            <div class="rbv-weekdays">@foreach(['M','T','W','T','F','S','S'] as $weekday)<span>{{ $weekday }}</span>@endforeach</div>
            <div class="rbv-days" id="rbv-calendar-days"></div>
        </div>
        <p class="rbv-calendar-ribbon"><span data-rbv-weekday>{{ strtoupper($date->format('l')) }}</span><strong data-rbv-day>{{ $date->format('d') }}</strong><span data-rbv-monthyear>{{ strtoupper($date->format('F Y')) }}</span></p>
        <p class="rbv-copy" data-field="date_caption">{{ $copy('date_caption',"A day we'll remember for a lifetime.") }}</p>
    </div>
</section>

{{-- 07 GRAND: venue illustration --}}
<section class="rbv-grand rbv-venue-art" id="venue-art" data-preview-section="ceremony">
    <span class="rbv-eyebrow">WHERE WE WILL SAY “I DO”</span>
    <h2 class="rbv-title" data-field="venue_art_heading">{{ $copy('venue_art_heading','Our special place') }}</h2>
    <figure class="rbv-photo rbv-venue-engraving" data-photo-slot="venue_ceremony">
        @if($image('venue_ceremony','venue-engraving.webp','grand-doors.webp'))<img src="{{ $image('venue_ceremony','venue-engraving.webp','grand-doors.webp') }}" data-slot-img="venue_ceremony" alt="Wedding venue artwork" loading="lazy">@else<div class="rbv-photo-empty">YOUR CEREMONY VENUE</div>@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="venue_ceremony"><i class="fa-solid fa-camera"></i> Venue artwork</button>@endif
    </figure>
    <p data-field="venue_name" class="rbv-venue-name">{{ $personal('venue_name','THE GRAND ESTATE') }}</p>
</section>

{{-- 08 INFO: ceremony and reception specifics --}}
<section class="rbv-info" id="location-details" data-preview-section="ceremony">
    <div class="rbv-inner"><span class="rbv-eyebrow">COME CELEBRATE WITH US</span>
        <h2 class="rbv-title" data-field="venue_intro">{{ $copy('venue_intro','The venues') }}</h2>
        <div class="rbv-location">
            <span class="rbv-eyebrow">THE CEREMONY</span>
            <h3 data-field="ceremony_venue">{{ $personal('ceremony_venue','Our wedding ceremony') }}</h3>
            <p data-field="ceremony_address">{{ $personal('ceremony_address','Ceremony address') }}</p>
            <strong data-field="event_time">{{ $personal('event_time','3:00 PM') }}</strong>
            <a class="rbv-link" data-map-link="ceremony" href="{{ $map('ceremony_map_url') ?: '#' }}" target="_blank" rel="noopener noreferrer" @if(!$map('ceremony_map_url')) hidden @endif>GET DIRECTIONS <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
        <span class="rbv-divider">✦</span>
        <div class="rbv-location" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
            <span class="rbv-eyebrow">THE RECEPTION</span>
            <h3 data-field="reception_venue">{{ $personal('reception_venue','Our reception venue') }}</h3>
            <p data-field="reception_address">{{ $personal('reception_address','Reception address') }}</p>
            <strong data-field="reception_time">{{ $personal('reception_time','6:00 PM') }}</strong>
            <a class="rbv-link" data-map-link="reception" href="{{ $map('reception_map_url') ?: '#' }}" target="_blank" rel="noopener noreferrer" @if(!$map('reception_map_url')) hidden @endif>GET DIRECTIONS <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
    </div>
</section>
