<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand">
                <a class="footer-logo" href="<?= e(url('/')) ?>" aria-label="AMANIQ — home"><?= wordmark('brand-mark', false) ?></a>
                <p>Technology solutions, cybersecurity, consulting, digital innovation, professional training and procurement services — delivered with integrity.</p>
                <a class="btn btn--gold btn--sm" href="<?= e(url('/contact/#enquiry')) ?>">Discuss a Project</a>
            </div>
            <nav class="footer-col" aria-label="Services">
                <h2 class="footer-heading">Services</h2>
                <ul>
                    <?php foreach (content('services') as $s): ?>
                    <li><a href="<?= e(url('/services/' . $s['slug'] . '/')) ?>"><?= e($s['short']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <nav class="footer-col" aria-label="Divisions">
                <h2 class="footer-heading">Divisions</h2>
                <ul>
                    <?php foreach (content('divisions') as $d): ?>
                    <li><a href="<?= e(url('/divisions/' . $d['slug'] . '/')) ?>"><?= e($d['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <nav class="footer-col" aria-label="Company">
                <h2 class="footer-heading">Company</h2>
                <ul>
                    <li><a href="<?= e(url('/about/')) ?>">About AMANIQ</a></li>
                    <li><a href="<?= e(url('/mission-values/')) ?>">Mission &amp; Values</a></li>
                    <li><a href="<?= e(url('/team/')) ?>">Meet the Team</a></li>
                    <li><a href="<?= e(url('/insights/')) ?>">Insights</a></li>
                    <li><a href="<?= e(url('/contact/')) ?>">Contact</a></li>
                </ul>
            </nav>
            <div class="footer-col footer-contact">
                <h2 class="footer-heading">Contact</h2>
                <address>
                    <a href="<?= e(tel_href()) ?>"><?= icon('phone') ?><?= e(company('phone')) ?></a>
                    <a href="mailto:<?= e(company('email')) ?>"><?= icon('mail') ?><?= e(company('email')) ?></a>
                    <a href="<?= e(company('map_url')) ?>" rel="noopener" target="_blank"><?= icon('pin') ?><span><?= e(company('address.street')) ?>,<br><?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?><span class="visually-hidden"> (opens Google Maps in a new tab)</span></span></a>
                </address>
            </div>
        </div>
        <p class="footer-divisions-note">AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy are business divisions of AMANIQ Projects Limited.</p>
        <div class="footer-bottom">
            <p><strong><?= e(company('legal_name')) ?> <span aria-hidden="true">·</span> <?= e(company('rc')) ?></strong></p>
            <p>&copy; <?= date('Y') ?> <?= e(company('legal_name')) ?>. All rights reserved.</p>
            <ul class="footer-legal">
                <li><a href="<?= e(url('/privacy/')) ?>">Privacy Policy</a></li>
                <li><a href="<?= e(url('/terms/')) ?>">Terms of Use</a></li>
            </ul>
        </div>
    </div>
</footer>
