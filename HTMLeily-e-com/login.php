<?php
require_once 'f_db.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Nom d\'utilisateur et mot de passe requis.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if (!$user || md5($password) !== $user['password']) {
            $errors[] = 'Nom d\'utilisateur ou mot de passe invalide.';
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion - Eily Gym</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./register.css">
</head>
<body>
<div class="login-box">
    <h1>Connexion</h1>
    <?php if (!empty($errors)): ?>
        <div class="message-error"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="login.php" autocomplete="off">
        <label>Nom d'utilisateur <input name="username" required></label>
        <label>Mot de passe <input name="password" type="password" required></label>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
</div>
</body>
</html>