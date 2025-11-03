<?php

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Contact Aurum Concierge';

$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $topic = trim($_POST['topic'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // In a production deployment you would send this via secure messaging or ticketing.
    // For the demo application we simply surface a confirmation notice to the visitor.
}

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="page-hero">
    <div class="container page-hero-grid">
        <div>
            <span class="eyebrow">Contact</span>
            <h1>Connect with our global concierge desk.</h1>
            <p>Whether you are onboarding new assets, arranging an urgent shipment, or exploring membership, our specialists are available 24/7. Choose the channel that suits you and we will respond immediately.</p>
        </div>
        <div class="card-panel">
            <h2>Immediate assistance</h2>
            <p><strong>Concierge hotline:</strong> +41 22 555 0198</p>
            <p><strong>Secure email:</strong> concierge@aurumvault.com</p>
            <p class="muted">Encrypted messaging via Signal or Wire is available upon request.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <div class="contact-card">
            <h2>Visit our private client lounges</h2>
            <p>Schedule appointments at any Aurum location. Viewing salons are discreet, monitored, and tailored for asset inspections.</p>
            <ul class="list-check">
                <li><strong>Geneva, Switzerland</strong> ? Rue du Rh?ne 102, Level 3</li>
                <li><strong>New York, USA</strong> ? 745 Fifth Avenue, 32nd Floor</li>
                <li><strong>Dubai, UAE</strong> ? DIFC Gate Village 12, Suite 501</li>
                <li><strong>Singapore</strong> ? Marina Bay Financial Centre, Tower 2</li>
            </ul>
        </div>
        <div>
            <?php if ($submitted): ?>
                <div class="alert alert-success">
                    Thank you <?= htmlspecialchars($name ?: 'for reaching out') ?>. A concierge will contact you at <?= htmlspecialchars($email ?: 'your provided details') ?> shortly.
                </div>
            <?php endif; ?>
            <div class="card-panel">
                <h2>Send a secure enquiry</h2>
                <form method="POST" class="form-grid">
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                    </label>
                    <label>
                        <span>Topic</span>
                        <select name="topic" required>
                            <option value="">Select</option>
                            <option value="vaulting" <?= isset($topic) && $topic === 'vaulting' ? 'selected' : '' ?>>Vault storage</option>
                            <option value="shipping" <?= isset($topic) && $topic === 'shipping' ? 'selected' : '' ?>>Shipping request</option>
                            <option value="pricing" <?= isset($topic) && $topic === 'pricing' ? 'selected' : '' ?>>Pricing & membership</option>
                            <option value="support" <?= isset($topic) && $topic === 'support' ? 'selected' : '' ?>>Client support</option>
                            <option value="partnership" <?= isset($topic) && $topic === 'partnership' ? 'selected' : '' ?>>Partnership</option>
                        </select>
                    </label>
                    <label>
                        <span>Message</span>
                        <textarea name="message" rows="5" required><?= htmlspecialchars($message ?? '') ?></textarea>
                    </label>
                    <button class="btn btn-primary" type="submit">Submit enquiry</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container contact-highlight">
        <div>
            <h2>Emergency logistics desk</h2>
            <p>For urgent releases or crisis situations, call +41 22 555 0911 or initiate a priority request inside the portal. Our response teams can deploy within 90 minutes in major financial hubs.</p>
        </div>
        <div class="contact-actions">
            <a class="btn btn-secondary" href="tel:+41225550911">Call emergency line</a>
            <a class="btn btn-ghost" href="<?= base_url('tracking.php') ?>">Track existing shipment</a>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
