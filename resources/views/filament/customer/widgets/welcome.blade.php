<x-filament-widgets::widget>
    @php
        $owner = auth()->user();
        $site = $owner->invitationWebsites()->latest()->first();
        $remaining = \App\Support\InvitationAccounts::remainingSites($owner);
    @endphp

    <div style="background:#1B1717;color:#EDEBDD;border-radius:18px;padding:clamp(23px,4vw,45px);overflow:hidden;position:relative;">
        <div style="position:absolute;width:280px;height:280px;border-radius:50%;background:#810100a0;filter:blur(78px);top:-135px;right:-70px;pointer-events:none"></div>
        <div style="position:relative;z-index:1">
            <p style="font-size:11px;letter-spacing:.22em;text-transform:uppercase;color:#ddaaaa;margin:0 0 15px;font-weight:700">Your celebration hub</p>
            <h2 style="font-family:Georgia,serif;font-size:clamp(28px,4vw,46px);line-height:1.1;max-width:670px;margin:0 0 14px">
                Welcome back, {{ str($owner->name)->before(' ') }}.
            </h2>
            <p style="font-size:13px;line-height:1.9;color:#d9ccc5;max-width:650px;margin:0 0 24px">
                {{ $site ? 'Your invitation is ready whenever you are. Edit your wedding details or share your beautiful website.' : 'Your first wedding invitation is a few steps away. Choose your design and make the details uniquely yours.' }}
            </p>
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:11px">
                @if($site)
                    <a href="{{ route('wedding.show', $site->slug) }}" target="_blank" rel="noopener"
                       style="display:inline-flex;padding:12px 18px;background:#810100;border-radius:8px;color:white;text-decoration:none;font-size:12px;font-weight:800">View my invitation ↗</a>
                    <a href="/app/invitations"
                       style="display:inline-flex;padding:12px 18px;border:1px solid #bd9889;border-radius:8px;color:#EDEBDD;text-decoration:none;font-size:12px;font-weight:800">Manage invitation →</a>
                @elseif($remaining === null || $remaining > 0)
                    <a href="{{ route('wedding.editor', 'ever-after-classic') }}"
                       style="display:inline-flex;padding:12px 18px;background:#810100;border-radius:8px;color:white;text-decoration:none;font-size:12px;font-weight:800">Create my invitation →</a>
                @endif
                <span style="font-size:11px;color:#d5b9a5;padding:8px 0">
                    {{ $owner->account_tier === 'premium' ? 'Premium access' : 'Free account · 1 website' }}
                </span>
            </div>
        </div>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;margin-top:18px">
        <div style="background:#fff;border:1px solid #e4dad1;border-radius:12px;padding:20px">
            <p style="font-size:10px;color:#756b68;letter-spacing:.12em;text-transform:uppercase;font-weight:700;margin:0 0 10px">My websites</p>
            <p style="font-family:Georgia,serif;font-size:35px;color:#1B1717;margin:0">{{ $owner->invitationWebsites()->count() }}</p>
        </div>
        <div style="background:#fff;border:1px solid #e4dad1;border-radius:12px;padding:20px">
            <p style="font-size:10px;color:#756b68;letter-spacing:.12em;text-transform:uppercase;font-weight:700;margin:0 0 10px">Website slots remaining</p>
            <p style="font-family:Georgia,serif;font-size:35px;color:#810100;margin:0">{{ $remaining === null ? '∞' : $remaining }}</p>
        </div>
        <div style="background:#fff;border:1px solid #e4dad1;border-radius:12px;padding:20px">
            <p style="font-size:10px;color:#756b68;letter-spacing:.12em;text-transform:uppercase;font-weight:700;margin:0 0 10px">My account</p>
            <a href="/app/profile" style="display:inline-block;margin-top:9px;color:#810100;font-size:13px;font-weight:700;text-decoration:underline">Update profile →</a>
        </div>
    </div>
</x-filament-widgets::widget>
