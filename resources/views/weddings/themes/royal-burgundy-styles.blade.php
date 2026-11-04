<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:wght@400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
<style>
/* Royal Burgundy: a complete wedding website, not platform chrome.
   Static photo masks and one-shot reveals replace the supplied floating heart,
   perpetual gallery sheen and aggressive image scaling. */
.rb-invite{--rb-red:#810f19;--rb-maroon:#58090f;--rb-gold:#d7b577;--rb-cream:#f5ece0;--rb-paper:#fffaf3;--rb-ink:#372c28;
    background:var(--rb-paper);color:var(--rb-ink);font:17px/1.65 'Cormorant Garamond',Georgia,serif;overflow:hidden}
.rb-invite *{box-sizing:border-box}
.rb-invite [hidden]{display:none!important}
.rb-invite .rb-container{width:min(1160px,100% - 42px);margin:auto}
.rb-invite .rb-nav{min-height:66px;background:#190e10ef;border-bottom:1px solid #d7b57736;color:var(--rb-cream);padding:10px max(20px,calc((100% - 1240px)/2))}
.rb-invite .rb-brand{font:italic clamp(20px,2.2vw,29px) 'Great Vibes',Georgia,serif;color:#f5e0b1;white-space:nowrap}
.rb-invite .rb-brand span:nth-child(2){padding:0 5px}
.rb-invite .rb-links{display:flex;gap:clamp(5px,1.4vw,17px);flex-wrap:wrap}
.rb-invite .rb-links a{font:600 10px/1.4 'Cinzel',Georgia,serif;color:#faebd4;letter-spacing:.08em;text-decoration:none;border-bottom:1px solid transparent;padding:7px 2px;transition:border-color .18s}
.rb-invite .rb-links a:hover{border-color:var(--rb-gold)}
.rb-invite .rb-kicker{font:700 10px/1.7 'Cinzel',serif;letter-spacing:.22em;text-transform:uppercase;color:var(--rb-gold)}
.rb-invite .rb-section{padding:clamp(66px,8vw,114px) 0;position:relative}
.rb-invite .rb-paper{background:linear-gradient(170deg,#fcf5ea,#efe0ce);color:#4c372e}
.rb-invite .rb-burgundy{background:radial-gradient(circle at 90% 10%,#a32a2b66,transparent 38%),linear-gradient(150deg,#830f19,#54090f);color:#fff0d8}
.rb-invite .rb-noir{background:linear-gradient(140deg,#1a1414,#080707);color:#fff1d9}
.rb-invite .rb-cover{position:relative;min-height:min(800px,100svh);min-height:max(640px,100svh);display:grid;place-items:center;text-align:center;background:#190e10;isolation:isolate;padding:110px 20px 75px;color:#fbeddb}
.rb-invite .rb-cover-photo{position:absolute;inset:0;z-index:-1;background:radial-gradient(circle at 48% 30%,#6b1a23,#150b0e 65%);background-size:cover;background-position:center}
.rb-invite .rb-cover-photo::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,#180b0ec4 0%,#2b080b78 48%,#14080de0 100%);pointer-events:none}
.rb-invite .rb-cover-content{width:min(700px,100%);position:relative}
.rb-invite .rb-cover-title{font:italic clamp(25px,4vw,52px)/1.2 'Cormorant Garamond',Georgia,serif;color:#fff2da;margin:12px 0 0}
.rb-invite .rb-script{font:400 clamp(55px,8.5vw,126px)/1.06 'Great Vibes','Cormorant Garamond',cursive;color:#ffe0a0;margin:13px 0 20px;display:flex;justify-content:center;gap:.16em;align-items:center;flex-wrap:wrap;text-shadow:0 7px 28px #0007}
.rb-invite .rb-script .rb-amp{font:italic .48em 'Cormorant Garamond',serif;color:#fff5e3;align-self:center}
.rb-invite .rb-rule{height:1px;background:linear-gradient(90deg,transparent,#d7b577,transparent);width:min(380px,100%);margin:23px auto;position:relative}
.rb-invite .rb-star{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#230c13;padding:0 14px;color:#dfbb79}
.rb-invite .rb-cover-message{font:400 clamp(17px,2vw,25px)/1.5 'Cormorant Garamond',serif;max-width:570px;margin:24px auto;color:#f9ebd6}
.rb-invite .rb-cover-date{font:600 clamp(15px,2vw,20px) 'Cinzel',serif;letter-spacing:.15em;margin:22px 0 12px;color:#ffe0a0}
.rb-invite .rb-cover-venue{font:600 11px 'Cinzel',serif;letter-spacing:.18em;color:#f3e3ca}
.rb-invite .rb-pill{border:1px solid #f0cf9691;display:inline-flex;align-items:center;gap:11px;padding:11px 20px;border-radius:50px;margin-top:28px;font:600 11px 'Cinzel',serif;color:#ffe9c1;text-decoration:none}
.rb-invite .rb-pill:hover{background:#f0cf9623}
.rb-invite .rb-cover-edit{position:absolute;top:80px;right:24px;z-index:5}
.rb-invite .rb-heading{text-align:center;max-width:790px;margin:0 auto 54px}
.rb-invite .rb-heading h2{font:400 clamp(37px,5vw,69px)/1.04 'Cinzel',Georgia,serif;letter-spacing:-.045em;margin:13px 0 18px}
.rb-invite .rb-heading h2 em{font:italic 1.18em 'Great Vibes',cursive;text-transform:none;color:var(--rb-gold)}
.rb-invite .rb-paper .rb-heading h2 em{color:#8a1a22}
.rb-invite .rb-lead{font-size:clamp(18px,2.1vw,24px);line-height:1.5}
.rb-invite .rb-intro-grid{display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);gap:clamp(23px,5vw,72px);align-items:center}
.rb-invite .rb-script-small{font:italic 45px 'Great Vibes',cursive;color:#8a1a22}
.rb-invite .rb-big-date{font:600 clamp(24px,3vw,39px) 'Cinzel',Georgia,serif;color:#8a1a22}
.rb-invite .rb-detail{margin-top:25px;border-top:1px solid #b49b8673;padding-top:18px}
.rb-invite .rb-detail>span{font:700 10px 'Cinzel',serif;letter-spacing:.17em;display:block;color:#b1855e}
.rb-invite .rb-detail strong{display:block;font:500 26px/1.4 'Cormorant Garamond',Georgia,serif;margin:8px 0}
.rb-invite .rb-detail p{margin:6px 0}
.rb-invite .rb-preline{white-space:pre-line;overflow-wrap:anywhere}
.rb-invite .rb-photo-pair{display:grid;grid-template-columns:1fr 1fr;gap:14px;align-items:center}
.rb-invite .rb-photo-pair .rb-photo:nth-child(2){transform:translateY(36px)}
.rb-invite .rb-photo{position:relative;overflow:hidden;border-radius:12px;background:linear-gradient(160deg,#d1b6a0,#f5e4ca 45%,#9f5a53);margin:0;aspect-ratio:4/5;min-height:130px;border:5px solid #fff8ef;box-shadow:0 14px 35px #27070e26}
.rb-invite .rb-photo img{width:100%;height:100%;object-fit:cover;object-position:center;display:block;transition:filter .25s ease}
.rb-invite .rb-photo:hover img{filter:brightness(.96)}
.rb-invite .rb-photo-empty{position:absolute;inset:0;display:grid;place-content:center;gap:9px;text-align:center;padding:20px;color:#6d3d39;background:radial-gradient(circle at 35% 20%,#fff6e4aa,transparent 45%),linear-gradient(145deg,#e6c6b3,#c09b97)}
.rb-invite .rb-photo-empty>span{font-size:42px;color:#f9e7c9}
.rb-invite .rb-photo-empty small{font:600 11px 'Cinzel',Georgia,serif;letter-spacing:.05em;max-width:150px}
.rb-invite .rb-cover-edit,.rb-invite .rb-photo-edit{appearance:none;cursor:pointer;border:1px solid #eed7b4;background:#fffaf3f2;color:#6f141b;border-radius:99px;font:800 11px 'DM Sans',sans-serif;padding:8px 12px;display:inline-flex;align-items:center;gap:7px}
.rb-invite .rb-photo-edit{position:absolute;bottom:12px;left:50%;transform:translateX(-50%);z-index:3;white-space:nowrap}
.rb-invite [data-photo-slot].is-photo-focused{outline:5px solid #edc277!important;outline-offset:3px;box-shadow:0 0 0 10px #a41c2440!important}
.rb-invite .rb-photo-edit:hover,.rb-invite .rb-cover-edit:hover{background:#ffe6bb}
.rb-invite .rb-story{list-style:none;max-width:990px;margin:0 auto;padding:0;position:relative;display:grid;gap:35px}
.rb-invite .rb-story::before{content:"";width:1px;position:absolute;top:33px;bottom:33px;left:50%;background:linear-gradient(180deg,transparent,#e2c991,#e2c991,transparent);opacity:.72}
.rb-invite .rb-story-item{position:relative;display:grid;grid-template-columns:1fr 82px 1fr;align-items:center;gap:12px}
.rb-invite .rb-story-marker{grid-column:2;grid-row:1;justify-self:center;width:46px;height:46px;border-radius:50%;display:grid;place-items:center;background:#f2dfb9;color:#750f19;font:600 13px 'Cinzel',serif;border:6px solid #79131d;z-index:2;box-shadow:0 0 0 1px #e1c58a}
.rb-invite .rb-story-item .rb-story-photo{grid-column:1;grid-row:1;width:min(100%,260px);justify-self:end}
.rb-invite .rb-story-item .rb-story-copy{grid-column:3;grid-row:1;padding:15px 20px 15px 10px}
.rb-invite .rb-story-item:nth-child(even) .rb-story-photo{grid-column:3;justify-self:start}
.rb-invite .rb-story-item:nth-child(even) .rb-story-copy{grid-column:1;text-align:right;padding:15px 10px 15px 20px}
.rb-invite .rb-story-copy h3{font:500 clamp(28px,3vw,42px) 'Cormorant Garamond',Georgia,serif;margin:7px 0;color:#ffe2aa}
.rb-invite .rb-story-copy p{margin:0;font-size:19px;line-height:1.5}
.rb-invite .rb-people-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px}
.rb-invite .rb-person-card{padding:27px 20px;background:#fffaf8;border:1px solid #ddcbb9;border-radius:12px;min-width:0;box-shadow:0 12px 24px #5610150b}
.rb-invite .rb-person-card h3{font:700 11px/1.6 'Cinzel',Georgia,serif;color:#8b1a20;letter-spacing:.06em;margin:0 0 16px}
.rb-invite .rb-person-card p{font-size:20px;margin:6px 0;overflow-wrap:anywhere}
.rb-invite .rb-extra{margin-top:30px}
.rb-invite .rb-program-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.rb-invite .rb-program-card{padding:30px 27px;border:1px solid #d9ba836c;border-radius:12px;background:#fff6e51b}
.rb-invite .rb-program-card h3{font:500 34px 'Cormorant Garamond',Georgia,serif;margin:15px 0;color:#ffe0a0}
.rb-invite .rb-program-card p{font-size:19px}
.rb-invite .rb-info-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.rb-invite .rb-info-card{padding:30px;border:1px solid #d5bca5;border-radius:12px;background:#fffaf5}
.rb-invite .rb-info-card h3{font:500 36px 'Cormorant Garamond',Georgia,serif;color:#8b141d;margin:10px 0 18px}
.rb-invite .rb-info-card p{font-size:19px;margin:10px 0}
.rb-invite .rb-locations{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.rb-invite .rb-location{padding:28px 30px;border:1px solid #f4dfba80;background:#3a0a103d;border-radius:12px}
.rb-invite .rb-location h3{font:500 35px 'Cormorant Garamond',Georgia,serif;margin:12px 0;color:#ffe2aa}
.rb-invite .rb-location a{display:inline-flex;margin-top:15px;color:#ffe2aa;text-decoration:underline;font-size:15px}
.rb-invite .rb-gallery{display:grid;grid-template-columns:1.3fr 1fr 1fr;grid-template-rows:190px 190px;gap:13px}
.rb-invite .rb-gallery-photo{aspect-ratio:auto;border-width:3px;min-height:0}
.rb-invite .rb-gallery-photo:nth-child(1){grid-row:span 2}
.rb-invite .rb-gallery-photo:nth-child(4){grid-column:span 2}
.rb-invite .rb-rsvp-grid{display:grid;grid-template-columns:minmax(260px,.8fr) 1.2fr;gap:clamp(30px,6vw,86px);align-items:center}
.rb-invite .rb-rsvp-photo{max-width:370px}
.rb-invite .rb-rsvp-copy h2{font:400 clamp(38px,5vw,66px) 'Cinzel',serif;margin:10px 0 24px}
.rb-invite .rb-rsvp-copy h2 em{font:italic 1.2em 'Great Vibes',cursive;color:#dfc18b}
.rb-invite .rb-rsvp-copy>p{font-size:22px;line-height:1.5}
.rb-invite .rb-rsvp-note{font:13px/1.6 'DM Sans',sans-serif!important;color:#d9b5a2}
.rb-invite .rb-footer{text-align:center;background:#520910;color:#fff0d7;padding:65px 20px 55px}
.rb-invite .rb-footer p{font:italic clamp(42px,5vw,74px) 'Great Vibes',cursive;color:#ffe0a0;margin:18px 0}
.rb-invite .rb-footer a{color:#f8e7cb;font:600 11px 'Cinzel',serif;text-decoration:none}
.rb-invite .rb-reveal{opacity:1;transform:none}
.rb-invite.rb-motion-ready .rb-reveal:not(.rb-visible){opacity:.45;transform:translateY(12px)}
.rb-invite.rb-motion-ready .rb-reveal{transition:opacity .55s ease,transform .55s ease}
.rb-invite.rb-motion-ready .rb-reveal.rb-visible{opacity:1;transform:none}
@media(max-width:900px){
 .rb-invite .rb-links{display:none}
 .rb-invite .rb-people-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
 .rb-invite .rb-program-grid,.rb-invite .rb-info-grid{grid-template-columns:1fr}
 .rb-invite .rb-intro-grid{grid-template-columns:1fr}
 .rb-invite .rb-photo-pair{max-width:520px;margin:20px auto 0}
 .rb-invite .rb-gallery{grid-template-rows:150px 150px}
}
@media(max-width:600px){
 .rb-invite .rb-section{padding:60px 0}
 .rb-invite .rb-container{width:min(100% - 30px,1160px)}
 .rb-invite .rb-nav{justify-content:center;position:relative;min-height:53px}
 .rb-invite .rb-cover{min-height:690px;padding:100px 16px 60px}
 .rb-invite .rb-script{font-size:clamp(52px,12vw,82px)}
 .rb-invite .rb-heading{margin-bottom:32px}
 .rb-invite .rb-story{gap:22px;padding-left:26px}
 .rb-invite .rb-story::before{left:13px}
 .rb-invite .rb-story-item,.rb-invite .rb-story-item:nth-child(even){grid-template-columns:1fr;gap:9px;padding-left:12px}
 .rb-invite .rb-story-item .rb-story-marker{position:absolute;left:-32px;top:8px;width:38px;height:38px;grid-area:auto}
 .rb-invite .rb-story-item .rb-story-photo,.rb-invite .rb-story-item:nth-child(even) .rb-story-photo{grid-column:1;grid-row:auto;justify-self:stretch;width:min(100%,370px);max-height:370px}
 .rb-invite .rb-story-item .rb-story-copy,.rb-invite .rb-story-item:nth-child(even) .rb-story-copy{grid-column:1;grid-row:auto;text-align:left;padding:5px 10px}
 .rb-invite .rb-people-grid{grid-template-columns:1fr 1fr;gap:10px}
 .rb-invite .rb-person-card{padding:17px 13px}
 .rb-invite .rb-person-card p{font-size:17px}
 .rb-invite .rb-locations,.rb-invite .rb-rsvp-grid{grid-template-columns:1fr}
 .rb-invite .rb-rsvp-photo{max-width:290px;justify-self:center;width:100%}
 .rb-invite .rb-gallery{grid-template-columns:repeat(2,1fr);grid-template-rows:170px 170px 140px}
 .rb-invite .rb-gallery-photo:nth-child(1){grid-column:span 2;grid-row:span 1}
 .rb-invite .rb-gallery-photo:nth-child(4){grid-column:span 2}
}
@media(prefers-reduced-motion:reduce){.rb-invite .rb-reveal,.rb-invite.rb-motion-ready .rb-reveal{opacity:1!important;transform:none!important;transition:none!important}.rb-invite .rb-photo img{transition:none}}
</style>
