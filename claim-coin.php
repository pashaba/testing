<?php
// claim-coin.php - Redirect ke link premade
// Ini sebenarnya tidak perlu karena link premade langsung diarahkan ke user

// Tapi kalau tetap mau pakai claim-coin.php sebagai perantara:

$token = $_GET['token'] ?? '';

if (!$token) {
    die('Token tidak valid');
}

// Cek token di premade_links
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links?token=eq.' . urlencode($token) . '&select=url,used_by');
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
    die('Link tidak ditemukan');
}

$link = $data[0];

if ($link['used_by'] !== null) {
    die('Link sudah pernah digunakan');
}

// Redirect ke URL tujuan
header('Location: ' . $link['url']);
exit;
?>
