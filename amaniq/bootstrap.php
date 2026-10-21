<?php
declare(strict_types=1);

/*
 * Application bootstrap: loads configuration, sets up error handling and
 * pulls in the small set of function libraries the site is built from.
 */
define('APP_ROOT', __DIR__);
define('STORAGE_ROOT', APP_ROOT . '/storage');

require APP_ROOT . '/src/helpers.php';
require APP_ROOT . '/src/http.php';
require APP_ROOT . '/src/view.php';
require APP_ROOT . '/src/seo.php';
require APP_ROOT . '/src/rate_limit.php';
require APP_ROOT . '/src/mailer.php';
require APP_ROOT . '/src/contact.php';
require APP_ROOT . '/src/routes.php';

$configFile = APP_ROOT . '/config/config.php';
if (!is_file($configFile)) {
    error_log('AMANIQ: amaniq/config/config.php is missing. Copy config.example.php and edit it.');
    http_response_code(503);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'The website is being configured. Please try again shortly.';
    exit;
}
$GLOBALS['amaniq_config'] = require $configFile;

date_default_timezone_set((string) config('timezone', 'Africa/Lagos'));
mb_internal_encoding('UTF-8');

// Production never shows PHP errors to visitors; they go to a private log instead.
error_reporting(E_ALL);
ini_set('display_errors', is_production() ? '0' : '1');
ini_set('log_errors', '1');
if (is_dir(STORAGE_ROOT . '/logs') && is_writable(STORAGE_ROOT . '/logs')) {
    ini_set('error_log', STORAGE_ROOT . '/logs/php-errors.log');
}

set_exception_handler(static function (Throwable $e): void {
    error_log('AMANIQ uncaught ' . get_class($e) . ': ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    render_server_error($e);
});
