# We Want You There - PNG Logo Upload and Icon Upgrade

Updated November 4, 2026.

## What changed in the code
The active public layout, SEO homepage, wedding builder, published wedding website, customer login, customer dashboard, invitation table, and Superadmin brand references now use raster PNG logos instead of the previous `branding/wwyt-*.svg` assets. Marketing action buttons and visible feature icons use **Font Awesome 6 Solid** icon-font classes, and the customer Filament sidebar and table actions use **solid Heroicons** instead of thin outline variants.

**Do not upload images to the Laravel storage/app directory.** These are publicly served static assets.

## Upload location on Hostinger
In Hostinger File Manager, open the website's **public_html** folder, then:

`public_html/brand/wwyt/`

The path is relative to the public website root, not the Laravel project root. For this installation the Laravel app lives under `wwyt/wewantyouthere`, while static assets live in `public_html`.

Upload the 8 generated transparent PNG images from the chat, renamed exactly as follows.

| Source image / variant | Exact filename | Usage |
| --- | --- | --- |
| Full color 3D horizontal wordmark | `logo-primary.png` | Light Filament sidebar, Superadmin |
| Flat 2D horizontal wordmark | `logo-flat.png` | Optional for future light brand placements |
| Black monochrome horizontal wordmark | `logo-black.png` | Light marketing section |
| White monochrome horizontal wordmark | `logo-white.png` | Public header/footer, dark Filament topbar, login header |
| 3D wax seal icon | `seal-3d.png` | Homepage hero, customer dashboard, login |
| Flat seal icon | `seal-flat.png` | Template gallery branding |
| Outline seal icon | `seal-outline.png` | Sidebar footer, empty states |
| Small-size optimized compact seal | `favicon.png` | Browser tab, Filament panels |

All eight should have transparent backgrounds. Preserve the PNG format. Do not rename them to SVG or rename a JPG file with a PNG extension. Logo files should have tight transparent margins and enough resolution to remain sharp.

**The images intentionally are NOT committed into this repository.** The business owner is uploading the real generated images through Hostinger's File Manager.

## Static URL checks after upload
- `https://wewantyouthere.com/brand/wwyt/logo-white.png`
- `https://wewantyouthere.com/brand/wwyt/logo-primary.png`
- `https://wewantyouthere.com/brand/wwyt/seal-3d.png`
- `https://wewantyouthere.com/brand/wwyt/favicon.png`

All should open as images, not 404s. The File Manager path is case-sensitive.

## Code deployment
From `domains/wewantyouthere.com/wwyt/wewantyouthere` (Laravel root):

```sh
git pull origin main
php artisan optimize:clear
php artisan filament:cache-components
```

If you use the regular sync of Laravel `public/` to `public_html/`, don't overwrite the uploaded PNG files. For example, a regular `rsync -av` without `--delete` preserves them.

## Icon system
- Marketing buttons use Font Awesome Solid arrow, chevron, navigation, event, and feature icons (font-based, not custom inline SVG).
- Google sign-in icon uses the Font Awesome Google brand glyph.
- Customer panel resource, billing, dashboard and action icons use native Filament solid Heroicons.
- Font Awesome CSS is linked from cdnjs. If a visitor's network blocks cdnjs, icon-font glyphs may not display; button labels remain readable. This adds no image files or JS animation packages.
- The decorative SVG scroll-line animation remains because it is a non-icon visual effect. Customer event invitation templates keep their independent style.

## Browser QA
1. Check that public header/footer logos are readable on dark backgrounds.
2. Check colored logo on Cotton sidebar and in Superadmin.
3. Check the 3D seal on landing, login and /app dashboard.
4. Check the solid arrow icon buttons and filled feature cards.
5. Check mobile menu, site builder controls, Google login and published invitation links.
6. Clear browser caches if old imagery is still showing.

Automated tests validate the code references, but cannot verify your manual File Manager image upload.
