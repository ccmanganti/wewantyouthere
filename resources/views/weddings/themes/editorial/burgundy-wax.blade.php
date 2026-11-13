{{-- HEIRLOOM LETTER: a narrow, beautifully layered letter rather than a full-width website. --}}
<nav class="bw-nav"><a href="#bw-front" aria-label="Return to cover">A love letter</a><a href="#bw-reply">RSVP <span aria-hidden="true">↗</span></a></nav>
<header id="bw-front" class="bw-front ce2-section" data-preview-section="couple">
    <div class="bw-foliage bw-foliage-left" style="background-image:url('{{ $decoration('flowers') }}')" aria-hidden="true"></div>
    <div class="bw-foliage bw-foliage-right" style="background-image:url('{{ $decoration('flowers') }}')" aria-hidden="true"></div>
    <div class="bw-presentation">
        <span class="bw-caption">AN INVITATION TO CELEBRATE</span>
        <span class="bw-tiny">WITH THEIR BELOVED FAMILIES</span>
        <h1><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span><i>&amp;</i><span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h1>
        <div class="bw-flourish" aria-hidden="true">❦</div>
        <p data-field="event_date">{{ $display('event_date','December 12, 2027') }}</p>
        <p data-field="venue_name">{{ $copy('venue_name','The Glass Garden') }}</p>
        <span class="bw-emboss">Together, forever.</span>
        <a class="bw-next" href="#bw-note">OPEN THE LETTER <span aria-hidden="true">↓</span></a>
    </div>
    <span class="bw-seal-small" aria-hidden="true">A<span>✦</span>G</span>
</header>

<section class="bw-note ce2-section" id="bw-note" data-preview-section="couple">
    <span class="bw-overline">DEAR FRIENDS &amp; FAMILY</span>
    <h2 data-field="welcome_heading">{{ $copy('welcome_heading','You are warmly invited.') }}</h2>
    <p class="bw-handwriting" data-field="host_message">{{ $copy('host_message',"We would be so delighted if you were there as we start this next chapter of our lives.") }}</p>
    <div class="bw-polaroids">
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_one','class'=>'bw-polaroid bw-polaroid-left','caption'=>$copy('editorial_caption_one','One beautiful beginning')])
        @include('weddings.themes.editorial.photo', ['slot'=>'portrait_two','class'=>'bw-polaroid bw-polaroid-right','caption'=>$copy('editorial_caption_two','A lifetime to follow')])
    </div>
    <div class="bw-story-card">
        <span class="bw-overline">THE STORY SO FAR</span>
        <h3 data-field="story_heading">{{ $copy('story_heading','Once upon our forever') }}</h3>
        <p data-field="couple_story">{{ $copy('couple_story','Some stories are written in letters. Ours is written in every moment together.') }}</p>
    </div>
</section>

<section class="bw-details ce2-section" id="bw-date" data-preview-section="ceremony">
    <div class="bw-engraving" aria-hidden="true" style="background-image:url('{{ $decoration('architecture') }}')"></div>
    <div class="bw-card">
        <span class="bw-overline">SAVE THIS BEAUTIFUL DAY</span>
        <h2 data-field="event_date">{{ $display('event_date','December 12, 2027') }}</h2>
        <span class="bw-line" aria-hidden="true"></span>
        <p data-field="event_time">{{ $display('event_time','3:00 PM') }}</p>
        <h3 data-field="ceremony_venue">{{ $copy('ceremony_venue','The Glass Chapel') }}</h3>
        <p data-field="ceremony_address">{{ $copy('ceremony_address','A beautiful place to say our vows') }}</p>
        <span class="bw-overline">FOLLOWED BY AN EVENING TO REMEMBER</span>
        <h3 data-field="reception_venue">{{ $copy('reception_venue','The Glass Garden') }}</h3>
        <p data-field="reception_time">{{ $display('reception_time','6:00 PM') }}</p>
        <p data-field="reception_address">{{ $copy('reception_address','Dinner and celebration') }}</p>
    </div>
</section>

@if($premiumAccess && $visible('ceremony_details'))
<section class="bw-ceremony ce2-section" id="bw-ceremony" data-preview-section="ceremony" data-premium-section="ceremony_details">
    <span class="bw-overline">THE SACRED MOMENT</span><h2 data-field="ceremony_type">{{ $copy('ceremony_type','Our ceremony') }}</h2>
    <p data-field="ceremony_notes">{{ $copy('ceremony_notes','A special note from the couple.') }}</p>
</section>
@endif
@include('weddings.themes.editorial.maps', ['mapClass'=>'bw-maps'])

@if($premiumAccess && $visible('program'))
<section class="bw-schedule ce2-section" id="bw-program" data-preview-section="program" data-premium-section="program">
    <span class="bw-overline">INSIDE THIS LITTLE LETTER</span><h2 data-field="timeline_heading">{{ $copy('timeline_heading','Our wedding day') }}</h2>
    <div class="bw-schedule-cards">
        @foreach([['event_time','3:00 PM','ceremony_timeline_note','A promise of forever'],['reception_time','6:00 PM','reception_timeline_note','Dinner by candlelight'],['celebration_time','9:00 PM','celebration_timeline_note','Dancing until late']] as [$time,$sampleTime,$note,$sampleNote])
        <article><strong data-field="{{ $time }}">{{ $display($time,$sampleTime) }}</strong><span data-field="{{ $note }}">{{ $copy($note,$sampleNote) }}</span></article>
        @endforeach
    </div>
    <p class="bw-schedule-extra" data-field="event_schedule">{{ $copy('event_schedule','') }}</p>
