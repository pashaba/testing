<?php
// generate-premade-links.php
// Jalankan sekali untuk membuat 5 link premade di Supabase
// Atau jalankan saat ingin menambah link baru

require_once 'config.php';

// ========== DAFTAR LINK SAFELINK YANG SUDAH ANDA BUAT ==========
// Ganti dengan 5 link Safelink yang berbeda
$premade_urls = [
    'https://safelinku.com/xxxxx1', // Ganti dengan link Safelink 1
    'https://safelinku.com/xxxxx2', // Ganti dengan link Safelink 2
    'https://safelinku.com/xxxxx3', // Ganti dengan link Safelink 3
    'https://safelinku.com/xxxxx4', // Ganti dengan link Safelink 4
    'https://safelinku.com/xxxxx5'  // Ganti dengan link Safelink 5
];

$added = 0;
$errors = 0;

echo "<h1>Generate Premade Links</h1>";
echo "<pre>";

foreach ($premade_urls as $url) {
    $url = trim($url);
    if (empty($url)) continue;
    
    $token = 'PC_' . strtoupper(bin2hex(random_bytes(8)));
    
    $data = json_encode([
        'token' => $token,
        'url' => $url,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links');
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
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $result = json_decode($response, true);
        echo "✅ Added: " . ($result[0]['token'] ?? $token) . " → " . $url . "\n";
        $added++;
    } else {
        echo "❌ Failed: " . $url . " (HTTP " . $httpCode . ")\n";
        $errors++;
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Total added: " . $added . "\n";
echo "❌ Errors: " . $errors . "\n";
echo "</pre>";

// Cek total link yang tersedia
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/premade_links?used_by=eq.null&select=count');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$available = $data[0]['count'] ?? 0;

echo "<p style='font-size:16px;font-weight:bold;'>📊 Total link premade tersedia: <span style='color:#ffcc00;'>" . $available . "</span></p>";
echo "<p><a href='dashboard.php'>← Kembali ke Dashboard</a></p>";
?>
