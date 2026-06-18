<?php
// cron/refill-coin-links.php
// Jalankan setiap 5 menit via cron job

require_once '../config.php';

function refillCoinLinks() {
    // Ambil semua user_id yang punya pending link kurang dari 10
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?select=user_id,count&status=eq.pending&group_by=user_id');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    $users = [];
    foreach ($data as $row) {
        if ($row['count'] < 10) {
            $users[] = [
                'user_id' => $row['user_id'],
                'count' => $row['count']
            ];
        }
    }
    
    // Generate link untuk setiap user yang kurang
    foreach ($users as $user) {
        $toGenerate = 10 - $user['count'];
        for ($i = 0; $i < $toGenerate; $i++) {
            $unique_token = bin2hex(random_bytes(16));
            $data = json_encode([
                'token' => $unique_token,
                'user_id' => $user['user_id'],
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'apikey: ' . SUPABASE_KEY,
                'Authorization: Bearer ' . SUPABASE_KEY
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
        }
        
        echo "Refilled links for user {$user['user_id']}: +{$toGenerate} links\n";
    }
}

echo "[" . date('Y-m-d H:i:s') . "] Running refill...\n";
refillCoinLinks();
echo "[" . date('Y-m-d H:i:s') . "] Done\n";
?>
