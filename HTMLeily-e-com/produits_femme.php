<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produits Femme - Eily GYM</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
<main>
  <section class="product-section">
    <h2>Produits Femme</h2>
    <div class="product-grid">
      <?php
        $products_femme = [
          ["nom" => "Leggings Femme Élite", "prix" => "55€", "image" => "legging_f.png"],
          ["nom" => "Brassière Femme", "prix" => "35€", "image" => "brassiere_f.png"],
          ["nom" => "t-shirt Femme", "prix" => "45€", "image" => "t-shirt_f.png"],
          ["nom" => "debardeur Femme", "prix" => "40€", "image" => "debardeur_f.png"]
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

<script src="script.js"></script>
</body>
</html>
