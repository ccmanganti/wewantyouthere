<nav class="wwyt-panel-topnav" aria-label="Customer workspace shortcuts">
    <a href="{{ route('home') }}" title="Return to the We Want You There homepage">
        <span aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></span> Website
    </a>
    <a href="{{ route('marketing.templates') }}">Templates</a>
    <a href="{{ url('/app/invitations') }}" @if(request()->is('app/invitations*')) aria-current="page" @endif>My Invitations</a>
    <a href="{{ url('/app/billing') }}" @if(request()->is('app/billing*')) aria-current="page" @endif>My Plan</a>
</nav>