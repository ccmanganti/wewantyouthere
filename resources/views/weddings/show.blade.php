@extends('layouts.wwyt')
@section('body_class', 'invitation-page')
@section('robots', 'noindex,nofollow')
@section('title', e(($answers['bride_name'] ?? 'Our') . ' & ' . ($answers['groom_name'] ?? 'Wedding') . ' | Wedding Invitation'))
@section('meta_description', 'You are invited to our wedding celebration. Browse our ceremony, reception, entourage, program and wedding details.')

@push('styles')
@include('weddings.partials.invitation-theme-styles')
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.themes.royal-burgundy-styles')
<link rel="preload" href="{{ asset('wedding/royal-burgundy/envelope-front.webp') }}" as="image" type="image/webp">
<link rel="preload" href="{{ asset('wedding/royal-burgundy/envelope-flap.webp') }}" as="image" type="image/webp">
@endif
<style>
    body.invitation-page{background:#fbf8f1}
    body.invitation-page .topbar,body.invitation-page .foot{display:none}
    body.invitation-page>main{display:block;width:100%;margin:0;padding:0}
    body.invitation-page>.wrap:has(.alert){position:fixed;top:15px;left:50%;transform:translateX(-50%);z-index:60;max-width:560px;width:calc(100% - 30px)}
    body.invitation-page>.wrap .alert{box-shadow:0 8px 28px #1e2a1e36;margin:0}
    .public-wedding{width:100%;min-height:100svh;margin:0}
    .public-wedding .wedding-invite{width:100%}
    .invite-share{position:fixed;right:24px;bottom:24px;z-index:50;font:14px 'DM Sans',Arial,sans-serif}
    .invite-share summary{background:#3f5442;color:#fff;border:1px solid #869a87;
        box-shadow:0 12px 28px #20271c3d;border-radius:999px;min-height:52px;
        padding:14px 20px;display:flex;align-items:center;gap:10px;cursor:pointer;
        font-size:13px;font-weight:700;list-style:none}
    .invite-share summary::-webkit-details-marker{display:none}
    .invite-share summary:hover{background:#304636}
    .invite-share[open] summary{background:#2f4836}
    .invite-share-panel{position:absolute;right:0;bottom:calc(100% + 12px);width:min(340px,calc(100vw - 26px));
        padding:22px;background:#fffcf5;border:1px solid #d1c8b5;border-radius:14px;
        box-shadow:0 23px 65px #19261c46;color:#344136;text-align:center}
    .invite-share-panel h2{font:31px 'DM Serif Display',Georgia,serif;color:#3c5640;margin:0 0 7px}
    .invite-share-panel p{font-size:12px;color:#697368;line-height:1.7;margin:0 0 14px}
    .invite-share-panel .qr-frame{background:#fff;border:1px solid #d7dbc9;border-radius:10px;padding:13px;display:grid;place-items:center;margin:0 auto 16px;max-width:230px}
    .invite-share-panel .qr-frame img{display:block;width:194px;height:194px;max-width:100%}
    .share-url{font-size:11px;font-weight:600;color:#586e5c;overflow-wrap:anywhere;padding:9px 10px;background:#edf0e8;border-radius:7px;margin-bottom:14px}
    .share-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:center}
    .share-actions button,.share-actions a{border-radius:9px;padding:11px 13px;font:700 12px 'DM Sans',Arial,sans-serif;cursor:pointer;text-decoration:none}
    .share-actions .share-primary{background:#405c46;color:#fff;border:1px solid #405c46}
    .share-actions .share-secondary{background:#fff;color:#405c46;border:1px solid #b6c4b6}
    @media(max-width:650px){.invite-share{bottom:13px;right:13px}.invite-share summary{padding:13px 17px}}
    @media print{.invite-share{display:none!important}body.invitation-page .wedding-invite .invite-site-nav{display:none}}
</style>
@endpush

@section('content')
<div class="public-wedding">
    @include('weddings.partials.invitation', [
        'answers' => $answers,
        'sections' => $sections,
        'questions' => $questions,
        'isPreview' => false,
        'template' => $template,
        'photoUrls' => $photoUrls ?? [],
    ])
</div>

<details class="invite-share" id="invite-share">
    <summary aria-label="Share this wedding invitation and get its QR code">
        <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span> Share & QR
    </summary>
    <div class="invite-share-panel" role="group" aria-label="Invitation sharing options">
        <h2>Share our day</h2>
        <p>Scan this QR code or share the link with friends and family.</p>
        <div class="qr-frame">
            <img src="{{ route('wedding.qr', $website->slug) }}"
                alt="QR code linking to this wedding invitation"
                width="194" height="194" loading="lazy">
        </div>
        <div class="share-url" id="share-url">{{ route('wedding.show', $website->slug) }}</div>
        <div class="share-actions">
            <button type="button" id="copy-invitation-link" class="share-primary">Copy link</button>
            <a class="share-secondary" href="{{ route('wedding.qr', ['slug' => $website->slug, 'download' => 1]) }}">Download QR (SVG)</a>
        </div>
        @auth
            @if((int) auth()->id() === (int) $website->user_id)
                <div style="margin-top:16px;border-top:1px solid #d8d1c6;padding-top:13px">
                    <a href="{{ url('/app/invitations') }}" style="font-size:12px;font-weight:700;color:#810100;text-decoration:underline">Manage my invitation <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            @endif
        @endauth
    </div>
</details>
@endsection

@push('scripts')
@if(($template->settings['theme'] ?? '') === 'royal_burgundy')
@include('weddings.themes.royal-burgundy-script')
@endif
<script>
(function () {
    const button = document.getElementById('copy-invitation-link');
    const link = @json(route('wedding.show', $website->slug));
    if (!button) return;
    button.addEventListener('click', async function () {
        try {
            if (!navigator.clipboard || !navigator.clipboard.writeText) throw new Error('Clipboard not available');
            await navigator.clipboard.writeText(link);
            button.textContent = 'Copied!';
        } catch (error) {
            window.prompt('Copy your invitation link:', link);
        }
    });
})();
</script>
@endpush