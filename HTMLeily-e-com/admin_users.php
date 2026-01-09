<?php
require_once 'f_db.php';
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? 'user') !== 'admin') {
    header('Location: index.php'); exit();
}

// changer rôle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_role'])) {
    $userId = (int)($_POST['user_id'] ?? 0);
    $role = $_POST['role'] ?? 'user';

    if ($userId > 0 && in_array($role, ['user','admin'], true)) {
        // éviter de se retirer admin soi-même
        if ($userId === (int)$_SESSION['user']['id'] && $role !== 'admin') {
            $error = "Tu ne peux pas retirer ton propre rôle admin.";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET role=? WHERE id=?");
            $stmt->execute([$role, $userId]);
        }
    }
}

$users = $pdo->query("SELECT id, username, email, role FROM users ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Admin - Utilisateurs</title></head>
<body>
<h1>Gérer les utilisateurs</h1>

<?php if (!empty($error)) echo "<p style='color:red'>".htmlspecialchars($error)."</p>"; ?>

<table border="1" cellpadding="8">
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Rôle</th><th>Action</th></tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= (int)$u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
            <form method="post" style="display:inline">
                <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                <select name="role">
                    <option value="user" <?= $u['role']==='user'?'selected':'' ?>>user</option>
                    <option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>admin</option>
                </select>
                <button type="submit" name="set_role">Changer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="admin.php">Retour admin</a></p>
</body>
</html>
