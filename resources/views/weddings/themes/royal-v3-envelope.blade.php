{{-- Guest invitation opens only on click or keyboard activation of the floating envelope. --}}
<div class="rbv-intro" id="rbv-intro" data-intro-click-only="true" @if($isPreview || ($isPublishedSite && (session('rsvp_success') || $errors->any()))) hidden @endif
     role="dialog" aria-modal="true" aria-label="Your wedding invitation">
    <div class="rbv-intro-stage">
        {{-- The envelope itself is the only visible control; keyboard-accessible by default. --}}
        <button type="button" class="rbv-envelope-button" data-rbv-open
                aria-label="Open the wedding invitation" title="Open invitation">
            <span class="rbv-envelope" id="rbv-envelope">
            <img class="rbv-envelope-back" src="{{ $art('envelope-back.webp','envelope-back.webp') }}" alt="" width="920" height="600">
            <span class="rbv-letter">
                <img src="{{ $art('letter.webp','envelope-letter.webp') }}" alt="" width="610" height="740">
                <span class="rbv-letter-copy">
                    <small>THE WEDDING OF</small>
                    <strong><span data-field="bride_name">{{ $personal('bride_name','Amelia') }}</span> &amp; <span data-field="groom_name">{{ $personal('groom_name','Gabriel') }}</span></strong>
                    <span>YOU ARE CORDIALLY INVITED</span>
                    <b data-field="event_date">{{ $date->format('F j, Y') }}</b>
                </span>
            </span>
            <img class="rbv-envelope-front" src="{{ $art('envelope-front.webp','envelope-front.webp') }}" alt="" width="920" height="600">
            <img class="rbv-envelope-flap" src="{{ $art('envelope-flap.webp','envelope-flap.webp') }}" alt="" width="920" height="320">
            <img class="rbv-envelope-seal" src="{{ $art('seal.webp','wax-seal.webp') }}" alt="" width="290" height="290">
            </span>
        </button>
    </div>
</div>