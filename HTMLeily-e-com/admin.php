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
    <title>Admin - Eily Gym</title>
</head>
<body>
    <h1>Espace Admin</h1>
    <ul>
        <li><a href="admin_products.php">Gérer les articles</a></li>
        <li><a href="admin_categories.php">Gérer les catégories</a></li>
        <li><a href="admin_users.php">Gérer les utilisateurs</a></li>
        <li><a href="admin_orders.php">Gérer les commandes</a></li>
    </ul>
    <a href="index.php">Retour accueil</a>
</body>
</html>