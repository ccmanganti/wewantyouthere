<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@400;500;600;700&family=Great+Vibes&display=swap');
.ce-invite{font-family:'Cormorant Garamond',Georgia,serif;background:var(--ce-paper);color:var(--ce-ink);width:100%;overflow:hidden;position:relative;font-size:19px;line-height:1.5;isolation:isolate}
.ce-invite *{box-sizing:border-box}
.ce-invite [hidden]{display:none!important}
.ce-invite a{color:inherit}
.ce-invite img{width:100%;height:100%;object-fit:cover;display:block}
.ce-invite p,.ce-invite h1,.ce-invite h2,.ce-invite h3,.ce-invite figure{margin:0}
.ce-invite h1,.ce-invite h2,.ce-invite h3{font-weight:500;line-height:1.07}
.ce-invite h2{font-size:clamp(43px,7vw,78px)}
.ce-script,.ce-intro-script{font-family:'Great Vibes','Brush Script MT',cursive;font-weight:400}
.ce-eyebrow,.ce-overline,.ce-navbar,.ce-explore,.ce-ticket-top,.ce-ticket-row,.ce-ticket-tear,.ce-footer>a{font:600 10px/1.7 'DM Sans',sans-serif;letter-spacing:.22em;text-transform:uppercase}
.ce-navbar{display:flex;align-items:center;justify-content:space-between;gap:12px;position:absolute;left:0;right:0;top:0;padding:19px max(22px,calc((100vw - 1160px)/2));z-index:12;color:var(--ce-ink)}
.ce-wordmark{display:flex;gap:8px;align-items:center;text-decoration:none;font-size:11px;letter-spacing:.12em;text-transform:none;max-width:75%}
.ce-wordmark b{font-family:Georgia,serif;font-size:19px;font-weight:400}
.ce-menu{position:relative}.ce-menu summary{list-style:none;cursor:pointer;display:flex;gap:12px;align-items:center;padding:8px;min-height:44px}.ce-menu summary::-webkit-details-marker{display:none}
.ce-menu nav{position:absolute;top:100%;right:0;width:190px;background:var(--ce-paper);border:1px solid color-mix(in srgb,var(--ce-ink) 35%,transparent);padding:15px;box-shadow:0 15px 45px #0003;display:flex;flex-direction:column;gap:7px}
.ce-menu nav a{text-decoration:none;font:600 11px/1.5 'DM Sans',sans-serif;padding:7px}
.ce-menu nav a:hover{text-decoration:underline}
.ce-cover{min-height: min(100svh,950px);position:relative;display:flex;flex-direction:column}
.ce-cover h1{font-size:clamp(59px,11vw,126px);text-align:center;display:flex;flex-direction:column;align-items:center;gap:0;line-height:.91;letter-spacing:-.035em}
.ce-cover h1 em{font-family:'Great Vibes',cursive;font-size:.65em;font-weight:400;line-height:1.13}
.ce-cover p{text-align:center}
.ce-explore{display:inline-block;text-decoration:none;margin:25px auto 0;padding:10px;border-bottom:1px solid currentColor}
.ce-section:not(.ce-cover){padding:clamp(76px,10vw,150px) 22px}
.ce-editorial-heading,.ce-story-text,.ce-date-section,.ce-reception-heading,.ce-details,.ce-gallery,.ce-program,.ce-entourage,.ce-rsvp,.ce-footer,.ce-premium-section{text-align:center}
.ce-editorial-heading{max-width:650px;margin:0 auto 65px}
.ce-editorial-heading p,.ce-story-text p,.ce-details>p,.ce-premium-section>p{max-width:580px;margin:23px auto 0;font-size:clamp(18px,3vw,25px)}
.ce-story-photos{display:flex;align-items:center;justify-content:center;max-width:1040px;margin:0 auto;gap:clamp(10px,5vw,70px)}
.ce-picture{position:relative;background:#d9d0c2;overflow:hidden}
.ce-missing-photo{height:100%;min-height:220px;display:grid;place-items:center;background:linear-gradient(155deg,#ddd5c8,#c7b7a3);color:#6d5e56;letter-spacing:.2em;font:600 10px 'DM Sans',sans-serif}
.ce-story-first{width:53%;aspect-ratio:3/4}.ce-story-second{width:36%;aspect-ratio:3/4;margin-top:130px}
.ce-story-photos figcaption{text-align:center;font-style:italic;background:var(--ce-paper);position:absolute;bottom:0;left:0;right:0;padding:12px 6px;font-size:21px}
.ce-story-text{max-width:700px;margin:95px auto 0}.ce-story-text h2{margin:14px 0}
.ce-date-section{background:color-mix(in srgb,var(--ce-ink) 9%,var(--ce-paper));}
.ce-date-ornament{font-size:60px;line-height:1}
.ce-calendar-shell{max-width:370px;margin:32px auto 0;background:var(--ce-paper);padding:20px 24px 30px;box-shadow:0 13px 40px #00000010}
.ce-calendar-month{text-transform:uppercase;letter-spacing:.15em;font-size:24px;padding:10px 0 25px}
.ce-calendar-grid{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:7px;font:500 12px/1.6 'DM Sans',sans-serif}
.ce-calendar-grid span{display:grid;place-items:center;aspect-ratio:1}
.ce-calendar-grid .ce-today{background:var(--ce-ink);color:var(--ce-paper);border-radius:50%}
.ce-date-large{font-size:clamp(32px,5vw,52px);margin:28px auto 0}
.ce-countdown{display:flex;justify-content:center;gap:clamp(12px,4vw,45px);margin-top:30px}
.ce-countdown div{display:flex;flex-direction:column;min-width:58px}.ce-countdown strong{font-size:36px;font-weight:500;font-variant-numeric:tabular-nums}.ce-countdown small{font:600 10px 'DM Sans',sans-serif;letter-spacing:.15em}
.ce-place{display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:clamp(22px,5vw,80px);max-width:1160px;margin:auto}
.ce-place-photo{aspect-ratio:4/5}.ce-place-body h2{margin:12px 0 34px}.ce-place-body h3{font-size:clamp(27px,4vw,39px);margin:18px 0 9px}.ce-place-body p{margin-bottom:20px}
.ce-reception{background:color-mix(in srgb,var(--ce-ink) 5%,var(--ce-paper))}.ce-reception-photo{max-width:820px;aspect-ratio:16/9;margin:35px auto 0}
.ce-program-line{max-width:500px;margin:55px auto;position:relative}
.ce-program-line:before{content:'';position:absolute;top:5px;bottom:5px;left:50%;width:1px;background:var(--ce-ink)}
.ce-program-item{position:relative;display:flex;width:50%;flex-direction:column;padding:20px 24px;text-align:right}
.ce-program-item:nth-child(even){margin-left:50%;text-align:left}
.ce-program-item:after{content:'';width:11px;height:11px;border-radius:50%;background:var(--ce-ink);position:absolute;top:27px;right:-6px}
.ce-program-item:nth-child(even):after{right:auto;left:-5px}
.ce-program-item>span{font-size:34px}.ce-program-item p{font-size:17px}
.ce-program-full{white-space:pre-line;max-width:500px;margin:0 auto}
.ce-entourage-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:45px;max-width:750px;margin:50px auto 0}
.ce-entourage-grid p{white-space:pre-line;font-size:27px;margin:12px 0 0}
.ce-gallery-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;max-width:1050px;margin:42px auto 25px}
.ce-gallery-grid .ce-picture{aspect-ratio:3/4}.ce-gallery-grid .ce-picture:nth-child(even){margin-top:50px}
.ce-gallery .ce-script{font-size:40px;margin:35px 0}
.ce-details{background:color-mix(in srgb,var(--ce-ink) 6%,var(--ce-paper))}
.ce-swatches{display:flex;gap:12px;justify-content:center;margin:30px 0 55px}
.ce-swatches i{width:48px;aspect-ratio:1;border-radius:50%;background:#e8dac7;border:3px solid #ffffff75;box-shadow:0 2px 9px #0001}
.ce-swatches i:nth-child(2){background:#a09a80}.ce-swatches i:nth-child(3){background:#728475}.ce-swatches i:nth-child(4){background:#a88c89}.ce-swatches i:nth-child(5){background:var(--ce-ink)}
.ce-gift{max-width:520px;border-top:1px solid currentColor;padding-top:36px;margin:0 auto}.ce-gift p{margin:13px 0 0}.ce-gift a,.ce-map-card a{display:inline-block;margin-top:18px;font:700 10px 'DM Sans',sans-serif;letter-spacing:.13em}
.ce-rsvp-envelope{height:100px;width:135px;margin:0 auto 28px;background:linear-gradient(145deg,transparent 48%,#ffffff8c 49%,#ffffff8c 51%,transparent 52%),var(--ce-ink);position:relative;clip-path:polygon(0 0,100% 0,100% 100%,0 100%);display:grid;place-items:center}
.ce-rsvp-envelope span{background:var(--ce-paper);padding:8px 13px;font-size:29px}
.ce-rsvp-form{display:grid;gap:18px;max-width:430px;text-align:left;margin:35px auto 0;font:600 12px 'DM Sans',sans-serif}
.ce-rsvp-form label{display:grid;gap:7px}
.ce-rsvp-form input:not([type=radio]),.ce-rsvp-form select,.ce-rsvp-form textarea{width:100%;min-height:44px;border:1px solid color-mix(in srgb,var(--ce-ink) 30%,transparent);background:#fffdf9;border-radius:3px;padding:12px;font:400 13px 'DM Sans',sans-serif;color:#292424}
.ce-rsvp-form fieldset{border:0;padding:0;margin:0;display:flex;gap:15px;flex-wrap:wrap}.ce-rsvp-form legend{padding:0 0 10px}.ce-rsvp-form fieldset label{display:flex;flex-direction:row;align-items:center;gap:7px}
.ce-rsvp-form button{padding:16px;border:0;background:var(--ce-ink);color:var(--ce-paper);font:700 12px 'DM Sans',sans-serif;letter-spacing:.13em;cursor:pointer}
.ce-honey{position:absolute;left:-9999px}
.ce-map-card{max-width:650px;margin:35px auto}.ce-map-card h3{font-size:28px}.ce-map-card iframe{width:100%;aspect-ratio:16/9;border:0;margin-top:15px}
.ce-footer{background:var(--ce-ink);color:var(--ce-paper)}.ce-footer .ce-script{font-size:47px}.ce-footer h2{margin:0 0 20px}.ce-footer>a{display:inline-block;margin:40px 0 0;text-decoration:none;border-bottom:1px solid currentColor;padding:10px}
.ce-intro{position:fixed;inset:0;z-index:10000;background:#141019ec;display:grid;place-items:center;perspective:1000px;transition:opacity .7s,visibility .7s}
.ce-intro.ce-opened{opacity:0;visibility:hidden;pointer-events:none}
.ce-intro-envelope{position:relative;width:min(340px,78vw);height:250px;border:0;background:transparent;cursor:pointer;filter:drop-shadow(0 22px 32px #0007);animation:ce-float 4s ease-in-out infinite}
.ce-intro-card{position:absolute;bottom:32px;left:7%;width:86%;height:200px;background:var(--ce-paper);z-index:1;display:flex;align-items:center;justify-content:center;flex-direction:column;color:var(--ce-ink);transition:transform 1.15s ease}
.ce-intro-card .ce-intro-script{font-size:31px}.ce-intro-card strong{font-size:24px;font-weight:500}.ce-intro-card small{font-size:15px}
.ce-intro-front{position:absolute;inset:65px 0 0;background:var(--ce-ink);z-index:3;clip-path:polygon(0 0,50% 65%,100% 0,100% 100%,0 100%)}
.ce-intro-flap{position:absolute;left:0;right:0;top:64px;height:125px;background:color-mix(in srgb,var(--ce-ink) 77%,#fff);clip-path:polygon(0 0,100% 0,50% 95%);z-index:4;transform-origin:top;transition:transform .8s}
.ce-intro-seal{position:absolute;z-index:5;left:calc(50% - 22px);bottom:57px;width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:#b48b5d;border:4px double #f6e4bb;color:#fff}
.ce-intro.ce-opening .ce-intro-flap{transform:rotateX(180deg);z-index:0}
.ce-intro.ce-opening .ce-intro-card{transform:translateY(-120px)}
.ce-intro-tag{position:absolute;color:#fff;top:0;left:0;right:0;text-align:center;font:700 11px 'DM Sans',sans-serif}
@keyframes ce-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
.ce-cover-picture,.ce-pearl-picture,.ce-ticket-hero-photo{overflow:hidden}
.ce-cover-picture img,.ce-pearl-picture img,.ce-ticket-hero-photo img{transition:transform 1s}
.ce-cover-picture:hover img,.ce-pearl-picture:hover img,.ce-ticket-hero-photo:hover img{transform:scale(1.055)}
.ce-burgundy-wax{background:#fbf6ef}.ce-burgundy-wax .ce-cover{background:#190b10;padding:88px 22px 45px}
.ce-burgundy-wax .ce-floral-ceiling{position:absolute;inset:0;background-position:center;background-size:cover;opacity:.4;filter:saturate(.6) brightness(.5)}
.ce-cover-paper{position:relative;background:#fcfaf5;max-width:620px;width:100%;min-height:690px;margin:auto;padding:80px 32px 45px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;box-shadow:0 20px 60px #0004}
.ce-pressed-flowers{position:absolute;left:12px;top:10px;width:160px;height:160px;background-image:url('https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=550&q=80');background-position:center;background-size:cover;clip-path:ellipse(42% 46% at 50% 50%);opacity:.85}
.ce-stationery-arch{border:1px solid #c7aa96;outline:4px double #ddc6b3;padding:60px 24px;width:100%;max-width:475px;border-radius:170px 170px 15px 15px;margin:28px 0 10px}
.ce-stationery-arch .ce-script{font-size:32px}.ce-stationery-arch h1{font-size:clamp(60px,10vw,100px);margin:10px 0 20px}.ce-date-letter{font-size:25px}
.ce-wax{display:grid;place-items:center;background:#6a1736;border:5px double #b37975;box-shadow:0 10px 20px #4e14244f;width:88px;height:88px;border-radius:42%;color:#ead4ba;transform:rotate(-12deg);font-size:25px}.ce-wax small{font-size:13px}
.ce-olive-garden{--ce-ink:#55613f}.ce-olive-garden .ce-navbar{color:#f6efe3}
.ce-olive-hero{min-height:850px;width:100%;background:linear-gradient(145deg,#34492e,#758157);display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:30px;padding:95px max(22px,calc((100vw - 1050px)/2));position:relative}
.ce-olive-hero:before{content:'';inset:0;position:absolute;opacity:.1;background-image:url('https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?auto=format&fit=crop&w=900&q=80');background-size:cover;pointer-events:none}
.ce-olive-hero .ce-cover-picture{aspect-ratio:3/4;margin:0;transform:rotate(-5deg);box-shadow:13px 13px 0 #eee5d3}
.ce-olive-envelope{position:relative;background:#f8f1dd;max-width:480px;min-height:510px;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:45px 23px;text-align:center;clip-path:polygon(0 8%,100% 0,100% 95%,0 100%);box-shadow:0 10px 25px #0004}
.ce-olive-envelope h1{font-size:clamp(50px,6vw,92px);margin:20px 0}.ce-olive-envelope .ce-script{font-size:33px}
.ce-stamp{position:absolute;top:24px;right:30px;font-size:45px}.ce-olive-caption{position:absolute;bottom:20px;left:0;right:0;text-align:center;color:#fff5d7;font:italic 35px 'Cormorant Garamond',serif}
.ce-painted-orchard .ce-navbar{color:#fff9ed}
.ce-orchard-hero{min-height:870px;display:flex;align-items:center;justify-content:center;flex-direction:column;background-size:cover;background-position:center;padding:120px 22px 50px}
.ce-orchard-frame{padding:80px 35px;background:#f7f1e8ed;border:14px solid #f7f1e88a;outline:2px solid #d4c1ac;outline-offset:-22px;width:min(610px,100%);text-align:center;clip-path:polygon(0 5%,5% 0,95% 0,100% 5%,100% 95%,95% 100%,5% 100%,0 95%);box-shadow:0 12px 35px #0004}
.ce-orchard-frame>span{letter-spacing:.2em;font:600 11px 'DM Sans',sans-serif}.ce-orchard-frame h1{font-size:clamp(57px,9vw,108px);margin:28px 0}.ce-orchard-fleur{font-size:43px;margin-top:28px;display:block}
.ce-orchard-hero .ce-explore{color:#fff}
.ce-pearl-editorial{--ce-ink:#4d4440}.ce-pearl-hero{background:#faf8f4;min-height:850px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:100px 25px 45px}
.ce-pearl-hero .ce-script{font-size:48px}.ce-pearl-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(68px,11vw,144px);line-height:.83;margin:20px 0 30px;position:relative;z-index:1}
.ce-pearl-amp{font-size:.5em!important;font-style:italic;margin:15px 0}.ce-pearl-picture{width:min(540px,78vw);height:360px;filter:grayscale(100%);box-shadow:0 12px 35px #2b27232e}
.ce-pearl-chain{letter-spacing:.15em;font-size:20px;color:#c5ac92;transform:rotate(-7deg);margin-top:-9px;z-index:2}
.ce-pearl-issue{margin-top:25px;font:600 10px 'DM Sans',sans-serif;letter-spacing:.2em}
.ce-pearl-editorial .ce-story-photos img,.ce-pearl-editorial .ce-gallery-grid img{filter:grayscale(1)}
.ce-destination-ticket{--ce-ink:#152c45}.ce-destination-ticket .ce-cover{background:linear-gradient(#10243975,#10243990),url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1400&q=85') center/cover;padding:110px 20px 45px}
.ce-destination-ticket .ce-navbar{color:#fff}
.ce-ticket-hero{width:min(630px,100%);background:#fbf7ef;margin:auto;padding:28px 28px 0;color:#162d42;box-shadow:14px 14px 0 #09192c8c}
.ce-ticket-top{display:flex;justify-content:space-between;gap:10px;border-bottom:1px dashed #78818a;padding-bottom:18px}
.ce-ticket-globe{text-align:center;font-size:65px}
.ce-ticket-hero h1{font-size:clamp(59px,8vw,105px);margin:15px auto 26px}.ce-ticket-hero h1 small{font-family:'Great Vibes',cursive;font-size:.45em;font-weight:400;line-height:1.2}
.ce-ticket-row{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid #c8bfb1;border-bottom:1px solid #c8bfb1;gap:15px;padding:16px 0;margin:15px auto}
.ce-ticket-row div{display:flex;flex-direction:column}.ce-ticket-row small{opacity:.6;font-size:9px}.ce-ticket-row span{font-weight:600;letter-spacing:0;font-size:13px}
.ce-ticket-hero-photo{height:235px}.ce-ticket-tear{background:#152c45;color:#fff;padding:18px;margin:0 -28px;text-align:center!important;border-top:4px dotted #fff;letter-spacing:.12em}
.ce-destination-ticket .ce-program{background:#152c45;color:#faf7f0}
.ce-destination-ticket .ce-program-line:before,.ce-destination-ticket .ce-program-item:after{background:#faf7f0}
.ce-destination-ticket .ce-gallery .ce-picture{border:7px solid #faf7f0;box-shadow:0 0 0 1px #152c45}
.ce-olive-garden .ce-program{background:#526143;color:#fff7ec}
.ce-olive-garden .ce-program-line:before,.ce-olive-garden .ce-program-item:after{background:#fff7ec}
.ce-painted-orchard .ce-date-section{background:#e8d5c7}
.ce-pearl-editorial .ce-program{background:#b8a9a0;color:#fff}
.ce-pearl-editorial .ce-program-line:before,.ce-pearl-editorial .ce-program-item:after{background:#fff}
.ce-invite .ce-reveal{opacity:0;transform:translateY(30px);transition:opacity .9s ease,transform .9s ease}
.ce-invite .ce-reveal.ce-visible{opacity:1;transform:translateY(0)}
.ce-destination-ticket .ce-reveal{transform:translateX(-35px)}.ce-destination-ticket .ce-reveal.ce-visible{transform:translateX(0)}
.ce-olive-garden .ce-reveal{transform:scale(.96)}.ce-olive-garden .ce-reveal.ce-visible{transform:scale(1)}
.ce-pearl-editorial .ce-reveal{transform:translateY(12px);filter:blur(5px)}.ce-pearl-editorial .ce-reveal.ce-visible{transform:translateY(0);filter:blur(0)}
.ce-painted-orchard .ce-reveal{transform:translateY(40px) scale(.97)}.ce-painted-orchard .ce-reveal.ce-visible{transform:translateY(0) scale(1)}
@media(max-width:700px){
.ce-navbar{padding:15px}.ce-cover{min-height:720px}.ce-section:not(.ce-cover){padding:80px 20px}
.ce-story-photos{gap:12px}.ce-story-second{margin-top:90px}.ce-story-photos figcaption{font-size:14px}
.ce-place{grid-template-columns:1fr;gap:25px}.ce-place-photo{max-height:450px}.ce-place-body{text-align:center}
.ce-gallery-grid{grid-template-columns:repeat(2,1fr)}.ce-gallery-grid .ce-picture:nth-child(even){margin-top:20px}
.ce-entourage-grid{gap:25px}.ce-entourage-grid p{font-size:22px}
.ce-olive-hero{grid-template-columns:1fr;gap:20px;padding:90px 20px 70px;min-height:900px}
.ce-olive-hero .ce-cover-picture{width:66%;margin:0 auto;max-height:270px}.ce-olive-envelope{min-height:420px;margin:0 auto;width:95%}
.ce-olive-caption{bottom:13px;font-size:25px}.ce-stationery-arch{padding:55px 10px}.ce-cover-paper{min-height:600px}
.ce-pearl-picture{height:260px}.ce-pearl-hero{min-height:730px}.ce-orchard-hero{min-height:740px}
.ce-ticket-hero{padding:22px 18px 0}.ce-ticket-tear{margin:0 -18px}.ce-ticket-top{font-size:8px}
}
@media(prefers-reduced-motion:reduce){.ce-invite *, .ce-invite *:before,.ce-invite *:after{animation:none!important;scroll-behavior:auto!important;transition-duration:0ms!important}.ce-invite .ce-reveal{opacity:1;transform:none;filter:none}}
</style>