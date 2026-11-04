<x-filament-panels::page>
    @php
        $user = auth()->user();
        $max = \App\Support\InvitationAccounts::websiteLimit($user);
        $used = $user->invitationWebsites()->count();
    @endphp

    <div style="max-width:950px">
        <div style="border-radius:16px;padding:clamp(24px,4vw,40px);background:#1B1717;color:#EDEBDD;position:relative;overflow:hidden">
            <div style="position:absolute;right:-55px;top:-75px;width:210px;height:210px;background:#810100;filter:blur(60px);opacity:.85"></div>
            <div style="position:relative;z-index:1">
                <p style="font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:#d3b590;margin:0 0 10px">Account & subscription</p>
                <h2 style="font-family:Georgia,serif;font-size:clamp(30px,4vw,45px);line-height:1.2;margin:0 0 10px">{{ $user->account_tier === 'premium' ? 'Premium plan' : 'Free plan' }}</h2>
                <p style="color:#dfd3ca;font-size:13px;max-width:590px;line-height:1.8;margin:0">Build and share meaningful invitations without unnecessary complexity.</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:15px;margin-top:20px">
            <div style="padding:24px;background:#fff;border:1px solid #dfd4c9;border-radius:12px">
                <strong style="display:block;font-size:12px;color:#51413b;margin-bottom:10px">Website allowance</strong>
                <div style="font-family:Georgia,serif;font-size:34px;color:#810100">{{ $used }} / {{ $max ?? 'Unlimited' }}</div>
                <p style="font-size:12px;color:#7a6f68;line-height:1.6">Deleted websites free up a slot. Unpublished or archived websites still count.</p>
                <a href="/app/invitations" style="font-size:12px;font-weight:700;color:#810100;text-decoration:underline">Manage my websites →</a>
            </div>
            <div style="padding:24px;background:#fff;border:1px solid #dfd4c9;border-radius:12px">
                <strong style="display:block;font-size:12px;color:#51413b;margin-bottom:10px">Billing & payment methods</strong>
                <div style="font-family:Georgia,serif;font-size:24px;color:#1B1717;margin:12px 0">Not required</div>
                <p style="font-size:12px;color:#7a6f68;line-height:1.7">Payments, invoices and premium checkout are not yet enabled. There is no payment method to manage in this release.</p>
            </div>
        </div>
        <div style="padding:23px 26px;background:#EDEBDD;border:1px solid #d1bfae;border-radius:12px;margin-top:18px">
            <strong style="font-size:14px;color:#630000">Premium upgrades — coming soon</strong>
            <p style="font-size:12px;color:#544846;line-height:1.8;margin:8px 0 0">Future plans will unlock more invitations, expanded guest management, RSVP analytics and additional invitation formats. No purchase or subscription is possible yet.</p>
        </div>
    </div>
</x-filament-panels::page>
