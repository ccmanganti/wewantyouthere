@php
    // Demo previews deliberately showcase only original library tracks.
    // A demo flag never grants premium entitlement or exposes private uploads.
    $isAudioDemo = (bool) ($audioDemo ?? false);
    $isAudioPremium = (bool) ($premiumAccess ?? $hasPremium ?? false);
    $hasMusicFeature = \App\Support\WeddingAudio::supported($template);
    $audioTheme = \App\Support\CuratedWeddingDesign::forTemplate($template) ?? 'royal_burgundy';
    $playerSettings = $isAudioDemo
        ? \App\Support\WeddingAudio::defaults($template)
        : (isset($website)
            ? \App\Support\WeddingAudio::publicSettings($website, $template, $isAudioPremium)
            : ['enabled' => $isAudioPremium, ...($musicSettings ?? \App\Support\WeddingAudio::defaults($template))]);
    $audioData = [
        'enabled' => ($isAudioPremium || $isAudioDemo) && $hasMusicFeature,
        'demo' => $isAudioDemo,
        'theme' => $audioTheme,
        'settings' => $playerSettings,
        'tracks' => config('wedding_audio.tracks', []),
    ];
@endphp
@if($audioData['enabled'])
<script type="application/json" id="wwyt-audio-bootstrap">{!! json_encode($audioData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) !!}</script>
<script src="{{ route('wedding.audio.script') }}?v=5"></script>
@endif
