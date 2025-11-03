<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class TrackingEvent extends Model
{
    public static function forShipment(int $shipmentId): array
    {
        $statement = self::db()->prepare(
            'SELECT * FROM tracking_events WHERE shipment_id = :shipment_id ORDER BY event_time DESC'
        );
        $statement->execute(['shipment_id' => $shipmentId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int
    {
        $statement = self::db()->prepare(
            'INSERT INTO tracking_events (shipment_id, status, location, details, event_time, created_at)
             VALUES (:shipment_id, :status, :location, :details, :event_time, NOW())'
        );

        $statement->execute([
            'shipment_id' => $data['shipment_id'],
            'status' => $data['status'],
            'location' => $data['location'] ?? null,
            'details' => $data['details'] ?? null,
            'event_time' => $data['event_time'] ?? date('Y-m-d H:i:s'),
        ]);

        Shipment::updateStatus($data['shipment_id'], [
            'status' => $data['status'],
            'notes' => $data['details'] ?? null,
            'delivered_at' => str_contains(strtolower($data['status']), 'delivered')
                ? ($data['event_time'] ?? date('Y-m-d H:i:s'))
                : null,
            'last_status_at' => $data['event_time'] ?? date('Y-m-d H:i:s'),
        ]);

        return (int) self::db()->lastInsertId();
    }
}

