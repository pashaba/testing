<?php
session_start();
require_once 'config.php';

// Harus sudah login
if (!isset($_SESSION['user_google_id'])) {
    header('Location: dashboard.php');
    exit;
}

// ===== TAHAP 2: Balik dari SFL, flag sudah ON → kasih coin =====
if (!empty($_SESSION['earn_flag'])) {

    // Cek expiry 10 menit
    if (time() - ($_SESSION['earn_flag_time'] ?? 0) > 600) {
        unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);
        header('Location: dashboard.php?earn=expired');
        exit;
    }

    // Hapus flag DULU (anti double claim)
    unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);

    // Tambah coin
    $_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

    // Redirect ke dashboard dengan notif sukses
    header('Location: dashboard.php?earn=success&coins=' . $_SESSION['user_coins']);
    exit;
}

// ===== TAHAP 1: Pertama kali klik → set flag → redirect ke SFL =====
$_SESSION['earn_flag'] = true;
$_SESSION['earn_flag_time'] = time();

// Ganti URL ini dengan link SFL kamu (destination-nya ke polar.web.id/earn-coin.php)
header('Location: https://sfl.gl/tNNrdyA');
exit;
