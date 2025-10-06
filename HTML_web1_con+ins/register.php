<?php
$db_host = 'localhost';
$db_name = 'eily_gym';
$db_user = 'root';
$db_pass = '';

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

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $mails = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    if (empty($erreurs)) {
        $stmt = $pdo->prepare('SELECT id FROM user WHERE username = ? LIMIT 1');
        $stmt->execute([$user]);
        if ($stmt->rowCount() > 0) {
            $erreurs[] = 'Ce nom d\'utilisateur est déjà pris.';
        }

        $stmt = $pdo->prepare('SELECT id FROM user WHERE email = ? LIMIT 1');
        $stmt->execute([$mails]);
        if ($stmt->rowCount() > 0) {
            $erreurs[] = 'Cet email est déjà utilisé.';
        }

        if (empty($erreurs)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO user (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$user, $mails, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>

<?php if (!empty($erreurs)): ?>
    <ul>
        <?php foreach ($erreurs as $erreur): ?>
            <li><?= htmlspecialchars($erreur) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

 
 <html>
<head>
    <link rel="stylesheet" href="./register.css">
    <meta charset="utf-8">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
  <div class="register">
  <h1>Créer un compte</h1>
  <?php if (!empty($errors)): ?>
    <div style="background:#ffe6e6;padding:1rem;border:1px solid #ffcccc;">
      <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
    </div>
  <?php endif; ?>
  <form method="post" action="register.php" autocomplete="off">
    <label>username <input name="username" required maxlength="100"></label>
    <label>email <input name="email" required maxlength="100"></label>
    <label>Mot de passe <input name="password" type="password" required></label>
    <button type="submit" style="margin-top:1rem;padding:.5rem 1rem;">S'inscrire</button>
  </form>
  <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
  </div>
</body>

 </html>

