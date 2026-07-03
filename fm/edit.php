<?php
require_once __DIR__ . '/config.php';
require_login();
require_once __DIR__ . '/GitHubClient.php';

$gh = new GitHubClient();
$path = trim($_GET['path'] ?? '', '/');
if ($path === '') { header('Location: index.php'); exit; }

$parentPath = strpos($path, '/') !== false ? substr($path, 0, strrpos($path, '/')) : '';
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newContent = $_POST['content'] ?? '';
    $fresh = $gh->getFile($path); // ambil sha terbaru dulu (auto pull sebelum push)
    if (!$fresh['ok']) {
        $err = 'Gagal ambil versi terbaru file sebelum save.';
    } else {
        $res = $gh->createOrUpdateFile($path, $newContent, 'Edit ' . $path . ' via web file manager', $fresh['data']['sha']);
        if ($res['ok']) {
            header('Location: edit.php?path=' . urlencode($path) . '&msg=' . urlencode('Berhasil disimpan & push ke GitHub.'));
            exit;
        } else {
            $err = 'Gagal save (HTTP ' . $res['code'] . '): ' . json_encode($res['data']);
        }
    }
}

$fileRes = $gh->getFile($path);
if (!$fileRes['ok']) {
    $err = 'Gagal ambil file dari GitHub (HTTP ' . $fileRes['code'] . ').';
    $content = '';
} else {
    $content = $fileRes['data']['decoded_content'];
}

$msg = $_GET['msg'] ?? $msg;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit <?= htmlspecialchars($path) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
  <h1>✏️ Edit: <?= htmlspecialchars($path) ?></h1>
  <a href="logout.php">Logout</a>
</div>
<div class="container">
  <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert alert-error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <div class="toolbar">
      <a class="btn" href="index.php?path=<?= urlencode($parentPath) ?>">⬅️ Kembali</a>
    </div>
    <form method="post">
      <textarea name="content" spellcheck="false"><?= htmlspecialchars($content) ?></textarea>
      <button type="submit" class="btn btn-primary">💾 Save & Push ke GitHub</button>
    </form>
  </div>
</div>
</body>
</html>
