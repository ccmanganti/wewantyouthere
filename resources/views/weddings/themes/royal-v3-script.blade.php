<script>
(function(){
    'use strict';
    const root=document.getElementById('wedding-invite');
    if(!root || !root.classList.contains('rb-v3')) return;
    const reduced=window.matchMedia('(prefers-reduced-motion:reduce)');
    const builder=document.getElementById('wedding-builder');
    const isPreview=root.dataset.preview==='1';

    const intro=document.getElementById('rbv-intro');
    const envelope=document.getElementById('rbv-envelope');
    let finishTimer;
    function dismiss(){
        if(!intro || intro.hidden) return;
        clearTimeout(finishTimer);
        intro.classList.add('is-fading');
        intro.dataset.opening='0';
        intro.querySelector('[data-rbv-open]')?.removeAttribute('disabled');
        document.body.classList.remove('rbv-intro-locked');
        finishTimer=window.setTimeout(()=>{
            intro.hidden=true;
            intro.classList.remove('is-fading');
            envelope?.classList.remove('is-opening');
        },reduced.matches?0:780);
    }
    function open(){
        if(!intro || intro.hidden || intro.dataset.opening==='1') return;
        intro.dataset.opening='1';
        intro.querySelector('[data-rbv-open]')?.setAttribute('disabled','disabled');
        if(reduced.matches){dismiss();return;}
        envelope?.classList.add('is-opening');
        // The animation is only triggered by the click; never by a timeout on page load.
        finishTimer=window.setTimeout(dismiss,2250);
    }
    intro?.querySelector('[data-rbv-open]')?.addEventListener('click',open);
    intro?.querySelector('[data-rbv-skip]')?.addEventListener('click',dismiss);
    // Optional editor-only preview; no replay button appears on guest websites.
    document.getElementById('preview-envelope-intro')?.addEventListener('click',()=>{
        if(!intro) return;
        const websiteTab=builder?.querySelector('[data-preview-format="website"]');
        if(websiteTab)websiteTab.click();
        intro.hidden=false;
        intro.dataset.opening='0';
        intro.classList.remove('is-fading');
        envelope?.classList.remove('is-opening');
        intro.querySelector('[data-rbv-open]')?.removeAttribute('disabled');
        document.body.classList.add('rbv-intro-locked');
        intro.querySelector('[data-rbv-open]')?.focus({preventScroll:true});
    });

    if(intro && !intro.hidden){
        document.body.classList.add('rbv-intro-locked');
        intro.querySelector('[data-rbv-open]')?.focus({preventScroll:true});
    }

    function updateCalendar(){
        const widget=root.querySelector('.rbv-calendar');
        if(!widget)return;
        const input=builder?.querySelector('[name="answers[event_date]"]');
        const iso=input?.value || widget.dataset.rbvDate;
        const m=/^(\d{4})-(\d{2})-(\d{2})$/.exec(iso||'');
        if(!m)return;
        const year=Number(m[1]),month=Number(m[2])-1,day=Number(m[3]);
        const date=new Date(year,month,day);
        if(date.getFullYear()!==year || date.getMonth()!==month || date.getDate()!==day)return;
        widget.dataset.rbvDate=iso;
        const monthLabel=root.querySelector('[data-rbv-month]');
        const yearLabel=root.querySelector('[data-rbv-year]');
        const monthYear=root.querySelector('[data-rbv-monthyear]');
        const weekday=root.querySelector('[data-rbv-weekday]');
        const dayLabel=root.querySelector('[data-rbv-day]');
        const readable=date.toLocaleDateString('en-US',{month:'long'});
        if(monthLabel)monthLabel.textContent=readable;
        if(yearLabel)yearLabel.textContent=String(year);
        if(monthYear)monthYear.textContent=(readable+' '+year).toUpperCase();
        if(weekday)weekday.textContent=date.toLocaleDateString('en-US',{weekday:'long'}).toUpperCase();
        if(dayLabel)dayLabel.textContent=String(day).padStart(2,'0');
        const offset=(new Date(year,month,1).getDay()+6)%7;
        const days=new Date(year,month+1,0).getDate();
        const fragment=document.createDocumentFragment();
        for(let i=0;i<offset;i++){const blank=document.createElement('span');blank.setAttribute('aria-hidden','true');fragment.append(blank);}
        for(let i=1;i<=days;i++){
            const node=document.createElement('span');
            node.textContent=String(i);
            if(i===day){node.className='is-wedding-day';node.setAttribute('aria-current','date');}
            fragment.append(node);
        }
        root.querySelector('#rbv-calendar-days')?.replaceChildren(fragment);
        if(input)root.querySelector('.rbv-date-text')?.setAttribute('data-format', 'long');
    }
    function updateMapLinks(){
        if(!builder)return;
        for(const type of ['ceremony','reception']){
            const link=root.querySelector('[data-map-link="'+type+'"]');
            const input=builder.querySelector('[name="answers['+type+'_map_url]"]');
            if(!link || !input)continue;
            let safe='';
            try { const u=new URL(input.value.trim()); if(['https:','http:'].includes(u.protocol))safe=u.href; }catch(e){}
            link.hidden=!safe;
            if(safe)link.href=safe;else link.removeAttribute('href');
        }
    }
    function selectMap(type){
        const ceremony=root.querySelector('[name="answers[ceremony_address]"]');
        const select=(key)=>builder?.querySelector('[name="answers['+key+']"]')?.value?.trim()||'';
        const address=type==='reception' ? select('reception_address') : select('ceremony_address');
        const fallbackAddress=root.querySelector(type==='reception'?'[data-field="reception_address"]':'[data-field="ceremony_address"]')?.textContent.trim()||'';
        const location=(address||fallbackAddress).trim();
        const title=root.querySelector(type==='reception'?'[data-field="reception_venue"]':'[data-field="ceremony_venue"]')?.textContent.trim()||'';
        const frame=root.querySelector('#rbv-event-map');
        const name=root.querySelector('#rbv-map-destination');
        const link=root.querySelector('#rbv-map-external');
        if(name)name.textContent=title;
        if(frame && location){
            frame.src='https://maps.google.com/maps?q='+encodeURIComponent(location)+'&z=14&output=embed';
            frame.title=(type==='reception'?'Reception':'Ceremony')+' location map';
        }
        if(link && location){
            let mapUrl=select(type+'_map_url');
            try{const u=new URL(mapUrl);if(!['https:','http:'].includes(u.protocol))mapUrl='';}catch(e){mapUrl='';}
            link.href=mapUrl||'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(location);
        }
        root.querySelectorAll('[data-map-choice]').forEach(button=>{
            const active=button.dataset.mapChoice===type;
            button.classList.toggle('is-active',active);
            button.setAttribute('aria-pressed',String(active));
        });
    }
    root.querySelectorAll('[data-map-choice]').forEach(button=>button.addEventListener('click',()=>selectMap(button.dataset.mapChoice)));
    updateCalendar();updateMapLinks();
    window.addEventListener('wwyt:preview-updated',()=>{updateCalendar();updateMapLinks();});

    const lightbox=root.querySelector('#rbv-lightbox');
    root.querySelectorAll('[data-rbv-gallery]').forEach(button=>{
        button.addEventListener('click',()=>{
            const picture=button.querySelector('img');
            const dest=root.querySelector('#rbv-lightbox-photo');
            if(!picture||!dest||!lightbox)return;
            dest.src=picture.currentSrc||picture.src;
            dest.alt=picture.alt||'Wedding photograph';
            root.querySelector('#rbv-lightbox-caption').textContent=button.parentElement.querySelector('figcaption')?.textContent||'A beautiful memory';
            if(!lightbox.open)lightbox.showModal();
        });
    });
    root.querySelector('.rbv-lightbox-close')?.addEventListener('click',()=>lightbox?.close());
    lightbox?.addEventListener('click',event=>{if(event.target===lightbox)lightbox.close();});
    lightbox?.addEventListener('close',()=>{root.querySelector('#rbv-lightbox-photo')?.removeAttribute('src');});

    const form=root.querySelector('#rbv-rsvp-form');
    const feedback=root.querySelector('#rbv-rsvp-feedback');
    if(form){
        const attendance=()=>form.querySelector('[name="attendance"]:checked')?.value;
        const wrap=form.querySelector('[data-rbv-party-wrap]');
        const party=form.querySelector('[name="party_size"]');
        form.querySelectorAll('[name="attendance"]').forEach(radio=>radio.addEventListener('change',()=>{
            const declined=attendance()==='declined';
            if(wrap)wrap.hidden=declined;
            if(party)party.disabled=declined;
            if(feedback)feedback.textContent='';
        }));
        if(form.dataset.demo==='1'){
            form.addEventListener('submit',event=>{
                event.preventDefault();
                if(!form.reportValidity())return;
                const name=form.querySelector('[name="guest_name"]')?.value.trim()||'Guest';
                if(!attendance()){
                    if(feedback)feedback.textContent='Please select whether you can attend.';
                    return;
                }
                if(feedback)feedback.textContent='Preview only, '+name+'. Your response was not submitted.';
            });
        }
    }
    root.querySelectorAll('.rbv-menu nav a').forEach(link=>link.addEventListener('click',()=>{
        const menu=root.querySelector('.rbv-menu');if(menu)menu.open=false;
    }));

    // Deliberate once-only reveals, never SVG path animations or scroll-tied loops.
    if(!reduced.matches && 'IntersectionObserver' in window){
        const targets=Array.from(root.querySelectorAll('.rbv-grand>.rbv-title,.rbv-info .rbv-inner,.rbv-photo-pair,.rbv-timeline-step,.rbv-entourage-person,.rbv-gallery-item'));
        const observer=new IntersectionObserver(entries=>entries.forEach(e=>{
            if(!e.isIntersecting)return;
            e.target.classList.add('rbv-visible');
            observer.unobserve(e.target);
        }),{threshold:.05,rootMargin:'0px 0px 65px 0px'});
        targets.forEach(element=>{
            element.classList.add('rbv-reveal');
            if(element.getBoundingClientRect().top<window.innerHeight)element.classList.add('rbv-visible');
            observer.observe(element);
        });
        root.classList.add('rbv-motion-ready');
    }
})();
</script>