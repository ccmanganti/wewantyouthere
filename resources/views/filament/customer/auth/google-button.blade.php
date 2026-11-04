<div class="wwyt-auth-intro">
    <div class="wwyt-auth-top">
        <span class="wwyt-auth-mini-label">WE WANT YOU THERE <span>✦</span> YOUR CELEBRATION HUB</span>
        <a href="{{ route('home') }}" class="wwyt-auth-home-link">← Back to home</a>
    </div>

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
            <svg width="20" height="20" viewBox="0 0 48 48" aria-hidden="true">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.25 5.48-4.76 7.18l7.73 6C44.42 38.05 46.98 31.95 46.98 24.55z"/>
                <path fill="#FBBC05" d="M10.53 28.59A14.45 14.45 0 0 1 9.75 24c0-1.6.27-3.15.76-4.59l-7.98-6.2A24 24 0 0 0 0 24c0 3.86.93 7.5 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.9-5.8l-7.72-6c-2.15 1.44-4.91 2.3-8.18 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.2C6.5 42.62 14.61 48 24 48z"/>
            </svg>
            Continue with Google
        </a>
    @else
        <p class="wwyt-auth-google-note">Email sign-in is available now. Google sign-in will appear here once it is configured.</p>
    @endif

    <div class="wwyt-auth-divider"><span>OR CONTINUE WITH EMAIL</span></div>
</div>