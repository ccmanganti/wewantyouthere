@php
    $photoUrls = $photoUrls ?? [];
    $photo = fn (string $slot) => $photoUrls[$slot] ?? null;
    $visible = fn (string $group) => $sections[$group] ?? true;
    $hasIntroPhotos = (bool) ($photo('portrait_one') || $photo('portrait_two'));
    $galleryCount = collect(['gallery_one','gallery_two','gallery_three','gallery_four'])->filter(fn ($slot) => (bool) $photo($slot))->count();
    $hasRsvpPhoto = (bool) $photo('rsvp_portrait');
@endphp
<div class="wedding-invite rb-invite" id="wedding-invite">
    <nav class="invite-site-nav rb-nav" aria-label="Wedding website sections">
        <a class="rb-brand" href="#wedding-home">
            <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name', 'Amelia') }}</span>
            <span>&amp;</span>
            <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name', 'Gabriel') }}</span>
        </a>
        <div class="invite-site-links rb-links">
            <a href="#wedding-ceremony">The day</a>
            <a href="#wedding-story">Our story</a>
            <a href="#wedding-entourage" data-nav-section="entourage" @if(!$visible('entourage')) hidden @endif>Our people</a>
            <a href="#wedding-program" data-nav-section="program" @if(!$visible('program')) hidden @endif>Program</a>
            <a href="#wedding-details" data-nav-section="details" @if(!$visible('details')) hidden @endif>Details</a>
            <a href="#wedding-guests" data-nav-section="guests" @if(!$visible('guests')) hidden @endif>RSVP</a>
        </div>
    </nav>

    <section class="rb-cover" id="wedding-home" data-preview-section="couple">
        <div class="rb-cover-photo" data-photo-slot="hero"
            @if($photo('hero')) style="background-image:url('{{ $photo('hero') }}')" @endif>
            @if($isPreview)<button type="button" data-photo-edit="hero" class="rb-cover-edit" aria-label="Choose cover photo"><i class="fa-solid fa-camera" aria-hidden="true"></i> Cover photo</button>@endif
        </div>
        <div class="rb-cover-content rb-reveal">
            <span class="rb-kicker">YOU ARE CORDIALLY INVITED TO</span>
            <p class="rb-cover-title">The Wedding of</p>
            <h1 class="rb-script"><span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name', 'Amelia') }}</span><span class="rb-amp">&amp;</span><span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name', 'Gabriel') }}</span></h1>
            <div class="rb-rule"><span class="rb-star">✦</span></div>
            <p class="rb-cover-message" data-field="host_message" data-fallback="Together with our families, we invite you to celebrate the start of our forever.">{{ $display('host_message', 'Together with our families, we invite you to celebrate the start of our forever.') }}</p>
            <p class="rb-cover-date" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date', 'December 12, 2027') }}</p>
            <p class="rb-cover-venue" data-field="venue_name" data-fallback="THE GRAND GARDEN">{{ $display('venue_name', 'THE GRAND GARDEN') }}</p>
            <a class="rb-pill" href="#wedding-ceremony">Discover our day <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a>
        </div>
    </section>

    <section class="rb-section rb-paper" id="wedding-ceremony" data-preview-section="ceremony">
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">THE BEGINNING OF FOREVER</span><h2>With all our hearts, <em>you're invited.</em></h2></header>
            <div class="rb-intro-grid {{ !$isPreview && !$hasIntroPhotos ? 'rb-intro-grid--no-photos' : '' }}">
                <div class="rb-intro-copy rb-reveal">
                    <p class="rb-script-small">A celebration of love</p>
                    <p class="rb-big-date" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date','December 12, 2027') }}</p>
                    <div class="rb-detail"><span>TIME</span><strong data-field="event_time" data-fallback="3:00 PM">{{ $display('event_time','3:00 PM') }}</strong></div>
                    <div class="rb-detail"><span>CEREMONY</span><strong data-field="ceremony_venue" data-fallback="The Grand Chapel">{{ $display('ceremony_venue','The Grand Chapel') }}</strong><p class="rb-preline" data-field="ceremony_address" data-fallback="Your ceremony address">{{ $display('ceremony_address','Your ceremony address') }}</p></div>
                    <div class="rb-detail"><span>RECEPTION</span><strong data-field="reception_venue" data-fallback="The Grand Garden">{{ $display('reception_venue','The Grand Garden') }}</strong><p data-field="reception_time" data-fallback="6:00 PM">{{ $display('reception_time','6:00 PM') }}</p></div>
                    @include('weddings.partials.extras', ['group' => 'ceremony'])
                </div>
                @if($isPreview || $hasIntroPhotos)
                <div class="rb-photo-pair">
                    @foreach(['portrait_one','portrait_two'] as $slot)
                        @if($isPreview || $photo($slot))
                        <figure class="rb-photo rb-reveal" data-photo-slot="{{ $slot }}">
                            @if($photo($slot))<img src="{{ $photo($slot) }}" alt="Wedding portrait" loading="lazy" data-slot-img="{{ $slot }}">@else<div class="rb-photo-empty"><span aria-hidden="true">✦</span><small>A beautiful memory belongs here</small></div>@endif
                            @if($isPreview)<button type="button" data-photo-edit="{{ $slot }}" class="rb-photo-edit"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                        </figure>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    <section class="rb-section rb-burgundy" id="wedding-story" data-preview-section="couple">
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">THE CHAPTERS THAT BROUGHT US HERE</span><h2>Our <em>love story</em></h2><p class="rb-lead" data-field="couple_story" data-fallback="Every great love story has a beginning. Here is ours.">{{ $display('couple_story','Every great love story has a beginning. Here is ours.') }}</p></header>
            <ol class="rb-story" aria-label="Our love story timeline">
                @foreach(['story_one' => ['01','How it began','love_story_start','The day our paths first crossed.'], 'story_two' => ['02','Growing together','love_story_growing','The little moments that became our favorite memories.'], 'story_three' => ['03','The promise','love_story_proposal','The beginning of a beautiful new chapter.']] as $slot => [$number,$title,$key,$fallback])
                    <li class="rb-story-item rb-reveal">
                        <span class="rb-story-marker" aria-hidden="true">{{ $number }}</span>
                        @if($isPreview || $photo($slot))
                        <figure class="rb-photo rb-story-photo" data-photo-slot="{{ $slot }}">
                            @if($photo($slot))<img src="{{ $photo($slot) }}" alt="{{ $title }}" loading="lazy" data-slot-img="{{ $slot }}">@else<div class="rb-photo-empty"><span aria-hidden="true">✦</span><small>{{ $title }}</small></div>@endif
                            @if($isPreview)<button type="button" data-photo-edit="{{ $slot }}" class="rb-photo-edit"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                        </figure>
                        @endif
                        <div class="rb-story-copy"><span class="rb-kicker">CHAPTER {{ $number }}</span><h3>{{ $title }}</h3><p class="rb-preline" data-field="{{ $key }}" data-fallback="{{ $fallback }}">{{ $display($key, $fallback) }}</p></div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="rb-section rb-paper" id="wedding-entourage" data-preview-section="entourage" @if(!$visible('entourage')) hidden @endif>
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">OUR DEAREST PEOPLE</span><h2>With love, <em>from our families.</em></h2><p class="rb-lead" data-field="parents_message" data-fallback="Our families and beloved friends make this celebration even more meaningful.">{{ $display('parents_message','Our families and beloved friends make this celebration even more meaningful.') }}</p></header>
            <div class="rb-people-grid">
                @foreach([
                    ['Parents of the couple','bride_parents','groom_parents'],
                    ['Principal sponsors · Ninong & Ninang','principal_sponsors',null],
                    ['Maid of honor & best man','maid_of_honor','best_man'],
                    ['Bridesmaids & groomsmen','bridesmaids','groomsmen'],
                    ['Secondary sponsors','secondary_sponsors',null],
                    ['Ceremony roles','candle_sponsors','veil_sponsors'],
                    ['Flower girls & little bearers','flower_girls','ring_bearer'],
                    ['Officiant & readers','officiant_name','readers'],
                ] as [$title, $first, $second])
                    <div class="rb-person-card rb-reveal">
                        <h3>{{ $title }}</h3>
                        <p class="rb-preline" data-field="{{ $first }}" data-fallback="Add your loved ones">{{ $display($first, 'Add your loved ones') }}</p>
                        @if($second)<p class="rb-preline" data-field="{{ $second }}" data-fallback="">{{ $display($second) }}</p>@endif
                    </div>
                @endforeach
            </div>
            <div class="rb-extra">@include('weddings.partials.extras', ['group' => 'entourage'])</div>
        </div>
    </section>

    <section class="rb-section rb-burgundy" id="wedding-program" data-preview-section="program" @if(!$visible('program')) hidden @endif>
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">THE FLOW OF OUR DAY</span><h2>A day to <em>remember.</em></h2></header>
            <div class="rb-program-grid">
                <div class="rb-program-card rb-reveal"><span class="rb-kicker">01 / OUR WEDDING DAY</span><h3>The celebration</h3><p class="rb-preline" data-field="event_schedule" data-fallback="2:00 PM — Arrival&#10;3:00 PM — Wedding ceremony&#10;6:00 PM — Reception">{{ $display('event_schedule', "2:00 PM — Arrival\n3:00 PM — Wedding ceremony\n6:00 PM — Reception") }}</p></div>
                <div class="rb-program-card rb-reveal"><span class="rb-kicker">02 / THE CEREMONY</span><h3>The vows</h3><p class="rb-preline" data-field="ceremony_program" data-fallback="Procession · Vows · Exchange of rings">{{ $display('ceremony_program','Procession · Vows · Exchange of rings') }}</p><p class="rb-preline" data-field="ceremony_readings" data-fallback="">{{ $display('ceremony_readings') }}</p></div>
                <div class="rb-program-card rb-reveal"><span class="rb-kicker">03 / THE RECEPTION</span><h3>The festivities</h3><p class="rb-preline" data-field="reception_program" data-fallback="Dinner · Speeches · First dance">{{ $display('reception_program','Dinner · Speeches · First dance') }}</p><p class="rb-preline" data-field="reception_highlights" data-fallback="">{{ $display('reception_highlights') }}</p></div>
            </div>
        </div>
    </section>

    <section class="rb-section rb-paper" id="wedding-details" data-preview-section="details" @if(!$visible('details')) hidden @endif>
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">BEFORE THE BIG DAY</span><h2>The little <em>details.</em></h2></header>
            <div class="rb-info-grid">
                <div class="rb-info-card rb-reveal"><span class="rb-kicker">DRESS TO CELEBRATE</span><h3>Dress code</h3><p data-field="dress_code" data-fallback="Formal / Semi-formal">{{ $display('dress_code', 'Formal / Semi-formal') }}</p><p data-field="color_motif" data-fallback="A touch of burgundy, gold, and ivory">{{ $display('color_motif','A touch of burgundy, gold, and ivory') }}</p><p class="rb-preline" data-field="motif_notes" data-fallback="">{{ $display('motif_notes') }}</p></div>
                <div class="rb-info-card rb-reveal"><span class="rb-kicker">FROM THE HEART</span><h3>Gifts & wishes</h3><p class="rb-preline" data-field="gift_message" data-fallback="Your presence is already our greatest gift.">{{ $display('gift_message','Your presence is already our greatest gift.') }}</p></div>
                <div class="rb-info-card rb-reveal"><span class="rb-kicker">HELPFUL DETAILS</span><h3>Good to know</h3><p class="rb-preline" data-field="other_reminders" data-fallback="We cannot wait to celebrate with you.">{{ $display('other_reminders','We cannot wait to celebrate with you.') }}</p></div>
            </div>
            @include('weddings.partials.extras', ['group' => 'details'])
        </div>
    </section>

    <section class="rb-section rb-burgundy" id="wedding-reception" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">FIND YOUR WAY TO US</span><h2>Places & <em>directions.</em></h2></header>
            <div class="rb-locations">
                <div class="rb-location rb-reveal"><span class="rb-kicker">THE CEREMONY</span><h3 data-field="ceremony_venue" data-fallback="The Grand Chapel">{{ $display('ceremony_venue','The Grand Chapel') }}</h3><p class="rb-preline" data-field="ceremony_address" data-fallback="Your ceremony address">{{ $display('ceremony_address','Your ceremony address') }}</p>
                    @if(filled($answers['ceremony_map_url'] ?? ''))<a href="{{ $answers['ceremony_map_url'] }}" target="_blank" rel="noopener noreferrer">Open directions ↗</a>@endif
                </div>
                <div class="rb-location rb-reveal"><span class="rb-kicker">THE RECEPTION</span><h3 data-field="reception_venue" data-fallback="The Grand Garden">{{ $display('reception_venue','The Grand Garden') }}</h3><p class="rb-preline" data-field="reception_address" data-fallback="Reception address">{{ $display('reception_address','Reception address') }}</p>
                    @if(filled($answers['reception_map_url'] ?? ''))<a href="{{ $answers['reception_map_url'] }}" target="_blank" rel="noopener noreferrer">Open directions ↗</a>@endif
                </div>
            </div>
            @include('weddings.partials.extras', ['group' => 'reception'])
        </div>
    </section>

    @if($isPreview || $galleryCount > 0)
    <section class="rb-section rb-paper" id="wedding-moments" data-preview-section="couple">
        <div class="rb-container">
            <header class="rb-heading rb-reveal"><span class="rb-kicker">A FEW FAVORITE MOMENTS</span><h2>Our <em>memories.</em></h2></header>
            <div class="rb-gallery {{ !$isPreview && $galleryCount < 4 ? 'rb-gallery-few' : '' }}">
                @foreach(['gallery_one','gallery_two','gallery_three','gallery_four'] as $slot)
                    @if($isPreview || $photo($slot))
                    <figure class="rb-photo rb-gallery-photo rb-reveal" data-photo-slot="{{ $slot }}">
                        @if($photo($slot))<img src="{{ $photo($slot) }}" alt="A favorite wedding memory" loading="lazy" data-slot-img="{{ $slot }}">@else<div class="rb-photo-empty"><span aria-hidden="true">✦</span><small>Our favorite moments</small></div>@endif
                        @if($isPreview)<button type="button" data-photo-edit="{{ $slot }}" class="rb-photo-edit"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                    </figure>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="rb-section rb-noir" id="wedding-guests" data-preview-section="guests" @if(!$visible('guests')) hidden @endif>
        <div class="rb-container rb-rsvp-grid {{ !$isPreview && !$hasRsvpPhoto ? 'rb-rsvp-grid--no-photo' : '' }}">
            @if($isPreview || $hasRsvpPhoto)
            <figure class="rb-photo rb-rsvp-photo rb-reveal" data-photo-slot="rsvp_portrait">
                @if($photo('rsvp_portrait'))<img src="{{ $photo('rsvp_portrait') }}" alt="The happy couple" loading="lazy" data-slot-img="rsvp_portrait">@else<div class="rb-photo-empty"><span aria-hidden="true">✦</span><small>With love</small></div>@endif
                @if($isPreview)<button type="button" data-photo-edit="rsvp_portrait" class="rb-photo-edit"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
            </figure>
            @endif
            <div class="rb-rsvp-copy rb-reveal">
                <span class="rb-kicker">WE CAN'T WAIT TO SEE YOU</span>
                <h2>Will you <em>join us?</em></h2>
                <p class="rb-preline" data-field="rsvp_message" data-fallback="Let us know if you'll be joining the celebration.">{{ $display('rsvp_message','Let us know if you’ll be joining the celebration.') }}</p>
                <div class="rb-detail"><span>PLEASE RESPOND BY</span><strong data-field="rsvp_deadline" data-fallback="November 20, 2027">{{ $display('rsvp_deadline','November 20, 2027') }}</strong></div>
                <div class="rb-detail"><span>CONTACT</span><strong data-field="contact_name" data-fallback="Your RSVP contact">{{ $display('contact_name','Your RSVP contact') }}</strong><p data-field="contact_phone" data-fallback="">{{ $display('contact_phone') }}</p></div>
                <p class="rb-rsvp-note">RSVP collection is coming soon. For now, please confirm directly with the contact above.</p>
                @include('weddings.partials.extras', ['group' => 'guests'])
            </div>
        </div>
    </section>

    <footer class="rb-footer">
        <span class="rb-kicker">WITH ALL OUR LOVE</span>
        <p><span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span></p>
        <a href="#wedding-home">Back to the beginning <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></a>
    </footer>
</div>
