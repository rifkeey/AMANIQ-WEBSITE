# Launch and security checklists

## Launch checklist

### Content and claims
- [ ] Founder and Associate Consultant have approved their profiles, titles and credential wording
- [ ] Hissein Banaye Hassan's certifications are confirmed: exact names, levels and current status (`amaniq/data/team.php`)
- [ ] Genuine portraits added, or the monogram placeholders accepted for launch (`docs/CONTENT-GUIDE.md` → Team)
- [ ] Service and division wording reviewed by the founder
- [ ] No testimonials, client logos, statistics or partnerships appear unless verified
- [ ] Privacy Policy retention periods and data-transfer records confirmed (see PLACEHOLDERS.md)
- [ ] Founder has read and approved the final Privacy Policy and Terms of Use
- [ ] NDPC registration status checked (data controller of major importance, NDPA s.44)
- [ ] Decide whether to show a WhatsApp number (`company.php` → `whatsapp`)
- [ ] Company LinkedIn URL added if one exists

### Configuration
- [ ] `amaniq/` uploaded **beside** `public_html` (not inside), or the 403 check below passes
- [ ] `amaniq/config/config.php` created on the server from the example, permissions 600/640
- [ ] `env => 'production'`, `base_url => 'https://amaniqgroup.com'`
- [ ] `security.app_key` replaced with a long random value
- [ ] `contact@` password set in `config.php` on the server; SPF and DKIM valid in *Email Deliverability*
- [ ] One test enquiry per type arrives in the right division inbox with a copy in info@
- [ ] `info@amaniqgroup.com` exists and is monitored
- [ ] PHP 8.3 selected for the domain; `display_errors` off
- [ ] `academy.live` set correctly (false until the Academy platform is public)

### HTTPS and domain
- [ ] SSL active for `amaniqgroup.com` and `www.amaniqgroup.com`
- [ ] `force_https => true` after SSL works; `http://` and `www.` redirect to `https://amaniqgroup.com`

### Functional checks on the live site
- [ ] Every menu item, dropdown, footer link and CTA opens the right page (desktop and mobile)
- [ ] `/about/` loads (clean URLs work); otherwise set `pretty_urls => false`
- [ ] Contact form: a test enquiry arrives at `info@amaniqgroup.com`, and *Reply* goes to the sender's address
- [ ] Contact form: an empty submission shows field errors; nothing is sent
- [ ] Phone and email links work on a mobile phone
- [ ] `https://amaniqgroup.com/amaniq/config/config.php` → 403 or 404, never the file
- [ ] `https://amaniqgroup.com/.htaccess` → 403
- [ ] `https://amaniqgroup.com/sitemap.xml` and `/robots.txt` load
- [ ] A missing page (e.g. `/test-404/`) shows the branded 404 page
- [ ] Social preview checked (e.g. paste the URL into LinkedIn's Post Inspector)
- [ ] Lighthouse run on the home page and contact page (mobile and desktop); fix anything below expectations
- [ ] Security headers checked at securityheaders.com

### After launch
- [ ] Submit the sitemap in Google Search Console and Bing Webmaster Tools
- [ ] Create or claim the Google Business Profile with exactly the same name, address and phone number
- [ ] Set up a backup routine (`docs/MAINTENANCE.md`)

## Security checklist

- [ ] No secrets in Git: `amaniq/config/config.php` is in `.gitignore`; check with `git ls-files | grep config.php` (only `config.example.php` should appear)
- [ ] `config.php`, logs and sessions sit outside the web root
- [ ] `env` is `production` (errors hidden from visitors, logged privately)
- [ ] HTTPS forced; HSTS considered once HTTPS is stable
- [ ] SMTP mailbox password is unique, strong and used only by the website
- [ ] cPanel account protected with a strong password and two-factor authentication
- [ ] Response headers present: Content-Security-Policy, X-Frame-Options, X-Content-Type-Options, Referrer-Policy, Permissions-Policy
- [ ] Directory listing disabled (`Options -Indexes`; test `/assets/` → 403)
- [ ] Contact-form rate limit and spam checks tested (`tools/smoke-test.php` locally)
- [ ] Development files not uploaded (`tools/`, `docs/`, local `config.php`, `mail-outbox/`)
- [ ] Logs reviewed monthly for repeated mail failures or abuse
- [ ] PHP version kept supported (8.3 receives security fixes until the end of 2027)
