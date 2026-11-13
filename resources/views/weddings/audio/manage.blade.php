@extends('layouts.wwyt')
@section('title', 'Manage Wedding Music | We Want You There')
@section('robots', 'noindex,nofollow')

@push('styles')
@include('weddings.partials.audio-builder-styles')
<style>
.wwyt-music-manager{max-width:1040px;margin:30px auto 75px;padding:0 20px;font-family:'DM Sans',Arial,sans-serif;color:#332b2a}
.wwyt-music-manager-header{margin:26px 0 22px}
.wwyt-music-manager-header h1{font:400 clamp(34px,5vw,55px)/1.12 Georgia,serif;color:#4c2730;margin:12px 0}
.wwyt-music-manager-header p{color:#706563;line-height:1.6;font-size:13px;max-width:630px}
.wwyt-music-manager-back{font:800 12px 'DM Sans',sans-serif;color:#823446;text-decoration:underline}
.wwyt-music-manager .music-studio{margin:0}
.wwyt-music-manager-actions{display:flex;align-items:center;gap:15px;flex-wrap:wrap;margin:25px 0}
.wwyt-music-manager-actions button{border:0;border-radius:9px;background:#641d34;color:white;font:800 13px 'DM Sans',sans-serif;padding:15px 23px;cursor:pointer}
.wwyt-music-manager-actions a{font-size:12px;color:#6b3a43}
.wwyt-music-manager .music-existing-url{display:inline-block;color:#4b6765;font-size:11px;text-decoration:underline;margin:4px 0}
.wwyt-music-manager .music-slot>p{margin-top:3px}
.wwyt-music-manager .music-manager-status{margin:15px 0;padding:14px 18px;border:1px solid #c9dac3;border-radius:8px;background:#f0f7ed;color:#365637;font:12px 'DM Sans',sans-serif}
.wwyt-music-manager .music-upload-options input[type=file]{max-width:600px}
@media(max-width:650px){.wwyt-music-manager{margin:12px auto 55px;padding:0 13px}}
</style>
@endpush

@section('content')
@php
    $premiumAccess = true; // Authorization is enforced by WeddingAudioController::ownedWebsite.
    $musicTracks = collect(config('wedding_audio.tracks', []));
@endphp
<div class="wwyt-music-manager">
    <header class="wwyt-music-manager-header">
        <a class="wwyt-music-manager-back" href="{{ url('/app/invitations') }}">← Back to My Invitations</a>
        <h1>Your invitation's soundtrack.</h1>
        <p>Update the opening and background music for <strong>{{ $website->name }}</strong>. Your invitation URL, guest responses and photographs stay unchanged.</p>
        @if(session('status'))<div class="music-manager-status" role="status">{{ session('status') }}</div>@endif
        @if($errors->any())<p class="music-manager-status" role="alert">{{ $errors->first() }}</p>@endif
    </header>
    <form method="POST" enctype="multipart/form-data"
          action="{{ route('wedding.audio.update', $website) }}"
          id="wedding-audio-manager" data-wwyt-audio-manager>
        @csrf
        <div class="music-studio" id="wedding-music-studio">
            <div class="music-studio-heading">
                <span class="music-studio-kicker"><i class="fa-solid fa-gem" aria-hidden="true"></i> PREMIUM MUSIC STUDIO</span>
                <h3>Music for every moment.</h3>
                <p>Each soundtrack has its own controls. Choose a built-in arrangement, upload your own recording, or leave it silent.</p>
            </div>
            @foreach(['intro'=>['01','Opening music','Starts after guests click the invitation opening.'],
                      'main'=>['02','Invitation music','Loops gently after the invitation opens.']] as $slot => $heading)
            @php
                $selection = old('audio.'.$slot, $musicSettings[$slot] ?? ['source'=>'none','track'=>'']);
                $current = $existingAudio['audio_'.$slot] ?? null;
                $hasCurrent = is_array($current) && !empty($current['path']);
                $originalSource = $selection['source'] ?? 'none';
            @endphp
            <fieldset class="music-slot" data-music-slot="{{ $slot }}">
                <legend><span>{{ $heading[0] }}</span> {{ $heading[1] }}</legend>
                <p>{{ $heading[2] }}</p>
                <div class="music-source-switch">
                    @foreach(['library'=>'Music library','custom'=>'My custom music','none'=>'No music'] as $source => $label)
                    <label class="music-source-option">
                        <input type="radio" name="audio[{{ $slot }}][source]" value="{{ $source }}" @checked($originalSource === $source)>
                        <span>{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="music-library-options" data-music-library="{{ $slot }}">
                    <label for="manage-track-{{ $slot }}">Original instrumentals</label>
                    <select id="manage-track-{{ $slot }}" name="audio[{{ $slot }}][track]" data-music-track="{{ $slot }}">
                        @foreach($musicTracks->filter(fn ($track) => ($track['role'] ?? '') === $slot) as $id => $track)
                        <option value="{{ $id }}" @selected(($selection['track'] ?? '') === $id)>{{ $track['title'] }} · {{ $track['description'] }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="music-try-button" data-music-manager-preview="{{ $slot }}" data-source="library">
                        <i class="fa-solid fa-play" aria-hidden="true"></i> Preview library track
                    </button>
                </div>
                <div class="music-upload-options" data-music-custom="{{ $slot }}" hidden>
                    <label for="manage-music-upload-{{ $slot }}">Upload MP3, WAV, OGG or M4A (max 12 MB)</label>
                    <input id="manage-music-upload-{{ $slot }}" type="file"
                           name="music_files[{{ $slot }}]" data-music-upload="{{ $slot }}"
                           accept=".mp3,.wav,.ogg,.m4a,audio/mpeg,audio/ogg,audio/mp4,audio/wav">
                    <span class="music-uploaded-file" data-music-uploaded-name="{{ $slot }}"
                          data-uploaded-url="{{ $hasCurrent ? route('wedding.audio.ownerPreview', ['website'=>$website, 'slot'=>$slot]).'?v='.rawurlencode(basename($current['path'])) : '' }}">
                          {{ $hasCurrent ? 'Current private upload is saved.' : 'No custom audio uploaded yet.' }}
                    </span>
                    <button type="button" class="music-try-button" data-music-manager-preview="{{ $slot }}" data-source="custom">
                        <i class="fa-solid fa-play" aria-hidden="true"></i> Preview custom music
                    </button>
                    @if($hasCurrent)
                        <a class="music-existing-url" href="{{ route('wedding.audio.ownerPreview',['website'=>$website,'slot'=>$slot]) }}" target="_blank" rel="noopener">Listen to the saved file separately</a>
                    @endif
                </div>
                <p class="music-upload-status" data-music-status="{{ $slot }}" aria-live="polite"></p>
            </fieldset>
            @endforeach
            <div class="music-studio-extras">
                <label class="music-sfx-toggle">
                    <input type="hidden" name="audio[sfx]" value="0">
                    <input type="checkbox" name="audio[sfx]" value="1" data-music-sfx
                           @checked(old('audio.sfx',$musicSettings['sfx'] ?? true))>
                    <span><strong>Enable theme-specific sound effects</strong>
                    <small>Opening effects, clicks on photographs and subtle navigation chimes.</small></span>
                </label>
                <label class="music-volume-label" for="manage-music-volume">
                    Music volume <output data-volume-output>{{ old('audio.volume',$musicSettings['volume'] ?? 45) }}%</output>
                </label>
                <input id="manage-music-volume" type="range" name="audio[volume]" data-music-volume
                       min="0" max="100" step="5" value="{{ old('audio.volume',$musicSettings['volume'] ?? 45) }}">
                <p class="music-studio-tip"><i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                   Guests start music by opening the invitation and can pause it at any time. Upload only audio you own or have a valid right to share.</p>
            </div>
        </div>
        <div class="wwyt-music-manager-actions">
            <button type="submit">Save music settings</button>
            <a href="{{ route('wedding.show', $website->slug) }}" target="_blank" rel="noopener">Preview your published invitation ↗</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@include('weddings.partials.audio-runtime')
<script>
(() => {
    const form = document.getElementById('wedding-audio-manager');
    if(!form)return;
    const originals = {};
    function selection(slot){return form.querySelector('input[name="audio['+slot+'][source]"]:checked')?.value||'none';}
    for(const slot of ['intro','main']){
        const section=form.querySelector('[data-music-slot="'+slot+'"]');
        const library=section?.querySelector('[data-music-library]');
        const custom=section?.querySelector('[data-music-custom]');
        const file=section?.querySelector('[data-music-upload]');
        const label=section?.querySelector('[data-music-uploaded-name]');
        const msg=section?.querySelector('[data-music-status]');
        const display=()=>{
            library.hidden=selection(slot)!=='library';
            custom.hidden=selection(slot)!=='custom';
        };
        section?.querySelectorAll('input[name="audio['+slot+'][source]"]').forEach(el=>el.addEventListener('change',()=>{
            window.WWYTAudio?.stopPreview?.();display();
        }));
        file?.addEventListener('change',event=>{
            if(originals[slot])URL.revokeObjectURL(originals[slot]);
            const current=event.target.files?.[0];
            if(!current)return;
            if(!/\.(mp3|wav|ogg|m4a)$/i.test(current.name) || current.size>12*1024*1024){
                msg.textContent='Use MP3, WAV, OGG or M4A no larger than 12 MB.';
                file.value='';return;
            }
            originals[slot]=URL.createObjectURL(current);
            label.dataset.uploadedUrl=originals[slot];
            label.textContent='New file selected: '+current.name;
            msg.textContent='Click Save music settings to publish your replacement.';
            section.querySelector('input[value="custom"]').checked=true;
            display();
        });
        section?.querySelectorAll('[data-music-manager-preview]').forEach(button=>{
            button.addEventListener('click',()=>{
                const source=button.dataset.source;
                const chosen={
                    source,
                    track:section.querySelector('[data-music-track]')?.value||'',
                    url:label?.dataset.uploadedUrl||''
                };
                if(source==='custom'&&!chosen.url){msg.textContent='Upload a file first.';return;}
                const playing=window.WWYTAudio?.preview?.(slot,chosen);
                msg.textContent=playing?'Playing a short preview. Click again to stop.':'Preview stopped.';
            });
        });
        display();
    }
    form.querySelector('[data-music-volume]')?.addEventListener('input',event=>{
        form.querySelector('[data-volume-output]').textContent=event.target.value+'%';
    });
    window.addEventListener('pagehide',()=>Object.values(originals).forEach(url=>URL.revokeObjectURL(url)));
})();
</script>
@endpush
