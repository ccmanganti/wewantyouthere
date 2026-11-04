# Royal Burgundy — Editorial Wedding Invitation V2
Updated November 4, 2026

## Design reference and approach
This version uses the user-provided tall wedding invitation screenshot as visual direction, not as copied HTML or licensed artwork. It is an original narrow editorial website, approximately 750px wide on desktop, with warm cream paper, burgundy sections, a calendar, framed photo sections, candlelit/gold-inspired accents, a picturesque antique door divider, botanical engravings, painterly dress-code swatches, a full wedding program, entourage, RSVP contact and a farewell page.

The old scrolling heart path was intentionally removed. There are no SVG animations inside this design. Light on-scroll transitions are implemented via IntersectionObserver and CSS transform/opacity.

## Five-step creation flow
1. Choose sections (existing question groups and switches).
2. Add details (the shared wedding event question definitions).
3. Preview & refine (jump to actual invitation sections, replay the envelope opening, edit details).
4. Add your photos (interactive image cards, auto-scroll/outline highlights, AJAX upload, remove/replace).
5. Publish (custom URI, website plan comparison, QR/link).

The upload step is intentionally late. Photos are optional; decorative imagery and careful layout work without them. Existing drafts remain in the same browser/session.

## Design details
- Main portrait cover with the couple's names and invitation message.
- A decorative full-width photo-like raster illustration of grand burgundy doors.
- Framed invitation message.
- Dynamic month/year calendar with wedding date highlighted; it updates instantly in the builder.
- Program timings and details.
- Ceremony and reception panels, each with its own editable image slot and validated map URL.
- Dress-code instructions, printed painterly swatches and motif text.
- A three-chapter love story with optional photos.
- Family, principal/secondary sponsors, bridesmaids/groomsmen and ceremony roles.
- Gallery, gifts and reminders.
- RSVP contact section (not a live RSVP backend).
- Real layered raster envelope artwork in the contact section, and a final thank-you.

All editable text uses the existing shared Event Questions system and data-field live preview updates. No new executable custom template code is accepted.

## Envelope opening: graphical not vector
These original WebP assets are committed under public/wedding/royal-burgundy/:
- envelope-back.webp
- envelope-front.webp
- envelope-flap.webp
- envelope-letter.webp
- wax-seal.webp
- grand-doors.webp
- botanical-engraving.webp
- dress-swatches.webp
- paper-texture.webp

The source generator is scripts/generate_royal_burgundy_assets.py. Its GitHub Actions workflow generates original deterministic raster graphic files and commits them to the repository. All nine generated images have been verified to be true WebP and bounded in size.

The intro is composed with CSS transforms of separately layered WebP images (flap opens, card rises, reveal). It auto-plays once per browser session on the public invitation. It has a clear Skip introduction control and can be replayed in builder step 3. It does not autoplay in the marketing preview, and is skipped for users with reduced-motion preferences. No audio or canvas animation loop is involved.

## Security and data
The system keeps the existing protected storage and photo upload workflow. Slots are allowlisted in config/wedding_photos.php. Two new slots are venue_ceremony and venue_reception, increasing total supported placements from 11 to 13. The same file validation, size limits, browser image optimization, private storage, and owner authorization remain in effect. The URL and basic QR code remain unchanged.

Do not mistake RSVP contact presentation for a working RSVP collection system: online RSVP forms and premium guest management are future work.

## Database
RoyalBurgundyWeddingSeeder is idempotent. Rerun after pulling so the existing template settings include the two additional photo positions and version 2. This does not reset admin publication status or customized Event Question records.

## Deploy to Hostinger
From the Laravel app root (wwyt/wewantyouthere, not public_html):

    git pull origin main
    php artisan migrate --force
    php artisan db:seed --class=RoyalBurgundyWeddingSeeder --force
    php artisan optimize:clear
    php artisan filament:cache-components
    rsync -av --exclude='index.php' --exclude='.htaccess' public/ ../../public_html/

The last rsync command is essential because GitHub has nine new static WebP images in the Laravel public/ tree. Do not use rsync --delete and do not overwrite the custom public_html/index.php or .htaccess. Composer/npm installs are not needed for this revision.

## Live smoke tests
- Royal Burgundy card opens the correct live demo on the home/gallery pages.
- First-time public visit shows skippable envelope intro; refresh in the same browser session does not replay automatically.
- Builder step 3 can replay the opening; reducing motion skips it.
- Choosing wedding date updates the highlighted month and day.
- Hidden optional sections disappear from preview and published page.
- Steps 1 → 2 → 3 → 4 → 5 work; Back buttons and saved drafts work.
- Step 4 Show position selects the exact photo slot and scrolls/highlights it.
- Both new venue photo uploads work and persist through signup and publish.
- Users can replace/delete photos from My Invitations; website owners are isolated from others.
- No hardcoded sample names/venue addresses get accidentally saved as the user's content.
- Review on 360px mobile, laptop, and narrow editor preview; printed/video invitations remain roadmap-only.

A complete browser visual review of the production Hostinger site remains necessary after deploying.
