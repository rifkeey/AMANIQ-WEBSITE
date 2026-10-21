<?php
/** @var array $article */
$author = content('team')[$article['author'] ?? ''] ?? null;
partial('page-hero', [
    'eyebrow' => $article['category'],
    'title' => e($article['title']),
    'lead' => $article['summary'],
    'crumbs' => $meta['breadcrumbs'],
    'extra' => '<p class="article-meta hero-in" data-delay="4"><time datetime="' . e($article['date']) . '">' . e(date('j F Y', strtotime($article['date']))) . '</time>'
        . ($author ? '<span>By ' . e($author['name']) . '</span>' : '') . '</p>',
]) ?>

<section class="section section--white">
    <div class="container">
        <article class="prose article-body">
            <?php foreach ($article['body'] as $block): ?>
            <?php if (is_array($block) && ($block[0] ?? '') === 'h2'): ?>
            <h2><?= e($block[1]) ?></h2>
            <?php else: ?>
            <p><?= e($block) ?></p>
            <?php endif; ?>
            <?php endforeach; ?>
        </article>
        <p class="center-link"><a class="link-arrow" href="<?= e(url('/insights/')) ?>">All insights <?= icon('arrow-right') ?></a></p>
    </div>
</section>

<?php partial('cta-band') ?>
