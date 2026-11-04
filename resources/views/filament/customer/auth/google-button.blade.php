<div class="wwyt-auth-intro">
    <div class="wwyt-auth-top">
        <span class="wwyt-auth-mini-label">WE WANT YOU THERE <span>✦</span> YOUR CELEBRATION HUB</span>
        <a href="{{ route('home') }}" class="wwyt-auth-home-link">← Back to home</a>
    </div>

    <img class="wwyt-login-seal" src="{{ asset('brand/wwyt/seal-3d.png') }}" alt="We Want You There wax seal" width="70" height="70">

    <h2 class="wwyt-auth-tagline">
        {{ request()->is('app/register') ? 'A beautiful beginning.' : 'Your celebration continues here.' }}
    </h2>
    <p class="wwyt-auth-text">
        {{ request()->is('app/register')
            ? 'Create your free account to save, publish and manage a wedding invitation website worth sharing.'
            : 'Sign in to manage your invitation website, update details and share every meaningful moment.' }}
    </p>

    @if($errors->has('google'))
        <div class="wwyt-auth-error" role="alert">{{ $errors->first('google') }}</div>
    @endif

    @if(filled(config('services.google.client_id')) && filled(config('services.google.client_secret')))
        <a href="{{ route('auth.google.redirect') }}" class="wwyt-google-button">
            <i class="fa-brands fa-google wwyt-google-icon" aria-hidden="true"></i>
            Continue with Google
        </a>
    @else
        <p class="wwyt-auth-google-note">Email sign-in is available now. Google sign-in will appear here once it is configured.</p>
    @endif

    <div class="wwyt-auth-divider"><span>OR CONTINUE WITH EMAIL</span></div>
</div>