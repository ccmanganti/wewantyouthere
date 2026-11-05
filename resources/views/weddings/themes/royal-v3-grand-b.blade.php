{{-- 09 GRAND: atmospheric reception photograph + overlaid couple portrait --}}
<section class="rbv-grand rbv-venue-photo" id="venue-photo-story" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
    <figure class="rbv-photo rbv-wide-photo" data-photo-slot="venue_reception">
        @if($image('venue_reception','gallery-venue.webp','grand-doors.webp'))<img src="{{ $image('venue_reception','gallery-venue.webp','grand-doors.webp') }}" alt="Reception venue" data-slot-img="venue_reception" loading="lazy">@else<div class="rbv-photo-empty">YOUR RECEPTION VENUE</div>@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="venue_reception"><i class="fa-solid fa-camera"></i> Reception photo</button>@endif
    </figure>
    <div class="rbv-photo-caption"><span class="rbv-eyebrow">A PLACE FOR OUR PROMISES</span>
        <h2 class="rbv-title">Where it all comes together.</h2>
        <p>THE SETTING IS BEAUTIFUL, BUT THE PEOPLE MAKE IT UNFORGETTABLE.</p>
    </div>
</section>

{{-- 10 INFO: actual ceremony/reception map links and embedded locations --}}
<section class="rbv-info rbv-map-section" id="location-map" data-preview-section="reception" @if(!$visible('reception')) hidden @endif>
    <div class="rbv-inner"><span class="rbv-eyebrow">SO YOU CAN FIND US EASILY</span>
        <h2 class="rbv-title" data-field="map_heading">{{ $copy('map_heading','Find your way.') }}</h2>
        <p class="rbv-copy" data-field="map_intro">{{ $copy('map_intro','We have saved you a spot. Here is a little help getting there.') }}</p>
        <div class="rbv-map-tabs" role="group" aria-label="Select venue">
            <button type="button" data-map-choice="ceremony" aria-pressed="true" class="is-active">Ceremony</button>
            <button type="button" data-map-choice="reception" aria-pressed="false">Reception</button>
        </div>
        <div class="rbv-map">
            @php $mapAddress = trim((string)($answers['ceremony_address'] ?? $answers['venue_address'] ?? '')); @endphp
            @if($mapAddress || $isPreview || $isSample)
                <iframe id="rbv-event-map" loading="lazy" title="Wedding ceremony venue map"
                    src="https://maps.google.com/maps?q={{ rawurlencode($mapAddress ?: 'Tagaytay City Philippines') }}&amp;z=14&amp;output=embed"
                    referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            @else
                <div class="rbv-map-placeholder" id="rbv-map-placeholder">Location map will appear once a venue address is added.</div>
            @endif
        </div>
        <p id="rbv-map-destination">{{ $personal('ceremony_venue','Ceremony venue') }}</p>
        <a class="rbv-link" id="rbv-map-external" href="{{ $map('ceremony_map_url') ?: 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($mapAddress ?: 'Tagaytay City Philippines') }}" target="_blank" rel="noopener noreferrer">OPEN IN GOOGLE MAPS <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        @if($isPreview)<p class="rbv-hint">Maps update from the wedding ceremony and reception address fields.</p>@endif
    </div>
</section>

{{-- 11 GRAND: milestone timeline, no SVG or curving line intersection --}}
<section class="rbv-grand rbv-timeline" id="the-timeline" data-preview-section="program" @if(!$visible('program')) hidden @endif>
    <span class="rbv-eyebrow">THE FLOW OF OUR CELEBRATION</span>
    <h2 class="rbv-title" data-field="timeline_heading">{{ $copy('timeline_heading','Wedding day program') }}</h2>
    <ol class="rbv-timeline-steps" aria-label="Order of wedding day events">
        @foreach([
            ['01','GUEST ARRIVAL','guest_arrival_time','2:30 PM','guest_arrival_note','Welcome drinks'],
            ['02','CEREMONY','event_time','3:00 PM','ceremony_timeline_note','The ceremony begins'],
            ['03','RECEPTION','reception_time','6:00 PM','reception_timeline_note','Dinner and speeches'],
            ['04','CELEBRATION','celebration_time','9:00 PM','celebration_timeline_note','Dance the night away']
        ] as [$number,$title,$timeKey,$time,$noteKey,$note])
        @if($isSample || $isPreview || filled($answers[$timeKey] ?? null) || filled($answers[$noteKey] ?? null))
        <li class="rbv-timeline-step" data-program-time="{{ $timeKey }}" data-program-note="{{ $noteKey }}"
            @if(!$isSample && !filled($answers[$timeKey] ?? null) && !filled($answers[$noteKey] ?? null)) hidden @endif>
            <span class="rbv-timeline-dot" aria-hidden="true"></span>
            <div class="rbv-timeline-content">
                <span class="rbv-eyebrow">{{ $number }} / THE MOMENT</span>
                <h3>{{ $title }}</h3>
                <strong data-field="{{ $timeKey }}">{{ $personal($timeKey,$time) }}</strong>
                <p data-field="{{ $noteKey }}">{{ $copy($noteKey,$note) }}</p>
            </div>
        </li>
        @endif
        @endforeach
    </ol>
    <p class="rbv-quote">Until the last dance.</p>
    <img class="rbv-botanical rbv-timeline-art" src="{{ $art('botanical.webp','botanical-engraving.webp') }}" alt="" loading="lazy">
    @include('weddings.partials.extras', ['group' => 'program'])
