<?php
declare(strict_types=1);

function is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if ((string) ($_SERVER['SERVER_PORT'] ?? '') === '443') {
        return true;
    }
    // Only trust a proxy header when the host is known to sit behind a proxy (e.g. Cloudflare).
    return (bool) config('trust_proxy_headers', false)
        && strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
}

function client_ip(): string
{
    if (config('trust_proxy_headers', false)) {
        foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR'] as $key) {
            $candidate = trim(explode(',', (string) ($_SERVER[$key] ?? ''))[0]);
            if ($candidate !== '' && filter_var($candidate, FILTER_VALIDATE_IP)) {
                return $candidate;
            }
        }
    }
    return (string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
}

/**
 * Redirects to HTTPS and to the configured host (e.g. www → apex). The target is
 * always built from base_url, never from the request's Host header.
 */
function enforce_canonical_origin(): void
{
    $base = parse_url((string) config('base_url'));
    $wantHost = strtolower(($base['host'] ?? '') . (isset($base['port']) ? ':' . $base['port'] : ''));
    $host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));

    $wrongScheme = ($base['scheme'] ?? 'https') === 'https' && config('force_https', true) && !is_https();
    $wrongHost = config('canonical_host_redirect', true) && $host !== '' && $host !== $wantHost;

    if ($wrongScheme || $wrongHost) {
        $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');
        $uri = str_starts_with($uri, '/') ? $uri : '/';
        header('Location: ' . site_origin() . $uri, true, 301);
        exit;
    }
}

function send_security_headers(): void
{
    $nonce = csp_nonce();
    $policy = [
        "default-src 'self'",
        "script-src 'self' 'nonce-{$nonce}'",
        "style-src 'self' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data:",
        "connect-src 'self'",
        "form-action 'self'",
        "frame-ancestors 'none'",
        "base-uri 'self'",
        "object-src 'none'",
        "manifest-src 'self'",
    ];
    if (is_https()) {
        $policy[] = 'upgrade-insecure-requests';
    }
    header('Content-Security-Policy: ' . implode('; ', $policy));
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    $hsts = config('hsts');
    if (is_https() && is_string($hsts) && $hsts !== '') {
        header('Strict-Transport-Security: ' . $hsts);
    }
    header_remove('X-Powered-By');
}

/** Starts a hardened session. Only the contact form uses one. */
function start_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $dir = STORAGE_ROOT . '/sessions';
    if (!is_dir($dir)) {
        @mkdir($dir, 0700, true);
    }
    if (is_dir($dir) && is_writable($dir)) {
        session_save_path($dir);
        ini_set('session.gc_probability', '1');
        ini_set('session.gc_divisor', '100');
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    ini_set('session.gc_maxlifetime', '7200');
    session_name('amaniq_sid');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => base_path() !== '' ? base_path() . '/' : '/',
        'secure' => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    start_session();
    return $_SESSION['_csrf'] ??= bin2hex(random_bytes(32));
}

function csrf_valid(mixed $token): bool
{
    start_session();
    return is_string($token) && isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}

/** Redirects to an internal path only; external targets are never accepted. */
function redirect(string $path, array $query = [], int $status = 302): never
{
    header('Location: ' . url($path, $query), true, $status);
    exit;
}

function flash(string $key, mixed $value = null): mixed
{
    start_session();
    if (func_num_args() === 2) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    $stored = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $stored;
}
