<?php
/** @var array $service */
$division = $service['division'] ? division($service['division']) : null;
$others = array_filter(content('services'), static fn ($s) => $s['slug'] !== $service['slug']);
partial('page-hero', [
    'eyebrow' => 'Our Services',
    'title' => e($service['title']),
    'lead' => $service['summary'],
    'crumbs' => $meta['breadcrumbs'],
    'extra' => '<div class="btn-row hero-in" data-delay="4"><a class="btn btn--primary" href="' . e(url('/contact/#enquiry', ['enquiry' => $service['enquiry']])) . '">Discuss your requirements ' . icon('arrow-right') . '</a></div>',
]) ?>

<section class="section section--white">
    <div class="container">
        <div class="split">
            <div class="split-label" data-reveal>
                <p class="eyebrow">Overview</p>
                <span class="rule" aria-hidden="true"></span>
            </div>
            <div class="split-body prose-lg">
                <?php foreach ($service['intro'] as $k => $paragraph): ?>
                <p<?= $k === 0 ? ' class="statement statement--sm"' : '' ?> data-reveal><?= e($paragraph) ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head" data-reveal>
            <p class="eyebrow">What we offer</p>
            <h2 class="section-title">How we can <em>help.</em></h2>
        </div>
        <ol class="offer-grid">
            <?php foreach ($service['offerings'] as $i => [$title, $text]): ?>
            <li class="offer-card" data-reveal data-delay="<?= $i % 3 + 1 ?>">
                <span class="offer-num"><?= sprintf('%02d', $i + 1) ?></span>
                <h3><?= e($title) ?></h3>
                <p><?= e($text) ?></p>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<section class="section section--white">
    <div class="container two-col">
        <div data-reveal>
            <p class="eyebrow">Who it is for</p>
            <h2 class="section-title section-title--sm">Designed for organisations like yours.</h2>
            <ul class="tick-list">
                <?php foreach ($service['audiences'] as $audience): ?>
                <li><?= icon('check') ?><span><?= e($audience) ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div data-reveal data-delay="1">
            <p class="eyebrow">How we engage</p>
            <ol class="mini-steps">
                <li><strong>Initial conversation.</strong> We discuss your objectives, context and constraints.</li>
                <li><strong>Proposal and scope.</strong> We agree deliverables, responsibilities and timelines in writing.</li>
                <li><strong>Delivery.</strong> We carry out the work with regular, open communication.</li>
                <li><strong>Review.</strong> We review the outcome with you and agree any next steps.</li>
            </ol>
            <?php if ($division): ?>
            <a class="division-link acc-<?= e($division['slug']) ?>" href="<?= e(url('/divisions/' . $division['slug'] . '/')) ?>">
                <span class="division-link-label">Delivered by</span>
                <?= lockup($division['label']) ?>
                <?= icon('arrow-right') ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head" data-reveal>
            <p class="eyebrow">Related services</p>
        </div>
        <ul class="related-list">
            <?php foreach ($others as $s): ?>
            <li data-reveal><a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>"><?= icon($s['icon']) ?><span><?= e($s['title']) ?></span><?= icon('arrow-right', 'icon related-arrow') ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<?php partial('cta-band', [
    'title' => 'Talk to us about ' . $service['title'] . '.',
    'enquiry' => $service['enquiry'],
    'label' => 'Submit a Business Enquiry',
]) ?>
