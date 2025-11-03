<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Track Shipment';
$trackingNumber = trim($_GET['tracking'] ?? '');
$shipment = null;
$events = [];
$error = null;

if ($trackingNumber !== '') {
    $shipment = Shipment::findByTracking($trackingNumber);
    if ($shipment) {
        $events = TrackingEvent::forShipment((int) $shipment['id']);
    } else {
        $error = 'We could not find a shipment with that tracking number.';
    }
}

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="tracking">
    <div class="container tracking-container">
        <div class="tracking-search">
            <h1>Track your shipment</h1>
            <p>Enter your tracking number to view the latest status and milestones.</p>
            <form method="GET" class="tracking-form">
                <input type="text" name="tracking" value="<?= htmlspecialchars($trackingNumber) ?>" placeholder="Tracking number" required>
                <button class="btn btn-primary" type="submit">Check status</button>
            </form>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <p class="muted">Provided by <?= htmlspecialchars(config('app.name', 'Vault & Shipping Suite')) ?>.</p>
        </div>

        <?php if ($shipment): ?>
            <div class="tracking-details" data-tracking="<?= htmlspecialchars($shipment['tracking_number']) ?>">
                <header class="tracking-header">
                    <div>
                        <span class="badge badge-info">Current status</span>
                        <h2><?= htmlspecialchars($shipment['status']) ?></h2>
                    </div>
                    <div>
                        <p><strong>Tracking #</strong> <?= htmlspecialchars($shipment['tracking_number']) ?></p>
                        <p><strong>Destination</strong> <?= $shipment['destination'] ? htmlspecialchars($shipment['destination']) : '&mdash;' ?></p>
                    </div>
                </header>

                <div class="tracking-meta">
                    <article>
                        <p class="muted">Origin</p>
                        <p><?= $shipment['origin'] ? htmlspecialchars($shipment['origin']) : '&mdash;' ?></p>
                    </article>
                    <article>
                        <p class="muted">Estimated delivery</p>
                        <p><?= $shipment['estimated_delivery'] ? date('M j, Y', strtotime($shipment['estimated_delivery'])) : 'TBD' ?></p>
                    </article>
                    <article>
                        <p class="muted">Last updated</p>
                        <p><?= date('M j, H:i', strtotime($shipment['last_status_at'])) ?></p>
                    </article>
                </div>

                <div class="timeline">
                    <?php if ($events): ?>
                        <?php foreach ($events as $event): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="timeline-time"><?= date('M j, H:i', strtotime($event['event_time'])) ?></p>
                                    <h3><?= htmlspecialchars($event['status']) ?></h3>
                                    <?php if ($event['location']): ?>
                                        <p class="muted">Location: <?= htmlspecialchars($event['location']) ?></p>
                                    <?php endif; ?>
                                    <?php if ($event['details']): ?>
                                        <p><?= htmlspecialchars($event['details']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tracking events available yet. Please check back soon.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
