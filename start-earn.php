<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_google_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Set flag ON, lalu langsung redirect ke SFL — tidak ada cek/fallback apapun
$_SESSION['earn_flag'] = true;

// Ganti URL ini dengan link SFL kamu (destination-nya ke polar.web.id/earn-coin.php)
header('Location: https://sfl.gl/tNNrdyA');
exit;
