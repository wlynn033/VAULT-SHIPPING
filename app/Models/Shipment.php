<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Shipment extends Model
{
    public static function forUser(int $userId): array
    {
        $statement = self::db()->prepare(
            'SELECT s.*, u.name AS user_name
             FROM shipments s
             JOIN users u ON u.id = s.user_id
             WHERE s.user_id = :user_id
             ORDER BY s.last_status_at DESC, s.created_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allWithUsers(): array
    {
        $statement = self::db()->query(
            'SELECT s.*, u.name AS user_name, u.email AS user_email
             FROM shipments s
             JOIN users u ON u.id = s.user_id
             ORDER BY s.last_status_at DESC, s.created_at DESC'
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByTracking(string $tracking): ?array
    {
        $statement = self::db()->prepare('SELECT * FROM shipments WHERE tracking_number = :tracking LIMIT 1');
        $statement->execute(['tracking' => $tracking]);

        $shipment = $statement->fetch(PDO::FETCH_ASSOC);

        return $shipment ?: null;
    }

    public static function find(int $id): ?array
    {
        $statement = self::db()->prepare('SELECT * FROM shipments WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);

        $shipment = $statement->fetch(PDO::FETCH_ASSOC);

        return $shipment ?: null;
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare(
            'INSERT INTO shipments (user_id, title, tracking_number, status, origin, destination, estimated_delivery, shipped_at, delivered_at, notes, created_at, updated_at, last_status_at)
             VALUES (:user_id, :title, :tracking_number, :status, :origin, :destination, :estimated_delivery, :shipped_at, :delivered_at, :notes, NOW(), NOW(), NOW())'
        );

        $statement->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'] ?? 'Shipment',
            'tracking_number' => $data['tracking_number'],
            'status' => $data['status'] ?? 'Preparing',
            'origin' => $data['origin'] ?? null,
            'destination' => $data['destination'] ?? null,
            'estimated_delivery' => $data['estimated_delivery'] ?? null,
            'shipped_at' => $data['shipped_at'] ?? null,
            'delivered_at' => $data['delivered_at'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return (int) self::db()->lastInsertId();
    }

    public static function updateStatus(int $id, array $data): bool
    {
        $sql = 'UPDATE shipments SET status = :status, notes = :notes, delivered_at = COALESCE(:delivered_at, delivered_at), updated_at = NOW(), last_status_at = :last_status_at WHERE id = :id';
        $statement = self::db()->prepare($sql);

        return $statement->execute([
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
            'delivered_at' => $data['delivered_at'] ?? null,
            'last_status_at' => $data['last_status_at'] ?? date('Y-m-d H:i:s'),
            'id' => $id,
        ]);
    }
}

