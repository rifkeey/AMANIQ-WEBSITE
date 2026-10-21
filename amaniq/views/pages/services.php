<?php
$services = content('services');
ob_start(); ?>
<nav class="jump-nav hero-in" data-delay="4" aria-label="Service areas on this page">
    <?php foreach ($services as $s): ?>
    <a href="#<?= e($s['slug']) ?>"><?= e($s['short']) ?></a>
    <?php endforeach; ?>
</nav>
<?php $jump = ob_get_clean();
partial('page-hero', [
    'eyebrow' => 'Our Services',
    'title' => 'Expertise across technology, advisory, <em>skills and supply.</em>',
    'lead' => 'Six practice areas, each scoped around your objectives. Engage one service, or combine several into a single, coordinated engagement.',
    'crumbs' => $meta['breadcrumbs'],
    'extra' => $jump,
]) ?>

<?php $i = 0; foreach ($services as $s): $i++; ?>
<section class="section service-block<?= $i % 2 ? ' section--white' : '' ?>" id="<?= e($s['slug']) ?>">
    <div class="container">
        <div class="service-block-grid">
            <div class="service-block-head" data-reveal>
                <span class="service-num"><?= sprintf('%02d', $i) ?></span>
                <?= icon($s['icon'], 'icon service-block-icon') ?>
                <h2 class="section-title section-title--sm"><?= e($s['title']) ?></h2>
                <p class="muted"><?= e($s['summary']) ?></p>
                <div class="btn-row">
                    <a class="btn btn--primary btn--sm" href="<?= e(url('/services/' . $s['slug'] . '/')) ?>">View service details <?= icon('arrow-right') ?></a>
                    <a class="btn btn--text btn--sm" href="<?= e(url('/contact/#enquiry', ['enquiry' => $s['enquiry']])) ?>">Enquire</a>
                </div>
            </div>
            <ul class="offer-list">
                <?php foreach ($s['offerings'] as $j => [$title, $text]): ?>
                <li data-reveal data-delay="<?= $j % 3 + 1 ?>">
                    <h3><?= e($title) ?></h3>
                    <p><?= e($text) ?></p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php endforeach; ?>

<section class="section section--white">
    <div class="container">
        <p class="fine-print" data-reveal>The scope, deliverables and timelines of every engagement are agreed with you in writing before work begins. Where an engagement requires specific registrations, approvals or vendor relationships, we confirm those requirements at the outset.</p>
    </div>
</section>

<?php partial('cta-band', ['label' => 'Request a Consultation']) ?>
