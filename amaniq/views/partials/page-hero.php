<?php
/**
 * Interior page heading.
 * @var string $eyebrow @var string $title @var ?string $lead @var array $crumbs
 * Optional: $extra (HTML placed under the lead), $variant ('' or 'division'), $accent (division slug)
 */
$variant ??= '';
$accent ??= null;
$extra ??= '';
$lead ??= null;
?>
<section class="page-hero<?= $variant ? ' page-hero--' . e($variant) : '' ?><?= $accent ? ' acc-' . e($accent) : '' ?>">
    <div class="page-hero-motif" aria-hidden="true">
        <svg viewBox="0 0 400 400" focusable="false"><g fill="none" stroke="currentColor" stroke-width="1">
            <polygon class="draw d1" pathLength="1" points="<?= diamond_points(200, 200, 190) ?>"/>
            <polygon class="draw d2" pathLength="1" points="<?= diamond_points(200, 200, 130) ?>"/>
            <polygon class="draw d3" pathLength="1" points="<?= diamond_points(200, 200, 70) ?>"/>
        </g></svg>
    </div>
    <div class="container">
        <?php partial('breadcrumbs', ['crumbs' => $crumbs]) ?>
        <p class="eyebrow hero-in" data-delay="1"><?= e($eyebrow) ?></p>
        <h1 class="page-title hero-in" data-delay="2"><?= $title /* trusted markup from views */ ?></h1>
        <?php if ($lead): ?>
        <p class="lead page-lead hero-in" data-delay="3"><?= e($lead) ?></p>
        <?php endif; ?>
        <?= $extra ?>
    </div>
</section>
