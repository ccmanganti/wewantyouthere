# We Want You There — Wedding builder MVP

## Deploy on Hostinger
From the Laravel application root:

\`\`\`bash
git pull origin main
php artisan migrate --force
php artisan db:seed --class=WeddingBuilderSeeder --force
php artisan optimize:clear
\`\`\`

If the role seeders haven't been run, also execute:
\`\`\`bash
php artisan db:seed --class=RoleSeeder --force
\`\`\`

**Do not run default DatabaseSeeder** on Hostinger without dev dependencies (Faker).

## Public pages
- \`/\` — SEO-friendly homepage and available published wedding templates.
- \`/templates/wedding/ever-after-classic\` — live side-by-side editor with event-specific questions, section visibility, website/paper/animated preview tabs.
- \`/register\` and \`/login\` — public user accounts. Draft invitation answers persist in the session while registering/logging in.
- \`/i/{slug}\` — free published, shareable wedding invitation page.

## Superadmin question management
\`/admin\` → Event Questions: enable/disable questions, change labels, form group, required flag, placeholders, and sort order in modals or inline where available.

The \`WeddingBuilderSeeder\` inserts a fixed extensive wedding set and an immutable-slug starter template; it **does not reset enabled or required values** for existing question records. All wedding templates share the same EventType questions.

## Hardcoded first template
\`resources/views/weddings/partials/invitation.blade.php\` contains the hardcoded Ever After invitation. The same partial renders both the live editor and the public invitation. Answers use escaped Blade output and are updated through DOM \`textContent\` in the editor. Remaining enabled fields are rendered through \`weddings/partials/extras.blade.php\`.

The starter template uses \`settings.renderer = builtin_wedding\`, not uploaded executable PHP or Blade. The separate admin HTML upload feature remains a future foundation: **uploaded HTML is not publicly rendered** until an HTML sanitizer, asset handling and CSP are implemented.

## Premium features
The free-versus-premium page is a **non-transactional comparison**. RSVP dashboard, unique guest QR links, premium exports, printed invitation and animated/video invitation renderers, custom domains and DNS verification, map embeds and notifications are NOT yet operational; premium buttons do not charge users.

Only templates with \`is_premium = false\` may be published via the public free builder.

## Limitations and next milestones
1. Replace the placeholder premium tabs with independently implemented print/PDF and video renderers.
2. Add a real paid feature catalog and Stripe/payment-provider fulfillment before enabling upgrades.
3. Build RSVP guest links, guest/household tables, limits, exports and a dedicated premium owner dashboard.
4. Build domain verification, TLS provisioning and per-host routing. Never route user-supplied unverified hostnames.
5. Add invitation ownership/editing after publication, image uploads, consent/privacy terms, email verification and abuse prevention.
6. Preserve mobile preview parity and accessibility while extending event types.

## Implementation details
- Laravel 12, PHP 8.4, Blade; no Node/Vite assets required for these pages.
- All editor questions come from enabled database records; their default schema lives at \`config/wedding_builder.php\`.
- Public users cannot enter the Filament Superadmin admin panel.
- The account/password inputs use Laravel authentication and Laravel's hashed password model cast.

## November 2026 guided builder update

- Public homepage and wizard now use a black, burgundy-red and gold interface, while the invitation template itself remains a separate visual theme.
- Builder desktop viewport is fixed-height; its question panel and website preview are individually scrollable. On mobile, edit/preview are switchable full-height panes.
- Wizard has three steps: (1) choose optional sections, (2) answer one selected question group at a time, with optional fields initially collapsed, (3) compare free and future premium options and publish.
- Browser draft key: `wwyt:wedding:draft:v2:{templateSlug}`, stored in `localStorage`. It includes answers, selected sections, current stage and group, and expanded optional fields.
- **Drafts are browser/device-local**, not yet synced to a user account or backed up on the server. They can be lost if the browser deletes site data, storage is blocked, or the person uses another device. Avoid promising recovery across devices.
- The only intentional removal of local draft data occurs after successful `POST /templates/wedding/{slug}/cancel` or successful free publication. Both set a session flash key `clear_wedding_draft`, which causes the shared layout to remove the corresponding browser key on the destination page.
- Do not clear drafts in the wizard form submit event: guests may be redirected to registration/login before the invitation is actually published.
- Home page shows a Continue draft link whenever local data exists for a template; visitors do not need to register before starting.
- The CI workflow compiles/lints all Blade templates, checks JavaScript syntax and runs `WeddingBuilderTest` to cover cancellation, signup, publishing, required-field validation and seeder behavior.
