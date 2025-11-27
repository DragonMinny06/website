<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mon Panier</title>
</head>
<body>
<h1>Mon Panier</h1>
<?php if (empty($cart)): ?>
    <p>Votre panier est vide.</p>
<?php else: ?>
    <table border ="1">
        <tr>
            <th>Produit</th><th>Prix</th><th>Quantité</th><th>Total</th>
        </tr>
        <?php foreach($cart as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['nom']) ?></td>
            <td><?= htmlspecialchars($item['prix']) ?>€</td>
            <td><?= $item['quantite'] ?></td>
            <td><?= number_format($item['prix'] * $item['quantite'],2) ?>€</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <a href="checkout.php">Passer commande</a>
    </p>
<?php endif; ?>
</body>
</html>