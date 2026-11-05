{{-- 17 GRAND: seven independently replaceable photo memories --}}
<section class="rbv-grand rbv-gallery" id="gallery-memories" data-preview-section="couple">
    <span class="rbv-eyebrow">EVERY PHOTO HOLDS A LITTLE PIECE OF OUR STORY</span>
    <h2 class="rbv-title" data-field="gallery_heading">{{ $copy('gallery_heading','Our favorite memories.') }}</h2>
    <div class="rbv-gallery-grid">
        @foreach([
            ['gallery_one','gallery-couple-walking.webp','photo_caption_one','Hand in hand, wherever life takes us.'],
            ['gallery_two','gallery-couple-portrait.webp','photo_caption_two','The moments we never forget.'],
            ['gallery_three','gallery-couple-close.webp','photo_caption_three','Close to you.'],
            ['gallery_four','gallery-couple-sparklers.webp','photo_caption_four','A night full of light.'],
            ['gallery_five','couple_scene.jpg',null,'Our golden hour.'],
            ['gallery_six','gallery-couple-sunset.webp',null,'Together, always.'],
            ['gallery_seven','gallery-couple-smiling.webp',null,'A beautiful memory.'],
        ] as [$slot,$sample,$captionKey,$fallbackCaption])
            @if($isPreview || $isSample || isset($photoUrls[$slot]))
            <figure class="rbv-photo rbv-gallery-item" data-photo-slot="{{ $slot }}">
                @php $src = $image($slot,$sample,'grand-doors.webp'); @endphp
                @if($src)
                <button type="button" class="rbv-gallery-view" data-rbv-gallery aria-label="View photo larger">
                    <img src="{{ $src }}" data-slot-img="{{ $slot }}" loading="lazy" alt="Wedding couple photograph">
                </button>
                @else<div class="rbv-photo-empty">YOUR MEMORY</div>@endif
                @if($captionKey)<figcaption data-field="{{ $captionKey }}">{{ $copy($captionKey,$fallbackCaption) }}</figcaption>@endif
                @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="{{ $slot }}"><i class="fa-solid fa-camera"></i> Replace</button>@endif
            </figure>
            @endif
        @endforeach
    </div>
    <p class="rbv-gallery-hint">Tap a photo to view it larger.</p>
    <blockquote class="rbv-quote" data-field="gallery_quote">{{ $copy('gallery_quote','Life is a collection of moments. We are grateful for every one of ours.') }}</blockquote>
</section>

{{-- 18 INFO: guest policy, parking, contact and other helpful specifics --}}
<section class="rbv-info" id="guest-details" data-preview-section="guests" @if(!$visible('guests')) hidden @endif>
    <div class="rbv-inner"><span class="rbv-eyebrow">A FEW MORE THINGS TO KNOW</span>
        <h2 class="rbv-title" data-field="guest_details_heading">{{ $copy('guest_details_heading','Little reminders.') }}</h2>
        <div class="rbv-reminders">
            @foreach([
                ['THE CEREMONY','Unplugged vows','unplugged_note','We kindly ask you to be fully present during our vows.'],
                ['PARKING','Getting settled','parking_instructions','Parking is available near the venue.'],
                ['LITTLE GUESTS','Children & plus ones','children_policy','Please refer to your personal invitation for the seats reserved.']
            ] as [$eyebrow,$title,$key,$default])
            <article><span class="rbv-eyebrow">{{ $eyebrow }}</span><h3>{{ $title }}</h3><p data-field="{{ $key }}">{{ $personal($key,$default) }}</p></article>
            @endforeach
        </div>
        <p class="rbv-copy rbv-small" data-field="other_reminders">{{ $personal('other_reminders','') }}</p>
        <p class="rbv-copy rbv-small" data-field="accommodation_details">{{ $personal('accommodation_details','') }}</p>
    </div>
</section>

{{-- 19 GRAND: emotional closing with user-replaceable photograph --}}
<section class="rbv-grand rbv-closing" id="our-moment" data-preview-section="couple">
    <figure class="rbv-closing-background" data-photo-slot="closing_portrait">
        @if($image('closing_portrait','closing-photo.webp','grand-doors.webp'))
            <img src="{{ $image('closing_portrait','closing-photo.webp','grand-doors.webp') }}" data-slot-img="closing_portrait" alt="A beautiful evening together" loading="lazy">
        @else<div class="rbv-photo-empty">OUR FOREVER BEGINS HERE</div>@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="closing_portrait"><i class="fa-solid fa-camera"></i> Closing photo</button>@endif
    </figure>
    <figure class="rbv-photo rbv-quote-portrait" data-photo-slot="quote_portrait">
        @if($image('quote_portrait','gallery-couple-garden.webp','grand-doors.webp'))<img src="{{ $image('quote_portrait','gallery-couple-garden.webp','grand-doors.webp') }}" data-slot-img="quote_portrait" alt="An artistic couple photograph" loading="lazy">@else<div class="rbv-photo-empty">LOVE AND GRATITUDE</div>@endif
        @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="quote_portrait"><i class="fa-solid fa-camera"></i> Replace photo</button>@endif
    </figure>
    <div class="rbv-closing-copy"><span class="rbv-eyebrow">WITH LOVE &amp; GRATITUDE</span>
        <h2 data-field="closing_quote">{{ $copy('closing_quote',"We can't wait to see you.") }}</h2>
        <p data-field="closing_message">{{ $copy('closing_message','Until the last dance.') }}</p>
    </div>
</section>

