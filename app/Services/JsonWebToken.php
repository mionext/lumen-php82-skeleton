<?php

namespace App\Services;

use Ahc\Jwt\JWT;
use Illuminate\Support\Facades\Log;

class JsonWebToken extends Service
{
    /**
     * @param array $payload
     * @param int $ttl
     * @param array $headers
     * @return string|null
     */
    public static function encode(array $payload = [], int $ttl = 0, array $headers = []): ?string
    {
        try { return self::getBuilder($ttl)->encode($payload, $headers); } catch (\Exception $e) {
            Log::warning('JsonWebToken.encode: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @param string $token
     * @param bool $verify
     * @return array|null
     */
    public static function decode(string $token, bool $verify = false): ?array
    {
        try { return self::getBuilder()->decode($token, $verify); } catch (\Exception $e) {
            Log::warning('JsonWebToken.decode: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @param int $ttl
     * @return JWT
     */
    private static function getBuilder(int $ttl = 0): JWT
    {
        return new JWT(
            config('auth.jwt.key'),
            config('auth.jwt.alg'),
            $ttl ?: config('auth.jwt.ttl'),
            config('auth.jwt.leeway')
        );
    }
}
