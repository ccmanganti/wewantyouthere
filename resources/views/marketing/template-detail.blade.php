@extends('layouts.wwyt')
@section('body_class', 'template-detail-page')
@section('title', $template->name . ' Wedding Invitation Website Template | We Want You There')
@section('meta_description', 'Preview ' . $template->name . ', a responsive wedding invitation website. Customize the entourage, ceremony, program, dress code, URL and QR code before publishing.')
@push('styles')
@include('marketing.partials.styles')
<style>
/* Keep the design showcase within one desktop viewport. The invitation itself
   scrolls inside its preview frame; mobile uses natural page scrolling. */
.mkt .mkt-detail{padding:22px 0 34px}
.mkt .mkt-detail-layout{grid-template-columns:minmax(0,1.08fr) minmax(0,.92fr);gap:28px;align-items:stretch}
.mkt-detail-preview{display:flex;flex-direction:column;gap:12px;min-height:0;min-width:0}
.mkt .mkt-detail-iframe{flex:1;min-height:400px;border-width:6px;box-shadow:9px 10px 0 #b8a89c}
.mkt .mkt-detail-iframe iframe{width:100%;height:100%;min-height:400px}
.mkt-preview-actions{display:flex;align-items:center;justify-content:space-between;gap:12px;
    flex-wrap:wrap;font:12px/1.4 'DM Sans',sans-serif;color:#786661}
.mkt-preview-actions a{font-weight:700;color:#810100;text-decoration:underline;text-underline-offset:3px}
.mkt .mkt-detail-copy{min-width:0;display:flex;flex-direction:column;gap:0}
.mkt .mkt-detail-copy h1{font-size:clamp(34px,3.9vw,56px);line-height:1.04;margin:10px 0 13px}
.mkt .mkt-detail-copy .mkt-detail-lead{margin:15px 0 12px;line-height:1.6;font-size:13px}
.mkt-detail-features{display:grid;grid-template-columns:1fr 1fr;gap:9px;margin:18px 0 16px}
.mkt-detail-feature{display:flex;align-items:start;gap:8px;padding:11px;border:1px solid #d9c9bf;
    border-radius:9px;background:#fffbf5;font:600 12px/1.45 'DM Sans',sans-serif;color:#574740}
.mkt-detail-feature i{color:#8b242b;margin-top:3px}
.mkt-detail-more{border-top:1px solid #d8c4b9;border-bottom:1px solid #d8c4b9;margin:6px 0 16px}
.mkt-detail-more summary{cursor:pointer;list-style-position:inside;padding:12px 0;
    color:#67232d;font:700 12px 'DM Sans',sans-serif}
.mkt-detail-more .mkt-detail-points{margin:0 0 10px;columns:2;column-gap:18px}
.mkt-detail-more .mkt-detail-points li{break-inside:avoid;font-size:11px;padding:6px 0}
.mkt-detail-cta{margin-top:auto;padding-top:10px}
.mkt-detail-cta .mkt-button{min-height:43px}
.mkt-detail-cta p{font-size:11px!important;line-height:1.5!important;margin:10px 0 0!important}
@media(min-width:1021px){
 body.template-detail-page{height:100dvh;overflow:hidden;display:flex;flex-direction:column}
 body.template-detail-page>main{flex:1;min-height:0;overflow:hidden}
 body.template-detail-page .topbar{flex:none}
 body.template-detail-page .foot{display:none}
 body.template-detail-page .mkt{height:100%}
 body.template-detail-page .mkt .mkt-detail{height:100%;padding:12px 0 15px}
 body.template-detail-page .mkt .mkt-detail>.mkt-wrap{height:100%;display:flex;flex-direction:column}
 body.template-detail-page .mkt .mkt-detail-layout{min-height:0;flex:1}
 body.template-detail-page .mkt .mkt-detail-iframe{min-height:0}
 body.template-detail-page .mkt .mkt-detail-iframe iframe{min-height:0}
 body.template-detail-page .mkt .mkt-detail-copy{min-height:0;overflow-y:auto;overscroll-behavior:contain;padding:2px 12px 4px 2px}
}
@media(max-width:1020px){
 .mkt .mkt-detail-layout{grid-template-columns:1fr;gap:25px}
 .mkt .mkt-detail-iframe,.mkt .mkt-detail-iframe iframe{min-height:0;height:min(61dvh,580px)}
 .mkt-detail-features{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media(max-width:560px){
 .mkt .mkt-detail{padding:15px 0 35px}
 .mkt .mkt-detail-copy h1{font-size:clamp(32px,9vw,47px)}
 .mkt .mkt-detail-iframe,.mkt .mkt-detail-iframe iframe{height:min(53dvh,460px)}
 .mkt-detail-features{gap:7px}
 .mkt-detail-feature{padding:9px;font-size:11px}
 .mkt-detail-more .mkt-detail-points{columns:1}
}
</style>
@endpush
@section('content')
<div class="mkt">
    <section class="mkt-detail"><div class="mkt-wrap">
        <nav aria-label="Breadcrumb" style="font-size:11px;color:#7e6861;margin-bottom:12px">
            <a href="{{ route('home') }}" style="text-decoration:underline">Home</a> /
            <a href="{{ route('marketing.templates') }}" style="text-decoration:underline">Templates</a> /
            {{ $template->name }}
        </nav>
        <div class="mkt-detail-layout">
            <div class="mkt-detail-preview">
                <div class="mkt-detail-iframe">
                    <iframe src="{{ route('marketing.templatePreview', $template->slug) }}"
                        title="Interactive wedding invitation preview — {{ $template->name }}"
                        loading="eager"></iframe>
                </div>
                <div class="mkt-preview-actions">
                    <span><i class="fa-solid fa-computer-mouse" aria-hidden="true"></i> Scroll inside to explore the invitation</span>
                    <a href="{{ route('marketing.templatePreview', $template->slug) }}"
                        target="_blank" rel="noopener noreferrer">Full-screen preview <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="mkt-detail-copy">
                <div class="mkt-kicker red">WEDDING INVITATION WEBSITE</div>
                <h1>{{ $template->name }}</h1>
                <div><span class="mkt-pill">{{ $template->is_premium ? 'Premium template' : 'Free website design' }}</span></div>
                <p class="mkt-detail-lead">{{ data_get($template->settings, 'description', 'A romantic invitation design with room for all your wedding details.') }}</p>
                <div class="mkt-detail-features" aria-label="Included features">
                    <div class="mkt-detail-feature"><i class="fa-solid fa-heart" aria-hidden="true"></i> Couple names &amp; love story</div>
                    <div class="mkt-detail-feature"><i class="fa-solid fa-image" aria-hidden="true"></i> Replaceable photos &amp; galleries</div>
                    <div class="mkt-detail-feature"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Venue maps &amp; directions</div>
                    <div class="mkt-detail-feature"><i class="fa-solid fa-users" aria-hidden="true"></i> Entourage &amp; sponsors</div>
                    <div class="mkt-detail-feature"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Program &amp; event details</div>
                    <div class="mkt-detail-feature"><i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i> Guest RSVP &amp; invitation link</div>
                </div>
                <details class="mkt-detail-more">
                    <summary>What you can customize</summary>
                    <ul class="mkt-detail-points">
                        <li>Wedding date, reception and ceremony locations</li>
                        <li>Parents, principal sponsors, ninong &amp; ninang</li>
                        <li>Bridesmaids, groomsmen and entourage roles</li>
                        <li>Gift notes, dress code and guest reminders</li>
                        <li>Custom invitation wording &amp; visible sections</li>
                        <li>Shareable URL and downloadable QR code</li>
                        @if(in_array(($template->settings['theme'] ?? ''), ['royal_burgundy', 'curated_editorial'], true))
                        <li>Wedding galleries and all 20 replaceable photo positions</li>
                        <li>Animated, click-to-open invitation envelope</li>
                        @endif
                    </ul>
                </details>
                <div class="mkt-detail-cta">
                    @if(!$canCreate)
                        <a class="mkt-button" href="{{ url('/app/invitations') }}">Manage my invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    @elseif($template->is_premium)
                        <a class="mkt-button" href="{{ route('premium.show', $template->slug) }}">Unlock premium · {{ \App\Support\InvitationPremium::price($template) }} <i class="fa-solid fa-lock"></i></a>
                    @else
                        <a class="mkt-button" href="{{ route('wedding.editor', $template->slug) }}">Customize this invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    @endif
                    <p>Sample photos and wording are illustrative. Personalize your design before publishing. Maps, RSVP, video, programme and entourage are premium upgrades.</p>
                </div>
            </div>
        </div>
    </div></section>
</div>
@endsection
@push('scripts')
@include('marketing.partials.interactions')
@endpush
