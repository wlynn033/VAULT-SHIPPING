<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Support\Auth;

require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json');

$user = Auth::user();

if (!$user) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($user['role'] === 'admin') {
    $shipments = Shipment::allWithUsers();
} else {
    $shipments = Shipment::forUser((int) $user['id']);
}

$response = [];

foreach ($shipments as $shipment) {
    $events = TrackingEvent::forShipment((int) $shipment['id']);

    $response[] = [
        'id' => $shipment['id'],
        'title' => $shipment['title'],
        'tracking_number' => $shipment['tracking_number'],
        'status' => $shipment['status'],
        'destination' => $shipment['destination'] ?? null,
        'last_status_at' => $shipment['last_status_at'],
        'events' => array_map(static fn ($event) => [
            'status' => $event['status'],
            'location' => $event['location'],
            'details' => $event['details'],
            'event_time' => $event['event_time'],
        ], $events),
    ];
}

echo json_encode([
    'shipments' => $response,
]);

