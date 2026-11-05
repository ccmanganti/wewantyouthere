@extends('layouts.wwyt')
@section('title', 'Premium Upgrade Status | We Want You There')
@section('robots', 'noindex,nofollow')
@section('content')
<div class="wrap" style="max-width:620px;padding:90px 0;text-align:center">
    @if($paid)
       <h1>Premium is unlocked.</h1>
       <p>Your payment is confirmed. Your invitation's premium tools are now available.</p>
    @else
       <h1>Checking your payment.</h1>
       <p>We are waiting for the secure payment confirmation. Premium features will unlock when payment is verified. You can revisit this page if processing is delayed.</p>
    @endif
    <a class="btn" href="{{ route('wedding.editor', $template->slug) }}">Return to invitation editor</a>
    <a class="btn btn-light" href="{{ route('premium.show', $template->slug) }}">View upgrade status</a>
</div>
@endsection
