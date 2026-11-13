'use strict';
// Exercise actual sample Web Audio in both browser autoplay states.
// No visible play/volume widgets may be added to an invitation preview.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const sourceCode = fs.readFileSync('public/js/wedding-audio.js','utf8');

class Element {
  constructor(name='') {
    this.name = name;
    this.hidden = false;
    this.disabled = false;
    this.attributes = {};
    this.children = [];
    this.listeners = {};
    this.classList = {contains:()=>false};
  }
  addEventListener(event,cb) { (this.listeners[event] ||= []).push(cb); }
  click() { for (const cb of this.listeners.click || []) cb({target:this}); }
  setAttribute(name,value){this.attributes[name]=value;}
  getAttribute(name){return this.attributes[name];}
  querySelector(){return null;}
  closest(){return null;}
  append(...elements){this.children.push(...elements);}
  contains(){return false;}
}
class Gain {
  constructor() {
    this.gain = {
      value:.0001,
      setValueAtTime(v){this.value=v;},
      setTargetAtTime(v){this.value=v;},
      exponentialRampToValueAtTime(v){this.value=v;},
      linearRampToValueAtTime(v){this.value=v;},
      cancelScheduledValues(){}
    };
  }
  connect(){}
  disconnect(){}
}
function simulate(autoplayAllowed) {
  let oscillatorStarts=0;
  let contextsCreated=0;
  let activation=autoplayAllowed;
  const timers=[];
  const eventHandlers={};
  class Osc {
    constructor(){
      this.frequency={setValueAtTime(){},exponentialRampToValueAtTime(){}};
      this.type='sine';this.onended=null;
    }
    connect(){}
    disconnect(){}
    start(){oscillatorStarts++;}
    stop(){}
  }
  class AudioContext {
    constructor() {
      contextsCreated++;
      this.state = activation ? 'running' : 'suspended';
      this.currentTime=0;this.sampleRate=44100;this.destination={};
    }
    resume() {
      if(activation){this.state='running';return Promise.resolve();}
      return Promise.reject(new Error('NotAllowedError: autoplay blocked'));
    }
    createGain(){return new Gain();}
    createOscillator(){return new Osc();}
    createBiquadFilter(){return {frequency:{setValueAtTime(){}},connect(){},disconnect(){}};}
    createBuffer(_channels,count){return {getChannelData(){return new Float32Array(count);}};}
    createBufferSource(){return {connect(){},disconnect(){},start(){},stop(){}};}
  }
  const playerData = {
    enabled:true,demo:true,theme:'olive-garden',
    settings:{
      intro:{source:'library',track:'botanical-page'},
      main:{source:'library',track:'garden-afternoon'},
      sfx:true,volume:45
    },
    tracks:{
      'botanical-page':{role:'intro',title:'Garden Aisle Processional',
        bpm:68,meter:4,voice:'harp',accompaniment:'strings',
        melody:[67,72,74,76,79,76,74,null,72,74,76,79,81,79,76,null],
        chords:[[60,64,67],[53,57,60],[57,60,64],[55,59,62]]},
      'garden-afternoon':{role:'main',title:'A Promise in Bloom',
        bpm:78,meter:3,voice:'harp',accompaniment:'cello',
        melody:[72,76,79,81,79,76,74,72,69,72,76,79,76,74,72,71,72,74,76,79,76,74,72,null],
        chords:[[60,64,67],[53,57,60],[57,60,64],[55,59,62]]}
    }
  };
  const bootstrap = new Element('bootstrap');
  bootstrap.textContent=JSON.stringify(playerData);
  const opening = new Element('journal opener');
  opening.closest=(query)=>query.includes('[data-journal-open]')?opening:null;
  const root = new Element('invitation');
  root.contains=(target)=>target===opening;
  const elements={'wwyt-audio-bootstrap':bootstrap,'wedding-invite':root};
  let visibleControlsCreated=0;
  const document={
    hidden:false,body:new Element('body'),
    getElementById(id){return elements[id]||null;},
    createElement(tag){visibleControlsCreated++;return new Element(tag);},
    addEventListener(event,cb){(eventHandlers[event] ||= []).push(cb);}
  };
  const scheduling={
    setTimeout(cb,delay){const id=timers.length+1;timers.push({id,cb,delay});return id;},
    clearTimeout(){},
    setInterval(){return 19;},
    clearInterval(){}
  };
  const context = {
    document,console,Math,Float32Array,Promise,
    performance:{now:()=>0},
    ...scheduling,
    window:{
      AudioContext,
      matchMedia:()=>({matches:false}),
      ...scheduling,
      WWYTAudio:null
    }
  };
  vm.runInNewContext(sourceCode,context,{timeout:3000});
  assert.equal(visibleControlsCreated,0,'Live preview must not render music controls.');
  assert.equal(document.getElementById('wwyt-sample-music'),null,'No sample picker should exist.');
  assert.equal(contextsCreated,1,'Live preview should attempt autoplay once.');

  if(!autoplayAllowed) {
    assert.equal(oscillatorStarts,0,'A blocked browser must not fake automatic playback.');
    activation=true;
    for(const listener of eventHandlers.pointerdown||[])listener({target:opening});
    assert.ok(oscillatorStarts>0,'First tap must unlock default wedding music without music controls.');
  } else {
    assert.ok(oscillatorStarts>0,'A browser that permits autoplay must play wedding music on preview load.');
  }
  const initial=oscillatorStarts;
  for(const listener of eventHandlers.click||[])listener({target:opening});
  assert.equal(oscillatorStarts,initial,'Opening click must not restart an already-playing wedding intro.');

  const expectedDelay=2100-Math.min(1050,Math.floor(2100*.48));
  const transition=timers.find(timer=>timer.delay===expectedDelay);
  assert.ok(transition,'Opening-to-wedding-background crossfade must be scheduled.');
  transition.cb();
  assert.ok(oscillatorStarts>initial,'Invitation background music must overlap the opening.');
  assert.equal(visibleControlsCreated,0,'No toolbar is added during transition.');
  return {autoplayAllowed, oscillatorStarts};
}
console.log('PASS wedding-preview autoplay:', simulate(true));
console.log('PASS wedding-preview first-interaction fallback:', simulate(false));
