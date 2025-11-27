<?php
// Configuration de la base SQLite
$db_file = __DIR__ . '/products.sqlite';
try {
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Création de la table produits si elle n'existe pas
    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        desc TEXT,
        price TEXT,
        img TEXT
    )");
} catch (Exception $e) {
    die('Erreur de connexion à la base : ' . $e->getMessage());
}

// Fonction pour récupérer tous les produits
function get_products($db) {
    return $db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>