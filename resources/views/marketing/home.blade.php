@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', 'Free Wedding Invitation Website Philippines | We Want You There')
@section('meta_description', 'Create a free wedding invitation website in the Philippines. Try online invitation templates with real photo previews, share a custom link and QR code, and unlock optional premium RSVP and maps.')
@push('styles')
@include('marketing.partials.styles')
@endpush

@section('content')
<div class="mkt">
    @php($featured = $templates->first())
    <section class="mkt-hero" id="top">
        <div class="mkt-wrap mkt-hero-grid">
            <div class="mkt-hero-copy">
                <div class="mkt-kicker">WE WANT YOU THERE · FREE ONLINE INVITATION MAKER PHILIPPINES</div>
                <h1 class="mkt-display">FREE WEDDING INVITATION WEBSITE. <span class="mkt-serif">Made for your forever.</span></h1>
                <p><strong>Make a free website invitation for your wedding in the Philippines.</strong> Our online wedding invitation maker helps you choose a real-photo design, add names, wedding date, venue and photos, and publish a mobile-friendly digital invitation with a personal link and QR code. No coding, no printing, and no payment to publish a basic invitation. Upgrade only for RSVP email alerts, Google Maps, a wedding programme, entourage or video.</p>
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
                    <span>No app download needed</span>
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
                        <img class="mkt-hero-couple-photo" src="{{ config('wedding_sample_photos.portrait_one') }}" width="320" height="150" loading="eager" fetchpriority="high" alt="Sample wedding couple portrait in an online invitation design"><span class="mini-date">December 12, 2027</span>
                        <span class="mini-bottom">THE GLASS GARDEN · PHILIPPINES</span>
                    </div>
                </div>
                <div class="mkt-float-tag one" aria-hidden="true">✦ &nbsp; Designed for the moments you never forget.<small>ONE LINK. EVERY DETAIL.</small></div>
                <div class="mkt-float-tag two" aria-hidden="true">you're invited.<small>with love, always</small></div>
            </div>
        </div>
    </section>

    <div class="mkt-ticker" aria-hidden="true"><div class="mkt-ticker-inner">
        <div class="mkt-ticker-copy"><span>FREE WEDDING WEBSITE PHILIPPINES</span><span>DIGITAL WEDDING INVITATION</span><span>ONLINE INVITATION MAKER</span><span>CUSTOM URL</span><span>FREE QR CODE</span></div>
        <div class="mkt-ticker-copy"><span>FREE WEDDING WEBSITE PHILIPPINES</span><span>DIGITAL WEDDING INVITATION</span><span>ONLINE INVITATION MAKER</span><span>CUSTOM URL</span><span>FREE QR CODE</span></div>
    </div></div>

    <section class="mkt-section mkt-sample-showcase" id="sample-invitations" aria-labelledby="sample-invitations-title">
        <div class="mkt-wrap">
            <div class="mkt-section-head mkt-reveal">
                <div>
                    <div class="mkt-kicker red">ACTUAL PHOTOGRAPHY · INTERACTIVE DESIGN PREVIEWS</div>
                    <h2 id="sample-invitations-title">See your invitation <span class="mkt-serif">come to life.</span></h2>
                </div>
                <p>Explore examples of a digital wedding invitation with photographs, romantic cover sections, and a mobile-friendly layout. These use licensed sample photos—not real customer invitations.</p>
            </div>
            <div class="mkt-sample-photo-grid">
                @foreach([
                    ['portrait_one', 'The romantic cover', 'A personal website with your names, date and favorite portrait.'],
                    ['story_one', 'Your story in photos', 'Share engagement and prenup photos as part of your invitation.'],
                    ['gallery_three', 'Memories worth sharing', 'An elegant invitation guests can revisit from their phone.'],
                ] as [$slot, $label, $description])
                    <article class="mkt-sample-photo-card">
                        <div class="mkt-sample-photo-frame">
                            <img src="{{ config('wedding_sample_photos.' . $slot) }}" loading="lazy" decoding="async"
                                alt="{{ $label }} — sample wedding couple photograph in a digital wedding invitation" width="500" height="380">
                            <span>SAMPLE PHOTO · INVITATION DESIGN</span>
                        </div>
                        <div class="mkt-sample-photo-copy">
                            <h3>{{ $label }}</h3>
                            <p>{{ $description }}</p>
                            @if($featured)
                                <button type="button" data-preview-open
                                    data-preview-url="{{ route('marketing.templatePreview', $featured->slug) }}"
                                    data-preview-title="{{ $featured->name }}">
                                    Open working invitation preview <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mkt-section" id="templates">
        <div class="mkt-wrap">
            <div class="mkt-section-head mkt-reveal">
                <div>
                    <div class="mkt-kicker red">DIGITAL WEDDING INVITATION TEMPLATES</div>
                    <h2>Wedding website templates.<br><span class="mkt-serif">Make one yours.</span></h2>
                </div>
                <div>
                    <p>Browse working digital invitation designs with real sample couple photos and an interactive preview. Customize online without coding or graphic design skills.</p>
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
                <p>Make a free online wedding invitation in three steps, then send the link via Messenger or Viber. The live preview updates as you type.</p>
            </div>
            <div class="mkt-process-grid">
                <article class="mkt-step mkt-reveal"><div class="number">01</div><h3>Choose your invitation</h3><p>Explore wedding website templates, preview a full working design and pick the one that feels like your celebration.</p></article>
                <article class="mkt-step mkt-reveal"><div class="number">02</div><h3>Tell us your details</h3><p>Enter your names, date, venue, personal message and photos. Maps, RSVP, programme and entourage are optional premium sections.</p></article>
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
                    <div class="fake-input">Bride &nbsp; — &nbsp; Amelia</div>
                    <div class="fake-input">Groom &nbsp; — &nbsp; Gabriel</div>
                    <div class="fake-input">Wedding date &nbsp; — &nbsp; December 12, 2027</div>
                    <div class="fake-input">Ceremony &nbsp; — &nbsp; Garden Chapel</div>
                    <div class="fake-input">Dress code &nbsp; — &nbsp; Formal garden</div>
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
                <p>Create and publish a basic wedding website for free. Upgrade later for RSVP email alerts, Google Maps, an embedded video, the programme, entourage or extended ceremony details.</p>
            </div>
            <div class="mkt-free-card mkt-reveal">
                <span class="mkt-pill">FREE PLAN — AVAILABLE NOW</span>
                <h3 style="font:35px 'DM Serif Display',serif;margin:13px 0 0">Your first wedding website</h3>
                <div class="free-price">₱0</div>
                <ul>
                    <li>One basic wedding invitation website per free account</li>
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
                <div style="margin-top:15px;font-size:11px;color:#796c65">Google Maps, RSVP email alerts, embedded video, programme, entourage and extended ceremony details are premium upgrades.</div>
                @if($featured)
                    <p style="font-size:11px;color:#725d51">Optional premium upgrade for {{ $featured->name }}: <strong>{{ \App\Support\InvitationPremium::price($featured) }}</strong> one-time. <a href="{{ route('premium.show', $featured->slug) }}" style="text-decoration:underline">Compare what's included</a>.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="mkt-section mkt-faq" id="faq">
        <div class="mkt-wrap mkt-faq-layout">
            <div class="mkt-reveal"><div class="mkt-kicker red">GOOD TO KNOW</div><h2>Questions?<br><span class="mkt-serif">We got you.</span></h2></div>
            <div class="mkt-faq-list mkt-reveal">
                <details><summary>Is the wedding invitation website maker really free?</summary><p>Yes. One wedding website per free account, with a guided editor, shareable link, and a downloadable QR code. No payment details are needed for free publishing.</p></details>
                <details><summary>Can I add my ninong, ninang, entourage and wedding programme?</summary><p>Yes. Those sections are available with a premium upgrade. Free invitations include essential names, date, venue, message and photos.</p></details>
                <details><summary>Can I preview the wedding website before signing up?</summary><p>Yes. Explore a full sample website, choose a template and customize it first. Registration is requested when you're ready to publish.</p></details>
                <details><summary>Can I change the website after it's published?</summary><p>Yes. Sign in and use My Invitations to edit details, update the link or unpublish the website. Previous links redirect when you change your invitation URL.</p></details>
                <details><summary>Are Google Maps, RSVP and video included for free?</summary><p>They are premium options. RSVP includes email notifications to the invitation owner; video supports YouTube and Vimeo embeds. Printed and animated invitation exports are not yet available.</p></details>
                <details><summary>Where can I create a free wedding invitation website in the Philippines?</summary><p>We Want You There is a free online wedding website maker. Start with an editable digital invitation template, add your basic details and sample photos, then share your website link and QR code. Premium sections are optional.</p></details>
                <details><summary>Can I make an invitation without signing up first?</summary><p>You can try the template and save changes in your current browser first. You will need a free account to publish your invitation or purchase premium features.</p></details>
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