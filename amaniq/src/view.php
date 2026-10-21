<?php
declare(strict_types=1);

/** Renders a view file from amaniq/views and returns the HTML. */
function render(string $view, array $vars = []): string
{
    $file = APP_ROOT . '/views/' . $view . '.php';
    if (!preg_match('~^[a-z0-9/_-]+$~', $view) || !is_file($file)) {
        throw new RuntimeException("View not found: $view");
    }
    extract($vars, EXTR_SKIP);
    ob_start();
    try {
        require $file;
    } catch (Throwable $e) {
        ob_end_clean();
        throw $e;
    }
    return (string) ob_get_clean();
}

function partial(string $name, array $vars = []): void
{
    echo render('partials/' . $name, $vars);
}

/**
 * Renders a full page inside the site layout.
 *
 * $meta keys: title, description, path, breadcrumbs ([[label, path], ...]),
 * noindex, schema (list of JSON-LD objects), og_image, body_class.
 */
function page(string $view, array $meta, array $vars = [], int $status = 200): void
{
    $meta += [
        'title' => 'AMANIQ',
        'description' => '',
        'path' => current_path(),
        'breadcrumbs' => [],
        'noindex' => false,
        'schema' => [],
        'og_image' => null,
        'body_class' => '',
    ];
    $content = render('pages/' . $view, $vars + ['meta' => $meta]);

    http_response_code($status);
    header('Content-Type: text/html; charset=UTF-8');
    send_security_headers();
    echo render('layout', ['meta' => $meta, 'content' => $content]);
}

function not_found(): void
{
    page('404', [
        'title' => 'Page not found',
        'description' => 'The page you were looking for could not be found.',
        'noindex' => true,
    ], [], 404);
}

/** Last-resort error page that depends on as little of the site as possible. */
function render_server_error(?Throwable $e = null): void
{
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
    }
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    try {
        echo render('errors/500', ['debug' => (!is_production() && $e) ? $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine() : null]);
    } catch (Throwable) {
        echo 'Sorry, something went wrong. Please contact info@amaniqgroup.com.';
    }
}

/** Inline line icon. Icons are decorative; give the surrounding link or button its own label. */
function icon(string $name, string $class = 'icon'): string
{
    static $paths = [
        'shield' => '<path d="M12 3l7 3v5c0 4.5-3 8.3-7 10-4-1.7-7-5.5-7-10V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
        'server' => '<rect x="3.5" y="4" width="17" height="6.5" rx="1"/><rect x="3.5" y="13.5" width="17" height="6.5" rx="1"/><path d="M7 7.25h.01M7 16.75h.01M11 7.25h6M11 16.75h6"/>',
        'compass' => '<circle cx="12" cy="12" r="8.5"/><path d="M15.5 8.5l-2 5-5 2 2-5 5-2z"/>',
        'layers' => '<path d="M12 3.5l8.5 4.5-8.5 4.5L3.5 8z"/><path d="M3.5 12l8.5 4.5 8.5-4.5"/><path d="M3.5 16l8.5 4.5 8.5-4.5"/>',
        'book' => '<path d="M3.5 5.5c2.8-.9 5.6-.6 8.5 1 2.9-1.6 5.7-1.9 8.5-1v13c-2.8-.9-5.6-.6-8.5 1-2.9-1.6-5.7-1.9-8.5-1z"/><path d="M12 6.5v13"/>',
        'package' => '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5l8 4.5 8-4.5M12 12v9M8 5.25l8 4.5"/>',
        'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'arrow-up-right' => '<path d="M7 17L17 7M8 7h9v9"/>',
        'arrow-up' => '<path d="M12 19V5M6 11l6-6 6 6"/>',
        'phone' => '<path d="M5 4h3.5l1.5 4-2 1.5a11 11 0 0 0 6.5 6.5l1.5-2 4 1.5V19a1.5 1.5 0 0 1-1.6 1.5A16 16 0 0 1 3.5 5.6 1.5 1.5 0 0 1 5 4z"/>',
        'mail' => '<rect x="3.5" y="5.5" width="17" height="13" rx="1.5"/><path d="M4 7l8 6 8-6"/>',
        'pin' => '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.3"/>',
        'chat' => '<path d="M4.5 19.5l1.2-3.6a7.8 7.8 0 1 1 2.9 2.7z"/><path d="M9 10.5h6M9 13.5h4"/>',
        'check' => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'chevron-down' => '<path d="M6 9l6 6 6-6"/>',
        'menu' => '<path d="M4 8h16M4 16h16"/>',
        'close' => '<path d="M6 6l12 12M18 6L6 18"/>',
        'diamond' => '<path d="M12 3l9 9-9 9-9-9z"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'linkedin' => '<rect x="3.5" y="3.5" width="17" height="17" rx="2"/><path d="M8 10.5V16M8 7.5v.01M11.5 16v-3.2a2.3 2.3 0 0 1 4.6 0V16M11.5 10.5V16"/>',
    ];
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . ($paths[$name] ?? $paths['diamond']) . '</svg>';
}

/**
 * The approved "amaniq" wordmark, drawn from the same geometry as the brand files.
 * Uses currentColor so one asset serves light and dark backgrounds.
 */
