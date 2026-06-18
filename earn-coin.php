<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Harus sudah login
if (!isset($_SESSION['user_google_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Belum login']);
    exit;
}

// Cek apakah sudah ada flag aktif (belum dipakai)
if (!empty($_SESSION['earn_flag'])) {
    echo json_encode(['success' => false, 'message' => 'Sudah ada earn yang sedang berjalan']);
    exit;
}

// Set flag
$_SESSION['earn_flag'] = true;
$_SESSION['earn_flag_time'] = time();

// Ganti dengan link SFL kamu di bawah ini (baris 18)
$sfl_url = 'https://sfl.gl/HrOL7';

echo json_encode(['success' => true, 'url' => $sfl_url]);