{{-- 20 INFO: real RSVP for a published invitation; no fake server submission --}}
<section class="rbv-info rbv-rsvp" id="rsvp" data-preview-section="guests" @if(!$visible('guests')) hidden @endif>
    <div class="rbv-inner">
        <span class="rbv-eyebrow">A KIND RESPONSE IS REQUESTED</span>
        <h2 class="rbv-title" data-field="rsvp_heading">{{ $copy('rsvp_heading','Kindly RSVP') }}</h2>
        <p class="rbv-copy" data-field="rsvp_message">{{ $copy('rsvp_message','We would be delighted to celebrate with you. Please let us know if you can join us.') }}</p>
        <p class="rbv-rsvp-deadline">PLEASE RESPOND BY <strong data-field="rsvp_deadline">{{ $personal('rsvp_deadline','November 20, 2027') }}</strong></p>

        @if(session('rsvp_success') && $isPublishedSite)
            <div class="rbv-rsvp-success" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('rsvp_success') }}</div>
        @elseif($isPreview)
            {{-- The builder is already a form: never nest an RSVP form in it. --}}
            <div class="rbv-rsvp-form rbv-rsvp-sample" aria-label="Preview of guest RSVP form">
                <label><span>Your full name *</span><input disabled placeholder="Guest name" type="text"></label>
                <fieldset disabled><legend>Will you be joining us? *</legend><label class="rbv-radio"><input type="radio" checked> Joyfully accepts</label><label class="rbv-radio"><input type="radio"> Regretfully declines</label></fieldset>
                <label><span>Number of guests *</span><select disabled><option>1 guest</option></select></label>
                <label><span>A message for the couple</span><textarea disabled rows="2" placeholder="A little note or blessing…"></textarea></label>
                <button type="button" class="rbv-rsvp-button" disabled>RSVP FORM PREVIEW</button>
                <p class="rbv-rsvp-note">This form will collect responses on your published invitation.</p>
            </div>
        @elseif($isPublishedSite || $isSample)
            <form method="POST" action="{{ $isPublishedSite ? route('wedding.rsvp.store', $website->slug) : '#' }}"
                id="rbv-rsvp-form" class="rbv-rsvp-form" data-demo="{{ $isPublishedSite ? '0' : '1' }}">
                @csrf
                <label><span>Your full name *</span><input name="guest_name" id="rbv-guest-name" autocomplete="name"
                    type="text" required minlength="2" maxlength="120" value="{{ old('guest_name') }}" placeholder="How should we address you?"></label>
                <fieldset><legend>Will you be joining us? *</legend>
                    <label class="rbv-radio"><input type="radio" name="attendance" value="attending" required @checked(old('attendance')==='attending')> Joyfully accepts</label>
                    <label class="rbv-radio"><input type="radio" name="attendance" value="declined" @checked(old('attendance')==='declined')> Regretfully declines</label>
                </fieldset>
                <label data-rbv-party-wrap><span>Number of guests, including you *</span>
                    <select name="party_size" id="rbv-party-size" required>
                    @for($i=1;$i<=$guestMax;$i++)
                        <option value="{{ $i }}" @selected((int)old('party_size',1)===$i)>{{ $i }} {{ $i===1 ? 'guest' : 'guests' }}</option>
                    @endfor
                    </select>
                </label>
                <label><span>A message for the couple (optional)</span><textarea name="message" maxlength="500" rows="3" placeholder="A little note, wish, or blessing…">{{ old('message') }}</textarea></label>
                <label class="rbv-honeypot" aria-hidden="true" tabindex="-1">Leave this field empty <input type="text" name="website" autocomplete="off" tabindex="-1"></label>
                <button class="rbv-rsvp-button" type="submit">{{ $isPublishedSite ? 'SEND MY RSVP' : 'PREVIEW RESPONSE' }} <i class="fa-solid fa-arrow-right"></i></button>
                <p class="rbv-rsvp-feedback" id="rbv-rsvp-feedback" aria-live="polite"></p>
                @if($errors->any())<p class="rbv-rsvp-error" role="alert">{{ $errors->first() }}</p>@endif
                @unless($isPublishedSite)<p class="rbv-rsvp-note">Sample form — responses are not saved in the builder or design preview.</p>@endunless
            </form>
        @else
            <p class="rbv-copy">Please contact the couple for RSVP details.</p>
        @endif

        @if($isPreview || $isSample || isset($photoUrls['rsvp_portrait']))
        <figure class="rbv-photo rbv-rsvp-portrait" data-photo-slot="rsvp_portrait">
            @if($image('rsvp_portrait','gallery-couple-smiling.webp','grand-doors.webp'))<img src="{{ $image('rsvp_portrait','gallery-couple-smiling.webp','grand-doors.webp') }}" data-slot-img="rsvp_portrait" alt="A joyful couple photograph" loading="lazy">@else<div class="rbv-photo-empty">WITH LOVE</div>@endif
            @if($isPreview)<button type="button" class="rbv-photo-edit" data-photo-edit="rsvp_portrait"><i class="fa-solid fa-camera"></i> Add photo</button>@endif
        </figure>
        @endif
        <div class="rbv-contact"><span class="rbv-eyebrow">QUESTIONS ABOUT THE DAY?</span>
            <h3 data-field="rsvp_contact_heading">{{ $copy('rsvp_contact_heading',"We'd love to hear from you.") }}</h3>
            <p data-field="contact_name">{{ $personal('contact_name','Your wedding coordinator') }}</p>
            <p data-field="contact_phone">{{ $personal('contact_phone','') }}</p>
            @if(filled($answers['contact_email'] ?? null))
                <a href="mailto:{{ $answers['contact_email'] }}">CONTACT THE COORDINATOR</a>
            @endif
        </div>
        <p class="rbv-final-names">With love, <span data-field="bride_name">{{ $personal('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $personal('groom_name','Gabriel') }}</span></p>
    </div>
</section>
<footer class="rbv-footer"><span>MADE WITH LOVE</span><strong>WE WANT YOU THERE</strong></footer>
