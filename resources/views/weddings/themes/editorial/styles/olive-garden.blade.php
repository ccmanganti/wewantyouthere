<style>
.ce2-olive-garden{--og:#46543c;--og-paper:#fbf8ef;--og-wine:#793c45;background:var(--og-paper);color:#394237;font:18px/1.65 'Libre Baskerville',Georgia,serif}
.ce2-olive-garden h2{font:400 clamp(43px,6vw,76px)/1.15 'DM Serif Display',serif}
.ce2-olive-garden h3{font:400 clamp(26px,3.4vw,40px)/1.2 'DM Serif Display',serif}
.ce2-olive-garden .og-overline,.ce2-olive-garden .og-field-label{font:700 10px/1.5 'DM Sans',sans-serif;letter-spacing:.2em}
.ce2-olive-garden .og-tab{display:inline-block;background:var(--og-wine);color:#fff;padding:8px 14px;font:700 10px/1.2 'DM Sans',sans-serif;letter-spacing:.15em}
.ce2-olive-garden .og-nav{position:absolute;top:0;left:0;right:0;z-index:11;display:flex;justify-content:space-between;align-items:center;padding:18px 25px;color:#faf8f0;font:700 11px 'DM Sans',sans-serif;letter-spacing:.12em}
.ce2-olive-garden .og-nav a{color:inherit;text-decoration:none}
.ce2-olive-garden .og-nav a span{font-size:22px;color:#cfdbbb;vertical-align:middle}
.ce2-olive-garden .og-nav details{position:relative}.ce2-olive-garden .og-nav summary{cursor:pointer;list-style:none;min-height:35px;padding:9px}
.ce2-olive-garden .og-nav details>div{position:absolute;right:0;top:100%;width:180px;background:#f9f3e6;color:var(--og);padding:15px;display:grid;gap:12px;box-shadow:0 10px 22px #0005}
.ce2-olive-garden .og-cover{min-height:100svh;background:#526844;padding:110px clamp(20px,7vw,110px) 72px;position:relative;display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:clamp(20px,6vw,90px);overflow:hidden}
.ce2-olive-garden .og-leaf-spread{position:absolute;inset:0;background-size:cover;background-position:center;opacity:.16;filter:saturate(.8);mix-blend-mode:screen}
.ce2-olive-garden .og-cover-left,.ce2-olive-garden .og-cover-right{position:relative;min-width:0}
.ce2-olive-garden .og-paper-label{position:absolute;left:-7%;top:0;width:210px;height:95px;background:#faf0d7;z-index:2;padding:13px;display:grid;text-align:center;align-content:center;gap:2px;transform:rotate(-8deg);box-shadow:0 5px 17px #0004}
.ce2-olive-garden .og-paper-label span{font:700 8px 'DM Sans',sans-serif;letter-spacing:.1em}
.ce2-olive-garden .og-paper-label strong{font:500 16px 'DM Serif Display',serif}
.ce2-olive-garden .og-cover-photo{width:100%;aspect-ratio:4/5;transform:rotate(-4deg);border:13px solid #f8f5e9;box-shadow:13px 19px 2px #20332281}
.ce2-olive-garden .og-photo-tape{position:absolute;top:29px;right:5%;width:92px;height:30px;background:#e5d9aaab;transform:rotate(18deg);z-index:2;box-shadow:0 1px 2px #0002}
.ce2-olive-garden .og-cover-right{min-height:520px;padding:48px 24px 60px;background:linear-gradient(145deg,#f6f1df,#e7e1cc);clip-path:polygon(0 2%,100% 0,100% 98%,0 100%);display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;box-shadow:0 19px 20px #0003}
.ce2-olive-garden .og-flower-mark{font-size:52px;color:var(--og-wine)}
.ce2-olive-garden .og-cover h1{font:400 clamp(49px,7vw,108px)/.95 'DM Serif Display',serif;margin:36px auto 18px;display:flex;flex-direction:column;align-items:center;color:#4d5a38;letter-spacing:-.05em}
.ce2-olive-garden .og-cover h1 em{font:400 .7em 'Caveat',cursive;color:var(--og-wine);line-height:1.15}
.ce2-olive-garden .og-date{font-size:24px}.ce2-olive-garden .og-location{font-style:italic;font-size:16px}
.ce2-olive-garden .og-cover-right>a{margin-top:35px;text-decoration:none;border-bottom:1px solid var(--og);font:700 10px 'DM Sans',sans-serif;letter-spacing:.15em}
.ce2-olive-garden .og-welcome{background:#f6f3e6;padding:90px 20px;position:relative}
.ce2-olive-garden .og-notebook{background:#fffaf0;position:relative;max-width:920px;margin:auto;padding:65px clamp(22px,6vw,85px) 90px;clip-path:polygon(0 1.3%,3% .6%,6% 1.1%,10% .2%,90% .3%,96% .7%,100% 0,100% 99%,95% 98%,90% 100%,5% 99%,0 100%);box-shadow:0 15px 30px #0001}
.ce2-olive-garden .og-hand-note{position:relative;max-width:600px;padding-top:35px}.ce2-olive-garden .og-hand-note h2{color:var(--og-wine)}
.ce2-olive-garden .og-hand-note p{max-width:570px;margin-top:21px}
.ce2-olive-garden .og-hand-note .og-signature{font:400 45px 'Caveat',cursive;color:var(--og-wine)}
.ce2-olive-garden .og-pressed{position:absolute;right:3%;top:30px;width:185px;height:240px;background-size:cover;background-position:center;opacity:.8;clip-path:polygon(15% 0,100% 0,100% 100%,0 100%);mix-blend-mode:multiply}
.ce2-olive-garden .og-memory-row{display:flex;align-items:center;justify-content:center;gap:35px;margin:90px auto 0;max-width:760px}
.ce2-olive-garden .og-memory{background:#fff;padding:10px 10px 46px;aspect-ratio:4/5;width:46%;overflow:visible;box-shadow:0 11px 20px #44342236}
.ce2-olive-garden .og-memory-a{transform:rotate(-8deg)}.ce2-olive-garden .og-memory-b{transform:rotate(6deg) translateY(28px)}
.ce2-olive-garden .og-memory img{height:100%}.ce2-olive-garden .og-memory figcaption{text-align:center;font:400 27px 'Caveat',cursive;color:#6b584b}
.ce2-olive-garden .og-story{background:#e9e8d6;padding:110px clamp(25px,7vw,100px);text-align:center}
.ce2-olive-garden .og-story-layout{max-width:1100px;margin:45px auto 0;display:grid;grid-template-columns:1.1fr 1fr;gap:45px;align-items:center;text-align:left}
.ce2-olive-garden .og-story-photo{aspect-ratio:3/4;border:15px solid #fffaf1;transform:rotate(3deg);box-shadow:9px 12px 25px #3333}
.ce2-olive-garden .og-story-copy h2{color:var(--og);margin-bottom:20px}.ce2-olive-garden .og-handwritten{font:400 clamp(28px,4vw,45px) 'Caveat',cursive;color:var(--og-wine);margin:25px auto 0}
.ce2-olive-garden .og-calendar{display:grid;grid-template-columns:1fr 1fr;min-height:520px;background:#647b56;color:#fff8df}
.ce2-olive-garden .og-calendar-left{padding:85px clamp(22px,5vw,80px);display:flex;flex-direction:column;align-items:flex-start;justify-content:center;gap:17px}
.ce2-olive-garden .og-calendar-left h2{max-width:440px}.ce2-olive-garden .og-calendar-date{font-size:28px;margin-top:10px}
.ce2-olive-garden .og-calendar-right{position:relative;display:grid;place-items:center;padding:50px 22px}
.ce2-olive-garden .og-calendar-illustration{position:absolute;inset:0;background-size:cover;background-position:center;opacity:.26;filter:sepia(.3)}
.ce2-olive-garden .og-mini-calendar{position:relative;width:min(360px,100%);background:#faf7ea;color:#45523e;padding:25px;box-shadow:10px 12px 0 #283a2966}
.ce2-olive-garden .ce2-calendar-grid{gap:6px}.ce2-olive-garden .ce2-calendar-selected{background:#7d4650;color:#fff}
.ce2-olive-garden .og-venue{padding:110px 25px;background:#fbf9ef;display:grid;grid-template-columns:1fr 1fr;gap:40px;max-width:1300px;margin:auto}
.ce2-olive-garden .og-venue-note{padding:40px clamp(18px,4vw,65px);background:#f0ecdb;outline:1px solid #bdc0a6;outline-offset:-14px;align-self:center}
.ce2-olive-garden .og-venue-note h2{margin:30px 0}
.ce2-olive-garden .og-venue-note h3{margin:12px 0}.ce2-olive-garden .og-field-label{margin-top:29px;color:var(--og-wine)}
.ce2-olive-garden .og-venue-stack{display:grid;gap:35px;padding:15px}
.ce2-olive-garden .og-venue-photo{aspect-ratio:1.3;background:#fdf9ef;padding:9px 9px 35px;box-shadow:6px 7px 20px #0002}
.ce2-olive-garden .og-venue-photo-a{transform:rotate(-4deg)}.ce2-olive-garden .og-venue-photo-b{transform:rotate(5deg)}
.ce2-olive-garden .og-venue-photo figcaption{text-align:center;font:700 10px 'DM Sans',sans-serif;letter-spacing:.13em;margin-top:6px}
.ce2-olive-garden .og-ceremony-notes{padding:70px 20px;text-align:center;background:#f5f0e1}.ce2-olive-garden .og-ceremony-notes h2{margin:20px auto}
.ce2-olive-garden .og-timeline{background:#47613f;color:#f9f3e5;text-align:center;padding:120px 24px}
.ce2-olive-garden .og-timeline h2{margin:19px auto 50px}
.ce2-olive-garden .og-timeline-list{display:grid;max-width:800px;margin:auto;gap:10px}
.ce2-olive-garden .og-timeline-list>div{display:grid;grid-template-columns:38px 130px 1fr;gap:22px;align-items:center;text-align:left;border-bottom:1px dashed #ffffff72;padding:22px 0}
.ce2-olive-garden .og-bloom-dot{font-size:25px;color:#e4bdc5}
.ce2-olive-garden .og-timeline-list strong{font-size:28px}
.ce2-olive-garden .og-program-notes{white-space:pre-line;margin:40px 0 0}
.ce2-olive-garden .og-people{padding:110px 22px;background:#ede5dc;text-align:center}
.ce2-olive-garden .og-people h2{margin:22px auto 40px}
.ce2-olive-garden .og-people-grid{display:grid;gap:15px;max-width:850px;margin:auto;grid-template-columns:repeat(3,1fr)}
.ce2-olive-garden .og-people-grid>div{background:#faf7eb;padding:35px 15px;clip-path:polygon(0 0,100% 2%,100% 100%,0 98%)}
.ce2-olive-garden .og-people-grid span{font:700 9px 'DM Sans',sans-serif;letter-spacing:.15em}
.ce2-olive-garden .og-people-grid p{white-space:pre-line;margin-top:17px}
.ce2-olive-garden .og-album{padding:110px 24px;background:#f8f5e8;text-align:center}
.ce2-olive-garden .og-album h2{margin:20px auto 60px}
.ce2-olive-garden .og-scrapbook-grid{max-width:900px;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:30px 50px;margin:auto}
.ce2-olive-garden .og-scrapbook-photo{aspect-ratio:4/5;border:11px solid #fffaf0;box-shadow:7px 9px 16px #3e49342e;overflow:visible}
.ce2-olive-garden .og-scrapbook-photo:nth-child(1){transform:rotate(-8deg)}.ce2-olive-garden .og-scrapbook-photo:nth-child(2){transform:rotate(7deg) translateY(24px)}
.ce2-olive-garden .og-scrapbook-photo:nth-child(3){transform:rotate(5deg)}.ce2-olive-garden .og-scrapbook-photo:nth-child(4){transform:rotate(-5deg) translateY(-9px)}
.ce2-olive-garden .og-attire{background:#7f4649;padding:120px 22px;text-align:center}
.ce2-olive-garden .og-attire-card{max-width:720px;margin:auto;background:#faf5e9;padding:75px 35px 60px;box-shadow:0 15px 30px #24181b65;position:relative}
.ce2-olive-garden .og-attire-bow{position:absolute;width:140px;height:36px;left:calc(50% - 70px);top:-25px;background:#6d1f36;clip-path:polygon(0 15%,30% 50%,0 85%,44% 52%,50% 20%,56% 52%,100% 15%,70% 50%,100% 85%,56% 56%,50% 80%,44% 56%)}
.ce2-olive-garden .og-attire h2{margin:20px auto}.ce2-olive-garden .og-attire p{margin:10px auto}
.ce2-olive-garden .og-palette{display:flex;justify-content:center;gap:14px;margin:28px 0 40px}
.ce2-olive-garden .og-palette i{width:43px;height:43px;border-radius:50%;background:#a7ae84}.ce2-olive-garden .og-palette i:nth-child(2){background:#64313c}.ce2-olive-garden .og-palette i:nth-child(3){background:#2f5a44}.ce2-olive-garden .og-palette i:nth-child(4){background:#c4b8a5}.ce2-olive-garden .og-palette i:nth-child(5){background:#f0e7d6;border:1px solid #c4bba8}
.ce2-olive-garden .og-rsvp{padding:105px 20px;background:#e8e7d4}
.ce2-olive-garden .og-rsvp-notebook{background:repeating-linear-gradient(to bottom,#fffefa 0,#fffefa 34px,#d5ddd4 35px);border-left:20px solid #759174;border-radius:12px 2px 2px 12px;max-width:730px;margin:auto;padding:65px 42px;text-align:center;box-shadow:12px 15px 22px #23372c33}
.ce2-olive-garden .og-rsvp h2{margin:23px auto}
.ce2-olive-garden .og-rsvp-form button{background:#526c4d}
.ce2-olive-garden .og-footer{padding:90px 24px;background:#2d4b34;color:#f4eee0;text-align:center}
.ce2-olive-garden .og-footer span{font:700 10px 'DM Sans',sans-serif;letter-spacing:.2em}.ce2-olive-garden .og-footer h2{margin:22px 0}
.ce2-olive-garden .og-footer h2 em{font:400 44px 'Caveat',cursive}
.ce2-olive-garden .og-footer a{display:block;margin-top:25px;font:700 10px 'DM Sans',sans-serif;letter-spacing:.15em}
.ce2-olive-garden .og-intro{background:radial-gradient(circle,#536947,#1d2f21);perspective:1400px}
.ce2-olive-garden .og-book-shadow{perspective:1400px;filter:drop-shadow(0 25px 30px #0008)}
.ce2-olive-garden .og-book-trigger{position:relative;width:min(340px,78vw);height:min(475px,65vh);border:0;background:transparent;transform-style:preserve-3d;transform:rotateX(3deg) rotateY(-7deg);transition:transform 1.6s}
.ce2-olive-garden .og-book-back,.ce2-olive-garden .og-book-pages,.ce2-olive-garden .og-book-cover,.ce2-olive-garden .og-book-first-page{position:absolute;inset:0;backface-visibility:hidden}
.ce2-olive-garden .og-book-back{background:#413b2a;border-radius:4px 12px 12px 4px;transform:translateZ(-16px)}
.ce2-olive-garden .og-book-pages{background:repeating-linear-gradient(90deg,#d8d3c5,#fff9ed 3px,#d1c8ba 6px);transform:translateZ(-6px);border:10px solid #eee9d9;border-left:20px solid #322c1f;border-radius:4px 12px 12px 4px}
.ce2-olive-garden .og-book-cover{background:linear-gradient(145deg,#768360,#3b513c);transform-origin:left center;transform:translateZ(4px);transition:transform 1.65s cubic-bezier(.22,.8,.25,1);border-left:18px solid #2d3b2d;box-shadow:inset 0 0 0 9px #e0d8bc36,inset 0 0 0 12px #fcf3d03b;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:18px;text-align:center;gap:28px;color:#f8f0d2}
.ce2-olive-garden .og-book-cover>span:first-child{font:700 10px 'DM Sans',sans-serif;letter-spacing:.22em}
.ce2-olive-garden .og-book-cover strong{font:400 37px/1.15 'DM Serif Display',serif}
.ce2-olive-garden .og-book-cover strong i{font:400 37px 'Caveat',cursive}
.ce2-olive-garden .og-book-cover small{font:600 9px 'DM Sans',sans-serif;letter-spacing:.18em}
.ce2-olive-garden .og-book-flower{font-size:55px;color:#e4bbb7}
.ce2-olive-garden .og-book-first-page{background:#fff6df;display:grid;place-content:center;gap:12px;text-align:center;color:var(--og)}
.ce2-olive-garden .og-book-first-page span{font:700 11px 'DM Sans',sans-serif;letter-spacing:.2em}
.ce2-olive-garden .og-book-first-page strong{font:400 30px 'DM Serif Display',serif}
.ce2-olive-garden .og-intro.is-opening .og-book-cover{transform:rotateY(-175deg) translateZ(4px)}
.ce2-olive-garden .og-intro.is-opening .og-book-trigger{transform:translateX(22%) rotateY(0)}
.ce2-olive-garden .ce2-animated{opacity:0;transform:scale(.94) rotate(-1.4deg)}
.ce2-olive-garden .ce2-animated.ce2-in-view{opacity:1;transform:scale(1) rotate(0)}
@media(max-width:800px){.ce2-olive-garden .og-cover{grid-template-columns:1fr;padding:95px 20px 55px}.ce2-olive-garden .og-cover-photo{max-width:350px;margin:auto}.ce2-olive-garden .og-cover-right{width:min(100%,520px);margin:auto;min-height:460px}.ce2-olive-garden .og-story-layout,.ce2-olive-garden .og-venue,.ce2-olive-garden .og-calendar{grid-template-columns:1fr}.ce2-olive-garden .og-calendar-right{min-height:440px}}
@media(max-width:570px){.ce2-olive-garden .og-notebook{padding:45px 20px 60px}.ce2-olive-garden .og-pressed{width:100px;height:155px;opacity:.35}.ce2-olive-garden .og-memory-row{gap:5px;margin:45px auto}.ce2-olive-garden .og-memory{padding:6px 6px 34px}.ce2-olive-garden .og-timeline-list>div{grid-template-columns:22px 100px 1fr;gap:9px}.ce2-olive-garden .og-people-grid{grid-template-columns:1fr}.ce2-olive-garden .og-scrapbook-grid{gap:10px}.ce2-olive-garden .og-scrapbook-photo{border-width:5px}.ce2-olive-garden .og-rsvp-notebook{padding:48px 18px;border-left-width:9px}}
</style>