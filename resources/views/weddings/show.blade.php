@extends('layouts.wwyt')
@section('title', ($answers['bride_name'] ?? 'Our') . ' & ' . ($answers['groom_name'] ?? 'Wedding') . ' — Wedding Invitation')
@section('meta_description', 'You are invited to celebrate a wedding. Discover the ceremony, reception, wedding entourage and celebration details.')
@push('styles')
<style>
.public-invite{max-width:740px;margin:45px auto;box-shadow:0 20px 70px #213d3020}
.wedding-invite{color:#5c5247;background:#fcf8f0;text-align:center;font-family:Georgia,serif}
.wedding-invite [hidden]{display:none!important}
.invite-cover{min-height:740px;position:relative;padding:140px 48px 105px;border:1px solid #e1dacd;display:flex;flex-direction:column;align-items:center;justify-content:center;overflow:hidden}
.ornament{position:absolute;font-size:175px;line-height:1;color:#b4c0a7;opacity:.6}.ornament-top{top:-75px;left:-30px;transform:rotate(-20deg)}.ornament-bottom{bottom:-75px;right:-30px;transform:rotate(145deg)}
.invite-eyebrow,.invite-small{font-family:'DM Sans',sans-serif;font-size:10px;letter-spacing:.23em;font-weight:600}.invite-divider{height:1px;width:78px;background:#c4b49c;margin:26px auto}.invite-cover h1{font-family:'DM Serif Display',Georgia,serif;font-size:clamp(48px,7vw,80px);font-weight:400;line-height:1.12;color:#4b634d;margin:22px 0}.invite-cover h1 span{display:block}.invite-cover h1 i{display:block;font-size:.55em;font-weight:400}
.invite-message{font-style:italic;max-width:420px;line-height:1.85}.invite-date{font-family:'DM Serif Display',Georgia,serif;font-size:28px;margin:0 0 10px}
.invite-section{padding:75px 50px;background:#fffdf8;border-top:1px solid #eae5d9}.invite-section h2{font-family:'DM Serif Display',Georgia,serif;font-size:45px;font-weight:400;color:#516b52;margin:16px 0 27px}.invite-section h3{font:600 11px 'DM Sans',sans-serif;letter-spacing:.14em;text-transform:uppercase;color:#66745f;margin:30px 0 12px}.invite-section p{line-height:1.75}.invite-tinted{background:#f0f1e9}.invite-two-cols{display:grid;grid-template-columns:1fr 1fr;gap:18px;padding-top:10px}.subtle{color:#888477;font-size:14px}.pre-line{white-space:pre-line}.invite-footer{padding:46px;font:italic 27px 'DM Serif Display',Georgia,serif}.invite-footer small{display:block;margin-top:13px;font:600 9px 'DM Sans',sans-serif;letter-spacing:.2em}
@media(max-width:580px){.invite-cover{padding:95px 23px;min-height:580px}.invite-section{padding:54px 23px}.invite-two-cols{grid-template-columns:1fr}.public-invite{margin:0 auto}.invite-section h2{font-size:36px}}
</style>
@endpush
@section('content')
<div class="wrap">
    <div style="max-width:740px;margin:36px auto 22px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap">
        <span class="pill">A We Want You There invitation</span>
        <button class="btn btn-outline" type="button" onclick="navigator.clipboard?.writeText(location.href).then(()=>this.textContent='Link copied!').catch(()=>window.prompt('Copy link',location.href))">Share invitation →</button>
    </div>
    <div class="public-invite">
        @include('weddings.partials.invitation', ['answers' => $answers, 'sections' => $sections, 'questions' => $questions, 'isPreview' => false])
    </div>
</div>
@endsection
