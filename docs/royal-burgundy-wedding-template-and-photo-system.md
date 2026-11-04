# Royal Burgundy Wedding Template and Photo Studio
Updated November 4, 2026

## Original reference
The uploaded Brian and Yna HTML contains 17 wedding sections: hero, wedding details, storyline, entourage, family, honor, sponsors, secondary sponsors, ceremony roles, cherished roles, celebration roles, dress code, places, ceremony program, reception program, moments and RSVP. It also includes elaborate moving heart and line, floral, gallery and envelope effects.

The supplied file references many missing image files (2.jpg through 10.jpg) which were not included in the upload. It contains embedded decorative imagery, but no complete uploaded collection of original event photos. The implemented design uses user-uploaded photos through its image placement system.

The new slug is royal-burgundy-wedding. It is an original Blade-based wedding website, derived from the reference's visual language. We retained the major content groupings, cleaned up the motion and use safe declarative Blade templates rather than executing untrusted inline scripts.

## Template seeding
The idempotent RoyalBurgundyWeddingSeeder seeds one new published wedding design, adds a small number of optional question fields to the existing shared Wedding event type, and preserves admin-disabled question and template records.

Other available design: ever-after-classic.

## Builder and photo placements
- Guided sections -> questions -> photo studio -> review and publish.
- 11 positions: hero, portrait_one, portrait_two, story_one, story_two, story_three, gallery_one, gallery_two, gallery_three, gallery_four, rsvp_portrait.
- Every photo card has Show position, Upload / Replace and Remove controls.
- Clicking Show position scrolls the live preview pane and highlights the target. In-preview camera buttons open the matching picker.
- Upload, remove and replace happen through session-safe authenticated or anonymous AJAX endpoints with a CSRF token.
- Uploaded photos persist across normal page reloads while the session remains valid. Names and form responses are also saved to localStorage.
- Client-side image resizing and WebP conversion are used when browser capabilities allow.
- Photo controls can also be accessed after publishing through My Invitations -> Manage photos.
- The public invitation hides empty galleries and does not show empty photo upload boxes.

## Storage and security
- Only JPEG, PNG and WebP are accepted, with maximum 5 MB and 6000x6000 resolution; never SVG/HTML.
- Slots are server-side allowlisted; arbitrary paths and extensions are not accepted.
- Files are private under Laravel Storage local disk, served through Laravel routes; no public storage symlink required.
- An anonymous draft photo is available only from its browser session. Published photos are served only for public published invitation URLs, or to the owner for unpublished websites.
- Owner checks prevent users from managing other users' photos.
- Cancel deletes temporary images; publish saves private media into site-scoped directories; deleting the website cleans up that directory.
- Free users still have one website, not unlimited sites.
- Hostinger sessions may expire; a long-term unattended draft photo needs a persistent session or re-upload. Configure storage limits and stale-draft retention before large-scale launch.

## Hostinger deployment
From Laravel app root domains/wewantyouthere.com/wwyt/wewantyouthere:

    git pull origin main
    composer install --no-dev --optimize-autoloader
    php artisan migrate --force
    php artisan db:seed --class=RoyalBurgundyWeddingSeeder --force
    php artisan optimize:clear
    php artisan filament:cache-components

Never run migrate:fresh or a destructive default database seeder. This release does not require uploading new brand raster assets or syncing public_html. Do not overwrite the custom public_html/index.php and .htaccess.

## Verify after deployment
1. Catalogue lists Ever After and Royal Burgundy.
2. Royal design preview works and is full-page on desktop and mobile.
3. Builder question text updates its preview instantly; choose/disable sections.
4. Photo step auto-scrolls to the correct photo and highlights it.
5. Reloading retains answers and session photos; test uploading and removing photos.
6. Guest publishes after signup, owner can edit photos from My Invitations.
7. Published photos appear on /i/{slug}; unpublished draft photos are private.
8. Published site without any uploaded images is still a complete coherent page.
9. Test unsupported file types, one-free-site quota and owner-only access.

## Future work
- Authenticated permanent draft storage, abandoned draft storage cleanup and quotas.
- Image focal point and crop controls, generated thumbnails, dedicated CDN storage.
- Hybrid template schemas for affiliates and associates.
