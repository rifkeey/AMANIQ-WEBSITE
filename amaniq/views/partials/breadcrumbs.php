<?php /** @var array $crumbs list of [label, path] */ ?>
<?php if ($crumbs): ?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <ol>
        <li><a href="<?= e(url('/')) ?>">Home</a></li>
        <?php foreach ($crumbs as $i => [$label, $path]): ?>
        <?php if ($i === array_key_last($crumbs)): ?>
        <li><span aria-current="page"><?= e($label) ?></span></li>
        <?php else: ?>
        <li><a href="<?= e(url($path)) ?>"><?= e($label) ?></a></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
<?php endif; ?>
