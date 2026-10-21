<?php
/** @var array $division */
$isAcademy = $division['slug'] === 'academy';
$academyLive = $isAcademy && config('academy.live', false);
$external = $division['external_url'] ?: ($academyLive ? (string) config('academy.url') : null);
$primaryHref = $external ?: url('/contact/#enquiry', ['enquiry' => $division['enquiry']]);
$primaryLabel = $external ? 'Visit ' . $division['name'] : ($isAcademy ? 'Register your interest' : $division['cta']);

partial('page-hero', [
    'eyebrow' => $division['name'],
    'title' => e($division['tagline']),
    'lead' => $division['summary'],
    'crumbs' => $meta['breadcrumbs'],
    'variant' => 'division',
    'accent' => $division['slug'],
    'extra' => '<p class="division-of hero-in" data-delay="4">' . e($division['name']) . ' — A division of AMANIQ Projects Limited</p>'
        . '<div class="btn-row hero-in" data-delay="5"><a class="btn btn--primary" href="' . e($primaryHref) . '"' . ($external ? ' rel="noopener"' : '') . '>' . e($primaryLabel) . ' ' . icon($external ? 'arrow-up-right' : 'arrow-right') . '</a></div>',
]) ?>

<section class="section section--white acc-<?= e($division['slug']) ?>">
    <div class="container division-detail-grid">
        <div class="division-detail-visual" data-reveal="clip">
            <?= lockup($division['label'], 'lockup--panel') ?>
            <?= division_art($division['slug']) ?>
        </div>
        <div class="prose-lg">
            <p class="eyebrow" data-reveal>About the division</p>
            <?php foreach ($division['intro'] as $k => $paragraph): ?>
            <p<?= $k === 0 ? ' class="statement statement--sm"' : '' ?> data-reveal><?= e($paragraph) ?></p>
            <?php endforeach; ?>
            <p class="muted" data-reveal><?= e($division['role']) ?></p>
        </div>
    </div>
</section>

<section class="section acc-<?= e($division['slug']) ?>">
    <div class="container">
        <div class="section-head" data-reveal>
            <p class="eyebrow">Areas of focus</p>
            <h2 class="section-title">What <?= e($division['name']) ?> <em>focuses on.</em></h2>
        </div>
        <ol class="focus-grid">
            <?php foreach ($division['focus'] as $i => $focus): ?>
            <li data-reveal data-delay="<?= $i % 3 + 1 ?>"><span class="focus-num"><?= sprintf('%02d', $i + 1) ?></span><?= e($focus) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<?php if ($isAcademy): ?>
<section class="section section--white academy-panel-section">
    <div class="container">
        <div class="academy-panel" data-reveal>
            <div>
                <p class="eyebrow">Online learning</p>
                <h2 class="section-title section-title--sm">A dedicated learning platform for AMANIQ Academy.</h2>
                <?php if ($academyLive): ?>
                <p>AMANIQ Academy’s online platform is available at <a href="<?= e((string) config('academy.url')) ?>" rel="noopener"><?= e(preg_replace('~^https?://~', '', (string) config('academy.url'))) ?></a>, where you can browse courses and create a learner account.</p>
                <?php else: ?>
                <p>We are preparing AMANIQ Academy’s online learning platform, which will offer structured courses in cybersecurity and technology. Register your interest and we will let you know when courses open.</p>
                <p>Organisations looking for training for their teams can contact us now to discuss requirements.</p>
                <?php endif; ?>
            </div>
            <ul class="tick-list">
                <li><?= icon('check') ?><span>Cybersecurity awareness for staff</span></li>
                <li><?= icon('check') ?><span>Technical cybersecurity training</span></li>
                <li><?= icon('check') ?><span>IT and technology skills development</span></li>
                <li><?= icon('check') ?><span>Professional development programmes</span></li>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section<?= $isAcademy ? '' : ' section--white' ?>">
    <div class="container">
        <div class="section-head" data-reveal>
            <p class="eyebrow">Related services</p>
            <h2 class="section-title section-title--sm">Services delivered by <?= e($division['name']) ?></h2>
        </div>
        <div class="service-grid service-grid--compact">
            <?php foreach ($division['services'] as $i => $slug): ?>
            <?php if ($s = service($slug)) { partial('service-card', ['service' => $s, 'index' => $i]); } ?>
            <?php endforeach; ?>
        </div>
        <div class="sibling-divisions" data-reveal>
            <p class="eyebrow">Other divisions</p>
            <ul>
                <?php foreach (content('divisions') as $d): if ($d['slug'] === $division['slug']) continue; ?>
                <li><a class="acc-<?= e($d['slug']) ?>" href="<?= e(url('/divisions/' . $d['slug'] . '/')) ?>"><?= lockup($d['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<?php partial('cta-band', [
    'title' => $isAcademy ? 'Interested in training with AMANIQ Academy?' : 'Work with ' . $division['name'] . '.',
    'text' => $isAcademy
        ? 'Tell us about your own learning goals or your organisation’s training needs, and we will be in touch.'
        : 'Tell us about your requirements and we will suggest a practical way forward.',
    'enquiry' => $division['enquiry'],
    'label' => $isAcademy ? 'Register your interest' : $division['cta'],
]) ?>
