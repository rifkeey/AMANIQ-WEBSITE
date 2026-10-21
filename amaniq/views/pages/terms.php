<?php
$updated = '21 October 2026';
partial('page-hero', [
    'eyebrow' => 'Legal',
    'title' => 'Terms of Use',
    'lead' => 'The terms that apply when you use the ' . company('legal_name') . ' website.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container legal-layout">
        <aside class="legal-aside">
            <p class="legal-updated">Last updated: <?= e($updated) ?></p>
        </aside>
        <article class="prose legal-prose">
            <?php if (config('legal_review_pending', true)): ?>
            <div class="review-note" role="note">
                <strong>Draft pending legal review.</strong> These terms are a general starting point, not legal advice. They must be reviewed by a qualified legal adviser before launch — in particular the limitation of liability and governing law clauses.
            </div>
            <?php endif; ?>

            <h2>1. About these terms</h2>
            <p>This website, <?= e(company('domain')) ?>, is operated by <?= e(company('legal_name')) ?> (<?= e(company('rc')) ?>), <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?>. By using the website, you agree to these terms. If you do not agree, please do not use the website.</p>

            <h2>2. Using the website</h2>
            <p>You may use this website for lawful purposes only. You must not:</p>
            <ul>
                <li>attempt to gain unauthorised access to the website, its server or any connected system;</li>
                <li>introduce malicious code, or carry out any activity that could disrupt, damage or overload the website;</li>
                <li>use automated tools to submit forms or extract content in a way that places an unreasonable load on the website; or</li>
                <li>use the website to send unsolicited or misleading communications.</li>
            </ul>
            <p>If you believe you have found a security vulnerability in this website, please report it responsibly to <a href="mailto:<?= e(company('email')) ?>"><?= e(company('email')) ?></a> rather than testing it further.</p>

            <h2>3. Information on this website</h2>
            <p>The content of this website is provided for general information about AMANIQ and its services. It is not professional, technical, legal or financial advice, and should not be relied on as such. Specific advice is provided only under an engagement agreed with us in writing.</p>
            <p>We take care to keep the website accurate and up to date, but we do not guarantee that all content is complete, current or free from error. Descriptions of services do not constitute an offer; the scope of any engagement is set out in a written agreement.</p>

            <h2>4. Intellectual property</h2>
            <p>The AMANIQ name and logo, and the text, graphics and design of this website, are owned by or licensed to <?= e(company('legal_name')) ?>. You may view and print pages for your own reference. You may not reproduce, modify or use them for commercial purposes without our written permission.</p>

            <h2>5. Links to other websites</h2>
            <p>This website may link to websites operated by others. We are not responsible for their content, availability or privacy practices, and a link does not imply endorsement.</p>

            <h2>6. Availability</h2>
            <p>We aim to keep the website available but do not guarantee uninterrupted access. We may change, suspend or withdraw any part of the website without notice.</p>

            <h2>7. Limitation of liability</h2>
            <p>To the extent permitted by applicable law, <?= e(company('legal_name')) ?> is not liable for any loss or damage arising from your use of, or inability to use, this website or from reliance on its content. Nothing in these terms excludes or limits liability that cannot be excluded or limited under applicable law.</p>

            <h2>8. Privacy</h2>
            <p>Our <a href="<?= e(url('/privacy/')) ?>">Privacy Policy</a> explains how we handle personal information submitted through this website.</p>

            <h2>9. Governing law</h2>
            <p>These terms are governed by the laws of the Federal Republic of Nigeria.</p>

            <h2>10. Changes and contact</h2>
            <p>We may update these terms from time to time; the “last updated” date shows the current version. Questions about these terms can be sent to <a href="mailto:<?= e(company('email')) ?>"><?= e(company('email')) ?></a>.</p>
        </article>
    </div>
</section>
