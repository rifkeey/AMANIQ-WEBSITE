<?php
declare(strict_types=1);

/** Entry point called by public_html/index.php. */
function amaniq_run(): void
{
    enforce_canonical_origin();

    $method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
    $path = request_path();

    if (!preg_match('~^/[a-z0-9/._-]*$~', $path) || str_contains($path, '..') || str_contains($path, '//')) {
        not_found();
        return;
    }
    // Canonical form: directory-style URLs end with a slash.
    if (config('pretty_urls', true) && $method === 'GET' && !str_ends_with($path, '/') && !str_contains(basename($path), '.')) {
        redirect($path . '/', array_diff_key($_GET, ['route' => true]), 301);
    }
    if (!in_array($method, ['GET', 'HEAD', 'POST'], true) || ($method === 'POST' && $path !== '/contact/')) {
        header('Allow: GET, HEAD' . ($path === '/contact/' ? ', POST' : ''));
        http_response_code(405);
        exit;
    }

    current_path($path);
    dispatch($path);
}

function request_path(): string
{
    if (isset($_GET['route']) && is_string($_GET['route'])) {
        $path = $_GET['route'];
    } else {
        $path = rawurldecode((string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH));
        if (base_path() !== '' && str_starts_with($path, base_path())) {
            $path = substr($path, strlen(base_path()));
        }
        if (str_starts_with($path, '/index.php')) {
            $path = substr($path, strlen('/index.php'));
        }
    }
    return '/' . ltrim($path, '/');
}

function dispatch(string $path): void
{
    $pages = [
        '/' => 'page_home',
        '/about/' => 'page_about',
        '/mission-values/' => 'page_mission',
        '/services/' => 'page_services',
        '/divisions/' => 'page_divisions',
        '/team/' => 'page_team',
        '/academy/' => 'page_academy',
        '/contact/' => 'page_contact',
        '/insights/' => 'page_insights',
        '/privacy/' => 'page_privacy',
        '/terms/' => 'page_terms',
        '/sitemap.xml' => 'page_sitemap',
    ];
    if (isset($pages[$path])) {
        $pages[$path]();
        return;
    }
    if (preg_match('~^/services/([a-z0-9-]+)/$~', $path, $m) && service($m[1])) {
        page_service(service($m[1]));
        return;
    }
    if (preg_match('~^/divisions/([a-z0-9-]+)/$~', $path, $m) && division($m[1])) {
        page_division(division($m[1]));
        return;
    }
    if (preg_match('~^/insights/([a-z0-9-]+)/$~', $path, $m) && isset(content('insights')[$m[1]])) {
        page_article(content('insights')[$m[1]]);
        return;
    }
    not_found();
}

/* ---------------------------------------------------------------------------
 * Page controllers
 * ------------------------------------------------------------------------- */

function page_home(): void
{
    page('home', [
        'title' => 'AMANIQ Projects Limited | Technology, Cybersecurity, Consulting and Training',
        'title_full' => true,
        'description' => 'AMANIQ Projects Limited is a Nigerian company delivering technology solutions, cybersecurity, consulting, digital innovation, professional training and procurement services.',
        'schema' => [website_schema()],
        'body_class' => 'page-home',
    ]);
}

function page_about(): void
{
    page('about', [
        'title' => 'About AMANIQ',
        'description' => 'Who we are, what we do and how we work: AMANIQ Projects Limited brings together technology, consulting, digital innovation, training and procurement services.',
        'breadcrumbs' => [['About', '/about/']],
    ]);
}

function page_mission(): void
{
    page('mission-values', [
        'title' => 'Mission, Vision and Values',
        'description' => 'The mission, vision and core values that guide AMANIQ Projects Limited: integrity, excellence, innovation, accountability, client focus and continuous learning.',
        'breadcrumbs' => [['About', '/about/'], ['Mission, Vision and Values', '/mission-values/']],
    ]);
}

function page_services(): void
{
    page('services', [
        'title' => 'Our Services',
        'description' => 'Cybersecurity, IT and technology services, business consulting, digital products, professional training and procurement support from AMANIQ.',
        'breadcrumbs' => [['Our Services', '/services/']],
    ]);
}

function page_service(array $service): void
{
    page('service', [
        'title' => $service['title'],
        'description' => $service['summary'],
        'breadcrumbs' => [['Our Services', '/services/'], [$service['title'], '/services/' . $service['slug'] . '/']],
        'schema' => [service_schema($service)],
    ], ['service' => $service]);
}

function page_divisions(): void
{
    page('divisions', [
        'title' => 'Our Divisions',
        'description' => 'AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy: the four business divisions of AMANIQ Projects Limited.',
        'breadcrumbs' => [['Our Divisions', '/divisions/']],
    ]);
}