function wordmark(string $class = 'wordmark', bool $labelled = true): string
{
    static $n = 0;
    $id = 'amq-cut-' . ++$n;
    $cut = '<rect x="82" y="124" width="122" height="46" rx="22"/><rect x="434" y="58" width="105" height="210" rx="10"/><rect x="619" y="58" width="105" height="210" rx="10"/><polygon points="428,56 438,56 438,98 428,80"/><polygon points="613,56 623,56 623,98 613,80"/><rect x="910" y="124" width="122" height="46" rx="22"/><rect x="1262" y="58" width="130" height="210" rx="10"/><polygon points="1256,56 1266,56 1266,98 1256,80"/><rect x="1680" y="58" width="150" height="94" rx="26"/><polygon points="1842,152 1858,152 2008,302 1992,302"/>';
    $fill = '<rect x="12" y="0" width="318" height="58" rx="16"/><rect x="250" y="0" width="80" height="210" rx="16"/><rect x="0" y="78" width="330" height="132" rx="52"/><rect x="354" y="0" width="450" height="78" rx="44"/><rect x="354" y="0" width="80" height="210" rx="16"/><rect x="539" y="0" width="80" height="210" rx="16"/><rect x="724" y="0" width="80" height="210" rx="16"/><rect x="840" y="0" width="318" height="58" rx="16"/><rect x="1078" y="0" width="80" height="210" rx="16"/><rect x="828" y="78" width="330" height="132" rx="52"/><rect x="1182" y="0" width="290" height="78" rx="44"/><rect x="1182" y="0" width="80" height="210" rx="16"/><rect x="1392" y="0" width="80" height="210" rx="16"/><rect x="1496" y="0" width="80" height="210" rx="16"/><rect x="1497" y="-119" width="78" height="78" rx="12" transform="rotate(45 1536 -80)"/><rect x="1600" y="0" width="310" height="210" rx="52"/><polygon points="1740,152 1842,152 1992,302 1890,302"/>';
    $a11y = $labelled ? 'role="img" aria-label="AMANIQ"' : 'aria-hidden="true" focusable="false"';
    return '<svg class="' . e($class) . '" viewBox="-8 -150 2008 460" ' . $a11y . '>'
        . '<mask id="' . $id . '" maskUnits="userSpaceOnUse" x="-8" y="-150" width="2008" height="460"><rect x="-8" y="-150" width="2008" height="460" fill="#fff"/><g fill="#000">' . $cut . '</g></mask>'
        . '<g fill="currentColor" mask="url(#' . $id . ')">' . $fill . '</g></svg>';
}

/** Wordmark | DIVISION lockup. The division name always sits beside the wordmark, never inside it. */
function lockup(string $division, string $class = ''): string
{
    return '<span class="lockup ' . e($class) . '" role="img" aria-label="AMANIQ ' . e($division) . '">'
        . wordmark('lockup-mark', false)
        . '<span class="lockup-rule" aria-hidden="true"></span>'
        . '<span class="lockup-name" aria-hidden="true">' . e($division) . '</span></span>';
}

function diamond_points(float $cx, float $cy, float $r): string
{
    return "$cx," . ($cy - $r) . ' ' . ($cx + $r) . ",$cy $cx," . ($cy + $r) . ' ' . ($cx - $r) . ",$cy";
}

/** Abstract network-and-diamond composition for the home hero. */
function hero_art(): string
{
    $c = [240, 280];
    $svg = '<svg class="hero-art" viewBox="0 0 480 560" aria-hidden="true" focusable="false">';
    $svg .= '<defs><pattern id="hero-dots" width="24" height="24" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1" class="art-dot"/></pattern></defs>';
    $svg .= '<rect width="480" height="560" fill="url(#hero-dots)"/>';
    foreach ([[205, 'art-line art-faint', 0], [150, 'art-line', 1], [96, 'art-line art-strong', 2]] as [$r, $cls, $d]) {
        $svg .= '<polygon class="' . $cls . ' draw d' . $d . '" pathLength="1" points="' . diamond_points($c[0], $c[1], $r) . '"/>';
    }
    $nodes = [[240, 75], [372, 150], [445, 280], [372, 410], [240, 485], [108, 410], [35, 280], [108, 150], [240, 184], [336, 280], [240, 376], [144, 280], [312, 96], [420, 470], [60, 500], [64, 70]];
    $links = [[0, 1], [1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7], [7, 0], [0, 8], [1, 9], [3, 9], [4, 10], [5, 11], [7, 11], [8, 9], [9, 10], [10, 11], [11, 8], [12, 1], [12, 0], [13, 3], [14, 5], [15, 7]];
    foreach ($links as $i => [$a, $b]) {
        [$x1, $y1] = $nodes[$a];
        [$x2, $y2] = $nodes[$b];
        $svg .= '<line class="art-link draw d' . (3 + $i % 4) . '" pathLength="1" x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '"/>';
    }
    foreach ($nodes as $i => [$x, $y]) {
        $gold = in_array($i, [1, 5, 10, 12], true);
        if ($gold) {
            $svg .= '<circle class="art-pulse p' . ($i % 3) . '" cx="' . $x . '" cy="' . $y . '" r="10"/>';
        }
        $svg .= '<circle class="art-node' . ($gold ? ' is-gold' : '') . '" cx="' . $x . '" cy="' . $y . '" r="' . ($gold ? 4 : 2.6) . '"/>';
    }
    $svg .= '<polygon class="art-core" points="' . diamond_points($c[0], $c[1], 16) . '"/>';
    return $svg . '</svg>';
}

