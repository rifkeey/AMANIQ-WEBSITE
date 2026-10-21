<?php
/*
 * Terms of Use for the corporate website. These govern use of the website
 * only; client engagements are governed by their own written agreements.
 * Personal data matters are governed by the Privacy Policy (privacy.php).
 */
$updated = '21 October 2026';
$email = (string) company('email');
$mailto = '<a href="mailto:' . e($email) . '">' . e($email) . '</a>';
partial('page-hero', [
    'eyebrow' => 'Legal',
    'title' => 'Terms of Use',
    'lead' => 'The terms that apply when you visit or use the ' . company('legal_name') . ' website, including its enquiry form.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container legal-layout">
        <aside class="legal-aside">
            <p class="legal-updated">Last updated: <?= e($updated) ?></p>
            <nav aria-label="On this page" class="legal-toc">
                <ol>
                    <li><a href="#about">About these terms</a></li>
                    <li><a href="#acceptable-use">Acceptable use</a></li>
                    <li><a href="#security-testing">Security testing and disclosure</a></li>
                    <li><a href="#enquiries">Enquiries and communications</a></li>
                    <li><a href="#information">Information on this website</a></li>
                    <li><a href="#divisions">Our divisions and team</a></li>
                    <li><a href="#ip">Intellectual property</a></li>
                    <li><a href="#third-parties">Third-party links and services</a></li>
                    <li><a href="#platforms">Other AMANIQ platforms</a></li>
                    <li><a href="#availability">Availability and changes</a></li>
                    <li><a href="#privacy">Privacy and personal data</a></li>
                    <li><a href="#liability">Limitation of liability</a></li>
                    <li><a href="#law">Governing law and disputes</a></li>
                    <li><a href="#general">General</a></li>
                    <li><a href="#contact">Changes and contact</a></li>
                </ol>
            </nav>
        </aside>
        <article class="prose legal-prose">
            <p class="legal-intro">Please read these terms carefully. By using this website, you agree to them. If you do not agree, please do not use the website.</p>

            <h2 id="about">1. About these terms</h2>
            <p>This website, <?= e(company('domain')) ?>, is operated by <strong><?= e(company('legal_name')) ?></strong>, a company registered in Nigeria with the Corporate Affairs Commission under number <?= e(company('rc')) ?>, of <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?> (“AMANIQ”, “we”, “us”, “our”).</p>
            <p>These terms govern your use of this website only. Any services we provide are governed by a separate written agreement, which prevails over these terms if they conflict.</p>

            <h2 id="acceptable-use">2. Acceptable use</h2>
            <p>You may use this website for lawful purposes only, and in a way that does not infringe the rights of others or restrict their use of the website. You must not:</p>
            <ul>
                <li>access, or attempt to access, any part of the website, its server or any connected system or data without authorisation. Unauthorised access to computer systems may be an offence under the Cybercrimes (Prohibition, Prevention, etc.) Act, 2015;</li>
                <li>introduce viruses, malware or other harmful code, or do anything that could disable, overload, damage or impair the website;</li>
                <li>use robots, scrapers or other automated means to access the website, submit forms or copy content, except for search engines indexing public pages in line with our <code>robots.txt</code> file;</li>
                <li>use the enquiry form to send spam, advertising, or unlawful, abusive, threatening, defamatory or misleading content;</li>
                <li>impersonate any person or organisation, or give false information about your identity or authority to act for an organisation; or</li>
                <li>use the website in any way that breaches applicable law, including the Nigeria Data Protection Act, 2023.</li>
            </ul>
            <p>We may block access to the website, reject submissions, and report misuse to the relevant authorities where we reasonably believe these terms or the law have been breached.</p>

            <h2 id="security-testing">3. Security testing and responsible disclosure</h2>
            <p>Do not carry out security testing of this website, including vulnerability scanning, penetration testing or load testing, without our prior written permission.</p>
            <p>If you believe you have found a security vulnerability, please report it to <?= $mailto ?> with the subject “Security report”. Include enough detail for us to reproduce it, and do not access, modify or disclose data that does not belong to you, or make the issue public, until we have had a reasonable opportunity to fix it. We will acknowledge good-faith reports.</p>

            <h2 id="enquiries">4. Enquiries and communications</h2>
            <ul>
                <li>Sending an enquiry, or receiving a reply from us, does not create a contract, a client relationship or an obligation on either side to provide or buy services. An engagement begins only when both parties sign a written agreement.</li>
                <li>Please do not send confidential, commercially sensitive or security-sensitive information, such as passwords, system details or security incident data, through the enquiry form or by unencrypted email. Where an engagement requires confidential information, we will agree a secure method and, where appropriate, a confidentiality agreement first.</li>
                <li>You confirm that the information you give us is accurate and that you are entitled to share it, including any information about other people.</li>
                <li>We aim to respond to genuine enquiries, but we are not obliged to respond to every message, and we may decline any request for services.</li>
            </ul>

            <h2 id="information">5. Information on this website</h2>
            <p>The content of this website provides general information about AMANIQ and its services. It is not professional, technical, cybersecurity, legal, financial or procurement advice, and you should not rely on it as such. Advice specific to your circumstances is provided only under a written engagement.</p>
            <p>We take reasonable care to keep the website accurate and up to date, but we do not warrant that its content is complete, current or free from error. Descriptions of services are not offers capable of acceptance. The scope, deliverables, fees and terms of any engagement are set out in a written agreement.</p>

            <h2 id="divisions">6. Our divisions and team</h2>
            <p>AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy are business divisions of <?= e(company('legal_name')) ?>, not separate companies. Any agreement for services is made with <?= e(company('legal_name')) ?>.</p>
            <p>Team profiles describe the professional backgrounds and qualifications of individual team members, including experience gained before they joined AMANIQ. They are not statements about projects delivered by <?= e(company('legal_name')) ?>.</p>

            <h2 id="ip">7. Intellectual property</h2>
            <p>The AMANIQ name and logo, and the text, graphics, designs, layout and code of this website, are owned by or licensed to <?= e(company('legal_name')) ?> and are protected by copyright and other intellectual property laws of Nigeria and other countries.</p>
            <p>You may view, download and print pages from this website for your own information and non-commercial use, provided you do not remove any copyright or other notices. You must not copy, reproduce, modify, distribute, republish or create derivative works from any part of the website, or use the AMANIQ name or logo, for any commercial purpose or in a way that suggests an association with or endorsement by AMANIQ, without our prior written permission. Nothing in these terms grants you any other licence or right.</p>
            <p>Third-party names and trademarks mentioned on this website, including the names of professional certifications, belong to their respective owners. Their use does not imply any affiliation with or endorsement of AMANIQ.</p>

            <h2 id="third-parties">8. Third-party links and services</h2>
            <p>This website may link to, or use services provided by, third parties, such as Google Maps and Google Fonts. We do not control them and are not responsible for their content, availability, security or privacy practices. A link does not mean we endorse the linked website. Your use of third-party websites and services is subject to their own terms and policies.</p>
            <p>You may link to our home page in a way that is fair and lawful and does not damage our reputation or suggest any association, approval or endorsement on our part that does not exist. You must not frame this website on another site.</p>

            <h2 id="platforms">9. Other AMANIQ platforms</h2>
            <p>Separate AMANIQ platforms, such as an AMANIQ Academy learning platform, have their own terms of use and privacy policies, which apply when you use those platforms.</p>

            <h2 id="availability">10. Availability and changes to the website</h2>
            <p>The website is provided on an “as is” and “as available” basis. We aim to keep it available and secure but do not guarantee that it will be uninterrupted, error-free or free of harmful components. You are responsible for your own device security, including up-to-date security software. We may update, suspend or withdraw any part of the website at any time, for example for maintenance or security reasons.</p>

            <h2 id="privacy">11. Privacy and personal data</h2>
            <p>Our <a href="<?= e(url('/privacy/')) ?>">Privacy Policy</a> explains how we collect, use, protect and retain personal data, and the rights you have under the Nigeria Data Protection Act, 2023. It forms part of these terms. If these terms and the Privacy Policy conflict on any matter about personal data, the Privacy Policy prevails.</p>

            <h2 id="liability">12. Limitation of liability</h2>
            <p>Nothing in these terms excludes or limits:</p>
            <ul>
                <li>liability for fraud or fraudulent misrepresentation;</li>
                <li>liability for death or personal injury caused by negligence;</li>
                <li>your rights and remedies as a data subject under the Nigeria Data Protection Act, 2023, including the right to compensation under section 51 of that Act;</li>
                <li>your rights under the Federal Competition and Consumer Protection Act, 2018, where it applies; or</li>
                <li>any other liability that cannot be excluded or limited under Nigerian law.</li>
            </ul>
            <p>Subject to the paragraph above, and to the fullest extent permitted by law:</p>
            <ul>
                <li>we are not liable for any loss or damage arising from your use of, or inability to use, this website, or from your reliance on its content, including loss of profit, revenue, business, data or goodwill, or any indirect or consequential loss; and</li>
                <li>we are not liable for loss or damage caused by viruses or other harmful material that may affect your equipment or data because of your use of the website, or of any website linked to it.</li>
            </ul>
            <p>Our liability in connection with any services we provide is governed solely by the written agreement for those services.</p>

            <h2 id="law">13. Governing law and disputes</h2>
            <p>These terms, and any dispute or claim arising from them or from your use of the website, are governed by the laws of the Federal Republic of Nigeria.</p>
            <p>If a dispute arises, please contact us first. Both parties will try in good faith to resolve it by negotiation within 30 days. If it cannot be resolved, the courts of the Federal Capital Territory, Abuja, have jurisdiction, without affecting any right you have to complain to the Nigeria Data Protection Commission or another regulator.</p>

            <h2 id="general">14. General</h2>
            <ul>
                <li>If any part of these terms is found to be invalid or unenforceable, the rest remains in full force.</li>
                <li>If we do not enforce any of these terms, or delay in doing so, we have not waived our right to enforce it later.</li>
                <li>These terms, together with the Privacy Policy, are the entire agreement between you and us about your use of this website.</li>
                <li>You may not transfer your rights or obligations under these terms. We may transfer ours to another organisation that takes over this website, and we will update these terms if that happens.</li>
            </ul>

            <h2 id="contact">15. Changes to these terms and contact</h2>
            <p>We may revise these terms at any time by updating this page. The date at the top shows when they last changed. Please check this page from time to time; continuing to use the website after a change means you accept the revised terms.</p>
            <p>For any question about these terms, contact <?= e(company('legal_name')) ?> at <?= $mailto ?>, on <a href="<?= e(tel_href()) ?>"><?= e(company('phone')) ?></a>, or at <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?>.</p>
        </article>
    </div>
</section>
