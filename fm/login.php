<?php
require_once __DIR__ . '/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['password'] ?? '') === FM_PASSWORD) {
        $_SESSION['fm_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - File Manager</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
  <div class="card login-card">
    <h1>🔐 GitHub File Manager</h1>
    <?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="password" name="password" placeholder="Password" required autofocus>
      <button type="submit" class="btn btn-primary">Masuk</button>
    </form>
  </div>
</div>
</body>
</html>
