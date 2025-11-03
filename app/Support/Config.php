<?php

declare(strict_types=1);

namespace App\Support;

final class Config
{
    private static array $cache = [];

    public static function get(string $key, mixed $default = null): mixed
    {
        [$filename, $configKey] = self::splitKey($key);

        if (!isset(self::$cache[$filename])) {
            $path = BASE_PATH . '/config/' . $filename . '.php';
            self::$cache[$filename] = file_exists($path) ? require $path : [];
        }

        $value = self::$cache[$filename];

        if ($configKey === '') {
            return $value;
        }

        foreach (explode('.', $configKey) as $segment) {
            if ($segment === '') {
                continue;
            }

            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    private static function splitKey(string $key): array
    {
        if (!str_contains($key, '.')) {
            return [$key, ''];
        }

        $parts = explode('.', $key, 2);

        return [$parts[0], $parts[1]];
    }
}

