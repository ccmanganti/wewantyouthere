@php
    /*
     * Every curated template is an independent layout. Only the safe data,
     * uploaded-photo handling and entitlement rules are shared.
     */
    $isPreview = $isPreview ?? false;
    $isSample = !isset($website) && !$isPreview;
    $premiumAccess = (bool) ($premiumAccess ?? false);
    $designKey = (string) ($template->settings['design'] ?? 'burgundy-wax');
    if (!array_key_exists($designKey, config('wedding_curated_themes', []))) $designKey = 'burgundy-wax';
    $photoUrls = $photoUrls ?? [];
    $themeArt = config('wedding_curated_assets.'.$designKey, []);
    $photo = function (string $slot) use ($photoUrls, $themeArt, $isSample, $isPreview) {
        if (filled($photoUrls[$slot] ?? null)) return $photoUrls[$slot];
        // Sample couples must never appear in someone else's published invitation.
        return ($isSample || $isPreview) ? ($themeArt['photos'][$slot] ?? null) : null;
    };
    $decoration = fn (string $slot) => $themeArt['decor'][$slot] ?? null;
    $copy = function (string $key, string $fallback = '') use ($answers, $isPreview, $isSample) {
        $value = $answers[$key] ?? '';
        $value = is_array($value) ? implode(', ', array_map('strval', $value)) : trim((string) $value);
        return $value !== '' ? $value : (($isPreview || $isSample) ? $fallback : '');
    };
    $visible = fn (string $key) => (bool) ($sections[$key] ?? in_array($key, ['couple', 'ceremony', 'reception', 'details'], true));
    $date = !empty($answers['event_date']) ? \Carbon\CarbonImmutable::parse($answers['event_date']) : \Carbon\CarbonImmutable::create(2027,12,12);
    $isPublishedSite = isset($website) && $website->status === 'published' && !$isPreview;
    $guestMax = max(1, min(12, (int) ($answers['guest_limit'] ?? 3)));
    $validExternal = function (string $key) use ($answers): ?string {
        $url = trim((string) ($answers[$key] ?? ''));
        return filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), ['https','http'], true) ? $url : null;
    };
@endphp
<div class="wedding-invite ce2 ce2-{{ $designKey }}" id="wedding-invite"
     data-curated-design="{{ $designKey }}" data-preview="{{ $isPreview ? '1' : '0' }}"
     data-ce2-date="{{ $date->format('Y-m-d') }}"
     data-ce2-motion="{{ config('wedding_curated_themes.'.$designKey.'.animation') }}">
    @include('weddings.themes.editorial.'.$designKey)
    @if($premiumAccess && $visible('video'))
        @include('weddings.partials.premium-video')
    @endif
</div>
