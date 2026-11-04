@extends('layouts.wwyt')
@section('body_class', 'marketing-v2')
@section('title', ($section === 'privacy' ? 'Privacy Policy' : 'Terms of Service') . ' | We Want You There')
@section('meta_description', 'Read the ' . ($section === 'privacy' ? 'privacy policy' : 'terms of service') . ' for the We Want You There digital invitation website builder.')
@push('styles')
@include('marketing.partials.styles')
@endpush
@section('content')
<div class="mkt"><div class="mkt-wrap"><article class="mkt-legal">
    <div class="mkt-kicker red">WE WANT YOU THERE · ACCOUNT INFORMATION</div>
    @if($section === 'privacy')
        <h1>Privacy policy.</h1>
        <p><strong>Effective November 4, 2026.</strong> This notice describes how We Want You There handles information used to build and share event invitation websites.</p>
        <h2>Information you provide</h2>
        <p>When you create an account, we collect the name and email address you provide, plus a password if you choose email registration. When you create an invitation, we store event information such as names, dates, venues, sponsors, entourage, program details and website settings.</p>
        <h2>Google sign-in</h2>
        <p>If you sign in through Google, Google sends basic profile details such as an account identifier, name and email to authenticate you. Sign-in does not request access to Google Drive, Gmail or calendar. Google authentication is available once the integration is configured.</p>
        <h2>How information is used</h2>
        <p>We use information to authenticate you, offer invitation editing and publishing, display your website, prevent misuse and operate the service. Content published on an invitation website may be viewed by people who receive its link; avoid adding details you would not want your guests to see.</p>
        <h2>Browser drafts</h2>
        <p>The invitation builder can save an unpublished draft on your current browser and device. Drafts do not synchronize between devices. Clearing browser storage may remove them.</p>
        <h2>Sharing and storage</h2>
        <p>Information may be processed by service providers used to host and operate the platform. Deleting a website takes its published content offline; server backups and operational records may take additional time to expire.</p>
        <h2>Your choices and updates</h2>
        <p>You can edit your account and invitation details, unpublish or delete invitations using your dashboard. This notice will be updated as new RSVP, messaging or paid features are introduced.</p>
    @else
        <h1>Terms of service.</h1>
        <p><strong>Effective November 4, 2026.</strong> By using We Want You There, you agree to use it responsibly and only publish information you are authorized to share.</p>
        <h2>What the service provides</h2>
        <p>The current free plan allows one invitation website per account. You may customize a supported wedding design, publish a website and share its link and basic QR code. Features described as coming soon are not yet included.</p>
        <h2>Your responsibilities</h2>
        <p>You are responsible for the accuracy of event details, and for having permission to publish names, photographs, and messages. Do not upload malicious code, impersonate others, infringe rights, harass people, or use the service unlawfully.</p>
        <h2>Publishing and deletion</h2>
        <p>A published invitation can be accessed through its link. You can edit, unpublish or delete a website from your dashboard. Deletion frees a free-plan site slot but cannot recall links that have already been shared.</p>
        <h2>Account security</h2>
        <p>Keep login credentials secure. Google sign-in, when enabled, is subject to Google's authentication processes. The platform may restrict abusive use to help maintain reliability and safety.</p>
        <h2>Payments and changes</h2>
        <p>Premium subscriptions, paid invitations, and video exports are not yet available for purchase. Future paid offerings will state their terms before checkout. Features and availability may change as the service develops.</p>
    @endif
    <p style="margin-top:45px;border-top:1px solid #c9b7ae;padding-top:20px"><a href="{{ route('home') }}" style="color:#810100;text-decoration:underline">← Back to We Want You There</a></p>
</article></div></div>
@endsection