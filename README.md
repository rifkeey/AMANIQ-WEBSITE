# AMANIQ Projects Limited — corporate website

The public website for **AMANIQ Projects Limited** (RC 9945758), served at **amaniqgroup.com**.

It is built in plain PHP 8.3, HTML, CSS and vanilla JavaScript, so it runs on ordinary Linux shared hosting (GO54/cPanel) without Node.js, Composer, a framework or a database.

## What's included

| Area | Pages |
|---|---|
| Company | Home, About, Mission/Vision/Values, Meet the Team |
| Services | Services overview plus six service pages (`/services/{slug}/`) |
| Divisions | Divisions overview plus four division pages (`/divisions/{slug}/`); `/academy/` redirects to the Academy page |
| Conversion | Contact page with a secure enquiry form, FAQ, and enquiry shortcuts that preselect the enquiry type |
| Legal | Privacy Policy (written against the Nigeria Data Protection Act, 2023) and Terms of Use |
| Growth | Insights section with an article template; hidden from search engines until real articles exist |
| SEO | Unique titles and descriptions, canonical URLs, Open Graph tags, JSON-LD structured data, `sitemap.xml`, `robots.txt`, favicons |

## Project layout

```
AMANIQGROUP/
├── public_html/              ← the web root: upload into the server's public_html
│   ├── index.php             front controller (every page request goes through here)
│   ├── .htaccess             clean URLs, file blocking, security headers, caching
│   ├── robots.txt, site.webmanifest
│   └── assets/
│       ├── css/site.css      design system (site.min.css is the production build)
│       ├── js/site.js        navigation, scroll reveals, accordion, form validation
│       └── img/brand/        logo SVGs, favicons, app icons, social-sharing image
├── amaniq/                   ← PRIVATE application folder: upload beside public_html, never inside it
│   ├── bootstrap.php
│   ├── config/               config.example.php (template), config.php (real settings, not in Git)
│   ├── data/                 editable content: company, services, divisions, team, insights
│   ├── src/                  routing, security, mailer, contact form, SEO helpers
│   ├── views/                layout, partials (header, footer, cards…), pages, error pages
│   └── storage/              logs, sessions, rate-limit records (must be writable)
├── tools/                    local development tools (not uploaded)
└── docs/                     deployment, content, security and testing guides
```

Every request is handled by `public_html/index.php`, which loads `amaniq/bootstrap.php` from the folder beside `public_html`. Configuration, secrets, logs and source code are therefore outside the web root.

## Run it locally

You need PHP 8.1 or newer (8.3 recommended) with the `mbstring`, `openssl` and `curl` extensions.

```bash
cp amaniq/config/config.example.php amaniq/config/config.php   # then set env => 'development', base_url => 'http://127.0.0.1:8080'
php -S 127.0.0.1:8080 -t public_html tools/dev-router.php
```

Open http://127.0.0.1:8080. In development, the mail transport `log` writes enquiries to `amaniq/storage/mail-outbox/` instead of sending them.

## Tools

| Command | Purpose |
|---|---|
| `php tools/smoke-test.php http://127.0.0.1:8080` | End-to-end checks: every page, redirects, headers, blocked paths, full contact-form flow |
| `php tools/build-assets.php` | Rebuild `site.min.css` after editing `site.css` |
| `php tools/fake-smtp.php 2525 <folder>` | Local fake SMTP server for testing the SMTP transport |
| `node tools/make-brand-images.mjs <path-to-node_modules>` | Regenerate favicons, icons and the social image (needs `@resvg/resvg-js`) |

## Documentation

- [docs/DEPLOYMENT-GO54.md](docs/DEPLOYMENT-GO54.md): step-by-step deployment to GO54 shared hosting, including the file mapping, SMTP setup and hosting prerequisites
- [docs/CONTENT-GUIDE.md](docs/CONTENT-GUIDE.md): editing contact details, services, divisions and team, adding pages and articles, and setting up the Academy subdomain
- [docs/CHECKLISTS.md](docs/CHECKLISTS.md): launch checklist and security checklist
- [docs/SECURITY.md](docs/SECURITY.md): the security measures implemented, their limits, and maintenance
- [docs/PLACEHOLDERS.md](docs/PLACEHOLDERS.md): items still needing real company assets or decisions
- [docs/TEST-REPORT.md](docs/TEST-REPORT.md): what was tested, the results, and what can only be tested on the live host
- [docs/MAINTENANCE.md](docs/MAINTENANCE.md): backups, updates and routine maintenance

## Content policy

The site publishes only facts supplied by the company. It contains no client logos, testimonials, awards, statistics, partnerships or accreditations. Keep it that way unless a claim has been verified. Individual team members' professional backgrounds are described as their own careers, not as company track record.
