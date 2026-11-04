<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
:root {
    --wwyt-cotton: #EDEBDD;
    --wwyt-cherry: #810100;
    --wwyt-maroon: #630000;
    --wwyt-noir: #1B1717;
}
.fi-body {font-family: 'DM Sans', sans-serif}
.fi-sidebar {background: var(--wwyt-cotton)}
.fi-sidebar-header {background: var(--wwyt-cotton)}
.fi-topbar {background: var(--wwyt-noir)}
.fi-topbar .fi-icon-btn, .fi-topbar .fi-icon, .fi-topbar .fi-topbar-item-label {color: var(--wwyt-cotton)}
.fi-sidebar-item-button {border-radius: 9px}
.fi-sidebar-item-button:hover {background: #e5d7cc}
.fi-sidebar-item.fi-active .fi-sidebar-item-button {background: #81010018}
.fi-main {scroll-behavior: smooth}
.fi-header-heading {font-family: Georgia, serif;letter-spacing:-.02em}
@media(prefers-reduced-motion:no-preference) {
    .fi-section, .fi-ta-ctn {animation:wwytAppear .28s ease-out both}
    @keyframes wwytAppear {from{opacity:.85;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
}

/* Customer authentication: an editorial split screen, native Filament form intact. */
body:has(.wwyt-auth-intro){background:#EDEBDD!important}
body:has(.wwyt-auth-intro) .fi-simple-layout{
    min-height:100dvh!important;
    background:linear-gradient(90deg,#1B1717 0%,#1B1717 46%,#EDEBDD 46%,#EDEBDD 100%);
    position:relative;
    padding:35px 30px 35px 48%!important;
    display:flex;
    align-items:center;
    justify-content:center;
}
body:has(.wwyt-auth-intro) .fi-simple-layout::before{
    content:"YOUR BIGGEST MOMENTS.\A BEAUTIFULLY INVITED.";
    position:fixed;
    z-index:0;
    left:clamp(34px,6vw,100px);
    top:25%;
    width:35%;
    white-space:pre-line;
    font:600 clamp(34px,4.4vw,65px)/1.07 'DM Sans',Arial,sans-serif;
    letter-spacing:-.075em;
    color:#EDEBDD;
    pointer-events:none;
}
body:has(.wwyt-auth-intro) .fi-simple-layout::after{
    content:"ONE LINK. EVERY DETAIL. EVERY MOMENT.";
    position:fixed;
    z-index:0;
    left:clamp(34px,6vw,100px);
    bottom:17%;
    color:#d7baa0;
    font:700 10px 'DM Sans',Arial,sans-serif;
    letter-spacing:.17em;
    pointer-events:none;
}
body:has(.wwyt-auth-intro) .fi-simple-main{
    position:relative;
    z-index:1;
    max-width:500px;
    width:100%;
    background:#fffefa;
    border:1px solid #d8c5ba;
    border-radius:14px;
    padding:clamp(22px,3.2vw,44px);
    box-shadow:0 17px 58px #1d121028;
}
body:has(.wwyt-auth-intro) .fi-simple-header{margin-bottom:18px}
body:has(.wwyt-auth-intro) .fi-simple-header-heading{font-family:Georgia,serif;letter-spacing:-.04em}
.wwyt-auth-intro{max-width:440px}
.wwyt-auth-top{display:flex;justify-content:space-between;gap:10px;align-items:start;flex-wrap:wrap;margin-bottom:19px}
.wwyt-auth-mini-label{letter-spacing:.13em;font-size:9px;color:#810100;font-weight:800}
.wwyt-auth-mini-label span{color:#ba9c72;margin:0 3px}
.wwyt-auth-home-link{font-size:10px!important;color:#675554!important;text-decoration:underline}
.wwyt-auth-tagline{font:italic 35px/1.08 Georgia,serif;letter-spacing:-.05em;color:#1B1717;margin:0 0 11px}
.wwyt-auth-text{font-size:12px;color:#72645e;line-height:1.8;margin:0 0 21px}
.wwyt-google-button{
    display:flex;justify-content:center;align-items:center;gap:12px;
    min-height:49px;border:1px solid #bdada5;border-radius:8px;
    background:#fff;color:#2c2626!important;text-decoration:none!important;
    font-size:13px;font-weight:800;
    transition:background .2s,border-color .2s,transform .2s;
}
.wwyt-google-button:hover{background:#f8eee9;border-color:#810100;transform:translateY(-1px)}
.wwyt-auth-google-note{font-size:11px;line-height:1.5;background:#f7f0e9;color:#6e5c55;border:1px solid #e1d3cb;padding:11px 12px;border-radius:7px;margin:0}
.wwyt-auth-divider{display:flex;align-items:center;gap:11px;color:#98817b;font-size:9px;letter-spacing:.1em;font-weight:800;margin:21px 0 4px}
.wwyt-auth-divider::before,.wwyt-auth-divider::after{content:'';height:1px;background:#d8c7bd;flex:1}
.wwyt-auth-error{padding:11px 13px;border-radius:7px;border:1px solid #d5a1a0;background:#fff0ee;color:#720b09;font-size:12px;margin:0 0 15px}
body:has(.wwyt-auth-intro) .fi-btn-primary{background:#810100!important}
body:has(.wwyt-auth-intro) .fi-btn-primary:hover{background:#630000!important}
body:has(.wwyt-auth-intro) input:focus-visible,body:has(.wwyt-auth-intro) a:focus-visible{outline:2px solid #a88458;outline-offset:3px}
@media(max-width:980px){
    body:has(.wwyt-auth-intro) .fi-simple-layout{
        background:#EDEBDD!important;padding:35px 20px!important;
    }
    body:has(.wwyt-auth-intro) .fi-simple-layout::before,
    body:has(.wwyt-auth-intro) .fi-simple-layout::after{display:none}
    body:has(.wwyt-auth-intro) .fi-simple-main{max-width:520px;margin:auto}
}
@media(max-width:520px){
    body:has(.wwyt-auth-intro) .fi-simple-layout{padding:18px 12px!important}
    body:has(.wwyt-auth-intro) .fi-simple-main{padding:24px 20px;border-radius:11px}
    .wwyt-auth-tagline{font-size:29px}
}
@media(prefers-reduced-motion:reduce){
    .wwyt-google-button{transition:none}
}


/* Shared brand shell: the customer dashboard uses the same language as the homepage. */
.fi-body:not(:has(.wwyt-auth-intro)){background:#f5efe7!important}
.fi-topbar{background:#1B1717!important;border-bottom:1px solid #493234!important;box-shadow:0 8px 23px #1b171715}
.fi-topbar .fi-logo{height:2.7rem;max-width:235px;object-fit:contain}
.fi-topbar .fi-topbar-start{display:flex;align-items:center;gap:20px}
.fi-topbar .fi-icon-btn,.fi-topbar .fi-topbar-item-label,.fi-topbar svg{color:#EDEBDD}
.fi-sidebar,.fi-sidebar-header{background:#EDEBDD!important}
.fi-sidebar{border-right:1px solid #d9c5b8!important}
.fi-sidebar-header{border-bottom:1px solid #d9c5b8}
.fi-sidebar-header .fi-logo{height:3.25rem;width:auto;object-fit:contain}
.fi-sidebar-nav{padding-top:24px!important}
.fi-sidebar-item{margin-bottom:3px}
.fi-sidebar-item-button{min-height:44px;padding:10px 13px!important;color:#4b3b37!important;transition:background .16s ease,transform .16s ease}
.fi-sidebar-item-button:hover{background:#e5d6c8!important;transform:translateX(2px)}
.fi-sidebar-item.fi-active .fi-sidebar-item-button{background:#81010016!important;border-left:3px solid #810100;color:#630000!important}
.fi-sidebar-item.fi-active .fi-sidebar-item-label{color:#630000;font-weight:800}
.fi-main-ctn{background:#f7f2ec}
.fi-main{max-width:1500px!important;margin:0 auto}
.fi-header-heading{font-family:Georgia,serif!important;font-size:clamp(28px,2.7vw,38px)!important;color:#281c1d!important;letter-spacing:-.045em}
.fi-section,.fi-ta-ctn{border:1px solid #e4d4c9;border-radius:14px;background:#fffdf9;box-shadow:0 9px 22px #4d1b1608}
.fi-btn-primary{background:#810100!important}
.fi-btn-primary:hover{background:#630000!important}
.fi-sidebar .fi-sidebar-item-icon{color:#8c5856}
.wwyt-panel-topnav{display:flex;align-items:center;gap:7px;margin-inline-start:12px}
.wwyt-panel-topnav a{color:#EDEBDD!important;font-size:12px;font-weight:700;padding:10px 13px;border-radius:8px;white-space:nowrap;text-decoration:none;transition:background .18s ease,color .18s ease}
.wwyt-panel-topnav a:hover,.wwyt-panel-topnav a[aria-current=page]{background:#810100;color:#fff!important}
.wwyt-sidebar-footer{padding:17px 17px 25px;border-top:1px solid #dbc9bb;margin-top:20px}
.wwyt-sidebar-brand-stamp{display:flex;gap:11px;align-items:center;color:#630000;margin-bottom:18px}
.wwyt-sidebar-brand-stamp img{width:37px;height:37px;flex:none}
.wwyt-sidebar-brand-stamp strong{font:italic 14px Georgia,serif;display:block;line-height:1.3}
.wwyt-sidebar-brand-stamp span{display:block;font-size:10px;color:#846f64;line-height:1.6}
.wwyt-sidebar-back,.wwyt-sidebar-explore{display:flex;align-items:center;gap:9px;text-decoration:none;font-size:12px;font-weight:700;padding:10px 12px;border-radius:8px}
.wwyt-sidebar-back{background:#1B1717;color:#EDEBDD!important}
.wwyt-sidebar-back:hover{background:#630000}
.wwyt-sidebar-explore{color:#810100!important;margin-top:6px}
.wwyt-sidebar-explore:hover{background:#8101000d}
.wwyt-auth-global-nav{
    position:fixed;z-index:100;left:0;right:0;top:0;
    min-height:77px;display:flex;align-items:center;justify-content:space-between;
    padding:9px clamp(18px,4vw,66px);gap:25px;background:#1B1717;border-bottom:1px solid #4b2a2b;
    box-shadow:0 6px 22px #1b17171e;
}
.wwyt-auth-nav-brand{display:inline-flex;align-items:center;flex:none}
.wwyt-auth-nav-brand img{width:218px;height:54px;object-fit:contain}
.wwyt-auth-nav-links{display:flex;align-items:center;gap:clamp(12px,2vw,30px)}
.wwyt-auth-nav-links a{color:#EDEBDD!important;font-size:12px;font-weight:700;text-decoration:none;white-space:nowrap}
.wwyt-auth-nav-links a:hover{color:#eacda0!important}
.wwyt-auth-nav-links a.wwyt-auth-nav-cta{display:inline-flex;align-items:center;justify-content:center;background:#810100;padding:12px 16px;border-radius:7px}
.wwyt-auth-nav-links a.wwyt-auth-nav-cta:hover{background:#a31116;color:#fff!important}
body:has(.wwyt-auth-global-nav) .fi-simple-layout{padding-top:114px!important;min-height:100dvh}
body:has(.wwyt-auth-global-nav) .wwyt-auth-home-link{display:none}
.wwyt-login-seal{width:70px;height:70px;display:block;object-fit:contain;margin:-5px 0 18px}
@media(max-width:1350px){.wwyt-panel-topnav a{padding:9px 9px;font-size:11px}}
@media(max-width:1080px){.wwyt-panel-topnav{display:none}}
@media(max-width:720px){
    .wwyt-auth-global-nav{min-height:69px;padding:8px 15px}
    .wwyt-auth-nav-brand img{width:162px;height:41px}
    .wwyt-auth-nav-links{gap:8px}
    .wwyt-auth-nav-links .wwyt-hide-mobile,.wwyt-auth-nav-links a[href$='/wedding-invitation-templates']{display:none}
    .wwyt-auth-nav-links a{font-size:11px}
    .wwyt-auth-nav-links a.wwyt-auth-nav-cta{padding:9px 11px}
    .fi-header-heading{font-size:29px!important}
}
@media(max-width:380px){.wwyt-auth-nav-links a:first-child{display:none}}
@media(prefers-reduced-motion:reduce){
    .fi-sidebar-item-button,.wwyt-panel-topnav a,.wwyt-auth-nav-links a{transition:none!important}
    .fi-section,.fi-ta-ctn{animation:none!important}
}


/* Logos in dark header, cotton sidebar, and pale login form are independent. */
.wwyt-dynamic-brand{display:inline-flex;align-items:center;height:100%;min-height:42px;max-width:235px}
.wwyt-dynamic-brand img{height:100%;max-height:54px;width:auto;max-width:235px;object-fit:contain}
.wwyt-dynamic-brand .wwyt-logo-color{display:none}
.fi-sidebar-header .wwyt-dynamic-brand .wwyt-logo-light,.fi-simple-header .wwyt-dynamic-brand .wwyt-logo-light{display:none}
.fi-sidebar-header .wwyt-dynamic-brand .wwyt-logo-color,.fi-simple-header .wwyt-dynamic-brand .wwyt-logo-color{display:block}


/* Strong font icons on customer surfaces replace thin decorative arrows. */
.wwyt-panel-topnav .fa-solid,.wwyt-sidebar-footer .fa-solid,.wwyt-dashboard .fa-solid,.wwyt-auth-global-nav .fa-solid{font-size:1em;line-height:1}
.wwyt-dashboard .wwyt-dash-quick .arrow i{font-size:12px;color:#810100}
.wwyt-google-icon{font-size:20px;background:linear-gradient(45deg,#4285F4 0 35%,#34A853 35% 53%,#FBBC05 53% 68%,#EA4335 68%);-webkit-background-clip:text;background-clip:text;color:transparent}
.fi-sidebar-item .fi-sidebar-item-icon{width:20px;height:20px}
.fi-sidebar-item .fi-sidebar-item-icon svg{stroke-width:2.5}
@media(prefers-reduced-motion:reduce){.wwyt-sidebar-footer .fa-solid,.wwyt-dashboard .fa-solid{transition:none}}
</style>
