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

foreach($cart as $item){
    // Trouver l'id produit depuis le nom
    $stmt = $pdo->prepare("SELECT id FROM products WHERE nom = ?");
    $stmt->execute([$item['nom']]);
    $product = $stmt->fetch();
    if ($product) {
        $stmt2 = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantite) VALUES (?, ?, ?)");
        $stmt2->execute([$orderId, $product['id'], $item['quantite']]);
    }
}
$_SESSION['cart'] = [];
echo "Commande passée !";
?>
<a href="index.php">Retour accueil</a>