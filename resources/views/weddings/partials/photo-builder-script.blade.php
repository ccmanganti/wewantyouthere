<script>
(function () {
    'use strict';
    const app = document.getElementById('wedding-builder');
    if (!app || app.dataset.photosEnabled !== '1') return;

    const cards = Array.from(app.querySelectorAll('[data-photo-card]'));
    const preview = document.getElementById('wedding-invite');
    const viewport = document.getElementById('preview-scroll');
    const csrf = document.querySelector('#wedding-form input[name="_token"]')?.value;
    const uploadUrl = app.dataset.photoUploadUrl;
    const uploadedKeys = new Set(
        cards.filter(card => !!card.querySelector('[data-photo-card-preview] img'))
            .map(card => card.dataset.photoCard)
    );
    const baseDraftUrl = uploadUrl; // /templates/wedding/{slug}/photos

    function cardFor(slot) { return cards.find(c => c.dataset.photoCard === slot); }
    function photoTarget(slot) {
        return Array.from(preview.querySelectorAll('[data-photo-slot]')).find(el => el.dataset.photoSlot === slot);
    }
    function selectedSlot(slot, scroll = true) {
        const card = cardFor(slot);
        const target = photoTarget(slot);
        if (!card || !target) return;
        cards.forEach(c => c.classList.toggle('is-focused', c === card));
        preview.querySelectorAll('[data-photo-slot]').forEach(el => el.classList.toggle('is-photo-focused', el === target));

        if (!scroll) return;
        const tab = app.querySelector('[data-preview-format="website"]');
        if (tab && tab.getAttribute('aria-selected') !== 'true') tab.click();
        if (target.closest('[hidden]')) {
            const note = card.querySelector('[data-photo-status]');
            if (note) note.textContent = 'This photo appears when its section is enabled.';
            return;
        }
        const top = target.getBoundingClientRect().top - viewport.getBoundingClientRect().top
            + viewport.scrollTop - 72;
        viewport.scrollTo({top:Math.max(0, top),behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth'});
        card.scrollIntoView({block:'nearest',behavior:'auto'});
    }

    function status(slot, message, failed = false) {
        const el = cardFor(slot)?.querySelector('[data-photo-status]');
        if (!el) return;
        el.textContent = message;
        el.classList.toggle('is-error', failed);
    }

    function setImage(slot, url) {
        const card = cardFor(slot);
        const box = card?.querySelector('[data-photo-card-preview]');
        if (!box) return;
        let thumb = box.querySelector('img');
        if (url) {
            if (!thumb) {
                box.replaceChildren();
                thumb = document.createElement('img');
                thumb.alt = card.querySelector('strong')?.textContent || 'Your wedding photo';
                box.append(thumb);
            }
            thumb.src = url;
        } else {
            box.replaceChildren();
            const placeholder = document.createElement('div');
            placeholder.className = 'photo-slot-placeholder';
            placeholder.innerHTML = '<i class="fa-solid fa-image" aria-hidden="true"></i><small>No photo yet</small>';
            box.append(placeholder);
        }

        app.querySelectorAll('[data-photo-edit="' + slot + '"]').forEach(button => {
            if (button.classList.contains('rb-cover-edit')) return;
            button.innerHTML = '<i class="fa-solid fa-camera" aria-hidden="true"></i>' + (url ? ' Replace photo' : ' Add photo');
        });
        const target = photoTarget(slot);
        if (target) {
            if (target.classList.contains('rb-cover-photo')) {
                target.style.backgroundImage = url ? 'url("' + url.replaceAll('"', '') + '")' : '';
            } else {
                let img = target.querySelector('[data-slot-img]');
                if (url) {
                    if (!img) {
                        img = document.createElement('img');
                        img.dataset.slotImg = slot;
                        img.alt = card.querySelector('strong')?.textContent || 'Wedding photo';
                        target.prepend(img);
                    }
                    img.src = url;
                    target.querySelector('.rb-photo-empty')?.remove();
                } else {
                    img?.remove();
                    if (!target.querySelector('.rb-photo-empty')) {
                        const placeholder = document.createElement('div');
                        placeholder.className = 'rb-photo-empty';
                        const symbol = document.createElement('span');
                        symbol.setAttribute('aria-hidden','true');
                        symbol.textContent = '✦';
                        const desc = document.createElement('small');
                        desc.textContent = card.querySelector('strong')?.textContent || 'Your photograph';
                        placeholder.append(symbol,desc);
                        target.prepend(placeholder);
                    }
                }
            }
        }
        const remove = card.querySelector('[data-photo-remove]');
        if (remove) remove.hidden = !url;
        const fileLabel = card.querySelector('.photo-slot-upload');
        if (fileLabel) {
            fileLabel.childNodes.forEach(node => {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim()) {
                    node.textContent = url ? ' Replace' : ' Upload';
                }
            });
        }
        if (url) uploadedKeys.add(slot);
        else uploadedKeys.delete(slot);
    }

    async function optimizeFile(file) {
        // Client-side image resizing keeps invitation websites lightweight and
        // strips incidental camera EXIF metadata in supported browsers.
        if (!window.createImageBitmap || !HTMLCanvasElement.prototype.toBlob) return file;
        let bitmap;
        try {
            bitmap = await createImageBitmap(file);
            const scale = Math.min(1, 2000 / Math.max(bitmap.width, bitmap.height));
            const canvas = document.createElement('canvas');
            canvas.width = Math.max(1, Math.round(bitmap.width * scale));
            canvas.height = Math.max(1, Math.round(bitmap.height * scale));
            canvas.getContext('2d').drawImage(bitmap, 0, 0, canvas.width, canvas.height);
            const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/webp', .84));
            if (!blob || blob.type !== 'image/webp' || blob.size >= file.size) return file;
            return new File([blob], file.name.replace(/\\.[^.]+$/, '') + '.webp', {type:'image/webp'});
        } catch (error) {
            return file; // Older browsers can send the original validated file.
        } finally {
            bitmap?.close?.();
        }
    }

    async function upload(slot, file) {
        if (!file) return;
        const allowed = ['image/jpeg','image/png','image/webp'];
        if (!allowed.includes(file.type) || file.size > 5 * 1024 * 1024) {
            status(slot, 'Choose a JPEG, PNG or WebP image under 5 MB.', true);
            return;
        }
        const input = cardFor(slot)?.querySelector('[data-photo-input]');
        if (input) input.disabled = true;
        status(slot, 'Uploading securely…');
        try {
            const body = new FormData();
            body.append('slot',slot);
            body.append('photo',await optimizeFile(file));
            const response = await fetch(uploadUrl,{
                method:'POST',
                credentials:'same-origin',
                headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json'},
                body,
            });
            const result = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(result.message || Object.values(result.errors||{}).flat()[0] || 'Could not upload photo');
            setImage(slot,result.url);
            status(slot,'Saved! Your photo is visible in the preview.');
            selectedSlot(slot,true);
        } catch (error) {
            status(slot,error.message || 'Upload failed. Try again.',true);
        } finally {
            if (input) {input.disabled = false;input.value = '';}
        }
    }

    async function remove(slot) {
        if (!uploadedKeys.has(slot)) return;
        if (!window.confirm('Remove this photo from your draft?')) return;
        status(slot,'Removing photo…');
        try {
            const response = await fetch(baseDraftUrl + '/' + encodeURIComponent(slot),{
                method:'DELETE',
                credentials:'same-origin',
                headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json'},
            });
            if (!response.ok) throw new Error('Unable to remove photo');
            setImage(slot,null);
            status(slot,'Photo removed.');
        } catch(error){status(slot,error.message,true);}
    }

    cards.forEach(card=>{
        const slot=card.dataset.photoCard;
        card.querySelector('[data-photo-locate]')?.addEventListener('click',()=>selectedSlot(slot,true));
        card.querySelector('[data-photo-input]')?.addEventListener('change',event=>upload(slot,event.target.files?.[0]));
        card.querySelector('[data-photo-remove]')?.addEventListener('click',()=>remove(slot));
        card.addEventListener('mouseenter',()=>selectedSlot(slot,false));
        card.addEventListener('focusin',()=>selectedSlot(slot,false));
    });

    preview.querySelectorAll('[data-photo-edit]').forEach(button=>{
        button.addEventListener('click',event=>{
            event.preventDefault();
            const slot=button.dataset.photoEdit;
            selectedSlot(slot,true);
            cardFor(slot)?.querySelector('[data-photo-input]')?.click();
        });
    });
})();
</script>