/** Distinct abstract motif for each division, drawn in the division's accent colour. */
function division_art(string $slug): string
{
    $svg = '<svg class="division-art" viewBox="0 0 320 200" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1.2">';
    switch ($slug) {
        case 'technologies': // connected lattice: systems and infrastructure
            for ($row = 0; $row < 3; $row++) {
                for ($col = 0; $col < 5; $col++) {
                    $x = 60 + $col * 50;
                    $y = 50 + $row * 50;
                    if ($col < 4) {
                        $svg .= '<line class="dim" x1="' . ($x + 9) . '" y1="' . $y . '" x2="' . ($x + 41) . '" y2="' . $y . '"/>';
                    }
                    if ($row < 2) {
                        $svg .= '<line class="dim" x1="' . $x . '" y1="' . ($y + 9) . '" x2="' . $x . '" y2="' . ($y + 41) . '"/>';
                    }
                    $filled = in_array([$row, $col], [[0, 1], [1, 3], [2, 0], [1, 2]], true);
                    $svg .= '<polygon points="' . diamond_points($x, $y, 9) . '"' . ($filled ? ' class="solid"' : '') . '/>';
                }
            }
            break;
        case 'consulting': // concentric focus: clarity and direction
            $svg .= '<line class="dim" x1="20" y1="100" x2="300" y2="100"/><line class="dim" x1="160" y1="8" x2="160" y2="192"/>';
            foreach ([88, 64, 40] as $r) {
                $svg .= '<polygon points="' . diamond_points(160, 100, $r) . '"/>';
            }
            $svg .= '<polygon class="solid" points="' . diamond_points(160, 100, 14) . '"/>';
            $svg .= '<polyline class="dim" points="248,100 268,80 300,80"/><circle class="solid" cx="300" cy="80" r="3"/>';
            break;
        case 'digital-labs': // modular blocks and code brackets: building products
            $svg .= '<polyline points="56,62 28,100 56,138"/><polyline points="264,62 292,100 264,138"/>';
            foreach ([[84, 56], [136, 56], [188, 56], [110, 104], [162, 104]] as $i => [$x, $y]) {
                $svg .= '<rect x="' . $x . '" y="' . $y . '" width="44" height="40" rx="2"' . ($i === 3 ? ' class="solid"' : '') . '/>';
            }
            $svg .= '<line class="dim" x1="84" y1="160" x2="236" y2="160"/><line class="dim" x1="110" y1="172" x2="210" y2="172"/>';
            break;
        case 'academy': // ascending steps: learning and progression
            $steps = [[50, 160], [105, 132], [160, 104], [215, 76], [270, 48]];
            $svg .= '<polyline class="dim" stroke-dasharray="3 5" points="' . implode(' ', array_map(fn ($p) => $p[0] . ',' . $p[1], $steps)) . '"/>';
            foreach ($steps as $i => [$x, $y]) {
                $svg .= '<line class="dim" x1="' . $x . '" y1="' . ($y + 14) . '" x2="' . $x . '" y2="184"/>';
                $svg .= '<polygon points="' . diamond_points($x, $y, 4 + $i * 2.5) . '"' . ($i === 4 ? ' class="solid"' : '') . '/>';
            }
            $svg .= '<line class="dim" x1="20" y1="184" x2="300" y2="184"/>';
            break;
    }
    return $svg . '</g></svg>';
}

/** Team portrait, or a refined monogram placeholder until a real photograph is supplied. */
function portrait(array $member, string $class = ''): string
{
    if (!empty($member['photo']) && is_file(PUBLIC_ROOT . '/assets/' . $member['photo'])) {
        return '<figure class="portrait ' . e($class) . '"><img src="' . e(asset($member['photo'])) . '" width="640" height="800" loading="lazy" decoding="async" alt="Portrait of ' . e($member['name']) . '"></figure>';
    }
    return '<figure class="portrait portrait--placeholder ' . e($class) . '" aria-hidden="true">'
        . '<svg class="portrait-art" viewBox="0 0 320 400" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1">'
        . '<polygon points="' . diamond_points(160, 200, 150) . '"/><polygon points="' . diamond_points(160, 200, 110) . '"/>'
        . '<line x1="0" y1="200" x2="320" y2="200"/></g></svg>'
        . '<span class="portrait-initials">' . e($member['initials']) . '</span></figure>';
}

/** Inline list of credential abbreviations. */
function credential_chips(array $items, string $class = 'chips'): string
{
    $html = '<ul class="' . e($class) . '">';
    foreach ($items as $item) {
        $html .= '<li>' . e($item) . '</li>';
    }
    return $html . '</ul>';
}
