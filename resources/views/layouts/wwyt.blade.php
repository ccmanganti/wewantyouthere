<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fbf9f5">
    <meta name="description" content="@yield('meta_description', 'Create elegant wedding invitation websites in minutes. Choose a template, customize every detail and publish your wedding invitation for free.')">
    <title>@yield('title', 'We Want You There — Wedding Invitation Websites & RSVP')</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#28332e;--muted:#69716a;--green:#385b4a;--green-dark:#294738;--cream:#fbf9f5;--paper:#fffefa;--line:#e6e7df;--gold:#b69a6e;--radius:18px}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--cream);color:var(--ink);font:15px/1.55 'DM Sans',Arial,sans-serif}
        a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}button{cursor:pointer}img{max-width:100%}
        h1,h2,h3,.serif{font-family:'DM Serif Display',Georgia,serif;font-weight:400;line-height:1.1}
        h1{font-size:clamp(42px,6vw,76px);letter-spacing:-1.4px}h2{font-size:clamp(30px,4vw,47px)}
        .wrap{width:min(1190px,calc(100% - 44px));margin-inline:auto}.topbar{height:79px;border-bottom:1px solid var(--line);background:rgba(251,249,245,.96);position:relative;z-index:10}
        .topbar-inner{height:100%;display:flex;align-items:center;justify-content:space-between;gap:20px}.brand{font-family:'DM Serif Display',Georgia,serif;font-size:23px;letter-spacing:-.5px;white-space:nowrap}.brand span{color:var(--green)}
        .nav{display:flex;align-items:center;gap:26px}.nav a{font-size:13px;font-weight:600}.nav .btn{padding:11px 18px}.eyebrow{letter-spacing:.17em;text-transform:uppercase;font-size:10px;font-weight:700;color:#7a8b78}
        .btn{border:1px solid transparent;border-radius:50px;padding:13px 22px;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-weight:700;font-size:13px;transition:.18s;background:var(--green);color:#fff}
        .btn:hover{background:var(--green-dark)}.btn-outline{background:transparent;color:var(--green);border-color:#c8d0c6}.btn-outline:hover{background:#ecf0e8}.btn-light{background:#fff;color:var(--ink);border:1px solid var(--line)}.btn-light:hover{background:#f1f2eb}
        .btn:disabled{opacity:.5;cursor:not-allowed}.pill{display:inline-block;border-radius:40px;padding:5px 12px;font-size:11px;font-weight:700;background:#edf2e9;color:var(--green)}
        .muted{color:var(--muted)}.section{padding:75px 0}.section-heading{text-align:center;max-width:710px;margin:0 auto 35px}.section-heading h2{margin:10px 0 12px}.section-heading p{color:var(--muted)}
        .card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden}.alert{padding:13px 18px;background:#eaf3e7;border:1px solid #c9dfc5;border-radius:12px;color:#37563e;margin:20px 0}
        .foot{padding:28px 0;border-top:1px solid var(--line);color:var(--muted);font-size:12px;margin-top:70px}.foot .wrap{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap}
        input:not([type=checkbox]):not([type=radio]),textarea,select{border:1px solid #dce1d8;background:#fff;border-radius:10px;padding:11px 13px;outline:none;width:100%;color:var(--ink)}
        input:focus,textarea:focus,select:focus{border-color:#6f9278;box-shadow:0 0 0 3px #6f927820}
        label.field-label{display:block;font-size:12px;font-weight:700;margin-bottom:6px}.field{margin-bottom:14px}.field-error{font-size:12px;color:#9b433c;margin-top:5px}
        .tiny{font-size:12px}.danger{color:#a1463c}.text-center{text-align:center}
        @media(max-width:700px){.topbar{height:70px}.brand{font-size:20px}.nav{gap:10px}.nav .hide-mobile{display:none}.nav .btn{padding:10px 14px}.wrap{width:min(100% - 28px,1190px)}.section{padding:52px 0}}
    </style>
    @stack('styles')
</head>
<body>
<header class="topbar"><div class="wrap topbar-inner">
    <a class="brand" href="{{ route('home') }}" aria-label="We Want You There homepage">we want <span>you there.</span></a>
    <nav class="nav" aria-label="Main">
        <a class="hide-mobile" href="{{ route('home') }}#templates">Templates</a>
        <a class="hide-mobile" href="{{ route('home') }}#how-it-works">How it works</a>
        @auth
            <form action="{{ route('wedding.logout') }}" method="POST">@csrf<button class="btn btn-outline" type="submit">Log out</button></form>
        @else
            <a class="hide-mobile" href="{{ route('login') }}">Log in</a>
            <a class="btn" href="{{ route('wedding.register') }}">Get started</a>
        @endauth
    </nav>
</div></header>
@if(session('status'))<div class="wrap"><div class="alert" role="status">{{ session('status') }}</div></div>@endif
<main>@yield('content')</main>
<footer class="foot"><div class="wrap"><span>© {{ date('Y') }} We Want You There. Celebrate beautifully.</span><span>Digital invitations made for meaningful moments.</span></div></footer>
@stack('scripts')
</body></html>
