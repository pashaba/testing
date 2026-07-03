<?php
require_once __DIR__ . '/config.php';
require_login();
require_once __DIR__ . '/GitHubClient.php';

$gh = new GitHubClient();
$path = isset($_GET['path']) ? trim($_GET['path'], '/') : '';

$msg = $_GET['msg'] ?? '';
$err = $_GET['err'] ?? '';

$res = $gh->listContents($path);

$items = [];
$isFile = false;
if ($res['ok']) {
    if (isset($res['data'][0]) || $res['data'] === []) {
        $items = $res['data'];
    } elseif (isset($res['data']['type']) && $res['data']['type'] === 'file') {
        // path ternyata file, bukan folder -> redirect ke edit
        header('Location: edit.php?path=' . urlencode($path));
        exit;
    }
} else {
    $err = 'Gagal ambil data dari GitHub (HTTP ' . $res['code'] . '). Cek token/owner/repo/branch di config.php.';
}

// Urutkan: folder dulu, lalu file, alfabetis
usort($items, function ($a, $b) {
    if ($a['type'] !== $b['type']) return $a['type'] === 'dir' ? -1 : 1;
    return strcasecmp($a['name'], $b['name']);
});

function breadcrumb($path)
{
    $out = '<a href="index.php">📦 root</a>';
    if ($path === '') return $out;
    $parts = explode('/', $path);
    $acc = '';
    foreach ($parts as $p) {
        $acc .= ($acc === '' ? '' : '/') . $p;
        $out .= ' / <a href="index.php?path=' . urlencode($acc) . '">' . htmlspecialchars($p) . '</a>';
    }
    return $out;
}

function humanSize($bytes)
{
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1024 * 1024) return round($bytes / 1024, 1) . ' KB';
    return round($bytes / (1024 * 1024), 1) . ' MB';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>File Manager - <?= htmlspecialchars(GITHUB_REPO) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
  <h1>🗂️ <?= htmlspecialchars(GITHUB_OWNER . '/' . GITHUB_REPO) ?> (<?= htmlspecialchars(GITHUB_BRANCH) ?>)</h1>
  <a href="logout.php">Logout</a>
</div>
<div class="container">

  <?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert alert-error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

  <div class="card">
    <div class="breadcrumb"><?= breadcrumb($path) ?></div>

    <div class="toolbar">
      <button class="btn btn-primary" onclick="document.getElementById('newFileForm').classList.toggle('hidden-form')">📄 File Baru</button>
      <button class="btn btn-primary" onclick="document.getElementById('newFolderForm').classList.toggle('hidden-form')">📁 Folder Baru</button>
      <button class="btn btn-green" onclick="document.getElementById('uploadForm').classList.toggle('hidden-form')">⬆️ Upload</button>
      <a class="btn" href="index.php?path=<?= urlencode($path) ?>">🔄 Refresh (pull)</a>
    </div>

    <form id="newFileForm" class="hidden-form" method="post" action="actions.php" style="margin-bottom:14px">
      <input type="hidden" name="action" value="create_file">
      <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
      <input type="text" name="name" placeholder="nama-file.txt" required>
      <button class="btn btn-primary btn-small" type="submit">Buat File</button>
    </form>

    <form id="newFolderForm" class="hidden-form" method="post" action="actions.php" style="margin-bottom:14px">
      <input type="hidden" name="action" value="create_folder">
      <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
      <input type="text" name="name" placeholder="nama-folder" required>
      <button class="btn btn-primary btn-small" type="submit">Buat Folder</button>
    </form>

    <form id="uploadForm" class="hidden-form" method="post" action="actions.php" enctype="multipart/form-data" style="margin-bottom:14px">
      <input type="hidden" name="action" value="upload">
      <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
      <input type="file" name="file" required>
      <button class="btn btn-green btn-small" type="submit">Upload</button>
    </form>

    <form method="post" action="actions.php" id="massForm">
      <input type="hidden" name="action" value="mass_delete">
      <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
      <table>
        <thead>
          <tr>
            <th><input type="checkbox" onclick="document.querySelectorAll('.chk').forEach(c=>c.checked=this.checked)"></th>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Ukuran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($items)): ?>
            <tr><td colspan="5" class="small">Folder ini kosong.</td></tr>
          <?php endif; ?>
          <?php foreach ($items as $item):
              $itemPath = $item['path'];
              $isDir = $item['type'] === 'dir';
              if ($item['name'] === '.gitkeep') continue;
          ?>
          <tr>
            <td><input class="chk" type="checkbox" name="items[]" value="<?= htmlspecialchars($itemPath) ?>|<?= $isDir ? 'dir' : 'file' ?>"></td>
            <td>
              <?php if ($isDir): ?>
                <a class="file-link folder" href="index.php?path=<?= urlencode($itemPath) ?>">📁 <?= htmlspecialchars($item['name']) ?></a>
              <?php else: ?>
                <a class="file-link" href="edit.php?path=<?= urlencode($itemPath) ?>">📄 <?= htmlspecialchars($item['name']) ?></a>
              <?php endif; ?>
            </td>
            <td><?= $isDir ? '<span class="badge">folder</span>' : 'file' ?></td>
            <td><?= $isDir ? '-' : humanSize($item['size'] ?? 0) ?></td>
            <td class="actions-row">
              <button type="button" class="btn btn-small" onclick="doRename('<?= htmlspecialchars(addslashes($itemPath)) ?>','<?= $isDir ? 'dir' : 'file' ?>','<?= htmlspecialchars(addslashes($item['name'])) ?>')">✏️ Rename</button>
              <form class="inline" method="post" action="actions.php" onsubmit="return confirm('Yakin hapus <?= htmlspecialchars(addslashes($item['name'])) ?>?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="target" value="<?= htmlspecialchars($itemPath) ?>|<?= $isDir ? 'dir' : 'file' ?>">
                <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
                <button type="submit" class="btn btn-danger btn-small">🗑️ Hapus</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="margin-top:14px">
        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus semua item yang dicentang? Aksi ini langsung push ke GitHub dan tidak bisa dibatalkan.')">🗑️ Mass Delete Terpilih</button>
      </div>
    </form>
  </div>
</div>

<form id="renameForm" method="post" action="actions.php" style="display:none">
  <input type="hidden" name="action" value="rename">
  <input type="hidden" name="path" value="<?= htmlspecialchars($path) ?>">
  <input type="hidden" name="old_path" id="renameOldPath">
  <input type="hidden" name="type" id="renameType">
  <input type="hidden" name="new_name" id="renameNewName">
</form>

<style>.hidden-form{display:none}</style>
<script>
function doRename(oldPath, type, currentName){
  const newName = prompt('Nama baru untuk "' + currentName + '":', currentName);
  if (!newName || newName.trim() === '' || newName === currentName) return;
  document.getElementById('renameOldPath').value = oldPath;
  document.getElementById('renameType').value = type;
  document.getElementById('renameNewName').value = newName.trim();
  document.getElementById('renameForm').submit();
}
</script>
</body>
</html>
