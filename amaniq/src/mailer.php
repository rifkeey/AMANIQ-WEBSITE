<?php
declare(strict_types=1);

final class MailException extends RuntimeException
{
}

/**
 * Sends a plain-text email using the transport set in config('mail.transport'):
 *   smtp — authenticated SMTP (recommended; works with cPanel mailboxes and providers)
 *   mail — PHP's mail() function, if the host allows it
 *   log  — development only: writes the message to storage/mail-outbox instead of sending
 *
 * Throws MailException when the message was not accepted, so callers never report
 * success for an email that was not sent.
 *
 * @param array{to:string|list<string>, cc?:list<string>, subject:string, body:string, reply_to?:string, reply_to_name?:string} $message
 */
function send_mail(array $message): void
{
    $from = (string) config('mail.from_email');
    $to = array_values(array_unique(array_map('strtolower', (array) $message['to'])));
    $cc = array_values(array_diff(array_unique(array_map('strtolower', (array) ($message['cc'] ?? []))), $to));
    if (!filter_var($from, FILTER_VALIDATE_EMAIL) || $to === []) {
        throw new MailException('Mail sender or recipient is not a valid address.');
    }
    foreach (array_merge($to, $cc) as $address) {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new MailException('Mail recipient is not a valid address.');
        }
    }
    $replyTo = $message['reply_to'] ?? null;
    if ($replyTo !== null && !filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $replyTo = null;
    }

    $headers = [
        'Date' => date(DATE_RFC2822),
        'From' => mail_address($from, (string) config('mail.from_name', 'AMANIQ Website')),
        'To' => implode(', ', $to),
        'Subject' => mail_header_text($message['subject']),
        'Message-ID' => '<' . bin2hex(random_bytes(12)) . '@' . (substr(strrchr($from, '@'), 1) ?: 'amaniqgroup.com') . '>',
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Content-Transfer-Encoding' => 'base64',
        'X-Mailer' => 'AMANIQ Website',
    ];
    if ($cc !== []) {
        $headers['Cc'] = implode(', ', $cc);
    }
    if ($replyTo !== null) {
        $headers['Reply-To'] = mail_address($replyTo, (string) ($message['reply_to_name'] ?? ''));
    }
    $body = rtrim(chunk_split(base64_encode(str_replace(["\r\n", "\r"], "\n", $message['body'])), 76, "\r\n"));

    $transport = (string) config('mail.transport', 'smtp');
    match ($transport) {
        'smtp' => smtp_send($from, array_merge($to, $cc), $headers, $body),
        'mail' => php_mail_send($from, implode(', ', $to), $headers, $body),
        'log' => log_mail_send($headers, $message['body']),
        default => throw new MailException('Unknown mail transport.'),
    };
}

/** Removes characters that could inject extra headers. */
function mail_clean(string $value): string
{
    return trim(preg_replace('/[\r\n\t\0]+/', ' ', $value) ?? '');
}

function mail_header_text(string $value): string
{
    $value = mail_clean($value);
    return preg_match('/[^\x20-\x7E]/', $value) ? mb_encode_mimeheader($value, 'UTF-8', 'B', "\r\n") : $value;
}

function mail_address(string $email, string $name = ''): string
{
    $name = mail_clean($name);
    if ($name === '') {
        return $email;
    }
    $encoded = preg_match('/[^\x20-\x7E]/', $name)
        ? mb_encode_mimeheader($name, 'UTF-8', 'B', "\r\n")
        : '"' . addcslashes($name, '"\\') . '"';
    return $encoded . ' <' . $email . '>';
}

function format_headers(array $headers): string
{
    $lines = [];
    foreach ($headers as $name => $value) {
        $lines[] = $name . ': ' . $value;
    }
    return implode("\r\n", $lines);
}

