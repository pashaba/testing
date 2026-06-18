<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Harus sudah login
if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login']);
    exit;
}

// Cek flag ada
if (empty($_SESSION['earn_flag'])) {
    echo json_encode(['success' => false, 'message' => 'Tidak ada earn yang valid. Klik Earn Coin dulu!']);
    exit;
}

// Cek expiry 10 menit (anti abuse: buka tab baru, tunggu lama baru klaim)
$flag_time = $_SESSION['earn_flag_time'] ?? 0;
if (time() - $flag_time > 600) {
    unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);
    echo json_encode(['success' => false, 'message' => 'Link kadaluarsa. Silakan earn coin lagi.']);
    exit;
}

// Flag valid → hapus flag DULU sebelum kasih coin (prevent double claim)
unset($_SESSION['earn_flag'], $_SESSION['earn_flag_time']);

// Tambah 1 coin ke session
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

// Kalau pakai Supabase untuk persistent coin, update di sini juga
// (opsional, uncomment kalau mau sync ke DB)
/*
$fingerprint = $_SESSION['fingerprint'] ?? '';
if ($fingerprint) {
    $new_coins = $_SESSION['user_coins'];
    $url = $SUPABASE_URL . '/rest/v1/polar_users?fingerprint=eq.' . urlencode($fingerprint);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['coins' => $new_coins]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY,
        'Prefer: return=minimal'
    ]);
    curl_exec($ch);
    curl_close($ch);
}
*/

echo json_encode([
    'success' => true,
    'coins' => $_SESSION['user_coins'],
    'message' => '+1 Polar Coin berhasil diklaim! 🪙'
]);
