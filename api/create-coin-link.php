<?php
require_once '../config-google.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu']);
    exit;
}

$amount = 1; // 1 klik = 1 koin

$token = bin2hex(random_bytes(16));
$_SESSION['pending_tokens'][$token] = [
    'email' => $_SESSION['user_email'],
    'amount' => $amount,
    'created_at' => time(),
    'claimed' => false
];

$claim_url = BASE_URL . '/claim-coin.php?token=' . $token;

// Coba Safelink API, jika gagal pakai link langsung
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SAFELINK_API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . SAFELINK_API_TOKEN,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['url' => $claim_url]));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        $shortUrl = $data['shortened_url'] ?? $data['url'] ?? $claim_url;
        echo json_encode(['success' => true, 'short_url' => $shortUrl, 'original_url' => $claim_url]);
    } else {
        echo json_encode(['success' => true, 'short_url' => $claim_url, 'original_url' => $claim_url, 'warning' => 'Gagal shorten link']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => true, 'short_url' => $claim_url, 'original_url' => $claim_url]);
}
?>
