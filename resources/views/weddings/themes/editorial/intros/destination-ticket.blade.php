<script>
(() => {
    // Travel ticket: the guest may pull the perforated stub to the right
    // (mouse/touch), or tap it. A plane takes off after the ticket tears.
    const boarding = document.querySelector('.ce2-destination-ticket #ce2-intro');
    const ticket = boarding?.querySelector('[data-boarding-ticket-open]');
    const stub = ticket?.querySelector('.dt-intro-stub');
    if(!boarding || !ticket || !stub)return;
    const editor = document.getElementById('wedding-builder');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
    let startX=null, pointerId=null, closingTimer, hideTimer, boarded=false;
    function takeOff(){
        if(boarded)return;
        boarded=true;ticket.disabled=true;
        boarding.classList.add('is-opening');
        closingTimer=setTimeout(()=>{
            boarding.classList.add('ce2-dismissing');
            if(!editor)document.body.classList.remove('ce2-intro-open');
            hideTimer=setTimeout(()=>{boarding.hidden=true;boarding.setAttribute('aria-hidden','true');},reduced?0:640);
        },reduced?0:1900);
    }
    stub.addEventListener('pointerdown',event=>{
        if(boarded)return;
        startX=event.clientX;pointerId=event.pointerId;
    });
    ticket.addEventListener('pointerup',event=>{
        if(pointerId!==event.pointerId || startX===null)return;
        const travel=event.clientX-startX;
        startX=null;pointerId=null;
        if(travel>50)takeOff();
    });
    ticket.addEventListener('pointercancel',()=>{startX=null;pointerId=null;});
    ticket.addEventListener('click',takeOff);
    if(editor)document.getElementById('preview-envelope-intro')?.addEventListener('click',()=>{
        clearTimeout(closingTimer);clearTimeout(hideTimer);
        boarded=false;startX=null;pointerId=null;ticket.disabled=false;
        document.getElementById('preview-scroll')?.scrollTo({top:0,behavior:'instant'});
        boarding.hidden=false;boarding.removeAttribute('aria-hidden');
        boarding.classList.remove('is-opening','ce2-dismissing');
        ticket.focus({preventScroll:true});
    });
    else if(!boarding.hidden)document.body.classList.add('ce2-intro-open');
})();
</script>