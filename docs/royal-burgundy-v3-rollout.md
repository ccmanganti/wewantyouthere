# Royal Burgundy V3 — one selectable invitation template

Updated: November 5, 2026.

## What changed
The approved standalone HTML prototype has been integrated into Laravel as one
20-section wedding invitation. The grand art sections alternate with clear
information sections: cover; welcome; editorial couple photos; love story;
antique doors; calendar; venue art; ceremony/reception information; venue photo;
maps; visual timeline; program instructions; family photo collage; entourage;
painted dress-code art; dress/gifts; seven-image gallery; guest instructions;
closing photograph; RSVP form and contact details.

The prototype's device buttons, toolbar, and Replay envelope navigation are gone.

## All content is customizable
The five-step builder remains Sections -> Details -> Preview & refine ->
Photos -> Publish. Newly seeded questions make romantic copy, all headings,
chapters, wedding timetable, guest reminders and role names editable, alongside
existing wedding questions. The Filament quick-edit form uses the same
questions. All twenty media slots appear in the guided image upload step and
the post-publish photo manager.

## Envelope
The guest sees a closed textured envelope first. No animation happens until
Open Invitation is clicked. Its WebP layers open, lift the paper card, then
zoom and fade gracefully into the wedding website. Skip is available.
Reduced-motion preference avoids animated movement.

## RSVP database
The migration creates invitation_rsvps with:
invitation_website_id, guest_name, attendance, guest_count, message and timestamps.
The POST /i/{slug}/rsvp endpoint validates input, respects invitation-specific
guest limits and RSVP deadlines, uses CSRF and throttling. The owner-only
Guest RSVPs page displays attendance counts and responses in the customer app.
The builder and design previews do not store real RSVP responses.

## Gallery and raster assets
The Laravel theme is committed. The exact sample photos from the standalone
HTML prototype are binary and require one optional Hostinger File Manager upload.
Extract royal_burgundy_v3_hostinger_assets.zip inside:

    public_html/wedding/royal-burgundy-v3/

The ZIP includes an assets/ folder. Check, for example:

    https://wewantyouthere.com/wedding/royal-burgundy-v3/assets/envelope-front.webp
    https://wewantyouthere.com/wedding/royal-burgundy-v3/assets/couple.webp
    https://wewantyouthere.com/wedding/royal-burgundy-v3/assets/gallery-couple-close.webp

If you have not uploaded the optional assets, the theme automatically falls
back to the committed Royal Burgundy WebP art and placeholders. For real
published invitations, owners must upload their own couple photographs;
sample couples are not silently published to strangers' wedding websites.

## Safe template replacement
RoyalBurgundyWeddingSeeder publishes only Royal Burgundy V3. Older templates
are archived in the database, not physically deleted, to preserve foreign keys
and historical published wedding websites. The seeder is idempotent and
preserves administrator-disabled event questions.

## Production commands (Laravel root)

    git pull origin main
    php artisan migrate --force
    php artisan db:seed --class=RoyalBurgundyWeddingSeeder --force
    php artisan optimize:clear
    php artisan filament:cache-components
    rsync -av --exclude='index.php' --exclude='.htaccess' public/ ../../public_html/

The final rsync copies static art but protects custom Hostinger index.php and
.htaccess. It does not delete File Manager uploads. Never use migrate:fresh.

## Post-deployment checks
1. Homepage/gallery show only Royal Burgundy V3.
2. Existing Ever After links continue rendering.
3. Envelope waits for the click and finishes with zoom/fade.
4. Every field edits live and survives publication.
5. Image replacement works before/after publishing.
6. Photo overlay, map, entourage, program and gallery display on mobile.
7. RSVP saves only on published sites; owner sees guest responses.
8. Other users cannot see or edit someone else's responses.
9. No prototype device toolbar or automatic envelope replay.
