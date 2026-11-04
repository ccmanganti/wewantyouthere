@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', $template->name . ' Wedding Invitation Website Template | We Want You There')
@section('meta_description', 'Preview ' . $template->name . ', a beautiful responsive wedding invitation website. Customize the entourage, ceremony, program, dress code, URL and QR code before publishing.')
@push('styles')
@include('marketing.partials.styles')
@endpush
@section('content')
<div class="mkt">
    <section class="mkt-detail"><div class="mkt-wrap">
        <nav aria-label="Breadcrumb" style="font-size:11px;color:#7e6861;margin-bottom:27px"><a href="{{ route('home') }}" style="text-decoration:underline">Home</a> / <a href="{{ route('marketing.templates') }}" style="text-decoration:underline">Wedding templates</a> / {{ $template->name }}</nav>
        <div class="mkt-detail-layout">
            <div>
                <div class="mkt-detail-iframe">
                    <iframe src="{{ route('marketing.templatePreview', $template->slug) }}" title="Live website sample — {{ $template->name }}" loading="lazy"></iframe>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:24px">
                    <p style="font-size:11px;color:#756865">Scroll inside the preview to explore the full invitation website.</p>
                    <a class="mkt-button small ghost" href="{{ route('marketing.templatePreview', $template->slug) }}" target="_blank" rel="noopener noreferrer">Open full website preview <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="mkt-detail-copy">
                <div class="mkt-kicker red">WEDDING INVITATION WEBSITE TEMPLATE</div>
                <h1>{{ $template->name }}</h1>
                <div class="mkt-pill">{{ $template->is_premium ? 'Premium template' : 'Free website design' }}</div>
                <p style="margin-top:23px">{{ data_get($template->settings, 'description', 'A romantic wedding invitation design with room for every meaningful detail.') }}</p>
                <p>Make the template your own with a guided wedding questionnaire and live website preview. Choose which sections appear; include entourage names, your ceremony and reception, dress code, program, and special messages for guests.</p>
                <h2 style="font-size:28px;margin-top:30px">What you can customize</h2>
                <ul class="mkt-detail-points">
                    <li>Couple's names, date, ceremony and reception locations</li>
                    <li>Filipino wedding entourage, principal sponsors, ninong and ninang</li>
                    <li>Wedding-day program, attire, gift notes and FAQs</li>
                    <li>Visible sections and invitation wording</li>
                    <li>Personalized shareable URL and downloadable QR code</li>
                    @if(($template->settings['theme'] ?? '') === 'royal_burgundy')
                        <li>Thirteen secure photo placements, with guided highlighting and editing after publishing</li>
                        <li>A romantic opening envelope, wedding calendar, editorial love story and complete event programs</li>
                    @endif
                </ul>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    @if(!$canCreate)
                        <a class="mkt-button" href="{{ url('/app/invitations') }}">Manage my invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    @elseif($template->is_premium)
                        <span class="mkt-pill">Premium publishing is coming soon</span>
                    @else
                        <a class="mkt-button" href="{{ route('wedding.editor', $template->slug) }}">Customize this design <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    @endif
                </div>
                <p style="font-size:11px;margin-top:16px">The preview uses demonstration details. You can replace them with your own during creation. Your free account allows one website.</p>
            </div>
        </div>
    </div></section>
    <section class="mkt-last"><div class="mkt-wrap"><div><div class="mkt-kicker">DESIGN IS ONLY THE BEGINNING</div><h2>SHARE THE DAY. <span class="mkt-serif">keep the feeling.</span></h2></div><a class="mkt-button light" href="{{ route('marketing.templates') }}">Explore other templates <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div></section>
</div>
@endsection
@push('scripts')
@include('marketing.partials.interactions')
@endpush