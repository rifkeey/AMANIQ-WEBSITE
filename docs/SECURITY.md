# Security overview

This describes what the site does to reduce risk, and what it does not do. No website is completely secure; these measures reduce the attack surface and the impact of common attacks.

## Design choices that reduce risk

- **No database, no logins, no admin panel, no file uploads.** There are no credentials to steal through the site and no SQL to inject.
- **No third-party PHP dependencies.** There is no Composer, framework or plugin ecosystem to keep patched. The SMTP client is about 150 lines in `amaniq/src/mailer.php`.
- **Code and secrets outside the web root.** Only `public_html/` is served. Configuration, source code, content data, logs and sessions are in `amaniq/`, beside it. A deny-all `.htaccess` inside `amaniq/` and a rewrite rule in the main `.htaccess` protect it if it is ever placed in the web root.

## Measures implemented

| Risk | Measure | Where |
|---|---|---|
| Cross-site scripting | All output escaped with `htmlspecialchars` (`e()`); strict Content-Security-Policy with a per-request nonce; no inline event handlers or styles | `src/helpers.php`, `src/http.php` |
| Cross-site request forgery | 256-bit CSRF token in the session, checked with `hash_equals`; SameSite=Lax cookie | `src/http.php`, `src/contact.php` |
| Email header injection | Control characters stripped from all header values; names and subjects MIME-encoded; Reply-To accepted only if it validates as an email address; body sent base64-encoded | `src/mailer.php` |
| Spam and abuse | Hidden honeypot field; minimum fill-in time (3 s); limit of 5 submissions per IP address per 15 minutes; maximum of 3 links per message; length limits on every field | `src/contact.php`, `src/rate_limit.php` |
| Clickjacking | `frame-ancestors 'none'` and `X-Frame-Options: DENY` | `src/http.php`, `.htaccess` |
| Session attacks | Strict mode, cookies only, HttpOnly, SameSite=Lax, Secure on HTTPS, ID regenerated after a successful submission, private session folder; sessions start only on the contact page | `src/http.php` |
| Open redirects / Host-header injection | Redirect targets are built from configured paths and `base_url`, never from user input or the Host header | `src/http.php`, `src/routes.php` |
| Path traversal | Routes accept only `[a-z0-9/._-]` without `..`; content and view names are whitelisted by pattern | `src/routes.php`, `src/view.php`, `src/helpers.php` |
| Information disclosure | `display_errors` off in production; generic 500 page; mail failures logged privately; `X-Powered-By` removed; directory listing off; backup, log and config file types blocked | `bootstrap.php`, `.htaccess` |
| False confirmations | Success is shown only after the mail server accepts the message; the development `log` transport refuses to run in production | `src/mailer.php` |
| Privacy | No analytics or tracking cookies; IP addresses stored only as salted hashes in rate-limit files deleted within about 24 hours; enquiry contents never written to logs | `src/rate_limit.php`, `src/contact.php` |
| Transport security | HTTPS redirect and optional HSTS; TLS 1.2+ with certificate verification for SMTP | `config.php`, `src/mailer.php` |
| Other browser features | `Permissions-Policy` disables camera, microphone, geolocation, payment and USB; `Referrer-Policy: strict-origin-when-cross-origin`; `nosniff` | `src/http.php` |

## Known limitations

- **Rate limiting is per IP address and file-based.** It stops casual abuse, not a distributed attack. If spam becomes a problem, add a privacy-respecting CAPTCHA (e.g. Cloudflare Turnstile) or put the site behind Cloudflare. If you use Cloudflare, set `trust_proxy_headers => true`.
- **Google Fonts** is loaded from Google's servers, so visitors' IP addresses reach Google. For maximum privacy, self-host the WOFF2 files under `assets/fonts/`, then remove the Google URLs from the layout and the CSP.
- **HSTS is off by default** so a certificate problem cannot lock visitors out. Enable it after HTTPS has been stable.
- **The shared hosting server's own security** (OS patches, PHP builds, other accounts on the server) is managed by GO54, not by this site.
- **The Terms of Use are a draft** pending professional review. The Privacy Policy follows the Nigeria Data Protection Act, 2023, but the company must keep its practices matching it (retention, transfer records, breach response).
- No automated malware scanning or file-integrity monitoring is included. cPanel's *Virus Scanner* or ImunifyAV, if offered, can provide this.

## Maintenance

- Keep PHP on a supported version (check php.net/supported-versions).
- Rotate the SMTP mailbox password if anyone who knew it leaves, and update `config.php`.
- Review `amaniq/storage/logs/` monthly.
- Re-run `tools/smoke-test.php` locally after any code change, before uploading.
- Report vulnerabilities to info@amaniqgroup.com. The Terms of Use invite responsible disclosure.
