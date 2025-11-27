<?php
require_once 'f_db.php';
$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tous les produits - Eily Gym</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Tous les produits</h2>
<div class="product-grid">
  <?php foreach ($products as $product) : ?>
    <div class="product-card">
      <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>">
      <h3><?= htmlspecialchars($product['nom']) ?></h3>
      <p><?= htmlspecialchars($product['prix']) ?>€</p>
      <form method="POST" action="panier_action.php">
        <input type="hidden" name="nom" value="<?= htmlspecialchars($product['nom']) ?>">
        <input type="hidden" name="prix" value="<?= htmlspecialchars($product['prix']) ?>">
        <button type="submit">Ajouter au panier</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>