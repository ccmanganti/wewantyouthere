/* We Want You There - original premium instrumental score & UI sound engine.
   Synthesized in Web Audio: no embedded third-party recordings or licenses.
   Never starts audio until a visitor explicitly clicks or taps. */
(() => {
  'use strict';
  const bootstrap = document.getElementById('wwyt-audio-bootstrap');
  const manager = document.getElementById('wedding-audio-manager');
  const root = document.getElementById('wedding-invite') || manager;
  if (!bootstrap || !root) return;
  let data;
  try { data = JSON.parse(bootstrap.textContent || '{}'); } catch (_) { return; }
  if (!data.enabled) return;

  const audioCtor = window.AudioContext || window.webkitAudioContext;
  const editor = document.getElementById('wedding-builder') || manager;
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const theme = data.theme || 'royal_burgundy';
  const tracks = data.tracks || {};
  const sampleMode = Boolean(data.demo);
  const CROSSFADE_MS = 1050;
  const introTimes = {
    'burgundy-wax': 2550, 'olive-garden': 2100, 'painted-orchard': 2300,
    'pearl-editorial': 2270, 'destination-ticket': 1900, 'royal_burgundy': 2250
  };
  let ctx = null, started = false, paused = false, muted = false;
  let effectsOn = Boolean(data.settings?.sfx ?? true);
  let active = null, preparedMain = null, outgoing = null;
  let mainTimer = null, outgoingTimer = null, previewTimer = null, previewing = null;
  let audioFailure = false;
  let volume = Math.max(0, Math.min(1, Number(data.settings?.volume ?? 45) / 100));
  let output, musicButton, effectsButton;

  function setStatus(text) {
    if (!output) return;
    output.textContent = text;
  }
  function getContext() {
    if (!audioCtor) return null;
    if (!ctx) ctx = new audioCtor();
    if (ctx.state === 'suspended') ctx.resume().catch(() => {});
    return ctx;
  }
  function choice(slot) {
    // In a demo-only builder preview there are no premium inputs. Use the
    // theme's original example music rather than treating the slot as silent.
    if (editor?.querySelector('input[name="audio['+slot+'][source]"]')) {
      const source = editor.querySelector('input[name="audio['+slot+'][source]"]:checked')?.value || 'none';
      const track = editor.querySelector('[name="audio['+slot+'][track]"]')?.value || '';
      const file = editor.querySelector('[data-music-uploaded-name="'+slot+'"]');
      return {source,track,url:source === 'custom' ? (file?.dataset.uploadedUrl || '') : ''};
    }
    return data.settings?.[slot] || {source:'none'};
  }
  function selectedVolume() {
    const editorVolume = editor?.querySelector('[data-music-volume]');
    return Math.max(0, Math.min(1, Number(editorVolume?.value ?? (data.settings?.volume ?? 45)) / 100));
  }
  function midi(note) { return 440 * Math.pow(2,(note-69)/12); }
  function oscillator(note, at, length, kind, bus, strength) {
    const audio = getContext();
    if (!audio || !Number.isFinite(note)) return;
    const osc = audio.createOscillator(), env = audio.createGain();
    const isBell = kind === 'bell' || kind === 'glass';
    const isPad = kind === 'pad';
    osc.type = isBell ? 'sine' : isPad ? 'sine' : kind === 'marimba' ? 'sine' : 'triangle';
    osc.frequency.setValueAtTime(midi(note),at);
    if (kind === 'glass') osc.frequency.exponentialRampToValueAtTime(midi(note)*1.005,at+0.15);
    const attack = isPad ? 0.14 : 0.012;
    const decay = isPad ? Math.max(.8,length) : kind === 'marimba' ? .45 : isBell ? 1.2 : .85;
    env.gain.setValueAtTime(.0001,at);
    env.gain.exponentialRampToValueAtTime(Math.max(.0002,strength),at+attack);
    env.gain.exponentialRampToValueAtTime(.0001,at+Math.max(attack+.06,decay));
    osc.connect(env); env.connect(bus);
    osc.start(at); osc.stop(at+Math.max(decay+.05,.23));
    osc.onended = () => { try {osc.disconnect();env.disconnect();} catch(_) {} };
  }
  function synth(trackId, level) {
    const track = tracks[trackId];
    const audio = getContext();
    if (!audio || !track || !Array.isArray(track.melody) || !track.melody.length) return null;
    const bus = audio.createGain();
    bus.gain.setValueAtTime(.0001,audio.currentTime);
    bus.connect(audio.destination);
    bus.gain.setTargetAtTime(Math.min(.7,level)*.46,audio.currentTime,.14);
    const bpm = Math.max(50,Math.min(130,Number(track.bpm)||80));
    const beat = 60/bpm;
    let index = 0, next = audio.currentTime+.035, timer;
    function schedule() {
      while (next < audio.currentTime+.36) {
        const step = index % track.melody.length;
        const note = track.melody[step];
        const voice = track.voice || 'piano';
        if (note !== null && note !== undefined) oscillator(Number(note), next, beat*.8, voice, bus, .18);
        if (step % 4 === 0 && Array.isArray(track.chords)) {
          const chord = track.chords[Math.floor(step/4)%track.chords.length] || [];
          chord.forEach((pitch,j) => oscillator(Number(pitch)-12, next+j*.022,beat*3,
            voice === 'marimba' ? 'piano' : 'pad',bus,.028));
        }
        if(step % 2 === 0 && Array.isArray(track.chords) && track.chords.length){
          const chord = track.chords[Math.floor(step/4)%track.chords.length]||[];
          if(chord.length) oscillator(Number(chord[0])-24,next,beat, 'sine',bus,.04);
        }
        next+=beat;index+=1;
      }
    }
    schedule();timer=window.setInterval(schedule,150);
    return {kind:'synth',bus,timer};
  }
  function stop(playing, fade=.17) {
    if (!playing) return;
    if (playing.fadeTimer) {
      window.clearInterval(playing.fadeTimer);
      playing.fadeTimer = null;
    }
    if (playing.kind === 'synth') {
      window.clearInterval(playing.timer);
      if(ctx) {
        playing.bus.gain.cancelScheduledValues(ctx.currentTime);
        playing.bus.gain.setTargetAtTime(.0001,ctx.currentTime,Math.max(.02,fade));
      }
      window.setTimeout(()=>{try{playing.bus.disconnect();}catch(_){}},1000);
    } else if (playing.kind === 'file') {
      const el=playing.el;
      if(!el)return;
      const initial=el.volume;
      const begun=performance.now();
      const length=Math.max(70,fade*1000);
      const timer=window.setInterval(()=>{
        const elapsed=Math.min(1,(performance.now()-begun)/length);
        el.volume=Math.max(0,initial*(1-elapsed));
        if(elapsed>=1){clearInterval(timer);el.pause();el.removeAttribute('src');el.load();}
      },40);
    }
  }
  function fileAudio(url, level, loop, silent = false) {
    if (!url || !/^(\/|https?:\/\/|blob:)/.test(url)) return null;
    const el=new Audio(url);
    el.preload='auto';el.loop=loop;el.volume=silent ? 0 : Math.max(0,Math.min(.8,level));
    el.play().catch(()=>{
      audioFailure=true;setStatus('Tap Play to enable music');
      updateButtons();
    });
    return {kind:'file',el};
  }
  function playSelection(slot, initialLevel, silent=false) {
    const selected=choice(slot);
    if(selected.source==='library' && tracks[selected.track] && tracks[selected.track].role===slot)
      return synth(selected.track,initialLevel);
    if(selected.source==='custom')return fileAudio(selected.url,initialLevel,slot==='main',silent);
    return null;
  }
  // Crossfade is a real overlap: the next track starts quietly while the
  // opening track is still audible. It uses one gain envelope per track,
  // whether the source is synthesized or a customer-uploaded audio file.
  function ramp(entry, level, milliseconds = CROSSFADE_MS) {
    if (!entry) return;
    const target = Math.max(0, Math.min(.8, level));
    const duration = Math.max(60, milliseconds);
    if (entry.kind === 'synth') {
      if (!ctx) return;
      const gain = entry.bus.gain;
      const now = ctx.currentTime;
      gain.cancelScheduledValues(now);
      gain.setValueAtTime(Math.max(0, gain.value), now);
      gain.linearRampToValueAtTime(target * .46, now + duration / 1000);
    } else if (entry.kind === 'file' && entry.el) {
      if (entry.fadeTimer) window.clearInterval(entry.fadeTimer);
      const element = entry.el;
      const initial = element.volume;
      const startedAt = performance.now();
      entry.fadeTimer = window.setInterval(() => {
        const fraction = Math.min(1, (performance.now() - startedAt) / duration);
        element.volume = Math.max(0, Math.min(.8, initial + (target - initial) * fraction));
        if (fraction === 1) {
          window.clearInterval(entry.fadeTimer);
          entry.fadeTimer = null;
        }
      }, 40);
    }
  }

  function stopAll() {
    window.clearTimeout(mainTimer);
    window.clearTimeout(outgoingTimer);
    window.clearTimeout(previewTimer);
    for (const entry of [active, outgoing, preparedMain, previewing]) {
      if (entry) stop(entry, .08);
    }
    active = null;
    outgoing = null;
    preparedMain = null;
    previewing = null;
    started = false;
  }

  function moveToMain(overlapMs) {
    if (!started) return;
    const background = choice('main');
    const next = preparedMain || (background.source !== 'none' ? playSelection('main', 0, true) : null);
    preparedMain = null;
    outgoing = active;
    active = next;

    // Begin both fades immediately. Do not wait for the intro to reach zero
    // before introducing the next melody.
    if (outgoing) {
      ramp(outgoing, 0, Math.max(60, overlapMs));
      outgoingTimer = window.setTimeout(() => {
        if (outgoing) stop(outgoing, .04);
        outgoing = null;
      }, overlapMs + 100);
    }
    if (active) ramp(active, muted ? 0 : volume, Math.max(60, overlapMs));
    updateButtons();
  }

  function prepareOpening() {
    if (!getContext()) {
      setStatus('Audio is unavailable in this browser');
      return;
    }
    stopAll();
    paused = false;
    muted = false;
    audioFailure = false;
    volume = selectedVolume();
    const sfxInput = editor?.querySelector('[data-music-sfx]');
    effectsOn = sfxInput ? sfxInput.checked : Boolean(data.settings?.sfx);
    started = true;

    const opening = choice('intro');
    const background = choice('main');
    if (opening.source !== 'none') {
      active = playSelection('intro', volume * .72);
    }

    // Mobile Safari may reject Audio.play() inside a delayed timer. If the
    // main track is uploaded music, start its element silently *now*, inside
    // the envelope/gate/journal tap gesture, then gradually raise volume.
    if (background.source === 'custom') {
      preparedMain = fileAudio(background.url, 0, true, true);
    }
    sound('open');

    const introMs = reducedMotion ? 0 : (introTimes[theme] || 2250);
    const overlapMs = Math.min(CROSSFADE_MS, Math.max(0, Math.floor(introMs * .48)));
    mainTimer = window.setTimeout(
      () => moveToMain(overlapMs),
      Math.max(0, introMs - overlapMs)
    );
    updateButtons();
  }
  function makeNoise(time,duration,bus,cutoff,gain) {
    const audio=getContext();if(!audio)return;
    const count=Math.max(100,Math.floor(audio.sampleRate*duration));
    const buffer=audio.createBuffer(1,count,audio.sampleRate);
    const arr=buffer.getChannelData(0);
    for(let i=0;i<count;i++)arr[i]=(Math.random()*2-1)*Math.pow(1-i/count,2);
    const src=audio.createBufferSource(),filter=audio.createBiquadFilter(),amp=audio.createGain();
    src.buffer=buffer;filter.type='lowpass';filter.frequency.setValueAtTime(cutoff,time);
    amp.gain.setValueAtTime(gain,time);amp.gain.exponentialRampToValueAtTime(.0001,time+duration);
    src.connect(filter);filter.connect(amp);amp.connect(bus);src.start(time);
    src.onended=()=>{try{src.disconnect();filter.disconnect();amp.disconnect();}catch(_){}};
  }
  function sound(kind) {
    if(!effectsOn || muted || !started)return;
    const audio=getContext();if(!audio)return;
    const bus=audio.createGain();bus.gain.value=Math.min(.3,volume*.25);bus.connect(audio.destination);
    const t=audio.currentTime+.004;
    const tones={
      'burgundy-wax': [69,76,81],'olive-garden':[67,74,79],
      'painted-orchard':[72,79,84],'pearl-editorial':[76,83,88],
      'destination-ticket':[72,79,84], 'royal_burgundy':[71,76,83]
    }[theme]||[69,76,81];
    if(kind==='open') {
      if(theme==='burgundy-wax')makeNoise(t,.14,bus,1700,.25);
      if(theme==='olive-garden')makeNoise(t,.38,bus,650,.07);
      if(theme==='pearl-editorial')makeNoise(t,.09,bus,3700,.26);
      if(theme==='destination-ticket')makeNoise(t,.1,bus,2200,.08);
      tones.forEach((pitch,index)=>oscillator(pitch,t+index*.1,.5,
        theme==='pearl-editorial'?'glass':theme==='destination-ticket'?'marimba':'bell',bus,.24));
    } else if(kind==='photo') {
      if(theme==='pearl-editorial')makeNoise(t,.065,bus,2900,.18);
      if(theme==='olive-garden')makeNoise(t,.16,bus,800,.12);
      if(theme==='destination-ticket')makeNoise(t,.09,bus,1700,.1);
      oscillator(tones[1],t,.3,theme==='destination-ticket'?'marimba':'glass',bus,.22);
      oscillator(tones[2],t+.10,.35,'bell',bus,.11);
    } else {
      oscillator(tones[0],t,.18,'bell',bus,.15);
    }
    setTimeout(()=>{try{bus.disconnect();}catch(_){}},2000);
  }
  function updateButtons() {
    if(!musicButton)return;
    const live=started&&!paused&&!muted&&!audioFailure;
    const playable=choice('main').source!=='none' || choice('intro').source!=='none';
    musicButton.setAttribute('aria-pressed',live?'true':'false');
    musicButton.innerHTML='<i class="fa-solid '+(live?'fa-volume-high':'fa-volume-xmark')+'" aria-hidden="true"></i> '+(live?'Pause music':playable?'Play music':'Music off');
    if(effectsButton) {
      effectsButton.setAttribute('aria-pressed',effectsOn?'true':'false');
      effectsButton.setAttribute('aria-label',effectsOn?'Mute sound effects':'Enable sound effects');
      effectsButton.innerHTML='<i class="fa-solid '+(effectsOn?'fa-bell':'fa-bell-slash')+'" aria-hidden="true"></i>';
    }
  }
  function togglePlayback() {
    if (!started || audioFailure) {
      if (!getContext()) {
        setStatus('Audio is unavailable in this browser');
        return;
      }
      stopAll();
      volume = selectedVolume();
      const sfxInput = editor?.querySelector('[data-music-sfx]');
      effectsOn = sfxInput ? sfxInput.checked : Boolean(data.settings?.sfx);
      started = true;
      muted = false;
      paused = false;
      audioFailure = false;
      // The toolbar's Play control starts the post-opening track directly.
      // It never accidentally restarts the opening or schedules a duplicate.
      active = playSelection('main', volume);
    } else if (!muted) {
      muted = true;
      paused = true;
      if (active?.kind === 'synth' && ctx)
        active.bus.gain.setTargetAtTime(.0001, ctx.currentTime, .06);
      if (active?.kind === 'file') active.el.pause();
      if (outgoing) ramp(outgoing, 0, 100);
    } else {
      muted = false;
      paused = false;
      if (active?.kind === 'synth' && ctx) ramp(active, volume, 250);
      if (active?.kind === 'file') {
        active.el.play().then(() => {
          ramp(active, volume, 250);
        }).catch(() => setStatus('Tap Play to enable audio'));
      }
    }
    updateButtons();
  }
  function buildControls() {
    if(!data.enabled)return;
    const toolbar=document.createElement('div');
    toolbar.className='wwyt-audio-toolbar';
    toolbar.setAttribute('role','group');
    toolbar.setAttribute('aria-label','Wedding music controls');
    musicButton=document.createElement('button');
    musicButton.type='button';musicButton.setAttribute('aria-label','Play or pause wedding music');
    effectsButton=document.createElement('button');
    effectsButton.type='button';effectsButton.className='wwyt-audio-sfx';
    output=document.createElement('span');output.className='wwyt-audio-caption';output.setAttribute('aria-live','polite');
    toolbar.append(musicButton,effectsButton,output);
    if (sampleMode) {
      const note = document.createElement('span');
      note.className = 'wwyt-audio-caption';
      note.textContent = 'Sample · Premium';
      toolbar.append(note);
      toolbar.setAttribute('aria-label', 'Sample premium wedding music controls');
    }
    (editor?.querySelector('.preview-pane') || document.body).append(toolbar);
    musicButton.addEventListener('click',togglePlayback);
    effectsButton.addEventListener('click',()=>{
      effectsOn=!effectsOn;
      if(editor){const box=editor.querySelector('[data-music-sfx]');if(box){box.checked=effectsOn;box.dispatchEvent(new Event('change',{bubbles:true}));}}
      updateButtons();
    });
    updateButtons();
  }

  // Reset the soundtrack whenever the editor replays its unique intro.
  // A new intro tap will start its music once, without layered duplicates.
  document.getElementById('preview-envelope-intro')?.addEventListener('click', () => stopAll());
  // The opening tap is the only implicit audio trigger, never page load.
  document.addEventListener('click',event=>{
    if(!root.contains(event.target))return;
    const trigger=event.target.closest('[data-wax-scroll-open],[data-journal-open],[data-garden-gate-open],[data-editorial-reveal],[data-boarding-ticket-open],[data-rbv-open]');
    if(trigger && !trigger.disabled){
      if(previewing){stop(previewing);previewing=null;}
      prepareOpening();
      return;
    }
    if(!started)return;
    if(event.target.closest('.ce2-viewable,.rbv-photo-viewer,.rbv-photo,[data-rbv-gallery]')) {
      sound('photo');
    } else if(event.target.closest('a[href^="#"]'))sound('nav');
  },true);

  document.addEventListener('keydown',event=>{
    if((event.key==='Enter'||event.key===' ')&&event.target.closest('.ce2-viewable')&&started)sound('photo');
  },true);

  // The editor's previews are explicitly user initiated.
  function preview(slot, selected) {
    const same=previewing && previewing.previewId===slot+':'+selected.source+':'+(selected.track||selected.url);
    if(previewing){stop(previewing,.08);previewing=null;}
    clearTimeout(previewTimer);
    if(same)return false;
    if(!getContext())return false;
    const auditionVolume=selectedVolume();
    if(selected.source==='library'&&tracks[selected.track]?.role===slot)
      previewing=synth(selected.track,auditionVolume);
    else if(selected.source==='custom'&&selected.url)
      previewing=fileAudio(selected.url,auditionVolume,false);
    if(!previewing)return false;
    previewing.previewId=slot+':'+selected.source+':'+(selected.track||selected.url);
    previewTimer=setTimeout(()=>{if(previewing){stop(previewing,.15);previewing=null;}},11000);
    return true;
  }
  window.WWYTAudio = {
    preview,stopPreview(){if(previewing){stop(previewing);previewing=null;}clearTimeout(previewTimer);},
    updateVolume(){
      volume = selectedVolume();
      if (active && !muted) ramp(active, volume, 220);
      if (outgoing) ramp(outgoing, 0, 180);
    },
    updateEffects(){
      const input = editor?.querySelector('[data-music-sfx]');
      effectsOn = input ? input.checked : effectsOn;
      updateButtons();
    }
  };
  if (!manager) buildControls();
  document.addEventListener('visibilitychange',()=>{
    if(!document.hidden || !started)return;
    // Background tabs go quiet; a returning guest must explicitly tap Play.
    muted=true;paused=true;
    if(active?.kind==='file')active.el.pause();
    if(active?.kind==='synth' && ctx)active.bus.gain.setTargetAtTime(.0001,ctx.currentTime,.04);
    if(outgoing) ramp(outgoing, 0, 100);
    updateButtons();
  });
})();
