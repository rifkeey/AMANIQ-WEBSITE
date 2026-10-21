<?php
declare(strict_types=1);

/**
 * File-based sliding-window rate limiter that works on shared hosting.
 * Records an attempt and returns false once $max attempts fall inside $window seconds.
 * IP addresses are stored only as salted hashes.
 */
function rate_limit_attempt(string $bucket, string $identity, int $max, int $window): bool
{
    $dir = STORAGE_ROOT . '/ratelimit';
    if (!is_dir($dir) && !@mkdir($dir, 0700, true)) {
        app_log('warning', 'Rate-limit storage unavailable; allowing request.');
        return true;
    }

    $key = hash_hmac('sha256', $bucket . '|' . $identity, (string) config('security.app_key', 'amaniq'));
    $file = $dir . '/' . $key . '.json';
    $now = time();

    $handle = @fopen($file, 'c+');
    if ($handle === false) {
        return true;
    }
    try {
        flock($handle, LOCK_EX);
        $hits = json_decode((string) stream_get_contents($handle), true);
        $hits = array_values(array_filter(is_array($hits) ? $hits : [], static fn ($t) => is_int($t) && $t > $now - $window));
        $allowed = count($hits) < $max;
        $hits[] = $now;
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, json_encode($hits));
        fflush($handle);
        flock($handle, LOCK_UN);
    } finally {
        fclose($handle);
    }

    // Occasionally clear out records older than a day.
    if (random_int(1, 50) === 1) {
        foreach (glob($dir . '/*.json') ?: [] as $old) {
            if (filemtime($old) < $now - 86400) {
                @unlink($old);
            }
        }
    }
    return $allowed;
}
