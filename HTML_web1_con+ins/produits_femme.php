<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produits Femme - Eily GYM</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <section class="product-section">
    <h2>Produits Femme</h2>
    <div class="product-grid">
      <?php
        $products_femme = [
          ["nom" => "Leggings Femme Élite", "prix" => "55€", "image" => "femme_leggings.jpg"],
          ["nom" => "Brassière Sport", "prix" => "40€", "image" => "femme_brassiere.jpg"],
          ["nom" => "Débardeur Femme", "prix" => "35€", "image" => "femme_debardeur.jpg"],
          ["nom" => "Sac Femme Fitness", "prix" => "45€", "image" => "femme_sac.jpg"]
        ];
        foreach ($products_femme as $product) {
          echo '<div class="product-card">';
          echo '<img src="images/' . $product["image"] . '" alt="' . $product["nom"] . '">';
          echo '<h3>' . $product["nom"] . '</h3>';
          echo '<p class="price">' . $product["prix"] . '</p>';
          echo '<form method="POST" action="panier_action.php?action=ajouter">';
          echo '<input type="hidden" name="nom" value="' . htmlspecialchars($product["nom"]) . '">';
          echo '<input type="hidden" name="prix" value="' . floatval(str_replace('€', '', $product["prix"])) . '">';
          echo '<button type="submit">Ajouter au panier</button>';
          echo '</form>';
          echo '</div>';
        }
      ?>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>

<script src="script.js"></script>
</body>
</html>
