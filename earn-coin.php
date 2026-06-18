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
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links?used_by=eq.' . urlencode($user_id) . '&used_at=gte.' . urlencode($today . ' 00:00:00') . '&select=count');
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
        'message' => 'Anda sudah mengambil ' . $maxPerDay . ' Polar Coin hari ini. Coba lagi besok! 🪙',
        'claimed_today' => $claimedToday,
        'max_per_day' => $maxPerDay
    ]);
    exit;
}

// ========== AMBIL 1 TOKEN YANG BELUM DIPAKAI ==========
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
$claim_url = $link['url']; // URL Safelink yang sudah dibuat

// ========== TANDAI LINK SEDANG DIPROSES (opsional) ==========
$updateData = json_encode([
    'status' => 'processing',
    'processing_at' => date('Y-m-d H:i:s')
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

// ========== KIRIM RESPONSE ==========
$remaining = $maxPerDay - ($claimedToday + 1);

echo json_encode([
    'success' => true,
    'url' => $claim_url,
    'claimed_today' => $claimedToday + 1,
    'max_per_day' => $maxPerDay,
    'remaining' => $remaining,
    'message' => '🪙 Polar Coin berhasil diambil! Sisa ' . $remaining . ' coin hari ini.'
]);
?>