function smtp_send(string $from, array $recipients, array $headers, string $body): void
{
    $host = (string) config('mail.host', '');
    $port = (int) config('mail.port', 587);
    $encryption = (string) config('mail.encryption', 'tls');
    $timeout = (int) config('mail.timeout', 15);
    if ($host === '') {
        throw new MailException('SMTP host is not configured.');
    }

    $context = stream_context_create(['ssl' => [
        'verify_peer' => (bool) config('mail.verify_peer', true),
        'verify_peer_name' => (bool) config('mail.verify_peer', true),
        'peer_name' => $host,
    ]]);
    $remote = ($encryption === 'ssl' ? 'ssl://' : 'tcp://') . $host . ':' . $port;
    $socket = @stream_socket_client($remote, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);
    if ($socket === false) {
        throw new MailException("SMTP connection failed ($errno): $errstr");
    }
    stream_set_timeout($socket, $timeout);

    try {
        smtp_expect($socket, [220]);
        $helo = parse_url((string) config('base_url'), PHP_URL_HOST) ?: 'localhost';
        smtp_command($socket, 'EHLO ' . $helo, [250]);

        if ($encryption === 'tls') {
            smtp_command($socket, 'STARTTLS', [220]);
            $crypto = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT') ? STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT : 0);
            if (!@stream_socket_enable_crypto($socket, true, $crypto)) {
                throw new MailException('SMTP STARTTLS negotiation failed.');
            }
            smtp_command($socket, 'EHLO ' . $helo, [250]);
        }

        $username = (string) config('mail.username', '');
        if ($username !== '') {
            smtp_command($socket, 'AUTH LOGIN', [334]);
            smtp_command($socket, base64_encode($username), [334]);
            smtp_command($socket, base64_encode((string) config('mail.password', '')), [235], true);
        }

        smtp_command($socket, 'MAIL FROM:<' . $from . '>', [250]);
        foreach ($recipients as $recipient) {
            smtp_command($socket, 'RCPT TO:<' . $recipient . '>', [250, 251]);
        }
        smtp_command($socket, 'DATA', [354]);
        // Dot-stuff any line beginning with "." as required by RFC 5321.
        $data = preg_replace('/^\./m', '..', format_headers($headers) . "\r\n\r\n" . $body);
        smtp_command($socket, $data . "\r\n.", [250]);
        @fwrite($socket, "QUIT\r\n");
    } finally {
        fclose($socket);
    }
}

/** @return string the server's full reply */
function smtp_command($socket, string $command, array $expect, bool $secret = false): string
{
    if (@fwrite($socket, $command . "\r\n") === false) {
        throw new MailException('SMTP write failed' . ($secret ? '' : ' for ' . strtok($command, ' ')));
    }
    return smtp_expect($socket, $expect, $secret ? 'AUTH' : strtok($command, ' :'));
}

function smtp_expect($socket, array $codes, string $step = 'greeting'): string
{
    $reply = '';
    while (($line = fgets($socket, 1024)) !== false) {
        $reply .= $line;
        if (strlen($line) < 4 || $line[3] === ' ') {
            break;
        }
    }
    $code = (int) substr($reply, 0, 3);
    if (!in_array($code, $codes, true)) {
        $meta = stream_get_meta_data($socket);
        $reason = $meta['timed_out'] ? 'timed out' : 'replied ' . trim(substr($reply, 0, 120));
        throw new MailException("SMTP {$step} failed: server {$reason}");
    }
    return $reply;
}

function php_mail_send(string $from, string $to, array $headers, string $body): void
{
    $subject = $headers['Subject'];
    unset($headers['To'], $headers['Subject']);
    if (!@mail($to, $subject, $body, format_headers($headers), '-f' . $from)) {
        throw new MailException('PHP mail() reported failure.');
    }
}

function log_mail_send(array $headers, string $plainBody): void
{
    if (is_production()) {
        throw new MailException('The "log" mail transport is disabled in production.');
    }
    $dir = STORAGE_ROOT . '/mail-outbox';
    if (!is_dir($dir) && !@mkdir($dir, 0700, true)) {
        throw new MailException('Mail outbox folder is not writable.');
    }
    $file = $dir . '/' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)) . '.eml.txt';
    if (@file_put_contents($file, format_headers($headers) . "\r\n\r\n" . $plainBody) === false) {
        throw new MailException('Could not write development mail file.');
    }
}
