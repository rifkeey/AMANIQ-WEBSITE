<?php /** @var array $division @var int $index */ ?>
<article class="division-card acc-<?= e($division['slug']) ?>" data-reveal data-delay="<?= e($index + 1) ?>">
    <div class="division-card-art"><?= division_art($division['slug']) ?></div>
    <h3 class="division-card-title">
        <a class="card-link" href="<?= e(url('/divisions/' . $division['slug'] . '/')) ?>"><?= lockup($division['label'], 'lockup--card') ?></a>
    </h3>
    <p class="division-card-tagline"><?= e($division['tagline']) ?></p>
    <ul class="division-card-focus">
        <?php foreach (array_slice($division['focus'], 0, 3) as $focus): ?>
        <li><?= e($focus) ?></li>
        <?php endforeach; ?>
    </ul>
    <span class="link-arrow" aria-hidden="true">Explore <?= e($division['label']) ?> <?= icon('arrow-right') ?></span>
</article>
