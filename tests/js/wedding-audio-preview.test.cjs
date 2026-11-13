'use strict';

/**
 * Small dependency-free playback smoke test. This exercises the actual browser
 * source in a fake DOM and a recording Web Audio context. A view-only test
 * cannot verify that clicking Listen really schedules audible oscillator notes.
 */
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');

let oscillators = 0;
let contextCreated = 0;
let suspendedResumes = 0;
const scheduled = [];
const listeners = {};

class FakeElement {
  constructor(name = '') {
    this.name = name;
    this.dataset = {};
    this.attributes = {};
    this.listeners = {};
    this.classList = {contains: () => false};
    this.disabled = false;
    this.hidden = false;
    this.textContent = '';
    this.value = '';
    this.children = [];
  }
  addEventListener(type, handler) {
    (this.listeners[type] ||= []).push(handler);
  }
  dispatch(type) {
    for (const cb of this.listeners[type] || []) cb({target: this});
  }
  click() { this.dispatch('click'); }
  append(...children) { this.children.push(...children); }
  setAttribute(name, value) { this.attributes[name] = value; }
  getAttribute(name) { return this.attributes[name]; }
  querySelector() { return null; }
  contains() { return false; }
  closest() { return null; }
}

class FakeGain extends FakeElement {
  constructor() {
    super();
    this.gain = {
      value: 0,
      cancelScheduledValues() {},
      setValueAtTime(value) { this.value = value; },
      setTargetAtTime(value) { this.value = value; },
      linearRampToValueAtTime(value) { this.value = value; },
      exponentialRampToValueAtTime(value) { this.value = value; }
    };
  }
  connect() {}
  disconnect() {}
}

class FakeOscillator extends FakeElement {
  constructor() {
    super();
    this.frequency = {
      setValueAtTime() {},
      exponentialRampToValueAtTime() {}
    };
  }
  connect() {}
  disconnect() {}
  start() { oscillators++; }
  stop() {}
}

class FakeAudioContext {
  constructor() {
    contextCreated++;
    this.state = 'running';
    this.currentTime = 0;
    this.sampleRate = 44100;
    this.destination = {};
  }
  resume() { suspendedResumes++; this.state = 'running'; return Promise.resolve(); }
  createGain() { return new FakeGain(); }
  createOscillator() { return new FakeOscillator(); }
  createBiquadFilter() {
    return {type: 'lowpass',frequency:{setValueAtTime(){}},connect(){},disconnect(){}};
  }
  createBuffer(_channels, length) { return {getChannelData(){ return new Float32Array(length); }}; }
  createBufferSource() {
    return {connect(){},disconnect(){},start(){},stop(){},onended:null};
  }
}

const introSelect = new FakeElement('intro-select');
introSelect.value = 'botanical-page';
const mainSelect = new FakeElement('main-select');
mainSelect.value = 'garden-afternoon';
const introListen = new FakeElement('intro-listen');
const mainListen = new FakeElement('main-listen');
const full = new FakeElement('full');
const slider = new FakeElement('volume');
slider.value = '75';
const volumeOutput = new FakeElement('volume-output');
const status = new FakeElement('status');
const opener = new FakeElement('journal-button');
opener.closest = selector => selector.includes('[data-journal-open]') ? opener : null;

const intro = new FakeElement('journal-intro');
intro.querySelector = selector => selector.includes('[data-journal-open]') ? opener : null;

const controls = new FakeElement('preview-music');
controls.querySelector = selector => ({
  '[data-demo-track="intro"]':introSelect, '[data-demo-track="main"]':mainSelect,
  '[data-demo-listen="intro"]':introListen, '[data-demo-listen="main"]':mainListen,
  '[data-demo-experience]':full, '[data-demo-volume]':slider,
  '[data-demo-volume-output]':volumeOutput, '[data-demo-audio-status]':status
})[selector] || null;

const root = new FakeElement('wedding-invite');
root.contains = node => node === opener;
root.querySelector = selector => selector.includes('#ce2-intro') ? intro : null;

