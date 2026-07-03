<?php
require_once __DIR__ . '/config.php';
require_login();
require_once __DIR__ . '/GitHubClient.php';

$gh = new GitHubClient();
$path = trim($_POST['path'] ?? '', '/');
$action = $_POST['action'] ?? '';

function redirectBack($path, $msg = '', $err = '')
{
    $url = 'index.php?path=' . urlencode($path);
    if ($msg) $url .= '&msg=' . urlencode($msg);
    if ($err) $url .= '&err=' . urlencode($err);
    header('Location: ' . $url);
    exit;
}

switch ($action) {

    case 'create_file': {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') redirectBack($path, '', 'Nama file kosong.');
        $newPath = ($path === '' ? '' : $path . '/') . $name;
        $res = $gh->createOrUpdateFile($newPath, '', 'Buat file ' . $newPath . ' via web file manager');
        $res['ok']
            ? redirectBack($path, "File '$name' berhasil dibuat & push ke GitHub.")
            : redirectBack($path, '', 'Gagal buat file (HTTP ' . $res['code'] . ').');
        break;
    }

    case 'create_folder': {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') redirectBack($path, '', 'Nama folder kosong.');
        $newPath = ($path === '' ? '' : $path . '/') . $name;
        $res = $gh->createFolder($newPath, 'Buat folder ' . $newPath . ' via web file manager');
        $res['ok']
            ? redirectBack($path, "Folder '$name' berhasil dibuat & push ke GitHub.")
            : redirectBack($path, '', 'Gagal buat folder (HTTP ' . $res['code'] . ').');
        break;
    }

    case 'upload': {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            redirectBack($path, '', 'Upload gagal.');
        }
        $name = basename($_FILES['file']['name']);
        $tmp = $_FILES['file']['tmp_name'];
        $data = file_get_contents($tmp);
        $newPath = ($path === '' ? '' : $path . '/') . $name;
        $res = $gh->createOrUpdateFile($newPath, $data, 'Upload ' . $newPath . ' via web file manager');
        $res['ok']
            ? redirectBack($path, "File '$name' berhasil diupload & push ke GitHub.")
            : redirectBack($path, '', 'Gagal upload (HTTP ' . $res['code'] . ').');
        break;
    }

    case 'delete': {
        $target = $_POST['target'] ?? '';
        [$targetPath, $type] = array_pad(explode('|', $target, 2), 2, 'file');
        if ($type === 'dir') {
            $res = $gh->deleteFolder($targetPath, 'Hapus folder ' . $targetPath . ' via web file manager');
            $res['ok']
                ? redirectBack($path, "Folder berhasil dihapus & push ke GitHub.")
                : redirectBack($path, '', 'Gagal hapus folder: ' . implode('; ', $res['errors'] ?? []));
        } else {
            $fresh = $gh->getFile($targetPath);
            if (!$fresh['ok']) redirectBack($path, '', 'Gagal ambil sha file untuk dihapus.');
            $res = $gh->deleteFile($targetPath, 'Hapus ' . $targetPath . ' via web file manager', $fresh['data']['sha']);
            $res['ok']
                ? redirectBack($path, "File berhasil dihapus & push ke GitHub.")
                : redirectBack($path, '', 'Gagal hapus file (HTTP ' . $res['code'] . ').');
        }
        break;
    }

    case 'mass_delete': {
        $items = $_POST['items'] ?? [];
        if (empty($items)) redirectBack($path, '', 'Tidak ada item yang dicentang.');
        $errors = [];
        $count = 0;
        foreach ($items as $entry) {
            [$targetPath, $type] = array_pad(explode('|', $entry, 2), 2, 'file');
            if ($type === 'dir') {
                $res = $gh->deleteFolder($targetPath, 'Mass delete folder ' . $targetPath . ' via web file manager');
                if ($res['ok']) $count++; else $errors[] = $targetPath;
            } else {
                $fresh = $gh->getFile($targetPath);
                if (!$fresh['ok']) { $errors[] = $targetPath; continue; }
                $res = $gh->deleteFile($targetPath, 'Mass delete ' . $targetPath . ' via web file manager', $fresh['data']['sha']);
                if ($res['ok']) $count++; else $errors[] = $targetPath;
            }
        }
        $msg = "$count item berhasil dihapus & push ke GitHub.";
        $err = empty($errors) ? '' : ('Gagal hapus: ' . implode(', ', $errors));
        redirectBack($path, $msg, $err);
        break;
    }

    case 'rename': {
        $oldPath = trim($_POST['old_path'] ?? '', '/');
        $type = $_POST['type'] ?? 'file';
        $newName = trim($_POST['new_name'] ?? '');
        if ($oldPath === '' || $newName === '') redirectBack($path, '', 'Data rename tidak lengkap.');

        $parent = strpos($oldPath, '/') !== false ? substr($oldPath, 0, strrpos($oldPath, '/')) : '';
        $newPath = ($parent === '' ? '' : $parent . '/') . $newName;

        if ($type === 'dir') {
            $res = $gh->renameFolder($oldPath, $newPath, "Rename folder $oldPath -> $newPath via web file manager");
            $res['ok']
                ? redirectBack($path, "Folder berhasil di-rename & push ke GitHub.")
                : redirectBack($path, '', 'Gagal rename folder: ' . implode('; ', $res['errors'] ?? []));
        } else {
            $res = $gh->renameFile($oldPath, $newPath, "Rename $oldPath -> $newPath via web file manager");
            $res['ok']
                ? redirectBack($path, "File berhasil di-rename & push ke GitHub.")
                : redirectBack($path, '', 'Gagal rename file (HTTP ' . $res['code'] . ').');
        }
        break;
    }

    default:
        redirectBack($path, '', 'Aksi tidak dikenal.');
}
