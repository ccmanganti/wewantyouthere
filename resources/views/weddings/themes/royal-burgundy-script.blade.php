<script>
(function(){
    'use strict';
    const invitation = document.querySelector('.rb-invite');
    if (!invitation || !window.IntersectionObserver || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    // IntersectionObserver fires once: no rAF loop, no tracking heart and no full-width image transforms.
    const targets = Array.from(invitation.querySelectorAll('.rb-reveal'));
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('rb-visible');
            observer.unobserve(entry.target);
        });
    }, {threshold:0.05,rootMargin:'0px 0px 70px 0px'});
    targets.forEach(node => observer.observe(node));
    invitation.classList.add('rb-motion-ready');
    // Show already visible elements without unnecessary movement.
    targets.filter(el => el.getBoundingClientRect().top < window.innerHeight).forEach(el => el.classList.add('rb-visible'));
})();
</script>
