<?php partial('page-hero', [
    'eyebrow' => 'About AMANIQ',
    'title' => 'A Nigerian company built on expertise, integrity and <em>practical solutions.</em>',
    'lead' => 'AMANIQ Projects Limited brings together technology, consulting, digital innovation, training and procurement services for businesses, institutions and public-sector organisations.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container">
        <div class="split">
            <div class="split-label" data-reveal>
                <p class="eyebrow">Who we are</p>
                <span class="rule" aria-hidden="true"></span>
            </div>
            <div class="split-body prose-lg">
                <p class="statement" data-reveal>AMANIQ Projects Limited is a Nigerian company focused on delivering technology solutions, professional consulting, digital innovation, training and procurement services to businesses, institutions and public-sector organisations.</p>
                <p data-reveal>We bring together technical expertise, strategic thinking and a practical approach to solving business challenges.</p>
                <p data-reveal>From strengthening cybersecurity capabilities and implementing technology solutions to developing digital products, building professional skills and supporting procurement needs, our goal is to help organisations operate more securely, efficiently and confidently.</p>
                <p data-reveal>Through our divisions (AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy), we aim to deliver services that respond to evolving organisational needs while maintaining a consistent commitment to quality, integrity and accountability.</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head section-head--split">
            <div data-reveal>
                <p class="eyebrow">What we do</p>
                <h2 class="section-title">Six practice areas, <em>delivered through four divisions.</em></h2>
            </div>
            <p class="section-intro" data-reveal data-delay="1">Our services can be engaged individually or combined. For example, a security assessment followed by technology implementation and staff training.</p>
        </div>
        <ul class="index-list">
            <?php $i = 0; foreach (content('services') as $s): ?>
            <li data-reveal data-delay="<?= $i % 3 + 1 ?>">
                <a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>">
                    <span class="index-num"><?= sprintf('%02d', ++$i) ?></span>
                    <span class="index-title"><?= e($s['title']) ?></span>
                    <span class="index-text"><?= e($s['summary']) ?></span>
                    <?= icon('arrow-up-right', 'icon index-arrow') ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section section--white">
    <div class="container">
        <div class="two-col">
            <div data-reveal>
                <p class="eyebrow">Who we serve</p>
                <h2 class="section-title section-title--sm">Organisations that value expertise and dependable delivery.</h2>
                <p class="muted">We work with organisations of different sizes and sectors, and with individuals building their professional skills.</p>
            </div>
            <ul class="tick-list tick-list--cols" data-reveal data-delay="1">
                <?php foreach ([
                    'Private companies and corporate organisations',
                    'Banks, financial institutions and fintech companies',
                    'Government agencies and public-sector organisations',
                    'Development institutions and international organisations',
                    'Businesses seeking cybersecurity, IT and consulting services',
                    'Organisations seeking procurement support and technology solutions',
                    'Professionals and individuals interested in technology training',
                    'Prospective business partners and institutional clients',
                ] as $item): ?>
                <li><?= icon('check') ?><span><?= e($item) ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head" data-reveal>
            <p class="eyebrow">How we work</p>
            <h2 class="section-title">Our approach to <em>business challenges.</em></h2>
        </div>
        <ol class="process">
            <?php foreach ([
                ['Understand the challenge', 'We start with your objectives, constraints and risks, and we listen before we recommend.'],
                ['Choose the right approach', 'We weigh the options and recommend what is proportionate, practical and sustainable.'],
                ['Deliver with purpose', 'We agree scope and responsibilities clearly, then deliver with open, regular communication.'],
                ['Review and improve', 'We review what has been delivered with you and identify sensible next steps.'],
            ] as $i => [$title, $text]): ?>
            <li class="process-step" data-reveal data-delay="<?= $i + 1 ?>">
                <span class="process-num"><?= sprintf('%02d', $i + 1) ?></span>
                <h3><?= e($title) ?></h3>
                <p><?= e($text) ?></p>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<section class="section section--white">
    <div class="container">
        <div class="feature-pair">
            <article class="feature-block" data-reveal>
                <span class="feature-mark" aria-hidden="true"><?= icon('diamond') ?></span>
                <h2 class="feature-title">Integrity, quality and accountability</h2>
                <p>At AMANIQ, we believe meaningful progress begins with understanding the challenge, choosing the right approach and delivering solutions that create lasting value.</p>
                <p>Our commitment is simple: to earn trust, deliver with purpose and build solutions that make a difference. We are clear about what we can deliver, and we hold ourselves accountable for doing it well.</p>
            </article>
            <article class="feature-block feature-block--dark" data-reveal data-delay="1">
                <span class="feature-mark" aria-hidden="true"><?= icon('pin') ?></span>
                <h2 class="feature-title">Nigerian foundation, international ambition</h2>
                <p>AMANIQ is a Nigerian company, registered with the Corporate Affairs Commission (<?= e(company('rc')) ?>) and based in Maitama, Abuja.</p>
                <p>We are building a company that can serve clients across Nigeria and, over time, internationally, growing steadily on the strength of its people, its standards and the trust it earns.</p>
            </article>
        </div>
        <p class="center-link" data-reveal><a class="link-arrow" href="<?= e(url('/mission-values/')) ?>">Read our mission, vision and values <?= icon('arrow-right') ?></a></p>
    </div>
</section>

<?php partial('cta-band') ?>
