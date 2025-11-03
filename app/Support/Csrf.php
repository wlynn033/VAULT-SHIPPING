<?php

declare(strict_types=1);

namespace App\Support;

final class Csrf
{
    private const KEY = '_csrf_token';

    public static function token(): string
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::KEY];
    }

    public static function verify(?string $token): bool
    {
        if (!$token || !isset($_SESSION[self::KEY])) {
            return false;
        }

        return hash_equals($_SESSION[self::KEY], $token);
    }
}

