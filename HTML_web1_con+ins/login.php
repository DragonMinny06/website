<?php
$db_host = 'localhost';
$db_name = 'eily_gym';
$db_user = 'root';
$db_pass = 'root';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}

session_start();

// Tableau des erreurs
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs du formulaire
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation des champs
    if ($username === '' || $password === '') {
        $errors[] = 'Le nom d\'utilisateur et le mot de passe sont requis.';
    } else {
        // Préparation de la requête pour vérifier l'utilisateur dans la base de données
        $stmt = $pdo->prepare('SELECT id, username, password FROM user WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Nom d\'utilisateur ou mot de passe invalide.';
        } else {
            // Stockage des informations utilisateur dans la session
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'username' => $user['username'],
            ];
            // Redirection vers la page d'accueil
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>
  <div class="login">
    <h1>Connexion</h1>

    <?php if (isset($_GET['registered'])): ?>
      <div style="background:#e6ffea;padding:1rem;border:1px solid #cceacc;">Inscription réussie — connectez-vous.</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
      <div style="background:#ffe6e6;padding:1rem;border:1px solid #ffcccc;">
        <ul>
          <?php foreach($errors as $error) echo '<li>' . htmlspecialchars($error) . '</li>'; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" action="login.php" autocomplete="off">
      <label>Nom d'utilisateur <input name="username" required></label>
      <label>Mot de passe <input name="password" type="password" required></label>
      <button type="submit" style="margin-top:1rem;padding:.5rem 1rem;">Se conn
