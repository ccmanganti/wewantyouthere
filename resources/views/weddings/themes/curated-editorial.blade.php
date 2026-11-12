@php
    $isPreview = $isPreview ?? false;
    $isSample = !isset($website) && !$isPreview;
    $premiumAccess = $premiumAccess ?? false;
    $designKey = $template->settings['design'] ?? 'burgundy-wax';
    $design = config('wedding_curated_themes.'.$designKey, config('wedding_curated_themes.burgundy-wax'));
    $photoUrls = $photoUrls ?? [];
    $samplePhoto = config('wedding_sample_photos', []);
    $photo = function (string $slot) use ($photoUrls, $samplePhoto, $isSample, $isPreview) {
        if (!empty($photoUrls[$slot])) return $photoUrls[$slot];
        // Never publish someone else's sample wedding photographs.
        return ($isPreview || $isSample) ? ($samplePhoto[$slot] ?? null) : null;
    };
    $copy = function (string $key, string $fallback = '') use ($answers, $isPreview, $isSample) {
        $value = trim((string) ($answers[$key] ?? ''));
        return $value !== '' ? $value : (($isPreview || $isSample) ? $fallback : '');
    };
    $visible = fn (string $key) => (bool) ($sections[$key] ?? !in_array($key, ['maps','ceremony_details','video','program','entourage','guests'], true));
    $published = isset($website) && $website->status === 'published' && !$isPreview;
    $date = !empty($answers['event_date']) ? \Carbon\CarbonImmutable::parse($answers['event_date']) : \Carbon\CarbonImmutable::create(2027,12,12);
    $guestMax = min(12,max(1,(int) ($answers['guest_limit'] ?? 3)));
    $safeLink = function ($key) use ($answers) {
        $url = trim((string) ($answers[$key] ?? ''));
        return filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), ['http','https'], true) ? $url : null;
    };
