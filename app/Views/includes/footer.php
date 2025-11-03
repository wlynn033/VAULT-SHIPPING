    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(config('app.name', 'Vault & Shipping Suite')) ?>. All rights reserved.</p>
                <p class="muted small">Global custody and concierge logistics for fine assets.</p>
            </div>
            <div class="footer-links">
                <a href="<?= base_url('about.php') ?>">About</a>
                <a href="<?= base_url('security.php') ?>">Security</a>
                <a href="<?= base_url('pricing.php') ?>">Pricing</a>
                <a href="<?= base_url('faq.php') ?>">FAQ</a>
                <a href="<?= base_url('contact.php') ?>">Contact</a>
            </div>
        </div>
    </footer>
    <script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
