<?php
/*
 * End-to-end smoke test for a running copy of the site.
 *
 *   php tools/smoke-test.php http://127.0.0.1:8080
 *
 * Checks every page, redirects, security headers, blocked paths and the full
 * contact-form flow (validation, CSRF, spam checks, success, rate limiting).
 * Run it against a development server; it submits test enquiries, and the
 * rate-limit test deliberately exhausts the limit for your IP address.
 * Do not run it against the live site unless you intend to send test emails.
 */
declare(strict_types=1);

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8080', '/');
$skipRateLimit = in_array('--skip-rate-limit', $argv, true);
$pass = 0;
$fail = 0;

function check(bool $ok, string $label, string $detail = ''): void
{
    global $pass, $fail;
    $ok ? $pass++ : $fail++;
    echo ($ok ? "  PASS  " : "  FAIL  ") . $label . ($ok || $detail === '' ? '' : "  — $detail") . "\n";
}

/** @return array{status:int, headers:array<string,string>, body:string} */
function request(string $method, string $url, array $post = [], ?string $cookieJar = null): array
{
    $ch = curl_init($url);
    $headers = [];
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HEADERFUNCTION => static function ($ch, $line) use (&$headers) {
            if (str_contains($line, ':')) {
                [$k, $v] = explode(':', $line, 2);
                $headers[strtolower(trim($k))] = trim($v);
            }
            return strlen($line);
        },
    ]);
    if ($post) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    if ($cookieJar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    }
    $body = (string) curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    return ['status' => $status, 'headers' => $headers, 'body' => $body];
}

function form_session(string $base): array
{
    $jar = tempnam(sys_get_temp_dir(), 'amq');
    $r = request('GET', "$base/contact/", [], $jar);
    preg_match('/name="_token" value="([a-f0-9]{64})"/', $r['body'], $m);
    return [$jar, $m[1] ?? ''];
}

function valid_post(string $token, array $override = []): array
{
    return $override + [
        '_token' => $token,
        'website' => '',
        'name' => 'Smoke Test',
        'email' => 'smoke.test@example.com',
        'phone' => '+234 800 000 0000',
        'organisation' => 'Test Organisation',
        'enquiry_type' => 'consulting',
        'subject' => 'Automated smoke test',
        'message' => 'This is an automated test enquiry sent by tools/smoke-test.php.',
        'consent' => '1',
    ];
}

echo "Testing $base\n\nPages\n";
$pages = ['/', '/about/', '/mission-values/', '/services/', '/divisions/', '/team/', '/academy/', '/contact/', '/insights/', '/privacy/', '/terms/',
    '/services/cybersecurity/', '/services/it-technology/', '/services/consulting/', '/services/digital-products/', '/services/training/', '/services/procurement/',
    '/divisions/technologies/', '/divisions/consulting/', '/divisions/digital-labs/', '/divisions/academy/'];
$titles = [];
foreach ($pages as $path) {
    $r = request('GET', $base . $path);
    preg_match('~<title>(.*?)</title>~s', $r['body'], $t);
    preg_match('~<meta name="description" content="([^"]*)"~', $r['body'], $d);
    preg_match('~<link rel="canonical" href="([^"]*)"~', $r['body'], $c);
    $ok = $r['status'] === 200 && !empty($t[1]) && !empty($d[1]) && !empty($c[1])
        && substr_count($r['body'], '<h1') === 1 && !preg_match('/(Warning|Notice|Deprecated|Fatal error):/', $r['body']);
    check($ok, "GET $path", "status {$r['status']}, h1 count " . substr_count($r['body'], '<h1'));
    $titles[] = $t[1] ?? '';
}
check(count(array_unique($titles)) === count($titles), 'Every page has a unique <title>');

echo "\nRouting and redirects\n";
$r = request('GET', "$base/about");
check($r['status'] === 301 && str_ends_with($r['headers']['location'] ?? '', '/about/'), 'Missing trailing slash → 301');
$r = request('GET', "$base/academy/");
check($r['status'] === 200 && str_contains($r['body'], 'Coming soon'), '/academy/ shows the Coming soon page');
$r = request('GET', "$base/does-not-exist/");
check($r['status'] === 404 && str_contains($r['body'], 'noindex'), 'Unknown page → 404 with noindex');
$r = request('GET', "$base/services/not-a-service/");
check($r['status'] === 404, 'Unknown service → 404');
$r = request('GET', "$base/index.php?route=/team/");
check($r['status'] === 200 && str_contains($r['body'], 'Meet the Team'), 'Fallback URL /index.php?route=/team/ works');
$r = request('POST', "$base/about/", ['x' => '1']);
check($r['status'] === 405, 'POST to a page other than /contact/ → 405');
$r = request('GET', "$base/sitemap.xml");
check($r['status'] === 200 && substr_count($r['body'], '<loc>') === 20 && str_contains($r['headers']['content-type'] ?? '', 'xml'), 'sitemap.xml lists 20 URLs (Insights excluded while empty)', substr_count($r['body'], '<loc>') . ' URLs');
$r = request('GET', "$base/robots.txt");
check($r['status'] === 200 && str_contains($r['body'], 'Sitemap:'), 'robots.txt served');

