<?php partial('page-hero', [
    'eyebrow' => 'Our Divisions',
    'title' => 'Four divisions. <em>One company.</em>',
    'lead' => 'AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy each focus on a distinct area of expertise, and all are business divisions of AMANIQ Projects Limited.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white division-intro">
    <div class="container">
        <div class="split">
            <div class="split-label" data-reveal>
                <p class="eyebrow">How it fits together</p>
                <span class="rule" aria-hidden="true"></span>
            </div>
            <div class="split-body">
                <p class="statement statement--sm" data-reveal>Our divisions give each area of work a clear focus, while clients deal with one company, one leadership team and one set of standards.</p>
                <p class="muted" data-reveal data-delay="1">The divisions are not separate companies. Every engagement is contracted with AMANIQ Projects Limited (<?= e(company('rc')) ?>), and divisions work together whenever a client’s needs span more than one area.</p>
            </div>
        </div>
    </div>
</section>

<?php $i = 0; foreach (content('divisions') as $d): $i++; ?>
<section class="section division-feature acc-<?= e($d['slug']) ?><?= $i % 2 ? '' : ' section--white' ?>" id="<?= e($d['slug']) ?>">
    <div class="container division-feature-grid<?= $i % 2 ? '' : ' is-reversed' ?>">
        <div class="division-feature-visual" data-reveal="clip">
            <?= division_art($d['slug']) ?>
            <span class="division-feature-index"><?= sprintf('%02d', $i) ?></span>
        </div>
        <div class="division-feature-copy">
            <h2 class="division-feature-title" data-reveal><?= lockup($d['label'], 'lockup--lg') ?></h2>
            <p class="division-of" data-reveal><?= e($d['name']) ?> | A division of AMANIQ Projects Limited</p>
            <p class="lead lead--sm" data-reveal data-delay="1"><?= e($d['intro'][0]) ?></p>
            <ul class="focus-list" data-reveal data-delay="2">
                <?php foreach ($d['focus'] as $focus): ?>
                <li><?= e($focus) ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="btn-row" data-reveal data-delay="3">
                <a class="btn btn--primary" href="<?= e(url('/divisions/' . $d['slug'] . '/')) ?>">Explore <?= e($d['name']) ?> <?= icon('arrow-right') ?></a>
                <a class="btn btn--text" href="<?= e(url('/contact/#enquiry', ['enquiry' => $d['enquiry']])) ?>"><?= e($d['cta']) ?></a>
            </div>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php partial('cta-band', [
    'title' => 'Not sure which division you need?',
    'text' => 'Tell us what you are trying to achieve. We will involve the right people from across AMANIQ and respond as one team.',
    'label' => 'Contact Our Team',
]) ?>
