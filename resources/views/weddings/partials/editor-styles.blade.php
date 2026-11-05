<style>
/* The page never scrolls. Only the questions and the invitation preview do. */
.builder-app{display:flex;flex-direction:column;flex:1;min-height:0;overflow:hidden;background:#171417;color:#f4ede7}
.builder-app [hidden]{display:none!important}
.builder-utility{height:65px;flex:none;padding:0 23px;border-bottom:1px solid #393034;display:flex;align-items:center;justify-content:space-between;gap:15px}
.builder-title{display:flex;align-items:center;gap:17px;min-width:0}
.builder-title strong{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:14px;letter-spacing:.01em}
.builder-title small{display:block;color:#b6aaa6;font-size:11px}
.builder-back{color:#cbb7a8;font-size:13px;font-weight:700;white-space:nowrap}
.builder-back:hover{color:#fff}
.builder-utility-right{display:flex;gap:15px;align-items:center}
.draft-indicator{color:#c8b4a2;font-size:11px;display:flex;align-items:center;gap:7px}
.draft-indicator::before{content:"";width:7px;height:7px;background:#c39d65;border-radius:50%;display:block}
.draft-indicator[data-state="saved"]::before{background:#82b890}
.draft-indicator[data-state="unavailable"]::before{background:#d78c73}
.cancel-btn{border:1px solid #5e4449;background:transparent;color:#f1b8b8;border-radius:9px;padding:9px 13px;font-size:12px;font-weight:700;white-space:nowrap}
.cancel-btn:hover{background:#54262d;color:#fff}
.builder-mobile-switch{display:none;gap:4px;border:1px solid #554347;border-radius:9px;padding:3px}
.builder-mobile-switch button{border:0;background:transparent;color:#d4c1bf;border-radius:6px;padding:7px 12px;font-size:12px;font-weight:700}
.builder-mobile-switch button[aria-pressed=true]{background:#a32936;color:#fff}
.wizard-strip{height:63px;display:flex;align-items:center;gap:4px;flex:none;padding:0 23px;border-bottom:1px solid #352d2f;overflow-x:auto;scrollbar-width:none}
.wizard-strip::-webkit-scrollbar{display:none}
.wizard-step{display:flex;align-items:center;gap:10px;background:transparent;border:0;color:#a69a98;padding:10px 12px;border-radius:8px;white-space:nowrap;font-size:12px;font-weight:700}
.wizard-step .step-dot{width:27px;height:27px;display:grid;place-items:center;border:1px solid #6b5654;border-radius:50%;color:#c5aea4;font-size:11px}
.wizard-step.is-current{color:#fff;background:#302328}.wizard-step.is-current .step-dot{background:#ae2938;border-color:#ae2938;color:#fff}
.wizard-step.is-done{color:#d6bd9a}.wizard-step.is-done .step-dot{border-color:#b9955c;color:#dfbf82}
.wizard-step:disabled{cursor:not-allowed;opacity:.55}
.wizard-arrow{color:#746564;font-size:17px}
.builder-columns{display:grid;grid-template-columns:minmax(375px,.87fr) minmax(450px,1.13fr);gap:14px;padding:14px;flex:1;min-height:0;overflow:hidden}
.editor-pane,.preview-pane{min-width:0;min-height:0;overflow:hidden;border-radius:15px;display:flex;flex-direction:column}
.editor-pane{background:#fffcf8;color:#2a2022;border:1px solid #ddcfca}
.preview-pane{background:#242022;border:1px solid #49383a}
.editor-stage{display:none;flex:1;min-height:0;flex-direction:column}
.editor-stage.is-active{display:flex}
.stage-top{flex:none;padding:24px 28px 19px;border-bottom:1px solid #eee4df}
.stage-top h1,.stage-top h2{font-family:'DM Serif Display',Georgia,serif;font-size:31px;font-weight:400;margin:5px 0 9px;line-height:1.13;color:#211a1c}
.stage-top p{margin:0;color:#786b6c;font-size:12px;line-height:1.65}
.stage-kicker{font-size:10px;color:#a32936;letter-spacing:.16em;font-weight:800;text-transform:uppercase}
.stage-scroll{flex:1;min-height:0;overflow-y:auto;overscroll-behavior:contain;padding:23px 28px 28px;scrollbar-width:thin;scrollbar-color:#d1bab3 transparent}
.stage-footer{flex:none;display:flex;align-items:center;justify-content:space-between;gap:10px;border-top:1px solid #e9ded8;padding:15px 25px;background:#fffdf9}
.stage-footer .btn{min-height:42px}
.stage-footer p{font-size:11px;color:#8b7977;margin:0}
.editor-pane .btn-outline{border-color:#d3bec0}
.editor-pane .btn-outline:hover{background:#f9edf0}
.selector-intro{display:flex;gap:12px;border:1px solid #e9d4ca;padding:15px;border-radius:11px;background:#fff6f2;margin-bottom:17px}
.selector-intro .selector-icon{width:27px;height:27px;flex:none;display:grid;place-items:center;background:#a32936;color:#fff;border-radius:8px;font-size:14px}
.selector-intro strong{display:block;font-size:13px;margin-bottom:4px}.selector-intro p{font-size:11px;color:#7b6967;margin:0}
.section-choice-grid{display:grid;grid-template-columns:1fr 1fr;gap:11px}
.section-choice{border:1px solid #e5d8d5;border-radius:12px;padding:18px;display:block;position:relative;cursor:pointer;background:#fff;transition:background .15s,border-color .15s,box-shadow .15s}
.section-choice:has(input:checked){border-color:#b35560;background:#fff5f4;box-shadow:0 0 0 1px #e3afb2}
.section-choice:focus-within{outline:2px solid #ae5359;outline-offset:2px}
.section-choice[data-required=true]{border-color:#dbc5ae;background:#fbf6ec;cursor:default}
.section-choice .choice-top{display:flex;justify-content:space-between;align-items:start;gap:12px}
.section-choice .choice-icon{width:31px;height:31px;display:grid;place-items:center;border-radius:9px;background:#f4eeea;color:#ae303b;font-size:17px}
.section-choice input{width:18px;height:18px;accent-color:#a32936;margin:3px 0 0;flex:none}
.section-choice strong{display:block;margin:15px 0 4px;font-size:14px}
.section-choice small{display:block;color:#7f7272;line-height:1.6;font-size:11px}
.section-choice .always{display:block;color:#b09164;margin-top:8px;font-size:10px;font-weight:700}
.group-headline{padding:18px 26px 14px;border-bottom:1px solid #efe6e1;flex:none}
.group-count{font-size:10px;font-weight:700;color:#a32936;text-transform:uppercase;letter-spacing:.1em}
.group-headline h2{font-family:'DM Serif Display',serif;font-size:28px;margin:5px 0;color:#251d1f}
.group-headline p{color:#786e6d;font-size:11px;margin:5px 0 0}
.group-tabs{padding:11px 20px;border-bottom:1px solid #efe4df;display:flex;gap:7px;overflow-x:auto;flex:none;scrollbar-width:thin}
.group-tab{white-space:nowrap;padding:8px 13px;border-radius:18px;background:#f5efec;border:1px solid transparent;color:#756868;font-size:11px;font-weight:700}
.group-tab.is-current{background:#a32936;color:#fff}
.group-tab.is-complete:not(.is-current){border-color:#dac5a5;color:#7d6241}
.detail-scroll{padding:20px 26px 28px}
.question-group{display:none}.question-group.is-current{display:block}
.question-grid{display:grid;grid-template-columns:1fr 1fr;column-gap:14px;row-gap:1px}
.question-grid .field.full{grid-column:1/-1}
.editor-pane .field-label{font-size:11px;display:block;font-weight:700;color:#43383b;margin-bottom:6px}
.editor-pane input:not([type=checkbox]):not([type=radio]),.editor-pane textarea{border:1px solid #ddcfcb;border-radius:10px;background:#fff;padding:11px 12px;font:13px 'DM Sans',Arial,sans-serif;display:block;width:100%;color:#2a2022}
.editor-pane input:focus,.editor-pane textarea:focus{outline:0;border-color:#a32936;box-shadow:0 0 0 3px #a329361a}
.editor-pane textarea{resize:vertical;min-height:82px}
.editor-pane .field{margin-bottom:14px}
.editor-pane .required{color:#ab2936}
.editor-pane .optional-note{font-size:10px;color:#917f80;margin-top:5px}
.advanced-fields{display:none;grid-column:1/-1}
.question-group.show-advanced .advanced-fields{display:grid;grid-template-columns:1fr 1fr;column-gap:14px}
.expand-questions{border:1px dashed #c7a5a4;border-radius:10px;background:#fff9f7;color:#a32936;padding:12px;font-size:12px;font-weight:700;width:100%;margin:10px 0 5px}
.expand-questions:hover{background:#fff2ef}
.helper-text{color:#7a706e;font-size:10px;margin-top:4px}
.group-empty{padding:20px 0;font-size:13px;color:#776b6c}
.back-btn{border:1px solid #e3d5d1;border-radius:10px;padding:11px 15px;background:#fff;color:#685458;font-size:12px;font-weight:700}
.back-btn:hover{background:#f7eeee}
.review-list{padding:0;margin:0;list-style:none;display:grid;gap:10px}
.review-list li{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:12px 14px;border:1px solid #ece0db;border-radius:10px;font-size:12px}
.review-list li strong{font-size:12px;color:#2f2526}.review-list li span{color:#907b76;font-size:11px}
.plan-grid{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin-top:16px}
.plan-card{padding:20px 16px;border:1px solid #e2d5d0;border-radius:12px;background:#fff}
.plan-card.premium{background:#221b1e;border-color:#ae7b59;color:#f5eee8}
.plan-card h3{font-size:23px;margin:9px 0;font-family:'DM Serif Display',serif;font-weight:400}
.plan-card .plan-price{font:27px 'DM Serif Display',serif;color:#a32936}
.plan-card.premium .plan-price{color:#d1ac6c}
.plan-card ul{margin:14px 0 0;padding-left:18px;font-size:11px;line-height:1.95;color:#706565}
.plan-card.premium ul{color:#e1d2ca}
.plan-card .pill{background:#f4e1df;color:#9d3036}
.plan-card.premium .pill{background:#51402d;color:#efd6a6}
.launch-note{padding:14px;background:#fdf4e8;border:1px solid #ead3b9;color:#816040;font-size:11px;line-height:1.7;border-radius:10px;margin-top:16px}
.preview-top{flex:none;display:flex;align-items:center;justify-content:space-between;padding:13px 17px;gap:12px;flex-wrap:wrap;border-bottom:1px solid #413436;background:#211b1f}
.preview-top strong{font-size:13px;color:#fff}.preview-top small{display:block;font-size:10px;color:#bbaaab;margin-top:3px}
.preview-switch{display:flex;flex-wrap:wrap;gap:3px;border-radius:9px;background:#34282b;padding:4px}
.preview-switch button{border:0;background:transparent;border-radius:7px;padding:8px 11px;color:#e0cecb;font-size:10px;font-weight:700}
.preview-switch button[aria-selected=true]{background:#a32936;color:#fff}
.preview-scroll{flex:1;min-height:0;overflow:auto;overscroll-behavior:contain;padding:23px;background:radial-gradient(circle at 50% 10%,#3d3333,#251e21 72%);scrollbar-color:#6f5a56 transparent;scrollbar-width:thin}
.preview-canvas{max-width:550px;margin:0 auto;box-shadow:0 14px 45px #0b080a70;background:#fff}
.preview-bottom{flex:none;border-top:1px solid #47393c;padding:11px 17px;display:flex;justify-content:space-between;align-items:center;gap:10px;color:#d4c2be;font-size:10px}
.preview-dot{display:inline-block;width:7px;height:7px;background:#a4c89a;border-radius:50%;margin-right:7px}
.preview-locked{background:#f9f5ee;max-width:550px;min-height:370px;margin:0 auto;display:flex;align-items:center;justify-content:center;text-align:center;padding:37px;color:#443336}
.preview-locked .icon{color:#b69057;font-size:40px;display:block;margin-bottom:11px}
.preview-locked h3{font:30px 'DM Serif Display',serif;margin:8px 0;color:#2e2527}
.preview-locked p{color:#756a67;max-width:340px;font-size:12px;line-height:1.8}
.preview-locked .pill{background:#30272a;color:#f1d6a9}
.preview-comparison{display:none;max-width:550px;margin:0 auto 15px;grid-template-columns:1fr 1fr;gap:12px}
.preview-comparison.is-visible{display:grid}
.compare-block{border:1px solid #5d4b4c;border-radius:10px;background:#282124;padding:15px;color:#fff;min-width:0}
.compare-block.premium{border-color:#b0905c}
.compare-block strong{display:block;font:20px 'DM Serif Display',serif;margin:8px 0;overflow-wrap:anywhere}
.compare-block span{font-size:10px;color:#dfc9c2}
.compare-block .small-badge{font-size:9px;color:#ceac75;letter-spacing:.12em;font-weight:700}
.wedding-invite{color:#5c5247;background:#fcf8f0;text-align:center;font-family:Georgia,serif}
.wedding-invite [hidden]{display:none!important}
.invite-cover{min-height:520px;position:relative;padding:80px 30px 60px;border:1px solid #e1dacd;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden}
.ornament{position:absolute;font-size:130px;line-height:1;color:#b4c0a7;opacity:.6}.ornament-top{top:-55px;left:-30px;transform:rotate(-20deg)}.ornament-bottom{bottom:-55px;right:-30px;transform:rotate(145deg)}
.invite-eyebrow,.invite-small{font-family:'DM Sans',sans-serif;font-size:9px;letter-spacing:.19em;font-weight:600}.invite-divider{height:1px;width:78px;background:#c4b49c;margin:20px auto}
.invite-cover h1{font-family:'DM Serif Display',Georgia,serif;font-size:clamp(39px,4.4vw,64px);font-weight:400;line-height:1.15;color:#4b634d;margin:20px 0}.invite-cover h1 span{display:block}.invite-cover h1 i{display:block;font-size:.55em;font-weight:400}
.invite-message{font-style:italic;max-width:400px;line-height:1.8;font-size:13px}.invite-date{font-family:'DM Serif Display',Georgia,serif;font-size:23px;margin:0 0 10px}
.invite-section{padding:54px 30px;background:#fffdf8;border-top:1px solid #eae5d9}.invite-section h2{font-family:'DM Serif Display',Georgia,serif;font-size:34px;font-weight:400;color:#516b52;margin:14px 0 23px}.invite-section h3{font:600 10px 'DM Sans',sans-serif;letter-spacing:.14em;text-transform:uppercase;color:#66745f;margin:24px 0 11px}
.invite-section p{line-height:1.7;font-size:14px}.invite-tinted{background:#f0f1e9}.invite-two-cols{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-top:9px}.subtle{color:#888477;font-size:12px}.pre-line{white-space:pre-line}.invite-footer{padding:36px;font:italic 27px 'DM Serif Display',Georgia,serif}.invite-footer small{display:block;margin-top:13px;font:600 9px 'DM Sans',sans-serif;letter-spacing:.2em}
.wedding-invite .invite-extra[hidden]{display:none!important}
@media(max-width:1080px){
    .builder-columns{grid-template-columns:minmax(320px,.95fr) minmax(340px,1.05fr)}
    .question-grid{grid-template-columns:1fr}.question-grid .field.full{grid-column:auto}
    .question-group.show-advanced .advanced-fields{grid-template-columns:1fr}
}
@media(max-width:850px){
    .builder-columns{grid-template-columns:1fr;padding:9px;gap:0}
    .builder-mobile-switch{display:flex}
    .builder-app[data-mobile-view="edit"] .preview-pane{display:none}
    .builder-app[data-mobile-view="preview"] .editor-pane{display:none}
    .preview-top{gap:7px}
    .preview-scroll{padding:13px}
    .section-choice-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:560px){
    .builder-utility{padding:0 12px;height:54px}
    .builder-utility-right{gap:8px}
    .builder-title small,.draft-indicator{display:none}
    .builder-title{gap:8px}
    .builder-title strong{font-size:12px;max-width:118px}
    .builder-back{font-size:11px}
    .cancel-btn{font-size:11px;padding:7px 8px}
    .wizard-strip{height:54px;padding:0 6px}
    .wizard-step{font-size:10px;padding:8px 6px;gap:6px}
    .wizard-step .step-dot{width:23px;height:23px}
    .stage-top{padding:19px 19px 15px}
    .stage-top h1,.stage-top h2{font-size:26px}
    .stage-scroll{padding:15px 17px 22px}
    .stage-footer{padding:12px 14px}
    .section-choice-grid,.plan-grid{grid-template-columns:1fr}
    .section-choice{padding:14px}
    .section-choice strong{margin:9px 0 2px}
    .group-headline{padding:16px 18px 12px}
    .group-tabs{padding:9px 12px}
    .detail-scroll{padding:15px 17px 25px}
    .preview-comparison{grid-template-columns:1fr}
    .invite-cover{min-height:460px;padding:65px 20px}
    .invite-section{padding:42px 22px}
    .invite-two-cols{grid-template-columns:1fr}
}

/* Scrollbars remain discoverable, styled and keyboard-scrollable. */
.builder-app .wizard-strip{scrollbar-width:thin;scrollbar-color:#aa7b81 transparent}
.builder-app .wizard-strip::-webkit-scrollbar{display:block;height:6px}
.builder-app .stage-scroll,.builder-app .group-tabs{
    scrollbar-color:#b88788 transparent;scrollbar-gutter:stable
}
.builder-app .preview-scroll{scrollbar-color:#aa7b81 transparent;scrollbar-gutter:stable}
/* Editor controls reveal their exact position in the independently scrollable preview. */
.builder-app .preview-link-tip{display:flex;align-items:center;gap:8px;
    padding:8px 10px;margin-top:10px;border-radius:8px;
    background:#f5e6e3;border:1px solid #e6c5c2;
    font:600 11px/1.5 'DM Sans',sans-serif;color:#792837}
.builder-app .preview-link-tip i{font-size:12px;color:#922c3a}
.builder-app .preview-highlight-help{display:flex;align-items:center;gap:9px;
    min-height:33px;padding:7px 18px;background:#302428;
    border-bottom:1px solid #4d363e;color:#ebd0ba;
    font:600 11px/1.4 'DM Sans',sans-serif}
.builder-app .preview-highlight-help i{color:#edb96d}
.builder-app .preview-canvas .wwyt-preview-section-active{
    position:relative;z-index:2;
    outline:3px solid #efbd71!important;outline-offset:-3px;
    box-shadow:inset 0 0 0 3px #efbd71,0 0 0 2px #efbd7199!important;
}
.builder-app .preview-canvas .wwyt-preview-field-active{
    position:relative;z-index:3;isolation:isolate;
    outline:2px solid #e6a954;outline-offset:3px;
    background:rgba(249,212,136,.23);border-radius:3px;
    box-decoration-break:clone;-webkit-box-decoration-break:clone;
}
.builder-app .preview-canvas .wwyt-preview-removed{
    filter:grayscale(.8);opacity:.53;
}
.builder-app .preview-canvas .wwyt-preview-removed::after{
    content:"Removed from invitation";position:absolute;z-index:20;
    left:50%;top:20px;transform:translateX(-50%);
    width:max-content;max-width:90%;padding:9px 14px;
    background:#40191f;color:#fff4e3;border:1px solid #ebc78b;
    border-radius:999px;box-shadow:0 5px 22px #1b0919a8;
    font:700 11px 'DM Sans',sans-serif;
}
.builder-app .section-choice:focus-within,.builder-app .group-tab:focus-visible{
    outline:2px solid #9f3343;outline-offset:2px;
}
@media(prefers-reduced-motion:no-preference){
 .builder-app .preview-canvas .wwyt-preview-section-active{
    animation:wwyt-preview-section-flash .6s ease-out 1
 }
 .builder-app .preview-canvas .wwyt-preview-field-active{
    animation:wwyt-preview-field-flash .65s ease-out 1
 }
 @keyframes wwyt-preview-section-flash{
    from{box-shadow:inset 0 0 0 7px #efbd71,0 0 0 5px #efbd71cc}
    to{box-shadow:inset 0 0 0 3px #efbd71,0 0 0 2px #efbd7199}
 }
 @keyframes wwyt-preview-field-flash{
    from{background:rgba(249,212,136,.65)}
    to{background:rgba(249,212,136,.23)}
 }
}


/* Single-row builder chrome: the public navigation is replaced by the complete
   builder toolbar on this page only. All controls remain in the same document. */
body.builder-page .topbar{display:none!important}
body.builder-page > main{min-height:0}
.builder-app .builder-utility{
    height:60px;min-height:60px;flex:none;padding:0 15px;gap:12px;
    display:flex;align-items:center;justify-content:space-between;
    background:#1b171a;border-bottom:1px solid #473539;
}
.builder-app .builder-identity{
    display:flex;flex:0 1 350px;min-width:0;gap:12px;align-items:center
}
.builder-app .builder-brand{display:inline-flex;align-items:center;flex:none;line-height:0}
.builder-app .builder-brand-full{width:145px;height:38px;object-fit:contain}
.builder-app .builder-brand-icon{display:none}
.builder-app .builder-toolbar-divider{height:25px;width:1px;background:#624b4d;flex:none}
.builder-app .builder-back{
    display:inline-flex;align-items:center;gap:6px;flex:none;white-space:nowrap;
    font-size:11px;font-weight:700;color:#e8d3c8;
}
.builder-app .builder-back:hover{color:white}
.builder-app .builder-title{min-width:0;flex:1;display:block}
.builder-app .builder-title strong{
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
    font-size:12px;font-weight:700;max-width:100%;
}
.builder-app .wizard-strip{
    flex:1 1 auto;min-width:0;width:auto;height:100%;gap:3px;
    padding:0 2px;border-bottom:0;justify-content:center;
    scrollbar-width:thin;scrollbar-color:#75535a transparent
}
.builder-app .wizard-strip::-webkit-scrollbar{height:4px}
.builder-app .wizard-step{gap:6px;padding:6px 6px;font-size:11px}
.builder-app .wizard-step .step-dot{width:25px;height:25px;flex:none;font-size:10px}
.builder-app .wizard-arrow{font-size:13px}
.builder-app .builder-utility-right{flex:none;gap:11px;min-width:0}
.builder-app .draft-indicator{font-size:10px;white-space:nowrap}
.builder-app .cancel-btn{
    display:inline-flex;align-items:center;gap:6px;
    padding:8px 10px;font-size:11px
}
.builder-app .builder-columns{padding:10px;gap:10px}
.builder-app .editor-pane,.builder-app .preview-pane{border-radius:12px}
.builder-app .preview-top{min-height:46px;padding:8px 13px;gap:8px;flex-wrap:nowrap}
.builder-app .preview-top strong{font-size:12px}
.builder-app .preview-top small{font-size:10px;margin-top:1px}
.builder-app .preview-switch{flex:none}
.builder-app .preview-switch button{padding:6px 8px}
.builder-app .preview-highlight-help{min-height:27px;padding:5px 13px;font-size:10px}
.builder-app .preview-scroll{padding:12px}
.builder-app .preview-canvas{max-width:650px}
.builder-app .preview-comparison{max-width:650px}
.builder-app .preview-bottom{min-height:29px;padding:7px 12px}
.builder-app .group-headline{padding:10px 19px 9px}
.builder-app .group-headline h2{font-size:25px;margin:3px 0}
.builder-app .group-headline p{margin:3px 0 0}
.builder-app .stage-top{padding:15px 20px 12px}
.builder-app .stage-top h1,.builder-app .stage-top h2{font-size:28px;margin:4px 0 7px}
.builder-app .preview-link-tip{padding:6px 8px;margin-top:7px}
.builder-app .group-tabs{padding:7px 12px;gap:6px}
.builder-app .group-tab{padding:7px 10px}
.builder-app .stage-scroll{padding:15px 20px 20px}
.builder-app .stage-footer{padding:10px 18px;min-height:58px}
.builder-app .stage-footer .btn{min-height:38px}
.builder-app .detail-scroll{padding:15px 20px 20px}

@media(max-width:1320px){
 .builder-app .builder-identity{flex:0 1 255px}
 .builder-app .builder-title{display:none}
 .builder-app .wizard-arrow{display:none}
}
@media(max-width:1030px){
 .builder-app .builder-brand-full{width:116px;height:34px}
 .builder-app .builder-identity{flex:0 0 auto;gap:9px}
 .builder-app .wizard-step{padding:6px 4px;gap:4px}
 .builder-app .wizard-step-label{font-size:10px}
 .builder-app .draft-indicator{font-size:0;gap:0}
 .builder-app .draft-indicator::before{width:8px;height:8px}
}
@media(max-width:850px){
 .builder-app .builder-utility{height:54px;min-height:54px;padding:0 9px;gap:7px}
 .builder-app .builder-brand-full{width:102px}
 .builder-app .builder-back span{display:none}
 .builder-app .builder-back{padding:6px 3px}
 .builder-app .wizard-step-label{display:none}
 .builder-app .wizard-strip{gap:1px;justify-content:center}
 .builder-app .wizard-step{padding:4px 3px}
 .builder-app .wizard-step .step-dot{width:26px;height:26px}
 .builder-app .builder-utility-right{gap:6px}
 .builder-app .cancel-btn{padding:7px 8px}
 .builder-app .builder-columns{padding:7px;gap:0}
 .builder-app .preview-top{flex-wrap:wrap;gap:5px}
 .builder-app .preview-scroll{padding:10px}
 .builder-app .preview-canvas{max-width:650px}
 .builder-app .stage-scroll{padding:14px 16px 20px}
}
@media(max-width:600px){
 .builder-app .builder-utility{height:52px;min-height:52px;padding:0 7px;gap:5px}
 .builder-app .builder-identity{gap:5px}
 .builder-app .builder-brand-full{display:none}
 .builder-app .builder-brand-icon{display:block;width:32px;height:32px;object-fit:contain}
 .builder-app .builder-toolbar-divider{display:none}
 .builder-app .builder-back{padding:6px}
 .builder-app .wizard-strip{height:100%;padding:0;gap:0;justify-content:center}
 .builder-app .wizard-step{padding:5px 2px}
 .builder-app .wizard-step .step-dot{width:24px;height:24px}
 .builder-app .builder-utility-right{gap:4px}
 .builder-app .cancel-btn{width:29px;height:31px;padding:0;justify-content:center}
 .builder-app .cancel-btn span{display:none}
 .builder-app .builder-mobile-switch{gap:1px;padding:2px}
 .builder-app .builder-mobile-switch button{padding:6px 7px;font-size:10px}
 .builder-app .stage-top{padding:14px 15px 10px}
 .builder-app .stage-top h1,.builder-app .stage-top h2{font-size:25px}
 .builder-app .group-headline{padding:10px 15px 8px}
 .builder-app .group-headline h2{font-size:24px}
 .builder-app .group-tabs{padding:7px 9px}
 .builder-app .stage-scroll{padding:13px 14px 18px}
 .builder-app .detail-scroll{padding:13px 14px 18px}
 .builder-app .stage-footer{padding:8px 10px;min-height:53px}
 .builder-app .preview-top{padding:8px 10px}
 .builder-app .preview-bottom{padding:6px 9px}
}
@media(max-width:370px){
 .builder-app .builder-brand-icon{width:26px;height:26px}
 .builder-app .wizard-step .step-dot{width:22px;height:22px}
 .builder-app .builder-mobile-switch button{padding:6px 5px}
}

</style>