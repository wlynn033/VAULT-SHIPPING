<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Vault Storage Services';

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="page-hero">
    <div class="container page-hero-grid">
        <div>
            <span class="eyebrow">Private Vaulting</span>
            <h1>Preserve gold, diamonds, and heritage collections without compromise.</h1>
            <p>Our multi-layer vault system is engineered for irreplaceable valuables ? bullion reserves, loose stones, couture jewelry, rare watches, fine art, vintage wine, and sensitive archives. Every chamber is climate-controlled, monitored in real time, and accessible only with dual biometric authorization.</p>
            <div class="stat-band">
                <div class="stat">
                    <strong>6</strong>
                    <span class="muted">Global vault locations</span>
                </div>
                <div class="stat">
                    <strong>-20?C</strong>
                    <span class="muted">Cryogenic capacity</span>
                </div>
                <div class="stat">
                    <strong>0.1%</strong>
                    <span class="muted">Variance in humidity tolerance</span>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <h2>Asset classes we safeguard</h2>
            <ul class="list-check">
                <li>Investment-grade gold, platinum, and palladium bars with independent assay.</li>
                <li>Loose diamonds, gemstones, and bespoke jewelry with individualized containers.</li>
                <li>Rare timepieces, couture accessories, and heritage fashion collections.</li>
                <li>Fine art, archival documents, and specialty collections requiring controlled environments.</li>
            </ul>
        </div>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div>
            <h2>Engineered for absolute custody</h2>
            <p>Layered defenses deter, detect, and defeat threats long before they reach client assets. We combine bank-level vault construction with air-gapped monitoring and on-site response teams trained for high-value protection.</p>
            <ul class="list-check">
                <li>UL 608 certification, seismic isolation, and ballistic-rated access doors.</li>
                <li>Biometric plus encrypted token entry with four-eyes authentication enforced.</li>
                <li>Video, vibration, and thermal analytics monitored across redundant GSOCs.</li>
                <li>Continuous private insurance coverage per client, not pooled, with auditable inventory.</li>
            </ul>
        </div>
        <div class="card-panel">
            <h3>Concierge access portal</h3>
            <p>Clients and appointed advisors can schedule viewings, request high-resolution imaging, or authorize releases through the secured web portal. Every action requires digital signatures and is notarized in the audit log.</p>
            <div class="highlight-bar">
                <h3>When you need to inspect holdings</h3>
                <ul class="list-check">
                    <li>Virtual inspections with 4K livestream and dual-camera verification.</li>
                    <li>Private viewing salons with armed escort between vault and salon.</li>
                    <li>White-labeled reporting for wealth managers and family offices.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Intake to release: a proven workflow</h2>
        <p class="section-subtitle">Every piece is catalogued, verified, and sealed under camera before it enters storage. When you need it returned, the release mirrors intake ? precise, documented, and insured door to door.</p>
        <div class="icon-grid">
            <article class="icon-card">
                <h3>1. Secure arrival</h3>
                <p>Dedicated armored transport or hand-carry experts deliver assets into our secure receiving center with continuous video capture.</p>
            </article>
            <article class="icon-card">
                <h3>2. Authentication</h3>
                <p>Metals are weighed and assayed, stones are measured, and provenance documents are digitized by certified specialists.</p>
            </article>
            <article class="icon-card">
                <h3>3. Preservation</h3>
                <p>Items move into climate-appropriate chambers with tamper-evident seals, RFID tracking, and environmental telemetry.</p>
            </article>
            <article class="icon-card">
                <h3>4. Controlled release</h3>
                <p>Authorized instructions trigger dual verification, packing under HD recording, and insured dispatch to your chosen destination.</p>
            </article>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
