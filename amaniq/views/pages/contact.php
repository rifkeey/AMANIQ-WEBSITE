<?php
/**
 * @var array $errors @var array $old @var ?string $alert @var bool $sent @var string $csrf
 */
$val = static fn (string $key): string => e($old[$key] ?? '');
$err = static fn (string $key): string => isset($errors[$key])
    ? '<p class="field-error" id="' . e($key) . '-error">' . e($errors[$key]) . '</p>' : '';
$invalid = static fn (string $key): string => isset($errors[$key]) ? ' aria-invalid="true" aria-describedby="' . e($key) . '-error"' : '';
$whatsapp = whatsapp_href();

partial('page-hero', [
    'eyebrow' => 'Contact Us',
    'title' => 'Let’s discuss <em>your project.</em>',
    'lead' => 'Tell us about your challenge, requirement or idea. A member of our team will review your enquiry and respond using the contact details you provide.',
    'crumbs' => $meta['breadcrumbs'],
]) ?>

<section class="section section--white contact-section">
    <div class="container contact-grid">
        <aside class="contact-details" data-reveal>
            <h2 class="contact-heading">Contact details</h2>
            <ul class="contact-list">
                <li>
                    <span class="contact-icon"><?= icon('phone') ?></span>
                    <div><span class="contact-label">Telephone</span><a href="<?= e(tel_href()) ?>"><?= e(company('phone')) ?></a></div>
                </li>
                <li>
                    <span class="contact-icon"><?= icon('mail') ?></span>
                    <div><span class="contact-label">Email</span><a href="mailto:<?= e(company('email')) ?>"><?= e(company('email')) ?></a></div>
                </li>
                <?php if ($whatsapp): ?>
                <li>
                    <span class="contact-icon"><?= icon('chat') ?></span>
                    <div><span class="contact-label">WhatsApp</span><a href="<?= e($whatsapp) ?>" rel="noopener" target="_blank">Message us on WhatsApp<span class="visually-hidden"> (opens in a new tab)</span></a></div>
                </li>
                <?php endif; ?>
                <li>
                    <span class="contact-icon"><?= icon('pin') ?></span>
                    <div>
                        <span class="contact-label">Office</span>
                        <address><?= e(company('legal_name')) ?><br><?= e(company('address.street')) ?><br><?= e(company('address.locality')) ?>, <?= e(company('address.region')) ?>, <?= e(company('address.country')) ?></address>
                        <a class="link-arrow" href="<?= e(company('map_url')) ?>" rel="noopener" target="_blank">View on Google Maps <?= icon('arrow-up-right') ?><span class="visually-hidden"> (opens in a new tab)</span></a>
                    </div>
                </li>
            </ul>
            <div class="contact-note">
                <h3>What happens next</h3>
                <ol>
                    <li>We review your enquiry and pass it to the right person.</li>
                    <li>We contact you to understand your needs in more detail.</li>
                    <li>Where appropriate, we propose a scope and approach for your review.</li>
                </ol>
            </div>
        </aside>

        <div class="enquiry" id="enquiry" tabindex="-1">
            <?php if ($sent): ?>
            <div class="form-success" role="status" data-reveal>
                <span class="form-success-icon" aria-hidden="true"><?= icon('check') ?></span>
                <h2>Thank you — your enquiry has been sent.</h2>
                <p>We have received your message and a member of our team will respond using the contact details you provided. If your matter is urgent, please call us on <a href="<?= e(tel_href()) ?>"><?= e(company('phone')) ?></a>.</p>
                <a class="btn btn--outline" href="<?= e(url('/')) ?>">Return to the home page</a>
            </div>
            <?php else: ?>
            <form class="enquiry-form" method="post" action="<?= e(url('/contact/#enquiry')) ?>" novalidate data-enquiry-form>
                <h2 class="form-title">Submit a business enquiry</h2>
                <p class="form-intro">Fields marked <span class="req" aria-hidden="true">*</span><span class="visually-hidden">with an asterisk</span> are required.</p>

                <?php if ($alert): ?>
                <div class="form-alert" role="alert" tabindex="-1" data-form-alert><?= icon('diamond') ?><p><?= e($alert) ?></p></div>
                <?php endif; ?>

                <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                <div class="hp-field" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="form-grid">
                    <div class="field<?= isset($errors['name']) ? ' has-error' : '' ?>">
                        <label for="name">Full name <span class="req" aria-hidden="true">*</span></label>
                        <input type="text" id="name" name="name" value="<?= $val('name') ?>" autocomplete="name" required minlength="2" maxlength="100"<?= $invalid('name') ?>>
                        <?= $err('name') ?>
                    </div>
                    <div class="field<?= isset($errors['email']) ? ' has-error' : '' ?>">
                        <label for="email">Business email <span class="req" aria-hidden="true">*</span></label>
                        <input type="email" id="email" name="email" value="<?= $val('email') ?>" autocomplete="email" required maxlength="254" inputmode="email"<?= $invalid('email') ?>>
                        <?= $err('email') ?>
                    </div>
                    <div class="field<?= isset($errors['phone']) ? ' has-error' : '' ?>">
                        <label for="phone">Telephone <span class="optional">(optional)</span></label>
                        <input type="tel" id="phone" name="phone" value="<?= $val('phone') ?>" autocomplete="tel" maxlength="30" pattern="\+?[0-9 ()\-]{7,20}"<?= $invalid('phone') ?>>
                        <?= $err('phone') ?>
                    </div>
                    <div class="field">
                        <label for="organisation">Organisation <span class="optional">(optional)</span></label>
                        <input type="text" id="organisation" name="organisation" value="<?= $val('organisation') ?>" autocomplete="organization" maxlength="150">
                    </div>
                    <div class="field field--full<?= isset($errors['enquiry_type']) ? ' has-error' : '' ?>">
                        <label for="enquiry_type">Enquiry type <span class="req" aria-hidden="true">*</span></label>
                        <div class="select-wrap">
                            <select id="enquiry_type" name="enquiry_type" required<?= $invalid('enquiry_type') ?>>
                                <option value="">Please choose…</option>
                                <?php foreach (enquiry_types() as $key => $label): ?>
                                <option value="<?= e($key) ?>"<?= ($old['enquiry_type'] ?? '') === $key ? ' selected' : '' ?>><?= e($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= icon('chevron-down') ?>
                        </div>
                        <?= $err('enquiry_type') ?>
                    </div>
                    <div class="field field--full<?= isset($errors['subject']) ? ' has-error' : '' ?>">
                        <label for="subject">Subject <span class="req" aria-hidden="true">*</span></label>
                        <input type="text" id="subject" name="subject" value="<?= $val('subject') ?>" required minlength="3" maxlength="150"<?= $invalid('subject') ?>>
                        <?= $err('subject') ?>
                    </div>
                    <div class="field field--full<?= isset($errors['message']) ? ' has-error' : '' ?>">
                        <label for="message">Message <span class="req" aria-hidden="true">*</span></label>
                        <textarea id="message" name="message" rows="7" required minlength="20" maxlength="5000"<?= $invalid('message') ?>><?= $val('message') ?></textarea>
                        <p class="field-hint" id="message-hint">Briefly describe your requirement, timescales and any relevant background. Please do not include passwords or other sensitive information.</p>
                        <?= $err('message') ?>
                    </div>
                    <div class="field field--full field--check<?= isset($errors['consent']) ? ' has-error' : '' ?>">
                        <input type="checkbox" id="consent" name="consent" value="1" required<?= ($old['consent'] ?? '') === '1' ? ' checked' : '' ?><?= $invalid('consent') ?>>
                        <label for="consent">I have read the <a href="<?= e(url('/privacy/')) ?>">privacy notice</a> and agree that AMANIQ Projects Limited may use these details to respond to my enquiry. <span class="req" aria-hidden="true">*</span></label>
                        <?= $err('consent') ?>
                    </div>
                </div>

                <div class="form-submit">
                    <button class="btn btn--primary" type="submit" data-submit>
                        <span data-submit-label>Send enquiry</span> <?= icon('arrow-right') ?>
                    </button>
                    <p class="form-privacy">We use your details only to respond to your enquiry. See our <a href="<?= e(url('/privacy/')) ?>">Privacy Policy</a>.</p>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section faq-section">
    <div class="container split">
        <div class="split-label" data-reveal>
            <p class="eyebrow">Questions</p>
            <h2 class="section-title section-title--sm">Frequently asked questions</h2>
        </div>
        <div class="faq" data-reveal data-delay="1">
            <?php foreach ([
                ['Which organisations do you work with?', 'We work with private companies, financial institutions and fintech companies, public-sector organisations, development and international organisations, and individuals seeking professional training.'],
                ['Can you combine several services in one engagement?', 'Yes. Many challenges span more than one area — for example, a security review followed by technology implementation and staff training. We can coordinate this as a single engagement with one point of contact.'],
                ['How does an engagement start?', 'It starts with a conversation about your objectives and context. If there is a good fit, we agree the scope, deliverables, responsibilities and timelines with you in writing before work begins.'],
                ['Are the divisions separate companies?', 'No. AMANIQ Technologies, AMANIQ Consulting, AMANIQ Digital Labs and AMANIQ Academy are business divisions of AMANIQ Projects Limited (' . company('rc') . ').'],
                ['How can I find out about AMANIQ Academy courses?', 'Visit the AMANIQ Academy page, or choose “Training and Academy” as your enquiry type above and tell us what you would like to learn.'],
                ['Do you work with organisations outside Abuja?', 'We welcome enquiries from organisations across Nigeria and internationally. Tell us where you are based and we will discuss how we can work together.'],
            ] as $i => [$q, $a]): ?>
            <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
                <summary><span><?= e($q) ?></span><?= icon('plus', 'icon faq-icon') ?></summary>
                <div class="faq-answer"><p><?= e($a) ?></p></div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
