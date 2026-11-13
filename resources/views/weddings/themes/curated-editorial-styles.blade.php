<style>
@import url('https://fonts.googleapis.com/css2?family=Allura&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;0,6..96,500;1,6..96,400&family=Caveat:wght@400;600&family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap');
.ce2{position:relative;isolation:isolate;width:100%;overflow:hidden;background:#faf8f0;color:#302b29}
.ce2 *, .ce2 *::before, .ce2 *::after{box-sizing:border-box}
.ce2 [hidden]{display:none!important}
.ce2 figure,.ce2 h1,.ce2 h2,.ce2 h3,.ce2 p,.ce2 blockquote{margin:0}
.ce2 a{color:inherit}
.ce2 .ce2-photo{position:relative;min-width:0;background:#e9e2d8;overflow:hidden}
.ce2 .ce2-photo img{display:block;width:100%;height:100%;object-fit:cover;object-position:center;transition:transform .7s ease}
.ce2 .ce2-photo:hover img{transform:scale(1.035)}
.ce2 .ce2-photo-empty{height:100%;min-height:180px;display:grid;place-content:center;text-align:center;gap:10px;padding:18px;color:#7d746a;font:600 10px/1.5 'DM Sans',sans-serif;letter-spacing:.14em;text-transform:uppercase}
.ce2 .ce2-photo-empty>span{font-size:30px}
.ce2 .ce2-form{display:grid;gap:17px;text-align:left;max-width:460px;margin:28px auto 0;font:600 12px/1.5 'DM Sans',sans-serif}
.ce2 .ce2-form label{display:grid;gap:7px}
.ce2 .ce2-form input:not([type=radio]),.ce2 .ce2-form textarea,.ce2 .ce2-form select{display:block;width:100%;padding:12px 14px;border:1px solid #c7bbb0;border-radius:3px;background:#fffefb;color:#302b29;min-height:46px;font:400 14px/1.5 'DM Sans',sans-serif}
.ce2 .ce2-form input:focus-visible,.ce2 .ce2-form select:focus-visible,.ce2 .ce2-form textarea:focus-visible{outline:2px solid currentColor;outline-offset:2px}
.ce2 .ce2-form fieldset{border:0;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:12px 20px}
.ce2 .ce2-form legend{font-weight:700;margin-bottom:9px}
.ce2 .ce2-form fieldset label{display:flex;flex-direction:row;align-items:center;gap:7px;cursor:pointer}
.ce2 .ce2-form fieldset label input{accent-color:currentColor}
.ce2 .ce2-form button{border:0;cursor:pointer;padding:16px 20px;background:#2e2828;color:#fff;letter-spacing:.1em;font:700 11px 'DM Sans',sans-serif}
.ce2 .ce2-form button:hover{filter:brightness(1.2)}
.ce2 .ce2-form .ce2-trap{position:absolute;left:-9999px}
.ce2 .ce2-form .ce2-feedback{min-height:1.2em;font-size:12px}
.ce2 .ce2-premium-maps{padding:90px 20px;text-align:center}
.ce2 .ce2-premium-maps h2{font:400 clamp(36px,6vw,66px)/1.1 Georgia,serif;margin:15px 0 35px}
.ce2 .ce2-map-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr));gap:25px;max-width:1000px;margin:auto}
.ce2 .ce2-map-card{padding:18px;border:1px solid currentColor;min-width:0}
.ce2 .ce2-map-card h3{font:400 29px Georgia,serif}
.ce2 .ce2-map-card iframe{width:100%;height:280px;border:0;margin:15px 0}
.ce2 .ce2-map-card a{font:700 11px 'DM Sans',sans-serif;letter-spacing:.1em}
.ce2 .ce2-intro{position:fixed;inset:0;z-index:10000;display:grid;place-items:center;overflow:hidden;perspective:1400px;transition:opacity .8s ease,visibility .8s ease}
.ce2 .ce2-intro.ce2-dismissing{opacity:0;visibility:hidden;pointer-events:none}
.ce2 .ce2-intro button{cursor:pointer;-webkit-tap-highlight-color:transparent}
.ce2 .ce2-intro button:focus-visible{outline:3px solid #e8c594;outline-offset:7px}
.ce2 .ce2-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:5px;font:500 11px/1.4 'DM Sans',sans-serif}
.ce2 .ce2-calendar-grid span{display:grid;place-items:center;min-height:30px}
.ce2 .ce2-calendar-grid .ce2-calendar-selected{background:currentColor;border-radius:50%;font-weight:700}
.ce2 .ce2-calendar-grid .ce2-calendar-selected>b{color:#fff;line-height:1;font-weight:700}
.ce2 .ce2-animated{transition:opacity 1.1s ease,transform 1.1s ease,filter 1.1s ease}
.ce2 :where(.ce2-section) {scroll-margin-top:25px}
@media(max-width:620px){.ce2 .ce2-premium-maps{padding:60px 15px}.ce2 .ce2-map-card iframe{height:220px}.ce2 .ce2-form{gap:14px}}
@media(prefers-reduced-motion:reduce){
 .ce2 *, .ce2 *::before,.ce2 *::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
 .ce2 .ce2-animated{opacity:1!important;filter:none!important;transform:none!important}
}
body.ce2-intro-open{overflow:hidden!important}
.ce2 .ce2-calendar-month{text-align:center;font:500 21px/1.3 Georgia,serif;margin-bottom:22px}
.ce2 .ce2-photo.ce2-viewable{cursor:zoom-in}
.ce2 .ce2-photo.ce2-viewable:focus-visible{outline:4px solid #bd9c65;outline-offset:3px}
.ce2-photo-dialog{background:transparent;border:0;padding:55px 15px 15px;max-width:min(96vw,1100px);max-height:95vh;position:fixed;overflow:visible}
.ce2-photo-dialog::backdrop{background:#090b0dde;backdrop-filter:blur(7px)}
.ce2-photo-dialog>img{max-width:100%;max-height:calc(95vh - 90px);object-fit:contain;display:block;margin:auto;box-shadow:0 16px 55px #0008}
.ce2-lightbox-close{position:absolute;right:15px;top:0;width:44px;height:44px;background:#fff;border:0;border-radius:50%;color:#272323;font:500 28px/1 'DM Sans',sans-serif;cursor:pointer}
</style>
@php
    $curatedStyle = (string) ($template->settings['design'] ?? 'burgundy-wax');
    if (!array_key_exists($curatedStyle, config('wedding_curated_themes', []))) $curatedStyle = 'burgundy-wax';
@endphp
@include('weddings.themes.editorial.styles.'.$curatedStyle)
