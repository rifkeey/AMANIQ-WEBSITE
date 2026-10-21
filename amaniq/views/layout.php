<?php
/** @var array $meta @var string $content */
$fullTitle = !empty($meta['title_full']) ? $meta['title'] : $meta['title'] . ' | AMANIQ';
$canonical = absolute_url($meta['path']);
$ogImage = $meta['og_image'] ?? site_origin() . asset('img/brand/og-default.png');
$schemas = array_merge([organization_schema()], $meta['schema']);
if ($meta['breadcrumbs']) {
    $schemas[] = breadcrumb_schema($meta['breadcrumbs']);
}
?>
<!doctype html>
<html lang="en-GB" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($fullTitle) ?></title>
<meta name="description" content="<?= e($meta['description']) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<?php if ($meta['noindex']): ?>
<meta name="robots" content="noindex, follow">
<?php endif; ?>
<meta property="og:type" content="<?= e($meta['og_type'] ?? 'website') ?>">
<meta property="og:site_name" content="AMANIQ">
<meta property="og:locale" content="en_GB">
<meta property="og:title" content="<?= e($fullTitle) ?>">
<meta property="og:description" content="<?= e($meta['description']) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="AMANIQ: Technology. Insight. Solutions that move you forward.">
<meta name="twitter:card" content="summary_large_image">
<meta name="theme-color" content="#F6F3ED">
<link rel="icon" href="<?= e(asset('img/brand/favicon.svg')) ?>" type="image/svg+xml">
<link rel="icon" href="<?= e(asset('img/brand/favicon-32.png')) ?>" sizes="32x32" type="image/png">
<link rel="apple-touch-icon" href="<?= e(asset('img/brand/apple-touch-icon.png')) ?>">
<link rel="manifest" href="<?= e(base_path()) ?>/site.webmanifest">
<script nonce="<?= e(csp_nonce()) ?>">document.documentElement.classList.replace('no-js','js');</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;family=Newsreader:ital,opsz,wght@0,6..72,300..500;1,6..72,300..500&amp;display=swap">
<link rel="stylesheet" href="<?= e(stylesheet()) ?>">
<script src="<?= e(asset('js/site.js')) ?>" defer></script>
<?php foreach ($schemas as $schema): ?>
<?= json_ld($schema) ?>

<?php endforeach; ?>
</head>
<body class="<?= e(trim($meta['body_class'])) ?>">
<a class="skip-link" href="#main">Skip to main content</a>
<?php partial('header') ?>
<main id="main" tabindex="-1">
<?= $content ?>
</main>
<?php partial('footer') ?>
<a class="to-top" href="#main" data-to-top aria-label="Back to top">
    <svg class="to-top-ring" viewBox="0 0 48 48" aria-hidden="true" focusable="false"><circle cx="24" cy="24" r="22" pathLength="1" data-to-top-progress/></svg>
    <?= icon('arrow-up') ?>
</a>
</body>
</html>
