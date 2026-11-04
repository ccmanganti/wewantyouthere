@php
    $photoUrls = $photoUrls ?? [];
    $photo = fn (string $slot) => $photoUrls[$slot] ?? null;
    $visible = fn (string $group) => $sections[$group] ?? true;
    $isPreview = $isPreview ?? false;
    $assetBase = 'wedding/royal-burgundy/';
    $eventDate = \DateTimeImmutable::createFromFormat('!Y-m-d', (string) ($answers['event_date'] ?? '')) ?: new \DateTimeImmutable('2027-12-12');
    $firstDay = $eventDate->modify('first day of this month');
    $startOffset = (int) $firstDay->format('N') - 1;
    $daysInMonth = (int) $firstDay->format('t');
    $gallery = ['gallery_one', 'gallery_two', 'gallery_three', 'gallery_four'];
    $hasGallery = collect($gallery)->contains(fn ($slot) => (bool) $photo($slot));
    $safeMap = function (string $key) use ($answers): ?string {
        $value = trim((string) ($answers[$key] ?? ''));
        if (!filter_var($value, FILTER_VALIDATE_URL)) return null;
        return in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?: ''), ['https', 'http'], true) ? $value : null;
    };
    $phone = preg_replace('/[^\d+]/', '', (string) ($answers['contact_phone'] ?? ''));
