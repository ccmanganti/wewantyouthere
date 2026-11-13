<script>
(() => {
    // Fashion editorial: a shutter-like flash and theatrical velvet curtains.
    // Neither opening markup nor control is shared with any stationery design.
    const stage = document.querySelector('.ce2-pearl-editorial #ce2-intro');
    const reveal = stage?.querySelector('[data-editorial-reveal]');
    if(!stage || !reveal)return;
    const editor = document.getElementById('wedding-builder');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let flashTimer, fadeTimer, hideTimer, showing=false;
    function start(){
        if(showing)return;showing=true;reveal.disabled=true;
        stage.classList.add('is-opening');
        flashTimer=setTimeout(()=>stage.classList.add('pa-flash-frame'),reduced?0:1050);
        fadeTimer=setTimeout(()=>{
            stage.classList.add('ce2-dismissing');
            if(!editor)document.body.classList.remove('ce2-intro-open');
            hideTimer=setTimeout(()=>{stage.hidden=true;stage.setAttribute('aria-hidden','true');},reduced?0:720);
        },reduced?0:2270);
    }
    reveal.addEventListener('click',start);
    if(editor)document.getElementById('preview-envelope-intro')?.addEventListener('click',()=>{
        clearTimeout(flashTimer);clearTimeout(fadeTimer);clearTimeout(hideTimer);
        showing=false;reveal.disabled=false;
        document.getElementById('preview-scroll')?.scrollTo({top:0,behavior:'instant'});
        stage.hidden=false;stage.removeAttribute('aria-hidden');
        stage.classList.remove('is-opening','pa-flash-frame','ce2-dismissing');
        reveal.focus({preventScroll:true});
    });
    else if(!stage.hidden)document.body.classList.add('ce2-intro-open');
})();
</script>