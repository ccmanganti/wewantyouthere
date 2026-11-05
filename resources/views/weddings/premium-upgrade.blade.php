@extends('layouts.wwyt')
@section('title', 'Upgrade Your Invitation | We Want You There')
@section('meta_description', 'Upgrade your invitation with interactive maps, email RSVP alerts, video, programme, entourage, and ceremony details.')
@section('robots', 'noindex,nofollow')
@push('styles')
<style>
.upgrade{width:min(1050px,calc(100% - 36px));margin:56px auto 80px;display:grid;grid-template-columns:1.4fr .8fr;gap:26px;align-items:start}
.upgrade-panel{background:#fffdf9;border:1px solid #e7d4c9;border-radius:18px;padding:clamp(22px,4vw,40px);box-shadow:0 14px 42px #27141813}
.upgrade-kicker{font-size:11px;letter-spacing:.18em;color:#963343;font-weight:800;text-transform:uppercase}
.upgrade h1{font-size:clamp(35px,5vw,55px);margin:12px 0}.upgrade p{color:#71605c;font-size:13px;line-height:1.8}
.upgrade-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;margin-top:23px}
.upgrade-feature{padding:14px;border:1px solid #e8d8cd;border-radius:12px;background:#fcf6f1}
.upgrade-feature i{color:#9b3845;font-size:19px}.upgrade-feature strong{display:block;margin:8px 0 4px;font-size:13px}.upgrade-feature span{font-size:11px;color:#7d6d66}
.upgrade-side{position:sticky;top:110px}.upgrade-price{font:48px 'DM Serif Display',serif;color:#5e1b26;margin:12px 0}
.upgrade-side .btn{display:flex;width:100%;margin:13px 0 10px;text-align:center}
.upgrade-message{font-size:12px;color:#77584f;background:#f9ede6;padding:14px;border-radius:10px}
.upgrade-continue{color:#752e3a;font-size:12px;font-weight:800;text-decoration:underline;text-underline-offset:3px}
@media(max-width:760px){.upgrade{grid-template-columns:1fr}.upgrade-grid{grid-template-columns:1fr}.upgrade-side{position:static}}
</style>
@endpush
@section('content')
<div class="upgrade">
 <section class="upgrade-panel">
   <div class="upgrade-kicker">We Want You There · Premium</div>
   <h1>A little more magic for your invitation.</h1>
   <p>Keep your free invitation simple, or unlock every special detail for <strong>{{ $template->name }}</strong>. Premium is a one-time upgrade, not a recurring subscription.</p>
   <div class="upgrade-grid">
   @foreach($features as $feature)
      <div class="upgrade-feature">
       <i class="fa-solid {{ $feature['icon'] }}" aria-hidden="true"></i>
       <strong>{{ $feature['name'] }}</strong>
       <span>{{ $feature['detail'] }}</span>
      </div>
   @endforeach
   </div>
 </section>
 <aside class="upgrade-panel upgrade-side">
   <div class="upgrade-kicker">Your template</div>
   <h2>{{ $template->name }}</h2>
   <div class="upgrade-price">{{ \App\Support\InvitationPremium::price($template) }}</div>
   <p>One-time premium access for this invitation design.</p>
   @if($hasPremium)
    <div class="upgrade-message" role="status"><i class="fa-solid fa-circle-check"></i> Premium is active on your account.</div>
    <a class="btn" href="{{ route('wedding.editor', $template->slug) }}">Continue editing</a>
   @elseif(!auth()->check())
    <div class="upgrade-message">Sign in or create an account to purchase safely. Your current invitation draft is saved in this browser.</div>
    <a class="btn" href="{{ url('/app/login') }}">Log in to upgrade</a>
    <a class="btn btn-light" href="{{ url('/app/register') }}">Create free account</a>
   @elseif($checkoutReady)
    <form method="post" action="{{ route('premium.checkout', $template->slug) }}">@csrf
      <button class="btn" type="submit"><i class="fa-solid fa-lock"></i> Pay securely and unlock</button>
    </form>
    <p>Checkout is processed by Stripe. Access is activated only after payment confirmation.</p>
   @else
    <div class="upgrade-message">Secure checkout is not connected yet. Premium purchases are temporarily unavailable, and no payment will be taken.</div>
   @endif
   @if($errors->any())<p role="alert" style="color:#a42336">{{ $errors->first() }}</p>@endif
   <a class="upgrade-continue" href="{{ route('wedding.editor', $template->slug) }}">Return to invitation editor</a>
 </aside>
</div>
@endsection
