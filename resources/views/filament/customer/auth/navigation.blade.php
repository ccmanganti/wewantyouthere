<header class="wwyt-auth-global-nav">
    <a href="{{ route('home') }}" class="wwyt-auth-nav-brand" aria-label="We Want You There homepage">
        <img src="{{ asset('branding/wwyt-horizontal-light.svg') }}" width="220" height="55" alt="We Want You There — Digital Invitations & RSVP">
    </a>
    <nav aria-label="Account page navigation" class="wwyt-auth-nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('marketing.templates') }}">Templates</a>
        <a href="{{ route('home') }}#how-it-works" class="wwyt-hide-mobile">How it works</a>
        @if(request()->is('app/register'))
            <a class="wwyt-auth-nav-cta" href="{{ url('/app/login') }}">Log in →</a>
        @else
            <a class="wwyt-auth-nav-cta" href="{{ url('/app/register') }}">Get started →</a>
        @endif
    </nav>
</header>