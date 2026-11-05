@php
    $photoUrls = $photoUrls ?? [];
    $isPreview = $isPreview ?? false;
    $isSample = !isset($website) && !$isPreview;
    $visible = fn (string $group) => $sections[$group] ?? true;
    $copy = function (string $key, string $fallback = '') use ($answers): string {
        $value = trim((string) ($answers[$key] ?? ''));
        return $value !== '' ? $value : $fallback;
    };
    $personal = fn (string $key, string $fallback = ''): string => $display($key, $fallback);
    $art = function (string $file, string $fallback) {
        $path = 'wedding/royal-burgundy-v3/assets/' . $file;
        // On Hostinger, the public_html web root is outside Laravel's public/
        // directory. Check both locations so File Manager uploads are detected.
        $isUploaded = is_file(public_path($path))
            || is_file(base_path('../../public_html/' . $path));
        return asset($isUploaded ? $path : 'wedding/royal-burgundy/' . $fallback);
    };
    $image = function (string $slot, string $sample, string $fallback) use ($photoUrls, $art, $isSample, $isPreview) {
        // A customer's uploaded photograph always takes priority.
        if (!empty($photoUrls[$slot])) return $photoUrls[$slot];

        // The real-couple stock images belong to the demo/builder ONLY.
        // A published invitation must never inherit another couple's photo.
        if (!$isSample && !$isPreview) return null;

        // Keep the optional self-hosted V3 sample set as the first choice.
        $samplePath = 'wedding/royal-burgundy-v3/assets/' . $sample;
        if (is_file(public_path($samplePath)) || is_file(base_path('../../public_html/' . $samplePath))) {
            return asset($samplePath);
        }

        // Production no longer depends on an untracked File Manager ZIP to
        // show real wedding photography in the preview.
        return config('wedding_sample_photos.' . $slot) ?: $art($sample, $fallback);
    };
    $date = !empty($answers['event_date']) ? \Carbon\CarbonImmutable::parse($answers['event_date']) : \Carbon\CarbonImmutable::create(2027,12,12);
    $sampleDate = $isSample || $isPreview;
    $dateText = $date->format('l, F j, Y');
    $map = function (string $key, string $fallback = '') use ($answers) {
        $candidate = trim((string) ($answers[$key] ?? ''));
        if ($candidate === '') $candidate = $fallback;
        if (!filter_var($candidate,FILTER_VALIDATE_URL)) return '';
        $scheme = strtolower(parse_url($candidate,PHP_URL_SCHEME) ?: '');
        return in_array($scheme,['https','http'],true) ? $candidate : '';
    };
    $guestMax = min(12,max(1,(int)($answers['guest_limit'] ?? 3)));
    $isPublishedSite = isset($website) && $website->status === 'published' && !$isPreview;
@endphp

<div id="wedding-invite" class="wedding-invite rb-invite rb-v3" data-royal-theme="grand-info-v3" data-preview="{{ $isPreview ? '1' : '0' }}">
    <header class="rbv-header">
        <a class="rbv-monogram" href="#cover"><span data-field="bride_name">{{ $personal('bride_name', 'Amelia') }}</span> <i>&amp;</i> <span data-field="groom_name">{{ $personal('groom_name', 'Gabriel') }}</span></a>
        <span class="rbv-header-label">THE WEDDING INVITATION</span>
        <details class="rbv-menu"><summary><span class="rbv-menu-icon" aria-hidden="true">☰</span> Menu</summary>
            <nav aria-label="Invitation sections">
                <a href="#our-story">Our story</a><a href="#the-date">Date</a>
                <a href="#location-details">Venue</a><a href="#the-timeline">Program</a>
                <a href="#our-people">Entourage</a><a href="#gallery-memories">Gallery</a><a href="#rsvp">RSVP</a>
            </nav>
        </details>
    </header>
    <main class="rbv-pages">
        @include('weddings.themes.royal-v3-grand-a')
        @include('weddings.themes.royal-v3-grand-b')
        @include('weddings.themes.royal-v3-grand-c')
    </main>
    @include('weddings.themes.royal-v3-envelope')
    <dialog class="rbv-lightbox" id="rbv-lightbox" aria-label="Wedding photo viewer">
        <button type="button" class="rbv-lightbox-close" aria-label="Close photograph">×</button>
        <img id="rbv-lightbox-photo" alt="Selected couple photograph">
        <p id="rbv-lightbox-caption"></p>
    </dialog>
</div>