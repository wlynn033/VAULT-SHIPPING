<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\User;

final class Auth
{
    private const SESSION_KEY = 'auth_user_id';

    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION[self::SESSION_KEY] = $user['id'];

        return true;
    }

    public static function user(): ?array
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            return null;
        }

        return User::find((int) $_SESSION[self::SESSION_KEY]);
    }

    public static function id(): ?int
    {
        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
        session_regenerate_id(true);
    }

    public static function checkRole(string $role): bool
    {
        $user = self::user();

        return $user ? $user['role'] === $role : false;
    }

    public static function requireRole(string $role): void
    {
        if (!self::checkRole($role)) {
            redirect('login.php');
        }
    }

    public static function requireAuth(): void
    {
        if (!self::user()) {
            redirect('login.php');
        }
    }
}

