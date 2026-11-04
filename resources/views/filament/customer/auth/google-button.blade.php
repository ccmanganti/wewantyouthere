@php($isRegistering = request()->is('app/register'))
<div class="wwyt-auth-intro {{ $isRegistering ? 'wwyt-auth-intro--register' : 'wwyt-auth-intro--login' }}">
    <div class="wwyt-auth-top">
        <img class="wwyt-login-seal" src="{{ asset('brand/wwyt/seal-3d.png') }}"
            alt="" width="38" height="38">
        <span class="wwyt-auth-mini-label">YOUR INVITATION WORKSPACE</span>
        <a href="{{ route('home') }}" class="wwyt-auth-home-link">Back to home</a>
    </div>

    @if($isRegistering)
        <h2 class="wwyt-auth-tagline">A beautiful beginning.</h2>
        <p class="wwyt-auth-text">Create your free account to publish and manage your wedding invitation.</p>
    @else
        <p class="wwyt-auth-text">Manage your invitations, update details and keep every moment together.</p>
    @endif

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