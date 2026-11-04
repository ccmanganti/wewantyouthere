<style>
.custom-link-panel{padding:19px 20px 17px;background:#fff9f2;border:1px solid #e3cabc;border-radius:12px;margin:0 0 25px}
.custom-link-label{display:block;font-size:14px;font-weight:800;color:#3a2526;margin-bottom:5px}
.custom-link-panel>p{font-size:11px;line-height:1.65;color:#756666;margin:0 0 15px}
.custom-link-field{display:flex;align-items:stretch;border:1px solid #d4b5aa;border-radius:9px;overflow:hidden;background:#fff}
.custom-link-field:focus-within{outline:2px solid #a32936;outline-offset:2px}
.custom-link-field .url-prefix{display:flex;align-items:center;background:#f4e8e1;padding:10px 12px;white-space:nowrap;font-size:11px;font-weight:800;color:#735556;letter-spacing:-.03em}
.editor-pane .custom-link-field input{border:0;border-radius:0;min-width:80px;font-size:13px;font-weight:700;box-shadow:none}
.editor-pane .custom-link-field input:focus{box-shadow:none;border:0}
.slug-feedback{font-size:11px;margin-top:10px;color:#786d66;min-height:17px}
.slug-feedback[data-state="available"]{color:#356f41}
.slug-feedback[data-state="unavailable"],.slug-feedback[data-state="invalid"]{color:#a52a37}
.slug-feedback[data-state="checking"]{color:#866947}
.full-url-preview{font-size:10px;line-height:1.5;color:#7c7371;margin-top:7px;overflow-wrap:anywhere}
.full-url-preview span{color:#9f333a;font-weight:700}
.full-url-preview.qr-note{margin-top:13px;padding-top:12px;border-top:1px solid #ecd7cf}
@media(max-width:560px){
.custom-link-panel{padding:16px 13px}
.custom-link-field{flex-wrap:wrap}
.custom-link-field .url-prefix{width:100%;padding:8px 11px;font-size:10px}
.editor-pane .custom-link-field input{width:100%;min-width:0}
}
</style>