<style>
:root {
    --wwyt-cotton: #EDEBDD;
    --wwyt-cherry: #810100;
    --wwyt-maroon: #630000;
    --wwyt-noir: #1B1717;
}
.fi-body {font-family: 'DM Sans', sans-serif}
.fi-sidebar {background: var(--wwyt-cotton)}
.fi-sidebar-header {background: var(--wwyt-cotton)}
.fi-topbar {background: var(--wwyt-noir)}
.fi-topbar .fi-icon-btn, .fi-topbar .fi-icon, .fi-topbar .fi-topbar-item-label {color: var(--wwyt-cotton)}
.fi-sidebar-item-button {border-radius: 9px}
.fi-sidebar-item-button:hover {background: #e5d7cc}
.fi-sidebar-item.fi-active .fi-sidebar-item-button {background: #81010018}
.fi-main {scroll-behavior: smooth}
.fi-header-heading {font-family: Georgia, serif;letter-spacing:-.02em}
@media(prefers-reduced-motion:no-preference) {
    .fi-section, .fi-ta-ctn {animation:wwytAppear .28s ease-out both}
    @keyframes wwytAppear {from{opacity:.85;transform:translateY(4px)}to{opacity:1;transform:translateY(0)}}
}
</style>
