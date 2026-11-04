<style>
/* The public invitation is a real responsive wedding website.
   The builder renders the same markup in a narrower preview container. */
.wedding-invite {
    --wedding-ink:#2f372f;--wedding-muted:#726f67;--wedding-sage:#667462;
    --wedding-ivory:#fbf8f1;--wedding-cream:#f3efe5;--wedding-line:#dcd7c9;
    width:100%;min-width:0;margin:0;overflow:clip;color:var(--wedding-ink);
    background:var(--wedding-ivory);font-family:'DM Sans',Arial,sans-serif;
    font-size:15px;line-height:1.7;text-align:left;
}
.wedding-invite [hidden]{display:none!important}
.wedding-invite *{box-sizing:border-box}
.wedding-invite .invite-site-nav{
    position:sticky;top:0;z-index:12;display:flex;align-items:center;justify-content:space-between;
    padding:14px clamp(18px,5vw,75px);gap:15px;min-height:65px;
    background:#fbf9f3f2;border-bottom:1px solid var(--wedding-line);
    backdrop-filter:blur(12px);
}
.wedding-invite .invite-logo{font:italic 25px 'DM Serif Display',Georgia,serif;color:#4e624f;white-space:nowrap;letter-spacing:-.5px}
.wedding-invite .invite-logo-and{color:#b29a77;font-style:normal}
.wedding-invite .invite-site-links{display:flex;gap:clamp(10px,2vw,27px);align-items:center;overflow-x:auto;scrollbar-width:none}
.wedding-invite .invite-site-links::-webkit-scrollbar{display:none}
.wedding-invite .invite-site-links a{font:600 11px 'DM Sans',Arial,sans-serif;white-space:nowrap;color:#716e64;letter-spacing:.02em}
.wedding-invite .invite-site-links a:hover{color:#354c3c}
.wedding-invite .invite-cover{
    position:relative;display:flex;align-items:center;justify-content:center;isolation:isolate;
    min-height:max(680px,calc(100svh - 65px));padding:clamp(65px,10vw,142px) 24px;
    border:0;overflow:hidden;background:
    radial-gradient(ellipse at 0% 0%,#e6e5d5 0,transparent 43%),
    radial-gradient(ellipse at 90% 100%,#e3e6da 0,transparent 49%),
    #faf7ef;text-align:center;
}
.wedding-invite .invite-cover::before{
    content:'';position:absolute;z-index:-1;inset:clamp(14px,3vw,35px);
    border:1px solid #b9bda8;pointer-events:none;opacity:.65;
}
.wedding-invite .invite-hero-flourish{
    position:absolute;z-index:-1;font:normal clamp(190px,29vw,500px)/1 Georgia,serif;
    color:#94a88c;opacity:.15;pointer-events:none;
}
.wedding-invite .invite-hero-flourish-left{left:-9%;top:-22%;transform:rotate(-24deg)}
.wedding-invite .invite-hero-flourish-right{right:-12%;bottom:-32%;transform:rotate(163deg)}
.wedding-invite .invite-hero-content{position:relative;max-width:850px;width:100%;margin:0 auto}
.wedding-invite .invite-eyebrow{font:700 10px/1.6 'DM Sans',Arial,sans-serif;letter-spacing:.25em;color:#687d67;text-transform:uppercase}
.wedding-invite .invite-small{font:600 11px/1.7 'DM Sans',Arial,sans-serif;letter-spacing:.18em;color:#7a8374}
.wedding-invite .invite-divider{width:84px;height:1px;background:#b9a583;margin:25px auto}
.wedding-invite .invite-couple-names{
    display:block;color:#3b5848;font:italic 400 clamp(64px,9.6vw,142px)/.95 'DM Serif Display',Georgia,serif;
    letter-spacing:-.03em;margin:25px 0;
}
.wedding-invite .invite-couple-names span{display:block;overflow-wrap:anywhere}
.wedding-invite .invite-couple-names i{display:block;font:italic 400 .43em/1.3 'DM Serif Display',Georgia,serif;color:#a4a17c}
.wedding-invite .invite-message{font:italic clamp(15px,2vw,20px)/1.9 Georgia,serif;max-width:610px;margin:22px auto;color:#697367}
.wedding-invite .invite-date{font:400 clamp(24px,3.5vw,38px)/1.4 'DM Serif Display',Georgia,serif;margin:12px 0 3px;color:#556d56}
.wedding-invite .invite-location{font:600 11px/1.8 'DM Sans',Arial,sans-serif;letter-spacing:.19em;color:#6c7066;text-transform:uppercase}
.wedding-invite .invite-scroll-link{display:inline-flex;align-items:center;gap:16px;margin:35px auto 0;
    font:600 11px 'DM Sans',Arial,sans-serif;text-transform:uppercase;letter-spacing:.12em;
    border-bottom:1px solid #798d74;padding:0 0 10px;color:#4e6553}
.wedding-invite .invite-scroll-link:hover{color:#273d2a;border-color:#273d2a}
.wedding-invite .invite-hero-extra{max-width:630px;margin:35px auto 0;text-align:center}
.wedding-invite .invite-section{background:#fdfbf7;padding:clamp(80px,11vw,170px) clamp(20px,5vw,60px);border-top:0;scroll-margin-top:65px}
.wedding-invite .invite-tinted{background:#e9ecdf}
.wedding-invite .invite-section-inner{width:min(1060px,100%);margin:0 auto;display:grid;grid-template-columns:minmax(0,.8fr) minmax(0,1fr);gap:clamp(35px,7vw,110px);align-items:start}
.wedding-invite .invite-section-heading{position:relative}
.wedding-invite .invite-section-heading h2,.wedding-invite .invite-centered-section h2{
    font:400 clamp(43px,5.9vw,78px)/1.08 'DM Serif Display',Georgia,serif;
    margin:19px 0 18px;color:#466047;letter-spacing:-.015em;
}
.wedding-invite .invite-section-heading p,.wedding-invite .invite-section-lead{
    max-width:590px;font:italic clamp(15px,1.5vw,19px)/1.85 Georgia,serif;
    color:#687566;margin:15px 0 0;
}
.wedding-invite .invite-content-column{border-left:1px solid #bcc7b8;padding-left:clamp(18px,3vw,44px)}
.wedding-invite .invite-detail-item{margin:0 0 48px}
.wedding-invite .invite-detail-item:last-child{margin-bottom:0}
.wedding-invite .invite-detail-number{display:block;color:#7b8776;font-size:10px;font-weight:700;letter-spacing:.18em;margin-bottom:17px}
.wedding-invite .invite-featured{font:400 clamp(27px,3vw,41px)/1.28 'DM Serif Display',Georgia,serif;margin:0 0 15px;color:#344f3a}
.wedding-invite .invite-muted{color:#70746c;font:400 13px/1.85 'DM Sans',Arial,sans-serif}
.wedding-invite .invite-centered-section{max-width:980px;margin:0 auto;text-align:center}
.wedding-invite .invite-centered-section .invite-section-lead{margin:0 auto 46px}
.wedding-invite .invite-two-cols{display:grid;grid-template-columns:1fr 1fr;gap:18px 35px;padding:12px 0;margin:30px 0 0;text-align:center}
.wedding-invite .invite-two-cols>div{padding:23px 15px;border-top:1px solid #cbd4c6}
.wedding-invite .invite-section h3,.wedding-invite .invite-more-details h3,.wedding-invite .invite-hero-extra h3{
    font:700 11px/1.65 'DM Sans',Arial,sans-serif;text-transform:uppercase;letter-spacing:.17em;
    margin:0 0 13px;color:#728470;
}
.wedding-invite .invite-two-cols p{font:400 18px/1.9 Georgia,serif;margin:4px 0;color:#536451}
.wedding-invite .invite-program-line{width:min(560px,100%);margin:25px auto;padding:30px 25px;
    border:1px solid #bec7b4;background:#fffdf8;color:#475d4c;
    font:400 clamp(15px,1.8vw,21px)/2.2 Georgia,serif;text-align:center}
.wedding-invite .invite-guest-note{display:flex;flex-direction:column;gap:6px;align-items:center;
    padding:30px;border:1px solid #bdc8b8;width:min(480px,100%);margin:30px auto;
}
.wedding-invite .invite-guest-note span{font-size:11px;font-weight:700;letter-spacing:.13em;text-transform:uppercase;color:#718273}
.wedding-invite .invite-guest-note strong{font:26px 'DM Serif Display',Georgia,serif;color:#526c53}
.wedding-invite .invite-gift-note{max-width:650px;margin:34px auto 0;padding:28px 25px;border-top:1px solid #bac7b8}
.wedding-invite .invite-gift-note p{font:italic 18px/1.8 Georgia,serif;color:#526450}
.wedding-invite .invite-more-details{display:grid;gap:16px;margin-top:28px}
.wedding-invite .invite-extra{padding:14px 0;border-top:1px solid #c9d3c5;text-align:inherit}
.wedding-invite .invite-extra h3{margin-bottom:6px}
.wedding-invite .invite-extra p{white-space:pre-line;margin:0;color:#5e6b5f;font:400 15px/1.85 Georgia,serif;overflow-wrap:anywhere}
.wedding-invite .pre-line{white-space:pre-line}
.wedding-invite .invite-footer{text-align:center;background:#3e5544;padding:clamp(65px,8vw,110px) 20px;color:#f5f0e7}
.wedding-invite .invite-footer .invite-eyebrow{color:#d4d9ca}
.wedding-invite .invite-footer-names{font:italic clamp(45px,6.5vw,82px)/1.2 'DM Serif Display',Georgia,serif;margin:20px 0;color:#fff}
.wedding-invite .invite-footer-names i{margin:0 12px;color:#d6d3ac}
.wedding-invite .invite-footer small{display:block;color:#c8d3c2;font-size:10px;letter-spacing:.23em;font-weight:700}
.wedding-invite .invite-top-link{display:inline-block;font-size:11px;color:#ecebdc;margin-top:35px;border-bottom:1px solid #aebca6;padding-bottom:5px}

/* Compact website preview: the same content but responsive within its preview canvas. */
.preview-canvas{container:invite-preview / inline-size}
@container invite-preview (max-width:560px){
    .wedding-invite .invite-site-nav{padding:12px 16px;flex-wrap:wrap;gap:9px;min-height:0}
    .wedding-invite .invite-logo{font-size:18px}
    .wedding-invite .invite-site-links{width:100%;gap:14px}
    .wedding-invite .invite-site-links a{font-size:9px}
    .wedding-invite .invite-cover{min-height:540px;padding:85px 24px}
    .wedding-invite .invite-couple-names{font-size:clamp(48px,12cqw,74px)}
    .wedding-invite .invite-hero-flourish{font-size:220px}
    .wedding-invite .invite-section{padding:55px 22px;scroll-margin-top:95px}
    .wedding-invite .invite-section-inner{grid-template-columns:1fr;gap:30px}
    .wedding-invite .invite-content-column{padding-left:18px}
    .wedding-invite .invite-section-heading h2,.wedding-invite .invite-centered-section h2{font-size:40px}
    .wedding-invite .invite-two-cols{grid-template-columns:1fr;gap:0}
    .wedding-invite .invite-two-cols>div{padding:18px 8px}
    .wedding-invite .invite-featured{font-size:30px}
}
@media(max-width:740px){
    .wedding-invite .invite-site-nav{padding:13px 19px;flex-wrap:wrap;gap:10px;min-height:0}
    .wedding-invite .invite-logo{font-size:22px}
    .wedding-invite .invite-site-links{width:100%;gap:19px;padding-bottom:3px}
    .wedding-invite .invite-site-links a{font-size:10px}
    .wedding-invite .invite-cover{min-height:calc(100svh - 105px);padding:82px 23px}
    .wedding-invite .invite-couple-names{font-size:clamp(58px,12vw,85px)}
    .wedding-invite .invite-hero-flourish{font-size:220px}
    .wedding-invite .invite-section{padding:85px 24px;scroll-margin-top:105px}
    .wedding-invite .invite-section-inner{grid-template-columns:1fr;gap:30px}
    .wedding-invite .invite-content-column{padding-left:22px}
    .wedding-invite .invite-section-heading h2,.wedding-invite .invite-centered-section h2{font-size:47px}
    .wedding-invite .invite-two-cols{grid-template-columns:1fr;gap:0}
    .wedding-invite .invite-two-cols>div{padding:22px 12px}
    .wedding-invite .invite-footer-names{font-size:47px}
}
@media(prefers-reduced-motion:reduce){
    .wedding-invite *{scroll-behavior:auto!important}
}
</style>