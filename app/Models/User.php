<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends Model
{
    public static function find(int $id): ?array
    {
        $statement = self::db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $statement = self::db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function allCustomers(): array
    {
        $statement = self::db()->prepare('SELECT * FROM users WHERE role = :role ORDER BY name');
        $statement->execute(['role' => 'customer']);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function all(): array
    {
        $statement = self::db()->query('SELECT * FROM users ORDER BY created_at DESC');

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare(
            'INSERT INTO users (name, email, password, role, phone, created_at, updated_at)
             VALUES (:name, :email, :password, :role, :phone, NOW(), NOW())'
        );

        $statement->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'customer',
            'phone' => $data['phone'] ?? null,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function updateUser(int $id, array $data): bool
    {
        $fields = ['name = :name', 'email = :email', 'role = :role', 'phone = :phone'];
        $params = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'id' => $id,
        ];

        if (!empty($data['password'])) {
            $fields[] = 'password = :password';
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ', updated_at = NOW() WHERE id = :id';
        $statement = self::db()->prepare($sql);

        return $statement->execute($params);
    }
}

