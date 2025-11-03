<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/app/helpers.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Support\Env;

$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    Env::load($envFile);
}

date_default_timezone_set(config('app.timezone', 'UTC'));

if (session_status() === PHP_SESSION_NONE) {
    $lifetimeMinutes = (int) ($_ENV['SESSION_LIFETIME'] ?? 120);
    $cookieOptions = [
        'lifetime' => max(0, $lifetimeMinutes * 60),
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ];

    session_set_cookie_params($cookieOptions);
    session_start();
}

