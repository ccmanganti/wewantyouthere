<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&family=Great+Vibes&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Royal Burgundy — a vertical, stationery-led editorial wedding website.
   Graphic resources are original WebP bitmaps committed with this template.
   No SVG line art, animation sprites, or heavy JavaScript libraries. */
.rb-invite{
    --rb-ivory:#f4f1df;--rb-paper:#faf6e9;--rb-wine:#650d16;
    --rb-dark:#290c12;--rb-ink:#46231f;--rb-gold:#ad8354;
    container-type:inline-size;position:relative;isolation:isolate;
    min-height:100svh;background:#1a1516;color:var(--rb-ink);
    font-family:'Cormorant Garamond',Georgia,serif;font-size:19px;line-height:1.55
}
.rb-invite *{box-sizing:border-box}
.rb-invite [hidden]{display:none!important}
.rb-invite .rb-preserve{white-space:pre-line;overflow-wrap:anywhere}
.rb-invite .rb-editorial-page{
    max-width:750px;margin:auto;
    box-shadow:0 0 75px #0005;position:relative;
    background:var(--rb-ivory)
}
.rb-invite .rb-light{color:var(--rb-ink);background-color:var(--rb-ivory);
    background-image:url('/wedding/royal-burgundy/paper-texture.webp');
    background-size:600px auto}
