<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$google_id = $_SESSION['user_google_id'];
$sb_url = rtrim($SUPABASE_URL, '/');
$sb_key = $SUPABASE_KEY;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sb_url . '/rest/v1/polar_users?google_id=eq.' . urlencode($google_id) . '&select=coins');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $sb_key,
    'Authorization: Bearer ' . $sb_key
]);
$raw = curl_exec($ch);
curl_close($ch);

$data = json_decode($raw, true);
$coins = (!empty($data) && isset($data[0]['coins'])) ? (int)$data[0]['coins'] : 0;

// sinkronkan session juga biar konsisten
$_SESSION['user_coins'] = $coins;

echo json_encode(['success' => true, 'coins' => $coins]);
?>
