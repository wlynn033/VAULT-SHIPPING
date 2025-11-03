<?php

declare(strict_types=1);

namespace App\Support;

final class Env
{
    public static function load(string $path): void
    {
        if (!is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            return;
        }

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$name, $value] = array_map('trim', explode('=', $line, 2));
            if ($name === '') {
                continue;
            }

            $value = self::stripQuotes($value);

            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;

            if (!getenv($name)) {
                putenv("{$name}={$value}");
            }
        }
    }

    private static function stripQuotes(string $value): string
    {
        return trim($value, "'\"");
    }
}

