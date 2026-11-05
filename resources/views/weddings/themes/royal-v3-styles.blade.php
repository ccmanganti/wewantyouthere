<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Royal Burgundy Grand/Info V3 — isolated from the platform UI.
   Typography and paper art follow the approved preview.
   Decorative images are real, optimized WebP/JPEG assets, not SVG animations. */
.rb-v3{--paper:#f3ebdd;--wine:#681421;--dark:#2b0b13;--gold:#d2a474;--ink:#55272e;
    width:100%;min-height:100svh;background:#180d11;color:var(--ink);
    font-family:'Cormorant Garamond',Georgia,serif;container-type:inline-size;isolation:isolate}
.rb-v3 *{box-sizing:border-box}
.rb-v3 [hidden]{display:none!important}
.rb-v3 a{color:inherit}
.rb-v3 .rbv-pages{max-width:790px;margin:0 auto;box-shadow:0 26px 110px #080306a8}
.rb-v3 .rbv-grand,.rb-v3 .rbv-info{position:relative;overflow:hidden;isolation:isolate;text-align:center}
.rb-v3 .rbv-grand{min-height:440px;padding:75px clamp(20px,7vw,74px);color:#f6e4cc;
    background:radial-gradient(ellipse at 35% 0,#9e344455,transparent 60%),linear-gradient(155deg,#7b1b2b,#3d0a14)}
.rb-v3 .rbv-info{background:#f3ebdd url('/wedding/royal-burgundy/paper-texture.webp') center/650px auto;
    padding:clamp(56px,8vw,90px) clamp(23px,7vw,76px);color:var(--ink)}
.rb-v3 .rbv-inner{max-width:520px;margin:auto}.rb-v3 .rbv-inner-wide{max-width:640px}
.rb-v3 .rbv-eyebrow{font:700 10px/1.7 'DM Sans',sans-serif;letter-spacing:.21em;text-transform:uppercase;color:#9b5a50;display:block}
.rb-v3 .rbv-grand>.rbv-eyebrow,.rb-v3 .rbv-grand .rbv-eyebrow{color:#efc59e}
.rb-v3 .rbv-title{font:400 clamp(55px,8.8vw,92px)/1.1 'Great Vibes',cursive;
    color:#7d1c2b;margin:14px auto 26px;letter-spacing:0}
.rb-v3 .rbv-grand .rbv-title{color:#f6d5b5}
.rb-v3 .rbv-copy{font:500 clamp(20px,2.8vw,27px)/1.4 'Cormorant Garamond',serif;margin:14px auto;white-space:pre-line}
.rb-v3 .rbv-copy.rbv-small{font-size:18px}
.rb-v3 .rbv-quote{font:400 clamp(33px,5vw,54px)/1.25 'Great Vibes',cursive;
    color:#f3d0a7;max-width:560px;margin:31px auto 8px}
.rb-v3 .rbv-info .rbv-quote{color:#822a30}
.rb-v3 .rbv-divider{font:20px Georgia,serif;color:#b98864;display:block;margin:22px auto}
.rb-v3 .rbv-photo{margin:0;position:relative;min-width:0;overflow:hidden}
.rb-v3 .rbv-photo>img,.rb-v3 .rbv-photo>button.rbv-gallery-view img{display:block;width:100%;height:100%;object-fit:cover}
.rb-v3 .rbv-photo-empty{display:grid;place-items:center;position:absolute;inset:0;
    font:700 11px 'DM Sans',sans-serif;letter-spacing:.1em;
    background:linear-gradient(135deg,#824350,#c99c81,#52242f);color:#fff7e9;text-align:center;padding:20px}
.rb-v3 .rbv-photo-edit{position:absolute;z-index:6;bottom:12px;left:50%;transform:translateX(-50%);
    background:#fff6e9;color:#74202b;border:1px solid #edc595;border-radius:999px;white-space:nowrap;
    font:700 10px 'DM Sans',sans-serif;cursor:pointer;display:flex;gap:8px;align-items:center;
    padding:9px 13px;box-shadow:0 4px 15px #0005}
.rb-v3 .rbv-photo-edit:hover{background:#fff}
.rb-v3 [data-photo-slot].is-photo-focused{outline:5px solid #f6c383!important;
    outline-offset:3px;box-shadow:0 0 0 9px #9e1e2b66!important}
.rb-v3 .rbv-botanical{object-fit:contain;display:block;margin:15px auto;max-width:100%;height:auto;opacity:.64}
.rb-v3 .rbv-small-botanical{max-width:220px;max-height:90px}
.rb-v3 .rbv-scroll-down{font:700 10px 'DM Sans',sans-serif;display:inline-flex;
    text-decoration:none;gap:10px;align-items:center;letter-spacing:.07em;color:#8c3440}
.rb-v3 .rbv-header{height:60px;position:relative;z-index:25;display:flex;align-items:center;
    justify-content:space-between;gap:12px;padding:10px 28px;max-width:790px;margin:auto;
    background:#2d101a;color:#f8e5cf;border-bottom:1px solid #d2a4745c}
.rb-v3 .rbv-monogram{text-decoration:none;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
    font:italic 25px 'Cormorant Garamond',serif;max-width:52%}
.rb-v3 .rbv-monogram i{font:400 23px 'Great Vibes',cursive;color:#ddb685}
.rb-v3 .rbv-header-label{font:700 9px 'DM Sans',sans-serif;letter-spacing:.15em;text-align:center;color:#dcb994}
.rb-v3 .rbv-menu{position:relative;font:700 11px 'DM Sans',sans-serif}
.rb-v3 .rbv-menu summary{cursor:pointer;list-style:none;display:flex;gap:8px;align-items:center}
.rb-v3 .rbv-menu summary::-webkit-details-marker{display:none}
.rb-v3 .rbv-menu nav{position:absolute;top:calc(100% + 16px);right:0;min-width:180px;z-index:10;
    display:grid;background:#2d101a;border:1px solid #c18f72;border-radius:8px;padding:8px;box-shadow:0 15px 30px #0006}
.rb-v3 .rbv-menu nav a{font:600 12px 'DM Sans',sans-serif;color:#fff2de;text-decoration:none;padding:10px 12px;border-radius:6px}
.rb-v3 .rbv-menu nav a:hover{background:#782735}
.rb-v3 .rbv-cover{padding-top:67px;background:#f5eee1 url('/wedding/royal-burgundy/paper-texture.webp') center/600px auto;color:#582029}
.rb-v3 .rbv-cover-title{margin:6px auto 20px}.rb-v3 .rbv-cover-title h1{
    font:600 clamp(53px,9vw,102px)/.93 'Playfair Display',serif;color:#48101a;
    letter-spacing:-.1em;margin:4px 0}
.rb-v3 .rbv-cover-title .rbv-script{font:400 clamp(45px,6vw,71px)/1 'Great Vibes',cursive;color:#8c2631;display:block}
.rb-v3 .rbv-cover-title .rbv-script:first-child{transform:translateX(-60px)}
.rb-v3 .rbv-cover-title .rbv-script:last-child{transform:translateX(95px)}
.rb-v3 .rbv-cover-photo{max-width:500px;margin:17px auto;border:9px solid #481520;background:#481520;box-shadow:0 13px 35px #4c101846}
.rb-v3 .rbv-cover-photo>img{height:auto;max-height:360px;aspect-ratio:1.8/1}
.rb-v3 .rbv-cover-photo figcaption{color:#ffebd0;font:700 9px 'DM Sans',sans-serif;letter-spacing:.15em;padding:10px}
.rb-v3 .rbv-names{font:400 clamp(43px,6.4vw,73px)/1.1 'Great Vibes',cursive;color:#811f2d;margin:19px 0 8px}
.rb-v3 .rbv-names b{font:400 19px Georgia,serif;margin:0 10px;color:#a73948}
.rb-v3 .rbv-date-text{font:700 11px 'DM Sans',sans-serif;letter-spacing:.17em;text-transform:uppercase;margin:12px 0 19px}
.rb-v3 .rbv-welcome .rbv-inner{padding:20px;border:1px solid #cdb8a1}
.rb-v3 .rbv-editorial{padding-bottom:76px}
.rb-v3 .rbv-overlay-art{position:absolute;z-index:-1;max-width:58%;opacity:.35;pointer-events:none}
.rb-v3 .rbv-overlay-left{top:5%;left:-15%;transform:rotate(-13deg)}
.rb-v3 .rbv-photo-pair{display:grid;grid-template-columns:1.35fr 1fr;gap:15px;align-items:center;max-width:620px;margin:24px auto}
.rb-v3 .rbv-photo-pair .rbv-photo{aspect-ratio:4/5;border:5px solid #efd9ba;box-shadow:0 13px 25px #0004}
.rb-v3 .rbv-photo-pair .rbv-photo:nth-child(2){transform:translateY(32px)}
.rb-v3 .rbv-photo-pair figcaption{position:absolute;bottom:0;left:0;right:0;
    background:#240e16a8;color:#fff2da;font:italic 19px 'Cormorant Garamond',serif;padding:9px}
.rb-v3 .rbv-story-keepsake{width:min(280px,70%);aspect-ratio:4/5;margin:25px auto;border:6px solid #f9f0e2}
.rb-v3 .rbv-quote-portrait{position:absolute;inset:0;z-index:0;opacity:.08}
.rb-v3 .rbv-quote-portrait img{width:100%;height:100%;object-fit:cover}
.rb-v3 .rbv-rsvp-portrait{width:min(225px,60%);aspect-ratio:4/5;margin:25px auto;border:7px solid #fff4e2}
.rb-v3:not([data-preview="1"]){container-type:normal}
.rb-v3 .rbv-chapters{display:grid;gap:14px;margin:26px auto}
.rb-v3 .rbv-chapters article{padding:18px 21px;border:1px solid #d8c5af;background:#fff8eca6}
.rb-v3 .rbv-chapters article>span{font:700 9px 'DM Sans',sans-serif;letter-spacing:.16em;color:#a76b56}
.rb-v3 .rbv-chapters article h3{font:400 36px 'Great Vibes',cursive;color:#842d34;margin:6px 0}
.rb-v3 .rbv-chapters article p{font:500 19px/1.45 'Cormorant Garamond',serif;white-space:pre-line;margin:0}
.rb-v3 .rbv-inner blockquote{font:italic 23px Georgia,serif;color:#813039;line-height:1.5;margin:20px auto}
.rb-v3 .rbv-doors{height:520px;min-height:0;display:grid;place-items:end center;padding:0}
.rb-v3 .rbv-doors-photo{position:absolute;inset:0;margin:0}.rb-v3 .rbv-doors-photo img{width:100%;height:100%;object-fit:cover}
.rb-v3 .rbv-doors:after{content:"";inset:0;position:absolute;pointer-events:none;background:linear-gradient(180deg,transparent 30%,#1c0816e0)}
.rb-v3 .rbv-door-caption{position:relative;z-index:2;padding:30px 20px 50px}
.rb-v3 .rbv-door-caption h2{font:italic clamp(37px,5vw,62px) 'Cormorant Garamond',serif;margin:8px 0}
.rb-v3 .rbv-calendar-year{font:500 18px 'Playfair Display',serif;letter-spacing:.23em}
.rb-v3 .rbv-calendar{max-width:365px;margin:24px auto}
.rb-v3 .rbv-weekdays,.rb-v3 .rbv-days{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:3px}
.rb-v3 .rbv-weekdays span{font:700 10px 'DM Sans',sans-serif;margin-bottom:12px}
.rb-v3 .rbv-days span{aspect-ratio:1;display:grid;place-items:center;font:600 19px 'Cormorant Garamond',serif}
.rb-v3 .rbv-days .is-wedding-day{border-radius:50%;background:#8b2435;color:white;box-shadow:0 0 0 3px #81243626}
.rb-v3 .rbv-calendar-ribbon{font:700 10px 'DM Sans',sans-serif;letter-spacing:.1em;display:flex;align-items:center;justify-content:center;gap:17px}
.rb-v3 .rbv-calendar-ribbon strong{font:500 46px 'Playfair Display',serif;color:#812a35}
.rb-v3 .rbv-venue-art{padding-top:72px;padding-bottom:63px}
.rb-v3 .rbv-venue-engraving{max-width:610px;aspect-ratio:16/7;margin:22px auto;overflow:visible}
.rb-v3 .rbv-venue-engraving img{object-fit:contain;filter:drop-shadow(0 10px 13px #0004)}
.rb-v3 .rbv-venue-name{font:500 26px 'Playfair Display',serif;color:#efcba2;letter-spacing:.06em}
.rb-v3 .rbv-location{margin:22px auto}.rb-v3 .rbv-location h3{font:500 33px 'Playfair Display',serif;margin:11px 0;color:#631c29}
.rb-v3 .rbv-location p{font:500 20px 'Cormorant Garamond',serif;white-space:pre-line;margin:9px auto}
.rb-v3 .rbv-location strong{display:block;font:700 13px 'DM Sans',sans-serif;color:#8f5e53;margin:17px auto}
.rb-v3 .rbv-link{display:inline-flex;gap:11px;align-items:center;border:1px solid #9a5b58;
    color:#782332;text-decoration:none;padding:11px 19px;font:700 11px 'DM Sans',sans-serif;
    margin-top:13px}
.rb-v3 .rbv-link:hover{background:#842c35;color:#fff}
.rb-v3 .rbv-venue-photo{padding:0}.rb-v3 .rbv-wide-photo{height:480px}
.rb-v3 .rbv-wide-photo>img{height:100%;width:100%;object-fit:cover}
.rb-v3 .rbv-photo-caption{position:relative;padding:18px 25px 40px}
.rb-v3 .rbv-photo-caption p{font:700 11px 'DM Sans',sans-serif;letter-spacing:.07em}
.rb-v3 .rbv-map-tabs{display:inline-flex;gap:5px;border:1px solid #d9bd9d;padding:5px;margin:12px auto 18px}
.rb-v3 .rbv-map-tabs button{background:transparent;color:#7c3640;border:0;padding:10px 18px;cursor:pointer;font:700 11px 'DM Sans',sans-serif}
.rb-v3 .rbv-map-tabs button.is-active{background:#762432;color:#fff}
.rb-v3 .rbv-map{min-height:285px;background:#e8d6c4;border:7px solid #fff6e9;box-shadow:0 7px 28px #491e1e1c}
.rb-v3 .rbv-map iframe{width:100%;height:285px;display:block;border:0}
.rb-v3 .rbv-map-placeholder{display:grid;place-items:center;min-height:285px;font-size:17px;padding:22px}
.rb-v3 #rbv-map-destination{font:500 19px Georgia,serif}
.rb-v3 .rbv-hint{font:11px 'DM Sans',sans-serif;color:#795c57}
.rb-v3 .rbv-timeline-steps{position:relative;max-width:550px;margin:30px auto;list-style:none;padding:0}
.rb-v3 .rbv-timeline-steps:before{content:"";position:absolute;top:10px;bottom:10px;left:50%;width:2px;background:#d4aa79}
.rb-v3 .rbv-timeline-step{display:grid;grid-template-columns:1fr 1fr;position:relative;min-height:137px;align-items:center}
.rb-v3 .rbv-timeline-dot{position:absolute;top:46px;left:50%;transform:translateX(-50%);width:17px;height:17px;border-radius:50%;border:3px solid #e2b680;background:#681521;z-index:1}
.rb-v3 .rbv-timeline-content{padding:10px 23px;text-align:left;grid-column:2}
.rb-v3 .rbv-timeline-step:nth-child(even) .rbv-timeline-content{grid-column:1;text-align:right;grid-row:1}
.rb-v3 .rbv-timeline-content h3{font:700 12px 'DM Sans',sans-serif;letter-spacing:.09em;margin:7px 0}
.rb-v3 .rbv-timeline-content strong{font:400 37px 'Great Vibes',cursive;color:#ffdbac;display:block}
.rb-v3 .rbv-timeline-content p{font:400 19px 'Cormorant Garamond',serif;margin:0}
.rb-v3 .rbv-timeline-art{width:200px;max-height:110px;filter:sepia(1) brightness(2);opacity:.4}
.rb-v3 .rbv-program-rows{margin:24px auto}.rb-v3 .rbv-program-rows>div{display:flex;gap:20px;align-items:center;text-align:left;padding:15px;border-bottom:1px solid #d8bda6}
.rb-v3 .rbv-program-rows span{font:700 18px 'DM Sans',sans-serif;color:#a3604e}
.rb-v3 .rbv-program-rows p{font:500 19px/1.4 'Cormorant Garamond',serif;margin:0}
.rb-v3 .rbv-family-collage{display:grid;grid-template-columns:1.1fr .9fr;gap:12px;max-width:550px;margin:28px auto}
.rb-v3 .rbv-family-collage figure{aspect-ratio:4/5;border:5px solid #f2d5b2}
.rb-v3 .rbv-family-collage figure:first-child{grid-row:span 2;aspect-ratio:auto}
.rb-v3 .rbv-entourage{display:grid;grid-template-columns:1fr 1fr;gap:6px 21px;margin:30px auto}
.rb-v3 .rbv-entourage-person{padding:16px 7px;border-bottom:1px solid #cfb9a3}
.rb-v3 .rbv-entourage-person p{font:500 19px/1.35 'Cormorant Garamond',serif;white-space:pre-line;margin:9px 0}
.rb-v3 .rbv-swatches{display:block;max-width:min(570px,100%);height:auto;margin:22px auto}
.rb-v3 .rbv-dress-art>p{font:600 17px 'Cormorant Garamond',serif}
.rb-v3 .rbv-info-columns{display:grid;grid-template-columns:1fr 1fr;gap:22px;margin:25px auto}
.rb-v3 .rbv-info-columns article{border:1px solid #d3b9a2;padding:16px 17px}
.rb-v3 .rbv-info-columns h3{font:400 33px 'Great Vibes',cursive;color:#802c33;margin:12px 0}
.rb-v3 .rbv-info-columns p{font:500 19px 'Cormorant Garamond',serif;white-space:pre-line}
.rb-v3 .rbv-gallery-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;max-width:650px;margin:25px auto}
.rb-v3 .rbv-gallery-item{aspect-ratio:4/5;border:4px solid #eac89c;box-shadow:0 5px 18px #0003}
.rb-v3 .rbv-gallery-item:nth-child(1){grid-row:span 2;aspect-ratio:auto}
.rb-v3 .rbv-gallery-item:nth-child(5){grid-column:span 2;aspect-ratio:1.6/1}
.rb-v3 .rbv-gallery-view{display:block;width:100%;height:100%;background:none;padding:0;border:0;cursor:zoom-in}
.rb-v3 .rbv-gallery-item figcaption{position:absolute;bottom:0;left:0;right:0;padding:8px;
    background:#2d0a1699;color:#fff4e7;font:italic 15px 'Cormorant Garamond',serif}
.rb-v3 .rbv-gallery-hint{font:600 11px 'DM Sans',sans-serif;color:#e8c4a5}
.rb-v3 .rbv-reminders article{padding:20px 0;border-bottom:1px solid #d8c2af}
.rb-v3 .rbv-reminders h3{font:400 37px 'Great Vibes',cursive;color:#6c2530;margin:9px 0}
.rb-v3 .rbv-reminders p{font:500 19px 'Cormorant Garamond',serif;white-space:pre-line;margin:0}
.rb-v3 .rbv-closing{padding:0;min-height:520px;display:grid;place-items:center}
.rb-v3 .rbv-closing-background{margin:0;position:absolute;inset:0}.rb-v3 .rbv-closing-background img{width:100%;height:100%;object-fit:cover}
.rb-v3 .rbv-closing:before{content:"";position:absolute;inset:0;background:linear-gradient(140deg,#2d0816d1,#59102064);z-index:1;pointer-events:none}
.rb-v3 .rbv-closing-copy{position:relative;z-index:2;padding:70px 30px}
.rb-v3 .rbv-closing-copy h2{font:400 clamp(48px,8vw,88px) 'Great Vibes',cursive;margin:16px 0;color:#ffe0b7}
.rb-v3 .rbv-closing-copy p{font:italic 25px 'Cormorant Garamond',serif}
.rb-v3 .rbv-rsvp-deadline{font:600 11px 'DM Sans',sans-serif;letter-spacing:.09em;margin:20px 0 30px}
.rb-v3 .rbv-rsvp-deadline strong{display:block;margin:10px auto;font:600 17px 'Playfair Display',serif}
.rb-v3 .rbv-rsvp-form{padding:23px;border:1px solid #d4bdab;max-width:510px;margin:20px auto;text-align:left;background:#fdf7ee9c}
.rb-v3 .rbv-rsvp-form>label{display:block;margin:0 0 15px;font:600 12px 'DM Sans',sans-serif}
.rb-v3 .rbv-rsvp-form label>span{display:block;margin-bottom:7px}
.rb-v3 .rbv-rsvp-form input[type=text],.rb-v3 .rbv-rsvp-form select,.rb-v3 .rbv-rsvp-form textarea{
    display:block;width:100%;border:1px solid #bfa9a0;background:#fffaf3;border-radius:5px;
    padding:11px;font:14px 'DM Sans',sans-serif;color:#432329}
.rb-v3 .rbv-rsvp-form fieldset{border:0;padding:0;margin:13px 0}
.rb-v3 .rbv-rsvp-form legend{font:600 12px 'DM Sans',sans-serif;margin-bottom:10px}
.rb-v3 .rbv-rsvp-form .rbv-radio{display:inline-flex;gap:7px;align-items:center;margin:3px 10px 9px 0;font:500 11px 'DM Sans',sans-serif}
.rb-v3 .rbv-rsvp-button{width:100%;padding:15px;border:0;background:#762233;color:#fff;
    cursor:pointer;display:flex;justify-content:center;gap:10px;align-items:center;font:700 12px 'DM Sans',sans-serif}
.rb-v3 .rbv-rsvp-button:hover{background:#943444}
.rb-v3 .rbv-rsvp-note,.rb-v3 .rbv-rsvp-feedback,.rb-v3 .rbv-rsvp-error{font:12px/1.5 'DM Sans',sans-serif;color:#8b3e3e}
.rb-v3 .rbv-rsvp-success{background:#e2eddf;border:1px solid #63966d;color:#275836;padding:18px;margin:25px 0;font:600 13px 'DM Sans',sans-serif}
.rb-v3 .rbv-honeypot{position:absolute!important;left:-9999px!important;width:1px!important;height:1px!important;overflow:hidden!important}
.rb-v3 .rbv-contact{padding:24px 0;border-top:1px solid #dec6ad;margin-top:31px}
.rb-v3 .rbv-contact h3{font:400 39px 'Great Vibes',cursive;color:#812b35}
.rb-v3 .rbv-contact p{font:600 17px 'Cormorant Garamond',serif}
.rb-v3 .rbv-contact a{font:700 11px 'DM Sans',sans-serif;color:#8c3740}
.rb-v3 .rbv-final-names{font:400 28px 'Great Vibes',cursive;color:#812d35}
.rb-v3 .rbv-footer{padding:26px 20px;text-align:center;background:#360d1a;color:#e8c4a6;display:grid;gap:7px}
.rb-v3 .rbv-footer span{font:700 9px 'DM Sans',sans-serif;letter-spacing:.22em}
.rb-v3 .rbv-footer strong{font:600 15px 'Playfair Display',serif;letter-spacing:.06em}
.rb-v3 .rbv-lightbox{border:1px solid #aa8d79;background:#220b11;color:#f7e7d6;
    border-radius:12px;padding:26px 14px 13px;max-width:min(94vw,960px)}
.rb-v3 .rbv-lightbox::backdrop{background:#090609c9;backdrop-filter:blur(7px)}
.rb-v3 .rbv-lightbox img{max-height:78svh;max-width:90vw;width:auto;display:block;margin:auto}
.rb-v3 .rbv-lightbox-close{position:absolute;top:0;right:3px;background:none;border:0;font-size:27px;color:#fff;cursor:pointer}
.rb-v3 .rbv-lightbox p{text-align:center;font:italic 18px Georgia,serif}
/* Intro — the only visible element is the sealed, interactive envelope.
   All five layers use the same 920x600 art coordinate system as the approved V2
   HTML, with the letter FULLY hidden before the guest clicks. */
.rb-v3 .rbv-intro{
    position:fixed;inset:0;z-index:9999;display:grid;place-items:center;overflow:hidden;
    background:radial-gradient(ellipse at 50% 38%,#672b39 0%,#3f111f 49%,#1d0a11 100%);
    opacity:1;visibility:visible;
    transition:opacity .75s ease,visibility .75s ease;
}
.rb-v3 .rbv-intro[hidden]{display:none!important}
.rb-v3 .rbv-intro::before{
    content:"";position:absolute;inset:0;pointer-events:none;
    background:radial-gradient(ellipse at center,#f2c49812 0%,transparent 56%);
}
.rb-v3 .rbv-intro-stage{
    position:relative;width:100%;display:grid;place-items:center;
    padding:22px 10px;transform:scale(1);
    transition:transform .84s cubic-bezier(.15,.7,.2,1),filter .84s ease;
}
.rb-v3 .rbv-envelope-button{
    position:relative;display:block;appearance:none;-webkit-appearance:none;
    width:min(88vw,540px);height:auto;aspect-ratio:920/600;
    margin:0;padding:0;background:transparent;border:0;border-radius:0;
    cursor:pointer;-webkit-tap-highlight-color:transparent;
}
.rb-v3 .rbv-envelope{
    position:relative;display:block;width:100%;height:100%;
    perspective:1150px;isolation:isolate;pointer-events:none;
    filter:drop-shadow(0 26px 25px #11050b88);
    animation:rbv-sealed-float 5.2s ease-in-out infinite;
}
@keyframes rbv-sealed-float{
    0%,100%{transform:translate3d(0,2px,0) rotate(-.25deg)}
    50%{transform:translate3d(0,-10px,0) rotate(.25deg)}
}
.rb-v3 .rbv-envelope-button:hover .rbv-envelope{
    filter:drop-shadow(0 28px 32px #0c020aaf) drop-shadow(0 0 15px #d8a36c36);
}
.rb-v3 .rbv-envelope-button:focus-visible{
    outline:2px solid #f8d9a1;outline-offset:9px;border-radius:9px;
}
.rb-v3 .rbv-envelope>img{position:absolute;display:block;max-width:none;
    user-select:none;pointer-events:none}
.rb-v3 .rbv-envelope-back,.rb-v3 .rbv-envelope-front{
    inset:0;width:100%;height:100%;object-fit:contain
}
.rb-v3 .rbv-envelope-back{z-index:1}
.rb-v3 .rbv-envelope-front{z-index:4}
.rb-v3 .rbv-envelope-flap{
    width:100%;height:auto;top:20%;left:0;z-index:5;transform-origin:50% 0;
    transform:rotateX(0deg);backface-visibility:hidden;
    transition:transform 1.05s cubic-bezier(.24,.72,.21,1) .18s;
}
.rb-v3 .rbv-envelope-seal{
    width:21%;height:auto;left:39.5%;top:45%;z-index:6;
    filter:drop-shadow(0 7px 11px #21030d88);
    transition:opacity .32s ease,transform .35s ease;
}
.rb-v3 .rbv-letter{
    position:absolute;z-index:2;left:25%;top:8%;width:50%;
    aspect-ratio:610/740;opacity:0;pointer-events:none;
    transform:translateY(4%) scale(.84);
    filter:drop-shadow(0 13px 12px #1a041063);
    transition:transform 1.12s cubic-bezier(.18,.73,.2,1) .86s,
               opacity .22s linear .94s;
}
.rb-v3 .rbv-letter>img{position:relative;display:block;width:100%;height:100%}
.rb-v3 .rbv-letter-copy{
    position:absolute;left:5%;right:5%;top:23%;
    display:flex;flex-direction:column;align-items:center;gap:clamp(4px,1.2vw,11px);
    text-align:center;color:#72232c;
}
.rb-v3 .rbv-letter-copy small,.rb-v3 .rbv-letter-copy span,.rb-v3 .rbv-letter-copy b{
    font:700 clamp(6px,1vw,10px) 'DM Sans',sans-serif;letter-spacing:.07em
}
.rb-v3 .rbv-letter-copy strong{
    font:italic clamp(16px,3vw,29px)/1.08 'Cormorant Garamond',serif
}
.rb-v3 .rbv-envelope.is-opening{
    animation:none;transform:translate3d(0,0,0);cursor:default;pointer-events:none;
}
.rb-v3 .rbv-envelope.is-opening .rbv-envelope-seal{
    opacity:0;transform:translateY(8px) scale(.72)
}
.rb-v3 .rbv-envelope.is-opening .rbv-envelope-flap{
    transform:rotateX(-177deg)
}
.rb-v3 .rbv-envelope.is-opening .rbv-letter{
    opacity:1;transform:translateY(-25%) scale(1)
}
.rb-v3 .rbv-intro.is-fading{opacity:0;visibility:hidden;pointer-events:none}
.rb-v3 .rbv-intro.is-fading .rbv-intro-stage{
    transform:scale(1.12);filter:blur(3px)
}
body.rbv-intro-locked{overflow:hidden}
.rb-v3.rbv-motion-ready .rbv-reveal{transition:opacity .7s ease,transform .7s ease}
.rb-v3.rbv-motion-ready .rbv-reveal:not(.rbv-visible){opacity:.15;transform:translateY(15px)}
@container (max-width:560px){
 .rb-v3 .rbv-grand{padding:58px 24px}
 .rb-v3 .rbv-info{padding:52px 24px}
 .rb-v3 .rbv-cover-title h1{font-size:clamp(45px,10vw,68px)}
 .rb-v3 .rbv-title{font-size:clamp(52px,12vw,78px)}
 .rb-v3 .rbv-header-label{display:none}
 .rb-v3 .rbv-program-rows{margin:18px auto}
 .rb-v3 .rbv-family-collage{gap:8px}
 .rb-v3 .rbv-timeline-steps:before{left:14px}
 .rb-v3 .rbv-timeline-step{grid-template-columns:35px 1fr;min-height:125px}
 .rb-v3 .rbv-timeline-dot{left:14px;top:35px}
 .rb-v3 .rbv-timeline-content,.rb-v3 .rbv-timeline-step:nth-child(even) .rbv-timeline-content{
     grid-column:2;text-align:left;grid-row:1;padding:8px 15px}
 .rb-v3 .rbv-timeline-content strong{font-size:33px}
 .rb-v3 .rbv-venue-engraving{aspect-ratio:1.6/1}
 .rb-v3 .rbv-people-grid{grid-template-columns:1fr 1fr}
 .rb-v3 .rbv-entourage{grid-template-columns:1fr 1fr}
 .rb-v3 .rbv-gallery-grid{grid-template-columns:repeat(2,1fr);gap:7px}
 .rb-v3 .rbv-gallery-item:nth-child(1){grid-row:auto;aspect-ratio:4/5}
 .rb-v3 .rbv-gallery-item:nth-child(5){grid-column:span 2}
}
@container (max-width:380px){
 .rb-v3 .rbv-info{padding:43px 15px}
 .rb-v3 .rbv-grand{padding:50px 15px}
 .rb-v3 .rbv-entourage{grid-template-columns:1fr}
 .rb-v3 .rbv-info-columns{grid-template-columns:1fr}
 .rb-v3 .rbv-photo-pair{gap:7px}
 .rb-v3 .rbv-calendar{max-width:305px}
 
}
@media(max-width:600px){
 .rb-v3 .rbv-header{padding:9px 15px}
 .rb-v3 .rbv-header-label{display:none}
 .rb-v3 .rbv-grand{padding:55px 19px}
 .rb-v3 .rbv-info{padding:52px 18px}
 .rb-v3 .rbv-info-columns{grid-template-columns:1fr}
 .rb-v3 .rbv-entourage{grid-template-columns:1fr 1fr}
 
 .rb-v3 .rbv-envelope-button{width:min(90vw,470px);height:auto;aspect-ratio:920/600}
 .rb-v3 .rbv-photo-edit{font-size:9px;padding:6px 9px}
}
@media(prefers-reduced-motion:reduce){
 .rb-v3 .rbv-intro,.rb-v3 .rbv-intro *,
 .rb-v3 .rbv-reveal{animation:none!important;transition:none!important;
     scroll-behavior:auto!important}
 .rb-v3.rbv-motion-ready .rbv-reveal:not(.rbv-visible){opacity:1!important;transform:none!important}
}
</style>