<section class="error-page">
    <div class="container">
        <p class="error-code" aria-hidden="true">404</p>
        <p class="eyebrow">Page not found</p>
        <h1 class="page-title">We could not find <em>that page.</em></h1>
        <p class="lead">The page may have moved, or the address may be mistyped. These links may help:</p>
        <ul class="error-links">
            <li><a href="<?= e(url('/')) ?>">Home</a></li>
            <li><a href="<?= e(url('/services/')) ?>">Our Services</a></li>
            <li><a href="<?= e(url('/divisions/')) ?>">Our Divisions</a></li>
            <li><a href="<?= e(url('/team/')) ?>">Meet the Team</a></li>
            <li><a href="<?= e(url('/contact/')) ?>">Contact</a></li>
        </ul>
    </div>
</section>
