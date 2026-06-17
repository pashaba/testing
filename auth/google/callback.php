<?php
// auth/google/callback.php
require_once '../../config-google.php';

// Jika sudah login, redirect ke dashboard (pakai path absolut dari root)
if (isset($_SESSION['user_email'])) {
    header('Location: /dashboard.php');  // ← PAKAI SLASH DI DEPAN
    exit;
}

$code = $_GET['code'] ?? '';
$error = $_GET['error'] ?? '';

if ($error) {
    header('Location: /dashboard.php?error=google_auth_failed');
    exit;
}

if ($code) {
    $token_url = 'https://oauth2.googleapis.com/token';
    $post_data = [
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
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
        $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userinfo_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token_data['access_token']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $user_response = curl_exec($ch);
        curl_close($ch);
        
        $user_data = json_decode($user_response, true);
        
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_name'] = $user_data['name'] ?? 'User';
        $_SESSION['user_picture'] = $user_data['picture'] ?? '';
        $_SESSION['user_coins'] = 0;
        
        // ← PAKAI PATH ABSOLUT DARI ROOT
        header('Location: /dashboard.php?login=success');
        exit;
    } else {
        header('Location: /dashboard.php?error=token_failed');
        exit;
    }
}

// Jika tidak ada code, redirect ke login
header('Location: /dashboard.php');
exit;
?>
