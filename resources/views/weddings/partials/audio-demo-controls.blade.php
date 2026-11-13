@php
    // Public sample/editor demo only. Never expose custom uploads to unpaid visitors.
    $sampleTheme = \App\Support\CuratedWeddingDesign::forTemplate($template) ?? 'royal_burgundy';
    $sampleSet = config('wedding_audio.preview_sets.'.$sampleTheme, []);
    $sampleDefaults = config('wedding_audio.defaults.'.$sampleTheme, []);
    $sampleTracks = config('wedding_audio.tracks', []);
@endphp
@if(\App\Support\WeddingAudio::supported($template) && count($sampleSet) === 2)
<aside class="wwyt-sample-music {{ !empty($insideBuilder) ? 'wwyt-sample-music-builder' : '' }}"
      id="wwyt-sample-music" aria-label="Sample music for this invitation" data-music-sample>
    <div class="wwyt-sample-music-head">
        <div><span class="wwyt-sample-music-overline">MUSIC PREVIEW</span><strong>Hear this design</strong></div>
        <span class="wwyt-sample-premium">Premium demo</span>
    </div>
    <div class="wwyt-sample-music-tracks">
        @foreach(['intro' => 'Opening music', 'main' => 'Invitation music'] as $slot => $label)
        <div class="wwyt-sample-music-track">
            <label for="wwyt-sample-track-{{ $slot }}">{{ $label }}</label>
            <div class="wwyt-sample-track-actions">
                <select id="wwyt-sample-track-{{ $slot }}" data-demo-track="{{ $slot }}"
                        aria-label="Choose {{ strtolower($label) }}">
                    @foreach($sampleSet[$slot] ?? [] as $id)
                        @if(isset($sampleTracks[$id]) && $sampleTracks[$id]['role'] === $slot)
                        <option value="{{ $id }}" @selected(($sampleDefaults[$slot] ?? '') === $id)>
                            {{ $sampleTracks[$id]['title'] }}
                        </option>
                        @endif
                    @endforeach
                </select>
                <button type="button" data-demo-listen="{{ $slot }}"
                        aria-label="Listen to {{ strtolower($label) }}">
                    <i class="fa-solid fa-play" aria-hidden="true"></i> Listen
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="wwyt-sample-music-bottom">
        <label for="wwyt-sample-volume">Volume <output data-demo-volume-output>75%</output></label>
        <input type="range" id="wwyt-sample-volume" data-demo-volume min="0" max="100" step="5" value="75" aria-label="Sample music volume">
        <button type="button" class="wwyt-sample-experience" data-demo-experience>
            <i class="fa-solid fa-music" aria-hidden="true"></i> Hear the full opening
        </button>
    </div>
    <p class="wwyt-sample-audio-status" data-demo-audio-status role="status" aria-live="polite">
        Tap Listen to hear music. Your published invitation needs Premium for music.
    </p>
</aside>
@endif
