<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;

require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json');

$tracking = trim($_GET['tracking'] ?? '');

if ($tracking === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Tracking parameter is required.']);
    exit;
}

$shipment = Shipment::findByTracking($tracking);

if (!$shipment) {
    http_response_code(404);
    echo json_encode(['error' => 'Shipment not found.']);
    exit;
}

$events = TrackingEvent::forShipment((int) $shipment['id']);

echo json_encode([
    'shipment' => [
        'title' => $shipment['title'],
        'tracking_number' => $shipment['tracking_number'],
        'status' => $shipment['status'],
        'origin' => $shipment['origin'],
        'destination' => $shipment['destination'],
        'estimated_delivery' => $shipment['estimated_delivery'],
        'last_status_at' => $shipment['last_status_at'],
    ],
    'events' => array_map(static fn ($event) => [
        'status' => $event['status'],
        'location' => $event['location'],
        'details' => $event['details'],
        'event_time' => $event['event_time'],
    ], $events),
]);

