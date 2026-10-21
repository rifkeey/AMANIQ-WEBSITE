<?php
/*
 * AMANIQ Academy landing page shown from the main "Academy" menu item while
 * the learning platform is being prepared. When config academy.live is true,
 * /academy/ redirects to the platform instead (see page_academy() in routes.php).
 */
$academy = division('academy');
partial('page-hero', [
    'eyebrow' => 'AMANIQ Academy',
    'title' => 'Professional learning, <em>coming soon.</em>',
    'lead' => 'AMANIQ Academy is preparing practical, career-focused courses in cybersecurity and technology. Register your interest and we will let you know when enrolment opens.',
    'crumbs' => $meta['breadcrumbs'],
    'variant' => 'division',
    'accent' => 'academy',
    'extra' => '<p class="coming-soon-badge hero-in" data-delay="4"><span aria-hidden="true"></span>Coming soon</p>'
        . '<div class="btn-row hero-in" data-delay="5">'
        . '<a class="btn btn--primary" href="' . e(url('/contact/#enquiry', ['enquiry' => 'training'])) . '">Register your interest ' . icon('arrow-right') . '</a>'
        . '<a class="btn btn--text" href="' . e(url('/divisions/academy/')) . '">About the Academy division</a>'
        . '</div>',
]) ?>

<section class="section section--white acc-academy">
    <div class="container division-detail-grid">
        <div class="division-detail-visual" data-reveal="clip">
            <?= lockup('Academy', 'lockup--panel') ?>
            <?= division_art('academy') ?>
            <p class="coming-soon-panel-note">Online learning platform in preparation</p>
        </div>
        <div class="prose-lg">
            <p class="eyebrow" data-reveal>What to expect</p>
            <p class="statement statement--sm" data-reveal>Structured courses that build practical skills you can apply at work, to be designed by practitioners with hands-on cybersecurity and technology experience.</p>
            <p data-reveal>The Academy will offer online learning in the areas below. We will share course details, dates and enrolment information with everyone who registers their interest.</p>
            <ul class="tick-list" data-reveal>
                <?php foreach ($academy['focus'] as $focus): ?>
                <li><?= icon('check') ?><span><?= e($focus) ?></span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="feature-pair">
            <article class="feature-block" data-reveal>
                <span class="feature-mark" aria-hidden="true"><?= icon('book') ?></span>
                <h2 class="feature-title">For individuals</h2>
                <p>Building a career in cybersecurity or technology? Register your interest and tell us what you would like to learn. We will contact you when courses open for enrolment.</p>
                <a class="link-arrow" href="<?= e(url('/contact/#enquiry', ['enquiry' => 'training'])) ?>">Register your interest <?= icon('arrow-right') ?></a>
            </article>
            <article class="feature-block feature-block--dark" data-reveal data-delay="1">
                <span class="feature-mark" aria-hidden="true"><?= icon('layers') ?></span>
                <h2 class="feature-title">For organisations</h2>
                <p>You do not need to wait for the platform. We can already discuss cybersecurity awareness, technical training and skills development for your teams.</p>
                <a class="link-arrow" href="<?= e(url('/services/training/')) ?>">Professional training services <?= icon('arrow-right') ?></a>
            </article>
        </div>
    </div>
</section>

<?php partial('cta-band', [
    'title' => 'Be the first to know when AMANIQ Academy opens.',
    'text' => 'Choose “Training and Academy” on our enquiry form and tell us about your learning goals or your team’s training needs.',
    'enquiry' => 'training',
    'label' => 'Register your interest',
]) ?>
