<?php
require_once 'f_db.php';
session_start();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = 'Tous les champs sont requis.';
    }
    if (strlen($username) > 100) $errors[] = 'Le pseudo est trop long.';

    // Vérifier doublons
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->execute(array($username, $email));
    if ($stmt->fetch()) $errors[] = 'Ce pseudo ou cet email existe déjà.';

    if (empty($errors)) {
        $hash = md5($password);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)');
        $stmt->execute(array($username, $email, $hash, 'user'));
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Eily Gym</title>
    <link rel="stylesheet" href="./register.css">
</head>
<body>
<div class="register">
    <h1>Créer un compte</h1>
    <?php if (!empty($errors)): ?>
        <div style="background:#ffe6e6;padding:1rem;border:1px solid #ffcccc;">
            <ul>
                <?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
            </ul>
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