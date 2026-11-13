<script>
(() => {
    // Conservatory gates: two hinged photo-backed panels separate, while
    // distinct bloom particles drift over the threshold into the garden.
    const gate = document.querySelector('.ce2-painted-orchard #ce2-intro');
    const entry = gate?.querySelector('[data-garden-gate-open]');
    if(!gate || !entry)return;
    const editor = document.getElementById('wedding-builder');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let revealTimer, endTimer, entered=false;
    function enterGarden(){
        if(entered)return;
        entered=true;entry.disabled=true;
        gate.classList.add('is-opening');
        if(!reduced){
            for(let i=0;i<13;i++){
                const petal=document.createElement('span');
                petal.className='po-floating-petal';
                petal.textContent=i%3===0?'✿':'❀';
                petal.style.setProperty('--index',String(i));
                petal.setAttribute('aria-hidden','true');
                gate.append(petal);
            }
        }
        revealTimer=setTimeout(()=>{
            gate.classList.add('ce2-dismissing');
            if(!editor)document.body.classList.remove('ce2-intro-open');
            endTimer=setTimeout(()=>{gate.hidden=true;gate.setAttribute('aria-hidden','true');},reduced?0:750);
        },reduced?0:2300);
    }
    entry.addEventListener('click',enterGarden);
    if(editor)document.getElementById('preview-envelope-intro')?.addEventListener('click',()=>{
        clearTimeout(revealTimer);clearTimeout(endTimer);
        entered=false;entry.disabled=false;
        gate.querySelectorAll('.po-floating-petal').forEach(el=>el.remove());
        document.getElementById('preview-scroll')?.scrollTo({top:0,behavior:'instant'});
        gate.hidden=false;gate.removeAttribute('aria-hidden');
        gate.classList.remove('is-opening','ce2-dismissing');
        entry.focus({preventScroll:true});
    });
    else if(!gate.hidden)document.body.classList.add('ce2-intro-open');
})();
</script>