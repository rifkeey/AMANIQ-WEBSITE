<?php
$articles = content('insights');
usort($articles, static fn ($a, $b) => strcmp($b['date'], $a['date']));
partial('page-hero', [
    'eyebrow' => 'Insights',
    'title' => 'Perspectives on security, technology and <em>doing business well.</em>',
    'lead' => 'Cybersecurity insights, consulting perspectives, training updates and company announcements from AMANIQ.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container">
        <?php if ($articles === []): ?>
        <div class="empty-state" data-reveal>
            <span class="empty-mark" aria-hidden="true"><?= icon('diamond') ?></span>
            <h2 class="section-title section-title--sm">Our first articles are on the way.</h2>
            <p class="muted">We are preparing practical articles on cybersecurity, technology, consulting and professional development. In the meantime, our team is happy to discuss any topic directly.</p>
            <div class="topic-row">
                <?php foreach (['Cybersecurity', 'Consulting', 'Training', 'Announcements'] as $topic): ?>
                <span class="topic"><?= e($topic) ?></span>
                <?php endforeach; ?>
            </div>
            <a class="btn btn--primary" href="<?= e(url('/contact/#enquiry')) ?>">Contact Our Team <?= icon('arrow-right') ?></a>
        </div>
        <?php else: ?>
        <ul class="article-list">
            <?php foreach ($articles as $a): ?>
            <li class="article-card" data-reveal>
                <p class="article-meta"><span><?= e($a['category']) ?></span><time datetime="<?= e($a['date']) ?>"><?= e(date('j F Y', strtotime($a['date']))) ?></time></p>
                <h2><a class="card-link" href="<?= e(url('/insights/' . $a['slug'] . '/')) ?>"><?= e($a['title']) ?></a></h2>
                <p><?= e($a['summary']) ?></p>
                <span class="link-arrow" aria-hidden="true">Read article <?= icon('arrow-right') ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</section>
