<?php /** Standalone error page: avoids partials so it still renders if they fail. @var ?string $debug */ ?>
<!doctype html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Something went wrong | AMANIQ</title>
<link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>">
</head>
<body>
<main class="error-page error-page--standalone">
    <div class="container">
        <?= wordmark('brand-mark error-mark') ?>
        <p class="eyebrow">Server error</p>
        <h1 class="page-title">Something went wrong <em>on our side.</em></h1>
        <p class="lead">Please try again in a few minutes. If the problem continues, contact us at <a href="mailto:info@amaniqgroup.com">info@amaniqgroup.com</a> or on <a href="tel:+2347085953567">+234 708 595 3567</a>.</p>
        <?php if (!empty($debug)): ?>
        <pre class="debug-box">Development only: <?= e($debug) ?></pre>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
