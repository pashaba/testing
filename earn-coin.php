<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Harap login terlebih dahulu']);
    exit;
}

$user_id = $_SESSION['user_google_id'];

// ========== FUNGSI GENERATE LINK ==========
function generateCoinLink($user_id) {
    $unique_token = bin2hex(random_bytes(16));
    $claim_url = "https://polar.web.id/claim-coin.php?token=" . $unique_token;
    
    // Simpan ke Supabase dengan status 'pending'
    $data = json_encode([
        'token' => $unique_token,
        'user_id' => $user_id,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Prefer: return=representation'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// ========== FUNGSI SHORTEN LINK KE SAFELINK ==========
function shortenLink($claim_url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://safelinku.com/api/v1/links");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $claim_url]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . SAFELINKU_API_KEY,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $result = json_decode($response, true);
        return $result['shortened_url'] ?? $result['url'] ?? null;
    }
    return null;
}

// ========== CEK DAN ISI ANTRIAN LINK ==========
function ensureLinkQueue($user_id) {
    // Cek berapa link pending yang tersedia
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&status=eq.pending&select=count');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    $pendingCount = $data[0]['count'] ?? 0;
    
    // Jika kurang dari 10, generate sampai 10
    $targetCount = 10;
    if ($pendingCount < $targetCount) {
        $toGenerate = $targetCount - $pendingCount;
        for ($i = 0; $i < $toGenerate; $i++) {
            generateCoinLink($user_id);
        }
    }
}

// ========== AMBIL SATU LINK UNTUK USER ==========
function getPendingLink($user_id) {
    // Ambil 1 link pending
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&status=eq.pending&limit=1&order=created_at.asc');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (empty($data)) {
        // Jika tidak ada, generate satu
        generateCoinLink($user_id);
        // Ambil lagi
        return getPendingLink($user_id);
    }
    
    return $data[0];
}

// ========== PROSES UTAMA ==========
// 1. Pastikan antrian link selalu 10
ensureLinkQueue($user_id);

// 2. Ambil 1 link untuk user
$link = getPendingLink($user_id);

if (!$link) {
    echo json_encode(['success' => false, 'message' => 'Gagal mendapatkan link, coba lagi']);
    exit;
}

$claim_url = "https://polar.web.id/claim-coin.php?token=" . $link['token'];

// 3. Shorten link (opsional, jika gagal pakai link langsung)
$shortUrl = shortenLink($claim_url);
if (!$shortUrl) {
    $shortUrl = $claim_url;
}

// 4. Update status link menjadi 'processing' (sedang diproses)
$updateData = json_encode(['status' => 'processing']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?id=eq.' . $link['id']);
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

// 5. Generate 1 link baru untuk menggantikan yang diambil
generateCoinLink($user_id);

// 6. Kirim response
echo json_encode([
    'success' => true,
    'url' => $shortUrl,
    'token' => $link['token'],
    'remaining' => 'Link akan otomatis diisi ulang'
]);
?>
