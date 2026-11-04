@extends('layouts.wwyt')
@section('title', ($mode === 'register' ? 'Create your account' : 'Welcome back') . ' | We Want You There')
@push('styles')
<style>.auth-shell{padding:65px 0}.auth-card{max-width:480px;margin:auto;padding:40px}.auth-card h1{font-size:40px;margin:8px 0}.auth-card p{color:var(--muted);margin-bottom:25px}.auth-card .btn{width:100%}.auth-card input{margin-top:2px}.auth-switch{text-align:center;margin-top:25px;font-size:13px}.auth-switch a{color:var(--green);font-weight:700}@media(max-width:580px){.auth-card{padding:26px 20px}}</style>
@endpush
@section('content')
<div class="auth-shell wrap"><div class="auth-card card">
    <span class="eyebrow">A little more magic</span><h1>{{ $mode === 'register' ? 'Save your invitation.' : 'Welcome back.' }}</h1>
    <p>{{ $mode === 'register' ? 'Create a free account to publish and keep your invitation safe.' : 'Log in to finish your wedding invitation.' }}</p>
    <form action="{{ $mode === 'register' ? route('wedding.register.submit') : route('wedding.login.submit') }}" method="POST">
        @csrf
        @if($mode === 'register')
            <div class="field"><label class="field-label" for="name">Your name</label><input id="name" name="name" required autocomplete="name" value="{{ old('name') }}" maxlength="120">@error('name')<div class="field-error">{{ $message }}</div>@enderror</div>
        @endif
        <div class="field"><label class="field-label" for="email">Email address</label><input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}">@error('email')<div class="field-error">{{ $message }}</div>@enderror</div>
        <div class="field"><label class="field-label" for="password">Password</label><input id="password" name="password" type="password" required autocomplete="{{ $mode === 'register' ? 'new-password' : 'current-password' }}" minlength="{{ $mode === 'register' ? '8' : '1' }}">@error('password')<div class="field-error">{{ $message }}</div>@enderror</div>
        @if($mode === 'register')
            <div class="field"><label class="field-label" for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"></div>
        @else
            <div class="field"><label><input type="checkbox" name="remember" value="1"> Remember me</label></div>
        @endif
        <button type="submit" class="btn">{{ $mode === 'register' ? 'Create account & publish →' : 'Log in & continue →' }}</button>
    </form>
    <div class="auth-switch">{{ $mode === 'register' ? 'Already have an account?' : 'New to We Want You There?' }} <a href="{{ $mode === 'register' ? route('login') : route('wedding.register') }}">{{ $mode === 'register' ? 'Log in' : 'Sign up free' }}</a></div>
</div></div>
@endsection
