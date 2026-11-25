@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', e($page['title'] . ' | We Want You There'))
@section('meta_description', e($page['description']))
@push('styles')
@include('marketing.partials.styles')
<style>
.mkt .seo-hero{background:linear-gradient(125deg,#1b1717,#520b13 72%,#810100);color:#fff;padding:65px 0 72px}
.mkt .seo-crumb{font-size:12px;margin-bottom:28px;display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.mkt .seo-crumb a{text-decoration:underline;text-underline-offset:3px}
.mkt .seo-hero-grid{display:grid;grid-template-columns:1.18fr .82fr;gap:52px;align-items:center}
.mkt .seo-hero h1{font-size:clamp(43px,6.4vw,83px);margin:12px 0 20px;font-weight:400}
.mkt .seo-hero p{max-width:650px;color:#f0dfd8;font-size:16px;line-height:1.8}
.mkt .seo-actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:24px}
.mkt .seo-example{background:#f7f1e6;color:#1b1717;border:1px solid #b89b72;padding:30px;box-shadow:10px 10px 0 #b89b7240;border-radius:14px}
.mkt .seo-example h2{font-size:clamp(27px,3.2vw,42px);margin:12px 0 17px}
.mkt .seo-example ul{padding-left:20px;margin:0}
.mkt .seo-example li{padding:7px 0}
.mkt .seo-content{padding:64px 0}
.mkt .seo-content h2{font-size:clamp(28px,3.8vw,45px);margin-bottom:20px}
.mkt .seo-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.mkt .seo-card{background:#fffdf7;border:1px solid #d8c9ba;border-radius:12px;padding:27px;min-width:0}
.mkt .seo-card h3{font-size:clamp(25px,2.7vw,34px);margin:8px 0 14px}
.mkt .seo-card p{margin:0;color:#554b47;line-height:1.85}
.mkt .seo-related{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
.mkt .seo-related a{display:block;padding:20px;background:#fffdf7;border:1px solid #d8c9ba;border-radius:9px}
.mkt .seo-related a:hover{border-color:#810100}
.mkt .seo-related strong{display:block;color:#810100;margin-bottom:9px}
.mkt .seo-related span{font-size:13px;color:#554b47}
.mkt .seo-faq details{background:#fffdf7;border:1px solid #d8c9ba;border-radius:9px;padding:16px 20px;margin:10px 0}
.mkt .seo-faq summary{cursor:pointer;font-weight:700}
.mkt .seo-faq p{margin:12px 0 0;color:#554b47;line-height:1.8}
.mkt .seo-compare{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:24px}
.mkt .seo-compare ul{padding-left:20px}
.mkt .seo-compare li{margin:8px 0}
.mkt .seo-price-list{display:grid;gap:10px}
.mkt .seo-price-row{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;border:1px solid #d8c9ba;background:#fffdf7;border-radius:10px;padding:16px}
.mkt .seo-price-row a:not(.mkt-button){font-weight:700;text-decoration:underline;text-underline-offset:3px}
.mkt .seo-last{background:#1b1717;color:#fff;text-align:center;padding:56px 0}
.mkt .seo-last h2{font-size:clamp(32px,4.5vw,55px);margin:0 0 18px}
@media(max-width:760px){.mkt .seo-hero{padding:38px 0 45px}.mkt .seo-hero-grid,.mkt .seo-grid,.mkt .seo-compare,.mkt .seo-related{grid-template-columns:1fr;gap:16px}.mkt .seo-content{padding:42px 0}.mkt .seo-card,.mkt .seo-example{padding:22px}.mkt .seo-hero-grid{gap:28px}}
</style>
@endpush
@section('content')
<div class="mkt">
    <section class="seo-hero">
        <div class="mkt-wrap">
            <nav class="seo-crumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span aria-current="page">{{ $page['label'] }}</span></nav>
            <div class="seo-hero-grid">
                <div>
                    <div class="mkt-kicker">{{ $page['kicker'] }}</div>
                    <h1>{{ $page['h1'] }}</h1>
                    <p>{{ $page['intro'] }}</p>
                    <div class="seo-actions">
                        <a class="mkt-button light" href="{{ !$canCreate ? url('/app/invitations') : route('marketing.templates') }}">{{ !$canCreate ? 'Manage my invitation' : $page['cta'] }}</a>
                        @if($pageSlug !== 'pricing')<a class="mkt-button ghost-light" href="{{ route('marketing.landing', ['page' => 'pricing']) }}">Compare free and premium</a>@endif
                    </div>
                </div>
                <aside class="seo-example" aria-label="Quick guide">
                    <div class="mkt-kicker red">GOOD TO KNOW</div>
                    <h2>{{ $page['exampleTitle'] }}</h2>
                    <ul>@foreach($page['example'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                </aside>
            </div>
        </div>
    </section>
    <section class="seo-content">
        <div class="mkt-wrap">
            <div class="seo-grid">
                @foreach($page['sections'] as [$heading, $body])
                    <section class="seo-card"><h2 style="font-size:clamp(26px,3vw,36px);margin:0 0 14px">{{ $heading }}</h2><p>{{ $body }}</p></section>
                @endforeach
            </div>
        </div>
    </section>
    @if(($page['mode'] ?? '') === 'examples')
        <section class="seo-content" style="padding-top:0">
            <div class="mkt-wrap">
                <h2>Explore interactive sample invitations</h2>
                <p>Each preview uses illustrative details. Open the sample to see the design in action.</p>
                <div class="mkt-template-grid">
                    @foreach($templates as $template)
                        @include('marketing.partials.template-card', ['template' => $template, 'canCreate' => $canCreate])
                    @endforeach
                </div>
                @if($templates->isEmpty())<p>No sample designs are currently available. Please check the template collection for updates.</p>@endif
            </div>
        </section>
        @include('marketing.partials.preview-dialog')
    @elseif(($page['mode'] ?? '') === 'pricing')
        <section class="seo-content" style="padding-top:0">
            <div class="mkt-wrap">
                <h2>Compare invitation features</h2>
                <div class="seo-compare">
                    <div class="seo-card"><h3>Free website · ₱0</h3><ul><li>One basic invitation per free account</li><li>Essential wedding information and supported photo uploads</li><li>Guided editor and preview</li><li>Shareable URL and downloadable QR code</li><li>Manage your invitation after publication</li></ul></div>
                    <div class="seo-card"><h3>Premium upgrade · one-time</h3><p>Everything supported by the selected basic design, plus advanced features:</p><ul>
                        @foreach(\App\Support\InvitationPremium::FEATURES as $feature)<li><strong>{{ $feature['name'] }}</strong> — {{ $feature['detail'] }}</li>@endforeach
                    </ul></div>
                </div>
                <h2>Current published designs and prices</h2>
                <div class="seo-price-list">
                    @forelse($templates as $template)
                        <div class="seo-price-row">
                            <div><a href="{{ route('marketing.templateDetail', $template->slug) }}">{{ $template->name }}</a><div>{{ $template->is_premium ? 'Premium design' : 'Free basic design' }}</div></div>
                            @if((int) $template->premium_price_cents >= 100)
                                <span>Premium: {{ \App\Support\InvitationPremium::price($template) }}</span>
                                <a class="mkt-button small" href="{{ route('premium.show', $template->slug) }}">View upgrade details</a>
                            @else
                                <span>Premium price not available</span>
                                <a class="mkt-button small ghost" href="{{ route('marketing.templateDetail', $template->slug) }}">View design</a>
                            @endif
                        </div>
                    @empty
                        <p>No published designs are currently available.</p>
                    @endforelse
                </div>
                @unless(\App\Support\InvitationPremium::isAvailable())
                    <p>Online premium checkout is currently unavailable. You can still explore the designs and free invitation options.</p>
                @endunless
            </div>
        </section>
    @endif
    <section class="seo-content" style="padding-top:0">
        <div class="mkt-wrap seo-faq">
            <h2>Frequently asked questions</h2>
            @foreach($page['faq'] as [$question, $answer])
                <details><summary>{{ $question }}</summary><p>{{ $answer }}</p></details>
            @endforeach
        </div>
    </section>
    <section class="seo-content" style="padding-top:0">
        <div class="mkt-wrap">
            <h2>Explore related resources</h2>
            <div class="seo-related">
                @foreach($page['related'] as $slug)
                    <a href="{{ route('marketing.landing', ['page' => $slug]) }}"><strong>{{ $pages[$slug]['label'] }} →</strong><span>{{ $pages[$slug]['description'] }}</span></a>
                @endforeach
                <a href="{{ route('marketing.templates') }}"><strong>Wedding invitation templates →</strong><span>Browse available designs and open a sample preview.</span></a>
            </div>
        </div>
    </section>
    <section class="seo-last"><div class="mkt-wrap"><h2>Ready to make it yours?</h2><a class="mkt-button light" href="{{ !$canCreate ? url('/app/invitations') : route('marketing.templates') }}">{{ !$canCreate ? 'Manage my invitation' : 'Explore wedding templates' }}</a></div></section>
</div>
@endsection
@push('scripts')
@if(($page['mode'] ?? '') === 'examples')
@include('marketing.partials.interactions')
@endif
@endpush
