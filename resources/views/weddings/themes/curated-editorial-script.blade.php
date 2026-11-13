<script>
(function(){
    'use strict';
    const root = document.getElementById('wedding-invite');
    if (!root || !root.classList.contains('ce2')) return;
    // Shared nonvisual services only: date/calendar, map synchronization,
    // premium RSVP form semantics and accessible public image viewing.
    // Every opening is a separate script owned by its individual template.
    const builder = document.getElementById('wedding-builder');
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function validDate(){
        const raw = builder?.querySelector('[name="answers[event_date]"]')?.value || root.dataset.ce2Date;
        if (!/^\d{4}-\d{2}-\d{2}$/.test(raw || '')) return null;
        const [year,month,day] = raw.split('-').map(Number);
        const result = new Date(year, month - 1, day);
        if (result.getFullYear() !== year || result.getMonth() !== month - 1 || result.getDate() !== day) return null;
        return result;
    }

    function updateCalendar(){
        const date = validDate();
        if (!date) return;
        root.querySelectorAll('[data-ce2-calendar]').forEach(host=>{
            const month = document.createElement('div');
            month.className = 'ce2-calendar-month';
            month.textContent = date.toLocaleDateString('en-US',{month:'long',year:'numeric'});
            const grid = document.createElement('div');
            grid.className = 'ce2-calendar-grid';
            for (const label of ['M','T','W','T','F','S','S']){
                const cell = document.createElement('span');
                cell.textContent = label;
                cell.setAttribute('aria-hidden','true');
                grid.append(cell);
            }
            const offset = (new Date(date.getFullYear(),date.getMonth(),1).getDay()+6)%7;
            for (let i=0;i<offset;i++){
                const cell = document.createElement('span');
                cell.setAttribute('aria-hidden','true');
                grid.append(cell);
            }
            const days = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
            for (let day=1;day<=days;day++){
                const cell = document.createElement('span');
                if(day === date.getDate()){
                    cell.className = 'ce2-calendar-selected';
                    cell.setAttribute('aria-current','date');
                    const content = document.createElement('b');
                    content.textContent = String(day);
                    cell.append(content);
                }else{
                    cell.textContent = String(day);
                }
                grid.append(cell);
            }
            host.replaceChildren(month,grid);
        });
    }

    updateCalendar();
    window.addEventListener('wwyt:preview-updated',updateCalendar);
    builder?.querySelector('[name="answers[event_date]"]')?.addEventListener('input',updateCalendar);

    // Update the existing paid map frames when addresses are edited, without
    // rebuilding the preview or reloading an iframe on every keystroke.
    let mapUpdateTimer = null;
    function refreshMaps(){
        if (!builder) return;
        root.querySelectorAll('[data-ce2-map-kind]').forEach(card=>{
            const kind = card.dataset.ce2MapKind;
            const value = key => builder.querySelector('[name="answers['+key+']"]')?.value?.trim() || '';
            const address = value(kind+'_address') || (kind==='ceremony' ? value('venue_address') : '');
            const placeholder = card.querySelector('[data-ce2-map-placeholder]');
            const iframe = card.querySelector('iframe');
            const link = card.querySelector('a');
            if(placeholder)placeholder.hidden=Boolean(address);
            if(iframe){
                iframe.hidden=!address;
                if(address && card.dataset.ce2LastAddress!==address){
                    iframe.src='https://maps.google.com/maps?q='+encodeURIComponent(address)+'&z=14&output=embed';
                }
                if(!address)iframe.removeAttribute('src');
            }
            if(link){
                link.hidden=!address;
                if(address){
                    let href='';
                    try{
                        const custom=new URL(value(kind+'_map_url'));
                        if(['https:','http:'].includes(custom.protocol))href=custom.href;
                    }catch(e){}
                    link.href=href||'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(address);
                }else link.removeAttribute('href');
            }
            card.dataset.ce2LastAddress=address;
        });
    }
    if(builder){
        window.addEventListener('wwyt:preview-updated',()=>{
            window.clearTimeout(mapUpdateTimer);
            mapUpdateTimer=window.setTimeout(refreshMaps,450);
        });
        refreshMaps();
    }

    root.querySelectorAll('[data-ce2-demo]').forEach(form=>{
        form.addEventListener('submit',event=>{
            event.preventDefault();
            if (!form.reportValidity()) return;
            const name = form.querySelector('input[name="guest_name"]')?.value?.trim() || 'Guest';
            const feedback = form.querySelector('[data-ce2-form-feedback]');
            if (feedback) feedback.textContent = 'Preview only, '+name+'. Your response was not sent.';
        });
    });

    root.querySelectorAll('.ce2-form').forEach(form=>{
        const updateParty = ()=>{
            const declined = form.querySelector('input[name="attendance"]:checked')?.value === 'declined';
            const group = form.querySelector('[data-ce2-guests]');
            const select = group?.querySelector('select');
            if (group) group.hidden = declined;
            if (select){ select.disabled = declined; select.required = !declined; }
        };
        form.querySelectorAll('input[name="attendance"]').forEach(input=>input.addEventListener('change',updateParty));
        updateParty();
    });

    // Each theme supplies its own reveal geometry in its dedicated stylesheet:
    // letter settles, book page unfolds, garden grows, print focuses, ticket arrives.
    const panels = Array.from(root.querySelectorAll(
        '.ce2-section:not(:first-child) h2, .ce2-section .ce2-photo, .ce2-section blockquote, .og-timeline-list>div, .po-path article, .pa-program-table>div, .dt-flight-stop'
    )).filter(el=>!el.closest('#ce2-intro'));
    if (!reduced && 'IntersectionObserver' in window){
        const observer = new IntersectionObserver(entries=>{
            for(const entry of entries){
                if(!entry.isIntersecting) continue;
                entry.target.classList.add('ce2-in-view');
                observer.unobserve(entry.target);
            }
        },{threshold:0.06,rootMargin:'0px 0px 70px 0px'});
        for(const el of panels){
            el.classList.add('ce2-animated');
            if(el.getBoundingClientRect().top < window.innerHeight && el.getBoundingClientRect().bottom > 0){
                el.classList.add('ce2-in-view');
            }
            observer.observe(el);
        }
    }

    // Non-destructive public gallery overlay. Builder interactions remain
    // dedicated to the existing photo-slot editor and upload workflow.
    if (!builder){
        const shots = Array.from(root.querySelectorAll('.ce2-photo img'));
        if(shots.length){
            const lightbox = document.createElement('dialog');
            lightbox.className = 'ce2-photo-dialog';
            lightbox.setAttribute('aria-label','Wedding photo viewer');
            const close = document.createElement('button');
            close.type = 'button'; close.className = 'ce2-lightbox-close';
            close.setAttribute('aria-label','Close wedding photo'); close.textContent = '×';
            const picture = document.createElement('img'); picture.alt = '';
            lightbox.append(close,picture); document.body.append(lightbox);
            close.addEventListener('click',()=>lightbox.close());
            lightbox.addEventListener('click',e=>{if(e.target === lightbox)lightbox.close();});
            function showPicture(img){
                picture.src = img.currentSrc || img.src;
                picture.alt = img.alt || 'Wedding photograph';
                if(typeof lightbox.showModal==='function')lightbox.showModal();
            }
            shots.forEach(img=>{
                const frame = img.closest('.ce2-photo');
                if (!frame) return;
                frame.classList.add('ce2-viewable');
                frame.tabIndex = 0;
                frame.setAttribute('role','button');
                frame.setAttribute('aria-label','View '+(img.alt || 'wedding photo'));
                frame.addEventListener('click',()=>showPicture(img));
                frame.addEventListener('keydown',e=>{
                    if(e.key==='Enter'||e.key===' '){e.preventDefault();showPicture(img);}
                });
            });
        }
    }
})();
</script>
@include('weddings.themes.editorial.intros.'.\App\Support\CuratedWeddingDesign::forTemplate($template))
