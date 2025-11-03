<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Frequently Asked Questions';

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="page-hero">
    <div class="container page-hero-grid">
        <div>
            <span class="eyebrow">Client FAQs</span>
            <h1>Answers to the most common vault and shipping questions.</h1>
            <p>From storing fine jewellery to transporting bullion across borders, we have distilled the details clients ask for most. If you need clarification, our concierge desk is just a call away.</p>
        </div>
        <div class="card-panel">
            <h2>Still have questions?</h2>
            <p>Our concierge team is available around the clock to help you plan storage, schedule shipments, or onboard new authorized users.</p>
            <a class="btn btn-primary" href="<?= base_url('contact.php') ?>">Contact concierge</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Vaulting</h2>
        <ul class="faq-list">
            <li class="faq-item">
                <h3>What types of assets can Aurum store?</h3>
                <p>We regularly safeguard precious metals, loose diamonds, investment jewellery, luxury watches, rare coins, fine art, documents, and other high-value collectibles. Specialized chambers support climate-sensitive items such as wine or archival materials.</p>
            </li>
            <li class="faq-item">
                <h3>How is my inventory documented?</h3>
                <p>Upon intake, every item is photographed, weighed or measured, assigned a unique identifier, and sealed in tamper-evident packaging. The record, including provenance documents, is available in your portal within two hours.</p>
            </li>
            <li class="faq-item">
                <h3>Can I visit the vault?</h3>
                <p>Yes. Clients can schedule private viewings in dedicated salons. Visits require 48 hours' notice and all guests must be pre-registered. Virtual inspections with live video are also available for urgent requests.</p>
            </li>
        </ul>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Shipping & logistics</h2>
        <ul class="faq-list">
            <li class="faq-item">
                <h3>How quickly can Aurum dispatch my assets?</h3>
                <p>Domestic releases can be arranged with as few as four hours' notice. Global shipments typically depart within 12-24 hours, depending on customs complexity and mode of transport.</p>
            </li>
            <li class="faq-item">
                <h3>Are shipments insured?</h3>
                <p>Yes. Every movement is covered by bespoke transit insurance up to your declared value. Certificates are issued before departure and available through the portal.</p>
            </li>
            <li class="faq-item">
                <h3>Who signs for delivery?</h3>
                <p>Only individuals you authorize in writing may sign. Couriers verify identity with government-issued ID and biometric validation where available. The delivery is photographed and logged immediately.</p>
            </li>
        </ul>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Technology & access</h2>
        <ul class="faq-list">
            <li class="faq-item">
                <h3>Is the client portal secure?</h3>
                <p>The portal is protected with multi-factor authentication, device fingerprinting, and hardware security modules. All instructions are digitally signed and time-stamped.</p>
            </li>
            <li class="faq-item">
                <h3>Can our family office integrate with your systems?</h3>
                <p>Yes. We offer secure APIs and SFTP feeds for inventory data, valuation updates, and logistics events. Single sign-on can be enabled for enterprise clients.</p>
            </li>
            <li class="faq-item">
                <h3>How are authorized users managed?</h3>
                <p>Administrators within your organization can grant or revoke access instantly. All changes require dual approval and appear in your audit log.</p>
            </li>
        </ul>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
