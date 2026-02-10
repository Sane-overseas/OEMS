<?php

namespace App\Support;

use App\Models\SecurityLog;
use Throwable;

class SecurityLogger
{
    public static function log(
        string $guard,
        ?int $userId,
        string $event,
        ?string $description = null,
        array $payload = []
    ): void {
        try {

            SecurityLog::create([
                'guard' => $guard,
                'user_id' => $userId,
                'event' => $event,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'description' => $description,
                'payload' => empty($payload) ? null : $payload,
            ]);

        } catch (Throwable $e) {

            // never break auth flow because of logging
            logger()->error('SecurityLogger failed: ' . $e->getMessage());
        }
    }
}
