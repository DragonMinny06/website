<?php
require_once 'f_db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user']['id'];

// Supprimer l'utilisateur
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$userId]);

session_destroy();
header("Location: index.php?account_deleted=1");
exit();
?>