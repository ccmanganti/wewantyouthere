<script>
(() => {
    // Botanical journal: hardcover rotates 175 degrees around the real
    // left spine. The paper underneath is an independent scene.
    const journal = document.querySelector('.ce2-olive-garden #ce2-intro');
    const cover = journal?.querySelector('[data-journal-open]');
    if(!journal || !cover)return;
    const editor = document.getElementById('wedding-builder');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let closingTimer, hideTimer, turning = false;
    function openBook(){
        if(turning)return;
        turning = true; cover.disabled = true;
        journal.classList.add('is-opening');
        closingTimer = setTimeout(()=>{
            journal.classList.add('ce2-dismissing');
            if(!editor)document.body.classList.remove('ce2-intro-open');
            hideTimer = setTimeout(()=>{journal.hidden = true;journal.setAttribute('aria-hidden','true');},reduced?0:700);
        },reduced?0:2100);
    }
    cover.addEventListener('click',openBook);
    if(editor)document.getElementById('preview-envelope-intro')?.addEventListener('click',()=>{
        clearTimeout(closingTimer);clearTimeout(hideTimer);
        turning=false;cover.disabled=false;
        document.getElementById('preview-scroll')?.scrollTo({top:0,behavior:'instant'});
        journal.hidden=false;journal.removeAttribute('aria-hidden');
        journal.classList.remove('is-opening','ce2-dismissing');
        cover.focus({preventScroll:true});
    });
    else if(!journal.hidden)document.body.classList.add('ce2-intro-open');
})();
</script>