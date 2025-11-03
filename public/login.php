<?php

use App\Support\Auth;

require_once __DIR__ . '/../app/bootstrap.php';

$pageTitle = 'Login';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($password === '') {
        $errors[] = 'Please provide your password.';
    }

    if (!$errors && Auth::attempt($email, $password)) {
        $user = Auth::user();
        $redirect = $user && $user['role'] === 'admin' ? 'admin/index.php' : 'dashboard.php';
        redirect($redirect);
    } else {
        if (!$errors) {
            $errors[] = 'The provided credentials are incorrect.';
        }
    }
}

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="auth-section">
    <div class="container auth-container">
        <div class="auth-card">
            <h1>Welcome back</h1>
            <p class="auth-subtitle">Access your vault or manage shipments.</p>

            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="form-grid">
                <label>
                    <span>Email</span>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>
                <button class="btn btn-primary" type="submit">Sign In</button>
            </form>

            <p class="auth-hint">Need help? Contact your concierge team.</p>
        </div>
        <div class="auth-side">
            <h2>Vault & Shipping Suite</h2>
            <ul>
                <li>Secure vault inventory visibility</li>
                <li>Live shipment status with location context</li>
                <li>Admin-managed updates in real time</li>
            </ul>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
