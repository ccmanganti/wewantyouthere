{{-- Unified scrollbar treatment for marketing, builder, preview iframe, and Filament panels.
     Native scrolling/keyboard interaction remains intact; only the appearance changes. --}}
<style>
:root{
    --wwyt-scroll-thumb:#9a6b6b;
    --wwyt-scroll-thumb-hover:#772a37;
    --wwyt-scroll-track:transparent;
}
html{scrollbar-width:thin;scrollbar-color:var(--wwyt-scroll-thumb) var(--wwyt-scroll-track)}
body,body *{scrollbar-width:thin;scrollbar-color:var(--wwyt-scroll-thumb) var(--wwyt-scroll-track)}
:where(html,body,body *)::-webkit-scrollbar{width:9px;height:9px}
:where(html,body,body *)::-webkit-scrollbar-track{
    background:var(--wwyt-scroll-track);border-radius:999px
}
:where(html,body,body *)::-webkit-scrollbar-thumb{
    background:var(--wwyt-scroll-thumb);border-radius:999px;
    border:2px solid transparent;background-clip:padding-box
}
:where(html,body,body *)::-webkit-scrollbar-thumb:hover{
    background-color:var(--wwyt-scroll-thumb-hover)
}
:where(html,body,body *)::-webkit-scrollbar-corner{background:transparent}
/* Dark workspaces use a lighter, contrasting thumb without introducing another style. */
.builder-app,.builder-app .preview-pane,.fi-topbar,.fi-sidebar,.fi-modal{
    --wwyt-scroll-thumb:#a77f80;
    --wwyt-scroll-thumb-hover:#d6adb0;
}
.builder-app .editor-pane{
    --wwyt-scroll-thumb:#bd8584;
    --wwyt-scroll-thumb-hover:#8d3342;
}
:where(.stage-scroll,.preview-scroll,.group-tabs,.fi-main,.fi-sidebar-nav){
    overscroll-behavior:contain
}
</style>
