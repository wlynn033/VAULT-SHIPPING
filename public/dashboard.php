<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Models\VaultItem;
use App\Support\Auth;

require_once __DIR__ . '/../app/bootstrap.php';

Auth::requireAuth();

$user = Auth::user();
if ($user['role'] === 'admin') {
    redirect('admin/index.php');
}

$pageTitle = 'My Vault & Shipments';

$vaultItems = VaultItem::forUser((int) $user['id']);
$shipments = Shipment::forUser((int) $user['id']);

$shipmentsWithEvents = array_map(function ($shipment) {
    $shipment['events'] = TrackingEvent::forShipment((int) $shipment['id']);
    return $shipment;
}, $shipments);

$storedCount = count($vaultItems);
$activeShipments = array_filter($shipmentsWithEvents, fn ($shipment) => strtolower($shipment['status']) !== 'delivered');
$recentEvents = [];

foreach ($shipmentsWithEvents as $shipment) {
    foreach ($shipment['events'] as $event) {
        $event['shipment_title'] = $shipment['title'];
        $recentEvents[] = $event;
    }
}

usort($recentEvents, fn ($a, $b) => strcmp($b['event_time'], $a['event_time']));
$recentEvents = array_slice($recentEvents, 0, 6);

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="dashboard">
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1>Hello, <?= htmlspecialchars($user['name']) ?></h1>
                <p>Here's the latest on your vaulted items and shipments.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-ghost" href="<?= base_url('tracking.php') ?>">Track another shipment</a>
            </div>
        </div>

        <div class="dashboard-stats">
            <article class="stat-card">
                <p class="stat-label">Items in Vault</p>
                <p class="stat-value"><?= $storedCount ?></p>
            </article>
            <article class="stat-card">
                <p class="stat-label">Active Shipments</p>
                <p class="stat-value"><?= count($activeShipments) ?></p>
            </article>
            <article class="stat-card">
                <p class="stat-label">Latest Update</p>
                <p class="stat-value"><?= $recentEvents ? date('M j, H:i', strtotime($recentEvents[0]['event_time'])) : '&mdash;' ?></p>
            </article>
        </div>

        <div class="dashboard-grid">
            <section class="panel">
                <div class="panel-header">
                    <h2>Vault Inventory</h2>
                    <p><?= $storedCount ?> items stored securely</p>
                </div>
                <?php if ($vaultItems): ?>
                    <div class="table-scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Added</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($vaultItems as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($item['item_name']) ?></strong>
                                        <?php if ($item['description']): ?>
                                            <p class="muted"><?= htmlspecialchars($item['description']) ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= (int) $item['quantity'] ?></td>
                                    <td><span class="badge badge-status"><?= htmlspecialchars($item['status']) ?></span></td>
                                    <td><?= $item['storage_location'] ? htmlspecialchars($item['storage_location']) : '&mdash;' ?></td>
                                    <td><?= date('M j, Y', strtotime($item['added_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No items in storage yet. Your concierge team will add them soon.</p>
                <?php endif; ?>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Shipments</h2>
                    <p>Track every outbound delivery.</p>
                </div>

                <?php if ($shipmentsWithEvents): ?>
                    <?php foreach ($shipmentsWithEvents as $shipment): ?>
                        <article class="shipment-card" data-tracking="<?= htmlspecialchars($shipment['tracking_number']) ?>">
                            <div class="shipment-header">
                                <div>
                                    <h3><?= htmlspecialchars($shipment['title']) ?></h3>
                                    <p class="muted">Tracking #<?= htmlspecialchars($shipment['tracking_number']) ?></p>
                                </div>
                                <span class="badge badge-info"><?= htmlspecialchars($shipment['status']) ?></span>
                            </div>
                            <ul class="shipment-meta">
                                <li><strong>Origin:</strong> <?= $shipment['origin'] ? htmlspecialchars($shipment['origin']) : '&mdash;' ?></li>
                                <li><strong>Destination:</strong> <?= $shipment['destination'] ? htmlspecialchars($shipment['destination']) : '&mdash;' ?></li>
                                <li><strong>Est. Delivery:</strong> <?= $shipment['estimated_delivery'] ? date('M j, Y', strtotime($shipment['estimated_delivery'])) : 'TBD' ?></li>
                            </ul>
                            <div class="timeline">
                                <?php if ($shipment['events']): ?>
                                    <?php foreach ($shipment['events'] as $event): ?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <p class="timeline-time"><?= date('M j, H:i', strtotime($event['event_time'])) ?></p>
                                                <h4><?= htmlspecialchars($event['status']) ?></h4>
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
                                    <p>No tracking events yet. We'll update you soon.</p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No shipments in progress.</p>
                <?php endif; ?>
            </section>
        </div>

        <section class="panel">
            <div class="panel-header">
                <h2>Recent activity</h2>
                <p>Live feed of your latest tracking milestones.</p>
            </div>
            <?php if ($recentEvents): ?>
                <ul class="activity-list" id="activity-feed">
                    <?php foreach ($recentEvents as $event): ?>
                        <li>
                            <div>
                                <p class="muted"><?= date('M j, H:i', strtotime($event['event_time'])) ?></p>
                                <strong><?= htmlspecialchars($event['status']) ?></strong>
                                <p><?= htmlspecialchars($event['shipment_title']) ?></p>
                                <?php if ($event['location']): ?>
                                    <span class="muted"><?= htmlspecialchars($event['location']) ?></span>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tracking activity yet.</p>
            <?php endif; ?>
        </section>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
