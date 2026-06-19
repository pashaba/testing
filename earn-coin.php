<?php
session_start();
require_once 'config.php';

// Harus sudah login
if (!isset($_SESSION['user_google_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Flag ON (user beneran lewat SFL) → kasih coin, lalu langsung matikan flag
if (!empty($_SESSION['earn_flag'])) {
    unset($_SESSION['earn_flag']);

    $_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

    header('Location: dashboard.php?earn=success&coins=' . $_SESSION['user_coins']);
    exit;
}

// Flag OFF (akses ulang / abuse / akses langsung tanpa lewat SFL) → tidak ada coin
header('Location: dashboard.php');
exit;
