<?php
declare(strict_types=1);

/** Enquiry categories offered on the contact form, keyed by the value posted. */
function enquiry_types(): array
{
    return [
        'cyber-it' => 'Cybersecurity and IT',
        'consulting' => 'Consulting',
        'digital' => 'Digital products',
        'training' => 'Training and Academy',
        'procurement' => 'Procurement',
        'partnerships' => 'Partnerships',
        'general' => 'General enquiries',
    ];
}

/**
 * Where an enquiry is delivered: the inbox set for its type in config
 * mail.routing (falling back to mail.to_email), plus a copy to mail.copy_to
 * so one inbox always sees every enquiry. Addresses come from configuration
 * only, never from the submitted form.
 *
 * @return array{0: string, 1: list<string>} [primary recipient, copy recipients]
 */
function enquiry_recipients(string $type): array
{
    $fallback = (string) config('mail.to_email', company('email'));
    $routed = (string) (config('mail.routing', [])[$type] ?? '');
    $primary = filter_var($routed, FILTER_VALIDATE_EMAIL) ? $routed : $fallback;

    $copy = (string) config('mail.copy_to', '');
    $copies = filter_var($copy, FILTER_VALIDATE_EMAIL) && strcasecmp($copy, $primary) !== 0 ? [$copy] : [];
    return [$primary, $copies];
}

/** Trims a submitted value, removes control characters and caps its length. */
function clean_input(mixed $value, int $max, bool $multiline = false): string
{
    if (!is_string($value)) {
        return '';
    }
    $value = str_replace(["\r\n", "\r"], "\n", $value);
    $value = preg_replace($multiline ? '/[^\P{C}\n\t]/u' : '/\p{C}/u', '', $value) ?? '';
    return mb_substr(trim($value), 0, $max);
}

/**
 * Validates and sends a contact-form submission. On success this redirects
 * (POST/redirect/GET); otherwise it returns the state to re-render the form.
 *
 * @return array{errors: array<string,string>, old: array<string,string>, alert: ?string}
 */
function contact_process(array $post): array
{
    $old = [
        'name' => clean_input($post['name'] ?? '', 100),
        'email' => clean_input($post['email'] ?? '', 254),
        'phone' => clean_input($post['phone'] ?? '', 30),
        'organisation' => clean_input($post['organisation'] ?? '', 150),
        'enquiry_type' => clean_input($post['enquiry_type'] ?? '', 30),
        'subject' => clean_input($post['subject'] ?? '', 150),
        'message' => clean_input($post['message'] ?? '', 5000, true),
        'consent' => isset($post['consent']) ? '1' : '',
    ];
    $state = ['errors' => [], 'old' => $old, 'alert' => null];
    $retry = 'We could not process your enquiry. Please wait a moment and try again, or email us directly at ' . company('email') . '.';

    $limit = (array) config('security.contact_rate_limit', ['max' => 5, 'window' => 900]);
    if (!rate_limit_attempt('contact', client_ip(), (int) ($limit['max'] ?? 5), (int) ($limit['window'] ?? 900))) {
        app_log('notice', 'Contact form rate limit reached.');
        $state['alert'] = 'You have sent several enquiries in a short time. Please try again later, or email us directly at ' . company('email') . '.';
        return $state;
    }

    if (!csrf_valid($post['_token'] ?? null)) {
        $state['alert'] = 'Your session expired before the form was sent. Please check your details and submit again.';
        return $state;
    }

    // Spam checks: a hidden field people never see, and a minimum time to fill in the form.
    $startedAt = (int) ($_SESSION['contact_form_at'] ?? 0);
    $elapsed = time() - $startedAt;
    if (($post['website'] ?? '') !== '' || $startedAt === 0 || $elapsed < (int) config('security.min_form_seconds', 3)) {
        app_log('notice', 'Contact form submission rejected by spam checks.');
        $state['alert'] = $retry;
        return $state;
    }

    $errors = [];
    if (mb_strlen($old['name']) < 2) {
        $errors['name'] = 'Please enter your full name.';
    } elseif (preg_match('~https?://|www\.~i', $old['name'])) {
        $errors['name'] = 'Please enter your name without a web address.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address, for example name@company.com.';
    }
    if ($old['phone'] !== '' && !preg_match('/^\+?[0-9 ()\-]{7,20}$/', $old['phone'])) {
        $errors['phone'] = 'Please enter a valid telephone number, or leave this blank.';
    }
    if (!array_key_exists($old['enquiry_type'], enquiry_types())) {
        $errors['enquiry_type'] = 'Please choose the type of enquiry.';
    }
    if (mb_strlen($old['subject']) < 3) {
        $errors['subject'] = 'Please add a short subject.';
    }
    if (mb_strlen($old['message']) < 20) {
        $errors['message'] = 'Please tell us a little more about your enquiry (at least 20 characters).';
    } elseif (preg_match_all('~https?://~i', $old['message']) > 3) {
        $errors['message'] = 'Please include no more than three web links in your message.';
    }
    if ($old['consent'] !== '1') {
        $errors['consent'] = 'Please confirm you have read the Privacy Policy and consent.';
    }
    if ($errors) {
        $state['errors'] = $errors;
        $state['alert'] = 'Please correct the highlighted fields and submit again.';
        return $state;
    }

    $type = enquiry_types()[$old['enquiry_type']];
    [$recipient, $copies] = enquiry_recipients($old['enquiry_type']);
    $body = implode("\n", [
        'New enquiry from the AMANIQ website',
        '',
        'Enquiry type: ' . $type,
        'Name: ' . $old['name'],
        'Email: ' . $old['email'],
        'Telephone: ' . ($old['phone'] !== '' ? $old['phone'] : '(not provided)'),
        'Organisation: ' . ($old['organisation'] !== '' ? $old['organisation'] : '(not provided)'),
        'Subject: ' . $old['subject'],
        '',
        'Message:',
        $old['message'],
        '',
        '---',
        'Submitted: ' . date('j F Y, H:i T'),
        'Consent given under the Privacy Policy: Yes (consent checkbox ticked)',
        'Delivered to: ' . $recipient . ($copies ? ' (copy to ' . implode(', ', $copies) . ')' : ''),
        'Reply to this email to respond directly to the sender.',
    ]);

    try {
        send_mail([
            'to' => $recipient,
            'cc' => $copies,
            'subject' => '[Website enquiry] ' . $type . ': ' . $old['subject'],
            'body' => $body,
            'reply_to' => $old['email'],
            'reply_to_name' => $old['name'],
        ]);
    } catch (MailException $e) {
        app_log('error', 'Contact form email failed: ' . $e->getMessage());
        $state['alert'] = 'Sorry, your message could not be sent just now. Please try again later, or contact us directly by email at '
            . company('email') . ' or by telephone on ' . company('phone') . '.';
        return $state;
    }

    app_log('info', 'Contact form enquiry sent.', ['type' => $old['enquiry_type']]);
    unset($_SESSION['contact_form_at'], $_SESSION['_csrf']);
    session_regenerate_id(true);
    flash('contact_sent', true);
    redirect('/contact/#enquiry', ['sent' => '1'], 303);
}
