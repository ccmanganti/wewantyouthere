# Brand, Customer Navigation and Scroll Motion
Updated November 4, 2026.

## Brand assets
Primary colors are Cotton #EDEBDD, Cherry Red #810100, Maroon #630000 and Noir Black #1B1717, with a restrained gold highlight.

Public assets at public/branding include SVG files for:
- Horizontal logo and icon in color, light, dark, outline and gradient 3D wax-seal variants.
- Light horizontal wordmark on Noir headers/footers.
- Color/dark wordmarks on Cotton or light surfaces.
- Dimensional seal for marketing hero, login and dashboard.
- Outline icon for subtle secondary areas.

These are scalable vector reconstructions based on the reference boards, not pixel-exact exports of the original photorealistic 3D logo and typography. Replace them with original transparent master SVG/PNG files when those are available for perfect fidelity. The individual event invitation templates retain their independent branding.

## Customer navigation
- Public marketing header and footer use the new logo.
- Login, registration and password-reset simple layouts have a persistent responsive navbar linking to Homepage, Templates, How it works and an account route.
- Customer Filament /app dashboard has a richer invitation workspace, and topbar shortcuts to public site, Templates, Invitations, Plan/Billing.
- Sidebar includes a branded footer plus accessible Back to Website links (including on mobile).
- Filament uses panel brandLogo views to choose the appropriate high-contrast color logo in topbar, sidebar and auth form.
- /admin includes the logo and favicon as well.
- Existing native Filament forms, email/Google authentication, roles, 1-free-site quota and modals remain unchanged.

## Lightweight motion
- Marketing headings display a short cherry/gold decorative line drawn as each section enters the viewport.
- The three-step process includes an animated SVG connector path.
- IntersectionObserver is used; no heavy scroll event loop or third-party animation dependency.
- Supports prefers-reduced-motion.

## Hostinger deployment
Run from the Laravel app directory:
    git pull origin main
    php artisan optimize:clear
    php artisan filament:cache-components

This Hostinger layout has public_html separate from the Laravel project. Sync public assets too:
    rsync -av --exclude='index.php' --exclude='.htaccess' public/ ../../public_html/

Do not overwrite custom public_html/index.php or public_html/.htaccess. The public sync is required to avoid 404s for branding SVGs.

## After deploying
Test marketing header, sticky login navigation, desktop/mobile dashboard topbar and sidebar, login/Google flow, template previews and full-screen guest invitation.
Confirm static logo URLs (e.g. /branding/wwyt-horizontal-light.svg) are served with image/svg+xml and that no branding is forced into individual invitation templates.
Check reduced-motion preference and basic keyboard accessibility.
Automated CI includes routes, compiled views, logo availability and customer account tests; visual browser QA is still recommended.
