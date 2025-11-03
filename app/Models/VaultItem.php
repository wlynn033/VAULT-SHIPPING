<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class VaultItem extends Model
{
    public static function forUser(int $userId): array
    {
        $statement = self::db()->prepare(
            'SELECT vi.*, u.name AS user_name
             FROM vault_items vi
             JOIN users u ON u.id = vi.user_id
             WHERE vi.user_id = :user_id
             ORDER BY vi.added_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allWithUsers(): array
    {
        $statement = self::db()->query(
            'SELECT vi.*, u.name AS user_name, u.email AS user_email
             FROM vault_items vi
             JOIN users u ON u.id = vi.user_id
             ORDER BY vi.added_at DESC'
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare(
            'INSERT INTO vault_items (user_id, item_name, description, quantity, storage_location, status, added_at)
             VALUES (:user_id, :item_name, :description, :quantity, :storage_location, :status, :added_at)'
        );

        $statement->execute([
            'user_id' => $data['user_id'],
            'item_name' => $data['item_name'],
            'description' => $data['description'] ?? null,
            'quantity' => $data['quantity'] ?? 1,
            'storage_location' => $data['storage_location'] ?? null,
            'status' => $data['status'] ?? 'stored',
            'added_at' => $data['added_at'] ?? date('Y-m-d H:i:s'),
        ]);

        return (int) self::db()->lastInsertId();
    }
}

