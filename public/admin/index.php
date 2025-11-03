<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Models\User;
use App\Models\VaultItem;
use App\Support\Auth;
use App\Support\Csrf;
use Throwable;

require_once __DIR__ . '/../../app/bootstrap.php';

Auth::requireAuth();
$admin = Auth::user();

if ($admin['role'] !== 'admin') {
    redirect('../dashboard.php');
}

$pageTitle = 'Admin Console';
$errors = [];

$normalizeDateTime = static function (?string $value): ?string {
    if (!$value) {
        return null;
    }

    $value = trim($value);
    if ($value === '') {
        return null;
    }

    $value = str_replace('T', ' ', $value);

    if (strlen($value) === 16) {
        $value .= ':00';
    }

    return $value;
};

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $token = $_POST['_token'] ?? null;

    if (!Csrf::verify($token)) {
        $errors[] = 'Security token mismatch. Please try again.';
    } else {
        try {
            switch ($action) {
                case 'create_user':
                    $name = trim($_POST['name'] ?? '');
                    $email = trim($_POST['email'] ?? '');
                    $password = $_POST['password'] ?? '';
                    $role = $_POST['role'] ?? 'customer';
                    $phone = trim($_POST['phone'] ?? '');

                    if ($name === '' || $email === '' || $password === '') {
                        throw new RuntimeException('Name, email, and password are required.');
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        throw new RuntimeException('Enter a valid email address.');
                    }

                    if (User::findByEmail($email)) {
                        throw new RuntimeException('A user with that email already exists.');
                    }

                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                        'role' => $role,
                        'phone' => $phone,
                    ]);

                    flash('success', 'User account created successfully.');
                    redirect('index.php');
                    break;

                case 'create_vault_item':
                    $userId = (int) ($_POST['user_id'] ?? 0);
                    $itemName = trim($_POST['item_name'] ?? '');
                    $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
                    $status = trim($_POST['status'] ?? 'stored');

                    if ($userId <= 0 || !$itemName) {
                        throw new RuntimeException('Select a customer and provide an item name.');
                    }

                    VaultItem::create([
                        'user_id' => $userId,
                        'item_name' => $itemName,
                        'description' => trim($_POST['description'] ?? ''),
                        'quantity' => $quantity,
                        'storage_location' => trim($_POST['storage_location'] ?? ''),
                        'status' => $status,
                    ]);

                    flash('success', 'Vault item added successfully.');
                    redirect('index.php');
                    break;

                case 'create_shipment':
                    $userId = (int) ($_POST['user_id'] ?? 0);
                    $title = trim($_POST['title'] ?? '');
                    $tracking = trim($_POST['tracking_number'] ?? '');

                    if ($userId <= 0 || $title === '' || $tracking === '') {
                        throw new RuntimeException('Customer, shipment title, and tracking number are required.');
                    }

                    if (Shipment::findByTracking($tracking)) {
                        throw new RuntimeException('Tracking number already exists.');
                    }

                    Shipment::create([
                        'user_id' => $userId,
                        'title' => $title,
                        'tracking_number' => $tracking,
                        'status' => trim($_POST['status'] ?? 'Preparing'),
                        'origin' => trim($_POST['origin'] ?? ''),
                        'destination' => trim($_POST['destination'] ?? ''),
                        'estimated_delivery' => $_POST['estimated_delivery'] ?: null,
                        'shipped_at' => $normalizeDateTime($_POST['shipped_at'] ?? null),
                        'notes' => trim($_POST['notes'] ?? ''),
                    ]);

                    flash('success', 'Shipment created successfully.');
                    redirect('index.php');
                    break;

                case 'add_tracking_event':
                    $shipmentId = (int) ($_POST['shipment_id'] ?? 0);
                    $status = trim($_POST['status'] ?? '');

                    if ($shipmentId <= 0 || $status === '') {
                        throw new RuntimeException('Select a shipment and set a status.');
                    }

                    TrackingEvent::create([
                        'shipment_id' => $shipmentId,
                        'status' => $status,
                        'location' => trim($_POST['location'] ?? ''),
                        'details' => trim($_POST['details'] ?? ''),
                        'event_time' => $normalizeDateTime($_POST['event_time'] ?? null) ?? date('Y-m-d H:i:s'),
                    ]);

                    flash('success', 'Tracking event recorded successfully.');
                    redirect('index.php');
                    break;

                default:
                    throw new RuntimeException('Unknown action.');
            }
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }
    }
}

