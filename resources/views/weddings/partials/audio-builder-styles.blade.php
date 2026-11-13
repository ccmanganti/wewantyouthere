<style>
.music-studio{background:#fffaf3;border:1px solid #e3d5c5;border-radius:14px;padding:23px 19px;margin:24px 0 7px;box-shadow:0 8px 28px #4b23110a;font-family:'DM Sans',Arial,sans-serif;color:#39302d}
.music-studio h3,.music-studio p{margin:0}
.music-studio-heading{margin-bottom:20px}
.music-studio-kicker{font:800 10px/1.5 'DM Sans',sans-serif;letter-spacing:.12em;color:#95643b;display:flex;align-items:center;gap:6px}
.music-studio-heading h3{font:400 34px/1.1 Georgia,serif;margin:9px 0 10px;color:#4c242c}
.music-studio-heading p{font:12px/1.65 'DM Sans',sans-serif;color:#7a6f6a;max-width:520px}
.music-slot{border:1px solid #e7d9c9;background:#fffefb;border-radius:12px;padding:19px 15px 17px;margin:15px 0;min-width:0}
.music-slot legend{font:800 13px/1.5 'DM Sans',sans-serif;color:#6f273b;padding:0 9px}
.music-slot legend span{font-size:10px;padding:6px 8px;background:#f0e3db;margin-right:6px;border-radius:6px}
.music-slot>p{font-size:11px;line-height:1.65;color:#716a65;margin-bottom:16px}
.music-source-switch{display:flex;flex-wrap:wrap;gap:8px;margin:5px 0 16px}
.music-source-option{position:relative;display:inline-flex;align-items:center;justify-content:center;min-height:36px;flex:1 1 140px;cursor:pointer}
.music-source-option input{position:absolute;opacity:0;inset:0;width:100%;height:100%;cursor:pointer;z-index:1}
.music-source-option span{width:100%;min-height:36px;padding:10px 8px;border:1px solid #d3c7bc;border-radius:7px;background:#faf8f3;display:grid;place-items:center;text-align:center;font-size:11px;font-weight:700;color:#665a54}
.music-source-option input:checked+span{background:#4b1e2e;color:#fff;border-color:#4b1e2e;box-shadow:0 3px 10px #4b1e2e20}
.music-source-option input:focus-visible+span{outline:3px solid #cb9468;outline-offset:3px}
.music-library-options,.music-upload-options{display:flex;flex-direction:column;align-items:start;gap:9px}
.music-library-options[hidden],.music-upload-options[hidden],.music-remove-button[hidden]{display:none!important}
.music-library-options label,.music-upload-options>label{font-size:11px;color:#6f625a;font-weight:700}
.music-library-options select{width:100%;min-width:0;max-width:100%;padding:12px 11px;border:1px solid #d0c2b4;border-radius:7px;background:white;color:#3b302e;font:600 11px/1.5 'DM Sans',sans-serif}
.music-upload-options input[type=file]{display:block;max-width:100%;width:100%;border:1px dashed #cdbca9;border-radius:8px;padding:12px;background:#fcf7f0;font:11px/1.5 'DM Sans',sans-serif}
.music-try-button{display:inline-flex;align-items:center;gap:9px;background:#f2e7db;color:#522639;border:1px solid #e2c4ae;border-radius:7px;padding:10px 13px;min-height:38px;font:800 11px/1.3 'DM Sans',sans-serif;cursor:pointer}
.music-try-button:hover,.music-try-button:focus-visible{background:#ead7c6}
.music-remove-button{background:transparent;border:0;text-decoration:underline;color:#a53e36;font:700 11px 'DM Sans',sans-serif;padding:4px 1px;cursor:pointer}
.music-uploaded-file{font:11px/1.5 'DM Sans',sans-serif;color:#476746;overflow-wrap:anywhere}
.music-upload-status{min-height:1em;font-size:11px!important;color:#496c54}
.music-upload-status.is-error{color:#ad3439}
.music-studio-extras{background:#f5ece2;padding:18px;border-radius:9px;margin-top:20px}
.music-sfx-toggle{display:flex;gap:12px;align-items:start;cursor:pointer;font-size:12px}
.music-sfx-toggle input{accent-color:#6c293d;margin-top:4px;width:18px;height:18px;flex:none}
.music-sfx-toggle strong{display:block;color:#562733;font-size:12px;margin-bottom:3px}
.music-sfx-toggle small{display:block;color:#786b63;line-height:1.55}
.music-volume-label{display:flex;justify-content:space-between;gap:14px;font-weight:700;font-size:11px;margin:22px 0 10px}
.music-volume-label output{font-variant-numeric:tabular-nums}
.music-studio input[type=range]{width:100%;accent-color:#783244}
.music-studio-tip{font:11px/1.6 'DM Sans',sans-serif!important;color:#71655d;display:flex;gap:9px;margin-top:18px!important}
.music-studio-tip i{margin-top:4px;flex:none}
.music-studio-locked{display:flex;align-items:center;gap:15px;margin:19px 0;padding:15px;border:1px solid #d0b9a4;background:#fffaf0;border-radius:11px;cursor:pointer;font:11px/1.5 'DM Sans',sans-serif;color:#5c4e48}
.music-studio-locked>i:first-child{font-size:19px;color:#995d47}.music-studio-locked>i:last-child{margin-left:auto}
.music-studio-locked strong{display:block;font-size:12px;color:#643340}.music-studio-locked small{display:block;color:#7d6f68;margin-top:3px}
.wwyt-audio-toolbar{position:fixed;bottom:22px;left:22px;z-index:901;display:flex;align-items:center;gap:6px;font-family:'DM Sans',Arial,sans-serif}
.wwyt-audio-toolbar button{display:flex;align-items:center;justify-content:center;gap:8px;border:1px solid #dacbb6;border-radius:999px;background:#fff9ed;color:#41353a;min-height:44px;box-shadow:0 8px 24px #0002;padding:10px 16px;font:800 11px 'DM Sans',sans-serif;cursor:pointer}
.wwyt-audio-toolbar button:hover{background:#efe5da}
.wwyt-audio-toolbar .wwyt-audio-sfx{width:42px;padding:0}
.wwyt-audio-toolbar .wwyt-audio-caption{font:600 10px 'DM Sans',sans-serif;color:inherit}
.wwyt-audio-toolbar[hidden]{display:none!important}
body.builder-page .wwyt-audio-toolbar{position:absolute;bottom:14px;left:14px;z-index:20}
body.builder-page .wwyt-audio-toolbar button{min-height:37px;padding:8px 12px}
@media(max-width:700px){.music-studio{padding:17px 12px}.music-slot{padding:17px 10px}.music-source-option{flex-basis:100px}.wwyt-audio-toolbar{left:12px;bottom:12px}.wwyt-audio-toolbar button{padding:10px 12px}}
@media(prefers-reduced-motion:reduce){.music-studio *, .wwyt-audio-toolbar *{transition:none!important;animation:none!important}}

</style>
