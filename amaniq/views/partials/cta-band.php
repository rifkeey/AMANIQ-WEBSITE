<?php
/**
 * Closing call to action.
 * Optional vars: $title, $text, $label, $enquiry (preselected contact enquiry type), $shortcuts (bool)
 */
$title ??= 'Let’s talk about what you need to achieve.';
$text ??= 'Tell us about your technology challenge, consulting engagement, training requirement or procurement need. We will listen first, then suggest a sensible way forward.';
$label ??= 'Discuss a Project';
$enquiry ??= null;
$shortcuts ??= false;
$target = $enquiry ? url('/contact/#enquiry', ['enquiry' => $enquiry]) : url('/contact/#enquiry');
?>
<section class="section cta-section">
    <div class="container">
        <div class="cta-panel" data-reveal>
            <div class="cta-panel-lines" aria-hidden="true"></div>
            <div class="cta-copy">
                <p class="eyebrow eyebrow--on-dark">Start a conversation</p>
                <h2 class="cta-title"><?= e($title) ?></h2>
                <p class="cta-text"><?= e($text) ?></p>
                <div class="btn-row">
                    <a class="btn btn--gold" href="<?= e($target) ?>"><?= e($label) ?> <?= icon('arrow-right') ?></a>
                    <a class="btn btn--ghost-light" href="<?= e(tel_href()) ?>"><?= icon('phone') ?> <?= e(company('phone')) ?></a>
                </div>
            </div>
            <?php if ($shortcuts): ?>
            <ul class="cta-shortcuts">
                <?php foreach ([
                    ['cyber-it', 'A technology or cybersecurity challenge'],
                    ['consulting', 'A consulting engagement'],
                    ['training', 'A training requirement'],
                    ['procurement', 'A procurement opportunity'],
                ] as [$key, $shortcut]): ?>
                <li><a href="<?= e(url('/contact/#enquiry', ['enquiry' => $key])) ?>"><span><?= e($shortcut) ?></span><?= icon('arrow-up-right') ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