@endphp
<div id="wedding-invite" class="wedding-invite ce-invite ce-{{ $designKey }}" data-curated-design="{{ $designKey }}" data-preview="{{ $isPreview ? '1' : '0' }}" style="--ce-ink:{{ $design['accent'] }};--ce-paper:{{ $design['paper'] }}">
    <header class="ce-navbar">
        <a class="ce-wordmark" href="#ce-cover" aria-label="Go to invitation cover"><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><b>&amp;</b><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></a>
        <details class="ce-menu"><summary aria-label="Open wedding navigation"><span>MENU</span><span aria-hidden="true">☰</span></summary>
            <nav aria-label="Invitation navigation">
                <a href="#ce-story">Our story</a><a href="#ce-when">Date</a><a href="#ce-where">Location</a>
                <a href="#ce-program" data-nav-section="program" @if(!$visible('program')) hidden @endif>Program</a>
                <a href="#ce-entourage" data-nav-section="entourage" @if(!$visible('entourage')) hidden @endif>Entourage</a>
                <a href="#ce-rsvp" data-nav-section="guests" @if(!$visible('guests')) hidden @endif>RSVP</a>
            </nav>
        </details>
    </header>

    {{-- Five different covers: independent image composition, typography and interaction. --}}
    <section class="ce-cover ce-section" id="ce-cover" data-preview-section="couple">
        @if($designKey === 'burgundy-wax')
            <div class="ce-floral-ceiling" style="background-image:url('{{ $design['floral'] }}')"></div>
            <div class="ce-cover-paper">
                <div class="ce-pressed-flowers" aria-hidden="true"></div>
                <p class="ce-overline">{{ $design['eyebrow'] }}</p>
                <div class="ce-stationery-arch">
                    <p class="ce-script">Together with their families</p>
                    <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><em>&amp;</em><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
                    <p class="ce-date-letter" data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
                </div>
                <span class="ce-wax" aria-hidden="true">A <small>&amp;</small> G</span>
                <a class="ce-explore" href="#ce-story">UNFOLD THE STORY ↓</a>
            </div>
        @elseif($designKey === 'olive-garden')
            <div class="ce-olive-hero">
                <figure class="ce-cover-picture" data-photo-slot="hero">
                    @if($photo('hero'))<img src="{{ $photo('hero') }}" data-slot-img="hero" alt="The happy couple" fetchpriority="high">@else<div class="ce-missing-photo">YOUR PHOTO</div>@endif
                </figure>
                <div class="ce-olive-envelope"><span class="ce-stamp" aria-hidden="true">✿</span>
                    <p class="ce-script">We invite you to celebrate</p>
                    <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><em>&amp;</em><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
                    <p data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
                </div>
                <div class="ce-olive-caption">{{ $design['cover'] }}</div>
            </div>
        @elseif($designKey === 'painted-orchard')
            <div class="ce-orchard-hero" style="background-image:linear-gradient(#141d1240,#161c1355),url('{{ $design['scenery'] }}')">
                <div class="ce-orchard-frame"><span>THE WEDDING OF</span>
                    <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><em>&amp;</em><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
                    <p data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
                    <span class="ce-orchard-fleur" aria-hidden="true">❀</span>
                </div>
                <a class="ce-explore" href="#ce-story">WANDER INTO OUR STORY ↓</a>
            </div>
        @elseif($designKey === 'pearl-editorial')
            <div class="ce-pearl-hero">
                <p class="ce-script">Are One · The wedding day</p>
                <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><span class="ce-pearl-amp">&amp;</span><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
                <div class="ce-pearl-picture" data-photo-slot="hero">
                    @if($photo('hero'))<img src="{{ $photo('hero') }}" data-slot-img="hero" alt="The happy couple" fetchpriority="high">@else<div class="ce-missing-photo">YOUR PHOTO</div>@endif
                </div>
                <div class="ce-pearl-chain" aria-hidden="true">● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ●</div>
                <p class="ce-pearl-issue">OUR WEDDING DAY <span data-field="event_date">{{ $display('event_date','December 12, 2027') }}</span></p>
            </div>
        @else
            <div class="ce-ticket-hero">
                <div class="ce-ticket-top"><span>✈ WEDDING TICKET</span><span>FLIGHT 001 · FOREVER</span></div>
                <div class="ce-ticket-globe" aria-hidden="true">✧</div>
                <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><small>and</small><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
                <div class="ce-ticket-row"><div><small>DEPARTURE</small><span data-field="event_date">{{ $display('event_date','December 12, 2027') }}</span></div><div><small>DESTINATION</small><span data-field="venue_name">{{ $copy('venue_name','Our favorite place') }}</span></div></div>
                <div class="ce-ticket-hero-photo" data-photo-slot="hero">
                    @if($photo('hero'))<img src="{{ $photo('hero') }}" data-slot-img="hero" alt="The happy couple" fetchpriority="high">@else<div class="ce-missing-photo">YOUR PHOTO</div>@endif
                </div>
                <p class="ce-ticket-tear">BOARDING FOR LOVE · ADMIT ONE CELEBRATION</p>
            </div>
        @endif
    </section>

    <section class="ce-story ce-section" id="ce-story" data-preview-section="couple">
        <div class="ce-editorial-heading"><span class="ce-eyebrow">THE BEGINNING OF EVERYTHING</span><h2 data-field="welcome_heading">{{ $copy('welcome_heading',"You're invited.") }}</h2>
            <p data-field="host_message">{{ $copy('host_message',"Together with our families, we invite you to celebrate a day filled with love.") }}</p>
        </div>
        <div class="ce-story-photos">
            <figure class="ce-picture ce-story-first" data-photo-slot="portrait_one">
                @if($photo('portrait_one'))<img src="{{ $photo('portrait_one') }}" data-slot-img="portrait_one" alt="A portrait from the couple's love story" loading="lazy">@else<div class="ce-missing-photo">ADD YOUR PORTRAIT</div>@endif
                <figcaption data-field="editorial_caption_one">{{ $copy('editorial_caption_one','Every path led us here.') }}</figcaption>
            </figure>
            <figure class="ce-picture ce-story-second" data-photo-slot="portrait_two">
                @if($photo('portrait_two'))<img src="{{ $photo('portrait_two') }}" data-slot-img="portrait_two" alt="Another special photograph" loading="lazy">@else<div class="ce-missing-photo">ADD YOUR PORTRAIT</div>@endif
                <figcaption data-field="editorial_caption_two">{{ $copy('editorial_caption_two','And every moment was worth it.') }}</figcaption>
            </figure>
        </div>
        <div class="ce-story-text"><span class="ce-eyebrow">A LITTLE OF OUR STORY</span><h2 data-field="story_heading">{{ $copy('story_heading','How it all began') }}</h2>
            <p data-field="couple_story">{{ $copy('couple_story',"Our days together have been filled with beautiful little moments.") }}</p>
        </div>
    </section>

    <section class="ce-date-section ce-section" id="ce-when" data-preview-section="ceremony">
        <div class="ce-date-ornament" aria-hidden="true">{{ $designKey === 'destination-ticket' ? '✈' : ($designKey === 'pearl-editorial' ? '◌' : '✿') }}</div>
        <span class="ce-eyebrow">SAVE OUR DATE</span>
        <h2 data-field="date_caption">{{ $copy('date_caption','A day to remember') }}</h2>
        <div class="ce-calendar-shell" data-ce-calendar="{{ $date->format('Y-m-d') }}">
            <div class="ce-calendar-month">{{ $date->format('F Y') }}</div>
            <div class="ce-calendar-grid" data-ce-calendar-grid></div>
        </div>
        <p class="ce-date-large" data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
        <p data-field="event_time">{{ $display('event_time','3:00 PM') }}</p>
        <div class="ce-countdown" data-ce-countdown="{{ $date->format('Y-m-d') }}" aria-label="Countdown to the wedding"><div><strong data-ce-days>00</strong><small>DAYS</small></div><div><strong data-ce-hours>00</strong><small>HOURS</small></div><div><strong data-ce-minutes>00</strong><small>MINUTES</small></div></div>
    </section>

    <section class="ce-place ce-section" id="ce-where" data-preview-section="ceremony">
        <div class="ce-place-photo ce-picture" data-photo-slot="venue_ceremony">
            @if($photo('venue_ceremony'))<img src="{{ $photo('venue_ceremony') }}" data-slot-img="venue_ceremony" alt="The ceremony venue" loading="lazy">@else<div class="ce-missing-photo">OUR CEREMONY VENUE</div>@endif
        </div>
        <div class="ce-place-body">
            <span class="ce-eyebrow">WHERE WE WILL SAY I DO</span><h2>Our venue</h2>
            <h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Glass Chapel') }}</h3>
            <p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful garden in the Philippines') }}</p>
            <p><span class="ce-eyebrow">THE CELEBRATION CONTINUES</span></p>
            <h3 data-field="reception_venue">{{ $copy('reception_venue','The Glass Garden') }}</h3>
            <p data-field="reception_address">{{ $copy('reception_address','Join us for dinner and dancing') }}</p>
            <p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p>
        </div>
    </section>

    @if($visible('reception'))
    <section class="ce-reception ce-section" data-preview-section="reception">
        <div class="ce-reception-heading"><span class="ce-eyebrow">DINNER, DANCING AND BEAUTIFUL MEMORIES</span><h2>Let's celebrate</h2></div>
        <figure class="ce-picture ce-reception-photo" data-photo-slot="venue_reception">
            @if($photo('venue_reception'))<img src="{{ $photo('venue_reception') }}" data-slot-img="venue_reception" alt="The wedding reception setting" loading="lazy">@else<div class="ce-missing-photo">RECEPTION PHOTOGRAPH</div>@endif
        </figure>
    </section>
    @endif

    @if($visible('maps') && $premiumAccess)
    <section class="ce-premium-section ce-section" id="ce-maps" data-preview-section="reception" data-premium-section="maps">
        <span class="ce-eyebrow">FIND YOUR WAY TO US</span><h2 data-field="map_heading">{{ $copy('map_heading','Directions') }}</h2>
        @foreach(['ceremony' => 'Ceremony','reception' => 'Reception'] as $kind => $label)
            @php $location = trim((string)($answers[$kind.'_address'] ?? $answers['venue_address'] ?? '')); @endphp
            @if($location)
                <div class="ce-map-card"><h3>{{ $label }}</h3><iframe loading="lazy" title="{{ $label }} location" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q={{ rawurlencode($location) }}&amp;z=14&amp;output=embed"></iframe>
                    <a href="{{ $safeLink($kind.'_map_url') ?: 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($location) }}" target="_blank" rel="noopener noreferrer">OPEN IN MAPS ↗</a></div>
            @endif
        @endforeach
    </section>
    @endif

    @if($visible('ceremony_details') && $premiumAccess)
    <section class="ce-premium-section ce-section" id="ce-ceremony-details" data-preview-section="ceremony" data-premium-section="ceremony_details">
        <span class="ce-eyebrow">A SPECIAL NOTE</span><h2 data-field="ceremony_type">{{ $copy('ceremony_type','The ceremony') }}</h2><p data-field="ceremony_notes">{{ $copy('ceremony_notes','A few details for our special day.') }}</p>
    </section>
    @endif

    @if($visible('program') && $premiumAccess)
    <section class="ce-program ce-section" id="ce-program" data-preview-section="program" data-premium-section="program">
        <span class="ce-eyebrow">OUR WEDDING DAY</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','Program of the day') }}</h2>
        <div class="ce-program-line">
            @foreach([['guest_arrival_time','2:00 PM','guest_arrival_note','Welcome drinks'],['event_time','3:00 PM','ceremony_timeline_note','Wedding ceremony'],['reception_time','6:00 PM','reception_timeline_note','Dinner and celebration'],['celebration_time','9:00 PM','celebration_timeline_note','Dancing under the stars']] as [$time,$timeFallback,$note,$noteFallback])
            <div class="ce-program-item"><span data-field="{{ $time }}">{{ $display($time,$timeFallback) }}</span><p data-field="{{ $note }}">{{ $copy($note,$noteFallback) }}</p></div>
            @endforeach
        </div>
        <p class="ce-program-full" data-field="event_schedule">{{ $copy('event_schedule','') }}</p>
    </section>
    @endif

    @if($visible('entourage') && $premiumAccess)
    <section class="ce-entourage ce-section" id="ce-entourage" data-preview-section="entourage" data-premium-section="entourage">
        <span class="ce-eyebrow">THE PEOPLE WE LOVE</span><h2 data-field="entourage_heading">{{ $copy('entourage_heading','Our dearest people') }}</h2>
        <div class="ce-entourage-grid">
            @foreach(['principal_sponsors'=>'Principal sponsors','bride_parents'=>"Bride's parents",'groom_parents'=>"Groom's parents",'maid_of_honor'=>'Maid of honor','best_man'=>'Best man','bridesmaids'=>'Bridesmaids','groomsmen'=>'Groomsmen'] as $key => $label)
                @if(filled($answers[$key] ?? null) || $isPreview || $isSample)
                <div><span class="ce-eyebrow">{{ $label }}</span><p data-field="{{ $key }}">{{ $copy($key,$label) }}</p></div>
                @endif
            @endforeach
        </div>
    </section>
    @endif

    <section class="ce-gallery ce-section" id="ce-gallery" data-preview-section="couple">
        <span class="ce-eyebrow">THE MOMENTS WE TREASURE</span><h2 data-field="gallery_heading">{{ $copy('gallery_heading','Our favorite memories') }}</h2>
        <div class="ce-gallery-grid">
            @foreach(['gallery_one','gallery_two','gallery_three','gallery_four'] as $slot)
                <figure class="ce-picture" data-photo-slot="{{ $slot }}">
                    @if($photo($slot))<img src="{{ $photo($slot) }}" data-slot-img="{{ $slot }}" alt="A favorite photograph of the couple" loading="lazy">@else<div class="ce-missing-photo">YOUR MEMORY</div>@endif
                </figure>
            @endforeach
        </div>
        <p class="ce-script" data-field="gallery_quote">{{ $copy('gallery_quote','Our favorite adventure is just beginning.') }}</p>
    </section>

    <section class="ce-details ce-section" id="ce-details" data-preview-section="details">
        <span class="ce-eyebrow">THE FINER DETAILS</span><h2 data-field="dress_heading">{{ $copy('dress_heading','Dress code') }}</h2>
        <p data-field="dress_code">{{ $copy('dress_code','Formal or semi-formal attire') }}</p>
        <p data-field="color_motif">{{ $copy('color_motif','Ivory, champagne and sage') }}</p>
        <div class="ce-swatches" aria-label="Sample wedding motif colors"><i></i><i></i><i></i><i></i><i></i></div>
        <div class="ce-gift"><span class="ce-eyebrow">A NOTE ABOUT GIFTS</span><p data-field="gift_message">{{ $copy('gift_message','Your presence is the greatest gift of all.') }}</p>
            @if($safeLink('gift_registry_url'))<a href="{{ $safeLink('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">VIEW OUR REGISTRY ↗</a>@endif
        </div>
    </section>

    @if($visible('guests') && $premiumAccess)
    <section class="ce-rsvp ce-section" id="ce-rsvp" data-preview-section="guests" data-premium-section="guests">
        <div class="ce-rsvp-envelope" aria-hidden="true"><span>RSVP</span></div>
        <span class="ce-eyebrow">WE WANT YOU THERE</span><h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','Kindly RSVP') }}</h2>
        <p data-field="rsvp_message">{{ $copy('rsvp_message','Let us know if you can celebrate with us.') }}</p>
        @if(session('rsvp_success') && $published)
            <p role="status">{{ session('rsvp_success') }}</p>
        @else
        <form class="ce-rsvp-form" method="POST" @if($published) action="{{ route('wedding.rsvp.store', $website->slug) }}" @else data-ce-demo="1" @endif>
            @csrf
            <label>Full name <input type="text" name="guest_name" placeholder="Enter your full name" maxlength="120" minlength="2" required></label>
            <fieldset><legend>Will you attend?</legend><label><input type="radio" name="attendance" value="attending" required> Joyfully accepts</label><label><input type="radio" name="attendance" value="declined" required> Regretfully declines</label></fieldset>
            <label>Number of guests<select name="party_size" required>@for($i=1;$i<=$guestMax;$i++)<option value="{{ $i }}">{{ $i }} {{ $i===1 ? 'guest':'guests' }}</option>@endfor</select></label>
            <label>Message (optional)<textarea name="message" rows="3" maxlength="500" placeholder="Send us your best wishes"></textarea></label>
            <label class="ce-honey" aria-hidden="true">Leave blank<input name="website" tabindex="-1" autocomplete="off"></label>
            <button type="submit">SEND CONFIRMATION →</button><p data-ce-form-feedback role="status" aria-live="polite"></p>
            @if($errors->any())<p role="alert">{{ $errors->first() }}</p>@endif
        </form>
        @endif
    </section>
    @endif

    @include('weddings.partials.premium-video')
    <footer class="ce-footer ce-section"><p class="ce-script">With all our love</p><h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2><p data-field="closing_message">{{ $copy('closing_message','We cannot wait to celebrate with you.') }}</p><a href="#ce-cover">BACK TO THE TOP ↑</a></footer>

    <div class="ce-intro" id="ce-intro" @if($isPreview) hidden @endif>
        <button type="button" class="ce-intro-envelope" data-ce-open aria-label="Open wedding invitation">
            @if($designKey === 'destination-ticket')<span class="ce-intro-tag">FIRST CLASS · BOARDING PASS</span>@endif
            <span class="ce-intro-flap"></span>
            <span class="ce-intro-card"><span class="ce-intro-script">{{ $design['intro'] }}</span><strong>{{ $copy('bride_name','Amelia') }} &amp; {{ $copy('groom_name','Gabriel') }}</strong><small>{{ $date->format('F j, Y') }}</small></span>
            <span class="ce-intro-front"></span>
            <span class="ce-intro-seal" aria-hidden="true">{{ $designKey === 'destination-ticket' ? '✈' : '♥' }}</span>
        </button>
    </div>
</div>
