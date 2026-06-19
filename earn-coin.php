<?php
session_start();
require_once 'config.php';

// Harus sudah login
if (!isset($_SESSION['user_google_id'])) {
    header('Location: dashboard.php');
    exit;
}

define('MIN_WAIT_SECONDS', 8);   // minimal waktu sejak klik sampai boleh klaim (anti bypass)
define('MAX_WAIT_SECONDS', 600); // expiry 10 menit

// ===== Flag sedang aktif (user sudah pernah klik Earn Coin) =====
if (!empty($_SESSION['earn_flag'])) {

    $elapsed = time() - ($_SESSION['earn_flag_time'] ?? 0);

    // Sudah kelamaan (>10 menit) → flag expired, hapus dan minta mulai ulang
    if ($elapsed > MAX_WAIT_SECONDS) {
        unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);
        header('Location: dashboard.php?earn=expired');
        exit;
    }

    // Belum cukup lama (user belum mungkin selesai nonton SFL) → JANGAN kasih coin
    // Paksa balik lagi ke SFL, jangan pernah sampai ke dashboard dengan coin
    if ($elapsed < MIN_WAIT_SECONDS) {
        header('Location: https://safelinku.com/polar-earn');
        exit;
    }

    // Lolos time-gate → baru sah dianggap balik dari SFL → hapus flag DULU (anti double claim)
    unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);

    // Tambah coin
    $_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

    header('Location: dashboard.php?earn=success&coins=' . $_SESSION['user_coins']);
    exit;
}

// ===== Belum ada flag → ini klik pertama → set flag → redirect ke SFL =====
$_SESSION['earn_flag'] = true;
$_SESSION['earn_flag_time'] = time();

// Ganti URL ini dengan link SFL kamu (destination-nya ke polar.web.id/earn-coin.php)
header('Location: https://sfl.gl/tNNrdyA');
exit;
