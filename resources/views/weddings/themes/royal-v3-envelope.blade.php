{{-- This intro never opens automatically. The guest clicks OPEN INVITATION. --}}
<div class="rbv-intro" id="rbv-intro" data-intro-click-only="true" @if($isPreview || ($isPublishedSite && (session('rsvp_success') || $errors->any()))) hidden @endif
     role="dialog" aria-modal="true" aria-label="Your wedding invitation">
    <div class="rbv-intro-stage">
        <span class="rbv-intro-eyebrow">SOMETHING BEAUTIFUL AWAITS</span>
        <h2>A letter, especially for you.</h2>
        <div class="rbv-envelope" id="rbv-envelope" aria-hidden="true">
            <img class="rbv-envelope-back" src="{{ $art('envelope-back.webp','envelope-back.webp') }}" alt="" width="920" height="600">
            <div class="rbv-letter">
                <img src="{{ $art('letter.webp','envelope-letter.webp') }}" alt="" width="610" height="740">
                <div class="rbv-letter-copy">
                    <small>THE WEDDING OF</small>
                    <strong><span data-field="bride_name">{{ $personal('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $personal('groom_name','Gabriel') }}</span></strong>
                    <span>YOU ARE CORDIALLY INVITED</span>
                    <b data-field="event_date">{{ $date->format('F j, Y') }}</b>
                </div>
            </div>
            <img class="rbv-envelope-front" src="{{ $art('envelope-front.webp','envelope-front.webp') }}" alt="" width="920" height="600">
            <img class="rbv-envelope-flap" src="{{ $art('envelope-flap.webp','envelope-flap.webp') }}" alt="" width="920" height="320">
            <img class="rbv-envelope-seal" src="{{ $art('seal.webp','wax-seal.webp') }}" alt="" width="290" height="290">
        </div>
        <p class="rbv-intro-tagline">THE BEGINNING OF OUR FOREVER</p>
        <div class="rbv-intro-actions">
            <button type="button" class="rbv-open-button" data-rbv-open>OPEN INVITATION <i class="fa-solid fa-arrow-right"></i></button>
            <button type="button" class="rbv-skip-button" data-rbv-skip>Skip introduction</button>
        </div>
    </div>
</div>