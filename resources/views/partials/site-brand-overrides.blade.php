<style>
/* WWYT platform identity, not a wedding invitation theme.
   Source palette: Cotton #EDEBDD, Cherry Red #810100, Maroon #630000, Noir Black #1B1717.
   Gold is a restrained editorial accent, not a fifth core brand color. */
:root{
    --wwyt-cotton:#EDEBDD;
    --wwyt-cherry:#810100;
    --wwyt-maroon:#630000;
    --wwyt-noir:#1B1717;
    --wwyt-gold:#B99A69;
    --cream:var(--wwyt-cotton);
    --ink:var(--wwyt-noir);
    --brand-dark:var(--wwyt-noir);
    --green:var(--wwyt-cherry);
    --green-dark:var(--wwyt-maroon);
    --gold:var(--wwyt-gold);
}
body:not(.invitation-page){background:var(--wwyt-cotton);color:var(--wwyt-noir)}
body:not(.invitation-page) .topbar{background:#1B1717;border-bottom-color:#432529}
body:not(.invitation-page) .topbar .brand span{color:#f6c9be}
body:not(.invitation-page) .nav .btn{background:#810100}
body:not(.invitation-page) .nav .btn:hover{background:#630000}
body:not(.invitation-page) .btn{background:#810100;color:#fff}
body:not(.invitation-page) .btn:hover{background:#630000}
body:not(.invitation-page) .btn-outline,body:not(.invitation-page) .btn-light{background:transparent;color:#810100;border-color:#a8787a}
body:not(.invitation-page) .btn-outline:hover,body:not(.invitation-page) .btn-light:hover{background:#81010012}
body:not(.invitation-page) .eyebrow{color:#810100}
body:not(.invitation-page) .foot{background:#1B1717;border-top-color:#653031}
/* Hero as an editorial cover: dramatic typography, cherry field, blurred abstract shadows. */
body:not(.invitation-page) .home-hero{
    background:#810100;
    background-image:radial-gradient(ellipse at 26% 50%,#57000088 0%,transparent 53%),
        radial-gradient(ellipse at 83% 33%,#cf3b2d66 0%,transparent 40%);
}
body:not(.invitation-page) .home-hero::before{
    width:490px;height:650px;top:12%;left:36%;border:none;border-radius:50%;
    background:#1B171799;filter:blur(70px);transform:rotate(-28deg);
    opacity:.7;
}
body:not(.invitation-page) .home-hero::after{
    width:460px;height:500px;right:-10%;bottom:-17%;border:none;border-radius:50%;
    background:#38000091;filter:blur(72px);
}
body:not(.invitation-page) .home-hero .eyebrow{color:#eed4b3}
body:not(.invitation-page) .home-hero h1{font-family:'DM Sans',Arial,sans-serif;font-weight:500;text-transform:uppercase;line-height:.94;letter-spacing:-.065em;font-size:clamp(45px,5.8vw,83px)}
body:not(.invitation-page) .home-hero h1 em{font-family:'DM Serif Display',Georgia,serif;text-transform:none;font-weight:400;color:#EDEBDD;letter-spacing:-.04em}
body:not(.invitation-page) .home-hero p{color:#f1ded7}
body:not(.invitation-page) .home-hero .hero-checks{color:#f3d3b9}
body:not(.invitation-page) .home-hero .btn{background:#1B1717;color:#EDEBDD;border-color:#1B1717}
body:not(.invitation-page) .home-hero .btn:hover{background:#302021}
body:not(.invitation-page) .home-hero .btn-line{background:transparent;color:#EDEBDD;border-color:#dd9697}
body:not(.invitation-page) .home-hero .btn-line:hover{background:#EDEBDD18}
body:not(.invitation-page) .home-band{background:#1B1717;border-color:#4b282b}
body:not(.invitation-page) .home-band .sep{color:#b99a69}
body:not(.invitation-page) .home-main,body:not(.invitation-page) .value-section{background:#EDEBDD}
body:not(.invitation-page) .process{background:#e6ded3}
body:not(.invitation-page) .template-visual{background:#1B1717}
body:not(.invitation-page) .template-visual-inner{background:#EDEBDD}
body:not(.invitation-page) .template-visual-inner .serif{color:#810100}
body:not(.invitation-page) .faq-section{background:#1B1717}
body:not(.invitation-page) .final-banner{background:#630000}
body:not(.invitation-page) .final-banner .btn{background:#EDEBDD;color:#630000}
body:not(.invitation-page) .final-banner .btn:hover{background:#fff}
body:not(.invitation-page) .home-heading h2{color:#1B1717}
body:not(.invitation-page) .art-paper{background:#EDEBDD;outline-color:#1B1717}
body:not(.invitation-page) .art-names{color:#810100}
body:not(.invitation-page) .art-tag{background:#1B1717}
body:not(.invitation-page) .template-card{border-color:#d3b7ad}
body:not(.invitation-page) .template-card .pill{background:#81010012;color:#630000}
body:not(.invitation-page) .draft-link{color:#810100}
body:not(.invitation-page) .process-card:before{background:#810100}
body:not(.invitation-page) .fake-section b{background:#810100}
body.builder-page{background:#1B1717}
body.builder-page .builder-app{background:#1B1717}
body.builder-page .editor-pane{background:#EDEBDD;border-color:#cdbeb0}
body.builder-page .stage-top,body.builder-page .stage-scroll,body.builder-page .stage-footer{background:#EDEBDD}
body.builder-page .preview-pane{background:#1B1717}
body.builder-page .wizard-step.is-current .step-dot{background:#810100;border-color:#810100}
body.builder-page .stage-kicker{color:#810100}
body.builder-page .group-tab.is-current{background:#810100;color:#fff}
body.builder-page .section-choice:has(input:checked){background:#8101000b;border-color:#810100}
body.builder-page .section-choice input{accent-color:#810100}
body.builder-page .plan-card.premium{background:#1B1717}
body.builder-page .preview-switch button[aria-selected=true]{background:#810100}
@media(prefers-reduced-motion:no-preference){
    body:not(.invitation-page) .template-card,body:not(.invitation-page) .process-card{
        transition:transform .23s ease,box-shadow .23s ease;
    }
    body:not(.invitation-page) .template-card:hover{transform:translateY(-5px);box-shadow:0 18px 40px #301b1a20}
    body:not(.invitation-page) .process-card:hover{transform:translateY(-3px)}
    body:not(.invitation-page) .home-hero .hero-grid>div:first-child{
        animation:wwyt-entry .6s ease-out both;
    }
    @keyframes wwyt-entry {from{opacity:0;transform:translateY(13px)}to{opacity:1;transform:translateY(0)}}
}
</style>