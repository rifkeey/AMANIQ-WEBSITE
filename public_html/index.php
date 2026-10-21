<?php
declare(strict_types=1);

/*
 * Front controller: every page request is routed through this file.
 *
 * The private application folder ("amaniq") normally sits beside public_html,
 * outside the web root. If a host forces it inside public_html, the .htaccess
 * file shipped in that folder blocks direct web access to it.
 */
define('PUBLIC_ROOT', __DIR__);

foreach ([dirname(__DIR__) . '/amaniq', __DIR__ . '/amaniq'] as $appDir) {
    if (is_file($appDir . '/bootstrap.php')) {
        require $appDir . '/bootstrap.php';
        amaniq_run();
        return;
    }
}

http_response_code(500);
header('Content-Type: text/plain; charset=UTF-8');
echo 'The website is not configured correctly. Please contact info@amaniqgroup.com.';