$customers = User::allCustomers();
$users = User::all();
$vaultItems = VaultItem::allWithUsers();
$shipments = Shipment::allWithUsers();

$totalCustomers = count(array_filter($users, fn ($user) => $user['role'] === 'customer'));
$totalVaultItems = count($vaultItems);
$openShipments = count(array_filter($shipments, fn ($shipment) => strtolower($shipment['status']) !== 'delivered'));

$successMessage = flash('success');

include BASE_PATH . '/app/Views/includes/header.php';
?>

<section class="admin">
    <div class="container">
        <header class="dashboard-header">
            <div>
                <h1>Admin control center</h1>
                <p>Manage customers, their vault inventory, and outbound shipments.</p>
            </div>
        </header>

        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-stats">
            <article class="stat-card">
                <p class="stat-label">Customers</p>
                <p class="stat-value"><?= $totalCustomers ?></p>
            </article>
            <article class="stat-card">
                <p class="stat-label">Vault Items</p>
                <p class="stat-value"><?= $totalVaultItems ?></p>
            </article>
            <article class="stat-card">
                <p class="stat-label">Active Shipments</p>
                <p class="stat-value"><?= $openShipments ?></p>
            </article>
        </div>

        <div class="admin-grid">
            <section class="panel">
                <div class="panel-header">
                    <h2>Create customer</h2>
                    <p>Add a new customer or admin user.</p>
                </div>
                <form method="POST" class="form-grid">
                    <input type="hidden" name="_token" value="<?= Csrf::token() ?>">
                    <input type="hidden" name="action" value="create_user">
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" required>
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required>
                    </label>
                    <label>
                        <span>Phone</span>
                        <input type="text" name="phone" placeholder="Optional">
                    </label>
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required>
                    </label>
                    <label>
                        <span>Role</span>
                        <select name="role">
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </label>
                    <button class="btn btn-primary" type="submit">Create user</button>
                </form>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Add vault item</h2>
                    <p>Link inventory to a customer vault.</p>
                </div>
                <form method="POST" class="form-grid">
                    <input type="hidden" name="_token" value="<?= Csrf::token() ?>">
                    <input type="hidden" name="action" value="create_vault_item">
                    <label>
                        <span>Customer</span>
                        <select name="user_id" required>
                            <option value="">Select customer</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"><?= htmlspecialchars($customer['name']) ?> (<?= htmlspecialchars($customer['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>
                        <span>Item title</span>
                        <input type="text" name="item_name" required>
                    </label>
                    <label>
                        <span>Description</span>
                        <textarea name="description" rows="3" placeholder="Optional"></textarea>
                    </label>
                    <label>
                        <span>Quantity</span>
                        <input type="number" name="quantity" min="1" value="1">
                    </label>
                    <label>
                        <span>Location</span>
                        <input type="text" name="storage_location" placeholder="Vault location / bin">
                    </label>
                    <label>
                        <span>Status</span>
                        <input type="text" name="status" value="Stored">
                    </label>
                    <button class="btn btn-primary" type="submit">Add item</button>
                </form>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Create shipment</h2>
                    <p>Launch outbound deliveries.</p>
                </div>
                <form method="POST" class="form-grid">
                    <input type="hidden" name="_token" value="<?= Csrf::token() ?>">
                    <input type="hidden" name="action" value="create_shipment">
                    <label>
                        <span>Customer</span>
                        <select name="user_id" required>
                            <option value="">Select customer</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"><?= htmlspecialchars($customer['name']) ?> (<?= htmlspecialchars($customer['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>
                        <span>Shipment title</span>
                        <input type="text" name="title" required>
                    </label>
                    <label>
                        <span>Tracking number</span>
                        <input type="text" name="tracking_number" required>
                    </label>
                    <label>
                        <span>Status</span>
                        <input type="text" name="status" value="Preparing">
                    </label>
                    <label>
                        <span>Origin</span>
                        <input type="text" name="origin" placeholder="Origin facility">
                    </label>
                    <label>
                        <span>Destination</span>
                        <input type="text" name="destination" placeholder="Customer address / city">
                    </label>
                    <label>
                        <span>Estimated delivery</span>
                        <input type="date" name="estimated_delivery">
                    </label>
                    <label>
                        <span>Shipped at</span>
                        <input type="datetime-local" name="shipped_at">
                    </label>
                    <label>
                        <span>Notes</span>
                        <textarea name="notes" rows="3" placeholder="Optional notes"></textarea>
                    </label>
                    <button class="btn btn-primary" type="submit">Create shipment</button>
                </form>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Post tracking update</h2>
                    <p>Broadcast new shipment milestones.</p>
                </div>
                <form method="POST" class="form-grid">
                    <input type="hidden" name="_token" value="<?= Csrf::token() ?>">
                    <input type="hidden" name="action" value="add_tracking_event">
                    <label>
                        <span>Shipment</span>
                        <select name="shipment_id" required>
                            <option value="">Select shipment</option>
                            <?php foreach ($shipments as $shipment): ?>
                                <option value="<?= $shipment['id'] ?>"><?= htmlspecialchars($shipment['title']) ?> (<?= htmlspecialchars($shipment['tracking_number']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>
                        <span>Status</span>
                        <input type="text" name="status" placeholder="e.g. In Transit" required>
                    </label>
                    <label>
                        <span>Location</span>
                        <input type="text" name="location" placeholder="City, Facility">
                    </label>
                    <label>
                        <span>Details</span>
                        <textarea name="details" rows="3" placeholder="Optional details"></textarea>
                    </label>
                    <label>
                        <span>Event time</span>
                        <input type="datetime-local" name="event_time">
                    </label>
                    <button class="btn btn-primary" type="submit">Add update</button>
                </form>
            </section>
        </div>

        <section class="panel">
            <div class="panel-header">
                <h2>Vault inventory overview</h2>
                <p>All items currently stored for clients.</p>
            </div>
            <?php if ($vaultItems): ?>
                <div class="table-scroll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Customer</th>
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
                                        <p class="muted small"><?= htmlspecialchars($item['description']) ?></p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($item['user_name']) ?><br>
                                    <span class="muted small"><?= htmlspecialchars($item['user_email']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($item['status']) ?></td>
                                <td><?= htmlspecialchars($item['storage_location'] ?? '?') ?></td>
                                <td><?= date('M j, Y', strtotime($item['added_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No inventory items yet.</p>
            <?php endif; ?>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h2>Shipments overview</h2>
                <p>Monitor every delivery with live updates.</p>
            </div>
            <?php if ($shipments): ?>
                <div class="table-scroll">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Shipment</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Tracking #</th>
                                <th>Destination</th>
                                <th>Last update</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($shipments as $shipment): ?>
                            <tr>
                                <td><?= htmlspecialchars($shipment['title']) ?></td>
                                <td>
                                    <?= htmlspecialchars($shipment['user_name']) ?><br>
                                    <span class="muted small"><?= htmlspecialchars($shipment['user_email']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($shipment['status']) ?></td>
                                <td><?= htmlspecialchars($shipment['tracking_number']) ?></td>
                                <td><?= htmlspecialchars($shipment['destination'] ?? '?') ?></td>
                                <td><?= date('M j, H:i', strtotime($shipment['last_status_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No shipments yet.</p>
            <?php endif; ?>
        </section>
    </div>
</section>

<?php include BASE_PATH . '/app/Views/includes/footer.php'; ?>
