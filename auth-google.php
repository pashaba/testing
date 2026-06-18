<?php
// auth-google.php
session_start();
require_once 'config.php';

// Konfigurasi Google
$client_id = '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://polar.web.id/auth-google.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_google_id'])) {
    header('Location: dashboard.php');
    exit;
}

$code = $_GET['code'] ?? '';
$error = $_GET['error'] ?? '';

// Jika ada error dari Google
if ($error) {
    header('Location: dashboard.php?error=google_auth_failed');
    exit;
}

// Jika ada code, proses login
if ($code) {
    // Tukar code dengan access token
    $token_url = 'https://oauth2.googleapis.com/token';
    $post_data = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $token_data = json_decode($response, true);
    
    if (isset($token_data['access_token'])) {
        // Ambil info user dari Google
        $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userinfo_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token_data['access_token']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $user_response = curl_exec($ch);
        curl_close($ch);
        
        $user_data = json_decode($user_response, true);
        
        if (isset($user_data['id'])) {
            $_SESSION['user_google_id'] = $user_data['id'];
            $_SESSION['user_name'] = $user_data['name'] ?? 'User';
            $_SESSION['user_email'] = $user_data['email'] ?? '';
            $_SESSION['user_avatar'] = $user_data['picture'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user_data['name'] ?? 'User') . '&background=FF6B00&color=fff';
            $_SESSION['user_coins'] = 50;
            
            header('Location: dashboard.php?login=success');
            exit;
        }
    }
    
    // Jika gagal
    header('Location: dashboard.php?error=login_failed');
    exit;
}

// Jika tidak ada code, redirect ke dashboard
header('Location: dashboard.php');
exit;
?>
