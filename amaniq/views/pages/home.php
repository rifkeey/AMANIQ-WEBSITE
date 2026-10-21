<?php
$services = content('services');
$divisions = content('divisions');
$founder = current(array_filter(content('team'), static fn ($m) => !empty($m['featured']))) ?: null;
?>
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <p class="eyebrow hero-in" data-delay="1"><?= e(company('legal_name')) ?> <span aria-hidden="true">·</span> Abuja, Nigeria</p>
            <h1 class="hero-title">
                <span class="line"><span>Technology. Insight.</span></span>
                <span class="line"><span>Solutions that move</span></span>
                <span class="line"><span><em>you forward.</em></span></span>
            </h1>
            <p class="lead hero-in" data-delay="4">AMANIQ delivers technology solutions, cybersecurity, consulting, digital innovation, professional training and procurement services — helping businesses, institutions and public-sector organisations operate more securely, efficiently and confidently.</p>
            <div class="btn-row hero-in" data-delay="5">
                <a class="btn btn--primary" href="<?= e(url('/services/')) ?>">Explore Our Services <?= icon('arrow-right') ?></a>
                <a class="btn btn--outline" href="<?= e(url('/contact/#enquiry')) ?>">Discuss a Project</a>
            </div>
            <ul class="hero-points hero-in" data-delay="6">
                <li>Integrity-led delivery</li>
                <li>Practical technical expertise</li>
                <li>Nigerian foundation, international outlook</li>
            </ul>
        </div>
        <div class="hero-visual hero-in" data-delay="2">
            <?= hero_art() ?>
            <p class="hero-visual-caption"><span>One company</span><span aria-hidden="true">◆</span><span>Four divisions</span><span aria-hidden="true">◆</span><span>Six practice areas</span></p>
        </div>
    </div>
</section>

<nav class="practice-strip" aria-label="Practice areas">
    <div class="container">
        <ul>
            <?php foreach ($services as $s): ?>
            <li><a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>"><?= e($s['short']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<section class="section section--white approach">
    <div class="container">
        <div class="split">
            <div class="split-label" data-reveal>
                <p class="eyebrow">Our approach</p>
                <span class="rule" aria-hidden="true"></span>
            </div>
            <div class="split-body">
                <p class="statement" data-reveal>Meaningful progress begins with understanding the challenge, choosing the right approach and delivering solutions that <em>create lasting value.</em></p>
                <p class="approach-text" data-reveal data-delay="1">We bring together technical expertise, strategic thinking and a practical approach to solving business challenges. We take the time to understand your objectives, your constraints and the risks that matter, then recommend and deliver what genuinely fits.</p>
                <ol class="steps">
                    <?php foreach ([
                        ['Understand', 'We learn how your organisation works, what it needs to achieve and what stands in the way — before recommending anything.'],
                        ['Choose the right approach', 'We recommend options that are proportionate, practical and suited to your environment and budget.'],
                        ['Deliver responsibly', 'We agree scope clearly, communicate openly and stand behind the work we deliver.'],
                    ] as $i => [$title, $text]): ?>
                    <li class="step" data-reveal data-delay="<?= $i + 1 ?>">
                        <span class="step-num"><?= sprintf('%02d', $i + 1) ?></span>
                        <h3><?= e($title) ?></h3>
                        <p><?= e($text) ?></p>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="section services-overview" id="services">
    <div class="container">
        <div class="section-head section-head--split">
            <div data-reveal>
                <p class="eyebrow">What we do</p>
                <h2 class="section-title"><span data-count="6">6</span> practice areas. <em>One accountable partner.</em></h2>
            </div>
            <p class="section-intro" data-reveal data-delay="1">From strengthening cybersecurity and implementing technology to developing digital products, building skills and supporting procurement, our services are designed to work on their own or together.</p>
        </div>
        <div class="service-grid">
            <?php $i = 0; foreach ($services as $service): ?>
            <?php partial('service-card', ['service' => $service, 'index' => $i++]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--dark divisions-overview">
    <div class="container">
        <div class="section-head section-head--split">
            <div data-reveal>
                <p class="eyebrow eyebrow--on-dark">Our divisions</p>
                <h2 class="section-title"><span data-count="4">4</span> divisions. <em>One company.</em></h2>
            </div>
            <p class="section-intro" data-reveal data-delay="1">Each division focuses on a distinct area of expertise. All four are business divisions of AMANIQ Projects Limited, sharing the same leadership, standards and accountability.</p>
        </div>
        <div class="division-grid">
            <?php $i = 0; foreach ($divisions as $division): ?>
            <?php partial('division-card', ['division' => $division, 'index' => $i++]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--white principles">
    <div class="container">
        <div class="split">
            <div class="split-label" data-reveal>
                <p class="eyebrow">Why AMANIQ</p>
                <h2 class="section-title section-title--sm">The principles we work by.</h2>
                <p class="muted">These commitments guide how we engage, how we deliver and how we intend to grow.</p>
                <a class="link-arrow" href="<?= e(url('/mission-values/')) ?>">Our mission and values <?= icon('arrow-right') ?></a>
            </div>
            <ol class="principle-list">
                <?php foreach ([
                    ['Integrity and accountability', 'We are honest about what we can deliver, transparent in how we work and accountable for the results.'],
                    ['Practical, solution-oriented delivery', 'We focus on workable solutions that fit the realities of your organisation, not theory for its own sake.'],
                    ['Technical expertise', 'Our work is grounded in hands-on experience across cybersecurity, technology and consulting.'],
                    ['Client-focused engagement', 'We listen carefully, communicate clearly and shape our approach around your objectives.'],
                    ['Continuous learning', 'Technology and threats keep changing. We invest in learning so our advice stays current.'],
                    ['A commitment to lasting value', 'We aim for outcomes that keep serving you long after an engagement ends.'],
                ] as $i => [$title, $text]): ?>
                <li class="principle" data-reveal data-delay="<?= $i % 2 + 1 ?>">
                    <span class="principle-num"><?= sprintf('%02d', $i + 1) ?></span>
                    <div>
                        <h3><?= e($title) ?></h3>
                        <p><?= e($text) ?></p>
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<?php if ($founder): ?>
<section class="section founder">
    <div class="container founder-grid">
        <div class="founder-media" data-reveal="clip">
            <?= portrait($founder) ?>
        </div>
        <div class="founder-copy">
            <p class="eyebrow" data-reveal>Leadership</p>
            <h2 class="section-title" data-reveal data-delay="1"><?= e($founder['name']) ?></h2>
            <p class="founder-role" data-reveal data-delay="1"><?= e($founder['title']) ?></p>
            <p data-reveal data-delay="2"><?= e($founder['summary']) ?></p>
            <?php if (!empty($founder['belief'])): ?>
            <blockquote class="founder-belief" data-reveal data-delay="2"><p><?= e($founder['belief']) ?></p></blockquote>
            <?php endif; ?>
            <div data-reveal data-delay="3">
                <?= credential_chips(array_column($founder['qualifications'], 0)) ?>
            </div>
            <a class="btn btn--outline" href="<?= e(url('/team/')) ?>" data-reveal data-delay="3">Meet the Team <?= icon('arrow-right') ?></a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php partial('cta-band', ['shortcuts' => true]) ?>
