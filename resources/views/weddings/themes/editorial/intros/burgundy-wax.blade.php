<script>
(() => {
    // Heirloom scroll: the wax medallion fractures, ribbon flies away,
    // then the parchment physically unrolls between its two rollers.
    const scene = document.querySelector('.ce2-burgundy-wax #ce2-intro');
    const seal = scene?.querySelector('[data-wax-scroll-open]');
    if (!scene || !seal) return;
    const editor = document.getElementById('wedding-builder');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let timers = [], busy = false;
    const later = (fn, ms) => { const id = window.setTimeout(fn, ms); timers.push(id); };
    function close(){
        scene.classList.add('ce2-dismissing');
        if(!editor) document.body.classList.remove('ce2-intro-open');
        later(() => { scene.hidden = true; scene.setAttribute('aria-hidden','true'); }, reduced ? 0 : 650);
    }
    function unroll(){
        if (busy) return;
        busy = true;
        seal.disabled = true;
        scene.classList.add('is-opening');
        later(close, reduced ? 0 : 2550);
    }
    function restart(){
        timers.forEach(window.clearTimeout); timers = [];
        busy = false; seal.disabled = false;
        document.getElementById('preview-scroll')?.scrollTo({top:0,behavior:'instant'});
        scene.hidden = false; scene.removeAttribute('aria-hidden');
        scene.classList.remove('ce2-dismissing','is-opening');
        seal.focus({preventScroll:true});
    }
    seal.addEventListener('click', unroll);
    if (editor) document.getElementById('preview-envelope-intro')?.addEventListener('click',restart);
    else if(!scene.hidden)document.body.classList.add('ce2-intro-open');
})();
</script>