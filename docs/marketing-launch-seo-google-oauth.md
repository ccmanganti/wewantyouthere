# WWYT — SEO Landing and Google Authentication Launch
Updated November 4, 2026.

## Positioning and competitor research
Ambitious, honest copy: "THE NEXT BIG HOME FOR DIGITAL INVITATIONS", "YOUR BIGGEST MOMENTS. beautifully invited." Avoid "#1", "largest", false usage statistics or testimonials.

Competitive references:
- Zola https://www.zola.com/wedding-planning/website : free wedding sites, templates, guest tools
- InviteKo https://inviteko.com/ : Filipino wedding website builder with clear steps
- Saya Invitations https://sayainvitations.com/about : event-type questions and invitations
- inviteyou.love https://www.inviteyou.love/ : Filipino multi-event invitation maker
- Google SEO guidance https://developers.google.com/search/docs/fundamentals/seo-starter-guide

## Search-intent keyword clusters (not measured search volumes)
Primary: free wedding invitation website maker; digital wedding invitation Philippines; online wedding invitation maker Philippines; wedding website maker; free wedding website Philippines.
Templates: wedding invitation website templates; wedding website invitation templates; editable online wedding invitation; elegant digital wedding invitation template.
Features: wedding website with QR code; shareable wedding invitation link; wedding website entourage; wedding invitation ninong and ninang; wedding program website invitation.

Do not use meta-keywords tags or repeat keywords unnaturally. Search Console and Keyword Planner can supply measured demand after launch.

## Live site structure
- / : SEO landing with real value proposition, templates, free plan and FAQ.
- /wedding-invitation-templates : indexed gallery, full live previews.
- /wedding-invitation-templates/{slug} : distinct indexed detail content.
- /templates/{slug}/preview : example site, noindex.
- /templates/wedding/{slug} : noindex guided builder.
- /i/{slug} : noindex shareable invitation.
- /privacy, /terms : public policies.
- /sitemap.xml, /robots.txt : dynamic SEO outputs.
- /app/login, /app/register : customer Filament authentication.
- /auth/google/redirect, /auth/google/callback : official Socialite OAuth.

Only templates supported by the built-in renderer appear for public use. Untrusted uploaded HTML must not execute publicly without sanitization and security checks. Free website, share link and base QR are live; premium guest-specific QR, RSVP collection and video/printed exports are coming soon.

Brand: Cotton #EDEBDD, Cherry Red #810100, Maroon #630000, Noir Black #1B1717. Gold is a restrained highlight. Motion should honor reduced-motion settings.

## Google OAuth production activation
The official laravel/socialite package has been installed into the repository with a committed lockfile. Do not commit real credentials.

1. In Google Cloud Console, configure a project and the Google Auth Platform branding and consent screen. Set app name, support email, authorized domain wewantyouthere.com, and public Privacy and Terms URLs.
2. Create OAuth Client ID of type Web application.
3. Authorized JavaScript origin: https://wewantyouthere.com
4. Authorized redirect URI: https://wewantyouthere.com/auth/google/callback
5. Set these secrets ONLY in the Hostinger Laravel application .env:
   APP_URL=https://wewantyouthere.com
   GOOGLE_CLIENT_ID=(Google OAuth Client ID)
   GOOGLE_CLIENT_SECRET=(Google OAuth Client Secret)
   GOOGLE_REDIRECT_URI=https://wewantyouthere.com/auth/google/callback
6. Run php artisan optimize:clear.
7. Test signup via a new verified Google account; a verified email already used on the site; declined OAuth consent; and resuming a wedding publication.

Google sign-in buttons stay hidden until client ID and secret are configured; email login remains functional. The callback uses session-based OAuth state validation, requires Google-verified email, and refuses to overwrite another Google ID. Google API tokens are never stored.

Google production policies require a verified domain, public homepage and appropriate privacy policy. The included legal content is an initial draft that the operator should review for accuracy before activating public Google authentication.

## Hostinger deployment
From the Laravel app directory (not public_html):
  git pull origin main
  composer install --no-dev --optimize-autoloader
  php artisan migrate --force
  php artisan optimize:clear
  php artisan filament:cache-components

If the starter wedding template has not been seeded:
  php artisan db:seed --class=WeddingBuilderSeeder --force

No npm or Vite build is needed for the landing page. Composer install is required because Laravel Socialite added a dependency.

## Search indexing
Verify wewantyouthere.com in Google Search Console; submit https://wewantyouthere.com/sitemap.xml; inspect the homepage, gallery and detail pages for crawling/indexing. Google does not guarantee rankings. Use actual Search Console impressions and query data to revise copy.

## Visual and functionality smoke tests
- Responsive marketing navigation and template previews, motion and reduced-motion mode.
- Template details, full demo and create links; builder drafts/resume still work.
- Free plan still limits site creation to one.
- Customer login, registration, Google authentication after credentials configured, and dashboard.
- Published invitation remains a separate fullscreen wedding site, not platform branding.
