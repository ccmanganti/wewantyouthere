<x-filament-widgets::widget>
@php
    $owner = auth()->user();
    $site = $owner->invitationWebsites()->with('template')->latest()->first();
    $siteCount = $owner->invitationWebsites()->count();
    $remaining = \App\Support\InvitationAccounts::remainingSites($owner);
    $firstName = trim(explode(' ', trim($owner->name))[0] ?? 'there');
    $hasSite = (bool) $site;
@endphp
<style>
.wwyt-dashboard{color:#1B1717;max-width:1450px;margin:0 auto}
.wwyt-dashboard *{box-sizing:border-box}
.wwyt-dashboard a{text-decoration:none}
.wwyt-dash-kicker{font:800 10px/1.4 'DM Sans',sans-serif;letter-spacing:.19em;color:#8e3d40;text-transform:uppercase}
.wwyt-dash-breadcrumb{display:flex;align-items:center;gap:8px;margin:-10px 0 23px;font-size:11px;font-weight:700;color:#88716a;flex-wrap:wrap}
.wwyt-dash-breadcrumb a{color:#810100}.wwyt-dash-breadcrumb a:hover{text-decoration:underline}
.wwyt-dash-hero{position:relative;isolation:isolate;overflow:hidden;border-radius:19px;background:
radial-gradient(ellipse at 92% 24%,#86080c88 0%,transparent 37%),linear-gradient(111deg,#1B1717 0%,#250d0e 57%,#630000 100%);
color:#EDEBDD;padding:clamp(27px,4.5vw,55px);min-height:315px;display:flex;align-items:center;border:1px solid #6a2d2a}
.wwyt-dash-hero::before{content:'';position:absolute;inset:18px;border:1px solid #a37a5144;border-radius:12px;pointer-events:none}
.wwyt-dash-hero::after{content:'';position:absolute;width:450px;height:450px;border:1px solid #d1ae7845;border-radius:50%;right:-116px;top:-145px;pointer-events:none}
.wwyt-dash-hero-inner{position:relative;z-index:2;max-width:720px}
.wwyt-dash-hero .wwyt-dash-kicker{color:#d9b28d}
.wwyt-dash-hero h2{font:400 clamp(32px,4.3vw,58px)/1.08 Georgia,serif;letter-spacing:-.055em;max-width:800px;margin:13px 0 15px}
.wwyt-dash-hero h2 i{font-weight:400;color:#e2b9a9}
.wwyt-dash-hero p{font-size:13px;line-height:1.9;color:#e2ccc4;max-width:560px;margin:0 0 24px}
.wwyt-dash-hero-actions{display:flex;gap:11px;align-items:center;flex-wrap:wrap}
.wwyt-dash-button{min-height:43px;display:inline-flex;gap:9px;align-items:center;justify-content:center;padding:11px 18px;border-radius:7px;font:800 12px 'DM Sans',sans-serif;white-space:nowrap;transition:background .18s,transform .18s}
.wwyt-dash-button:hover{transform:translateY(-2px)}
.wwyt-dash-button.primary{background:#810100;color:#fff!important;border:1px solid #9d3034}
.wwyt-dash-button.primary:hover{background:#a21b24}
.wwyt-dash-button.ghost{background:transparent;color:#EDEBDD!important;border:1px solid #a48b80}
.wwyt-dash-button.ghost:hover{background:#ffffff17}
.wwyt-dash-hero-seal{position:absolute;right:clamp(12px,3.3vw,52px);top:50%;transform:translateY(-50%) rotate(8deg);height:clamp(155px,22vw,300px);width:clamp(155px,22vw,300px);opacity:.92;pointer-events:none;z-index:1;filter:drop-shadow(0 10px 30px #05010255)}
.wwyt-dash-divider{margin:25px 0 23px;width:100%;height:1px;background:linear-gradient(90deg,#810100,#bf9b66 30%,transparent 90%)}
.wwyt-dash-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin:20px 0 0}
.wwyt-dash-stat{background:#fffefa;border:1px solid #dcc9bd;border-radius:11px;padding:20px 22px;min-width:0}
.wwyt-dash-stat .eyebrow{font-size:10px;letter-spacing:.15em;text-transform:uppercase;color:#826a60;font-weight:800;display:block}
.wwyt-dash-stat .value{font:400 36px/1.1 Georgia,serif;color:#630000;display:block;margin:13px 0 2px}
.wwyt-dash-stat .description{font-size:11px;color:#80716b;line-height:1.6}
.wwyt-dash-main{margin-top:26px;display:grid;grid-template-columns:minmax(0,1.3fr) minmax(280px,.7fr);gap:18px}
.wwyt-dash-panel{background:#fffefa;border:1px solid #dcc9bd;border-radius:14px;overflow:hidden}
.wwyt-dash-panel-head{padding:24px 26px 19px;display:flex;align-items:center;justify-content:space-between;gap:14px;border-bottom:1px solid #ede1d8}
.wwyt-dash-panel-head h3{font:400 29px/1.14 Georgia,serif;letter-spacing:-.04em;margin:6px 0 0;color:#1B1717}
.wwyt-dash-panel-head a{color:#810100;font-size:11px;font-weight:800;white-space:nowrap}
.wwyt-dash-panel-head a:hover{text-decoration:underline}
.wwyt-dash-invitation{padding:25px;display:grid;grid-template-columns:minmax(190px,.75fr) minmax(180px,1fr);gap:28px;align-items:center}
.wwyt-dash-invite-preview{position:relative;min-height:235px;display:grid;place-items:center;padding:22px 10px;background:#f1efe6;border:7px solid #1B1717;box-shadow:8px 8px 0 #a29080}
.wwyt-dash-invite-preview:before{content:"✤";position:absolute;right:0;top:-40px;font:140px Georgia,serif;color:#bbbc9c52}
.wwyt-dash-preview-content{position:relative;text-align:center;min-width:0;max-width:100%}
.wwyt-dash-preview-content span{display:block;font-size:8px;font-weight:800;letter-spacing:.12em;color:#69725b}
.wwyt-dash-preview-content strong{font:italic clamp(20px,2.6vw,38px)/1.2 Georgia,serif;color:#456349;display:block;overflow-wrap:anywhere;margin:17px 0}
.wwyt-dash-invite-meta .wwyt-pill{display:inline-flex;align-items:center;border:1px solid #cba5a0;border-radius:99px;padding:4px 10px;font-size:10px;color:#810100;font-weight:800;margin-bottom:13px}
.wwyt-dash-invite-meta h4{font:400 clamp(23px,2.3vw,34px)/1.1 Georgia,serif;letter-spacing:-.03em;margin:0 0 11px;color:#261c1d}
.wwyt-dash-invite-meta p{color:#756c68;font-size:12px;line-height:1.85;overflow-wrap:anywhere;margin:0 0 14px}
.wwyt-dash-invite-meta .links{display:flex;gap:8px;flex-wrap:wrap}
.wwyt-dash-invite-meta .links a{font-size:11px;font-weight:800;padding:10px 12px;border:1px solid #ad9589;border-radius:7px;color:#630000}
.wwyt-dash-invite-meta .links a:first-child{background:#810100;border-color:#810100;color:#fff}
.wwyt-dash-invite-meta .links a:hover{background:#f9e4df}
.wwyt-dash-invite-meta .links a:first-child:hover{background:#630000}
.wwyt-dash-empty{padding:30px 27px;text-align:left}
.wwyt-dash-empty img{width:85px;height:85px}
.wwyt-dash-empty h4{font:28px Georgia,serif;margin:14px 0 9px}
.wwyt-dash-empty p{font-size:13px;color:#6c605c;line-height:1.8;max-width:560px}
.wwyt-dash-quick{padding:12px 17px}
.wwyt-dash-quick a{display:flex;justify-content:space-between;align-items:center;gap:9px;padding:15px 12px;border-radius:8px;color:#332829!important;border-bottom:1px solid #e9dcd3;text-decoration:none}
.wwyt-dash-quick a:last-child{border-bottom:0}
.wwyt-dash-quick a:hover{background:#f7ece7}
.wwyt-dash-quick a strong{font-size:12px;display:block}
.wwyt-dash-quick a small{font-size:10px;color:#877772;display:block;margin-top:4px}
.wwyt-dash-quick .arrow{color:#810100;font-size:18px}
.wwyt-dash-bottom{padding:22px 25px;border:1px solid #d7c0ad;background:#EDEBDD;border-radius:12px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:18px}
.wwyt-dash-bottom img{width:43px;height:43px;flex:none}
.wwyt-dash-bottom strong{font:italic 18px Georgia,serif;color:#630000}
.wwyt-dash-bottom p{font-size:11px;margin:4px 0 0;color:#78675e}
.wwyt-dash-bottom a{color:#810100;font-size:12px;font-weight:800;text-decoration:underline}
@media(max-width:1100px){.wwyt-dash-main{grid-template-columns:1fr}.wwyt-dash-hero-seal{opacity:.33;right:-36px}}
@media(max-width:680px){
 .wwyt-dash-hero{min-height:270px}
 .wwyt-dash-hero-seal{width:210px;height:210px;opacity:.20;right:-65px}
 .wwyt-dash-stats{grid-template-columns:1fr 1fr}
 .wwyt-dash-stats .wwyt-dash-stat:last-child{grid-column:1/-1}
 .wwyt-dash-invitation{grid-template-columns:1fr}
 .wwyt-dash-invite-preview{max-width:330px}
 .wwyt-dash-panel-head{padding:20px}
 .wwyt-dash-quick{padding:10px}
}
@media(prefers-reduced-motion:reduce){.wwyt-dash-button{transition:none}}
</style>
<div class="wwyt-dashboard">
    <nav class="wwyt-dash-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">We Want You There</a><span>/</span><span>My Workspace</span>
    </nav>

    <section class="wwyt-dash-hero" aria-label="Invitation workspace welcome">
        <div class="wwyt-dash-hero-inner">
            <span class="wwyt-dash-kicker">YOUR CELEBRATION STUDIO · PERSONAL WORKSPACE</span>
            <h2>Welcome back, {{ $firstName }}.<br><i>Let's make it memorable.</i></h2>
            <p>{{ $hasSite ? 'Your invitation website is part of something special. Keep your wedding details up to date, share your link and make every guest feel invited.' : 'Every great celebration begins with one invitation. Choose your design, make it yours and share your story with the people who matter most.' }}</p>
            <div class="wwyt-dash-hero-actions">
                @if($site)
                    <a class="wwyt-dash-button primary" href="{{ url('/app/invitations') }}">Manage my website <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                    @if($site->status === 'published')
                        <a class="wwyt-dash-button ghost" href="{{ route('wedding.show', $site->slug) }}" target="_blank" rel="noopener">View live website <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                    @endif
                @elseif($remaining === null || $remaining > 0)
                    <a class="wwyt-dash-button primary" href="{{ route('marketing.templates') }}">Explore templates <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                @endif
            </div>
        </div>
        <img class="wwyt-dash-hero-seal" src="{{ asset('brand/wwyt/seal-3d.png') }}" alt="" width="280" height="280">
    </section>

    <div class="wwyt-dash-stats" aria-label="Account statistics">
        <div class="wwyt-dash-stat"><span class="eyebrow">My invitation websites</span><strong class="value">{{ $siteCount }}</strong><span class="description">Website{{ $siteCount === 1 ? '' : 's' }} created</span></div>
        <div class="wwyt-dash-stat"><span class="eyebrow">Available website slots</span><strong class="value">{{ $remaining === null ? '∞' : $remaining }}</strong><span class="description">Free plan includes one website</span></div>
        <div class="wwyt-dash-stat"><span class="eyebrow">Account membership</span><strong class="value" style="font-size:30px">{{ ucfirst($owner->account_tier ?? 'free') }}</strong><span class="description">Review your account in Plan & Billing</span></div>
    </div>

    <div class="wwyt-dash-main">
        <section class="wwyt-dash-panel">
            <div class="wwyt-dash-panel-head">
                <div><span class="wwyt-dash-kicker">YOUR WEBSITE</span><h3>{{ $hasSite ? 'Your invitation, ready to share.' : 'Create something beautiful.' }}</h3></div>
                <a href="{{ $hasSite ? url('/app/invitations') : route('marketing.templates') }}">View {{ $hasSite ? 'my invitations' : 'templates' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            @if($site)
                <div class="wwyt-dash-invitation">
                    <div class="wwyt-dash-invite-preview" aria-label="Preview of your invitation">
                        <div class="wwyt-dash-preview-content"><span>TOGETHER WITH OUR FAMILIES</span>
                            <strong>{{ $site->answers['bride_name'] ?? 'Your' }} &amp; {{ $site->answers['groom_name'] ?? 'Wedding' }}</strong>
                            <span>YOU'RE INVITED</span>
                        </div>
                    </div>
                    <div class="wwyt-dash-invite-meta">
                        <span class="wwyt-pill">{{ ucfirst($site->status) }}</span>
                        <h4>{{ $site->name }}</h4>
                        <p>wewantyouthere.com/i/{{ $site->slug }}</p>
                        <div class="links">
                            <a href="{{ url('/app/invitations') }}">Edit & manage <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                            @if($site->status === 'published')
                                <a href="{{ route('wedding.show', $site->slug) }}" target="_blank" rel="noopener">Open website <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="wwyt-dash-empty">
                    <img src="{{ asset('brand/wwyt/seal-outline.png') }}" width="85" height="85" alt="">
                    <h4>Your first invitation starts here.</h4>
                    <p>Explore the wedding template collection and create your website in a guided step-by-step builder.</p>
                    <a href="{{ route('marketing.templates') }}" class="wwyt-dash-button primary">Browse wedding templates <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            @endif
        </section>

        <aside class="wwyt-dash-panel">
            <div class="wwyt-dash-panel-head"><div><span class="wwyt-dash-kicker">EASY ACCESS</span><h3>Quick actions.</h3></div></div>
            <div class="wwyt-dash-quick">
                <a href="{{ url('/app/invitations') }}"><span><strong>My Invitations</strong><small>Edit, view or remove your website</small></span><span class="arrow"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span></a>
                <a href="{{ route('marketing.templates') }}"><span><strong>Explore Designs</strong><small>Browse all available templates</small></span><span class="arrow"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span></a>
                <a href="{{ url('/app/profile') }}"><span><strong>Profile Settings</strong><small>Manage your account information</small></span><span class="arrow"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span></a>
                <a href="{{ url('/app/billing') }}"><span><strong>Plan & Billing</strong><small>See your current website allowance</small></span><span class="arrow"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span></a>
                <a href="{{ route('home') }}"><span><strong>Back to Website</strong><small>Return to We Want You There</small></span><span class="arrow"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></span></a>
            </div>
        </aside>
    </div>

    <div class="wwyt-dash-bottom">
        <img src="{{ asset('brand/wwyt/seal-outline.png') }}" alt="" width="43" height="43">
        <div><strong>The best moments are shared.</strong><p>A little invitation can bring everyone together. Made with love, We Want You There.</p></div>
        <a href="{{ route('marketing.templates') }}">Discover designs <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    </div>
</div>
</x-filament-widgets::widget>