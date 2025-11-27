<?php
session_start();
if (!isset($_POST['nom']) || !isset($_POST['prix'])) {
    header('Location: cart.php');
    exit;
}
$nom = $_POST['nom'];
$prix = $_POST['prix'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['cart'][$nom])) {
    $_SESSION['cart'][$nom] = ['nom'=>$nom, 'prix'=>$prix, 'quantite'=>1];
} else {
    $_SESSION['cart'][$nom]['quantite'] += 1;
}
header('Location: cart.php');
exit;
?>