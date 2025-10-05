### SecurityAuthHelpers

Token utilities, password checks, TOTP basics, IP lists, brute-force guard, and session hygiene.

#### Function Index

- auth_generate_token(int $bytes = 32): string
- auth_hash_token(string $token): string
- auth_verify_token(string $plainToken, string $hashed): bool
- password_is_strong(string $password, int $minLength = 8): bool
- totp_generate_secret(int $length = 20): string
- totp_now(string $secret, int $period = 30, int $digits = 6): string
- totp_verify(string $secret, string $code, int $leewayWindows = 1, int $period = 30, int $digits = 6): bool
- ip_whitelisted(string $ip, array $whitelist): bool
- ip_blacklisted(string $ip, array $blacklist): bool
- bruteforce_guard(string $key, int $maxAttempts = 5, int $decaySeconds = 300): bool
- logout_other_sessions(string $password): void


