<?php
// config-google.php
session_start();

define('GOOGLE_CLIENT_ID', '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'https://polar.web.id/auth-google.php');

// Daftar email yang diizinkan (kosongkan untuk mengizinkan semua)
$ALLOWED_EMAILS = [
    // 'emailanda@gmail.com',
    // 'emailcadangan@gmail.com'
];

// Konfigurasi Safelink API
define('SAFELINK_API_URL', 'https://safelinku.com/api/v1/links');
define('SAFELINK_API_TOKEN', '1d7a39e84c46ddf4ab3a1050f707e1cf57bc7bd4');
define('BASE_URL', 'https://polar.web.id');

// Harga paket Jadibot dalam koin
$PACKAGES = [
    ['days' => 1, 'coin' => 1, 'label' => '1 Hari'],
    ['days' => 2, 'coin' => 2, 'label' => '2 Hari'],
    ['days' => 5, 'coin' => 4, 'label' => '5 Hari (Hemat)'],
    ['days' => 14, 'coin' => 10, 'label' => '14 Hari (Best Value)']
];

// Fungsi untuk mendapatkan user dari session
function getUserInfo() {
    if (isset($_SESSION['user_email'])) {
        return [
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'] ?? 'User',
            'picture' => $_SESSION['user_picture'] ?? '',
            'coins' => $_SESSION['user_coins'] ?? 0
        ];
    }
    return null;
}

// Fungsi untuk update koin user
function updateUserCoins($email, $amount) {
    // Simpan ke database atau session
    if (!isset($_SESSION['user_coins'])) $_SESSION['user_coins'] = 0;
    $_SESSION['user_coins'] += $amount;
    
    // Bisa juga simpan ke Supabase
    // supabase('PATCH', 'users?email=eq.'.$email, ['coins' => $_SESSION['user_coins']]);
}
?>
