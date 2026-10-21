# Content guide

All editable content lives in `amaniq/data/` as plain PHP arrays. Edit a file, save it, and upload it to the same place on the server; there is no build step. Keep straight quotes `'…'` around values. Use typographic apostrophes (’) inside text, or escape straight ones as `\'`.

After editing, check the file for syntax errors before uploading:

```bash
php -l amaniq/data/team.php
```

## Contact details, address, WhatsApp, LinkedIn

`amaniq/data/company.php` drives the header, footer, contact page, legal pages and structured data.

- `phone`: shown as written; the `tel:` link is generated automatically.
- `whatsapp`: digits only in international format (e.g. `2347085953567`). An empty value hides the WhatsApp link.
- `map_url`: the Google Maps link used on the contact page and in the footer.
- `linkedin`: the company page URL. It is added to the structured data when set.

The enquiry recipient address is set separately in `config.php` → `mail.to_email`.

## Services

`amaniq/data/services.php`: one entry per service area, keyed by URL slug.

- **Edit wording:** change `summary` (cards and meta description), `intro` (paragraphs) or `offerings` (`['Title', 'Description']` pairs).
- **Add a service:** copy an entry, give it a new key and `slug` (lower-case, hyphens), and pick an `icon` (`shield`, `server`, `compass`, `layers`, `book` or `package`). Its page appears at `/services/{slug}/`, and it is added automatically to the menu, footer, sitemap and services page.
- `division`: the slug of the division that delivers it, or `null`.
- `enquiry`: the contact-form category preselected by its buttons (see `enquiry_types()` in `amaniq/src/contact.php`).

Do not add accreditations, vendor partnerships or outcomes unless they are verified.

## Divisions

`amaniq/data/divisions.php`: the four divisions. Every division page states "A division of AMANIQ Projects Limited". Keep that wording while the divisions are not separate companies.

Division accent colours are set in `public_html/assets/css/site.css` (`--acc-technologies`, `--acc-consulting`, `--acc-digital-labs`, `--acc-academy`).

### Moving a division to its own site or subdomain

Set `external_url`, e.g. `'external_url' => 'https://labs.amaniqgroup.com'`. The division page stays on the main site as an introduction, and its main button links to the external site.

## Team

`amaniq/data/team.php`: people are shown in the order listed.

- **Add a person:** copy an entry, change the key and `slug`, and fill in the fields. Set `featured => true` on one person only to show them on the home page.
- **Photos:** save a genuine portrait as WebP or JPEG, 4:5 ratio, at least 640×800 px, under `public_html/assets/img/team/`, e.g. `mohammed-ibrahim.webp`. Then set `'photo' => 'img/team/mohammed-ibrahim.webp'`. Until a photo is set, a monogram placeholder is shown. Never use AI-generated or stock portraits of real people.
- **Credentials:** `qualifications` are `['Abbreviation', 'Full name']` pairs. Confirm exact names and current status with the person before publishing.

## AMANIQ Academy

The Academy page is `/divisions/academy/` (the menu's *Academy* link; `/academy/` redirects there).

When the learning platform at `academy.amaniqgroup.com` is open to the public, set in `config.php`:

```php
'academy' => ['url' => 'https://academy.amaniqgroup.com', 'live' => true],
```

The page then links to the platform instead of asking visitors to register interest.

### How the Academy subdomain fits

The corporate site and the Academy are separate applications. The corporate site has no logins, payments or learner data, which keeps its attack surface small. To run the Academy (the separate Laravel application in the ACADEMY-laravel repository) on `academy.amaniqgroup.com`:

1. cPanel → *Domains* → create the subdomain `academy.amaniqgroup.com` with its **own** document root (e.g. `/home/USERNAME/academy/public`).
2. Deploy the Academy application there, with its own configuration, database and SSL certificate.
3. Set `academy.live => true` here.

The same pattern applies to future AMANIQ Digital Labs products: give each one its own subdomain and application, and link to it via `external_url` or a page on this site.

## Insights articles

`amaniq/data/insights.php` contains a documented example. Each article needs a `slug`, `title`, `summary`, `category`, `date` (YYYY-MM-DD), optional `author` (a team slug) and `body` paragraphs (use `['h2', 'Heading']` for sub-headings).

Publishing the first article automatically makes the Insights page indexable and adds it, with its articles, to the sitemap. Do not publish placeholder or invented articles.

## Adding a new page

1. Create the view `amaniq/views/pages/my-page.php`. Copy `about.php` as a starting point; it uses `partial('page-hero', …)` and the standard section classes.
2. Add a controller function in `amaniq/src/routes.php`:

```php
function page_my_page(): void
{
    page('my-page', [
        'title' => 'My Page',
        'description' => 'One or two sentences for search results.',
        'breadcrumbs' => [['My Page', '/my-page/']],
    ]);
}
```

3. Register the route in the `$pages` array in `dispatch()`: `'/my-page/' => 'page_my_page',`
4. Add the path to `sitemap_paths()`, and link it from the header (`views/partials/header.php`) or footer (`views/partials/footer.php`) if needed.

## Legal pages

The Privacy Policy (`amaniq/views/pages/privacy.php`) is written to meet section 27 of the Nigeria Data Protection Act, 2023. It states purposes, lawful bases, recipients, transfers, retention periods, rights and the right to complain to the NDPC. Whenever the site starts collecting new personal data (analytics, a newsletter, accounts, new forms), update its purposes table, recipients and retention periods **before** the change goes live, and change the `$updated` date.

The Terms of Use still show a "Draft pending legal review" notice. After a qualified adviser has reviewed them, update `terms.php` and its `$updated` date, then set `'legal_review_pending' => false` in `config.php`.

## Logo and brand images

- The wordmark in the header and footer is drawn from vector geometry in `amaniq/src/view.php` (`wordmark()`), identical to the approved brand files. Standalone copies are in `public_html/assets/img/brand/amaniq-wordmark-{dark,light}.svg`.
- Favicons, app icons, `amaniq-logo-512.png` and the social-sharing image `og-default.png` are generated by `tools/make-brand-images.mjs`. To use a designer-supplied image instead, replace the file using the same name and dimensions (social image: 1200×630).

## Styles and scripts

- Design tokens (colours, fonts, spacing) are at the top of `public_html/assets/css/site.css`. After editing, run `php tools/build-assets.php` and upload both `site.css` and `site.min.css`.
- Behaviour is in `public_html/assets/js/site.js`.
