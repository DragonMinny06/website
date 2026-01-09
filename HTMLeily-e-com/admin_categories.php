<?php
require_once 'f_db.php';
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
  header('Location: index.php');
  exit();
}

// Ajouter catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cat'])) {
  $name = trim($_POST['name'] ?? '');
  if ($name !== '') {
    try {
      $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
      $stmt->execute([$name]);
      header("Location: admin_categories.php");
      exit();
    } catch (Exception $e) {
      $error = "Catégorie déjà existante (ou erreur).";
    }
  }
}

// Supprimer catégorie
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id=?");
    $stmt->execute([$id]);
    header("Location: admin_categories.php");
    exit();
  }
}

$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Admin - Catégories</title>
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
  <h1>Gérer les catégories</h1>

  <?php if (!empty($error)) echo "<p style='color:red;'>".htmlspecialchars($error)."</p>"; ?>

  <form method="post" style="margin-bottom:20px;">
    <input type="text" name="name" placeholder="Nom catégorie (ex: Homme, Femme, Accessoires)" required>
    <button type="submit" name="add_cat">Ajouter</button>
  </form>

  <table border="1" cellpadding="10" cellspacing="0">
    <tr><th>ID</th><th>Nom</th><th>Action</th></tr>
    <?php foreach ($cats as $c): ?>
      <tr>
        <td><?= (int)$c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td>
          <a href="?delete=<?= (int)$c['id'] ?>" onclick="return confirm('Supprimer cette catégorie ?');">
            Supprimer
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</main>

</body>
</html>
