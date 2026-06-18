<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Harap login terlebih dahulu']);
    exit;
}

$user_id = $_SESSION['user_google_id'];
$unique_token = bin2hex(random_bytes(16));
$claim_url = "https://polar.web.id/claim-coin.php?token=" . $unique_token;

// 1. Simpan token ke Supabase
$data = json_encode([
    'token' => $unique_token,
    'user_id' => $user_id,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
]);

// Gunakan fungsi supabaseRequest atau curl langsung
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

// 2. Tembak API SafelinkU
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
    if (isset($result['url']) || isset($result['shortened_url'])) {
        $shortUrl = $result['shortened_url'] ?? $result['url'] ?? $claim_url;
        echo json_encode(['success' => true, 'url' => $shortUrl]);
        exit;
    }
}

// Fallback: kirim link langsung
echo json_encode(['success' => true, 'url' => $claim_url]);
?>
