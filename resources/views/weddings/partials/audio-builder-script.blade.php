<script>
(() => {
    'use strict';
    const studio = document.getElementById('wedding-music-studio');
    const builder = document.getElementById('wedding-builder');
    if(!studio || !builder || builder.dataset.hasPremium !== '1')return;

    const csrf = builder.querySelector('#wedding-form input[name="_token"]')?.value;
    const uploadUrl = studio.dataset.audioUploadUrl;
    const routeBase = studio.dataset.audioRouteBase;

    function save() {
        window.dispatchEvent(new CustomEvent('wwyt:music-changed'));
        window.WWYTAudio?.updateVolume?.();
        window.WWYTAudio?.updateEffects?.();
    }
    function panel(slot) { return studio.querySelector('[data-music-slot="'+slot+'"]'); }
    function source(slot) {
        return panel(slot)?.querySelector('input[name="audio['+slot+'][source]"]:checked')?.value || 'none';
    }
    function draw(slot) {
        const host = panel(slot);
        if(!host)return;
        host.querySelector('[data-music-library]')?.toggleAttribute('hidden',source(slot)!=='library');
        host.querySelector('[data-music-custom]')?.toggleAttribute('hidden',source(slot)!=='custom');
        save();
    }
    function message(slot, text, failed=false) {
        const area=panel(slot)?.querySelector('[data-music-status]');
        if(!area)return;
        area.textContent=text;
        area.classList.toggle('is-error',failed);
    }
    function busy(slot, working) {
        const host=panel(slot);
        host?.querySelectorAll('input[type=file],button').forEach(el=>el.disabled=working);
        host?.setAttribute('aria-busy',working?'true':'false');
    }
    async function upload(slot, file) {
        if(!file)return;
        if(!/\.(mp3|wav|ogg|m4a)$/i.test(file.name)) {
            message(slot,'Choose an MP3, WAV, OGG or M4A audio file.',true);return;
        }
        if(file.size>12*1024*1024) {
            message(slot,'This file is too large. Maximum size is 12 MB.',true);return;
        }
        busy(slot,true);message(slot,'Uploading your song…');
        const body = new FormData();body.append('slot',slot);body.append('audio',file);
        try {
            const response = await fetch(uploadUrl,{
                method:'POST',credentials:'same-origin',
                headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json'},
                body
            });
            const result = await response.json().catch(()=>({}));
            if(!response.ok)throw new Error(result.message||Object.values(result.errors||{}).flat()[0]||'Upload failed.');
            const label=panel(slot)?.querySelector('[data-music-uploaded-name]');
            if(label) {
                label.textContent='Saved: '+result.name;
                label.dataset.uploadedUrl=result.url;
            }
            const remove=panel(slot)?.querySelector('[data-music-remove]');
            if(remove)remove.hidden=false;
            const radio=panel(slot)?.querySelector('input[value="custom"]');
            if(radio){radio.checked=true;draw(slot);}
            message(slot,'Music uploaded. Preview it before publishing.');
            save();
        } catch(error) {message(slot,error.message||'Unable to upload this music.',true);}
        finally {busy(slot,false);}
    }
    async function remove(slot) {
        busy(slot,true);message(slot,'Removing music…');
        try {
            const response=await fetch(routeBase+'/'+encodeURIComponent(slot),{
                method:'DELETE',credentials:'same-origin',
                headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json'}
            });
            if(!response.ok)throw new Error('Could not remove your music.');
            const label=panel(slot)?.querySelector('[data-music-uploaded-name]');
            if(label){label.textContent='No custom music uploaded yet.';delete label.dataset.uploadedUrl;}
            const removeButton=panel(slot)?.querySelector('[data-music-remove]');
            if(removeButton)removeButton.hidden=true;
            const picker=panel(slot)?.querySelector('[data-music-upload]');
            if(picker)picker.value='';
            window.WWYTAudio?.stopPreview?.();
            message(slot,'Custom track removed. Choose a library track or upload another.');
            save();
        } catch(error){message(slot,error.message,true);}
        finally{busy(slot,false);}
    }
    for(const slot of ['intro','main']){
        const host=panel(slot);if(!host)continue;
        host.querySelectorAll('input[name="audio['+slot+'][source]"]').forEach(input=>{
            input.addEventListener('change',()=>{window.WWYTAudio?.stopPreview?.();draw(slot);});
        });
        host.querySelector('[data-music-track]')?.addEventListener('change',()=>{
            window.WWYTAudio?.stopPreview?.();save();
        });
        host.querySelector('[data-music-upload]')?.addEventListener('change',event=>upload(slot,event.target.files?.[0]));
        host.querySelector('[data-music-remove]')?.addEventListener('click',()=>remove(slot));
        host.querySelectorAll('[data-music-try]').forEach(button=>{
            let buttonTimer=null;
            button.addEventListener('click',()=>{
                const currentSource=source(slot);
                const data={
                    source:currentSource,
                    track:host.querySelector('[data-music-track]')?.value||'',
                    url:host.querySelector('[data-music-uploaded-name]')?.dataset.uploadedUrl||''
                };
                if(currentSource==='custom'&&!data.url){message(slot,'Upload your custom file first.',true);return;}
                const started=window.WWYTAudio?.preview?.(slot,data);
                if(!started){message(slot,'Preview stopped, or audio is unavailable.');button.textContent='▶ Listen to selection';return;}
                message(slot,'Preview playing. Select again to stop.');
                button.textContent='■ Stop preview';
                clearTimeout(buttonTimer);
                buttonTimer=setTimeout(()=>{button.innerHTML='<i class="fa-solid fa-play" aria-hidden="true"></i> Listen to selection';},11500);
            });
        });
        draw(slot);
    }
    studio.querySelector('[data-music-sfx]')?.addEventListener('change',save);
    const volume=studio.querySelector('[data-music-volume]');
    const output=studio.querySelector('[data-volume-output]');
    volume?.addEventListener('input',()=>{
        if(output)output.textContent=volume.value+'%';
        save();
    });
})();
</script>
