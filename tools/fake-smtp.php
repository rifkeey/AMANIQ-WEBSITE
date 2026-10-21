<?php
/*
 * Minimal fake SMTP server for local testing of the SMTP transport only.
 * Accepts plain (unencrypted) connections, any AUTH LOGIN credentials except
 * the password "reject", and writes each message to the given folder.
 *
 *   php tools/fake-smtp.php 2525 /path/to/outbox [connections]
 *
 * Never expose this on a network.
 */
[$_, $port, $outbox] = $argv + [null, '2525', sys_get_temp_dir()];
$limit = (int) ($argv[3] ?? 1);
$server = stream_socket_server("tcp://127.0.0.1:$port", $errno, $errstr);
if (!$server) {
    fwrite(STDERR, "Cannot listen: $errstr\n");
    exit(1);
}
echo "Fake SMTP listening on 127.0.0.1:$port\n";

for ($n = 0; $n < $limit; $n++) {
    $c = stream_socket_accept($server, 60);
    if (!$c) {
        break;
    }
    $say = static fn (string $line) => fwrite($c, $line . "\r\n");
    $say('220 fake-smtp ready');
    $state = '';
    $data = '';
    $rcpt = [];
    while (($line = fgets($c)) !== false) {
        $cmd = rtrim($line, "\r\n");
        if ($state === 'data') {
            if ($cmd === '.') {
                // X-Envelope-To records the SMTP recipients, which include Cc addresses.
                file_put_contents(rtrim($outbox, '/\\') . '/smtp-' . date('His') . '-' . $n . '.eml', 'X-Envelope-To: ' . implode(', ', $rcpt ?? []) . "\r\n" . $data);
                $say('250 2.0.0 queued');
                $state = '';
                continue;
            }
            $data .= $cmd . "\r\n";
            continue;
        }
        if ($state === 'user') { $say('334 UGFzc3dvcmQ6'); $state = 'pass'; continue; }
        if ($state === 'pass') {
            $state = '';
            base64_decode($cmd) === 'reject' ? $say('535 5.7.8 authentication failed') : $say('235 2.7.0 authenticated');
            continue;
        }
        $verb = strtoupper(strtok($cmd, ' :'));
        match ($verb) {
            'EHLO', 'HELO' => $say("250-fake-smtp\r\n250 AUTH LOGIN"),
            'AUTH' => [$say('334 VXNlcm5hbWU6'), $state = 'user'],
            'MAIL' => [$say('250 2.1.0 ok'), $rcpt = []],
            'RCPT' => [$say('250 2.1.5 ok'), $rcpt[] = trim(substr($cmd, 8), ' <>')],
            'DATA' => [$say('354 end with .'), $state = 'data'],
            'QUIT' => $say('221 bye'),
            default => $say('502 not implemented'),
        };
        if ($verb === 'QUIT') {
            break;
        }
    }
    fclose($c);
}
