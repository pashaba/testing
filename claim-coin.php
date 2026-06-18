<?php
// claim-coin.php - FIX ERROR 500
// Pastikan tidak ada output sebelum session_start()

// Matikan error display di production, aktifkan di development
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Session harus di awal, sebelum output apapun
session_start();

// Include config
require_once 'config.php';

// ========== FUNGSI CURL KE SUPABASE ==========
function supabaseRequest($method, $endpoint, $body = null) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    
    // Gunakan konstanta dari config jika ada
    if (!isset($SUPABASE_URL)) {
        $SUPABASE_URL = 'https://xcxciixqhmghitmyigbj.supabase.co';
    }
    if (!isset($SUPABASE_KEY)) {
        $SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhjeGNpaXhxaG1naGl0bXlpZ2JqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODU2MzQ2MCwiZXhwIjoyMDk0MTM5NDYwfQ.Tzg34ww9r2X2WrZ9wcYoajoQUjUfRkOxnsdARskfvJE';
    }
    
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
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'data' => json_decode($response, true),
        'error' => $error
    ];
}

// ========== CEK FLAG ==========
if (!isset($_SESSION['can_claim']) || $_SESSION['can_claim'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak — Polar.id</title>
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
            .icon { font-size: 64px; margin-bottom: 16px; }
            h1 { font-size: 24px; font-weight: 900; margin-bottom: 8px; color: #ef4444; }
            p { color: #8b8b9b; font-size: 14px; margin-bottom: 20px; line-height: 1.6; }
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
            .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.3); }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">🚫</div>
            <h1>Akses Ditolak</h1>
            <p>Silakan klik <strong>"EARN POLAR COIN"</strong> terlebih dahulu di dashboard.</p>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== CEK EXPIRED ==========
if (isset($_SESSION['claim_time']) && (time() - $_SESSION['claim_time']) > 600) {
    $_SESSION['can_claim'] = false;
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sesi Kedaluwarsa — Polar.id</title>
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
            .icon { font-size: 64px; margin-bottom: 16px; }
            h1 { font-size: 24px; font-weight: 900; margin-bottom: 8px; color: #f59e0b; }
            p { color: #8b8b9b; font-size: 14px; margin-bottom: 20px; line-height: 1.6; }
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
            .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.3); }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">⏰</div>
            <h1>Sesi Kedaluwarsa</h1>
            <p>Waktu claim sudah habis (10 menit). Klik <strong>"EARN POLAR COIN"</strong> lagi.</p>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== CEK LOGIN ==========
if (!isset($_SESSION['user_google_id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Harap Login — Polar.id</title>
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
            .icon { font-size: 64px; margin-bottom: 16px; }
            h1 { font-size: 24px; font-weight: 900; margin-bottom: 8px; color: #3b82f6; }
            p { color: #8b8b9b; font-size: 14px; margin-bottom: 20px; line-height: 1.6; }
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
            .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.3); }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">🔐</div>
            <h1>Harap Login</h1>
            <p>Silakan login terlebih dahulu untuk mengklaim Polar Coin.</p>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Login</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== PROSES KLAIM ==========
$user_id = $_SESSION['user_google_id'];
$today = date('Y-m-d');

// CEK LIMIT 5 PER HARI
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&date=eq.' . $today . '&select=count');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$claimedToday = $data[0]['count'] ?? 0;

if ($claimedToday >= 5) {
    $_SESSION['can_claim'] = false;
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Limit Tercapai — Polar.id</title>
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
            .icon { font-size: 64px; margin-bottom: 16px; }
            h1 { font-size: 24px; font-weight: 900; margin-bottom: 8px; color: #ef4444; }
            p { color: #8b8b9b; font-size: 14px; margin-bottom: 20px; line-height: 1.6; }
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
            .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.3); }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">🛑</div>
            <h1>Limit Tercapai!</h1>
            <p>Anda sudah mengambil <strong>5 Polar Coin</strong> hari ini. Coba lagi besok! 🪙</p>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== UPDATE STATUS CLAIM ==========
$updateData = json_encode([
    'status' => 'claimed',
    'claimed_at' => date('Y-m-d H:i:s')
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?user_id=eq.' . urlencode($user_id) . '&date=eq.' . $today . '&status=eq.pending&limit=1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PATCH, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $updateData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'apikey: ' . SUPABASE_KEY,
    'Authorization: Bearer ' . SUPABASE_KEY
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

// ========== TAMBAH KOIN ==========
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

// ========== MATIKAN FLAG ==========
$_SESSION['can_claim'] = false;

$remaining = 5 - ($claimedToday + 1);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>+1 Polar Coin! 🪙</title>
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
        .remaining { font-size: 13px; color: #8b8b9b; margin-bottom: 20px; }
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
        .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255,107,0,0.3); }
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
        .btn-secondary:hover { background: rgba(255,255,255,0.08); color: white; }
        .confetti-container {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 999;
            overflow: hidden;
        }
        .confetti-piece {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 2px;
            animation: confettiFall 2s ease forwards;
        }
        @keyframes confettiFall {
            0% { opacity: 1; transform: translateY(0) rotate(0deg); }
            100% { opacity: 0; transform: translateY(300px) rotate(720deg); }
        }
    </style>
</head>
<body>
    <div class="card" id="claimCard">
        <!-- Loading State -->
        <div id="loadingState">
            <div style="margin-bottom:16px;">
                <div class="spinner" style="width:32px;height:32px;border:3px solid rgba(255,255,255,0.1);border-top-color:#ffcc00;border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto;"></div>
            </div>
            <h2 style="font-size:20px;font-weight:700;">Memproses...</h2>
            <p style="color:#8b8b9b;">Mohon tunggu sebentar</p>
        </div>

        <!-- Success State -->
        <div id="successState" style="display:none;">
            <div class="icon">🪙</div>
            <h1>+1 <span>Polar Coin</span></h1>
            <p>Polar Coin berhasil ditambahkan ke akun Anda!</p>
            <div class="coin-display">
                <?= $_SESSION['user_coins'] ?? 0 ?> 🪙
            </div>
            <div class="remaining">
                <?php if ($remaining > 0): ?>
                    Sisa claim hari ini: <strong style="color:#ffcc00;"><?= $remaining ?></strong> lagi
                <?php else: ?>
                    🎉 Anda sudah mencapai limit 5 Polar Coin hari ini!
                <?php endif; ?>
            </div>
            <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali ke Dashboard</a>
            <br>
            <a href="dashboard.php" class="btn-secondary">🔄 Refresh</a>
        </div>
    </div>

    <script>
        // ===== CONFETTI EFFECT =====
        function launchConfetti() {
            const colors = ['#ffcc00', '#FF6B00', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6', '#ec4899'];
            const container = document.createElement('div');
            container.className = 'confetti-container';
            for (let i = 0; i < 60; i++) {
                const piece = document.createElement('div');
                piece.className = 'confetti-piece';
                piece.style.cssText = `
                    left: ${Math.random() * 100}%;
                    top: ${-10 + Math.random() * 10}%;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    width: ${5 + Math.random() * 8}px;
                    height: ${5 + Math.random() * 8}px;
                    border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
                    animation-delay: ${Math.random() * 0.8}s;
                    animation-duration: ${1.5 + Math.random() * 1.5}s;
                `;
                container.appendChild(piece);
            }
            document.body.appendChild(container);
            setTimeout(() => container.remove(), 3000);
        }

        // ===== ANIMASI LOADING → SUCCESS =====
        document.addEventListener('DOMContentLoaded', function() {
            const loading = document.getElementById('loadingState');
            const success = document.getElementById('successState');
            
            // Tampilkan loading 1.5 detik
            setTimeout(() => {
                loading.style.display = 'none';
                success.style.display = 'block';
                launchConfetti();
            }, 1500);
        });
    </script>
</body>
</html>
