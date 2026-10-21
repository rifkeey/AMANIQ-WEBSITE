<?php /** @var array $service @var int $index */ ?>
<article class="service-card" data-reveal data-delay="<?= e($index % 3 + 1) ?>">
    <div class="service-card-top">
        <span class="service-num"><?= sprintf('%02d', $index + 1) ?></span>
        <?= icon($service['icon'], 'icon service-icon') ?>
    </div>
    <h3 class="service-card-title"><a href="<?= e(url('/services/' . $service['slug'] . '/')) ?>" class="card-link"><?= e($service['title']) ?></a></h3>
    <p><?= e($service['summary']) ?></p>
    <span class="link-arrow" aria-hidden="true">Learn more <?= icon('arrow-right') ?></span>
</article>
