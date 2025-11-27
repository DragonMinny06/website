<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Suppression d'un produit du panier
if (isset($_GET['remove'])) {
    $toRemove = $_GET['remove'];
    if (isset($_SESSION['cart'][$toRemove])) {
        unset($_SESSION['cart'][$toRemove]);
    }
    header('Location: cart.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - Eily Gym</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./register.css">
</head>
<body>
<div class="panier-box">
<h1>Mon Panier</h1>
<?php if (empty($cart)): ?>
    <div class="message-success">Votre panier est vide.</div>
    <a href="produits.php" class="btn-secondary">Voir les produits</a>
<?php else: ?>
    <table class="panier-table">
        <tr>
            <th>Produit</th><th>Prix</th><th>Quantité</th><th>Total</th><th>Action</th>
        </tr>
        <?php
        $grandTotal = 0;
        foreach($cart as $item):
            $lineTotal = $item['prix'] * $item['quantite'];
            $grandTotal += $lineTotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['nom']) ?></td>
            <td><?= htmlspecialchars($item['prix']) ?>€</td>
            <td><?= $item['quantite'] ?></td>
            <td><?= number_format($lineTotal,2) ?>€</td>
            <td>
                <form method="get" action="cart.php" style="display:inline;">
                    <input type="hidden" name="remove" value="<?= htmlspecialchars($item['nom']) ?>">
                    <button type="submit" class="supprimer-btn">Retirer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total général</strong></td>
            <td colspan="2"><strong><?= number_format($grandTotal,2) ?>€</strong></td>
        </tr>
    </table>
    <a href="checkout.php" class="btn-secondary">Passer commande</a>
<?php endif; ?>
</div>
</body>
</html>