</section>

{{-- 12 INFO: full program for guests --}}
<section class="rbv-info" id="program-details" data-preview-section="program" @if(!$visible('program')) hidden @endif>
    <div class="rbv-inner"><span class="rbv-eyebrow">A LITTLE GUIDE TO OUR DAY</span>
        <h2 class="rbv-title" data-field="program_details_heading">{{ $copy('program_details_heading','What to expect') }}</h2>
        <p class="rbv-copy rbv-schedule-text" data-field="event_schedule" data-optional-field-row="event_schedule"
            @if(blank($answers['event_schedule'] ?? null)) hidden @endif>{{ $personal('event_schedule', '') }}</p>
        <div class="rbv-program-rows">
            @foreach([
                ['01','program_step_one','Arrive and settle in before the ceremony.'],
                ['02','program_step_two','Join us as we exchange our vows.'],
                ['03','program_step_three','Share a meal, a toast, and a few stories.'],
                ['04','program_step_four','Celebrate together on the dance floor.']
            ] as [$num,$key,$default])
                @if($isSample || $isPreview || filled($answers[$key] ?? null))
                <div data-optional-field-row="{{ $key }}" @if(!$isSample && blank($answers[$key] ?? null)) hidden @endif>
                    <span>{{ $num }}</span><p data-field="{{ $key }}">{{ $isSample ? $copy($key,$default) : $personal($key, '') }}</p>
                </div>
                @endif
            @endforeach
        </div>
        @foreach(['ceremony_program','reception_program'] as $key)
            @if($isSample || $isPreview || filled($answers[$key] ?? null))
                <p class="rbv-copy rbv-small" data-field="{{ $key }}" data-optional-field-row="{{ $key }}"
                    @if(!$isSample && blank($answers[$key] ?? null)) hidden @endif>{{ $personal($key,'') }}</p>
            @endif
        @endforeach
    </div>
</section>

@php
    $entourageFields = [
        'principal_sponsors','maid_of_honor','matron_of_honor','best_man',
        'bridesmaids','groomsmen','secondary_sponsors','flower_girls',
        'ring_bearer','coin_bearer','bible_bearer','candle_sponsors',
        'veil_sponsors','cord_sponsors','officiant_name'
    ];
    $hasEntourage = collect($entourageFields)->contains(fn ($key) => filled($answers[$key] ?? null));
@endphp
{{-- 13 GRAND: couple collage acknowledging family and friends --}}
<section class="rbv-grand rbv-family-art" id="people-art" data-preview-section="entourage" @if(!$visible('entourage') || (!$isSample && !$isPreview && !$hasEntourage)) hidden @endif>
    <span class="rbv-eyebrow">THE PEOPLE WHO HAVE LOVED US ALL ALONG</span>
    <h2 class="rbv-title" data-field="people_art_heading">{{ $copy('people_art_heading','In good company.') }}</h2>
    <div class="rbv-family-collage">
        @foreach([['guest_art_portrait','gallery-couple-walking.webp'],['story_one','gallery-couple-garden.webp'],['story_two','gallery-couple-portrait.webp']] as [$slot,$sample])
            <figure class="rbv-photo" data-photo-slot="{{ $slot }}">
                @if($image($slot,$sample,'grand-doors.webp'))<img src="{{ $image($slot,$sample,'grand-doors.webp') }}" data-slot-img="{{ $slot }}" alt="A romantic couple and loved ones" loading="lazy">@else<div class="rbv-photo-empty">YOUR PHOTO</div>@endif
                @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera"></i></button>@endif
            </figure>
        @endforeach
    </div>
    <p class="rbv-quote" data-field="people_quote">{{ $copy('people_quote','“Our forever is sweeter with you beside us.”') }}</p>
