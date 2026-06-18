<?php
require_once 'config.php';

if (!is_logged_in()) {
    die("Harap login terlebih dahulu.");
}

$user_id = $_SESSION['user_google_id'];
$unique_token = bin2hex(random_bytes(16)); // Generate token unik
$claim_url = "https://polar.web.id/claim-coin.php?token=" . $unique_token;

// 1. Simpan token ke Supabase dengan status 'pending' (Gunakan fungsi cURL Supabase Anda)
$data = json_encode(['token' => $unique_token, 'user_id' => $user_id, 'status' => 'pending']);
// CONTOH EKSEKUSI (Sesuaikan dengan fungsi curl Anda):
// supabaseRequest('POST', 'coin_claims', $data);

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

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result['url'])) {
    // Redirect user ke link SafelinkU
    header("Location: " . $result['url']);
    exit();
} else {
    echo "Gagal membuat link. Coba lagi nanti.";
}
?>
