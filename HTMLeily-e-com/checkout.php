<?php
require_once 'f_db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "Panier vide!";
    exit;
}

// Enregistre la commande
$stmt = $pdo->prepare("INSERT INTO orders (user_id, date, status) VALUES (?, NOW(), 'pending')");
$stmt->execute([$_SESSION['user']['id']]);
$orderId = $pdo->lastInsertId();
foreach($cart as $product_id => $quantity){
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantite) VALUES (?, ?, ?)");
    $stmt->execute([$orderId, $product_id, $quantity]);
}
$_SESSION['cart'] = [];
echo "Commande passée !";
?>
<a href="index.php">Retour accueil</a>