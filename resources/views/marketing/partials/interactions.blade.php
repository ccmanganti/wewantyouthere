<script>
(function () {
    'use strict';
    const root = document.querySelector('.mkt');
    if (!root) return;

    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-revealed');
                observer.unobserve(entry.target);
            });
        }, {threshold:0.07, rootMargin:'0px 0px -18px 0px'});
        root.querySelectorAll('.mkt-reveal').forEach(node => observer.observe(node));
    } else {
        root.querySelectorAll('.mkt-reveal').forEach(node => node.classList.add('is-revealed'));
    }

    const dialog = root.querySelector('[data-template-dialog]');
    const frame = root.querySelector('[data-dialog-frame]');
    let opener = null;

    root.querySelectorAll('[data-preview-open]').forEach(button => {
        button.addEventListener('click', function () {
            const url = button.dataset.previewUrl;
            if (!url) return;
            if (!dialog || !dialog.showModal) {
                window.open(url, '_blank', 'noopener,noreferrer');
                return;
            }
            opener = button;
            root.querySelector('[data-dialog-title]').textContent = button.dataset.previewTitle || 'Website preview';
            frame.src = url;
            dialog.showModal();
        });
    });

    if (dialog) {
        dialog.querySelector('[data-dialog-close]').addEventListener('click', () => dialog.close());
        dialog.addEventListener('close', () => {
            frame.removeAttribute('src');
            frame.src = 'about:blank';
            if (opener) opener.focus();
            opener = null;
        });
        dialog.addEventListener('click', event => {
            if (event.target === dialog) dialog.close();
        });
    }

    const search = document.getElementById('mkt-template-search');
    if (search) {
        search.addEventListener('input', function () {
            const query = search.value.trim().toLowerCase();
            let shown = 0;
            root.querySelectorAll('[data-template-card]').forEach(card => {
                const match = !query || card.dataset.search.includes(query);
                card.hidden = !match;
                if (match) shown++;
            });
            const count = document.getElementById('mkt-template-count');
            if (count) count.textContent = shown + (shown === 1 ? ' design available' : ' designs available');
            const empty = document.getElementById('mkt-template-empty');
            if (empty) empty.hidden = shown > 0;
        });
    }

    const hero = root.querySelector('.mkt-hero');
    const orb = root.querySelector('.mkt-hero-orb');
    if (hero && orb && window.matchMedia('(pointer:fine)').matches &&
        !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        hero.addEventListener('pointermove', function (event) {
            const rect = hero.getBoundingClientRect();
            const x = (event.clientX - rect.left) / Math.max(1,rect.width) - .5;
            const y = (event.clientY - rect.top) / Math.max(1,rect.height) - .5;
            orb.style.transform = 'translate3d('+(x*18)+'px,'+(y*18)+'px,0)';
        }, {passive:true});
    }
})();
</script>
