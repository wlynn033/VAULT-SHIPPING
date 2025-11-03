    </main>
    <footer class="site-footer">
        <div class="container footer-inner">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars(config('app.name', 'Vault & Shipping Suite')) ?>. All rights reserved.</p>
            <div class="footer-links">
                <a href="mailto:support@example.com">Support</a>
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
            </div>
        </div>
    </footer>
    <script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
