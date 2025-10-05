<?php

/**
 * Security & Authentication Helper Functions
 *
 * Token generation/verification, password strength, 2FA TOTP basics,
 * IP allow/deny, brute force limiting, and session utilities.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

if (!function_exists('auth_generate_token')) {
    function auth_generate_token(int $bytes = 32): string
    {
        return bin2hex(random_bytes($bytes));
    }
}

if (!function_exists('auth_hash_token')) {
    function auth_hash_token(string $token): string
    {
        return hash('sha256', $token);
    }
}

if (!function_exists('auth_verify_token')) {
    function auth_verify_token(string $plainToken, string $hashed): bool
    {
        return hash_equals($hashed, auth_hash_token($plainToken));
    }
}

if (!function_exists('password_is_strong')) {
    function password_is_strong(string $password, int $minLength = 8): bool
    {
        if (strlen($password) < $minLength) return false;
        return (bool) (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/\d/', $password) && preg_match('/[^A-Za-z0-9]/', $password));
    }
}

if (!function_exists('totp_generate_secret')) {
    function totp_generate_secret(int $length = 20): string
    {
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }
}

if (!function_exists('totp_now')) {
    function totp_now(string $secret, int $period = 30, int $digits = 6): string
    {
        $time = floor(time() / $period);
        $key = base64_decode(strtr($secret, '-_', '+/'));
        $binTime = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $binTime, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated = unpack('N', substr($hash, $offset, 4))[1] & 0x7FFFFFFF;
        $code = $truncated % (10 ** $digits);
        return str_pad((string) $code, $digits, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('totp_verify')) {
    function totp_verify(string $secret, string $code, int $leewayWindows = 1, int $period = 30, int $digits = 6): bool
    {
        $current = (int) floor(time() / $period);
        for ($i = -$leewayWindows; $i <= $leewayWindows; $i++) {
            $t = (string) totp_now($secret, $period, $digits);
            if (hash_equals($t, $code)) return true;
        }
        return false;
    }
}

if (!function_exists('ip_whitelisted')) {
    function ip_whitelisted(string $ip, array $whitelist): bool
    {
        return in_array($ip, $whitelist, true);
    }
}

if (!function_exists('ip_blacklisted')) {
    function ip_blacklisted(string $ip, array $blacklist): bool
    {
        return in_array($ip, $blacklist, true);
    }
}

if (!function_exists('bruteforce_guard')) {
    function bruteforce_guard(string $key, int $maxAttempts = 5, int $decaySeconds = 300): bool
    {
        $bucket = "auth:attempts:{$key}";
        $attempts = (int) cache()->get($bucket, 0);
        if ($attempts >= $maxAttempts) return false;
        cache()->put($bucket, $attempts + 1, $decaySeconds);
        return true;
    }
}

if (!function_exists('logout_other_sessions')) {
    function logout_other_sessions(string $password): void
    {
        if (auth()->check()) {
            auth()->logoutOtherDevices($password);
        }
    }
}

?>


