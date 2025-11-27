<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">   
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eily Gym</title>
  <link rel="stylesheet" href="./styles.css">
</head>
<body>
  <header>
    <div class="logo">Eily GYM</div>
    <nav id="nav">
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li class="dropdown">
          <a href="produits.php">Tous les produits</a>
          <ul class="submenu">
            <li><a href="produits_homme.php">Homme</a></li>
            <li><a href="produits_femme.php">Femme</a></li>
          </ul>
        </li>
        <li><a href="cart.php">Mon panier</a></li>
        <li><a href="#about">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
        <?php
        session_start();
        if (isset($_SESSION['user'])) {
          echo '<li>Connecté : <b>' . htmlspecialchars($_SESSION['user']['username']) . '</b></li>';
          echo '<li><a href="admin.php">Admin</a></li>';
          echo '<li><a href="delete_account.php" onclick="return confirm(\'Voulez-vous vraiment supprimer votre compte ?\')">Supprimer mon compte</a></li>';
          echo '<li><a href="logout.php">Déconnexion</a></li>';
        } else {
          echo '<li><a href="login.php">Connexion</a></li>';
          echo '<li><a href="register.php">Inscription</a></li>';
        }
        ?>

      <li class="dropdown">
        <a href="./">&#128100</a>
        <ul class="submenu">
          <li><a href="./login.php">connexion</a></li>
          <li><a href="./register.php">Inscription</a></li>
        </ul>
      </li>
      <ul class="burger" id="burger"></ul>
    <form method="POST" action="panier_action.php?action=ajouter">

    <form method="POST" action="panier_action.php">
   <input type="hidden" name="nom" value="LeNomDuProduit">
   <input type="hidden" name="prix" value="49.99">
  </form>
  
  </header>

  <section class="hero" id="home">
    <h1>Reste fort! Reste stylé!</h1>
    <p>Découvre les nouvelles collections de vêtements de sport de la marque Eily Gym.</p>
    <a href="#products" class="btn-primary">Voir les nouveautés</a>
  </section>



  
  <section class="promo">
    <img src="images/banner.png" alt="Nouvelle Collection">
      <div class="promo-text">
        <h1> Nouvelle Collection Automne 2025🍂 </h1>
        <p>Des couleurs chaudes, des tissues techniaue et du style - pour performer avec classe. </p>
      </div>
  </section>



  <section class="products" id="products">
    <h2>Les Nouveautés</h2>
    <div class="products-grid" id="products-grid">
      <!-- Les produits seront injectés ici par JavaScript -->
    </div>
  </section>

  <section class="about" id="about">
    <h2>À propos</h2>
    <p>
    Eily Gym propose des vêtements de sport modernes, confortables et durables, conçus pour accompagner chaque séance.
    </p>
  </section>

  <section class="contact" id="contact">
    <h2>Contact</h2>
    <form>
      <input type="text" placeholder="Votre nom" required>
      <input type="email" placeholder="Votre email" required>
      <textarea placeholder="Votre message" required></textarea>
      <button type="submit">Envoyer</button>
    </form>
  </section>

  <footer>
    &copy; 2025 Eily Gym
  </footer>

  <script src="script.js"></script>
</body>
</html>