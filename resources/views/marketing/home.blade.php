@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', 'Free Wedding Invitation Website Maker Philippines | We Want You There')
@section('meta_description', 'Create a free digital wedding invitation website in the Philippines. Choose a wedding template, edit details live, get a custom link and download a QR code. No design skills needed.')
@push('styles')
@include('marketing.partials.styles')
@endpush

@section('content')
<div class="mkt">
    @php($featured = $templates->first())
    <section class="mkt-hero" id="top">
        <div class="mkt-wrap mkt-hero-grid">
            <div class="mkt-hero-copy">
                <div class="mkt-kicker">THE NEXT BIG HOME FOR DIGITAL INVITATIONS</div>
                <h1 class="mkt-display">YOUR BIGGEST MOMENTS. <span class="mkt-serif">beautifully invited.</span></h1>
                <p><strong>Make your wedding invitation website for free.</strong> Choose an elegant design, tell your story, add your ceremony and entourage details, and share everything through one memorable link.</p>
                <div class="mkt-hero-actions">
                    @if(!$canCreate)
                        <a class="mkt-button light" href="{{ url('/app/invitations') }}">Manage my invitation <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                    @elseif($featured)
                        <a class="mkt-button light" href="{{ route('wedding.editor', $featured->slug) }}">Make my invitation <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                    @else
                        <a class="mkt-button light" href="{{ route('marketing.templates') }}">Browse wedding templates <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span></a>
                    @endif
                    <a class="mkt-button ghost-light" href="{{ route('marketing.templates') }}">See all templates <span aria-hidden="true"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span></a>
                    @if($featured && $canCreate)
                        <a class="mkt-button ghost-light" href="{{ route('wedding.editor', $featured->slug) }}"
                            data-draft-resume="{{ $featured->slug }}" hidden>Continue my draft <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    @endif
                </div>
                <div class="mkt-proof" aria-label="Platform highlights">
                    <span>Free to publish</span>
                    <span>Personalized URL and QR code</span>
                    <span>Made for Filipino celebrations</span>
                </div>
            </div>
            <div class="mkt-hero-art" aria-label="Preview of a full-page digital wedding invitation website">
                <div class="mkt-hero-orb" aria-hidden="true"></div>
                <div class="mkt-floating-words" aria-hidden="true">YOU'RE INVITED</div>
                <div class="mkt-pulse" aria-hidden="true"></div>
                <img class="mkt-hero-brandseal" src="{{ asset('brand/wwyt/seal-3d.png') }}" width="115" height="115" alt="" aria-hidden="true">
                <div class="mkt-mock-screen">
                    <div class="mkt-mock-browser">
                        <span class="dot"></span><span class="dot"></span><span class="dot"></span>
                        <span class="site-name">wewantyouthere.com/i/amelia-and-gabriel</span>
                    </div>
                    <div class="mkt-mock-invite">
                        <span class="mini-top">TOGETHER WITH OUR FAMILIES</span>
                        <span class="mini-names">Amelia<br><span class="mini-and">&</span><br>Gabriel</span>
                        <span class="mini-top">JOYFULLY INVITE YOU</span>
                        <span class="mini-date">December 12, 2027</span>
                        <span class="mini-bottom">THE GLASS GARDEN · PHILIPPINES</span>
                    </div>
                </div>
                <div class="mkt-float-tag one" aria-hidden="true">✦ &nbsp; Designed for the moments you never forget.<small>ONE LINK. EVERY DETAIL.</small></div>
                <div class="mkt-float-tag two" aria-hidden="true">you're invited.<small>with love, always</small></div>
            </div>
        </div>
    </section>

    <div class="mkt-ticker" aria-hidden="true"><div class="mkt-ticker-inner">
        <div class="mkt-ticker-copy"><span>WEDDING WEBSITE MAKER</span><span>DIGITAL INVITATIONS</span><span>LIVE PREVIEW</span><span>CUSTOM URL</span><span>FREE QR CODE</span></div>
        <div class="mkt-ticker-copy"><span>WEDDING WEBSITE MAKER</span><span>DIGITAL INVITATIONS</span><span>LIVE PREVIEW</span><span>CUSTOM URL</span><span>FREE QR CODE</span></div>
    </div></div>

    <section class="mkt-section" id="templates">
        <div class="mkt-wrap">
            <div class="mkt-section-head mkt-reveal">
                <div>
                    <div class="mkt-kicker red">THE INVITATION EDIT</div>
                    <h2>Pick a design.<br><span class="mkt-serif">Make it yours.</span></h2>
                </div>
                <div>
                    <p>Explore actual wedding website templates. Open the full preview before you decide, then personalize each section in the guided builder.</p>
                    <a href="{{ route('marketing.templates') }}" style="display:inline-block;margin-top:16px;color:#810100;font-size:12px;font-weight:800;text-decoration:underline;text-underline-offset:4px">Explore all wedding invitation templates <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="mkt-template-grid">
                @forelse($templates->take(3) as $template)
                    @include('marketing.partials.template-card', ['template' => $template, 'canCreate' => $canCreate])
                @empty
                    <div class="mkt-empty" style="grid-column:1/-1"><h3>First wedding design is being prepared.</h3><p>The Ever After template will show here once the WeddingBuilderSeeder has run.</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mkt-section mkt-process" id="how-it-works">
        <div class="mkt-wrap">
            <div class="mkt-section-head mkt-reveal">
                <div><div class="mkt-kicker">NO DESIGN SKILLS. NO COMPLICATED STEPS.</div>
                    <h2>Three steps from <span class="mkt-serif">yes</span><br>to <span class="mkt-serif">you're invited.</span></h2>
                </div>
                <p>No guessing what to write. Our wedding website maker guides you through the details, with the preview right beside you.</p>
            </div>
            <div class="mkt-process-grid">
                <article class="mkt-step mkt-reveal"><div class="number">01</div><h3>Choose your invitation</h3><p>Explore wedding website templates, preview a full working design and pick the one that feels like your celebration.</p></article>
                <article class="mkt-step mkt-reveal"><div class="number">02</div><h3>Tell us your details</h3><p>Choose the sections you need, add names, entourage, ninong and ninang, schedule, venues, dress code and more. See changes live.</p></article>
                <article class="mkt-step mkt-reveal"><div class="number">03</div><h3>Publish and share</h3><p>Create a free account, choose a personalized website URL and get a shareable invitation link with its own downloadable QR code.</p></article>
            </div>
            <svg class="mkt-journey-line mkt-line-reveal" viewBox="0 0 1000 48" aria-hidden="true" focusable="false" preserveAspectRatio="none">
                <path d="M10 24 C235 -7 280 57 502 24 S766 -8 990 24" fill="none" stroke="#BA9871" stroke-width="1.5" stroke-linecap="round" stroke-dasharray="7 10"/>
            </svg>
        </div>
    </section>

    <section class="mkt-section mkt-features" id="features">
        <div class="mkt-wrap mkt-feature-grid">
            <div class="mkt-reveal">
                <div class="mkt-kicker red">MORE THAN A PRETTY INVITATION</div>
                <h2 style="font-size:clamp(41px,5.7vw,73px);margin:14px 0 24px">Every detail.<br><span class="mkt-serif">Thoughtfully included.</span></h2>
                <p style="max-width:565px;font-size:14px;color:#6f625c;line-height:1.85">Your celebration is unique, so your invitation should be too. Make a mobile-friendly wedding website that guests can return to for the details they need.</p>
                <img src="{{ asset('brand/wwyt/logo-black.png') }}" alt="" loading="lazy" width="250" height="59" style="max-width:220px;height:auto;margin:4px 0 2px;opacity:.84" aria-hidden="true">
                <div class="mkt-feature-list">
                    <div class="mkt-feature"><span class="icon" aria-hidden="true"><i class="fa-solid fa-people-group" aria-hidden="true"></i></span><div><h3>Complete Filipino wedding details</h3><p>Ceremony, reception, entourage, principal sponsors, ninong and ninang, program and FAQs.</p></div></div>
                    <div class="mkt-feature"><span class="icon" aria-hidden="true"><i class="fa-solid fa-pen-ruler" aria-hidden="true"></i></span><div><h3>Live editor and website preview</h3><p>Answer one section at a time, show or hide parts and see edits reflected as you type.</p></div></div>
                    <div class="mkt-feature"><span class="icon" aria-hidden="true"><i class="fa-solid fa-qrcode" aria-hidden="true"></i></span><div><h3>One shareable URL and QR code</h3><p>Pick your own invitation link and download a QR code for sharing or printing.</p></div></div>
                    <div class="mkt-feature"><span class="icon" aria-hidden="true"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i></span><div><h3>Save progress and manage later</h3><p>Continue a draft in the same browser, then edit your published website from your account.</p></div></div>
                </div>
            </div>
            <div class="mkt-feature-visual mkt-reveal" aria-label="Illustration of the guided wedding invitation questionnaire">
                <div class="worksheet" aria-hidden="true">
                    <span class="label">YOUR INVITATION, YOUR WAY</span>
                    <h3>Let's make it personal.</h3>
                    <div class="fake-input">Partner 1 &nbsp; — &nbsp; Amelia</div>
                    <div class="fake-input">Partner 2 &nbsp; — &nbsp; Gabriel</div>
                    <div class="fake-input">Wedding date &nbsp; — &nbsp; December 12, 2027</div>
                    <div class="fake-input">Ceremony & entourage &nbsp; ✓</div>
                    <div class="fake-input">Reception & dress code &nbsp; ✓</div>
                    <div class="fake-btn">Preview my website <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </section>

    <section class="mkt-section" id="events" style="background:#e9e0d6">
        <div class="mkt-wrap">
            <div class="mkt-section-head mkt-reveal">
                <div><div class="mkt-kicker red">BIG DREAMS. EVERY KIND OF CELEBRATION.</div><h2>Made for the moments<br><span class="mkt-serif">worth showing up for.</span></h2></div>
                <p>We're starting with weddings and growing into more event invitation websites for Filipino families and celebrations.</p>
            </div>
            <div class="mkt-event-row">
                <a class="mkt-event mkt-reveal" href="{{ route('marketing.templates') }}"><span class="event-glyph" aria-hidden="true"><i class="fa-solid fa-heart" aria-hidden="true"></i></span><div><h3>Weddings</h3><p>Explore designs now <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></p></div></a>
                <div class="mkt-event soon mkt-reveal"><span class="event-glyph" aria-hidden="true"><i class="fa-solid fa-crown" aria-hidden="true"></i></span><div><h3>Debuts</h3><p>18 roses, candles and treasures</p><span class="soon-label">COMING SOON</span></div></div>
                <div class="mkt-event soon mkt-reveal"><span class="event-glyph" aria-hidden="true"><i class="fa-solid fa-cake-candles" aria-hidden="true"></i></span><div><h3>Birthdays</h3><p>Every age, every milestone</p><span class="soon-label">COMING SOON</span></div></div>
                <div class="mkt-event soon mkt-reveal"><span class="event-glyph" aria-hidden="true"><i class="fa-solid fa-baby" aria-hidden="true"></i></span><div><h3>Christenings</h3><p>Families, ninong and ninang</p><span class="soon-label">COMING SOON</span></div></div>
            </div>
        </div>
    </section>

    <section class="mkt-section mkt-price" id="pricing">
        <div class="mkt-wrap mkt-price-grid">
            <div class="mkt-reveal">
                <div class="mkt-kicker" style="color:#e6c299">THE CELEBRATION COMES FIRST</div>
                <h2>YOUR INVITATION<br><span class="mkt-serif">starts free.</span></h2>
                <p>Design and publish a wedding invitation website without entering payment details. Premium tools and additional invitation formats are planned for later.</p>
            </div>
            <div class="mkt-free-card mkt-reveal">
                <span class="mkt-pill">FREE PLAN — AVAILABLE NOW</span>
                <h3 style="font:35px 'DM Serif Display',serif;margin:13px 0 0">Your first wedding website</h3>
                <div class="free-price">₱0</div>
                <ul>
                    <li>One published wedding invitation website per free account</li>
                    <li>Guided questions, live editing and section visibility</li>
                    <li>Custom invitation URL and downloadable QR code</li>
                    <li>Manage and update your wedding details later</li>
                </ul>
                @if(!$canCreate)
                    <a class="mkt-button" href="{{ url('/app/invitations') }}">Manage my website <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                @elseif($featured)
                    <a class="mkt-button" href="{{ route('wedding.editor', $featured->slug) }}">Start creating free <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                @else
                    <a class="mkt-button" href="{{ route('marketing.templates') }}">Browse wedding templates <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                @endif
                <div style="margin-top:15px;font-size:11px;color:#796c65">Premium RSVP dashboards, personalized guest QR codes, printed and video invitations are being developed.</div>
            </div>
        </div>
    </section>

    <section class="mkt-section mkt-faq" id="faq">
        <div class="mkt-wrap mkt-faq-layout">
            <div class="mkt-reveal"><div class="mkt-kicker red">GOOD TO KNOW</div><h2>Questions?<br><span class="mkt-serif">We got you.</span></h2></div>
            <div class="mkt-faq-list mkt-reveal">
                <details><summary>Is the wedding invitation website maker really free?</summary><p>Yes. One wedding website per free account, with a guided editor, shareable link, and a downloadable QR code. No payment details are needed for free publishing.</p></details>
                <details><summary>Can I add ninong, ninang, entourage and my wedding program?</summary><p>Yes. The wedding form includes Filipino wedding details such as principal sponsors, bridesmaids, groomsmen, ceremony and reception venues, guest notes, dress code and the program. You choose which sections appear.</p></details>
                <details><summary>Can I preview the wedding website before signing up?</summary><p>Yes. Explore a full sample website, choose a template and customize it first. Registration is requested when you're ready to publish.</p></details>
                <details><summary>Can I change the website after it's published?</summary><p>Yes. Sign in and use My Invitations to edit details, update the link or unpublish the website. Previous links redirect when you change your invitation URL.</p></details>
                <details><summary>Are online RSVP tracking and printed or video invitations included?</summary><p>Not yet. Those premium features are on the roadmap. Free website publishing, custom link, and basic downloadable QR code are available in this release.</p></details>
                <details><summary>Do I need to download an app?</summary><p>No. Build and share your invitation using your web browser. Guests open your wedding website using its link or QR code.</p></details>
            </div>
        </div>
    </section>

    <section class="mkt-last">
        <div class="mkt-wrap">
            <div><div class="mkt-kicker">THIS IS YOUR INVITATION TO BEGIN</div>
                <h2>BIG MOMENTS. <span class="mkt-serif">one beautiful link.</span></h2>
                <p>Let's make a wedding invitation your guests will be excited to open.</p>
            </div>
            <a class="mkt-button light" href="{{ !$canCreate ? url('/app/invitations') : route('marketing.templates') }}">{{ !$canCreate ? 'Manage my invitation' : 'Explore invitation templates' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </section>
    @include('marketing.partials.preview-dialog')
</div>
@endsection
@push('scripts')
@include('marketing.partials.seo-data')
@include('marketing.partials.interactions')
@endpush