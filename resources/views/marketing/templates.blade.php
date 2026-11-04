@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', 'Wedding Invitation Website Templates Philippines | We Want You There')
@section('meta_description', 'Browse wedding invitation website templates with full live previews. Make a digital wedding invitation for free, add Filipino wedding details, create a link and QR code.')
@push('styles')
@include('marketing.partials.styles')
@endpush

@section('content')
<div class="mkt">
    <section class="mkt-page-hero">
        <div class="mkt-wrap">
            <div class="mkt-kicker">THE WEDDING WEBSITE COLLECTION</div>
            <h1 class="mkt-display">FIND YOUR <span class="mkt-serif" style="text-transform:none">forever</span> DESIGN.</h1>
            <p>Explore online wedding invitation website templates built for beautiful celebrations in the Philippines. Open a full-page preview, choose the design you love, and make it uniquely yours.</p>
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:25px">
                <a class="mkt-button light" href="#catalogue">Explore wedding designs ↓</a>
                <a class="mkt-button ghost-light" href="{{ route('home') }}#how-it-works">How it works →</a>
            </div>
        </div>
    </section>

    <section class="mkt-section" id="catalogue" style="padding-top:38px">
        <div class="mkt-wrap">
            <div class="mkt-catalogue-filter">
                <div><div class="mkt-kicker red">LIVE WEDDING TEMPLATES</div><h2 style="font-size:clamp(28px,4vw,40px);margin-top:6px">Ready to personalize.</h2></div>
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:7px;max-width:410px;width:100%">
                    <label for="mkt-template-search" style="font-weight:800;font-size:11px;align-self:flex-start">Search available templates</label>
                    <input id="mkt-template-search" type="search" placeholder="Search wedding, ivory, elegant..." autocomplete="off">
                    <span id="mkt-template-count" role="status">{{ $templates->count() }} {{ $templates->count() === 1 ? 'design available' : 'designs available' }}</span>
                </div>
            </div>
            <div class="mkt-template-grid" style="margin-top:33px">
                @foreach($templates as $template)
                    @include('marketing.partials.template-card', ['template' => $template, 'canCreate' => $canCreate])
                @endforeach
            </div>
            <div class="mkt-empty" id="mkt-template-empty" hidden style="margin-top:20px">
                <h3>No matching invitations yet.</h3>
                <p>Try searching for “wedding” or clearing the search field.</p>
            </div>
            @if($templates->isEmpty())
                <div class="mkt-empty" style="margin-top:20px"><h3>The wedding collection is being prepared.</h3><p>Our first design will appear after the starter template is published.</p></div>
            @endif
        </div>
    </section>
    <section class="mkt-last"><div class="mkt-wrap"><div><div class="mkt-kicker">CREATE SOMETHING MEANINGFUL</div><h2>THE DETAILS ARE <span class="mkt-serif">all yours.</span></h2><p>Pick the layout. Tell your story. Share one beautifully simple link.</p></div>
        <a class="mkt-button light" href="{{ route('home') }}#how-it-works">See how it works →</a>
    </div></section>
    @include('marketing.partials.preview-dialog')
</div>
@endsection
@push('scripts')
@include('marketing.partials.interactions')
@endpush
