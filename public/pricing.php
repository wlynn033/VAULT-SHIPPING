<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Membership & Pricing';

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="page-hero">
    <div class="container page-hero-grid">
        <div>
            <span class="eyebrow">Membership</span>
            <h1>Transparent pricing for bespoke custody.</h1>
            <p>Your assets deserve predictable care. Our membership tiers align with the level of vault space, insurance coverage, and logistics cadence you require. Every plan includes access to the secure client portal, concierge support, and compliance reporting.</p>
            <div class="stat-band">
                <div class="stat">
                    <strong>99.8%</strong>
                    <span class="muted">Client retention over 5 years</span>
                </div>
                <div class="stat">
                    <strong>$25M</strong>
                    <span class="muted">Maximum insured per movement</span>
                </div>
                <div class="stat">
                    <strong>Included</strong>
                    <span class="muted">24/7 concierge across every tier</span>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <h2>Need a custom structure?</h2>
            <p>Family offices, dealers, and institutions with rotating stock can engage our structuring desk for bespoke capacity, staging rooms, or permanent on-site teams.</p>
            <a class="btn btn-primary" href="<?= base_url('contact.php') ?>">Speak with sales</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Compare membership tiers</h2>
        <p class="section-subtitle">Fees are billed quarterly and include proactive insurance renewals, compliance reporting, and access to the Aurum portal. Logistics charges apply per movement based on distance, mode, and declared value.</p>
        <div class="pricing-grid">
            <article class="plan-card">
                <span class="badge-outline">Essentials</span>
                <h3>Private Collector</h3>
                <p class="price">$1,250<span>/month</span></p>
                <ul class="list-check">
                    <li>Up to $2M insured value stored.</li>
                    <li>Two complimentary domestic releases per quarter.</li>
                    <li>Prime vault space with shared viewing salon.</li>
                    <li>Inventory audits twice yearly.</li>
                </ul>
                <a class="btn btn-ghost" href="<?= base_url('contact.php') ?>">Choose plan</a>
            </article>
            <article class="plan-card">
                <span class="badge-outline">Preferred</span>
                <h3>Family Office</h3>
                <p class="price">$3,800<span>/month</span></p>
                <ul class="list-check">
                    <li>Up to $8M insured value stored.</li>
                    <li>Four domestic or two international releases per quarter.</li>
                    <li>Dedicated concierge and private viewing salon.</li>
                    <li>Quarterly inventory reconciliation with valuation updates.</li>
                </ul>
                <a class="btn btn-primary" href="<?= base_url('contact.php') ?>">Talk to sales</a>
            </article>
            <article class="plan-card">
                <span class="badge-outline">Premier</span>
                <h3>Institutional</h3>
                <p class="price">Custom<span>/month</span></p>
                <ul class="list-check">
                    <li>$8M+ insured value with multi-jurisdiction vault access.</li>
                    <li>Unlimited global releases with charter, courier, or armored support.</li>
                    <li>Embedded onsite team, audit support, and white-label reporting.</li>
                    <li>Integration with treasury, trading desks, or marketplace platforms.</li>
                </ul>
                <a class="btn btn-primary" href="<?= base_url('contact.php') ?>">Schedule consultation</a>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container two-column">
        <div class="card-panel">
            <h2>What is included in every plan</h2>
            <ul class="list-check">
                <li>Secure intake with full photographic cataloguing and provenance documentation.</li>
                <li>Always-on monitoring, dual-control procedures, and incident response drills.</li>
                <li>Online dashboard for live inventory, shipment tracking, and digital approvals.</li>
                <li>Quarterly stewardship reports summarizing inspections, valuations, and releases.</li>
            </ul>
        </div>
        <div class="card-panel">
            <h2>Optional add-ons</h2>
            <ul class="list-check">
                <li>Premium insurance riders for exceptionally rare or high-volatility assets.</li>
                <li>Private viewing salon redesign to match family office branding.</li>
                <li>In-person armed escort for gala events or auctions.</li>
                <li>White-label portal with custom domain and single sign-on integration.</li>
            </ul>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
