<?php
// claim-coin.php
// Wajib di awal, sebelum output apapun
error_reporting(E_ALL);
ini_set('display_errors', 0); // Matikan display error di production

session_start();
require_once 'config.php';

// ========== KONFIGURASI ==========
$SUPABASE_URL = 'https://xcxciixqhmghitmyigbj.supabase.co';
$SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhjeGNpaXhxaG1naGl0bXlpZ2JqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODU2MzQ2MCwiZXhwIjoyMDk0MTM5NDYwfQ.Tzg34ww9r2X2WrZ9wcYoajoQUjUfRkOxnsdARskfvJE';

// ========== FUNGSI CURL KE SUPABASE ==========
function supabaseRequest($method, $endpoint, $body = null) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    $url = $SUPABASE_URL . '/rest/v1/' . $endpoint;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ]);
    if ($body) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'data' => json_decode($response, true)];
}

// ========== AMBIL TOKEN ==========
$token = $_GET['token'] ?? '';

if (!$token) {
    die('❌ Token tidak valid');
}

// ========== VALIDASI 1: Cek token di database ==========
$result = supabaseRequest('GET', 'premade_links?token=eq.' . urlencode($token) . '&select=*');
$data = $result['data'];

if (empty($data) || $result['code'] !== 200) {
    die('❌ Token tidak ditemukan di database');
}

$link = $data[0];

// ========== VALIDASI 2: Cek sudah dipakai ==========
if ($link['used_by'] !== null) {
    die('❌ Token sudah pernah digunakan');
}

// ========== VALIDASI 3: Cek login ==========
if (!isset($_SESSION['user_google_id'])) {
    die('❌ Silakan login terlebih dahulu');
}

$user_id = $_SESSION['user_google_id'];
$today = date('Y-m-d');

// ========== VALIDASI 4: Cek limit 5 per hari ==========
$countResult = supabaseRequest('GET', 'premade_links?used_by=eq.' . urlencode($user_id) . '&used_at=gte.' . urlencode($today . ' 00:00:00') . '&select=count');
$countData = $countResult['data'];
$claimedToday = $countData[0]['count'] ?? 0;

if ($claimedToday >= 5) {
    die('❌ Anda sudah mengambil 5 Polar Coin hari ini. Coba lagi besok! 🪙');
}

// ========== PROSES KLAIM ==========
// 1. Tandai token sudah dipakai
$updateData = [
    'used_by' => $user_id,
    'used_at' => date('Y-m-d H:i:s'),
    'status' => 'claimed'
];
$updateResult = supabaseRequest('PATCH', 'premade_links?id=eq.' . $link['id'], $updateData);

if ($updateResult['code'] !== 200) {
    die('❌ Gagal memproses klaim, coba lagi');
}

// 2. Tambah koin ke session
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;
$remaining = 5 - ($claimedToday + 1);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polar Coin Berhasil Diklaim! 🪙</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0a0a0f;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: radial-gradient(circle at 50% 50%, rgba(255,107,0,0.05) 0%, transparent 50%);
        }
        .card {
            background: #14141e;
            border: 1px solid #2a2a35;
            border-radius: 20px;
            padding: 48px 36px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon { font-size: 72px; margin-bottom: 16px; animation: bounce 1s ease infinite; }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        h1 { font-size: 28px; font-weight: 900; margin-bottom: 8px; }
        h1 span { color: #ffcc00; }
        p { color: #8b8b9b; font-size: 14px; margin-bottom: 8px; line-height: 1.6; }
        .coin-display {
            font-size: 48px;
            font-weight: 900;
            color: #ffcc00;
            margin: 16px 0;
            background: rgba(255,204,0,0.05);
            padding: 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,204,0,0.1);
        }
        .remaining {
            font-size: 13px;
            color: #8b8b9b;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #FF6B00, #e05e00);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255,107,0,0.3);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.05);
            border: 1px solid #2a2a35;
            margin-top: 10px;
            display: inline-block;
            padding: 12px 28px;
            color: #8b8b9b;
            text-decoration: none;
            border-radius: 12px;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }
        .token-info {
            font-size: 11px;
            color: #4a4a55;
            margin-top: 16px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🪙</div>
        <h1>+1 <span>Polar Coin</span></h1>
        <p>Polar Coin berhasil ditambahkan ke akun Anda!</p>
        
        <div class="coin-display">
            <?= $_SESSION['user_coins'] ?? 0 ?> 🪙
        </div>
        
        <div class="remaining">
            <?php if ($remaining > 0): ?>
                Sisa claim hari ini: <strong style="color: #ffcc00;"><?= $remaining ?></strong> lagi
            <?php else: ?>
                🎉 Anda sudah mencapai limit 5 Polar Coin hari ini!
            <?php endif; ?>
        </div>
        
        <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali ke Dashboard</a>
        <br>
        <a href="dashboard.php" class="btn-secondary">🔄 Refresh halaman</a>
        
        <div class="token-info">
            Token: <?= htmlspecialchars($token) ?>
        </div>
    </div>
</body>
</html>
