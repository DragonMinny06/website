<?php
session_start();
require_once 'config.php';
$cart = $_SESSION['cart'] ?? [];
$products = [];
if (count($cart)) {
    // On récupère les produits du panier par leur ID
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($cart);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="logo">Eily Gym</div>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="add_products.php">Ajouter produit</a></li>
        <li><a href="cart.php">Panier 🛒</a></li>
      </ul>
    </nav>
  </header>

  <section class="products">
    <h2>Votre panier</h2>
    <div class="products-grid">
      <?php foreach ($products as $p): ?>
        <div class="product-card">
          <img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
          <h3><?= htmlspecialchars($p['name']) ?></h3>
          <p><?= htmlspecialchars($p['desc']) ?></p>
          <div class="price"><?= htmlspecialchars($p['price']) ?></div>
        </div>
      <?php endforeach; ?>
      <?php if (count($products) == 0): ?>
        <p>Votre panier est vide.</p>
      <?php endif; ?>
    </div>
  </section>
  <footer>
    &copy; 2025 Eily Gym — Panier
  </footer>
</body>
</html>