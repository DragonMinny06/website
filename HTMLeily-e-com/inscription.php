<?php
require_once 'connect.php';
session_start();

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim(string: $_POST['nom'] ?? '');
    $prenom = trim(string: $_POST['prenom'] ?? '');
    $pseudo = trim(string: $_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($nom === '' || $prenom === '' || $pseudo === '' || $password === '') {
        $erreurs[] = 'Tous les champs sont requis.';
    }

    if (strlen($pseudo) > 50) {
        $erreurs[] = 'Le pseudo est trop long (max 50 caractères).';
    }

    if (strlen($password) < 4) {
        $erreurs[] = 'Le mot de passe doit contenir au moins 4 caractères.';
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE pseudo = ? LIMIT 1');
        $stmt->execute([$pseudo]);
        if ($stmt->fetch()) {

            } else {
                $errors[] = 'Ce pseudo est déjà utilisé.';
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (nom, prenom, pseudo, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nom, $prenom, $pseudo, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eily Gym</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
        <h2>Inscription</h2>
        <form action="register.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="S'inscrire">
        </form>
  </div>
</body>
</html>
