# Deploying to GO54 shared hosting

This guide assumes a GO54 (or other cPanel) Linux hosting plan with the domain `amaniqgroup.com` pointed at it.

## 1. Hosting prerequisites to verify

Check these in cPanel before uploading. The site cannot work without the first four.

| Requirement | Where to check | Notes |
|---|---|---|
| PHP 8.1+ (8.3 recommended) | cPanel → *Select PHP Version* or *MultiPHP Manager* | Set for the domain. |
| PHP extensions `mbstring`, `openssl`, `json`, `session`, `curl` (`filter` and `ctype` are on by default) | *Select PHP Version* → Extensions | `openssl` is required for SMTP over SSL/TLS. |
| Apache `mod_rewrite` | Usually on; test after upload | If clean URLs return 404, set `'pretty_urls' => false` (see §8). |
| Outbound SMTP from PHP to your mail server | Test with the contact form | Some hosts block outbound ports 465/587; using the host's own mail server (`mail.amaniqgroup.com`) normally works. |
| The sending mailbox `contact@amaniqgroup.com` (already created) | cPanel → *Email Accounts* | The site authenticates with this mailbox (SMTP only; no POP/IMAP needed). |
| Free SSL certificate (AutoSSL / Let's Encrypt) | cPanel → *SSL/TLS Status* | Needed before enabling `force_https`. |
| `mod_headers`, `mod_expires`, `mod_deflate` | Optional | Used if present; ignored safely if not. |

No database, Node.js, Composer, cron job or SSH access is required.

## 2. File mapping

On cPanel the home folder (e.g. `/home/USERNAME/`) contains `public_html/`, the domain's document root. Upload as follows:

| Local (this project) | Server destination |
|---|---|
| `public_html/*` (including the hidden `.htaccess`) | `/home/USERNAME/public_html/` |
| `amaniq/` (the whole folder) | `/home/USERNAME/amaniq/`, **beside** `public_html`, not inside it |
| `tools/`, `docs/`, `README.md`, `.gitignore` | **Do not upload** |
| `amaniq/config/config.php` from your computer | **Do not upload** — create it on the server (§4) |
| `amaniq/storage/*` contents (logs, outbox) | **Do not upload** — upload the empty folders only |

The result on the server:

```
/home/USERNAME/
├── amaniq/            private: code, content, config, storage
└── public_html/       public: index.php, .htaccess, assets/, robots.txt …
```

**The rule:** `index.php` looks for `amaniq/` in the folder that *contains* the web root. If the domain is an addon domain with the document root `/home/USERNAME/amaniqgroup.com/`, upload the contents of `public_html/` into `/home/USERNAME/amaniqgroup.com/` and put `amaniq/` at `/home/USERNAME/amaniq/`.

As a last resort, `amaniq/` may go *inside* the web root, where `index.php` also looks. Its own `.htaccess` and the main `.htaccess` both deny web access to it. In that case, verify that `https://amaniqgroup.com/amaniq/config/config.php` returns **403**.

### Uploading

Use cPanel *File Manager* (upload a ZIP, then *Extract*) or SFTP. If you upload a ZIP, check that hidden files such as `.htaccess` were included (File Manager → *Settings* → *Show Hidden Files*).

## 3. PHP version

cPanel → *MultiPHP Manager* (or *Select PHP Version*): set **PHP 8.3** for `amaniqgroup.com`. In *MultiPHP INI Editor* confirm:

- `display_errors = Off`
- `log_errors = On`

(The site also enforces these in production mode.)

## 4. Configuration

1. In File Manager, open `/home/USERNAME/amaniq/config/`.
2. Copy `config.example.php` to `config.php`.
3. Edit `config.php`:
   - `'env' => 'production'`
   - `'base_url' => 'https://amaniqgroup.com'`
   - `'force_https' => false` **until** SSL is active (§6), then `true`
   - `security.app_key`: a long random string. Generate one on your computer with `php -r "echo bin2hex(random_bytes(32));"` or any password generator (64+ characters).
   - the `mail` settings (§5)
4. Permissions: set `config.php` to **600** (or 640 if 600 causes errors).

`config.php` contains the SMTP password. It sits outside `public_html` and is never served. Do not email it or store it in Git.

## 5. Email (SMTP)

The site **only sends** email, using SMTP. It never reads mail, so POP/IMAP settings are not needed.

**Mailboxes and their roles**

| Mailbox | Role | Shown on the site? |
|---|---|---|
| `info@` | Public address; receives general, procurement and partnership enquiries, plus a copy of every enquiry | Yes |
| `contact@` | The website's private sending mailbox. The site logs in with it to send enquiries | No |
| `technologies@`, `consulting@`, `digitallabs@`, `academy@` | Receive enquiries of their division's type (see the routing table) | No |
| `mohammed.ibrahim@` | Personal mailbox; not used by the website | No |

**Routing** (`mail.routing` and `mail.copy_to` in `config.php`)

| Enquiry type on the form | Delivered to | Copy to |
|---|---|---|
| Cybersecurity and IT | technologies@ | info@ |
| Consulting | consulting@ | info@ |
| Digital products | digitallabs@ | info@ |
| Training and Academy | academy@ | info@ |
| Procurement, Partnerships, General enquiries | info@ | (none needed) |

Replying to any enquiry email goes straight to the person who sent it.

**Setup**

1. Give `contact@amaniqgroup.com` a strong, unique password used for nothing else (cPanel → *Email Accounts* → *Manage* → *Security*).
2. cPanel → *Email Accounts* → *Connect Devices* on `contact@` shows the outgoing (SMTP) server and port. Put them, with the password, into `amaniq/config/config.php` **on the server**. Never send the password by email or chat, and never store it in Git. Typical values:

```php
'mail' => [
    'transport'   => 'smtp',
    'host'        => 'mail.amaniqgroup.com',
    'port'        => 465,
    'encryption'  => 'ssl',          // or port 587 with 'tls'
    'username'    => 'contact@amaniqgroup.com',
    'password'    => 'THE-CONTACT-MAILBOX-PASSWORD',
    'verify_peer' => true,
    'from_email'  => 'contact@amaniqgroup.com',
    'from_name'   => 'AMANIQ Website',
    // to_email, routing and copy_to are already set in the example file
],
```

3. Make sure someone monitors every receiving mailbox, or set a forwarder to info@ for any that won't be checked.
4. cPanel → *Email Deliverability*: make sure SPF and DKIM are valid for the domain, so enquiries are not marked as spam.
5. Submit one test enquiry of each type on the live site and check it arrives in the right inbox with a copy in info@. A success message appears **only** if the mail server accepted the message. If sending fails, visitors see an apology with the phone number and email address, and the technical reason is written to `amaniq/storage/logs/app-YYYY-MM.log`.

If the certificate on `mail.amaniqgroup.com` does not match (some shared servers use the server's own hostname), use the hostname shown in *Connect Devices* as `host`. Only set `verify_peer => false` as a last resort.

**Fallback:** `'transport' => 'mail'` uses PHP's `mail()` function, if the host allows it. SMTP is more reliable and is preferred.

## 6. Domain and HTTPS

1. Domain DNS: point `amaniqgroup.com` and `www` to the GO54 server (GO54 nameservers or A records).
2. cPanel → *SSL/TLS Status* → run AutoSSL for `amaniqgroup.com` and `www.amaniqgroup.com`.
3. Once `https://amaniqgroup.com` loads with a valid padlock, set `'force_https' => true` in `config.php`. HTTP requests and `www.` requests are then redirected to `https://amaniqgroup.com`.
4. Optional, after a few weeks of trouble-free HTTPS: set `'hsts' => 'max-age=31536000'`. Do not add `includeSubDomains` until every subdomain (`academy.`, `mail.` and so on) serves HTTPS.

## 7. File permissions

| Path | Permission |
|---|---|
| Folders | 755 |
| Files | 644 |
| `amaniq/config/config.php` | 600 (or 640) |
| `amaniq/storage/` and its sub-folders | 755, writable by PHP (usual on cPanel, where PHP runs as your user) |

If enquiries fail with a "storage not writable" message in the error log, make `amaniq/storage/*` folders 775.

## 8. URL rewriting

Visit `https://amaniqgroup.com/about/`. If you get a 404 while the home page works, either:

- ask GO54 support to enable `mod_rewrite` / `AllowOverride FileInfo`, or
- set `'pretty_urls' => false` in `config.php`. Links then use `/index.php?route=/about/`, which works without rewriting.

## 9. Production error logging

- PHP errors: `amaniq/storage/logs/php-errors.log`
- Application events (sent enquiries, mail failures, spam rejections): `amaniq/storage/logs/app-YYYY-MM.log`. Message contents and visitor details are never logged.

Visitors only ever see a generic error page.

## 10. After deployment

1. Work through the launch checklist in [CHECKLISTS.md](CHECKLISTS.md).
2. Run the smoke test against the live site from your computer only if you accept a few test emails: `php tools/smoke-test.php https://amaniqgroup.com --skip-rate-limit`
3. Submit `https://amaniqgroup.com/sitemap.xml` in Google Search Console and Bing Webmaster Tools.

## 11. Updating the site later

Upload only the changed files to the same locations. Your `config.php` and the `storage` folder stay untouched. After changing `site.css`, run `php tools/build-assets.php` and upload `site.min.css` too.

## Database

The site does not use a database. If one is added later (for example for an Insights CMS), create it in cPanel → *MySQL Databases*, store its credentials in `config.php`, and use PDO prepared statements only.

## Backups

See [MAINTENANCE.md](MAINTENANCE.md).
