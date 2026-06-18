<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Harap login terlebih dahulu']);
    exit;
}

$user_id = $_SESSION['user_google_id'];
$today = date('Y-m-d');

// ========== CEK SUDAH BERAPA KOIN YANG DIAMBIL HARI INI ==========
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&status=eq.claimed&claimed_at=gte.' . urlencode($today . ' 00:00:00') . '&select=count');
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
$maxPerDay = 5;

if ($claimedToday >= $maxPerDay) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda sudah mengambil ' . $maxPerDay . ' koin hari ini. Coba lagi besok!',
        'claimed_today' => $claimedToday,
        'max_per_day' => $maxPerDay
    ]);
    exit;
}

// ========== CEK APAKAH ADA LINK PREMADE YANG BELUM DIGUNAKAN ==========
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links?used_by=eq.null&limit=1&order=id.asc');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$premade = json_decode($response, true);

if (empty($premade)) {
    echo json_encode([
        'success' => false,
        'message' => 'Tidak ada link premade tersedia. Hubungi admin.'
    ]);
    exit;
}

$link = $premade[0];
$linkId = $link['id'];
$claim_url = $link['url']; // Link premade sudah dalam bentuk shortened

// ========== TANDAI LINK SUDAH DIGUNAKAN ==========
$updateData = json_encode([
    'used_by' => $user_id,
    'used_at' => date('Y-m-d H:i:s'),
    'status' => 'claimed'
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links?id=eq.' . $linkId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PATCH, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

// ========== TAMBAH KOIN KE USER ==========
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

// ========== KIRIM RESPONSE ==========
$remaining = $maxPerDay - ($claimedToday + 1);

echo json_encode([
    'success' => true,
    'url' => $claim_url,
    'claimed_today' => $claimedToday + 1,
    'max_per_day' => $maxPerDay,
    'remaining' => $remaining,
    'message' => 'Koin berhasil diambil! Sisa ' . $remaining . ' koin hari ini.'
]);
?>
