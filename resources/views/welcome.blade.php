@extends('layouts.wwyt')

@section('title', 'Free Wedding Invitation Websites & Templates | We Want You There')
@section('meta_description', 'Create your wedding invitation website for free. Explore elegant invitation templates, enter your wedding details, see your design live, and publish in minutes.')

@push('styles')
<style>
.hero{padding:85px 0 65px;overflow:hidden}.hero-grid{display:grid;grid-template-columns:1.06fr .94fr;align-items:center;gap:68px}
.hero h1{margin:15px 0 22px;max-width:690px}.hero h1 em{color:var(--green);font-weight:400}.hero p{max-width:500px;color:var(--muted);font-size:17px;line-height:1.8}
.hero-actions{display:flex;flex-wrap:wrap;align-items:center;gap:12px;margin-top:28px}
.hero-proof{display:flex;flex-wrap:wrap;gap:19px;margin-top:28px;color:#6b796c;font-size:12px}.hero-proof span:before{content:'✓';color:#5b8066;font-weight:800;margin-right:7px}
.hero-display{padding:25px;background:#e6ebe2;border-radius:130px 130px 24px 24px;box-shadow:18px 20px 0 #f2eee5;transform:rotate(1deg)}
.template-poster{border:1px solid #dfd6c4;min-height:460px;background:#fbf7ed;position:relative;display:flex;flex-direction:column;justify-content:center;text-align:center;padding:65px 24px;overflow:hidden;color:#574e42}
.template-poster:before,.template-poster:after{content:'❧';position:absolute;font-size:130px;color:#c4cdb4;opacity:.65}.template-poster:before{top:-70px;left:-30px;transform:rotate(-22deg)}.template-poster:after{right:-20px;bottom:-95px;transform:rotate(125deg)}
.poster-names{font-family:'DM Serif Display',Georgia,serif;font-style:italic;font-size:clamp(43px,5vw,70px);line-height:1.05;margin:27px 0;color:#4e5c4b}
.poster-rule{width:64px;height:1px;background:#b7a88a;margin:18px auto}
.soft-band{background:#edf1e9;border-top:1px solid #dfe7da;border-bottom:1px solid #dfe7da}.advantages{display:grid;grid-template-columns:repeat(3,1fr);gap:35px;padding:26px 0;text-align:center}.advantages strong{font-family:'DM Serif Display';font-size:21px;font-weight:400}.advantages span{display:block;color:var(--muted);font-size:12px;margin-top:6px}
.template-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:26px}.template-card{overflow:hidden;border-radius:17px;border:1px solid var(--line);background:#fff}.template-thumbnail{padding:24px;background:#eaf0e7}
.template-thumb-inner{height:275px;background:#faf6ec;border:1px solid #dacdb9;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#746b5c;position:relative}
.template-thumb-inner .serif{font-size:36px;font-style:italic;margin:17px 0}.template-info{padding:23px}.template-info h3{font-size:26px;margin:5px 0}.template-info p{font-size:13px;color:var(--muted);min-height:40px}
.process-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:25px}.process-step{padding:32px;background:#fff;border:1px solid var(--line);border-radius:16px}.process-step .num{font-family:'DM Serif Display';font-size:40px;color:#91a595}.process-step h3{font-size:25px;margin:15px 0 10px}.process-step p{color:var(--muted);font-size:13px}
.last-cta{background:#385b4a;color:#fff;border-radius:20px;text-align:center;padding:60px 25px}.last-cta h2{margin:10px 0}.last-cta p{color:#d7e4d8}.last-cta .btn{background:#fff;color:#385b4a}
@media(max-width:900px){.hero-grid{grid-template-columns:1fr;gap:40px}.hero{padding-top:52px}.hero-display{max-width:470px;margin:auto;width:100%}.template-grid,.process-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:580px){.template-grid,.process-grid{grid-template-columns:1fr}.advantages{grid-template-columns:1fr;gap:14px}.template-poster{min-height:360px}}
</style>
@endpush

@section('content')
<section class="hero"><div class="wrap hero-grid">
    <div>
        <div class="eyebrow">Celebrate your love story, beautifully</div>
        <h1>Your wedding deserves a <em>beautiful invitation.</em></h1>
        <p>Choose a design, tell us your story, and watch your invitation come to life. Create a wedding website you can share with everyone you love — free to start.</p>
        <div class="hero-actions"><a href="#templates" class="btn">Explore wedding templates <span aria-hidden="true">→</span></a><a href="#how-it-works" class="btn btn-outline">How it works</a></div>
        <div class="hero-proof"><span>Free wedding website</span><span>Live preview</span><span>No coding needed</span></div>
    </div>
    <div class="hero-display" aria-label="Sample wedding invitation design">
        <div class="template-poster">
            <div class="eyebrow">TOGETHER WITH OUR FAMILIES</div>
            <div class="poster-names">Amelia<br><span style="font-size:.58em">&</span><br>Gabriel</div>
            <div class="poster-rule"></div>
            <div class="eyebrow">THE JOY OF OUR WEDDING DAY</div>
            <div style="font-family:'DM Serif Display';margin-top:20px;font-size:20px">December 12, 2027</div>
            <div class="tiny" style="margin-top:8px">THE GLASS GARDEN · PHILIPPINES</div>
        </div>
    </div>
</div></section>
<div class="soft-band"><div class="wrap advantages">
    <div><strong>01. Choose</strong><span>Pick a beautiful ready-made design</span></div>
    <div><strong>02. Personalize</strong><span>Fill in your details, preview as you type</span></div>
    <div><strong>03. Publish</strong><span>Share your invitation with one easy link</span></div>
</div></div>
<section class="section" id="templates"><div class="wrap">
    <div class="section-heading"><div class="eyebrow">The collection</div><h2>Find your perfect wedding invitation.</h2><p>Start with an elegant design and make it yours. More themes and event types are on the way.</p></div>
    <div class="template-grid">
        @forelse($templates as $template)
            <article class="template-card">
                <div class="template-thumbnail"><div class="template-thumb-inner">
                    <div class="eyebrow">YOU ARE INVITED</div><div class="serif">Amelia & Gabriel</div>
                    <span class="tiny">THE WEDDING CELEBRATION</span><span class="tiny" style="margin-top:18px">DECEMBER 12, 2027</span>
                </div></div>
                <div class="template-info"><span class="pill">{{ $template->is_premium ? 'Premium' : 'Free to publish' }}</span><h3>{{ $template->name }}</h3><p>{{ data_get($template->settings, 'description', 'A timeless wedding invitation.') }}</p>
                    <a class="btn" href="{{ route('wedding.editor', $template->slug) }}">Use this template →</a>
                </div>
            </article>
        @empty
            <div class="card" style="padding:36px;grid-column:1/-1"><h3>Beautiful templates are on the way.</h3><p class="muted">The starter wedding template will appear here after the wedding seeder runs.</p></div>
        @endforelse
    </div>
</div></section>
<section class="section soft-band" id="how-it-works"><div class="wrap">
    <div class="section-heading"><div class="eyebrow">Simple from the first click</div><h2>From “yes” to “you're invited.”</h2></div>
    <div class="process-grid">
        <div class="process-step"><div class="num">01</div><h3>Find your look</h3><p>Pick the wedding template that feels right. We’ll start you off with a beautifully made layout.</p></div>
        <div class="process-step"><div class="num">02</div><h3>Tell your story</h3><p>Enter your wedding details, entourage, program, dress code and more. Hide anything you don't want guests to see.</p></div>
        <div class="process-step"><div class="num">03</div><h3>Invite your people</h3><p>Publish your free invitation website, then share the link with friends and family.</p></div>
    </div>
</div></section>
<section class="section"><div class="wrap"><div class="last-cta"><div class="eyebrow" style="color:#c6dac6">Your celebration starts here</div><h2>We want you there.<br>Let’s make it official.</h2><p>A beautiful invitation is just a few details away.</p><a class="btn" href="#templates">Create your invitation →</a></div></div></section>
@endsection
