@php
    /*
     * Every curated template is an independent layout. Only the safe data,
     * uploaded-photo handling and entitlement rules are shared.
     */
    $isPreview = $isPreview ?? false;
    $isSample = !isset($website) && !$isPreview;
    $premiumAccess = (bool) ($premiumAccess ?? false);
    $designKey = \App\Support\CuratedWeddingDesign::forTemplate($template);
    if ($designKey === null) throw new \InvalidArgumentException('Unknown curated wedding design.');
    $photoUrls = $photoUrls ?? [];
    $themeArt = config('wedding_curated_assets.'.$designKey, []);
    $sampleAnswers = config('wedding_curated_showcases.'.$designKey, []);
    $photo = function (string $slot) use ($photoUrls, $themeArt, $isSample, $isPreview) {
        if (filled($photoUrls[$slot] ?? null)) return $photoUrls[$slot];
        // Sample couples must never appear in someone else's published invitation.
        return ($isSample || $isPreview) ? ($themeArt['photos'][$slot] ?? null) : null;
    };
    $decoration = fn (string $slot) => $themeArt['decor'][$slot] ?? null;
    $copy = function (string $key, string $fallback = '') use ($answers, $isPreview, $isSample, $sampleAnswers) {
        $value = $answers[$key] ?? '';
        $value = is_array($value) ? implode(', ', array_map('strval', $value)) : trim((string) $value);
        return $value !== '' ? $value : (($isPreview || $isSample) ? ($sampleAnswers[$key] ?? $fallback) : '');
    };
    $display = function (string $key, string $fallback = '') use ($answers, $isPreview, $isSample, $sampleAnswers): string {
        $value = $answers[$key] ?? '';
        $value = is_array($value) ? implode(', ', array_map('strval', $value)) : trim((string) $value);
        if ($value === '' && ($isPreview || $isSample)) $value = (string) ($sampleAnswers[$key] ?? $fallback);
        if ($value === '') return '';
        if (in_array($key, ['event_date', 'rsvp_deadline'], true) && preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $value)) {
            try { return \Carbon\CarbonImmutable::parse($value)->format('F j, Y'); } catch (\Throwable $ignored) {}
        }
        if (in_array($key, ['event_time','reception_time','guest_arrival_time','celebration_time'], true) && preg_match('/^\\d{2}:\\d{2}$/', $value)) {
            try { return \Carbon\CarbonImmutable::parse($value)->format('g:i A'); } catch (\Throwable $ignored) {}
        }
        return $value;
    };
    $visible = fn (string $key) => (bool) ($sections[$key] ?? in_array($key, ['couple', 'ceremony', 'reception', 'details'], true));
    $date = \Carbon\CarbonImmutable::parse($answers['event_date'] ?? (($isPreview || $isSample) ? ($sampleAnswers['event_date'] ?? '2027-12-12') : '2027-12-12'));
    $isPublishedSite = isset($website) && $website->status === 'published' && !$isPreview;
    $guestMax = max(1, min(12, (int) ($answers['guest_limit'] ?? 3)));
    $validExternal = function (string $key) use ($answers): ?string {
        $url = trim((string) ($answers[$key] ?? ''));
        return filter_var($url, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), ['https','http'], true) ? $url : null;
    };
@endphp
<div class="wedding-invite ce2 ce2-{{ $designKey }}" id="wedding-invite"
     data-curated-design="{{ $designKey }}" data-design-revision="{{ \App\Support\CuratedWeddingDesign::REVISION }}" data-preview="{{ $isPreview ? '1' : '0' }}"
     data-ce2-date="{{ $date->format('Y-m-d') }}"
     data-ce2-motion="{{ config('wedding_curated_themes.'.$designKey.'.animation') }}">
    @include('weddings.themes.editorial.'.$designKey)
    @if($premiumAccess && ($visible('video') || $isPreview))
        @include('weddings.partials.premium-video')
    @endif
</div>
