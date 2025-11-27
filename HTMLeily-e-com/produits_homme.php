<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produits Homme - Eily GYM</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
<main>
  <section class="product-section">
    <h2>Produits Homme</h2>
    <div class="product-grid">
      <?php
        $products_homme = [
          ["nom" => "T-shirt Homme Performance", "prix" => "40€", "image" => "t-shirt_h.png"],
          ["nom" => "Short Homme Confort flexible", "prix" => "35€", "image" => "short_h.png"],
          ["nom" => "Survetêment Homme", "prix" => "80€", "image" => "survet_h.png"],
          ["nom" => "Débardeur Capuche Homme", "prix" => "20€", "image" => "capuche_h.png"]
        ];


        foreach ($products_homme as $product) {
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
