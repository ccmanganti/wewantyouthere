<script>
(function(){
    'use strict';
    const root=document.querySelector('.ce-invite');
    if(!root) return;
    const builder=document.getElementById('wedding-builder');
    const reduced=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const intro=root.querySelector('#ce-intro');
    const opener=root.querySelector('[data-ce-open]');
    let opening=false;
    opener?.addEventListener('click',function(){
        if(opening)return;opening=true;
        intro.classList.add('ce-opening');
        opener.disabled=true;
        window.setTimeout(function(){intro.classList.add('ce-opened');intro.setAttribute('aria-hidden','true');},reduced?0:1400);
        window.setTimeout(function(){intro.hidden=true;},reduced?0:2200);
    });
    // The intro never automatically opens: guest clicks the envelope.
    root.querySelectorAll('.ce-menu nav a').forEach(a=>a.addEventListener('click',()=>{
        const details=root.querySelector('.ce-menu');if(details)details.open=false;
    }));
    function weddingDate(){
        const value=builder?.querySelector('[name="answers[event_date]"]')?.value
            || root.querySelector('[data-ce-calendar]')?.dataset.ceCalendar;
        if(!/^\d{4}-\d{2}-\d{2}$/.test(value||''))return null;
        const [y,m,d]=value.split('-').map(Number);
        const parsed=new Date(y,m-1,d);
        if(parsed.getFullYear()!==y||parsed.getMonth()!==m-1||parsed.getDate()!==d)return null;
        return parsed;
    }
    function refreshCalendar(){
        const calendar=root.querySelector('[data-ce-calendar-grid]');
        const date=weddingDate();
        if(!calendar||!date)return;
        const first=new Date(date.getFullYear(),date.getMonth(),1);
        const end=new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
        const offset=(first.getDay()+6)%7;
        const fragment=document.createDocumentFragment();
        ['M','T','W','T','F','S','S'].forEach(day=>{
            const item=document.createElement('span');item.textContent=day;item.setAttribute('aria-hidden','true');fragment.append(item);
        });
        for(let n=0;n<offset;n++){const item=document.createElement('span');item.setAttribute('aria-hidden','true');fragment.append(item);}
        for(let n=1;n<=end;n++){
            const item=document.createElement('span');item.textContent=String(n);
            if(n===date.getDate()){item.className='ce-today';item.setAttribute('aria-current','date');}
            fragment.append(item);
        }
        calendar.replaceChildren(fragment);
        const month=root.querySelector('.ce-calendar-month');
        if(month)month.textContent=date.toLocaleDateString('en-US',{month:'long',year:'numeric'});
        refreshCountdown();
    }
    function refreshCountdown(){
        const wedding=weddingDate();
        if(!wedding)return;
        const time=builder?.querySelector('[name="answers[event_time]"]')?.value || '15:00';
        if(/^\d{2}:\d{2}$/.test(time)){
            const [h,m]=time.split(':').map(Number);wedding.setHours(h,m,0,0);
        }
        const remain=Math.max(0,wedding.getTime()-Date.now());
        const days=Math.floor(remain/86400000);
        const hours=Math.floor(remain%86400000/3600000);
        const minutes=Math.floor(remain%3600000/60000);
        const paint=(selector,n)=>{const el=root.querySelector(selector);if(el)el.textContent=String(n).padStart(2,'0');};
        paint('[data-ce-days]',days);paint('[data-ce-hours]',hours);paint('[data-ce-minutes]',minutes);
    }
    refreshCalendar();
    if(!builder)window.setInterval(refreshCountdown,60000);
    window.addEventListener('wwyt:preview-updated',refreshCalendar);
    builder?.querySelector('[name="answers[event_date]"]')?.addEventListener('input',refreshCalendar);
    builder?.querySelector('[name="answers[event_time]"]')?.addEventListener('input',refreshCountdown);
    root.querySelectorAll('[data-ce-demo]').forEach(form=>{
        form.addEventListener('submit',function(e){
            e.preventDefault();
            if(!form.reportValidity())return;
            const feedback=form.querySelector('[data-ce-form-feedback]');
            if(feedback)feedback.textContent='This is a sample preview. No RSVP was submitted.';
        });
    });
    if(!reduced&&'IntersectionObserver' in window){
        const targets=root.querySelectorAll('.ce-section:not(.ce-cover) h2,.ce-picture,.ce-calendar-shell,.ce-program-item,.ce-entourage-grid>div,.ce-gift');
        const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{
            if(!entry.isIntersecting)return;
            entry.target.classList.add('ce-visible');observer.unobserve(entry.target);
        }),{threshold:.08,rootMargin:'0px 0px 50px 0px'});
        targets.forEach(el=>{
            el.classList.add('ce-reveal');
            if(el.getBoundingClientRect().top<window.innerHeight)el.classList.add('ce-visible');
            observer.observe(el);
        });
    }
})();
</script>