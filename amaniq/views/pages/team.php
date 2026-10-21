<?php
$team = content('team');
partial('page-hero', [
    'eyebrow' => 'Meet the Team',
    'title' => 'The people behind <em>AMANIQ.</em>',
    'lead' => 'Experienced professionals who combine technical depth with a practical, client-focused approach.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white team-index">
    <div class="container">
        <ul class="team-cards">
            <?php $i = 0; foreach ($team as $m): ?>
            <li class="team-card" data-reveal data-delay="<?= ++$i ?>">
                <a href="#<?= e($m['slug']) ?>">
                    <?= portrait($m, 'portrait--card') ?>
                    <span class="team-card-name"><?= e($m['name']) ?></span>
                    <span class="team-card-title"><?= e($m['title']) ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<?php $i = 0; foreach ($team as $m): $i++; ?>
<section class="section profile<?= $i % 2 ? '' : ' section--white' ?>" id="<?= e($m['slug']) ?>" aria-labelledby="<?= e($m['slug']) ?>-name">
    <div class="container profile-grid">
        <aside class="profile-aside">
            <div data-reveal="clip"><?= portrait($m) ?></div>
            <div class="profile-facts" data-reveal>
                <?php if ($m['education']): ?>
                <h3 class="facts-heading">Education</h3>
                <ul class="facts-list">
                    <?php foreach ($m['education'] as [$degree, $institution, $year]): ?>
                    <li><strong><?= e($degree) ?></strong><span><?= e($institution) ?><?= $year ? ', ' . e($year) : '' ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if ($m['qualifications']): ?>
                <h3 class="facts-heading">Professional qualifications</h3>
                <ul class="facts-list facts-list--creds">
                    <?php foreach ($m['qualifications'] as [$abbr, $full]): ?>
                    <li><abbr title="<?= e($full) ?>"><?= e($abbr) ?></abbr><span><?= e($full) ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <?php if (!empty($m['linkedin'])): ?>
                <a class="link-arrow" href="<?= e($m['linkedin']) ?>" rel="noopener" target="_blank"><?= icon('linkedin') ?> LinkedIn profile<span class="visually-hidden"> (opens in a new tab)</span></a>
                <?php endif; ?>
            </div>
        </aside>
        <div class="profile-body">
            <p class="eyebrow" data-reveal><?= e($m['title']) ?></p>
            <h2 class="profile-name" id="<?= e($m['slug']) ?>-name" data-reveal><?= e($m['name']) ?></h2>
            <p class="profile-headline" data-reveal data-delay="1"><?= e($m['headline']) ?></p>
            <ul class="chips chips--outline" data-reveal data-delay="1">
                <?php foreach ($m['expertise'] as $area): ?>
                <li><?= e($area) ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="profile-bio prose">
                <?php foreach ($m['bio'] as $paragraph): ?>
                <p data-reveal><?= e($paragraph) ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endforeach; ?>

<section class="section section--white">
    <div class="container">
        <p class="fine-print" data-reveal>Professional experience described on this page relates to each individual’s career, including roles held before joining AMANIQ, and does not describe projects delivered by AMANIQ Projects Limited.</p>
    </div>
</section>

<?php partial('cta-band', [
    'title' => 'Speak with our team.',
    'text' => 'Have a question about cybersecurity, technology, consulting or training? Contact us and the right person will get back to you.',
    'label' => 'Contact Our Team',
]) ?>
