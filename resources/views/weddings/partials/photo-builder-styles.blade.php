<style>
/* Photo placement studio inside the existing fixed-height invitation builder. */
.photo-stage-head{padding-bottom:17px}
.photo-stage-scroll{background:#fffaf6}
.photo-editor-hint{display:flex;gap:11px;align-items:start;padding:15px 17px;background:#f8ede7;border:1px solid #e3c7b5;border-radius:12px;margin-bottom:17px;color:#80232a}
.photo-editor-hint>i{margin-top:3px;font-size:20px}
.photo-editor-hint strong{display:block;font-size:12px;margin-bottom:4px}
.photo-editor-hint span{font-size:11px;color:#6e5f5d;line-height:1.5;display:block}
.photo-slot-grid{display:grid;grid-template-columns:1fr;gap:11px}
.photo-slot-card{border:1px solid #e3d0c6;background:#fff;border-radius:12px;display:grid;grid-template-columns:minmax(85px,126px) 1fr;gap:13px;padding:12px;transition:border-color .2s ease,box-shadow .2s ease;min-width:0}
.photo-slot-card.is-focused,.photo-slot-card:hover{border-color:#ae6c50;box-shadow:0 0 0 2px #dcbfa347}
.photo-slot-image{min-height:95px;max-height:136px;overflow:hidden;border-radius:8px;display:grid;place-items:center;background:linear-gradient(135deg,#e0c6b3,#f5ede5);border:1px solid #ebddd4}
.photo-slot-image img{width:100%;height:100%;object-fit:cover;display:block}
.photo-slot-placeholder{display:grid;place-items:center;gap:7px;color:#885a52;font-size:22px}
.photo-slot-placeholder small{font-size:9px;font-weight:800}
.photo-slot-meta{min-width:0}
.photo-slot-meta>strong{display:block;font:700 13px/1.3 'DM Sans',sans-serif;color:#2d2223}
.photo-slot-meta>small{display:block;font:11px/1.45 'DM Sans',sans-serif;color:#8a7170;margin:5px 0 12px}
.photo-slot-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
.photo-slot-actions button,.photo-slot-upload{display:inline-flex;align-items:center;justify-content:center;gap:5px;border:1px solid #cfb8ac;background:#fff7f2;border-radius:7px;font:800 10px 'DM Sans',sans-serif;color:#7a2229;padding:7px 8px;min-height:32px;cursor:pointer}
.photo-slot-actions button:hover,.photo-slot-upload:hover{background:#f4e4da;border-color:#ac7f6a}
.photo-slot-actions .photo-slot-upload{background:#810100;color:#fff;border-color:#810100}
.photo-slot-actions .photo-slot-upload:hover{background:#630000}
.photo-slot-actions .photo-slot-remove{color:#7d4e4d;border-color:#e2d6d0;background:transparent}
.photo-slot-actions .photo-slot-remove[hidden]{display:none!important}
.photo-slot-status{font:10px/1.4 'DM Sans',sans-serif;color:#286740;margin-top:6px;min-height:0}
.photo-slot-status.is-error{color:#ac303b}
.photo-security-note{border-top:1px solid #e9d4c7;padding:16px 3px 6px;font:11px/1.7 'DM Sans',sans-serif;color:#786c65;margin-top:18px}
.photo-security-note i{color:#a23541;margin-right:5px}
@media(max-width:480px){.photo-slot-card{grid-template-columns:80px 1fr;gap:10px;padding:9px}.photo-slot-meta>strong{font-size:12px}.photo-slot-actions button,.photo-slot-upload{font-size:9px;padding:7px}}
</style>