</section>

{{-- 14 INFO: every wedding role from the shared event questions --}}
<section class="rbv-info" id="our-people" data-preview-section="entourage" @if(!$visible('entourage') || (!$isSample && !$isPreview && !$hasEntourage)) hidden @endif>
    <div class="rbv-inner rbv-inner-wide"><span class="rbv-eyebrow">WITH THE BLESSINGS OF OUR FAMILIES</span>
        <h2 class="rbv-title" data-field="entourage_heading">{{ $copy('entourage_heading','Our dearest people.') }}</h2>
        <p class="rbv-copy" data-field="entourage_intro">{{ $copy('entourage_intro','We are surrounded by so much love, and these are the people standing beside us on our special day.') }}</p>
        <div class="rbv-entourage">
        @foreach([
            ['PRINCIPAL SPONSORS · NINONG & NINANG','principal_sponsors','Our beloved sponsors'],
            ['MAID / MATRON OF HONOR','maid_of_honor','Maid of Honor'],
            ['BEST MAN','best_man','Best Man'],
            ['BRIDESMAIDS','bridesmaids','Our bridesmaids'],
            ['GROOMSMEN','groomsmen','Our groomsmen'],
            ['SECONDARY SPONSORS','secondary_sponsors','Our sponsors'],
            ['FLOWER GIRLS','flower_girls','Flower girls'],
            ['RING BEARER','ring_bearer','Ring bearer'],
            ['COIN BEARER','coin_bearer','Coin bearer'],
            ['BIBLE BEARER','bible_bearer','Bible bearer'],
            ['CANDLE SPONSORS','candle_sponsors','Candle sponsors'],
            ['VEIL SPONSORS','veil_sponsors','Veil sponsors'],
            ['CORD SPONSORS','cord_sponsors','Cord sponsors'],
            ['OFFICIANT','officiant_name','Our officiant']
        ] as [$role,$key,$fallback])
            @if($isPreview || $isSample || filled($answers[$key] ?? null))
            <div class="rbv-entourage-person" data-optional-field-row="{{ $key }}"
                @if(!$isSample && blank($answers[$key] ?? null)) hidden @endif><span class="rbv-eyebrow">{{ $role }}</span>
                <p data-field="{{ $key }}">{{ $personal($key,$fallback) }}</p>
            </div>
            @endif
        @endforeach
        </div>
        @include('weddings.partials.extras', ['group' => 'entourage'])
    </div>
</section>

{{-- 15 GRAND: painterly dress-code art --}}
<section class="rbv-grand rbv-dress-art" id="dress-art" data-preview-section="details" @if(!$visible('details')) hidden @endif>
    <span class="rbv-eyebrow">WEAR SOMETHING LOVELY</span>
    <h2 class="rbv-title" data-field="dress_heading">{{ $copy('dress_heading','Dress code') }}</h2>
    <span class="rbv-eyebrow">THE COLOURS OF OUR CELEBRATION</span>
    <img class="rbv-swatches" src="{{ $art('swatches.webp','dress-swatches.webp') }}" alt="Painterly wedding palette" loading="lazy">
    <p data-field="color_motif">{{ $personal('color_motif','Burgundy · Champagne · Taupe') }}</p>
    <img class="rbv-botanical rbv-small-botanical" src="{{ $art('botanical.webp','botanical-engraving.webp') }}" alt="" loading="lazy">
</section>

{{-- 16 INFO: attire, gift and other guest notes --}}
<section class="rbv-info" id="dress-information" data-preview-section="details" @if(!$visible('details')) hidden @endif>
    <div class="rbv-inner"><span class="rbv-eyebrow">THE LITTLE DETAILS</span>
        <h2 class="rbv-title" data-field="dress_information_heading">{{ $copy('dress_information_heading','A few lovely notes') }}</h2>
        <div class="rbv-info-columns">
            <article><span class="rbv-eyebrow">ATTIRE</span><h3>Dress code</h3><p data-field="dress_code">{{ $personal('dress_code','Formal or semi-formal attire is warmly encouraged.') }}</p><p data-field="motif_notes">{{ $personal('motif_notes','Please wear something comfortable for a night of dancing.') }}</p></article>
            <article><span class="rbv-eyebrow">GIFTS</span><h3>Note on gifts</h3><p data-field="gift_message">{{ $personal('gift_message','Your presence is the greatest gift of all.') }}</p><p data-field="gift_instructions">{{ $personal('gift_instructions','') }}</p></article>
        </div>
        @include('weddings.partials.extras', ['group' => 'details'])
    </div>
</section>