const source = {
  enabled:true, demo:true, theme:'olive-garden', settings:{
    intro:{source:'library',track:'botanical-page'},
    main:{source:'library',track:'garden-afternoon'},sfx:true,volume:45
  }, previewSets:{
    intro:['botanical-page','woodland-gates','seal-whisper'],
    main:['garden-afternoon','orchard-bloom','heirloom-valse']
  }, tracks:{
    'botanical-page':{role:'intro',title:'Turning Leaves',bpm:84,voice:'harp',melody:[67,71,74,76],chords:[[55,59,62]]},
    'woodland-gates':{role:'intro',title:'The Secret Path',bpm:68,voice:'pad',melody:[64,67,71,74],chords:[[52,55,59]]},
    'garden-afternoon':{role:'main',title:'Garden Afternoon',bpm:94,voice:'harp',melody:[74,76,78,76],chords:[[55,59,62]]},
    'orchard-bloom':{role:'main',title:'Under the Blossoms',bpm:78,voice:'pad',melody:[71,74,76,78],chords:[[52,55,59]]}
  }
};
const bootstrap = new FakeElement('bootstrap');
bootstrap.textContent = JSON.stringify(source);

const elements = {
  'wwyt-audio-bootstrap':bootstrap, 'wedding-invite':root,
  'wwyt-sample-music':controls
};
const document = {
  body:new FakeElement('body'),
  hidden:false,
  getElementById(id) { return elements[id] || null; },
  createElement(tag) { return new FakeElement(tag); },
  addEventListener(name,cb) { (listeners[name] ||= []).push(cb); }
};
const clocks = {
  setTimeout(cb, delay) { scheduled.push({cb,delay}); return scheduled.length; },
  clearTimeout() {},
  setInterval() { return 20; },
  clearInterval() {}
};
opener.click = () => {
  for(const cb of listeners.click || [])cb({target:opener});
};

const sandbox = {
  document, console, Math, Float32Array, performance:{now:()=>0},
  ...clocks,
  window:{
    AudioContext: FakeAudioContext, matchMedia:()=>({matches:false}),
    WWYTAudio:null,...clocks
  }
};
vm.runInNewContext(fs.readFileSync('public/js/wedding-audio.js','utf8'),sandbox,{timeout:2000});

assert.match(status.textContent,/tap Listen/i,'Audio controls should give an explicit interaction hint.');
introListen.click();
assert.ok(oscillators>0,'Clicking Listen to opening music must schedule real audio notes.');
assert.match(status.textContent,/Turning Leaves/);
const afterIntro = oscillators;
mainListen.click();
assert.ok(oscillators>afterIntro,'Clicking Listen to invitation music must schedule additional notes.');
assert.match(status.textContent,/Garden Afternoon/);

introSelect.value='woodland-gates';
introSelect.dispatch('change');
const afterChange=oscillators;
introListen.click();
assert.ok(oscillators>afterChange,'Selecting an alternate intro track must play it.');
assert.match(status.textContent,/Secret Path/);

slider.value='90';
slider.dispatch('input');
assert.equal(volumeOutput.textContent,'90%');
const beforeFull=oscillators;
full.click();
assert.ok(oscillators>beforeFull,'Full experience must begin with its intro soundtrack.');
assert.ok(contextCreated>=1,'A real Web Audio context must be constructed.');
assert.match(status.textContent,/opening music/);
const beforeCrossfade=oscillators;
const expectedCrossfadeDelay=2100-Math.min(1050,Math.floor(2100*.48));
const crossfade = scheduled.find(task => task.delay === expectedCrossfadeDelay);
assert.ok(crossfade,'The crossfade into invitation music must be scheduled.');
crossfade.cb();
assert.ok(oscillators>beforeCrossfade,'The background track must start during crossfade.');
console.log('PASS: sample opening, ambient, alternate selection, volume, and crossfade all schedule Web Audio notes.');
