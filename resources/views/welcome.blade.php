@extends('layouts.wwyt')

@section('title', 'Free Wedding Invitation Website Builder & Templates | We Want You There')
@section('meta_description', 'Build a beautiful free wedding invitation website. Choose a wedding template, select sections, fill in your wedding details, see a live preview, and publish a shareable invitation.')

@push('styles')
<style>
.home{background:#f8f5f0}
.home-hero{background:#171417;position:relative;overflow:hidden;color:#fff}
.home-hero::before{content:"";position:absolute;pointer-events:none;width:540px;height:540px;border:1px solid #67524455;border-radius:50%;left:-320px;top:-220px}
.home-hero::after{content:"";position:absolute;pointer-events:none;width:330px;height:330px;border:1px solid #be9a6333;border-radius:50%;right:-175px;bottom:-150px}
.hero-grid{min-height:665px;display:grid;grid-template-columns:1.05fr .95fr;align-items:center;gap:72px;padding-top:72px;padding-bottom:76px}
.home-hero .eyebrow{color:#d2ad78;font-size:11px}
.home-hero h1{font:400 clamp(49px,6.3vw,91px)/.98 'DM Serif Display',Georgia,serif;letter-spacing:-2.5px;max-width:700px;margin:23px 0 24px}
.home-hero h1 em{font-weight:400;color:#cf4652}
.home-hero p{color:#d4c8c4;font-size:16px;max-width:500px;line-height:1.9}
.hero-ctas{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin:30px 0}
.home-hero .btn{border-radius:9px;padding:15px 24px}
.home-hero .btn-line{background:transparent;border:1px solid #736366;color:#fff}
.home-hero .btn-line:hover{background:#3b292f}
.hero-checks{display:flex;gap:19px;flex-wrap:wrap;color:#d5b88d;font-size:11px;letter-spacing:.02em;margin-top:24px}
.hero-checks span::before{content:"✓";margin-right:7px;color:#d5b88d}
.hero-art{position:relative;max-width:455px;margin:auto;width:100%;transform:rotate(1deg)}
.hero-art::before{content:"";position:absolute;inset:-22px;border:1px solid #94754d66;border-radius:210px 210px 15px 15px;z-index:0}
.art-paper{background:#f8f1e7;position:relative;border:7px solid #c9ad8c;outline:6px solid #3f2b2e;outline-offset:7px;min-height:530px;box-shadow:30px 32px 0 #a72d3733;color:#473935;display:flex;align-items:center;justify-content:center;padding:32px;text-align:center;border-radius:190px 190px 6px 6px;overflow:hidden}
.art-paper::before,.art-paper::after{content:"✤";position:absolute;color:#bc9d6d4d;font-size:180px}
.art-paper::before{top:-83px;left:-48px}.art-paper::after{right:-50px;bottom:-90px}
.art-inner{position:relative;z-index:1;padding:30px 16px;border:1px solid #c4a77d77;max-width:100%;width:100%;min-height:405px;display:flex;flex-direction:column;align-items:center;justify-content:center}
.art-kicker{letter-spacing:.22em;font-size:10px;color:#947554;font-weight:700}
.art-names{font:italic 60px/1.1 'DM Serif Display',Georgia,serif;color:#872733;margin:35px 0 23px}
.art-ampersand{font-size:43px;color:#b3996c}
.art-rule{width:60px;height:1px;background:#c3a076;margin:0 auto 23px}
.art-date{font:20px 'DM Serif Display',Georgia,serif;color:#5b4943;margin:10px 0}
.art-tag{position:absolute;top:44px;right:-40px;background:#9e2636;color:#fff;padding:12px 22px;letter-spacing:.16em;font-size:10px;font-weight:700;transform:rotate(5deg);box-shadow:0 8px 16px #0004;z-index:3}
.art-caption{position:absolute;bottom:-54px;left:15px;color:#b69a75;font-size:10px;letter-spacing:.14em}
.home-band{background:#261e22;color:#f3e7dd;border-top:1px solid #514143;border-bottom:1px solid #514143}
.home-band .wrap{padding:20px 0;display:flex;justify-content:space-around;align-items:center;gap:12px}
.home-band span{font-size:12px;font-weight:600;letter-spacing:.04em}
.home-band .sep{color:#b99a6d}
.home-main{padding:90px 0 40px}
.home-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:30px}
.home-heading h2{font-size:clamp(34px,4.5vw,54px);margin:12px 0;color:#241a1d;letter-spacing:-1px}
.home-heading p{font-size:14px;color:#827875;max-width:420px;line-height:1.8}
.home .eyebrow{color:#a52a39}
.template-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:23px}
.template-card{background:#fff;border:1px solid #ded2cd;border-radius:16px;overflow:hidden;box-shadow:0 10px 28px #2f1f1f07}
.template-visual{background:#2a2226;padding:27px;display:block;position:relative;min-height:350px}
.template-visual-inner{background:#f6f0e6;min-height:295px;padding:30px 15px;border:2px solid #c2a67b;text-align:center;color:#634d4c;display:flex;align-items:center;justify-content:center;flex-direction:column;position:relative}
.template-visual-inner::after{content:"✧";position:absolute;font-size:50px;right:7px;top:-17px;color:#a98a5d}
.template-visual-inner .serif{font-style:italic;font-size:36px;color:#9f2b36;margin:22px 0}
.template-visual-inner .tiny{letter-spacing:.08em;font-size:10px}
.template-card-body{padding:23px}
.template-card-body h3{font-size:28px;margin:12px 0 8px}
.template-card-body p{font-size:12px;line-height:1.8;color:#746a67;min-height:38px;margin:0 0 18px}
.template-card-body .btn{border-radius:9px}
.template-card .pill{background:#f9e8e6;color:#97343e}
.draft-link{display:none!important;margin-left:10px;font-size:12px;font-weight:700;color:#97343e;text-decoration:underline}
.draft-link.is-visible{display:inline!important}
.process{background:#f0eae3;padding:94px 0}
.process .home-heading{margin-bottom:43px}
.process-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px}
.process-card{padding:30px;border:1px solid #ddd0c9;background:#fffaf5;position:relative;border-radius:13px}
.process-card:before{content:"";height:3px;background:#b82e3d;position:absolute;top:0;left:0;right:0}
.process-number{font:45px 'DM Serif Display',Georgia,serif;color:#bfa16e}
.process-card h3{font-size:27px;margin:15px 0 10px}
.process-card p{font-size:13px;color:#7b706c;line-height:1.8}
.value-section{padding:92px 0}
.value-grid{display:grid;grid-template-columns:1fr 1fr;gap:74px;align-items:center}
.value-grid h2{margin:9px 0 18px;color:#231b1e}
.value-grid p{color:#7a7070;line-height:1.9}
.value-checks{display:grid;gap:17px;margin-top:25px}
.value-checks li{list-style:none;padding:0 0 0 31px;position:relative;color:#524647;font-size:13px}
.value-checks li:before{content:"✓";position:absolute;left:0;top:0;color:#a32a36;font-size:16px}
.value-visual{background:#211a1e;border-radius:15px;padding:30px;border:1px solid #4b3338;min-height:355px;display:grid;place-items:center}
.value-screen{background:#fff9f3;border:1px solid #b3915c;padding:24px 27px;border-radius:10px;width:100%;max-width:420px}
.value-progress{display:flex;gap:7px;margin-bottom:22px}.value-progress span{flex:1;height:4px;background:#e5d3c4;border-radius:4px}.value-progress span:first-child{background:#a52a37}
.value-screen h3{font:28px 'DM Serif Display',serif;margin:8px 0}
.fake-section{border:1px solid #e4d8d0;border-radius:8px;padding:12px 14px;margin:10px 0;display:flex;align-items:center;justify-content:space-between;gap:7px;color:#46383b;font-size:12px}
.fake-section b{display:inline-grid;place-items:center;width:19px;height:19px;border-radius:4px;background:#9e2a37;color:white;font-size:11px}
.faq-section{background:#1c171b;color:#f5eae4;padding:80px 0}
.faq-section h2{color:#f6eee4;margin:10px 0 24px}
.faq-list{display:grid;gap:10px}
.faq-list details{padding:18px 20px;background:#2b2227;border:1px solid #4c393d;border-radius:10px}
.faq-list summary{cursor:pointer;font-weight:700;font-size:13px}
.faq-list p{margin:11px 0 0;color:#d9c9c3;font-size:12px;line-height:1.8}
.final-banner{padding:70px 0;background:#a22938;color:#fff}
.final-banner .wrap{display:flex;justify-content:space-between;align-items:center;gap:25px}
.final-banner h2{margin:10px 0;color:#fff;max-width:630px}
.final-banner p{color:#f3dcda;font-size:13px}
.final-banner .btn{background:#f9eee2;color:#7d2933;border-radius:10px}
.final-banner .btn:hover{background:#fff}
@media(max-width:960px){.hero-grid{grid-template-columns:1fr;min-height:0;padding:66px 0 85px;gap:66px}.hero-art{max-width:390px}.art-paper{min-height:450px}.art-inner{min-height:342px}.template-grid,.process-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.value-grid{grid-template-columns:1fr;gap:28px}}
@media(max-width:620px){.home-hero h1{letter-spacing:-1.5px;font-size:clamp(46px,12vw,64px)}.hero-grid{gap:72px}.hero-art{max-width:290px}.art-paper{min-height:390px}.art-inner{min-height:280px}.art-names{font-size:41px;margin:22px 0 12px}.art-tag{right:-18px;top:24px;font-size:8px;padding:8px 10px}.art-caption{bottom:-42px}.hero-checks{gap:10px}.home-band .wrap{flex-direction:column;gap:7px}.home-band .sep{display:none}.home-main,.process,.value-section{padding:60px 0}.home-heading{display:block}.template-grid,.process-grid{grid-template-columns:1fr}.final-banner .wrap{display:block}.final-banner .btn{margin-top:12px}}
</style>
@endpush

@section('content')
<div class="home">
@php($featured = $templates->first())
<section class="home-hero">
    <div class="wrap hero-grid">
        <div>
            <div class="eyebrow">Made for the moments that matter</div>
            <h1>YOUR MOMENT, <em>beautifully invited.</em></h1>
            <p>Build a website invitation that feels unmistakably yours. Choose a design, select what you want to share, see your edits instantly, and publish for free.</p>
            <div class="hero-ctas">
                @if(!$canCreate)
                    <a class="btn" href="{{ url('/app/invitations') }}">Manage my invitation ↗</a>
                @elseif($featured)
                    <a class="btn" href="{{ route('wedding.editor', $featured->slug) }}">Create my invitation ↗</a>
                @else
                    <a class="btn" href="#templates">Explore wedding templates ↗</a>
                @endif
                <a href="#templates" class="btn btn-line">Browse templates</a>
                @if($featured && $canCreate)
                <a href="{{ route('wedding.editor', $featured->slug) }}" class="btn btn-line" id="hero-resume" hidden>Continue my draft →</a>
                @endif
            </div>
            <div class="hero-checks"><span>Free to publish</span><span>Live website preview</span><span>No design experience needed</span></div>
        </div>
        <div class="hero-art" aria-label="Elegant example wedding invitation">
            <span class="art-tag">THE WEDDING EDIT</span>
            <div class="art-paper"><div class="art-inner">
                <div class="art-kicker">TOGETHER WITH OUR FAMILIES</div>
                <div class="art-names">Amelia<br><span class="art-ampersand">&</span><br>Gabriel</div>
                <div class="art-rule"></div>
                <span class="art-kicker">JOYFULLY INVITE YOU TO CELEBRATE</span>
                <div class="art-date">December 12, 2027</div>
                <span class="art-kicker">THE GLASS GARDEN · PHILIPPINES</span>
            </div></div>
            <div class="art-caption">DESIGNED FOR BEAUTIFUL CELEBRATIONS</div>
        </div>
    </div>
</section>

<div class="home-band"><div class="wrap"><span>01 — Choose your design</span><span class="sep">✦</span><span>02 — Tell your story</span><span class="sep">✦</span><span>03 — Share your invitation</span></div></div>

<section class="home-main" id="templates">
    <div class="wrap">
        <div class="home-heading"><div><span class="eyebrow">The wedding collection</span><h2>Designed for your “I do.”</h2></div><p>Start with one carefully made wedding template. More styles and event categories will join the collection as we grow.</p></div>
        <div class="template-grid">
            @forelse($templates as $template)
                <article class="template-card">
                    <div class="template-visual"><div class="template-visual-inner">
                        <div class="eyebrow">YOU ARE INVITED</div>
                        <div class="serif">Amelia & Gabriel</div>
                        <span class="tiny">A CELEBRATION OF LOVE</span>
                        <span class="tiny" style="margin-top:19px">DECEMBER 12, 2027</span>
                    </div></div>
                    <div class="template-card-body">
                        <span class="pill">{{ $template->is_premium ? 'Premium template' : 'Free website' }}</span>
                        <h3>{{ $template->name }}</h3>
                        <p>{{ data_get($template->settings, 'description', 'Create a timeless wedding invitation in just a few steps.') }}</p>
                        @if($canCreate)
                            <a class="btn" href="{{ route('wedding.editor', $template->slug) }}">Customize template →</a>
                            <a class="draft-link" data-resume-template="{{ $template->slug }}" href="{{ route('wedding.editor', $template->slug) }}" aria-label="Continue draft for {{ $template->name }}">Continue draft ↗</a>
                        @else
                            <a class="btn" href="{{ url('/app/invitations') }}">Manage my invitation →</a>
                        @endif
                    </div>
                </article>
            @empty
                <div class="card" style="grid-column:1/-1;padding:35px"><h3>Our first wedding template is almost ready.</h3><p class="muted">Run the WeddingBuilderSeeder on the website to activate the starter design.</p></div>
            @endforelse
        </div>
    </div>
</section>

<section class="process" id="how-it-works"><div class="wrap">
    <div class="home-heading"><div><span class="eyebrow">Simple from start to finish</span><h2>Three steps. One beautiful invitation.</h2></div><p>Everything you need, without scrolling through a hundred questions at once.</p></div>
    <div class="process-grid">
        <div class="process-card"><span class="process-number">01</span><h3>Pick what matters</h3><p>Choose the sections you want: ceremony, reception, entourage, program, guest details, gifts and more.</p></div>
        <div class="process-card"><span class="process-number">02</span><h3>Fill in the details</h3><p>Complete one short section at a time. See every answer appear beside you in your live invitation.</p></div>
        <div class="process-card"><span class="process-number">03</span><h3>Publish & share</h3><p>Review your website, create your free account, and get a link you can send to everyone you love.</p></div>
    </div>
</div></section>

<section class="value-section"><div class="wrap value-grid">
    <div>
        <span class="eyebrow">A kinder way to create</span>
        <h2>Every detail belongs. Only if you want it.</h2>
        <p>Traditional wedding invitations can miss important information. Our guided builder makes space for your entourage, family, venues, program, dress code, RSVP notes and guest questions — and gives you full control over which sections appear.</p>
        <ul class="value-checks">
            <li>Choose sections before answering questions</li>
            <li>Pick up your draft after refreshing or reopening the browser</li>
            <li>Keep your editor and live preview in one screen</li>
            <li>Choose your own link and download an invitation QR code</li>
            <li>Start free and publish without entering payment details</li>
        </ul>
    </div>
    <div class="value-visual" aria-hidden="true">
        <div class="value-screen">
            <div class="value-progress"><span></span><span></span><span></span></div>
            <div class="eyebrow">STEP 01 — YOUR INVITATION</div>
            <h3>What would you like to include?</h3>
            <div class="fake-section"><span>Wedding ceremony</span><b>✓</b></div>
            <div class="fake-section"><span>Reception & directions</span><b>✓</b></div>
            <div class="fake-section"><span>Our entourage</span><b>✓</b></div>
            <div class="fake-section"><span>Program & guest details</span><b>✓</b></div>
        </div>
    </div>
</div></section>

<section class="faq-section"><div class="wrap">
    <span class="eyebrow" style="color:#c8a06a">Good to know</span>
    <h2>Frequently asked questions</h2>
    <div class="faq-list">
        <details><summary>Can I create a wedding invitation website for free?</summary><p>Yes. The free website includes your shareable invitation page, wedding essentials, ceremony and reception details, and your chosen information sections.</p></details>
        <details><summary>Do I need to register before designing?</summary><p>No. Choose a template and personalize it first. You'll only need an account when you publish your invitation.</p></details>
        <details><summary>Will my work be saved if I close the tab?</summary><p>Yes, the builder saves your draft in this browser when storage is available. You can return and continue later. Drafts are cleared only when you cancel or successfully publish. Use the same browser and device.</p></details>
        <details><summary>Do you offer wedding RSVPs, video and printed invitations?</summary><p>These are planned premium features, but they are not yet available in this first release. The website invitation can be published for free now.</p></details>
    </div>
</div></section>

<section class="final-banner"><div class="wrap">
    <div><span class="eyebrow" style="color:#f7d2ad">Start something beautiful</span><h2>Make the invitation as memorable as the moment.</h2><p>Your beautiful free wedding website starts with a template.</p></div>
    @if(!$canCreate)
    <a class="btn" href="{{ url('/app/invitations') }}">Manage my invitation →</a>
    @elseif($featured)
    <a class="btn" href="{{ route('wedding.editor', $featured->slug) }}">Create my invitation →</a>
    @else
    <a class="btn" href="#templates">Explore templates →</a>
    @endif
</div></section>
</div>
@endsection

@push('scripts')
@if($featured && $canCreate)
<script>
(function () {
    try {
        const featured = @json($featured->slug);
        document.querySelectorAll('[data-resume-template]').forEach(function (link) {
            const saved = localStorage.getItem('wwyt:wedding:draft:v2:' + link.dataset.resumeTemplate);
            if (!saved) return;
            try {
                const draft = JSON.parse(saved);
                if (draft.version !== 2 || draft.template !== link.dataset.resumeTemplate) return;
                link.classList.add('is-visible');
                if (link.dataset.resumeTemplate === featured) {
                    const resume = document.getElementById('hero-resume');
                    if (resume) resume.hidden = false;
                }
            } catch (error) { /* An invalid draft is left untouched until cancelled. */ }
        });
    } catch (error) { /* Browser storage may be disabled. */ }
})();
</script>
@endif
<script type="application/ld+json">
{"@@context":"https://schema.org","@type":"WebApplication","name":"We Want You There","url":"https://wewantyouthere.com","applicationCategory":"LifestyleApplication","description":"A free wedding invitation website builder with templates, a guided questionnaire, and live previews.","offers":{"@type":"Offer","price":"0","priceCurrency":"PHP"}}
</script>
@endpush
