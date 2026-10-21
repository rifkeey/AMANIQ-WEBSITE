# Test report

Tested on 21 October 2026, locally on Windows 11 with PHP 8.3.33's built-in server (`tools/dev-router.php`, which mirrors the `.htaccess` rules), Chrome headless, and the Claude in-app browser (Chromium).

## Tests performed and passed

### Automated end-to-end (`tools/smoke-test.php`): 52 / 52 passed
- All 20 pages return 200, each with exactly one `<h1>`, a title, a meta description and a canonical URL; no PHP warnings or notices in output; every title is unique
- Trailing-slash redirect (301), `/academy/` → `/divisions/academy/` (301), unknown pages and unknown service slugs → 404 with `noindex`
- Fallback URLs without rewriting (`/index.php?route=/team/`) work
- POST to any page other than `/contact/` → 405
- `sitemap.xml` (19 URLs; Insights excluded while empty) and `robots.txt`
- Security headers: CSP, X-Frame-Options, X-Content-Type-Options, Referrer-Policy; X-Powered-By removed; no cookies except on the contact page
- Blocked paths: `/amaniq/config/config.php`, `/amaniq/storage/logs/`, `/.htaccess`, `/.git/config`
- Reflected XSS attempt via query string is not echoed
- Session cookie is HttpOnly and SameSite=Lax
- Contact form: CSRF token present; invalid token rejected; too-fast submission rejected; honeypot rejected; server-side validation messages; HTML in input escaped on re-display; valid enquiry → 303 → one-time success message; rate limit triggers after repeated submissions

### Email
- **SMTP transport** against a local fake SMTP server (`tools/fake-smtp.php`): message delivered with correct headers, UTF-8 subject encoding and base64 body
- **Header injection:** CR/LF plus a `Bcc:` line in the subject and the reply-to name stayed inside the encoded header text; no extra header was created
- **Failure handling:** rejected authentication (535) and an unreachable server both raise an error. No success message is shown, and the reason is logged privately
- **Production mode:** with mail failing, visitors see an apology with the phone and email details and their input is preserved; no technical details are shown
- Development `log` transport output reviewed: all fields present, Reply-To set to the enquirer

### Links
- Crawl of all 31 internal URLs reachable from the home page: no broken links
- External links: Google Fonts (stylesheet and preconnect) and Google Maps only

### Browser checks
- Visual review of every page type at 1366 px (home, about, services, service detail, divisions, division detail, team, contact, privacy)
- At 375 px, no page scrolls horizontally on any of the 12 representative pages checked (only the decorative hero motif extends past the edge, and it is clipped)
- Mobile menu: opens, moves focus to the first link, locks page scroll, closes on Escape and returns focus to the toggle; focus is trapped while open
- Desktop dropdowns: open on click/keyboard, close on Escape with focus returned; the current page is highlighted in the menu and sub-menu
- No JavaScript errors and no CSP violations from the site's own scripts and styles (the only console error was from a deliberate framing test, which the CSP correctly blocked)
- Fonts load (Newsreader, Manrope)
- Reduced-motion rendering (`--force-prefers-reduced-motion`): all content visible without animation
- Production build: `site.min.css` is served in production mode and renders identically

### Static checks
- `php -l` on all 44 PHP files: no syntax errors

## Not fully verified

- **Animation smoothness:** The in-app browser pane was hidden during testing, which pauses CSS animations, so motion was confirmed by code review and by checking state, not watched live. Review the hero load, scroll reveals, card hovers and FAQ accordion in a normal browser.
- **Real devices:** Not tested on physical iPhone or Android devices, or in Safari and Firefox. The CSS uses widely supported features (grid, `clamp()`, `aspect-ratio`, `inset`); Safari 15+ and current Firefox should be fine.
- **Lighthouse and Core Web Vitals:** Not measured. Run them on the live site; scores depend on the host and CDN.
- **Screen readers:** Structure, labels, landmarks and focus management follow accessibility practice, but the site was not tested with NVDA or VoiceOver.

## Requires the live hosting environment

- Apache `.htaccess` behaviour on GO54 (`mod_rewrite`, headers, caching, file blocking); locally the dev router emulated it
- Real SMTP delivery through the GO54 mail server, SPF/DKIM alignment and inbox placement
- HTTPS redirect, `www` → apex redirect and HSTS
- File permissions and writability of `amaniq/storage/`
- PHP 8.3 availability and extensions on the purchased plan

## Requires credentials or configuration

- SMTP mailbox and password
- `security.app_key`
- WhatsApp number, LinkedIn URLs, team portraits (optional)
- Confirmation of the Privacy Policy retention periods and data-transfer records (see PLACEHOLDERS.md)
