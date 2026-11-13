@php
    $trackCollection = collect(config('wedding_audio.tracks', []));
    $audioSettings = $musicSettings ?? [];
    $uploadedAudio = $draftAudio ?? [];
@endphp
@if($hasPremium && $specialEditor)
<section class="music-studio" id="wedding-music-studio" aria-labelledby="music-studio-title"
         data-audio-upload-url="{{ route('wedding.audio.upload', $template->slug) }}"
         data-audio-route-base="{{ url('/templates/wedding/'.$template->slug.'/audio') }}">
    <div class="music-studio-heading">
        <span class="music-studio-kicker"><i class="fa-solid fa-gem" aria-hidden="true"></i> PREMIUM MUSIC STUDIO</span>
        <h3 id="music-studio-title">Set the mood.</h3>
        <p>Choose the opening soundtrack and the music guests hear after opening your invitation.</p>
    </div>
    @foreach(['intro' => ['01','Opening music','Plays when guests interact with the invitation opening.'],
              'main' => ['02','Invitation music','Starts after the opening and loops softly while guests explore.']] as $slot => $heading)
    @php
        $selection = $audioSettings[$slot] ?? ['source'=>'none','track'=>''];
        $savedFile = $uploadedAudio[$slot] ?? [];
        $hasFile = isset($savedFile['path']);
        $uploadedName = $hasFile ? ($savedFile['name'] ?? 'Your music file') : '';
    @endphp
    <fieldset class="music-slot" data-music-slot="{{ $slot }}">
        <legend><span>{{ $heading[0] }}</span> {{ $heading[1] }}</legend>
        <p>{{ $heading[2] }}</p>
        <div class="music-source-switch" role="group" aria-label="{{ $heading[1] }} source">
            @foreach(['library'=>'Our music library','custom'=>'Upload my music','none'=>'No music'] as $source => $label)
            <label class="music-source-option">
                <input type="radio" name="audio[{{ $slot }}][source]" value="{{ $source }}"
                       @checked(($selection['source'] ?? 'none') === $source)>
                <span>{{ $label }}</span>
            </label>
            @endforeach
        </div>
        <div class="music-library-options" data-music-library="{{ $slot }}">
            <label for="music-track-{{ $slot }}">Select a track</label>
            <select id="music-track-{{ $slot }}" name="audio[{{ $slot }}][track]" data-music-track="{{ $slot }}">
                @foreach($trackCollection->filter(fn ($track) => ($track['role'] ?? '') === $slot) as $id => $track)
                <option value="{{ $id }}" @selected(($selection['track'] ?? '') === $id)>
                    {{ $track['title'] }} · {{ $track['description'] }}
                </option>
                @endforeach
            </select>
            <button type="button" class="music-try-button" data-music-try="{{ $slot }}">
                <i class="fa-solid fa-play" aria-hidden="true"></i> Listen to selection
            </button>
        </div>
        <div class="music-upload-options" data-music-custom="{{ $slot }}" hidden>
            <label for="music-upload-{{ $slot }}">MP3, WAV, OGG or M4A · 12 MB maximum</label>
            <input type="file" id="music-upload-{{ $slot }}" data-music-upload="{{ $slot }}"
                   accept=".mp3,.wav,.ogg,.m4a,audio/mpeg,audio/mp4,audio/ogg,audio/wav">
            <span class="music-uploaded-file" data-music-uploaded-name="{{ $slot }}"
                  data-uploaded-url="{{ $hasFile ? route('wedding.audio.draft', ['slug' => $template->slug, 'slot' => $slot]) : '' }}">
                {{ $hasFile ? 'Saved: '.$uploadedName : 'No custom music uploaded yet.' }}
            </span>
            <button type="button" class="music-try-button" data-music-try="{{ $slot }}">
                <i class="fa-solid fa-play" aria-hidden="true"></i> Listen to upload
            </button>
            <button type="button" class="music-remove-button" data-music-remove="{{ $slot }}"
                    @if(!$hasFile) hidden @endif>Remove custom file</button>
        </div>
        <p class="music-upload-status" role="status" aria-live="polite" data-music-status="{{ $slot }}"></p>
    </fieldset>
    @endforeach
    <div class="music-studio-extras">
        <label class="music-sfx-toggle">
            <input type="hidden" name="audio[sfx]" value="0">
            <input type="checkbox" name="audio[sfx]" value="1" data-music-sfx
                   @checked($audioSettings['sfx'] ?? true)>
            <span><strong>Interactive sound effects</strong><small>Unique sounds for the opening, photo gallery and navigation.</small></span>
        </label>
        <label class="music-volume-label" for="music-volume">Music volume <output data-volume-output>{{ $audioSettings['volume'] ?? 45 }}%</output></label>
        <input id="music-volume" type="range" name="audio[volume]" data-music-volume
               min="0" max="100" step="5" value="{{ $audioSettings['volume'] ?? 45 }}">
        <p class="music-studio-tip"><i class="fa-solid fa-circle-info" aria-hidden="true"></i>
            Guest music starts when they click the opening, not automatically on page load. They can pause or mute it anytime. Only upload music you own or have permission to use.</p>
    </div>
</section>
@elseif($specialEditor)
<div class="music-studio-locked" data-locked-feature="music" tabindex="0" role="button">
    <i class="fa-solid fa-lock" aria-hidden="true"></i>
    <span><strong>Music & interactive sound effects</strong><small>Premium · Choose two tracks or upload your own.</small></span>
    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
</div>
@endif