</section>
@endif

@if($premiumAccess && $visible('entourage'))
<section class="bw-family ce2-section" id="bw-family" data-preview-section="entourage" data-premium-section="entourage">
    <span class="bw-overline">SEALED WITH LOVE, SHARED WITH FAMILY</span><h2 data-field="entourage_heading">{{ $copy('entourage_heading','Our cherished people') }}</h2>
    <div class="bw-family-list"><div><h3>Principal sponsors</h3><p data-field="principal_sponsors">{{ $copy('principal_sponsors','Our dearest ninongs and ninangs') }}</p></div>
    <div><h3>Bridesmaids</h3><p data-field="bridesmaids">{{ $copy('bridesmaids','Our favorite friends') }}</p></div>
    <div><h3>Groomsmen</h3><p data-field="groomsmen">{{ $copy('groomsmen','Our closest people') }}</p></div></div>
</section>
@endif

<section class="bw-album ce2-section" id="bw-album" data-preview-section="couple">
    <span class="bw-overline">OUR LITTLE COLLECTION OF FOREVER</span>
    <h2 data-field="gallery_heading">{{ $copy('gallery_heading','The moments that made us') }}</h2>
    <div class="bw-album-grid">
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_one','class'=>'bw-album-image bw-album-image-one'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_two','class'=>'bw-album-image bw-album-image-two'])
        @include('weddings.themes.editorial.photo', ['slot'=>'gallery_three','class'=>'bw-album-image bw-album-image-three'])
    </div>
    <p class="bw-album-quote" data-field="gallery_quote">{{ $copy('gallery_quote','Every photograph is a little piece of our story.') }}</p>
</section>

@if($visible('details'))
<section class="bw-dress ce2-section" id="bw-dress" data-preview-section="details">
    <div class="bw-dress-stationery"><span class="bw-overline">AN EVENING OF ELEGANCE</span><h2 data-field="dress_heading">{{ $copy('dress_heading','Dress code') }}</h2>
        <p data-field="dress_code">{{ $copy('dress_code','Formal attire') }}</p>
        <p data-field="color_motif">{{ $copy('color_motif','Burgundy, blush and champagne') }}</p>
        <div class="bw-swatches" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
        <div class="bw-registry"><h3>With love &amp; gratitude</h3><p data-field="gift_message">{{ $copy('gift_message','Your presence is the greatest gift we could receive.') }}</p>
            @if($validExternal('gift_registry_url'))<a href="{{ $validExternal('gift_registry_url') }}" target="_blank" rel="noopener noreferrer">Our wedding registry ↗</a>@endif
        </div>
    </div>
</section>
@endif

@if($premiumAccess && $visible('guests'))
<section class="bw-rsvp ce2-section" id="bw-reply" data-preview-section="guests" data-premium-section="guests">
    <div class="bw-rsvp-flower" aria-hidden="true" style="background-image:url('{{ $decoration('flowers') }}')"></div>
    <div class="bw-rsvp-letter"><span class="bw-overline">RETURN THIS LITTLE NOTE</span><h2 data-field="rsvp_heading">{{ $copy('rsvp_heading','A reply from the heart') }}</h2>
        <p data-field="rsvp_message">{{ $copy('rsvp_message',"We can't wait to celebrate with you.") }}</p>
        @include('weddings.themes.editorial.rsvp', ['formClass'=>'bw-rsvp-form','submitLabel'=>'Seal & send my reply'])
        <span class="bw-rsvp-seal" aria-hidden="true">♥</span>
    </div>
</section>
@endif

<footer class="bw-footer ce2-section"><span>WITH ALL OUR LOVE</span>
    <h2><span data-field="bride_name">{{ $copy('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $copy('groom_name','Gabriel') }}</span></h2>
    <p data-field="closing_message">{{ $copy('closing_message','Until we meet on our wedding day.') }}</p>
    <a href="#bw-front">BACK TO THE BEGINNING ↑</a>
</footer>

{{-- Click the seal to open a true paper letter. No skip button or auto-open. --}}
<div class="bw-intro ce2-intro" id="ce2-intro" @if($isPreview) hidden @endif>
    <button class="bw-letter-trigger" type="button" data-ce2-open aria-label="Open the wax-sealed invitation">
        <span class="bw-outer-envelope"><span class="bw-flap"></span><span class="bw-insert"><small>THE WEDDING OF</small><strong>{{ $copy('bride_name','Amelia') }} &amp; {{ $copy('groom_name','Gabriel') }}</strong><em>{{ $date->format('F j, Y') }}</em></span><span class="bw-envelope-face"></span><span class="bw-seal" aria-hidden="true">✦</span></span>
    </button>
</div>
