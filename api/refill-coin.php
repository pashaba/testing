<?php
// api/refill-coin.php
// Endpoint untuk mengisi ulang antrian link coin
// Panggil dari cron-job.org setiap 5 menit

require_once '../config.php';

// Secret key untuk keamanan (ganti dengan kunci rahasia Anda)
define('CRON_SECRET', 'pashapro');

// Cek secret key
$secret = $_GET['secret'] ?? '';
if ($secret !== CRON_SECRET) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

header('Content-Type: application/json');

function refillCoinLinks() {
    global $SUPABASE_URL, $SUPABASE_KEY;
    
    // Ambil semua user_id yang punya pending link kurang dari 10
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $SUPABASE_URL . '/rest/v1/coin_claims?select=user_id,count&status=eq.pending');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    // Group by user_id
    $userCounts = [];
    foreach ($data as $row) {
        $uid = $row['user_id'];
        if (!isset($userCounts[$uid])) {
            $userCounts[$uid] = 0;
        }
        $userCounts[$uid]++;
    }
    
    $generated = 0;
    foreach ($userCounts as $user_id => $count) {
        if ($count < 10) {
            $toGenerate = 10 - $count;
            for ($i = 0; $i < $toGenerate; $i++) {
                $unique_token = bin2hex(random_bytes(16));
                $data = json_encode([
                    'token' => $unique_token,
                    'user_id' => $user_id,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $SUPABASE_URL . '/rest/v1/coin_claims');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'apikey: ' . $SUPABASE_KEY,
                    'Authorization: Bearer ' . $SUPABASE_KEY
                ]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_exec($ch);
                curl_close($ch);
                $generated++;
            }
        }
    }
    
    return [
        'success' => true,
        'generated' => $generated,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

$result = refillCoinLinks();
echo json_encode($result);
?>
