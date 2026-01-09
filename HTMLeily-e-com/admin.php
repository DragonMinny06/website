<?php
require_once 'f_db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> Admin - Eily Gym</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div class="logo">Espace Admin</div>
    <nav>
        <a href="index.php" style="color:white;">Accueil</a>
        <a href="logout.php" style="color:white;">Déconnexion</a>
    </nav>
</header>


    <h1>Espace Admin</h1>

    <ul>
        <li><a href="add_products.php"> Ajouter un produit</a></li>
        <li><a href="admin_products.php"> Gérer les produits / catégories</a></li>
        <li><a href="admin_categories.php"> Gérer les catégories</a></li>
        <li><a href="admin_users.php"> Gérer les utilisateurs</a></li>
        <li><a href="admin_orders.php"> Gérer les commandes</a></li>
    </ul>


</body>
</html>
