# Invitation template architecture (v1)

## Model
- EventType owns a shared set of EventQuestion definitions. The questions are reused across every template for that event.
- InvitationTemplate selects an EventType and stores an HTML source path on a **private** storage disk. It can later gain a component-based renderer alongside the static HTML renderer.
- InvitationWebsite belongs to a user and template, stores questionnaire answers as JSON, an optional custom domain, and a separate domain verification status.
- Admin resources use modal create/edit and inline toggles/dropdowns. No edit pages.

## HTML placeholders
Use simple escaped tokens, e.g. `{{bride_name}}`, `{{groom_name}}`, `{{event_date}}`, `{{principal_sponsors}}`.
The renderer substitutes only enabled event question keys and HTML-escapes values.
Do not run Blade, PHP, JavaScript, or third-party scripts from uploaded templates.
**Security requirement before public rendering:** sanitize uploaded HTML with an allowlist HTML sanitizer and enforce a strict Content-Security-Policy. Uploaded HTML is untrusted, including SVG, CSS imports, event attributes, scripts and remote resources. The current renderer is a data substitution utility, NOT a safe public HTML endpoint.

## Domain workflow
A custom domain field is only a requested hostname. Never route arbitrary domains to invitations until domain ownership has been verified using DNS TXT or equivalent proof, followed by TLS provisioning and hostname allowlisting. Publishing and domain activation are separate states.

## Planned hybrid extension
A future `renderer_type` field can select `static_html` or `components`; a versioned component manifest and per-section configuration can be introduced without changing the EventType/EventQuestion/InvitationWebsite contracts.
