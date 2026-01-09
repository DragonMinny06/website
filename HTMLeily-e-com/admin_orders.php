<?php
require_once 'f_db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

/* ----
   MISE A JOUR DU STATUT
---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = (int) $_POST['order_id'];
    $status  = $_POST['status'];

    $allowedStatuses = ['en_attente', 'payee', 'expediee', 'annulee'];

    if ($orderId > 0 && in_array($status, $allowedStatuses, true)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }
}

/* -----------
   SUPPRESSION COMMANDE
------ */
if (isset($_GET['delete'])) {
    $orderId = (int) $_GET['delete'];

    if ($orderId > 0) {
        $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$orderId]);
        $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$orderId]);
    }

    header('Location: admin_orders.php');
    exit();
}

/* --------
   LISTE DES COMMANDES
------- */
$orders = $pdo->query("
    SELECT o.*, u.username 
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    ORDER BY o.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

/* -----
   LABELS STATUTS
----- */
$statusLabels = [
    'en_attente' => 'En attente',
    'payee'      => 'Payée',
    'expediee'   => 'Expédiée',
    'annulee'    => 'Annulée'
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Commandes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="logo">Espace Admin</div>
    <nav>
        <a href="admin.php" style="color:white;">Retour</a>
    </nav>
</header>

<main style="padding:20px;">
    <h1>Gérer les commandes</h1>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Changer statut</th>
            <th>Action</th>
        </tr>

        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= (int)$order['id'] ?></td>
                <td><?= htmlspecialchars($order['username'] ?? 'Invité') ?></td>
                <td><?= htmlspecialchars($order['total'] ?? '0') ?> €</td>
                <td><?= $statusLabels[$order['status']] ?? 'Inconnu' ?></td>
                <td>
                    <form method="post" style="display:flex; gap:8px;">
                        <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>">
                        <select name="status">
                            <?php foreach ($statusLabels as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $order['status'] === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update_status">OK</button>
                    </form>
                </td>
                <td>
                    <a href="?delete=<?= (int)$order['id'] ?>"
                       onclick="return confirm('Supprimer cette commande ?')">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>

</body>
</html>
