<?php
session_start();
require_once 'config.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    die('Token tidak valid');
}

// Cek token di Supabase
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?token=eq.' . urlencode($token) . '&select=*');
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
    die('Token tidak ditemukan');
}

$claim = $data[0];

if ($claim['status'] === 'claimed') {
    die('Token sudah pernah diklaim');
}

// Update status jadi claimed
$updateData = json_encode(['status' => 'claimed', 'claimed_at' => date('Y-m-d H:i:s')]);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, SUPABASE_URL . '/rest/v1/coin_claims?id=eq.' . $claim['id']);
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

// Tambah koin ke user
$user_id = $claim['user_id'];
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['user_coins'] = ($_SESSION['user_coins'] ?? 0) + 1;

// Update juga di database user jika ada
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koin Berhasil Diklaim — Polar.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0f0f13;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #1c1c24;
            border: 1px solid #2a2a35;
            border-radius: 16px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .icon { font-size: 64px; margin-bottom: 16px; }
        h1 { font-size: 28px; font-weight: 900; margin-bottom: 8px; }
        h1 span { color: #ffcc00; }
        p { color: #8b8b9b; font-size: 14px; margin-bottom: 24px; }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #FF6B00;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(255,107,0,0.3); }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">🪙</div>
        <h1>+1 <span>Koin</span></h1>
        <p>Koin berhasil ditambahkan ke akun Anda!<br>Total koin Anda sekarang: <strong><?= $_SESSION['user_coins'] ?? 0 ?></strong></p>
        <a href="dashboard.php" class="btn"><i class="fas fa-arrow-right"></i> Kembali ke Dashboard</a>
    </div>
</body>
</html>
