<?php
declare(strict_types=1);

/** Reads a configuration value using dot notation, e.g. config('mail.host'). */
function config(string $key, mixed $default = null): mixed
{
    $value = $GLOBALS['amaniq_config'] ?? [];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function is_production(): bool
{
    return config('env', 'production') !== 'development';
}

/** Escapes a value for HTML text and attribute contexts. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
}

/** Loads an editable content file from amaniq/data once per request. */
function content(string $name): array
{
    static $cache = [];
    if (!isset($cache[$name])) {
        if (!preg_match('/^[a-z_]+$/', $name)) {
            throw new InvalidArgumentException('Invalid content name.');
        }
        $cache[$name] = require APP_ROOT . '/data/' . $name . '.php';
    }
    return $cache[$name];
}

/** Company details (name, contact information, address) from data/company.php. */
function company(string $key, mixed $default = null): mixed
{
    $value = content('company');
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

function service(string $slug): ?array
{
    return content('services')[$slug] ?? null;
}

function division(string $slug): ?array
{
    return content('divisions')[$slug] ?? null;
}

/** Path prefix when the site is installed in a sub-folder, taken from base_url. */
function base_path(): string
{
    static $path = null;
    return $path ??= rtrim((string) parse_url((string) config('base_url', ''), PHP_URL_PATH), '/');
}

/** Scheme, host and port of the configured base URL. */
function site_origin(): string
{
    $parts = parse_url((string) config('base_url', 'https://amaniqgroup.com'));
    return ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? 'amaniqgroup.com')
        . (isset($parts['port']) ? ':' . $parts['port'] : '');
}

/**
 * Builds an internal link. With clean URLs on, "/about/" stays "/about/";
 * without URL rewriting it becomes "/index.php?route=/about/".
 */
function url(string $path = '/', array $query = []): string
{
    $fragment = null;
    if (str_contains($path, '#')) {
        [$path, $fragment] = explode('#', $path, 2);
    }
    $path = '/' . ltrim($path, '/');

    if (config('pretty_urls', true)) {
        $out = base_path() . $path . ($query ? '?' . http_build_query($query) : '');
    } else {
        $params = $path === '/' ? $query : ['route' => $path] + $query;
        $out = base_path() . '/index.php' . ($params ? '?' . str_replace('%2F', '/', http_build_query($params)) : '');
    }
    return $out . ($fragment !== null ? '#' . $fragment : '');
}

function absolute_url(string $path = '/', array $query = []): string
{
    return site_origin() . url($path, $query);
}

/** Public asset URL with a modification-time version for cache busting. */
function asset(string $path): string
{
    $file = PUBLIC_ROOT . '/assets/' . ltrim($path, '/');
    $version = is_file($file) ? '?v=' . filemtime($file) : '';
    return base_path() . '/assets/' . ltrim($path, '/') . $version;
}

/** Stylesheet to serve: the minified build in production when it exists. */
function stylesheet(): string
{
    return is_production() && is_file(PUBLIC_ROOT . '/assets/css/site.min.css') ? asset('css/site.min.css') : asset('css/site.css');
}

/** The route currently being served, e.g. "/services/cybersecurity/". */
function current_path(?string $set = null): string
{
    static $path = '/';
    if ($set !== null) {
        $path = $set;
    }
    return $path;
}

function is_current(string $path, bool $includeChildren = false): bool
{
    $current = current_path();
    return $includeChildren ? str_starts_with($current, $path) : $current === $path;
}

/** Per-request nonce allowing the site's own small inline scripts under the CSP. */
function csp_nonce(): string
{
    static $nonce = null;
    return $nonce ??= base64_encode(random_bytes(18));
}

/** Writes a line to the private application log. Never log message bodies or passwords. */
function app_log(string $level, string $message, array $context = []): void
{
    $dir = STORAGE_ROOT . '/logs';
    if (!is_dir($dir) && !@mkdir($dir, 0750, true)) {
        error_log("AMANIQ [$level] $message");
        return;
    }
    $line = date('c') . " [$level] $message" . ($context ? ' ' . json_encode($context, JSON_UNESCAPED_SLASHES) : '');
    @file_put_contents($dir . '/app-' . date('Y-m') . '.log', $line . PHP_EOL, FILE_APPEND | LOCK_EX);
}

/** Telephone link target in E.164 form, e.g. tel:+2347085953567. */
function tel_href(): string
{
    return 'tel:' . preg_replace('/[^0-9+]/', '', (string) company('phone'));
}

function whatsapp_href(): ?string
{
    $number = preg_replace('/\D/', '', (string) company('whatsapp', ''));
    return $number !== '' ? 'https://wa.me/' . $number : null;
}
