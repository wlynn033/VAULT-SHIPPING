<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Secure Storage & Shipping Portal';

include BASE_PATH . '/app/Views/includes/header.php';

$features = [
    [
        'title' => 'Personal Vault Access',
        'description' => 'Give your customers a beautiful dashboard to view every item secured in storage, including status, quantity, and history.'
    ],
    [
        'title' => 'Real-Time Shipment Tracking',
        'description' => 'Update shipment progress from the admin control center and let users follow every milestone from dispatch to delivery.'
    ],
    [
        'title' => 'Operations Command Center',
        'description' => 'Manage customers, vault inventory, and outbound deliveries with a modern admin experience designed for productivity.'
    ],
];
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="badge">Vault & Logistics Suite</span>
            <h1>Storage visibility and shipment tracking in one polished portal.</h1>
            <p>Deliver concierge-level transparency. Customers can review their vaulted assets, follow outgoing deliveries, and stay confident that every move is handled securely.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= base_url('login.php') ?>">Customer Login</a>
                <a class="btn btn-ghost" href="<?= base_url('tracking.php') ?>">Track a Shipment</a>
            </div>
            <ul class="hero-stats">
                <li><strong>Unlimited</strong><span>Storage categories</span></li>
                <li><strong>Live</strong><span>Status updates</span></li>
                <li><strong>Multi-user</strong><span>Admin control</span></li>
            </ul>
        </div>
        <div class="hero-visual">
            <div class="dashboard-preview">
                <div class="preview-header">
                    <span class="dot dot-red"></span>
                    <span class="dot dot-amber"></span>
                    <span class="dot dot-green"></span>
                </div>
                <div class="preview-body">
                    <p class="preview-title">Vault Snapshot</p>
                    <ul class="preview-list">
                        <li>
                            <span class="preview-label">Climate Vault</span>
                            <span class="preview-value">12 items stored</span>
                        </li>
                        <li>
                            <span class="preview-label">Outgoing Today</span>
                            <span class="preview-value status-info">3 shipments</span>
                        </li>
                        <li>
                            <span class="preview-label">Alerts</span>
                            <span class="preview-value status-success">All clear</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section features">
    <div class="container">
        <h2 class="section-title">Everything admins need to delight customers</h2>
        <div class="feature-grid">
            <?php foreach ($features as $feature): ?>
                <article class="feature-card">
                    <h3><?= htmlspecialchars($feature['title']) ?></h3>
                    <p><?= htmlspecialchars($feature['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section emphasis">
    <div class="container emphasis-grid">
        <div>
            <h2>Update once, sync everywhere.</h2>
            <p>From the admin dashboard you can add items to a customer vault, create outbound shipments, and push tracking checkpoints. Customers see updates instantly on desktop or mobile.</p>
        </div>
        <div class="emphasis-card">
            <p class="emphasis-title">Live Tracking Feed</p>
            <ul>
                <li>
                    <span class="badge badge-success">Delivered</span>
                    <div>
                        <strong>Luxury Watch Transfer</strong>
                        <p>Signed by client ? 15:24</p>
                    </div>
                </li>
                <li>
                    <span class="badge badge-info">In Transit</span>
                    <div>
                        <strong>Wine Collection</strong>
                        <p>Departed hub ? 11:05</p>
                    </div>
                </li>
                <li>
                    <span class="badge badge-warning">Preparing</span>
                    <div>
                        <strong>Document Pouch</strong>
                        <p>Packaging completed ? 09:12</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="section cta">
    <div class="container cta-inner">
        <h2>Ready to give clients premium visibility?</h2>
        <p>Deploy the Vault & Shipping Suite on your cPanel hosting and start inviting customers today.</p>
        <div class="cta-actions">
            <a class="btn btn-primary" href="<?= base_url('admin/index.php') ?>">Admin Console</a>
            <a class="btn btn-ghost" href="<?= base_url('docs/setup.html') ?>">View Setup Guide</a>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
