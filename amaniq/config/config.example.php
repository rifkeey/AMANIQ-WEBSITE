<?php
/*
 * AMANIQ website configuration — TEMPLATE.
 *
 * Copy this file to config.php in the same folder and fill in real values.
 * config.php is excluded from Git and must never be placed inside public_html.
 * Secrets can also be supplied as environment variables (see getenv() below),
 * which keeps them out of files entirely where the host supports it.
 */
return [
    // 'production' hides PHP errors from visitors. Use 'development' only on your own computer.
    'env' => 'production',

    // Full public address of the site, without a trailing slash.
    'base_url' => 'https://amaniqgroup.com',

    // true when Apache mod_rewrite works (clean URLs such as /about/).
    // false falls back to /index.php?route=/about/ links.
    'pretty_urls' => true,

    // Redirect HTTP → HTTPS. Turn on only after the SSL certificate is active.
    'force_https' => true,

    // Redirect other host names (e.g. www.amaniqgroup.com) to the base_url host.
    'canonical_host_redirect' => true,

    // Strict-Transport-Security header value, or '' to disable. Enable once HTTPS
    // has worked reliably for a while, e.g. 'max-age=31536000'. Add includeSubDomains
    // only when every subdomain (academy., mail. ...) serves HTTPS.
    'hsts' => '',

    // Set true only if the site sits behind a proxy/CDN such as Cloudflare.
    'trust_proxy_headers' => false,

    'timezone' => 'Africa/Lagos',

    // AMANIQ Academy. Set 'live' => true once academy.amaniqgroup.com is open to the public.
    'academy' => [
        'url' => 'https://academy.amaniqgroup.com',
        'live' => false,
    ],

    // Shows a "pending legal review" notice on the privacy and terms pages.
    // Set to false after a qualified adviser has reviewed both pages.
    'legal_review_pending' => true,

    'mail' => [
        // 'smtp' (recommended), 'mail' (PHP mail()), or 'log' (development only).
        'transport' => 'smtp',
        // cPanel mailbox settings are shown under Email Accounts → Connect Devices.
        'host' => getenv('AMANIQ_SMTP_HOST') ?: 'mail.amaniqgroup.com',
        'port' => (int) (getenv('AMANIQ_SMTP_PORT') ?: 465),
        // 'ssl' for port 465, 'tls' (STARTTLS) for port 587.
        'encryption' => getenv('AMANIQ_SMTP_ENCRYPTION') ?: 'ssl',
        'username' => getenv('AMANIQ_SMTP_USERNAME') ?: 'website@amaniqgroup.com',
        'password' => getenv('AMANIQ_SMTP_PASSWORD') ?: '',
        'verify_peer' => true,
        'timeout' => 15,
        // Must be a mailbox on amaniqgroup.com so SPF/DKIM checks pass.
        'from_email' => 'website@amaniqgroup.com',
        'from_name' => 'AMANIQ Website',
        // Where enquiries are delivered.
        'to_email' => 'info@amaniqgroup.com',
    ],

    'security' => [
        // Long random string used to hash rate-limit keys. Generate one with:
        //   php -r "echo bin2hex(random_bytes(32));"
        'app_key' => 'REPLACE_WITH_A_LONG_RANDOM_STRING',
        // Contact form: at most 'max' submissions per IP address per 'window' seconds.
        'contact_rate_limit' => ['max' => 5, 'window' => 900],
        // Submissions faster than this (seconds after the page loaded) are treated as automated.
        'min_form_seconds' => 3,
    ],
];
