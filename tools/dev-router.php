<?php
/*
 * Router for PHP's built-in development server (NOT used on the live server,
 * where public_html/.htaccess does the same job):
 *
 *   php -S 127.0.0.1:8080 -t public_html tools/dev-router.php
 *
 * Mirrors the Apache rules: real files are served directly, the private
 * "amaniq" folder and dotfiles are refused, everything else goes to index.php.
 */
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');

if (preg_match('~(^|/)\.(?!well-known/)|^/amaniq(/|$)~', $path)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

$file = __DIR__ . '/../public_html' . $path;
if ($path !== '/' && is_file($file)) {
    return false; // let the built-in server send the static file
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/../public_html/index.php';