function page_division(array $division): void
{
    page('division', [
        'title' => $division['name'],
        'description' => $division['summary'] . ' A division of AMANIQ Projects Limited.',
        'breadcrumbs' => [['Our Divisions', '/divisions/'], [$division['name'], '/divisions/' . $division['slug'] . '/']],
        'body_class' => 'division-' . $division['slug'],
    ], ['division' => $division]);
}

function page_team(): void
{
    page('team', [
        'title' => 'Meet the Team',
        'description' => 'Meet the people behind AMANIQ Projects Limited, including Founder & Principal Consultant Mohammed Ibrahim.',
        'breadcrumbs' => [['About', '/about/'], ['Meet the Team', '/team/']],
        'schema' => array_map('person_schema', array_values(content('team'))),
    ]);
}

function page_academy(): void
{
    // Once the learning platform is public, the menu item goes straight to it.
    if (config('academy.live', false) && filter_var(config('academy.url'), FILTER_VALIDATE_URL)) {
        header('Location: ' . config('academy.url'), true, 302);
        exit;
    }
    page('academy', [
        'title' => 'AMANIQ Academy: Coming Soon',
        'description' => 'AMANIQ Academy is preparing practical online courses in cybersecurity and technology. Register your interest to hear when enrolment opens.',
        'breadcrumbs' => [['Academy', '/academy/']],
        'body_class' => 'division-academy',
    ]);
}

function page_contact(): void
{
    start_session();
    $state = ['errors' => [], 'old' => [], 'alert' => null];
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        $state = contact_process($_POST);
    }
    $sent = flash('contact_sent') === true;

    if (!isset($state['old']['enquiry_type'])) {
        $requested = is_string($_GET['enquiry'] ?? null) ? $_GET['enquiry'] : '';
        $state['old']['enquiry_type'] = array_key_exists($requested, enquiry_types()) ? $requested : '';
    }
    $_SESSION['contact_form_at'] = time();

    page('contact', [
        'title' => 'Contact Us',
        'description' => 'Contact AMANIQ Projects Limited in Maitama, Abuja. Call +234 708 595 3567, email info@amaniqgroup.com or send a business enquiry.',
        'breadcrumbs' => [['Contact', '/contact/']],
        'noindex' => $sent || $state['alert'] !== null,
    ], $state + ['sent' => $sent, 'csrf' => csrf_token()]);
}

function page_insights(): void
{
    page('insights', [
        'title' => 'Insights',
        'description' => 'Cybersecurity insights, consulting perspectives, training updates and announcements from AMANIQ.',
        'breadcrumbs' => [['Insights', '/insights/']],
        // Kept out of search results until there is published content.
        'noindex' => content('insights') === [],
    ]);
}

function page_article(array $article): void
{
    page('article', [
        'title' => $article['title'],
        'description' => $article['summary'],
        'breadcrumbs' => [['Insights', '/insights/'], [$article['title'], '/insights/' . $article['slug'] . '/']],
        'og_type' => 'article',
    ], ['article' => $article]);
}

function page_privacy(): void
{
    page('privacy', [
        'title' => 'Privacy Policy',
        'description' => 'How AMANIQ Projects Limited collects, uses and protects personal information submitted through this website.',
        'breadcrumbs' => [['Privacy Policy', '/privacy/']],
    ]);
}

function page_terms(): void
{
    page('terms', [
        'title' => 'Terms of Use',
        'description' => 'The terms that apply to your use of the AMANIQ Projects Limited website.',
        'breadcrumbs' => [['Terms of Use', '/terms/']],
    ]);
}

function sitemap_paths(): array
{
    $paths = ['/', '/about/', '/mission-values/', '/services/', '/divisions/', '/team/', '/academy/', '/contact/', '/privacy/', '/terms/'];
    foreach (content('services') as $slug => $_) {
        $paths[] = '/services/' . $slug . '/';
    }
    foreach (content('divisions') as $slug => $_) {
        $paths[] = '/divisions/' . $slug . '/';
    }
    if (content('insights') !== []) {
        $paths[] = '/insights/';
        foreach (content('insights') as $slug => $_) {
            $paths[] = '/insights/' . $slug . '/';
        }
    }
    return $paths;
}

function page_sitemap(): void
{
    header('Content-Type: application/xml; charset=UTF-8');
    header('X-Content-Type-Options: nosniff');
    echo '<?xml version="1.0" encoding="UTF-8"?>', "\n", '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', "\n";
    foreach (sitemap_paths() as $path) {
        echo '  <url><loc>', e(absolute_url($path)), '</loc></url>', "\n";
    }
    echo '</urlset>', "\n";
}
