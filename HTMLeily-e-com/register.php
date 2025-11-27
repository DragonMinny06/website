<?php
require_once 'f_db.php';
session_start();

$errors = [];
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = 'Tous les champs sont requis.';
    }
    if (strlen($username) > 100) $errors[] = 'Le pseudo est trop long.';

    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->execute(array($username, $email));
    if ($stmt->fetch()) $errors[] = 'Ce pseudo ou cet email existe déjà.';

    if (empty($errors)) {
        $hash = md5($password);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($username, $email, $hash, 'user'));
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Eily Gym</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./register.css">
</head>
<body>
<div class="register">
    <h2>Créer un compte</h2>
    <?php if ($success): ?>
        <div class="message-success">Compte créé avec succès. <a href="login.php">Connectez-vous</a></div>
    <?php elseif (!empty($errors)): ?>
        <div class="message-error">
            <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post" action="register.php" autocomplete="off">
        <label>Nom d'utilisateur <input name="username" required maxlength="100"></label>
        <label>Email <input name="email" required maxlength="100" type="email"></label>
        <label>Mot de passe <input name="password" type="password" required></label>
        <button type="submit" style="margin-top:1rem;">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
</div>
</body>
</html>