# Customer workspace — We Want You There

## New architecture

- `/admin` is the **Superadmin-only** Filament panel. Authorization remains role-gated.
- `/app` is a separate customer Filament panel using the same Laravel `web` auth guard.
  - `/app/login`: Filament login.
  - `/app/register`: Filament registration, assigns the `User` role.
  - `/app/profile`: Filament native profile page (name, email, password).
  - `/app/invitations`: owner-only website management, modal-only edits, modal delete confirmation.
  - `/app/billing`: plan limits and a clear **coming soon** notice for premium billing.
- Invitations are still created via the guided builder, not a second generic create form.
- A pending invitation is automatically published once after Filament authentication. On errors, a one-shot session flag prevents an infinite redirect loop.

## Free accounts: one website, enforced server-side

- The `users.account_tier` column defaults to `free` on existing and new users.
- The central `InvitationAccounts` service defines one website for free users.
- `WeddingBuilderController::publish()` rejects logged-in users at quota.
- `WeddingBuilderController::complete()` uses a transaction and locks the user's database row before checking quota and inserting to prevent concurrent duplicate publishing.
- **Archived / draft websites count toward the one-site limit.** Deleting a website frees its slot.
- A manually provisioned `premium` tier is recognized in code for future expansion, but there is **no subscription checkout, plan upgrade or payment method handling** yet. Do not offer payments as active.

## Ownership and customer editing

- Customer Filament resource queries are scoped to the current user's `user_id`.
- `canEdit` and `canDelete` additionally require ownership.
- Quick edit modal: invitation name, slug and public/private status.
- Edit details modal: available event questionnaire fields, grouped by section, with section-visibility toggles.
- The backend re-queries the owned record before modifying it, rather than trusting client-side record IDs.
- The admin panel retains its independent resources and permissions.

## URL changes and QR integrity

- `invitation_slug_redirects` stores historical slugs tied to the original website.
- Renaming a link registers the old slug as a redirect and prevents anyone else from claiming it.
- Published old URLs issue a permanent redirect to the new invitation URL.
- Deletion cascades to associated historical slugs. Previously downloaded QR codes then stop resolving.
- Changing a slug cannot claim an alias belonging to someone else.
- **Custom domains are not live.** Only the `/i/{slug}` path can be customized.

## Branding rules (platform UI only)

- Cotton `#EDEBDD`
- Cherry Red `#810100`
- Maroon `#630000`
- Noir Black `#1B1717`
- Gold `#B99A69` is a restrained decorative accent (not a primary brand color).
- Public homepage and builder share these tokens. Filament customer and admin panels use Cherry Red as primary.
- Wedding invitation templates are **not** rebranded; customers should keep the original wedding template's palette and creative direction.
- Motion is subtle and respects `prefers-reduced-motion`.

## Deployment from Hostinger Laravel app directory

```bash
git pull origin main
php artisan migrate --force
php artisan db:seed --class=RoleSeeder --force
php artisan optimize:clear
php artisan filament:cache-components
```

No Node or npm build is required. If starter wedding templates are missing, also run `php artisan db:seed --class=WeddingBuilderSeeder --force`.

## After deployment, smoke test

1. Register a brand-new account through `/app/register`, then visit `/app`.
2. Create and publish the first invitation; confirm it's listed at `/app/invitations`.
3. Verify a second invitation cannot be published, even by posting to the builder.
4. Use **Quick edit** to rename the slug, then open the original link and confirm it redirects.
5. Use **Edit details** to change the couple's names and hide a section, then view the published site.
6. Delete the invitation with confirmation; confirm it disappears and a new creation slot becomes available.
7. Verify `/app/profile`, `/app/billing` and that an ordinary user gets a 403 at `/admin`.
8. Confirm `APP_URL=https://wewantyouthere.com` for QR links.

Production website styling and Livewire interactivity need a **manual browser check** in addition to the automated GitHub tests.
