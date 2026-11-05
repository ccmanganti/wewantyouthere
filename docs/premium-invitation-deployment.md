# Premium invitation rollout and Search Console

## Deploy safely

From the Laravel application directory after pulling **main**:

```bash
git pull origin main
php artisan migrate --force
php artisan db:seed --class=RoyalBurgundyWeddingSeeder --force
php artisan optimize:clear
```

The database migration adds a per-template price (stored in centavos), currency
and verified payment records. The wedding question seeder backfills video fields,
preserves existing template records and admin question settings, and can be
re-run without duplicating them.

## Set premium prices

In **Admin > Invitation Templates**, edit a design:

- **Premium-only design** toggle: when on, the design itself requires a paid
  upgrade before publishing; when off, its basic website remains free while the
  six optional premium features can be purchased.
- **Premium price (PHP centavos)**: 99900 = PHP 999.00, one-time.
- **Premium currency**: PHP.

Do not confuse `is_premium` with an account's entitlement. Payment is
granted only after verifying a Stripe session against the stored purchase
identifier, amount and currency; manually changing the field does not unlock
an account.

## Payments: required live setup

In the Hostinger application **.env**, configure:

```dotenv
STRIPE_SECRET_KEY=<your valid Stripe secret key>
STRIPE_WEBHOOK_SECRET=<your signing secret for the webhook endpoint>
```

Create a Stripe event destination at
`https://wewantyouthere.com/webhooks/stripe/wwyt` for events:

- `checkout.session.completed`
- `checkout.session.async_payment_succeeded`
- `checkout.session.expired`

Checkout remains unavailable until both secrets are configured. An
organization with a supported Stripe merchant account is required. Test a
real successful checkout, cancellation and failure before enabling paid ads.

## RSVP email setup

Set a working Laravel mail driver/provider in `.env` (SMTP, SES, Postmark,
Resend etc.). Configure `MAIL_FROM_ADDRESS` using a verified domain and test
mail deliverability, including SPF/DKIM/DMARC. Email goes to the invitation
owner's account email. RSVP submissions are saved even if email delivery
fails; failures are logged.

## Test premium permissions

1. Visit a free template, open section selection, click every locked premium
   tile, and verify the login/upgrade modal.
2. Publish a free invitation with basic names, date, venue and photos. Verify
   no RSVP submission form, embedded maps, programme, entourage or video
   appear in its public HTML. Invalid free-tier RSVP POST must be refused.
3. Buy a premium upgrade with a test payment, verify entitlement is not granted
   on a cancelled/unpaid session, then inspect the premium sections, video
   embed and real RSVP email.
4. Verify an already published free invitation can be upgraded from
   **My Invitations > Unlock premium** without deleting the website.
5. Check the builder and public preview on mobile before production launch.

## Search Console

The homepage title and H1 target **free wedding invitation website
Philippines**, with semantically related phrases **digital wedding
invitation**, **online wedding invitation maker**, **wedding website**,
**custom link** and **QR code**.

These are search-intent candidates informed by competitor content; this is not
a claim of measured search volume. Verify impressions and click-through data in
Google Search Console after indexing.

After deployment, submit `https://wewantyouthere.com/sitemap.xml` to
Search Console and request indexing of the homepage and
`/wedding-invitation-templates`. Do not submit guest invitation pages
(they use `noindex`). Product/demo imagery is licensed stock photography;
do not describe sample couples as customers.
