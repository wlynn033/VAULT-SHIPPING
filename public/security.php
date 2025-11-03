<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Security & Compliance';

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="page-hero">
    <div class="container page-hero-grid">
        <div>
            <span class="eyebrow">Security Architecture</span>
            <h1>Redundant defenses designed for irreplaceable wealth.</h1>
            <p>Protecting gold, diamonds, and other ultra high-value assets demands rigor. Our physical, digital, and human security layers converge to eliminate single points of failure and to provide transparent proof of custody for every client.</p>
            <div class="stat-band">
                <div class="stat">
                    <strong>ISO 27001</strong>
                    <span class="muted">Information security certified</span>
                </div>
                <div class="stat">
                    <strong>Tier IV</strong>
                    <span class="muted">Data center resilience standards</span>
                </div>
                <div class="stat">
                    <strong>99.99%</strong>
                    <span class="muted">System uptime SLA</span>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <h2>Three layers of assurance</h2>
            <ul class="list-check">
                <li>Physical fortification: ballistic materials, seismic isolation, and armed response.</li>
                <li>Digital safeguards: encrypted infrastructure, hardware security modules, and segmented networks.</li>
                <li>Operational integrity: vetted personnel, dual-control policies, and continuous training.</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div>
            <h2>Physical security blueprint</h2>
            <p>Our vaults sit behind concentric rings of protection that evolve with the threat landscape. Regular penetration testing and red-team exercises ensure we stay ahead of attackers.</p>
            <ul class="list-check">
                <li>Perimeter: anti-ram barriers, vehicle traps, and biometric guard posts.</li>
                <li>Interior: man-traps, x-ray scanning, and weapon-detecting millimeter-wave portals.</li>
                <li>Vault: Faraday shielding, anti-cut alloys, and on-site quick response teams.</li>
            </ul>
        </div>
        <div class="card-panel">
            <h3>Environmental controls</h3>
            <p>Climate, humidity, and air quality are tuned to asset requirements. Back-up power and redundant HVAC maintain stability even in regional outages.</p>
            <div class="stat-grid">
                <div class="stat-card-simple">
                    <strong>6x</strong>
                    <span class="muted">Redundant HVAC systems</span>
                </div>
                <div class="stat-card-simple">
                    <strong>24</strong>
                    <span class="muted">Hour generator autonomy</span>
                </div>
                <div class="stat-card-simple">
                    <strong>?1%</strong>
                    <span class="muted">Humidity variance</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div class="card-panel">
            <h2>Information security & compliance</h2>
            <p>Your data and instructions deserve the same protections as your physical assets. Our systems are built on zero-trust principles and audited by independent specialists.</p>
            <ul class="list-check">
                <li>Multi-factor authentication for every login and administrative action.</li>
                <li>Data encrypted in transit and at rest using TLS 1.3 and AES-256 standards.</li>
                <li>Segregated networks for vault operations, logistics, and customer portal access.</li>
                <li>Quarterly SOC 2 Type II attestation and GDPR-compliant data governance.</li>
            </ul>
        </div>
        <div class="card-panel">
            <h2>People & procedures</h2>
            <p>Every Aurum specialist is thoroughly vetted, bonded, and trained on strict confidential handling policies.</p>
            <ul class="list-check">
                <li>Background investigations conducted annually with continuous monitoring.</li>
                <li>Dual control for vault access, inventory adjustments, and shipment releases.</li>
                <li>Scenario-driven drills ranging from natural disasters to cyber incidents.</li>
                <li>Incident response teams on call 24/7 with escalation playbooks.</li>
            </ul>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
