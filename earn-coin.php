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

// ========== HARDCODE 5 LINK SAFELINK ==========
$premade_links = [
    'https://sfl.gl/fdI2BtU',
    'https://sfl.gl/jEyc1yAV',
    'https://sfl.gl/UBJUPR',
    'https://sfl.gl/uzKT',
    'https://sfl.gl/fFTu'
];

// ========== CEK SUDAH BERAPA KOIN YANG DIAMBIL HARI INI ==========
// Simpan di session (atau bisa pakai database/file)
$claimKey = 'claimed_' . $user_id . '_' . $today;
$claimedToday = $_SESSION[$claimKey] ?? 0;
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

// ========== AMBIL LINK BERDASARKAN INDEX ==========
$index = $claimedToday; // 0,1,2,3,4
$claim_url = $premade_links[$index] ?? null;

if (!$claim_url) {
    echo json_encode([
        'success' => false,
        'message' => 'Tidak ada link tersedia. Hubungi admin.'
    ]);
    exit;
}

// ========== TAMBAH COUNTER ==========
$_SESSION[$claimKey] = $claimedToday + 1;
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

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
