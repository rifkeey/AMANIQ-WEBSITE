<?php
$updated = '21 October 2026';
partial('page-hero', [
    'eyebrow' => 'Legal',
    'title' => 'Privacy Policy',
    'lead' => 'How ' . company('legal_name') . ' collects, uses and protects personal information submitted through this website.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container legal-layout">
        <aside class="legal-aside">
            <p class="legal-updated">Last updated: <?= e($updated) ?></p>
            <nav aria-label="On this page" class="legal-toc">
                <ol>
                    <li><a href="#who-we-are">Who we are</a></li>
                    <li><a href="#information">Information we collect</a></li>
                    <li><a href="#purposes">How and why we use it</a></li>
                    <li><a href="#cookies">Cookies and fonts</a></li>
                    <li><a href="#sharing">Who we share it with</a></li>
                    <li><a href="#retention">Retention and security</a></li>
                    <li><a href="#rights">Your rights</a></li>
                    <li><a href="#complaints">Questions and complaints</a></li>
                    <li><a href="#changes">Changes to this policy</a></li>
                </ol>
            </nav>
        </aside>
        <article class="prose legal-prose">
            <?php if (config('legal_review_pending', true)): ?>
            <div class="review-note" role="note">
                <strong>Draft pending legal review.</strong> This policy was prepared as a starting point and must be reviewed by a qualified legal adviser before it is relied on, in particular the lawful bases, retention periods, international transfer safeguards and any registration or audit obligations under the Nigeria Data Protection Act 2023.
            </div>
            <?php endif; ?>

            <h2 id="who-we-are">1. Who we are</h2>
            <p>This website, <?= e(company('domain')) ?>, is operated by <?= e(company('legal_name')) ?> (<?= e(company('rc')) ?>), <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?> (“AMANIQ”, “we”, “us”). We are responsible for the personal information described in this policy.</p>
            <p>AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy are divisions of <?= e(company('legal_name')) ?>; this policy covers all of them on this website. A separate AMANIQ Academy learning platform, if you use one, has its own privacy notice.</p>

            <h2 id="information">2. Information we collect</h2>
            <h3>Information you give us</h3>
            <p>When you use our enquiry form, we collect your name, business email address and, if you choose to provide them, your telephone number and organisation, together with the enquiry type, subject and message you write. If you email or call us directly, we receive the information you choose to share.</p>
            <p>Please do not include sensitive personal information, passwords or confidential security details in the enquiry form.</p>
            <h3>Information collected automatically</h3>
            <ul>
                <li><strong>Server logs.</strong> Like most websites, our hosting provider records technical information such as IP address, browser type, the pages requested and the date and time of each request. This is used to operate and secure the website.</li>
                <li><strong>Abuse-prevention records.</strong> To protect the enquiry form from automated abuse, we keep a short-lived record of submission attempts linked to a one-way (hashed) form of your IP address. These records are deleted automatically, normally within 24 hours.</li>
            </ul>
            <p>We do not use analytics, advertising or tracking cookies on this website.</p>

            <h2 id="purposes">3. How and why we use your information</h2>
            <ul>
                <li><strong>To respond to your enquiry</strong> and, where you ask us to, to take steps towards providing services. This is based on your consent and on steps taken at your request before entering into a contract.</li>
                <li><strong>To operate and secure this website</strong>, including preventing spam and abuse. This is based on our legitimate interest in keeping the website safe and available.</li>
                <li><strong>To meet legal obligations</strong> where the law requires us to keep or disclose information.</li>
            </ul>
            <p>We do not sell your personal information, and we do not add you to marketing lists without your separate, explicit consent.</p>

            <h2 id="cookies">4. Cookies and fonts</h2>
            <p>The contact page sets one strictly necessary cookie, <code>amaniq_sid</code>, which keeps the form secure (for example, by protecting against forged submissions). It is deleted when you close your browser and is not used to track you.</p>
            <p>This website loads typefaces from Google Fonts. When a page loads, your browser connects to Google’s servers, which receive your IP address. See Google’s privacy policy for how Google handles this information. Links to Google Maps only share information with Google if you choose to follow them.</p>

            <h2 id="sharing">5. Who we share information with</h2>
            <p>Enquiries are delivered to our business email account and are accessed only by authorised AMANIQ personnel who need them to respond. We use service providers who process information on our behalf:</p>
            <ul>
                <li>our website hosting provider, which stores the website and its server logs;</li>
                <li>our email service provider, which delivers and stores email; and</li>
                <li>Google, for web fonts as described above.</li>
            </ul>
            <p>We may also disclose information to professional advisers, or where required by law, regulation or a valid request from a public authority. Some providers may process information outside Nigeria; where this happens we take steps to ensure the information remains appropriately protected, as required by applicable data protection law.</p>

            <h2 id="retention">6. Retention and security</h2>
            <p>We keep enquiry information only for as long as needed to respond to you and to manage any relationship that follows, and to meet legal or accounting requirements. We then delete it or anonymise it.</p>
            <p>We protect information using measures appropriate to the risk, including encrypted connections (HTTPS), access controls and secure configuration of our website and email. No method of transmission or storage is completely secure, so we cannot guarantee absolute security.</p>

            <h2 id="rights">7. Your rights</h2>
            <p>Subject to the Nigeria Data Protection Act 2023 and other applicable law, you may have the right to:</p>
            <ul>
                <li>be informed about how your personal information is used;</li>
                <li>request access to the personal information we hold about you;</li>
                <li>ask us to correct inaccurate or incomplete information;</li>
                <li>ask us to delete your information, or to restrict how we use it;</li>
                <li>object to certain processing, and receive your information in a portable format where applicable; and</li>
                <li>withdraw your consent at any time, without affecting processing that took place before you withdrew it.</li>
            </ul>
            <p>To exercise any of these rights, email <a href="mailto:<?= e(company('email')) ?>"><?= e(company('email')) ?></a> with the subject “Privacy request”. We may need to confirm your identity before acting on a request.</p>

            <h2 id="complaints">8. Questions and complaints</h2>
            <p>If you have a question or concern about how we handle personal information, please contact us first at <a href="mailto:<?= e(company('email')) ?>"><?= e(company('email')) ?></a> or by post at the address above, and we will try to resolve it.</p>
            <p>You also have the right to lodge a complaint with the Nigeria Data Protection Commission (NDPC).</p>

            <h2 id="changes">9. Changes to this policy</h2>
            <p>We may update this policy from time to time. The “last updated” date at the top of the page shows when it was last changed.</p>
        </article>
    </div>
</section>