@endphp
<div class="wedding-invite rb-invite" id="wedding-invite" data-royal-theme="editorial">
    <nav class="invite-site-nav rb-site-nav" aria-label="Wedding invitation navigation">
        <a class="rb-site-monogram" href="#wedding-home" aria-label="Return to wedding invitation cover">
            <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span>
            <span class="rb-monogram-amp">&amp;</span>
            <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span>
        </a>
        <div class="rb-site-links">
            <a href="#wedding-date">The day</a>
            <a href="#wedding-ceremony">Venue</a>
            <a href="#wedding-details" data-nav-section="details" @if(!$visible('details')) hidden @endif>Dress code</a>
            <a href="#wedding-entourage" data-nav-section="entourage" @if(!$visible('entourage')) hidden @endif>Our people</a>
            <a href="#wedding-guests" data-nav-section="guests" @if(!$visible('guests')) hidden @endif>RSVP</a>
        </div>
        <details class="rb-site-mobile">
            <summary><i class="fa-solid fa-bars" aria-hidden="true"></i> Menu</summary>
            <div class="rb-site-mobile-links">
                <a href="#wedding-date">The day</a>
                <a href="#wedding-ceremony">Venue</a>
                <a href="#wedding-details" data-nav-section="details" @if(!$visible('details')) hidden @endif>Dress code</a>
                <a href="#wedding-story">Our story</a>
                <a href="#wedding-entourage" data-nav-section="entourage" @if(!$visible('entourage')) hidden @endif>Our people</a>
                <a href="#wedding-guests" data-nav-section="guests" @if(!$visible('guests')) hidden @endif>RSVP</a>
            </div>
        </details>
    </nav>

    <main class="rb-editorial-page">
        <section class="rb-panel rb-panel-hero rb-light" id="wedding-home" data-preview-section="couple">
            <div class="rb-hero-heading rb-reveal">
                <span class="rb-script-small">The</span>
                <h1>WEDDING <em>day</em></h1>
                <span class="rb-eyebrow rb-hero-eyebrow">AN INVITATION TO OUR FOREVER</span>
            </div>
            <figure class="rb-image-frame rb-hero-image rb-reveal" data-photo-slot="hero">
                @if($photo('hero'))
                    <img src="{{ $photo('hero') }}" alt="Couple's wedding portrait" data-slot-img="hero" fetchpriority="high">
                @else
                    <div class="rb-image-placeholder rb-placeholder-hero">
                        <img src="{{ asset($assetBase . 'grand-doors.webp') }}" alt="" loading="eager">
                        <span>YOUR FAVORITE PORTRAIT</span>
                    </div>
                @endif
                @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="hero"><i class="fa-solid fa-camera" aria-hidden="true"></i> Cover photo</button>@endif
            </figure>
            <p class="rb-couple-names rb-reveal">
                <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span>
                <span class="rb-couple-heart" aria-hidden="true">♥</span>
                <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span>
            </p>
            <p class="rb-hero-message rb-reveal" data-field="host_message" data-fallback="Together with our families, we would love for you to celebrate our wedding day.">{{ $display('host_message','Together with our families, we would love for you to celebrate our wedding day.') }}</p>
            <p class="rb-hero-date rb-reveal" data-field="event_date" data-fallback="December 12, 2027">{{ $display('event_date','December 12, 2027') }}</p>
            <a href="#wedding-message" class="rb-scroll-cue"><i class="fa-solid fa-arrow-down-long" aria-hidden="true"></i> Discover our day</a>
        </section>

        <div class="rb-art-panel rb-doors-panel" role="img" aria-label="Elegant burgundy double doors, opening into a celebration"></div>

        <section class="rb-panel rb-message-panel rb-light" id="wedding-message" data-preview-section="couple">
            <div class="rb-invitation-card rb-reveal">
                <span class="rb-eyebrow">WITH OUR DEEPEST LOVE</span>
                <p class="rb-message-script">Two hearts. One beautiful beginning.</p>
                <p class="rb-message-copy" data-field="hero_quote" data-fallback="It would mean the world to us to have you with us as we begin this new chapter together.">{{ $display('hero_quote','It would mean the world to us to have you with us as we begin this new chapter together.') }}</p>
                <span class="rb-ornament-dot" aria-hidden="true">✦</span>
            </div>
        </section>

        <section class="rb-panel rb-date-panel rb-light" id="wedding-date" data-preview-section="ceremony">
            <span class="rb-eyebrow">SAVE THE DATE</span>
            <h2 class="rb-script-title" data-rb-calendar-month>{{ $eventDate->format('F') }}</h2>
            <span class="rb-date-year" data-rb-calendar-year>{{ $eventDate->format('Y') }}</span>
            <div class="rb-calendar rb-reveal" data-rb-calendar data-date="{{ $eventDate->format('Y-m-d') }}" aria-label="Calendar with the wedding date highlighted">
                <div class="rb-calendar-weekdays">
                    @foreach(['M','T','W','T','F','S','S'] as $weekday)<span>{{ $weekday }}</span>@endforeach
                </div>
                <div class="rb-calendar-days" data-rb-calendar-days>
                    @for($cell=0; $cell<$startOffset; $cell++)<span class="rb-cal-empty" aria-hidden="true"></span>@endfor
                    @for($day=1; $day<=$daysInMonth; $day++)
                        <span @class(['rb-day','rb-day-selected' => $day === (int) $eventDate->format('j')])>
                            {{ $day }}
                        </span>
                    @endfor
                </div>
            </div>
            <img class="rb-botanical rb-reveal" src="{{ asset($assetBase.'botanical-engraving.webp') }}" alt="" width="390" height="220" loading="lazy">
        </section>

        <section class="rb-panel rb-timing-panel rb-wine" id="wedding-program" data-preview-section="program" @if(!$visible('program')) hidden @endif>
            <span class="rb-eyebrow">A DAY TO REMEMBER</span>
            <h2 class="rb-script-title">Our timing</h2>
            <div class="rb-timing-grid rb-reveal">
                <div class="rb-timing-item">
                    <strong data-field="event_time" data-fallback="3:00 PM">{{ $display('event_time','3:00 PM') }}</strong><span>CEREMONY</span>
                </div>
                <div class="rb-timing-item">
                    <strong data-field="reception_time" data-fallback="6:00 PM">{{ $display('reception_time','6:00 PM') }}</strong><span>RECEPTION</span>
                </div>
                <div class="rb-timing-item">
                    <strong data-field="first_dance_time" data-fallback="7:30 PM">{{ $display('first_dance_time','7:30 PM') }}</strong><span>FIRST DANCE</span>
                </div>
                <div class="rb-timing-item">
                    <strong data-field="after_party_time" data-fallback="9:00 PM">{{ $display('after_party_time','9:00 PM') }}</strong><span>CELEBRATION</span>
                </div>
            </div>
            <div class="rb-program-notes rb-reveal">
                <div><span class="rb-eyebrow">ORDER OF EVENTS</span>
                    <p class="rb-preserve" data-field="event_schedule" data-fallback="Ceremony · Cocktail hour · Dinner · Dancing">{{ $display('event_schedule','Ceremony · Cocktail hour · Dinner · Dancing') }}</p>
                </div>
                <div><span class="rb-eyebrow">CEREMONY & RECEPTION</span>
                    <p class="rb-preserve" data-field="ceremony_program" data-fallback="Processional · Vows · Exchange of rings">{{ $display('ceremony_program','Processional · Vows · Exchange of rings') }}</p>
                    <p class="rb-preserve" data-field="reception_program" data-fallback="Dinner · Speeches · First dance">{{ $display('reception_program','Dinner · Speeches · First dance') }}</p>
                </div>
            </div>
            <img class="rb-timing-art" src="{{ asset($assetBase.'botanical-engraving.webp') }}" alt="" loading="lazy">
            @include('weddings.partials.extras', ['group' => 'program'])
        </section>

        <section class="rb-panel rb-venue-panel rb-light" id="wedding-ceremony" data-preview-section="ceremony">
            <span class="rb-eyebrow">WHERE OUR FOREVER BEGINS</span>
            <h2 class="rb-script-title">The ceremony</h2>
            <figure class="rb-image-frame rb-venue-image rb-reveal" data-photo-slot="venue_ceremony">
                @if($photo('venue_ceremony'))
                    <img src="{{ $photo('venue_ceremony') }}" alt="Wedding ceremony venue" loading="lazy" data-slot-img="venue_ceremony">
                @else
                    <div class="rb-image-placeholder rb-placeholder-venue"><img src="{{ asset($assetBase.'grand-doors.webp') }}" alt="" loading="lazy"><span>CEREMONY LOCATION</span></div>
                @endif
                @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="venue_ceremony"><i class="fa-solid fa-camera" aria-hidden="true"></i> Ceremony photo</button>@endif
            </figure>
            <h3 class="rb-location-name" data-field="ceremony_venue" data-fallback="Our ceremony venue">{{ $display('ceremony_venue','Our ceremony venue') }}</h3>
            <p class="rb-location-address rb-preserve" data-field="ceremony_address" data-fallback="Ceremony address">{{ $display('ceremony_address','Ceremony address') }}</p>
            <p class="rb-venue-time" data-field="event_time" data-fallback="3:00 PM">{{ $display('event_time','3:00 PM') }}</p>
            @if($safeMap('ceremony_map_url'))<a href="{{ $safeMap('ceremony_map_url') }}" class="rb-venue-link" target="_blank" rel="noopener noreferrer">View on map <i class="fa-solid fa-location-arrow" aria-hidden="true"></i></a>@endif
            @include('weddings.partials.extras', ['group' => 'ceremony'])
        </section>

        <section class="rb-panel rb-reception-panel rb-wine" id="wedding-reception" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
            <span class="rb-eyebrow">DINNER, DANCING & A LITTLE MAGIC</span>
            <h2 class="rb-script-title">The reception</h2>
            <figure class="rb-image-frame rb-venue-image rb-reveal" data-photo-slot="venue_reception">
                @if($photo('venue_reception'))
                    <img src="{{ $photo('venue_reception') }}" alt="Wedding reception location" loading="lazy" data-slot-img="venue_reception">
                @else
                    <div class="rb-image-placeholder rb-placeholder-venue rb-placeholder-reception"><img src="{{ asset($assetBase.'grand-doors.webp') }}" alt="" loading="lazy"><span>RECEPTION LOCATION</span></div>
                @endif
                @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="venue_reception"><i class="fa-solid fa-camera" aria-hidden="true"></i> Reception photo</button>@endif
            </figure>
            <h3 class="rb-location-name" data-field="reception_venue" data-fallback="Our reception venue">{{ $display('reception_venue','Our reception venue') }}</h3>
            <p class="rb-location-address rb-preserve" data-field="reception_address" data-fallback="Reception venue address">{{ $display('reception_address','Reception venue address') }}</p>
            <p class="rb-venue-time" data-field="reception_time" data-fallback="6:00 PM">{{ $display('reception_time','6:00 PM') }}</p>
            @if($safeMap('reception_map_url'))<a href="{{ $safeMap('reception_map_url') }}" class="rb-venue-link rb-venue-link-light" target="_blank" rel="noopener noreferrer">View on map <i class="fa-solid fa-location-arrow" aria-hidden="true"></i></a>@endif
            @include('weddings.partials.extras', ['group' => 'reception'])
        </section>

        <section class="rb-panel rb-dress-panel rb-light" id="wedding-details" data-preview-section="details" @if(!$visible('details')) hidden @endif>
            <span class="rb-eyebrow">A LITTLE NOTE FOR OUR GUESTS</span>
            <h2 class="rb-script-title">Dress code</h2>
            <p class="rb-body-copy" data-field="dress_code" data-fallback="We would love for you to wear your favorite formal or semi-formal attire.">{{ $display('dress_code','We would love for you to wear your favorite formal or semi-formal attire.') }}</p>
            <img class="rb-swatches rb-reveal" src="{{ asset($assetBase.'dress-swatches.webp') }}" width="520" height="180" alt="Three painterly colour swatches: burgundy, champagne and taupe" loading="lazy">
            <p class="rb-color-motif" data-field="color_motif" data-fallback="Burgundy · Champagne · Soft taupe">{{ $display('color_motif','Burgundy · Champagne · Soft taupe') }}</p>
            <p class="rb-preserve rb-extra-note" data-field="motif_notes" data-fallback="">{{ $display('motif_notes') }}</p>
            <img class="rb-mini-engraving" src="{{ asset($assetBase.'botanical-engraving.webp') }}" alt="" loading="lazy">
        </section>

        <section class="rb-panel rb-story-panel rb-light" id="wedding-story" data-preview-section="couple">
            <span class="rb-eyebrow">THE CHAPTERS THAT BROUGHT US HERE</span>
            <h2 class="rb-script-title">Our love story</h2>
            <p class="rb-body-copy rb-preserve" data-field="couple_story" data-fallback="Every great love story has a beginning. This is ours.">{{ $display('couple_story','Every great love story has a beginning. This is ours.') }}</p>
            <div class="rb-story-chapters">
                @foreach(['story_one' => ['01','The beginning','love_story_start','Where our paths first crossed.'], 'story_two' => ['02','Every little moment','love_story_growing','The memories that brought us closer.'], 'story_three' => ['03','The promise','love_story_proposal','The moment we chose forever.']] as $slot => [$number,$title,$key,$fallback])
                    <article class="rb-story-card rb-reveal">
                        <span class="rb-chapter-number">{{ $number }}</span>
                        @if($isPreview || $photo($slot))
                            <figure class="rb-image-frame rb-story-image" data-photo-slot="{{ $slot }}">
                                @if($photo($slot))
                                    <img src="{{ $photo($slot) }}" alt="Our love story: {{ $title }}" loading="lazy" data-slot-img="{{ $slot }}">
                                @else
                                    <div class="rb-image-placeholder rb-placeholder-photo"><span>PHOTO OF OUR STORY</span></div>
                                @endif
                                @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                            </figure>
                        @endif
                        <h3>{{ $title }}</h3>
                        <p class="rb-preserve" data-field="{{ $key }}" data-fallback="{{ $fallback }}">{{ $display($key, $fallback) }}</p>
                    </article>
                @endforeach
            </div>
            @foreach(['portrait_one','portrait_two'] as $slot)
                @if($isPreview || $photo($slot))
                    <figure class="rb-image-frame rb-secondary-portrait rb-reveal" data-photo-slot="{{ $slot }}">
                        @if($photo($slot))
                            <img src="{{ $photo($slot) }}" alt="A favorite couple portrait" loading="lazy" data-slot-img="{{ $slot }}">
                        @else
                            <div class="rb-image-placeholder rb-placeholder-photo"><span>ANOTHER FAVORITE MEMORY</span></div>
                        @endif
                        @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add portrait</button>@endif
                    </figure>
                @endif
            @endforeach
        </section>

        <section class="rb-panel rb-entourage-panel rb-light" id="wedding-entourage" data-preview-section="entourage" @if(!$visible('entourage')) hidden @endif>
            <span class="rb-eyebrow">THE PEOPLE WHO MADE US WHO WE ARE</span>
            <h2 class="rb-script-title">Our loved ones</h2>
            <p class="rb-body-copy rb-preserve" data-field="parents_message" data-fallback="We are forever grateful for the love and support of our families and closest friends.">{{ $display('parents_message','We are forever grateful for the love and support of our families and closest friends.') }}</p>
            <div class="rb-people-grid">
                @foreach([
                    ['Parents of the bride','bride_parents'],['Parents of the groom','groom_parents'],
                    ['Principal sponsors · Ninong & Ninang','principal_sponsors'],
                    ['Maid of honour','maid_of_honor'],['Best man','best_man'],
                    ['Bridesmaids','bridesmaids'],['Groomsmen','groomsmen'],
                    ['Secondary sponsors','secondary_sponsors'],
                    ['Candle sponsors','candle_sponsors'],['Veil & cord sponsors','veil_sponsors'],
                    ['Little bearers & flower girls','flower_girls'],['Celebrant / officiant','officiant_name'],
                ] as [$label,$key])
                    <div class="rb-person-entry rb-reveal">
                        <span class="rb-eyebrow">{{ $label }}</span>
                        <p class="rb-preserve" data-field="{{ $key }}" data-fallback="With love">{{ $display($key,'With love') }}</p>
                    </div>
                @endforeach
            </div>
            @include('weddings.partials.extras', ['group' => 'entourage'])
            <img class="rb-botanical rb-people-botanical" src="{{ asset($assetBase.'botanical-engraving.webp') }}" alt="" loading="lazy">
        </section>

        @if($isPreview || $hasGallery)
            <section class="rb-panel rb-gallery-panel rb-light" id="wedding-moments" data-preview-section="couple">
                <span class="rb-eyebrow">A FEW MEMORIES WE HOLD CLOSE</span>
                <h2 class="rb-script-title">Our gallery</h2>
                <div class="rb-gallery-grid">
                    @foreach($gallery as $slot)
                        @if($isPreview || $photo($slot))
                            <figure class="rb-image-frame rb-gallery-image rb-reveal" data-photo-slot="{{ $slot }}">
                                @if($photo($slot))
                                    <img src="{{ $photo($slot) }}" alt="A favorite memory of the couple" loading="lazy" data-slot-img="{{ $slot }}">
                                @else
                                    <div class="rb-image-placeholder rb-placeholder-photo"><span>YOUR FAVORITE MEMORY</span></div>
                                @endif
                                @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                            </figure>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <section class="rb-panel rb-gifts-panel rb-light" id="wedding-gifts" data-preview-section="details" @if(!$visible('details')) hidden @endif>
            <span class="rb-eyebrow">FROM OUR HEARTS TO YOURS</span>
            <h2 class="rb-script-title">A note on gifts</h2>
            <p class="rb-body-copy rb-preserve" data-field="gift_message" data-fallback="Your presence at our wedding is the most beautiful gift we could ask for.">{{ $display('gift_message','Your presence at our wedding is the most beautiful gift we could ask for.') }}</p>
            <p class="rb-preserve rb-extra-note" data-field="other_reminders" data-fallback="">{{ $display('other_reminders') }}</p>
            <img class="rb-mini-engraving" src="{{ asset($assetBase.'botanical-engraving.webp') }}" alt="" loading="lazy">
            @include('weddings.partials.extras', ['group' => 'details'])
        </section>

        <section class="rb-panel rb-rsvp-panel rb-wine" id="wedding-guests" data-preview-section="guests" @if(!$visible('guests')) hidden @endif>
            <span class="rb-eyebrow">WE WOULD LOVE TO CELEBRATE WITH YOU</span>
            <h2 class="rb-script-title">Kindly respond</h2>
            <p class="rb-body-copy rb-preserve" data-field="rsvp_message" data-fallback="We can't wait to have you with us. Please let us know if you can join us.">{{ $display('rsvp_message','We can’t wait to have you with us. Please let us know if you can join us.') }}</p>
            <p class="rb-rsvp-by">PLEASE REPLY BY <strong data-field="rsvp_deadline" data-fallback="November 20, 2027">{{ $display('rsvp_deadline','November 20, 2027') }}</strong></p>
            <a href="#wedding-contacts" class="rb-rsvp-cta">View RSVP contact <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            <p class="rb-rsvp-notice">Online RSVP collection is being developed. For now, please contact the couple or wedding coordinator directly.</p>
            @include('weddings.partials.extras', ['group' => 'guests'])
        </section>

        <section class="rb-panel rb-contacts-panel rb-light" id="wedding-contacts" data-preview-section="guests" @if(!$visible('guests')) hidden @endif>
            <span class="rb-eyebrow">QUESTIONS ABOUT THE DAY?</span>
            <h2 class="rb-script-title">Contacts</h2>
            <p class="rb-body-copy">For anything we can help with, please reach out to our wedding contact below.</p>
            <div class="rb-contact-envelope rb-reveal">
                <img src="{{ asset($assetBase.'envelope-back.webp') }}" alt="" loading="lazy">
                <div class="rb-contact-letter">
                    <span>WITH LOVE</span>
                    <strong data-field="contact_name" data-fallback="Your wedding contact">{{ $display('contact_name','Your wedding contact') }}</strong>
                    <p data-field="contact_phone" data-fallback="Add a contact number">{{ $display('contact_phone','Add a contact number') }}</p>
                </div>
                <img src="{{ asset($assetBase.'envelope-front.webp') }}" alt="" loading="lazy">
                <img class="rb-contact-seal" src="{{ asset($assetBase.'wax-seal.webp') }}" alt="" loading="lazy">
            </div>
            @if($phone)<a href="tel:{{ $phone }}" class="rb-contact-phone"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call wedding contact</a>@endif
            @if($isPreview || $photo('rsvp_portrait'))
                <figure class="rb-image-frame rb-closing-photo rb-reveal" data-photo-slot="rsvp_portrait">
                    @if($photo('rsvp_portrait'))
                        <img src="{{ $photo('rsvp_portrait') }}" alt="The couple, with love" loading="lazy" data-slot-img="rsvp_portrait">
                    @else
                        <div class="rb-image-placeholder rb-placeholder-photo"><span>ONE LAST FAVORITE PHOTO</span></div>
                    @endif
                    @if($isPreview)<button type="button" class="rb-image-edit" data-photo-edit="rsvp_portrait"><i class="fa-solid fa-camera" aria-hidden="true"></i> Add photo</button>@endif
                </figure>
            @endif
        </section>

        <footer class="rb-panel rb-final-panel rb-wine">
            <span class="rb-eyebrow">THE MOST BEAUTIFUL DAYS ARE SHARED</span>
            <p class="rb-final-script">See you there!</p>
            <p class="rb-final-names">
                <span data-field="bride_name" data-fallback="Amelia">{{ $display('bride_name','Amelia') }}</span>
                <span aria-hidden="true">&amp;</span>
                <span data-field="groom_name" data-fallback="Gabriel">{{ $display('groom_name','Gabriel') }}</span>
            </p>
            <img src="{{ asset($assetBase.'botanical-engraving.webp') }}" class="rb-final-flowers" alt="" loading="lazy">
            <a href="#wedding-home" class="rb-to-top">BACK TO THE BEGINNING <i class="fa-solid fa-arrow-up-long" aria-hidden="true"></i></a>
        </footer>
    </main>

    {{-- Real raster stationery layers. Displayed only on live visits, or when replayed from the builder. --}}
    <div class="rb-envelope-intro" data-envelope-intro data-envelope-autoplay="{{ ($isPreview || ($suppressEnvelopeIntro ?? false)) ? '0' : '1' }}" data-envelope-phase="closed" hidden role="dialog" aria-label="Opening your wedding invitation">
        <div class="rb-envelope-stage">
            <span class="rb-envelope-caption">A SPECIAL INVITATION FOR YOU</span>
            <div class="rb-envelope-object">
                <img class="rb-envelope-back" src="{{ asset($assetBase.'envelope-back.webp') }}" width="840" height="560" alt="">
                <img class="rb-envelope-letter" src="{{ asset($assetBase.'envelope-letter.webp') }}" width="560" height="670" alt="You're invited to celebrate a wedding">
                <img class="rb-envelope-front" src="{{ asset($assetBase.'envelope-front.webp') }}" width="840" height="560" alt="">
                <img class="rb-envelope-flap" src="{{ asset($assetBase.'envelope-flap.webp') }}" width="840" height="286" alt="">
                <img class="rb-envelope-wax" src="{{ asset($assetBase.'wax-seal.webp') }}" width="240" height="240" alt="">
            </div>
            <p class="rb-envelope-label">We want you there.</p>
            <button type="button" class="rb-envelope-skip" data-envelope-skip>Skip introduction <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </div>
</div>