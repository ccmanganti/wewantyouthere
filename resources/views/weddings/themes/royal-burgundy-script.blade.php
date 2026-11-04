<script>
(function () {
    'use strict';
    const invitation = document.querySelector('.rb-invite');
    if (!invitation) return;

    // Gentle section reveals are one-shot and opt out when reduced motion is enabled.
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
    if ('IntersectionObserver' in window && !reduced.matches) {
        const items = Array.from(invitation.querySelectorAll('.rb-reveal'));
        const observer = new IntersectionObserver(entries => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                entry.target.classList.add('rb-visible');
                observer.unobserve(entry.target);
            }
        }, {threshold:0.05,rootMargin:'0px 0px 70px 0px'});
        items.forEach(el => observer.observe(el));
        invitation.classList.add('rb-motion-ready');
        items.filter(el => el.getBoundingClientRect().top < innerHeight + 50)
            .forEach(el => el.classList.add('rb-visible'));
    }

    function updateCalendar() {
        const widget = invitation.querySelector('[data-rb-calendar]');
        if (!widget) return;
        const input = document.querySelector('#wedding-form [data-question="event_date"]');
        const raw = input?.value || widget.dataset.date;
        const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(raw || '');
        if (!match) return;
        const year = +match[1], month = +match[2], day = +match[3];
        const date = new Date(year, month-1, day);
        if (date.getFullYear() !== year || date.getMonth() !== month-1 || date.getDate() !== day) return;
        const monthName = date.toLocaleDateString('en-US',{month:'long'});
        const monthTitle = invitation.querySelector('[data-rb-calendar-month]');
        const yearLabel = invitation.querySelector('[data-rb-calendar-year]');
        if (monthTitle) monthTitle.textContent = monthName;
        if (yearLabel) yearLabel.textContent = year;
        const days = widget.querySelector('[data-rb-calendar-days]');
        const firstOffset = (new Date(year,month-1,1).getDay()+6)%7;
        const daysCount = new Date(year,month,0).getDate();
        const fragment = document.createDocumentFragment();
        for (let i=0;i<firstOffset;i++) {
            const blank=document.createElement('span');
            blank.className='rb-cal-empty';
            blank.setAttribute('aria-hidden','true');
            fragment.append(blank);
        }
        for (let i=1;i<=daysCount;i++) {
            const cell=document.createElement('span');
            cell.className='rb-day'+(day===i?' rb-day-selected':'');
            cell.textContent=String(i);
            if(day===i) cell.setAttribute('aria-current','date');
            fragment.append(cell);
        }
        days.replaceChildren(fragment);
        widget.setAttribute('aria-label', 'Wedding day '+monthName+' '+day+', '+year);
        widget.dataset.date = raw;
    }
    window.addEventListener('wwyt:preview-updated', updateCalendar);

    // An actual image-layer envelope animation (WebP), never an SVG stroke.
    const intro = invitation.querySelector('[data-envelope-intro]');
    if (!intro) return;
    const skip = intro.querySelector('[data-envelope-skip]');
    const replayButton = document.getElementById('replay-envelope-intro');
    const key = 'wwyt:envelope:played:' + location.pathname;
    const builder = Boolean(document.getElementById('wedding-builder'));
    let openTimer, closeTimer, fadeTimer, playing=false;

    function remember() {
        if (intro.dataset.envelopeAutoplay !== '1') return;
        try {sessionStorage.setItem(key,'1');} catch (e) { /* privacy mode */ }
    }
    function finish() {
        clearTimeout(openTimer);
        clearTimeout(closeTimer);
        clearTimeout(fadeTimer);
        playing=false;
        intro.classList.add('rb-leaving');
        document.body.classList.remove('rb-envelope-locked');
        remember();
        fadeTimer=setTimeout(() => {
            intro.hidden=true;
            intro.classList.remove('rb-leaving');
            intro.dataset.envelopePhase='closed';
            if (builder) replayButton?.focus({preventScroll:true});
        }, reduced.matches?0:470);
    }
    function play() {
        clearTimeout(openTimer);
        clearTimeout(closeTimer);
        clearTimeout(fadeTimer);
        if (builder) {
            document.querySelector('[data-preview-format="website"]')?.click();
            document.getElementById('mobile-preview')?.click();
        }
        playing=true;
        intro.hidden=false;
        intro.classList.remove('rb-leaving');
        intro.dataset.envelopePhase='closed';
        if (!builder) document.body.classList.add('rb-envelope-locked');
        skip?.focus({preventScroll:true});
        if (reduced.matches) {
            finish();
            return;
        }
        openTimer=setTimeout(() => {
            if (playing) intro.dataset.envelopePhase='opening';
        }, 340);
        closeTimer=setTimeout(finish, 3300);
    }
    skip?.addEventListener('click',finish);
    replayButton?.addEventListener('click',play);
    window.WWYTEnvelope = {replay:play,skip:finish};

    let seen=false;
    try {seen = sessionStorage.getItem(key)==='1';} catch (e) { /* storage blocked */ }
    if (intro.dataset.envelopeAutoplay==='1' && !seen && !reduced.matches) {
        // Defer until first paint; do not block content if CSS/imagery is unavailable.
        const start = () => {if (!document.hidden) play();};
        if (document.readyState==='complete') setTimeout(start, 130);
        else window.addEventListener('load', () => setTimeout(start,130),{once:true});
    }
})();
</script>