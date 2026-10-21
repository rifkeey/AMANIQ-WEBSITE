<?php
/*
 * Privacy Policy, written to meet the information requirements of section 27
 * of the Nigeria Data Protection Act, 2023 (NDPA). If the site starts
 * collecting new data (analytics, newsletters, accounts…), update the
 * purposes table, retention periods and recipients before going live.
 */
$updated = '21 October 2026';
$email = (string) company('email');
$mailto = '<a href="mailto:' . e($email) . '">' . e($email) . '</a>';
partial('page-hero', [
    'eyebrow' => 'Legal',
    'title' => 'Privacy Policy',
    'lead' => 'How ' . company('legal_name') . ' collects, uses, protects and retains personal data, and the rights you have under the Nigeria Data Protection Act, 2023.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white">
    <div class="container legal-layout">
        <aside class="legal-aside">
            <p class="legal-updated">Last updated: <?= e($updated) ?></p>
            <nav aria-label="On this page" class="legal-toc">
                <ol>
                    <li><a href="#who-we-are">Who we are</a></li>
                    <li><a href="#scope">Scope of this policy</a></li>
                    <li><a href="#data-we-collect">Personal data we collect</a></li>
                    <li><a href="#purposes">Purposes, lawful bases and retention</a></li>
                    <li><a href="#consent">Consent and withdrawing it</a></li>
                    <li><a href="#cookies">Cookies and web fonts</a></li>
                    <li><a href="#recipients">Who receives your data</a></li>
                    <li><a href="#transfers">Transfers outside Nigeria</a></li>
                    <li><a href="#retention">How long we keep data</a></li>
                    <li><a href="#security">Security and data breaches</a></li>
                    <li><a href="#automated">Automated decision-making</a></li>
                    <li><a href="#rights">Your rights</a></li>
                    <li><a href="#complaints">Complaints</a></li>
                    <li><a href="#children">Children</a></li>
                    <li><a href="#changes">Changes and contact</a></li>
                </ol>
            </nav>
        </aside>
        <article class="prose legal-prose">
            <p class="legal-intro">We respect your privacy and handle personal data in line with the Nigeria Data Protection Act, 2023 (the “Act”). We process personal data fairly, lawfully and transparently; only for specified purposes; limited to what is necessary; kept accurate; retained no longer than necessary; and protected by appropriate security (section 24 of the Act).</p>

            <h2 id="who-we-are">1. Who we are</h2>
            <p>The data controller for personal data collected through this website is <strong><?= e(company('legal_name')) ?></strong>, a company registered in Nigeria with the Corporate Affairs Commission under number <?= e(company('rc')) ?> (“AMANIQ”, “we”, “us”, “our”).</p>
            <ul>
                <li><strong>Place of business:</strong> <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?></li>
                <li><strong>Email:</strong> <?= $mailto ?> (please use the subject “Privacy request” for privacy matters)</li>
                <li><strong>Telephone:</strong> <a href="<?= e(tel_href()) ?>"><?= e(company('phone')) ?></a></li>
            </ul>
            <p>AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy are business divisions of <?= e(company('legal_name')) ?>, not separate companies, so this policy covers all of them.</p>

            <h2 id="scope">2. Scope of this policy</h2>
            <p>This policy applies to personal data collected through <?= e(company('domain')) ?>, through its enquiry form, and when you contact us by email or telephone about our services. Any separate AMANIQ platform, such as an AMANIQ Academy learning platform, has its own privacy policy, which applies when you use that platform.</p>

            <h2 id="data-we-collect">3. Personal data we collect</h2>
            <h3>Information you give us</h3>
            <ul>
                <li><strong>Enquiry form:</strong> your full name and business email address (required); your telephone number and organisation (optional); the enquiry type, subject and message you write; and a record that you acknowledged this policy and gave consent.</li>
                <li><strong>Email and telephone:</strong> the information you choose to share when you contact us directly.</li>
            </ul>
            <h3>Information collected automatically</h3>
            <ul>
                <li><strong>Server logs:</strong> when you visit the website, our hosting provider records technical information such as your IP address, browser type, the pages requested and the date and time of each request.</li>
                <li><strong>Security records:</strong> to protect the enquiry form from automated abuse, we record the times of form submissions against a one-way, salted hash of your IP address. Your actual IP address is not stored in these records.</li>
                <li><strong>Session cookie:</strong> one strictly necessary cookie on the contact page (see section 6).</li>
            </ul>
            <p>We do not use analytics, advertising or tracking technologies, and we do not buy personal data from third parties.</p>
            <h3>Sensitive personal data</h3>
            <p>We do not ask for sensitive personal data, as defined in the Act (for example, information about health, religious beliefs, ethnic origin or political opinions). Please do not include it in your enquiry, and do not send passwords or confidential security information. If you send us sensitive personal data, we will use it only as necessary to respond to you and will delete it when it is no longer needed.</p>

            <h2 id="purposes">4. Purposes, lawful bases and retention</h2>
            <p>We use personal data only for the purposes below. Each purpose relies on a lawful basis in section 25(1) of the Act.</p>
            <div class="legal-table-wrap">
                <table class="legal-table">
                    <thead>
                        <tr><th scope="col">Purpose</th><th scope="col">Personal data</th><th scope="col">Lawful basis (Act, s.25(1))</th><th scope="col">Retention</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Purpose">Responding to your enquiry and corresponding with you about it</td>
                            <td data-label="Personal data">Enquiry form details; emails and call notes</td>
                            <td data-label="Lawful basis">Your consent, s.25(1)(a)</td>
                            <td data-label="Retention">Up to 24 months after our last communication, if no engagement follows</td>
                        </tr>
                        <tr>
                            <td data-label="Purpose">Preparing a proposal or agreement at your request, and providing services you engage us for</td>
                            <td data-label="Personal data">Contact details, enquiry details and related correspondence</td>
                            <td data-label="Lawful basis">Steps at your request before entering into a contract, and performance of a contract, s.25(1)(b)(i)</td>
                            <td data-label="Retention">For the duration of the engagement and 6 years after it ends</td>
                        </tr>
                        <tr>
                            <td data-label="Purpose">Keeping business, tax and accounting records</td>
                            <td data-label="Personal data">Contact and engagement records</td>
                            <td data-label="Lawful basis">Compliance with a legal obligation, s.25(1)(b)(ii)</td>
                            <td data-label="Retention">As long as the relevant law requires, generally 6 years</td>
                        </tr>
                        <tr>
                            <td data-label="Purpose">Keeping the website secure and available, and preventing spam and abuse</td>
                            <td data-label="Personal data">Server logs; hashed IP security records; session cookie</td>
                            <td data-label="Lawful basis">Our legitimate interests in operating a secure website, s.25(1)(b)(v)</td>
                            <td data-label="Retention">Security records: normally deleted within 24 hours. Session data: removed within a few hours. Server logs: no longer than 90 days</td>
                        </tr>
                        <tr>
                            <td data-label="Purpose">Establishing, exercising or defending legal claims</td>
                            <td data-label="Personal data">Relevant records listed above</td>
                            <td data-label="Lawful basis">Our legitimate interests, s.25(1)(b)(v)</td>
                            <td data-label="Retention">Only for as long as the matter requires</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p>We rely on legitimate interests only where they do not override your fundamental rights, freedoms and interests, and where you would reasonably expect the processing (section 25(2)). We will not use your personal data for a new purpose that is incompatible with the purposes above.</p>
            <p>We do not use your data for direct marketing. If we ever wish to, we will ask for your separate, specific consent first, and you may object to direct marketing at any time (section 36(3)).</p>

            <h2 id="consent">5. Consent and withdrawing it</h2>
            <p>When you send an enquiry, we ask you to tick a box to confirm you have read this policy and consent to us using your details to respond. The box is never pre-ticked, and we keep a record of your consent (section 26).</p>
            <p>You can withdraw your consent at any time by emailing <?= $mailto ?>. Withdrawing consent is as easy as giving it. It does not affect processing that took place before you withdrew it (sections 26(5) and 35), and we may continue to keep information where another lawful basis applies, such as a legal obligation.</p>

            <h2 id="cookies">6. Cookies and web fonts</h2>
            <p>The contact page sets one strictly necessary cookie, <code>amaniq_sid</code>, which protects the enquiry form against forged and automated submissions. It contains a random identifier, is deleted when you close your browser, and is not used to track you. No other cookies are set.</p>
            <p>This website displays typefaces provided by Google Fonts. When a page loads, your browser requests the font files directly from Google’s servers, which receive your IP address and browser information. Google’s privacy policy explains how Google handles this information. Links to Google Maps share information with Google only if you choose to follow them.</p>

            <h2 id="recipients">7. Who receives your data</h2>
            <p>Enquiries are delivered to our business email account and are accessed only by authorised AMANIQ personnel who need them to respond to you. We do not sell, rent or trade personal data. The recipients of personal data are:</p>
            <ul>
                <li><strong>Our website hosting and email provider</strong>, which hosts the website, records its server logs, and delivers and stores our email on our behalf, as our data processor;</li>
                <li><strong>Google</strong>, which receives your IP address when your browser loads web fonts (see section 6);</li>
                <li><strong>Professional advisers</strong>, such as lawyers, accountants and auditors, where necessary and under a duty of confidentiality; and</li>
                <li><strong>Regulators, law enforcement and other competent authorities</strong>, where we are required to disclose information by law or by a valid order.</li>
            </ul>
            <p>Where we use a data processor, we require it, by written agreement, to process personal data only on our instructions, to keep it secure and confidential, and to help us honour your rights, as section 29 of the Act requires.</p>

            <h2 id="transfers">8. Transfers outside Nigeria</h2>
            <p>Some of our service providers may store or process personal data outside Nigeria. Google, for example, operates servers in other countries. We transfer personal data outside Nigeria only where Part VIII of the Act permits it:</p>
            <ul>
                <li>where the recipient is subject to a law, binding corporate rules, contractual clauses, a code of conduct or a certification mechanism that provides an adequate level of protection (sections 41(1)(a) and 42); or</li>
                <li>otherwise, only where a condition in section 43 applies, for example where the transfer is necessary for steps you have asked us to take before entering into a contract, or you have consented after being informed of the possible risks.</li>
            </ul>
            <p>We record the basis for each transfer and our assessment of the protection it provides, as section 41(2) requires. You can ask us for more information about these transfers using the contact details in section 1.</p>

            <h2 id="retention">9. How long we keep data</h2>
            <p>We keep personal data only for as long as necessary for the purposes it was collected for (section 24(1)(d)). The retention period for each purpose is set out in the table in section 4. When a period ends, or when we no longer have a lawful basis to keep the data, we delete or anonymise it without undue delay (section 34(2)). We may keep data for longer only where the law requires it, or for as long as needed to deal with a legal claim.</p>

            <h2 id="security">10. Security and data breaches</h2>
            <p>We protect personal data with technical and organisational measures appropriate to the risk (section 39), including:</p>
            <ul>
                <li>encrypted connections (HTTPS) for this website and secure (TLS) connections for sending email;</li>
                <li>storing configuration and application data outside the publicly accessible part of the web server;</li>
                <li>protections against forged submissions, spam and automated abuse;</li>
                <li>keeping enquiry contents out of website logs; and</li>
                <li>restricting access to enquiries to authorised personnel, and reviewing our measures regularly.</li>
            </ul>
            <p>No method of transmission or storage is completely secure. If a personal data breach occurs that is likely to result in a risk to your rights and freedoms, we will notify the Nigeria Data Protection Commission within 72 hours of becoming aware of it. If the breach is likely to result in a high risk to you, we will also tell you directly and without delay, in plain language, including steps you can take to protect yourself (section 40). We keep a record of all personal data breaches.</p>

            <h2 id="automated">11. Automated decision-making</h2>
            <p>We do not make decisions about you based solely on automated processing, and we do not carry out profiling (section 37). Every enquiry is read and handled by a person. The website’s automated spam checks only screen form submissions for signs of abuse; if a genuine message is blocked, you can contact us by email or telephone instead.</p>

            <h2 id="rights">12. Your rights</h2>
            <p>Under Part VI of the Act, you have the right to:</p>
            <ul>
                <li><strong>Access:</strong> ask us to confirm whether we process your personal data and, if we do, to tell you the purposes, the categories of data, the recipients (including any outside Nigeria), how long we will keep it, its source if we did not collect it from you, and whether any automated decision-making applies (section 34(1)(a));</li>
                <li><strong>Obtain a copy:</strong> receive a copy of your personal data in a commonly used electronic format (section 34(1)(b)). This is free of charge, unless providing it would impose unreasonable costs, in which case we may ask you to bear some or all of those costs and will tell you in advance;</li>
                <li><strong>Correction:</strong> have inaccurate, out-of-date, incomplete or misleading data corrected, or deleted where correction is not feasible (section 34(1)(c));</li>
                <li><strong>Erasure:</strong> have your personal data erased without undue delay, unless we have a lawful basis to keep it (sections 34(1)(d) and 34(2));</li>
                <li><strong>Restriction:</strong> ask us to restrict processing while a request or objection is resolved, or where the data is needed for a legal claim (section 34(1)(e));</li>
                <li><strong>Withdraw consent:</strong> at any time, as explained in section 5 (section 35);</li>
                <li><strong>Object:</strong> object to processing based on our legitimate interests, in which case we will stop unless we can demonstrate overriding legitimate grounds. You can object to direct marketing at any time, and we will then stop using your data for that purpose (section 36);</li>
                <li><strong>Automated decisions:</strong> not be subject to decisions based solely on automated processing that produce legal or similarly significant effects (section 37); and</li>
                <li><strong>Data portability:</strong> receive your data in a structured, commonly used, machine-readable format and have it transmitted to another controller, in line with any regulations made by the Nigeria Data Protection Commission (section 38).</li>
            </ul>
            <h3>How to exercise your rights</h3>
            <p>Email <?= $mailto ?> with the subject “Privacy request”, or write to us at the address in section 1. Tell us which right you wish to exercise and give enough information for us to find your data. We may need to verify your identity before we act, to protect your data from being disclosed to someone else. We will respond without undue delay and, in any event, within 30 days of receiving your verified request. If we cannot act on your request, we will explain why.</p>

            <h2 id="complaints">13. Complaints</h2>
            <p>If you have a concern about how we handle your personal data, please contact us first so that we can try to resolve it.</p>
            <p>You have the right to lodge a complaint with the <strong>Nigeria Data Protection Commission</strong> if you believe we have handled your personal data in breach of the Act (section 46). Information about the Commission and how to complain is available at <a href="https://ndpc.gov.ng" rel="noopener" target="_blank">ndpc.gov.ng<span class="visually-hidden"> (opens in a new tab)</span></a>. If you suffer injury, loss or harm as a result of a breach of the Act, you may also be entitled to seek compensation through the courts (section 51).</p>

            <h2 id="children">14. Children</h2>
            <p>This website and our services are intended for businesses, organisations and adults. We do not knowingly collect personal data from children (persons under 18, as defined in the Child’s Rights Act, 2003) without the consent of a parent or legal guardian (section 31). Training enquiries for a child should be made by a parent or legal guardian. If we learn that we have collected a child’s personal data without that consent, we will delete it.</p>

            <h2 id="changes">15. Changes to this policy and contact</h2>
            <p>We review this policy regularly and update it when our practices or the law change. The date at the top of this page shows when it was last updated. Where a change materially affects how we use personal data we already hold, we will tell the people affected where we are able to.</p>
            <p>For any question about this policy or your personal data, contact <?= e(company('legal_name')) ?> at <?= $mailto ?>, on <a href="<?= e(tel_href()) ?>"><?= e(company('phone')) ?></a>, or at <?= e(company('address.street')) ?>, <?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?>.</p>
        </article>
    </div>
</section>
