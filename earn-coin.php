<?php
session_start();
require_once 'config.php';

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

// Set flag: boleh klaim coin sekali setelah balik dari SFL
$_SESSION['earn_flag'] = true;
$_SESSION['earn_flag_time'] = time(); // timestamp untuk expiry 10 menit

// URL random yang dibungkus safelinku
// Generate random target URL yang tidak abuse-able
$random_targets = [
    'https://www.wikipedia.org/wiki/Special:Random',
    'https://www.google.com/search?q=polar+whatsapp+bot',
    'https://polar.web.id',
    'https://www.google.com/search?q=whatsapp+bot+gratis',
    'https://www.wikipedia.org/wiki/WhatsApp',
];
$target = $random_targets[array_rand($random_targets)];

// Bungkus dengan Safelinku
// Format: https://safelinku.com/st?api=API_KEY&url=TARGET_URL&alias=ALIAS
// Ganti SAFELINKU_API_KEY dengan API key kamu
$safelinku_api = 'SAFELINKU_API_KEY_DISINI';
$return_url = 'https://polar.web.id/dashboard.php#earn-coin';

// Build safelinku URL (pakai redirect destination ke dashboard.php#earn-coin)
// Safelinku format: user klik link → lihat iklan → redirect ke URL tujuan
$encoded_return = urlencode($return_url);
$encoded_target = urlencode($target);

// Kalau pakai Safelinku API untuk generate link dinamis:
$sfl_api_url = "https://safelinku.com/api?api={$safelinku_api}&url={$encoded_return}&format=text";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sfl_api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 8);
$sfl_response = curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

// Jika API Safelinku berhasil
if ($sfl_response && filter_var(trim($sfl_response), FILTER_VALIDATE_URL)) {
    $sfl_url = trim($sfl_response);
} else {
    // Fallback: pakai link safelinku yang sudah di-generate manual
    // Ganti ini dengan link SFL kamu yang sudah dibuat di dashboard Safelinku
    $sfl_url = 'https://safelinku.com/polar-earn'; // <- ganti dengan link SFL kamu
}

echo json_encode([
    'success' => true,
    'url' => $sfl_url
]);
