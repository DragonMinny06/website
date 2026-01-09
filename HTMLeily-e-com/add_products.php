<?php
require_once 'f_db.php';
session_start();

/* admin uniquement */
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
    header('Location: index.php');
    exit();
}

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nom = trim($_POST['nom'] ?? '');
    $prix = trim($_POST['prix'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = ($_POST['category_id'] === '') ? null : (int)$_POST['category_id'];

    if ($nom !== '' && $prix !== '') {
        $stmt = $pdo->prepare("
            INSERT INTO products (nom, prix, image, description, category_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nom, $prix, $image, $description, $category_id]);

        /* Recharge propre (évite double insertion) */
        header("Location: add_products.php?success=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="logo">Espace Admin</div>
    <nav>
        <a href="admin.php" style="color:white;">Retour</a>
    </nav>
</header>

<main style="padding:20px; max-width:700px;">
    <h1>Ajouter un produit</h1>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green; font-weight:bold;">Produit ajouté avec succès.</p>
    <?php endif; ?>

    <form method="post" style="display:grid; gap:12px;">
        <input type="text" name="nom" placeholder="Nom du produit" required>

        <input type="number" name="prix" placeholder="Prix" step="0.01" min="0" required>

        <input type="text" name="image" placeholder="URL de l'image">

        <textarea name="description" placeholder="Description du produit" rows="4"></textarea>

        <select name="category_id">
            <option value="">Aucune catégorie</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="add_product">Ajouter le produit</button>
    </form>
</main>

</body>
</html>
