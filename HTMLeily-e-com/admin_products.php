<?php
require_once 'f_db.php';
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $image = $_POST['image'];
    $stmt = $pdo->prepare("INSERT INTO products (nom, prix, image) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $prix, $image]);
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

// Liste des produits
$products = $pdo->query("SELECT * FROM products")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des produits</title>
</head>
<body>
    <h2>Produits</h2>
    <form method="POST">
        <input name="nom" required placeholder="Nom">
        <input name="prix" required type="number" min="0" step="0.01" placeholder="Prix">
        <input name="image" placeholder="URL image">
        <button type="submit" name="add_product">Ajouter</button>
    </form>
    <ul>
    <?php foreach($products as $p): ?>
        <li>
            <?= htmlspecialchars($p['nom']) ?> - <?= htmlspecialchars($p['prix']) ?>€
            <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>