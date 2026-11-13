<style>
.ce2-destination-ticket{--dt-navy:#10283f;--dt-cream:#f9f4e6;--dt-blue:#d6e2e6;background:var(--dt-cream);color:var(--dt-navy);font:400 18px/1.6 'Libre Baskerville',Georgia,serif}
.ce2-destination-ticket h2{font:400 clamp(44px,6vw,82px)/1.12 'Libre Baskerville',serif;letter-spacing:-.07em}
.ce2-destination-ticket h3{font:400 clamp(28px,4vw,42px)/1.16 'Libre Baskerville',serif}
.ce2-destination-ticket .dt-section-number,.ce2-destination-ticket .dt-nav,.ce2-destination-ticket .dt-ticket-head,.ce2-destination-ticket .dt-ticket-details,.ce2-destination-ticket .dt-next{font:700 10px/1.6 'Space Mono',monospace;letter-spacing:.1em}
.ce2-destination-ticket .dt-nav{position:absolute;z-index:10;top:0;left:0;right:0;display:flex;justify-content:space-between;gap:20px;align-items:center;padding:20px clamp(20px,4vw,85px);color:#fdfaf2}
.ce2-destination-ticket .dt-nav a{text-decoration:none}
.ce2-destination-ticket .dt-nav a span{font-size:23px}
.ce2-destination-ticket .dt-pass{position:relative;min-height:100svh;padding:100px clamp(20px,5vw,90px) 40px;display:grid;grid-template-columns:1fr 1fr;gap:30px 45px;align-items:center;background:linear-gradient(125deg,#112f49 10%,#1a3f61 65%,#071b32)}
.ce2-destination-ticket .dt-departures{grid-column:1/-1;border-top:1px solid #d6dfdf85;border-bottom:1px solid #d6dfdf85;display:flex;justify-content:space-between;padding:20px 0;gap:30px;color:#fff8e8}
.ce2-destination-ticket .dt-departures>div{display:grid;grid-template-columns:auto auto;align-items:center;gap:5px 12px}
.ce2-destination-ticket .dt-departures span{font:700 10px 'Space Mono',monospace;letter-spacing:.15em}
.ce2-destination-ticket .dt-departures strong{font:700 clamp(23px,4vw,45px) 'Space Mono',monospace;grid-column:1/-1;letter-spacing:.09em}
.ce2-destination-ticket .dt-departures small{font:500 10px 'Space Mono',monospace;color:#b8d0d9}
.ce2-destination-ticket .dt-passport{background:#faf7ef;color:var(--dt-navy);padding:25px 27px 0;box-shadow:15px 15px 0 #03162691;min-width:0;position:relative}
.ce2-destination-ticket .dt-passport:before,.ce2-destination-ticket .dt-passport:after{content:'';position:absolute;top:58%;width:20px;height:20px;border-radius:50%;background:var(--dt-navy)}
.ce2-destination-ticket .dt-passport:before{left:-10px}.ce2-destination-ticket .dt-passport:after{right:-10px}
.ce2-destination-ticket .dt-ticket-head{display:flex;gap:14px;justify-content:space-between;border-bottom:2px dashed #adb4b3;padding:0 0 19px}
.ce2-destination-ticket .dt-route-icon{text-align:center;font-size:45px;margin:27px auto 7px}
.ce2-destination-ticket .dt-route-icon span{font-size:12px;letter-spacing:.3em}
.ce2-destination-ticket .dt-pass h1{font:400 clamp(44px,5.4vw,92px)/.95 'Libre Baskerville',serif;letter-spacing:-.07em;display:flex;flex-direction:column;align-items:center;text-align:center}
.ce2-destination-ticket .dt-pass h1 em{font:400 .65em 'Allura',cursive}
.ce2-destination-ticket .dt-ticket-details{border-top:1px solid #c9c5bb;margin-top:26px;padding:18px 0 23px;display:grid;grid-template-columns:1fr 1fr;gap:12px}
.ce2-destination-ticket .dt-ticket-details>div{display:flex;flex-direction:column}.ce2-destination-ticket .dt-ticket-details>div:last-child{grid-column:1/-1}
.ce2-destination-ticket .dt-ticket-details small{font-size:9px;color:#63707d}.ce2-destination-ticket .dt-ticket-details strong{font-size:12px;letter-spacing:0}
.ce2-destination-ticket .dt-ticket-tear{border-top:2px dashed #87949c;margin:0 -27px;padding:17px 25px;background:#efece4;display:flex;justify-content:space-between;gap:10px;font:700 9px 'Space Mono',monospace}
.ce2-destination-ticket .dt-hero-photo-wrap{position:relative;height:100%;min-height:480px;display:grid;align-items:center}
.ce2-destination-ticket .dt-hero-photo{aspect-ratio:4/5;border-radius:10px;border:9px solid #e9e2d3;box-shadow:13px 19px 0 #0316268e;transform:rotate(3deg)}
.ce2-destination-ticket .dt-photo-badge{position:absolute;bottom:7%;right:-2%;background:#f6ede0;color:#172d41;padding:15px 19px;transform:rotate(-7deg);font:700 10px 'Space Mono',monospace;letter-spacing:.1em;box-shadow:0 7px 14px #0005}
.ce2-destination-ticket .dt-next{grid-column:1/-1;color:#faf4e8;text-align:center;text-decoration:none;border-bottom:1px solid #faf4e88a;padding:11px 0;width:fit-content;margin:20px auto 0}
.ce2-destination-ticket .dt-journey{padding:110px clamp(23px,6vw,100px);background:#f7f4eb;position:relative}
.ce2-destination-ticket .dt-journey-title{max-width:900px;margin:25px 0 45px}
.ce2-destination-ticket .dt-journey-title h2{max-width:800px}.ce2-destination-ticket .dt-journey-title p{font-size:22px;max-width:640px;margin-top:22px}
.ce2-destination-ticket .dt-boarding-stamps{display:flex;gap:17px;flex-wrap:wrap;margin:40px auto}
.ce2-destination-ticket .dt-boarding-stamps>span{display:grid;place-items:center;width:110px;height:110px;border-radius:50%;border:3px double var(--dt-navy);font:700 11px/1.1 'Space Mono',monospace;transform:rotate(-13deg);opacity:.55;text-align:center}
.ce2-destination-ticket .dt-boarding-stamps>span:nth-child(2){transform:rotate(10deg)}
.ce2-destination-ticket .dt-journey-photos{max-width:1000px;margin:auto;display:grid;grid-template-columns:1fr 1fr;gap:32px}
.ce2-destination-ticket .dt-memory-photo{aspect-ratio:4/3;border:8px solid #fff;box-shadow:6px 10px 17px #152e4133}
.ce2-destination-ticket .dt-memory-b{transform:translateY(40px)}
.ce2-destination-ticket .dt-story-note{margin:90px 0 0;padding:40px;max-width:650px;background:#e5e4dd;border-left:8px solid #29425a}
.ce2-destination-ticket .dt-story-note>span{font:700 10px 'Space Mono',monospace}.ce2-destination-ticket .dt-story-note h3{margin:18px 0}
.ce2-destination-ticket .dt-map-day{min-height:550px;display:grid;grid-template-columns:1fr 1fr;background:#d5e1e3}
.ce2-destination-ticket .dt-map-graphic{background-size:cover;background-position:center;filter:saturate(.7)}
.ce2-destination-ticket .dt-date-pass{background:#f8f6ef;padding:85px clamp(22px,5vw,75px);text-align:center;display:flex;flex-direction:column;justify-content:center}
.ce2-destination-ticket .dt-date-pass h2{margin:18px 0}.ce2-destination-ticket .dt-date-pass>strong{font:400 29px 'Libre Baskerville',serif}
.ce2-destination-ticket .dt-date-pass>p{margin:14px auto}
.ce2-destination-ticket .dt-calendar{max-width:340px;margin:24px auto;width:100%}
.ce2-destination-ticket .ce2-calendar-grid .ce2-calendar-selected{background:var(--dt-navy);color:var(--dt-navy)}
.ce2-destination-ticket .dt-date-route{border-top:2px dashed #a1aab0;display:grid;grid-template-columns:1fr 1fr;gap:15px;padding-top:19px;margin:17px auto 0;max-width:370px;width:100%}
.ce2-destination-ticket .dt-date-route small{font:700 10px 'Space Mono',monospace}.ce2-destination-ticket .dt-date-route p{font-size:13px}
.ce2-destination-ticket .dt-destination{padding:110px clamp(25px,6vw,100px);background:#f5f2eb}
.ce2-destination-ticket .dt-destination>h2{max-width:820px;margin:18px 0 65px}
.ce2-destination-ticket .dt-destination-card{max-width:1100px;margin:40px auto;display:grid;grid-template-columns:1.1fr .9fr;align-items:center;gap:50px;border-top:1px solid #9eaaad;padding-top:35px}
.ce2-destination-ticket .dt-venue-photo{aspect-ratio:4/3}
.ce2-destination-ticket .dt-destination-card>div{padding:25px 20px}
.ce2-destination-ticket .dt-destination-card>div span{font:700 11px 'Space Mono',monospace;letter-spacing:.13em}
.ce2-destination-ticket .dt-destination-card h3{margin:22px 0}.ce2-destination-ticket .dt-destination-reverse .dt-venue-photo{order:2}
.ce2-destination-ticket .dt-ceremony{background:#d3e0e4;text-align:center;padding:75px 20px}.ce2-destination-ticket .dt-ceremony h2{margin:22px auto}
.ce2-destination-ticket .dt-itinerary{background:#122d46;color:#fff8e8;padding:115px 25px;text-align:center}
.ce2-destination-ticket .dt-itinerary h2{margin:20px auto 60px}
.ce2-destination-ticket .dt-flight-path{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0;max-width:1100px;margin:auto;position:relative}
.ce2-destination-ticket .dt-flight-path:before{content:'';position:absolute;top:29px;left:9%;right:9%;border-top:2px dashed #fff8e9;opacity:.5}
.ce2-destination-ticket .dt-flight-stop{display:flex;flex-direction:column;align-items:center;gap:14px;padding:5px;z-index:1}
.ce2-destination-ticket .dt-flight-dot{background:#e5e8e5;color:#132d42;display:grid;place-items:center;width:52px;height:52px;border-radius:50%;font-size:21px}
.ce2-destination-ticket .dt-flight-stop strong{font:700 clamp(16px,2vw,27px) 'Space Mono',monospace}
.ce2-destination-ticket .dt-flight-stop p{font-size:16px}
.ce2-destination-ticket .dt-program-extra{white-space:pre-line;margin:45px auto 0}
.ce2-destination-ticket .dt-crew{background:#e8e7df;padding:105px 25px;text-align:center}
.ce2-destination-ticket .dt-crew h2{margin:19px auto 47px}
.ce2-destination-ticket .dt-crew-manifest{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));max-width:1100px;margin:auto;border-top:2px solid var(--dt-navy);border-bottom:2px solid var(--dt-navy)}
.ce2-destination-ticket .dt-crew-manifest>div{padding:40px 18px;border-right:1px solid #acb4b6}
.ce2-destination-ticket .dt-crew-manifest>div:last-child{border:0}
.ce2-destination-ticket .dt-crew-manifest span{font:700 10px 'Space Mono',monospace}.ce2-destination-ticket .dt-crew-manifest h3{margin:20px auto}
.ce2-destination-ticket .dt-crew-manifest p{white-space:pre-line}
.ce2-destination-ticket .dt-photo-diary{background:#f6f3ea;padding:110px 25px}
.ce2-destination-ticket .dt-photo-diary-title{text-align:center}.ce2-destination-ticket .dt-photo-diary-title h2{margin:20px auto 55px}
.ce2-destination-ticket .dt-postcards{display:flex;align-items:center;justify-content:center;gap:15px;max-width:1160px;margin:auto}
.ce2-destination-ticket .dt-postcard{width:33%;aspect-ratio:3/4;border:9px solid #fff;background:#fff;overflow:visible;box-shadow:0 8px 20px #0002;transform:rotate(-5deg)}
.ce2-destination-ticket .dt-postcard:nth-child(2){transform:translateY(39px) rotate(4deg)}
.ce2-destination-ticket .dt-postcard:nth-child(3){transform:rotate(-1deg)}
.ce2-destination-ticket .dt-postcard figcaption{position:absolute;left:8px;bottom:5px;background:#fff;padding:3px 7px;font:700 10px 'Space Mono',monospace}
.ce2-destination-ticket .dt-photo-diary>p{text-align:center;max-width:730px;margin:100px auto 0;font:italic 27px 'Libre Baskerville',serif}
.ce2-destination-ticket .dt-dress{padding:110px 23px;background:#12344f}
.ce2-destination-ticket .dt-dress-card{max-width:780px;margin:auto;background:#fbf6e9;padding:70px clamp(20px,5vw,75px);border:10px solid #eee6d5;text-align:center;box-shadow:0 20px 45px #0007}
.ce2-destination-ticket .dt-dress h2{margin:21px 0}.ce2-destination-ticket .dt-dress p{margin:13px auto}
.ce2-destination-ticket .dt-dress h3{margin:35px auto 15px}
.ce2-destination-ticket .dt-dress-colors{display:flex;justify-content:center;gap:13px;margin:27px auto 45px}
.ce2-destination-ticket .dt-dress-colors i{width:40px;height:40px;border-radius:50%;background:#dad1be}
.ce2-destination-ticket .dt-dress-colors i:nth-child(2){background:#a2a69f}.ce2-destination-ticket .dt-dress-colors i:nth-child(3){background:#19344f}.ce2-destination-ticket .dt-dress-colors i:nth-child(4){background:#b7a99a}.ce2-destination-ticket .dt-dress-colors i:nth-child(5){background:#191919}
.ce2-destination-ticket .dt-rsvp{display:grid;grid-template-columns:.8fr 1.2fr;background:#e6edf0;padding:100px clamp(22px,5vw,95px);gap:40px;align-items:center}
.ce2-destination-ticket .dt-rsvp-heading>span{font:700 10px 'Space Mono',monospace}
.ce2-destination-ticket .dt-rsvp-heading h2{margin:20px auto}
.ce2-destination-ticket .dt-rsvp-ticket{background:#fdf8eb;box-shadow:13px 13px 0 #b2c8d1;padding:25px;min-width:0}
.ce2-destination-ticket .dt-rsvp-ticket-head{display:flex;justify-content:space-between;gap:14px;border-bottom:2px dashed #98aeb1;padding:4px 0 20px;font:700 10px 'Space Mono',monospace}
.ce2-destination-ticket .dt-rsvp-form button{background:var(--dt-navy)}
.ce2-destination-ticket .dt-rsvp-barcode{height:42px;max-width:300px;margin:15px auto;background:repeating-linear-gradient(90deg,#13293d 0 2px,transparent 2px 5px,#13293d 5px 6px,transparent 6px 10px,#13293d 10px 13px,transparent 13px 16px)}
.ce2-destination-ticket .dt-footer{background:#091e33;color:#fff8e9;text-align:center;padding:100px 24px}
.ce2-destination-ticket .dt-footer span:first-child{font:700 10px 'Space Mono',monospace;letter-spacing:.13em}
.ce2-destination-ticket .dt-footer h2{margin:21px 0}
.ce2-destination-ticket .dt-footer a{display:inline-block;margin-top:30px;font:700 10px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro{background:linear-gradient(120deg,#0e2b43,#235473)}
.ce2-destination-ticket .dt-boarding-trigger{position:relative;display:grid;grid-template-columns:1.8fr .8fr;grid-template-rows:auto 1fr;width:min(800px,94vw);min-height:350px;border:0;padding:0;background:#f9f5e7;box-shadow:0 20px 44px #04182db8;color:#162d43;text-align:left;transition:transform 1.4s cubic-bezier(.2,.8,.2,1),filter 1.4s}
.ce2-destination-ticket .dt-intro-header{grid-column:1/-1;display:flex;align-items:center;justify-content:space-between;gap:10px;padding:20px 28px;border-bottom:2px dashed #9da9aa}
.ce2-destination-ticket .dt-intro-header small{font:700 10px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro-header strong{font:700 22px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro-header em{font-size:29px}
.ce2-destination-ticket .dt-intro-body{display:grid;align-content:center;gap:16px;padding:35px}
.ce2-destination-ticket .dt-intro-body small{font:700 11px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro-body strong{font:400 clamp(25px,4vw,47px) 'Libre Baskerville',serif}
.ce2-destination-ticket .dt-intro-body>span{font:700 12px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro-stub{border-left:2px dashed #9da9aa;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:15px;padding:20px;position:relative;background:#e3e3dd;transition:transform 1s cubic-bezier(.2,.8,.2,1),opacity 1s;z-index:2}
.ce2-destination-ticket .dt-intro-stub:before,.ce2-destination-ticket .dt-intro-stub:after{content:'';position:absolute;left:-13px;width:24px;height:24px;background:#17435e;border-radius:50%}
.ce2-destination-ticket .dt-intro-stub:before{top:-13px}.ce2-destination-ticket .dt-intro-stub:after{bottom:-13px}
.ce2-destination-ticket .dt-intro-stub>span,.ce2-destination-ticket .dt-intro-stub>strong{font:700 11px 'Space Mono',monospace}
.ce2-destination-ticket .dt-intro-code{width:78%;height:62px;background:repeating-linear-gradient(90deg,#152d42 0 2px,transparent 2px 5px,#152d42 5px 7px,transparent 7px 12px,#152d42 12px 15px,transparent 15px 17px)}
.ce2-destination-ticket .dt-takeoff-trail{position:absolute;left:10%;bottom:5%;font-size:70px;color:#fff;opacity:0;transition:transform 1.6s ease,opacity .3s}
.ce2-destination-ticket .dt-intro.is-opening .dt-intro-stub{transform:translate(120%,40%) rotate(20deg);opacity:0}
.ce2-destination-ticket .dt-intro.is-opening .dt-boarding-trigger{transform:translate(-18%,-25%) rotate(-10deg) scale(1.25);filter:blur(3px)}
.ce2-destination-ticket .dt-intro.is-opening .dt-takeoff-trail{opacity:1;transform:translate(75vw,-75vh) rotate(-12deg)}
.ce2-destination-ticket .ce2-animated{opacity:0;transform:translateX(-55px)}
.ce2-destination-ticket .ce2-animated.ce2-in-view{opacity:1;transform:none}
@media(max-width:850px){.ce2-destination-ticket .dt-pass{grid-template-columns:1fr;padding:100px 20px 45px}.ce2-destination-ticket .dt-hero-photo-wrap{min-height:0;max-width:450px;width:100%;margin:auto}.ce2-destination-ticket .dt-hero-photo{height:330px}.ce2-destination-ticket .dt-map-day,.ce2-destination-ticket .dt-rsvp{grid-template-columns:1fr}.ce2-destination-ticket .dt-map-graphic{min-height:350px}.ce2-destination-ticket .dt-date-pass{padding:60px 20px}.ce2-destination-ticket .dt-destination-card{gap:25px}.ce2-destination-ticket .dt-crew-manifest{grid-template-columns:1fr}.ce2-destination-ticket .dt-crew-manifest>div{border-right:0;border-bottom:1px solid #b7c0c3}.ce2-destination-ticket .dt-crew-manifest>div:last-child{border-bottom:0}}
@media(max-width:600px){.ce2-destination-ticket .dt-nav>span{display:none}.ce2-destination-ticket .dt-departures{gap:12px}.ce2-destination-ticket .dt-passport{padding:15px 16px 0}.ce2-destination-ticket .dt-ticket-tear{margin:0 -16px}.ce2-destination-ticket .dt-destination-card,.ce2-destination-ticket .dt-destination-reverse{grid-template-columns:1fr}.ce2-destination-ticket .dt-destination-reverse .dt-venue-photo{order:0}.ce2-destination-ticket .dt-flight-path{grid-template-columns:1fr;gap:22px}.ce2-destination-ticket .dt-flight-path:before{top:25px;bottom:25px;left:26px;right:auto;height:auto;width:1px;border-top:0;border-left:2px dashed #fff8e9}.ce2-destination-ticket .dt-flight-stop{flex-direction:row;text-align:left;gap:17px}.ce2-destination-ticket .dt-flight-stop strong{min-width:100px}.ce2-destination-ticket .dt-flight-dot{flex:none}.ce2-destination-ticket .dt-postcards{gap:7px}.ce2-destination-ticket .dt-postcard{border-width:4px}.ce2-destination-ticket .dt-photo-diary>p{margin-top:65px}.ce2-destination-ticket .dt-intro-header{padding:14px;flex-wrap:wrap}.ce2-destination-ticket .dt-intro-body{padding:18px}.ce2-destination-ticket .dt-boarding-trigger{grid-template-columns:1fr .65fr;min-height:280px}.ce2-destination-ticket .dt-intro-stub{padding:5px}.ce2-destination-ticket .dt-intro-stub>strong{font-size:9px}.ce2-destination-ticket .dt-intro-code{height:40px}}
</style>