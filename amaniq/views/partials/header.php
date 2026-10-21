<?php
$services = content('services');
$divisions = content('divisions');
$aboutActive = is_current('/about/') || is_current('/mission-values/') || is_current('/team/');
?>
<div class="utility-bar">
    <div class="container utility-inner">
        <p class="utility-legal"><?= e(company('legal_name')) ?> <span aria-hidden="true">·</span> <?= e(company('rc')) ?></p>
        <ul class="utility-links">
            <li><a href="mailto:<?= e(company('email')) ?>"><?= icon('mail') ?><?= e(company('email')) ?></a></li>
            <li><a href="<?= e(tel_href()) ?>"><?= icon('phone') ?><?= e(company('phone')) ?></a></li>
        </ul>
    </div>
</div>
<header class="site-header" data-header>
    <div class="container header-inner">
        <a class="brand" href="<?= e(url('/')) ?>" aria-label="AMANIQ home">
            <?= wordmark('brand-mark', false) ?>
        </a>

        <nav class="primary-nav" aria-label="Main">
            <ul class="nav-list">
                <li class="nav-item has-sub" data-dropdown>
                    <a class="nav-link<?= $aboutActive ? ' is-active' : '' ?>" href="<?= e(url('/about/')) ?>"<?= is_current('/about/') ? ' aria-current="page"' : '' ?>>About</a>
                    <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="sub-about" data-dropdown-toggle>
                        <span class="visually-hidden">Show About pages</span><?= icon('chevron-down') ?>
                    </button>
                    <div class="subnav subnav--simple" id="sub-about">
                        <ul>
                            <li><a href="<?= e(url('/about/')) ?>"<?= is_current('/about/') ? ' aria-current="page"' : '' ?>><strong>About AMANIQ</strong><span>Who we are and how we work</span></a></li>
                            <li><a href="<?= e(url('/mission-values/')) ?>"<?= is_current('/mission-values/') ? ' aria-current="page"' : '' ?>><strong>Mission, Vision &amp; Values</strong><span>The principles that guide us</span></a></li>
                            <li><a href="<?= e(url('/team/')) ?>"<?= is_current('/team/') ? ' aria-current="page"' : '' ?>><strong>Meet the Team</strong><span>The people behind AMANIQ</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-sub" data-dropdown>
                    <a class="nav-link<?= is_current('/services/', true) ? ' is-active' : '' ?>" href="<?= e(url('/services/')) ?>"<?= is_current('/services/') ? ' aria-current="page"' : '' ?>>Our Services</a>
                    <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="sub-services" data-dropdown-toggle>
                        <span class="visually-hidden">Show services</span><?= icon('chevron-down') ?>
                    </button>
                    <div class="subnav subnav--mega" id="sub-services">
                        <ul class="subnav-grid">
                            <?php foreach ($services as $s): ?>
                            <li><a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>"<?= is_current('/services/' . $s['slug'] . '/') ? ' aria-current="page"' : '' ?>><?= icon($s['icon'], 'icon subnav-icon') ?><span><strong><?= e($s['title']) ?></strong></span></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="subnav-footer link-arrow" href="<?= e(url('/services/')) ?>">View all services <?= icon('arrow-right') ?></a>
                    </div>
                </li>
                <li class="nav-item has-sub" data-dropdown>
                    <a class="nav-link<?= is_current('/divisions/', true) ? ' is-active' : '' ?>" href="<?= e(url('/divisions/')) ?>"<?= is_current('/divisions/') ? ' aria-current="page"' : '' ?>>Our Divisions</a>
                    <button class="sub-toggle" type="button" aria-expanded="false" aria-controls="sub-divisions" data-dropdown-toggle>
                        <span class="visually-hidden">Show divisions</span><?= icon('chevron-down') ?>
                    </button>
                    <div class="subnav subnav--simple" id="sub-divisions">
                        <ul>
                            <?php foreach ($divisions as $d): ?>
                            <li><a class="subnav-division acc-<?= e($d['slug']) ?>" href="<?= e(url('/divisions/' . $d['slug'] . '/')) ?>"<?= is_current('/divisions/' . $d['slug'] . '/') ? ' aria-current="page"' : '' ?>><strong><?= e($d['name']) ?></strong><span><?= e($d['tagline']) ?></span></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link<?= is_current('/academy/') ? ' is-active' : '' ?>" href="<?= e(url('/academy/')) ?>"<?= is_current('/academy/') ? ' aria-current="page"' : '' ?>>Academy</a></li>
                <li class="nav-item"><a class="nav-link<?= is_current('/contact/') ? ' is-active' : '' ?>" href="<?= e(url('/contact/')) ?>"<?= is_current('/contact/') ? ' aria-current="page"' : '' ?>>Contact</a></li>
            </ul>
        </nav>

        <a class="btn btn--primary btn--sm header-cta" href="<?= e(url('/contact/#enquiry')) ?>">Discuss a Project</a>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" data-menu-toggle>
            <span class="menu-toggle-label">Menu</span>
            <span class="menu-toggle-bars" aria-hidden="true"><span></span><span></span></span>
        </button>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav" data-mobile-nav hidden>
    <div class="mobile-nav-inner container">
        <nav aria-label="Mobile">
            <ul class="mobile-list">
                <li><a href="<?= e(url('/')) ?>"<?= is_current('/') ? ' aria-current="page"' : '' ?>>Home</a></li>
                <li>
                    <details>
                        <summary>About <?= icon('plus') ?></summary>
                        <ul>
                            <li><a href="<?= e(url('/about/')) ?>">About AMANIQ</a></li>
                            <li><a href="<?= e(url('/mission-values/')) ?>">Mission, Vision &amp; Values</a></li>
                            <li><a href="<?= e(url('/team/')) ?>">Meet the Team</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>Our Services <?= icon('plus') ?></summary>
                        <ul>
                            <li><a href="<?= e(url('/services/')) ?>">All services</a></li>
                            <?php foreach ($services as $s): ?>
                            <li><a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>"><?= e($s['title']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>Our Divisions <?= icon('plus') ?></summary>
                        <ul>
                            <li><a href="<?= e(url('/divisions/')) ?>">All divisions</a></li>
                            <?php foreach ($divisions as $d): ?>
                            <li><a href="<?= e(url('/divisions/' . $d['slug'] . '/')) ?>"><?= e($d['name']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </details>
                </li>
                <li><a href="<?= e(url('/academy/')) ?>"<?= is_current('/academy/') ? ' aria-current="page"' : '' ?>>Academy</a></li>
                <li><a href="<?= e(url('/contact/')) ?>">Contact</a></li>
            </ul>
        </nav>
        <div class="mobile-nav-foot">
            <a class="btn btn--primary btn--block" href="<?= e(url('/contact/#enquiry')) ?>">Discuss a Project</a>
            <a class="mobile-contact" href="<?= e(tel_href()) ?>"><?= icon('phone') ?><?= e(company('phone')) ?></a>
            <a class="mobile-contact" href="mailto:<?= e(company('email')) ?>"><?= icon('mail') ?><?= e(company('email')) ?></a>
        </div>
    </div>
</div>
