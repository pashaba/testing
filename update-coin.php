<?php
session_start();
require_once 'config.php';

$amount = intval($_GET['amount'] ?? 0);

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'error' => 'not_logged_in']);
    exit;
}

$google_id = $_SESSION['user_google_id'];
$new_coins = max(0, ($_SESSION['user_coins'] ?? 0) + $amount);

// ===== Tulis ke Supabase =====
$sb_url = rtrim($SUPABASE_URL, '/');
$sb_key = $SUPABASE_KEY;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sb_url . '/rest/v1/polar_users?google_id=eq.' . urlencode($google_id));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['coins' => $new_coins]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . $sb_key,
    'Authorization: Bearer ' . $sb_key,
    'Prefer: return=minimal'
]);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Kalau gagal update Supabase, jangan bohongin session juga
if ($httpCode < 200 || $httpCode >= 300) {
    echo json_encode(['success' => false, 'error' => 'supabase_update_failed']);
    exit;
}

$_SESSION['user_coins'] = $new_coins;

echo json_encode(['success' => true, 'coins' => $new_coins]);
?>