echo "\nSecurity\n";
$r = request('GET', "$base/");
$csp = $r['headers']['content-security-policy'] ?? '';
check(str_contains($csp, "default-src 'self'") && str_contains($csp, "frame-ancestors 'none'") && str_contains($csp, "object-src 'none'"), 'Content-Security-Policy set');
check(($r['headers']['x-content-type-options'] ?? '') === 'nosniff', 'X-Content-Type-Options: nosniff');
check(($r['headers']['x-frame-options'] ?? '') === 'DENY', 'X-Frame-Options: DENY');
check(isset($r['headers']['referrer-policy']), 'Referrer-Policy set');
check(!isset($r['headers']['x-powered-by']), 'X-Powered-By removed');
check(!isset($r['headers']['set-cookie']), 'No cookies set outside the contact page');
foreach (['/amaniq/config/config.php', '/amaniq/storage/logs/', '/.htaccess', '/.git/config'] as $blocked) {
    $r = request('GET', $base . $blocked);
    check(in_array($r['status'], [403, 404], true) && !str_contains($r['body'], 'app_key'), "Blocked: $blocked", "status {$r['status']}");
}
$r = request('GET', "$base/contact/?enquiry=%3Cscript%3Ealert(1)%3C/script%3E");
check(!str_contains($r['body'], '<script>alert(1)'), 'Query string is not reflected unescaped');
$cookie = request('GET', "$base/contact/")['headers']['set-cookie'] ?? '';
check(stripos($cookie, 'httponly') !== false && stripos($cookie, 'samesite=lax') !== false, 'Session cookie is HttpOnly and SameSite=Lax');

echo "\nContact form\n";
[$jar, $token] = form_session($base);
check(strlen($token) === 64, 'Form includes a CSRF token');
$r = request('GET', "$base/contact/?enquiry=training", [], $jar);
check(str_contains($r['body'], '<option value="training" selected>'), 'Enquiry type preselected from ?enquiry=');

sleep(4);
$r = request('POST', "$base/contact/", valid_post($token, ['_token' => 'wrong']), $jar);
check($r['status'] === 200 && str_contains($r['body'], 'session expired'), 'Invalid CSRF token rejected');

[$jar, $token] = form_session($base);
$r = request('POST', "$base/contact/", valid_post($token), $jar);
check($r['status'] === 200 && str_contains($r['body'], 'could not process'), 'Submission faster than the minimum time rejected');

[$jar, $token] = form_session($base);
sleep(4);
$r = request('POST', "$base/contact/", valid_post($token, ['website' => 'http://spam.example']), $jar);
check(str_contains($r['body'], 'could not process'), 'Honeypot field rejected');

[$jar, $token] = form_session($base);
sleep(4);
$r = request('POST', "$base/contact/", valid_post($token, ['email' => 'not-an-email', 'message' => 'short', 'enquiry_type' => 'bogus', 'consent' => null, 'name' => '<b>X</b>']), $jar);
check(str_contains($r['body'], 'valid email address') && str_contains($r['body'], 'at least 20 characters')
    && str_contains($r['body'], 'choose the type') && str_contains($r['body'], 'Privacy Policy and consent.'), 'Server-side validation messages shown');
check(str_contains($r['body'], 'value="&lt;b&gt;X&lt;/b&gt;"'), 'Submitted values are escaped when re-displayed');

[$jar, $token] = form_session($base);
sleep(4);
$r = request('POST', "$base/contact/", valid_post($token), $jar);
check($r['status'] === 303 && str_contains($r['headers']['location'] ?? '', 'sent=1'), 'Valid enquiry → 303 redirect', "status {$r['status']}");
$r = request('GET', "$base/contact/?sent=1", [], $jar);
check(stripos($r['body'], 'your enquiry has been sent') !== false, 'Success message shown after redirect');
$r = request('GET', "$base/contact/?sent=1", [], $jar);
check(!stripos($r['body'], 'your enquiry has been sent') !== false, 'Success message is shown only once (no fake confirmations)');

if (!$skipRateLimit) {
    $limited = false;
    for ($i = 0; $i < 8 && !$limited; $i++) {
        [$jar, $token] = form_session($base);
        $r = request('POST', "$base/contact/", valid_post($token, ['message' => 'x']), $jar);
        $limited = str_contains($r['body'], 'several enquiries in a short time');
    }
    check($limited, 'Rate limit triggers after repeated submissions');
}

echo "\n$pass passed, $fail failed\n";
exit($fail === 0 ? 0 : 1);