.rb-invite .rb-wine{color:#fff0dc;background:
    radial-gradient(ellipse at 12% -3%,#a5323b4d,transparent 49%),
    linear-gradient(142deg,#74121d,#520b13)}
.rb-invite .rb-panel{
    padding:clamp(64px,8vw,94px) clamp(22px,8vw,84px);
    text-align:center;position:relative;overflow:hidden
}
.rb-invite .rb-eyebrow{display:block;font:700 10px/1.7 'Cinzel',Georgia,serif;
    letter-spacing:.21em;color:#955b46;text-transform:uppercase}
.rb-invite .rb-wine .rb-eyebrow{color:#e4c299}
.rb-invite .rb-script-small{display:block;font:400 40px/.9 'Great Vibes',cursive;color:#7e1c24}
.rb-invite .rb-script-title{font:400 clamp(52px,8.4vw,92px)/1.18 'Great Vibes',cursive;
    color:#74161c;letter-spacing:.015em;margin:18px 0 26px}
.rb-invite .rb-wine .rb-script-title{color:#f8e4c4}
.rb-invite .rb-body-copy{font:500 clamp(20px,2.5vw,26px)/1.44 'Cormorant Garamond',serif;
    max-width:480px;margin:16px auto 24px}
.rb-invite .rb-ornament-dot{display:inline-block;font-size:20px;color:#ba925f;margin-top:17px}
.rb-invite .rb-site-nav{
    position:sticky!important;z-index:27;top:0;
    max-width:750px;margin:0 auto;min-height:58px;display:flex;
    align-items:center;justify-content:space-between;
    padding:11px 25px;background:#2b1316f4;
    border-bottom:1px solid #dfc09b55;backdrop-filter:blur(12px)
}
.rb-invite .rb-site-monogram{
    display:inline-flex;align-items:center;gap:7px;color:#f6e0c2;
    text-decoration:none;font:italic 23px 'Cormorant Garamond',serif;
    line-height:1.1;max-width:60%;min-width:0
}
.rb-invite .rb-site-monogram span:first-child,
.rb-invite .rb-site-monogram span:last-child{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.rb-invite .rb-monogram-amp{color:#cb9869}
.rb-invite .rb-site-links{display:flex;align-items:center;gap:15px}
.rb-invite .rb-site-links a,.rb-invite .rb-site-mobile a{
    color:#f3e4cd;text-decoration:none;font:600 9px 'DM Sans',sans-serif;
    letter-spacing:.035em;white-space:nowrap
}
.rb-invite .rb-site-links a:hover,.rb-invite .rb-site-mobile a:hover{color:#e7ae90}
.rb-invite .rb-site-mobile{display:none;position:relative;font:600 12px 'DM Sans',sans-serif}
.rb-invite .rb-site-mobile summary{display:flex;align-items:center;gap:8px;color:#ead9c4;cursor:pointer;list-style:none}
.rb-invite .rb-site-mobile summary::-webkit-details-marker{display:none}
.rb-invite .rb-site-mobile-links{position:absolute;right:0;top:calc(100% + 14px);
    min-width:190px;z-index:4;border:1px solid #98675d;background:#2c0f14;
    border-radius:8px;box-shadow:0 14px 28px #0005;display:grid;padding:8px}
.rb-invite .rb-site-mobile-links a{padding:10px 12px;border-radius:5px}
.rb-invite .rb-site-mobile-links a:hover{background:#66212a}
.rb-invite .rb-panel-hero{padding-top:70px;padding-bottom:59px}
.rb-invite .rb-hero-heading h1{
    font:600 clamp(43px,6.6vw,74px)/.93 'Cinzel',Georgia,serif;
    letter-spacing:-.095em;max-width:590px;margin:8px auto 17px;color:#55191d
}
.rb-invite .rb-hero-heading h1 em{
    display:block;font:400 clamp(55px,9vw,103px)/1 'Great Vibes',cursive;
    letter-spacing:0;color:#89252c;text-transform:none
}
.rb-invite .rb-hero-eyebrow{margin-bottom:29px}
.rb-invite .rb-image-frame{display:block;position:relative;margin:0 auto;overflow:hidden;
    background:#dfc4a8;isolation:isolate}
.rb-invite .rb-image-frame>img{width:100%;height:100%;display:block;
    object-fit:cover;object-position:center}
.rb-invite .rb-hero-image{aspect-ratio:4/5;width:min(360px,100%);
    border:9px solid #faf6e9;box-shadow:0 0 0 1px #c3a780,0 18px 35px #57141722}
.rb-invite .rb-image-placeholder{position:absolute;inset:0;display:grid;place-content:center;
    text-align:center;isolation:isolate;background:#d3b1a0;overflow:hidden}
.rb-invite .rb-image-placeholder img{position:absolute;inset:0;width:100%;height:100%;
    object-fit:cover;filter:saturate(.75) brightness(.83);z-index:-1}
.rb-invite .rb-image-placeholder span{display:inline-block;max-width:270px;margin:auto;padding:11px 14px;
    background:#3a1822b6;color:#fbebc7;font:700 10px 'Cinzel',serif;letter-spacing:.14em}
.rb-invite .rb-placeholder-photo{background:
    radial-gradient(ellipse at 50% 8%,#fff9ebaa,transparent 75%),
    linear-gradient(155deg,#dec8b3,#8d4a4c)}
.rb-invite .rb-placeholder-venue{background:#7c222c}
.rb-invite .rb-placeholder-reception{background:#4b101d}
.rb-invite .rb-image-edit{
    position:absolute;z-index:5;left:50%;bottom:13px;transform:translateX(-50%);
    display:flex;align-items:center;gap:8px;padding:9px 12px;border-radius:50px;
    border:1px solid #dfc399;background:#fdf9f2ee;color:#6b1420;
    font:700 11px 'DM Sans',sans-serif;white-space:nowrap;cursor:pointer;
    box-shadow:0 5px 15px #1909085e
}
.rb-invite .rb-image-edit:hover{background:#fff}
.rb-invite [data-photo-slot].is-photo-focused{outline:5px solid #eec786!important;
    outline-offset:4px;box-shadow:0 0 0 11px #96302e6e!important}
.rb-invite .rb-couple-names{display:flex;justify-content:center;align-items:center;
    flex-wrap:wrap;gap:16px;font:400 clamp(36px,5.5vw,60px)/1.2 'Great Vibes',cursive;
    color:#71171f;margin:22px 0 9px}
.rb-invite .rb-couple-heart{font:400 18px Georgia,serif;color:#9d2b38}
.rb-invite .rb-hero-message{max-width:440px;margin:13px auto;
    font:500 17px/1.38 'Cormorant Garamond',serif}
.rb-invite .rb-hero-date{font:600 12px 'Cinzel',serif;color:#76413a;
    letter-spacing:.1em;margin:22px 0}
.rb-invite .rb-scroll-cue,.rb-invite .rb-to-top{color:#8a3742;text-decoration:none;
    display:inline-flex;align-items:center;gap:9px;font:700 10px 'DM Sans',sans-serif;
    letter-spacing:.08em;text-transform:uppercase}
.rb-invite .rb-art-panel{height:340px;width:100%;background-color:#4c0a12;
    background-size:cover;background-position:center}
.rb-invite .rb-doors-panel{background-image:url('/wedding/royal-burgundy/grand-doors.webp')}
.rb-invite .rb-message-panel{padding:68px 22px}
.rb-invite .rb-invitation-card{
    max-width:535px;border:1px solid #b5a08a;margin:auto;padding:30px 38px 34px;
    position:relative;background:#fdf9f08c}
.rb-invite .rb-invitation-card::before,.rb-invite .rb-invitation-card::after{
    content:"";position:absolute;width:25px;height:25px;border:1px solid #b59a7e
}
.rb-invite .rb-invitation-card::before{left:10px;top:10px;border-right:0;border-bottom:0}
.rb-invite .rb-invitation-card::after{right:10px;bottom:10px;border-left:0;border-top:0}
.rb-invite .rb-message-script{font:400 clamp(39px,5vw,65px)/1.2 'Great Vibes',cursive;
    color:#741a23;margin:17px 0}
.rb-invite .rb-message-copy{font:500 22px/1.4 'Cormorant Garamond',serif;margin:auto}
.rb-invite .rb-date-panel{padding-top:64px;padding-bottom:42px}
.rb-invite .rb-date-panel .rb-script-title{margin:12px 0 -4px}
.rb-invite .rb-date-year{display:block;font:500 19px 'Cinzel',serif;
    letter-spacing:.25em;margin:10px 0 31px}
.rb-invite .rb-calendar{max-width:390px;margin:0 auto}
.rb-invite .rb-calendar-weekdays,.rb-invite .rb-calendar-days{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:3px}
.rb-invite .rb-calendar-weekdays{margin-bottom:18px}
.rb-invite .rb-calendar-weekdays span{font:700 12px 'Cinzel',serif;color:#67413a}
.rb-invite .rb-day,.rb-invite .rb-cal-empty{aspect-ratio:1/1;display:grid;place-items:center;
    font:500 17px 'Cormorant Garamond',serif}
.rb-invite .rb-day-selected{border-radius:50%;color:#fff;background:#811c27;
    box-shadow:0 3px 8px #69131b28;font-weight:700}
.rb-invite .rb-botanical{display:block;width:min(440px,80%);height:auto;max-height:270px;
    object-fit:contain;margin:33px auto 0;opacity:.78}
.rb-invite .rb-timing-panel{padding-top:72px;padding-bottom:58px}
.rb-invite .rb-timing-grid{display:grid;grid-template-columns:1fr 1fr;
    gap:26px 13px;max-width:460px;margin:27px auto 32px}
.rb-invite .rb-timing-item{display:grid;gap:6px}
.rb-invite .rb-timing-item strong{font:400 clamp(30px,4vw,49px) 'Great Vibes',cursive;color:#ffdfa5}
.rb-invite .rb-timing-item span{font:600 10px 'Cinzel',serif;letter-spacing:.05em}
.rb-invite .rb-program-notes{max-width:510px;margin:29px auto 0;padding:23px 13px 4px;
    border-top:1px solid #e4b9877a;display:grid;grid-template-columns:1fr 1fr;gap:25px}
.rb-invite .rb-program-notes p{font:500 17px/1.4 'Cormorant Garamond',serif;margin:7px auto 13px}
.rb-invite .rb-timing-art{display:block;width:210px;height:116px;object-fit:contain;
    margin:7px auto -10px;opacity:.56;filter:sepia(1) brightness(2.5)}
.rb-invite .rb-venue-panel,.rb-invite .rb-reception-panel{padding-top:75px;padding-bottom:84px}
.rb-invite .rb-venue-image{max-width:510px;aspect-ratio:4/3;margin:22px auto 26px;
    border:6px solid #f6e7d4;box-shadow:0 14px 35px #330d113a}
.rb-invite .rb-location-name{font:600 clamp(25px,4vw,41px)/1.2 'Cinzel',serif;
    margin:12px auto 10px;letter-spacing:-.07em;overflow-wrap:anywhere}
.rb-invite .rb-location-address{max-width:450px;margin:0 auto;font:500 19px 'Cormorant Garamond',serif}
.rb-invite .rb-venue-time{font:600 14px 'Cinzel',serif;margin:15px 0}
.rb-invite .rb-venue-link,.rb-invite .rb-contact-phone{
    background:#6a111b;color:#fff!important;padding:11px 22px;
    min-height:43px;display:inline-flex;align-items:center;gap:9px;
    font:700 11px 'DM Sans',sans-serif;text-decoration:none;
    transition:background .2s ease;border-radius:2px;margin-top:15px}
.rb-invite .rb-venue-link:hover{background:#9e2835}
.rb-invite .rb-venue-link-light{background:#f4ead8;color:#61131b!important}
.rb-invite .rb-venue-link-light:hover{background:#fff}
.rb-invite .rb-dress-panel{padding-bottom:63px}
.rb-invite .rb-dress-panel .rb-body-copy{margin-bottom:23px}
.rb-invite .rb-swatches{display:block;width:min(485px,100%);height:auto;margin:5px auto}
.rb-invite .rb-color-motif{font:600 11px 'Cinzel',serif;letter-spacing:.03em;color:#81432b}
.rb-invite .rb-extra-note{font-size:16px;max-width:470px;margin:16px auto 0}
.rb-invite .rb-mini-engraving{display:block;width:240px;height:90px;object-fit:cover;opacity:.56;margin:24px auto 0}
.rb-invite .rb-story-panel{padding-top:78px;padding-bottom:79px}
.rb-invite .rb-story-chapters{display:grid;gap:26px;max-width:530px;margin:38px auto}
.rb-invite .rb-story-card{padding:22px 29px 26px;border:1px solid #d7bd9f;
    background:#fdf9ed9c;position:relative}
.rb-invite .rb-chapter-number{display:block;color:#9c5349;font:600 10px 'Cinzel',serif;letter-spacing:.15em}
.rb-invite .rb-story-card h3{font:400 clamp(30px,4.7vw,55px) 'Great Vibes',cursive;
    color:#731c26;margin:12px 0 8px}
.rb-invite .rb-story-card p{font-size:18px;margin:0;line-height:1.43}
.rb-invite .rb-story-image{width:min(290px,100%);aspect-ratio:4/5;margin:18px auto}
.rb-invite .rb-secondary-portrait{width:min(300px,80%);aspect-ratio:4/5;
    margin:29px auto;border:7px solid #fff6e6}
.rb-invite .rb-people-grid{max-width:555px;display:grid;grid-template-columns:1fr 1fr;
    gap:15px 21px;margin:28px auto}
.rb-invite .rb-person-entry{border-bottom:1px solid #bda48e;padding:17px 11px;min-width:0}
.rb-invite .rb-person-entry p{font:500 19px/1.5 'Cormorant Garamond',serif;margin:11px 0 0}
.rb-invite .rb-people-botanical{margin-top:28px;width:260px;max-height:120px}
.rb-invite .rb-gallery-grid{max-width:560px;margin:28px auto 0;
    display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
.rb-invite .rb-gallery-image{width:100%;aspect-ratio:4/5}
.rb-invite .rb-gallery-image:first-child{grid-row:span 2}
.rb-invite .rb-gallery-image:first-child:only-child{grid-row:auto;max-width:370px;margin:auto;grid-column:1/-1}
.rb-invite .rb-gifts-panel{padding-top:77px;padding-bottom:70px}
.rb-invite .rb-rsvp-panel{padding:80px 26px 85px}
.rb-invite .rb-rsvp-panel .rb-body-copy{color:#f1ddc7}
.rb-invite .rb-rsvp-by{font:500 16px 'Cormorant Garamond',serif;margin:30px auto}
.rb-invite .rb-rsvp-by strong{display:block;font:600 15px 'Cinzel',serif;letter-spacing:.06em;margin-top:9px}
.rb-invite .rb-rsvp-cta{display:inline-flex;align-items:center;gap:12px;
    background:#fbf1dc;color:#58121e;text-decoration:none;
    border-radius:3px;padding:13px 26px;
    font:700 11px 'DM Sans',sans-serif;margin:6px auto 18px}
.rb-invite .rb-rsvp-cta:hover{background:#fff}
.rb-invite .rb-rsvp-notice{font:400 11px/1.65 'DM Sans',sans-serif;
    color:#e9c5b5;max-width:360px;margin:15px auto 0}
.rb-invite .rb-contact-envelope{width:min(410px,100%);height:295px;position:relative;
    margin:30px auto 0;isolation:isolate}
.rb-invite .rb-contact-envelope>img:not(.rb-contact-seal){position:absolute;inset:0;
    width:100%;height:100%;object-fit:contain}
.rb-invite .rb-contact-letter{position:absolute;width:55%;min-height:98px;top:23%;left:22.5%;
    display:grid;place-items:center;background:#fdf7e9;border:1px solid #d2b790;
    box-shadow:0 5px 15px #43111a35;padding:12px;color:#691b26}
.rb-invite .rb-contact-letter span{font:600 9px 'Cinzel',serif;letter-spacing:.11em}
.rb-invite .rb-contact-letter strong{font:italic 22px 'Cormorant Garamond',serif;
    display:block;line-height:1.2;overflow-wrap:anywhere}
.rb-invite .rb-contact-letter p{font-size:14px;margin:0}
.rb-invite .rb-contact-seal{position:absolute;width:64px!important;height:64px!important;
    left:calc(50% - 32px);bottom:10px;z-index:5}
.rb-invite .rb-contact-phone{margin-top:18px}
.rb-invite .rb-closing-photo{aspect-ratio:4/5;max-width:240px;margin:38px auto 0}
.rb-invite .rb-final-panel{padding-top:68px;padding-bottom:60px}
.rb-invite .rb-final-script{font:400 clamp(62px,9vw,111px) 'Great Vibes',cursive;
    color:#ffe2b5;margin:12px 0 22px}
.rb-invite .rb-final-names{font:500 21px 'Cinzel',serif}
.rb-invite .rb-final-flowers{display:block;margin:17px auto 25px;
    width:min(245px,55%);height:auto;max-height:110px;
    object-fit:cover;opacity:.6;filter:sepia(1) brightness(2.2)}
.rb-invite .rb-to-top{color:#f4d4aa}
.rb-invite .rb-extra{max-width:570px;margin:18px auto}
.rb-invite .rb-extra [data-extra-row]{font-size:17px}
/* Subtle, one-time section reveals. No oversized moving heart or image parallax. */
.rb-invite .rb-reveal{opacity:1;transform:none}
.rb-invite.rb-motion-ready .rb-reveal:not(.rb-visible){opacity:.25;transform:translateY(12px)}
.rb-invite.rb-motion-ready .rb-reveal{transition:transform .65s ease,opacity .65s ease}
.rb-invite.rb-motion-ready .rb-reveal.rb-visible{opacity:1;transform:none}
/* The envelope intro is composed entirely of layered WebP image elements. */
.rb-envelope-intro{position:fixed;inset:0;z-index:9999;background:
    radial-gradient(ellipse at center,#571721 0%,#220b10 75%);
    display:grid;place-items:center;color:#f4e7d7;
    opacity:1;transition:opacity .5s ease;overscroll-behavior:contain}
.rb-envelope-intro[hidden]{display:none!important}
.rb-envelope-intro.rb-leaving{opacity:0;pointer-events:none}
.rb-envelope-stage{width:min(94vw,640px);text-align:center;position:relative}
.rb-envelope-caption{display:block;font:600 11px 'Cinzel',serif;letter-spacing:.2em;
    color:#f5d9ad;margin-bottom:18px}
.rb-envelope-object{position:relative;width:min(80vw,500px);
    height:min(60vw,400px);max-height:400px;margin:auto;perspective:1100px;isolation:isolate}
.rb-envelope-object>img{position:absolute;display:block;max-width:none;object-fit:contain;
    pointer-events:none;user-select:none}
.rb-envelope-back,.rb-envelope-front{width:100%;height:auto;left:0;top:0}
.rb-envelope-back{z-index:1}
.rb-envelope-letter{width:58%;height:auto;left:21%;top:-19%;z-index:2;
    transform:translateY(34%) scale(.86);filter:drop-shadow(0 8px 14px #11030664);
    transition:transform 1.2s cubic-bezier(.2,.75,.25,1) .95s}
.rb-envelope-front{z-index:3}
.rb-envelope-flap{width:100%;height:auto;top:18%;left:0;z-index:5;transform-origin:50% 0%;
    transform:rotateX(0deg);
    backface-visibility:visible;transition:transform 1s cubic-bezier(.2,.7,.16,1) .18s}
.rb-envelope-wax{width:26%;height:auto;left:37%;top:42%;z-index:6;
    transition:opacity .25s ease,transform .35s ease;filter:drop-shadow(0 9px 10px #1d060a55)}
.rb-envelope-intro[data-envelope-phase="opening"] .rb-envelope-wax{opacity:0;transform:scale(.85)}
.rb-envelope-intro[data-envelope-phase="opening"] .rb-envelope-flap{transform:rotateX(174deg);z-index:2}
.rb-envelope-intro[data-envelope-phase="opening"] .rb-envelope-letter{transform:translateY(-36%) scale(.98)}
.rb-envelope-label{font:400 clamp(40px,7vw,74px) 'Great Vibes',cursive;margin:15px 0 18px;color:#f3ddba}
.rb-envelope-skip{background:none;border:1px solid #ba9787;color:#fff2e2;border-radius:999px;
    padding:11px 19px;cursor:pointer;font:600 11px 'DM Sans',sans-serif;letter-spacing:.04em}
.rb-envelope-skip:hover{background:#ffffff19}
body.rb-envelope-locked{overflow:hidden}
.builder-app .rb-envelope-intro{position:absolute;inset:0;z-index:55}
.builder-app .rb-envelope-object{width:min(83%,330px);height:min(62vw,265px)}
.builder-app .rb-envelope-caption{font-size:9px}
@container (max-width:610px){
    .rb-invite .rb-site-links{display:none}
    .rb-invite .rb-site-mobile{display:block}
    .rb-invite .rb-panel{padding:56px 26px}
    .rb-invite .rb-hero-heading h1{font-size:clamp(39px,10vw,64px)}
    .rb-invite .rb-script-title{font-size:clamp(48px,12vw,78px)}
    .rb-invite .rb-timing-grid{gap:17px 8px}
    .rb-invite .rb-people-grid{grid-template-columns:1fr 1fr;gap:5px}
    .rb-invite .rb-venue-image{width:100%}
    .rb-invite .rb-art-panel{height:250px}
}
@container (max-width:420px){
    .rb-invite .rb-panel{padding:49px 18px}
    .rb-invite .rb-panel-hero{padding-top:45px}
    .rb-invite .rb-couple-names{font-size:40px;gap:9px}
    .rb-invite .rb-hero-image{width:min(290px,90%)}
    .rb-invite .rb-calendar{max-width:330px}
    .rb-invite .rb-invitation-card{padding:27px 20px}
    .rb-invite .rb-people-grid{grid-template-columns:1fr}
    .rb-invite .rb-program-notes{grid-template-columns:1fr}
    .rb-invite .rb-gallery-grid{gap:7px}
    .rb-invite .rb-site-nav{padding:10px 16px}
    .rb-invite .rb-image-edit{font-size:10px}
}
@media(max-width:620px){
    .rb-invite .rb-editorial-page{box-shadow:none}
    .rb-invite .rb-site-links{display:none}
    .rb-invite .rb-site-mobile{display:block}
    .rb-invite .rb-panel{padding:55px 21px}
    .rb-invite .rb-people-grid{grid-template-columns:1fr}
    .rb-envelope-caption{font-size:9px}
}
@media(prefers-reduced-motion:reduce){
    .rb-invite .rb-reveal,.rb-invite.rb-motion-ready .rb-reveal{opacity:1!important;
        transform:none!important;transition:none!important}
    .rb-envelope-intro,.rb-envelope-intro *{transition:none!important;animation:none!important}
}
</style>