<?php
// earn-coin.php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Harap login terlebih dahulu']);
    exit;
}

$user_id = $_SESSION['user_google_id'];
$today = date('Y-m-d');

// ========== CEK LIMIT 5 PER HARI ==========
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&date=eq.' . $today . '&select=count');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$claimedToday = $data[0]['count'] ?? 0;

if ($claimedToday >= 5) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda sudah mengambil 5 Polar Coin hari ini. Coba lagi besok! 🪙'
    ]);
    exit;
}

// ========== SET SESSION FLAG ==========
$_SESSION['can_claim'] = true;
$_SESSION['claim_user'] = $user_id;
$_SESSION['claim_time'] = time();

// ========== SIMPAN RECORD PENDING ==========
$insertData = json_encode([
    'user_id' => $user_id,
    'date' => $today,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $insertData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

// ========== REDIRECT KE SAFELINK ==========
// Ganti dengan link Safelink Anda
$safelink_url = 'https://sfl.gl/ooVeddtK'; // ← GANTI DENGAN LINK SAFELINK ANDA

echo json_encode([
    'success' => true,
    'url' => $safelink_url,
    'message' => '🪙 Klik link untuk dapat Polar Coin!'
]);
?>
