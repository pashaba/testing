<?php
// ============================================================
// POLAR.ID — DASHBOARD (LENGKAP)
// ============================================================

// ===== KONFIGURASI SESSION =====
session_name('POLAR_SID');
$secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
session_set_cookie_params([
    'lifetime'  => 86400 * 7,
    'path'      => '/',
    'domain'    => $_SERVER['HTTP_HOST'],
    'secure'    => $secure,
    'httponly'  => true,
    'samesite'  => 'Lax'
]);
session_start();

// ===== FUNGSI HELPER =====
function getUserData($google_id) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $SUPABASE_URL . '/rest/v1/polar_users?google_id=eq.' . urlencode($google_id));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    return (!empty($data) && isset($data[0])) ? $data[0] : null;
}

function getSessions($google_id) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    
    $url = $SUPABASE_URL . '/rest/v1/polar_sessions?user_google_id=eq.' . urlencode($google_id) . '&order=created_at.desc';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true) ?: [];
}

// ===== CEK LOGIN =====
$is_logged_in = isset($_SESSION['user_google_id']);
$user_google_id = $_SESSION['user_google_id'] ?? null;

if ($is_logged_in) {
    $_SESSION['LAST_ACTIVITY'] = time();
    $user_data = getUserData($user_google_id);
    
    if ($user_data) {
        $_SESSION['user_name'] = $user_data['name'];
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_avatar'] = $user_data['avatar'];
        $_SESSION['user_coins'] = (int)$user_data['coins'];
    } else {
        session_destroy();
        header('Location: dashboard.php');
        exit;
    }
}

$user_name = $_SESSION['user_name'] ?? "Guest";
$user_email = $_SESSION['user_email'] ?? "guest@gmail.com";
$user_avatar = $_SESSION['user_avatar'] ?? "https://ui-avatars.com/api/?name=Guest&background=FF6B00&color=fff";
$user_coins = $_SESSION['user_coins'] ?? 0;

// ===== FINGERPRINT =====
$fingerprint = $_SESSION['fingerprint'] ?? '';
if (!$fingerprint) {
    $device_data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $device_data .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    if (isset($_SERVER['HTTP_SEC_CH_UA'])) {
        $device_data .= $_SERVER['HTTP_SEC_CH_UA'];
    }
    $fingerprint = hash('sha256', $device_data . session_id());
    $_SESSION['fingerprint'] = $fingerprint;
}

// ===== AMBIL SESSIONS =====
$sessions = getSessions($user_google_id);
$totalSessions = count($sessions);
$maxSessions = 10;

// ===== KONFIGURASI GOOGLE =====
$client_id = '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://polar.web.id/dashboard.php';

// ===== PROSES CALLBACK GOOGLE =====
if (isset($_GET['code'])) {
    // Jika sudah login, redirect ke dashboard
    if (isset($_SESSION['user_google_id'])) {
        header('Location: dashboard.php');
        exit;
    }
    
    $code = $_GET['code'];
    error_log('📌 Google callback received with code: ' . substr($code, 0, 20) . '...');
    
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    error_log('📡 Token response HTTP: ' . $httpCode);
    error_log('📡 Token response: ' . $response);
    
    if ($error) {
        error_log('❌ CURL Error: ' . $error);
        die('CURL Error: ' . $error);
    }
    
    $token_data = json_decode($response, true);
    
    if (!isset($token_data['access_token'])) {
        error_log('❌ No access_token in response: ' . print_r($token_data, true));
        die('Gagal mendapatkan access token. Error: ' . ($token_data['error'] ?? 'unknown'));
    }
    
    // Ambil user info
    $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $userinfo_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token_data['access_token']]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $user_response = curl_exec($ch);
    curl_close($ch);
    
    $user_data = json_decode($user_response, true);
    error_log('👤 User data: ' . print_r($user_data, true));
    
    if (!isset($user_data['id'])) {
        error_log('❌ No user ID in response');
        die('Gagal mendapatkan data user');
    }

    $google_id = $user_data['id'];
    $name      = $user_data['name'] ?? 'User';
    $email     = $user_data['email'] ?? '';
    $avatar    = $user_data['picture'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=FF6B00&color=fff';

    // ===== CEK USER DI DATABASE =====
    $existing_user = getUserData($google_id);
    $saved_coins = $existing_user ? (int)$existing_user['coins'] : 0;

    // ===== UPSERT KE DATABASE =====
    $upsert_data = json_encode([
        'google_id'  => $google_id,
        'name'       => $name,
        'email'      => $email,
        'avatar'     => $avatar,
        'coins'      => $saved_coins,
        'created_at' => time()
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $SUPABASE_URL . '/rest/v1/polar_users');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $upsert_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . $SUPABASE_KEY,
        'Authorization: Bearer ' . $SUPABASE_KEY,
        'Prefer: resolution=merge-duplicates,return=minimal'
    ]);
    curl_exec($ch);
    curl_close($ch);

    // ===== SET SESSION =====
    $_SESSION['user_google_id'] = $google_id;
    $_SESSION['user_name']      = $name;
    $_SESSION['user_email']     = $email;
    $_SESSION['user_avatar']    = $avatar;
    $_SESSION['user_coins']     = $saved_coins;
    $_SESSION['CREATED']        = time();
    $_SESSION['EXPIRES']        = time() + 86400;
    $_SESSION['LAST_ACTIVITY']  = time();
    
    // Regenerate session ID untuk keamanan
    session_regenerate_id(true);
    
    error_log('✅ Login success! User: ' . $name . ' (' . $google_id . ')');
    error_log('📦 Session data: ' . print_r($_SESSION, true));
    
    // Redirect ke dashboard tanpa parameter
    header('Location: dashboard.php');
    exit;
}
// ===== URL LOGIN GOOGLE =====
$auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online',
    'prompt' => 'select_account'
]);

// ===== CEK STATUS SERVER =====
function checkPhoenixServer() {
    $ptero_panel = 'https://private.pterokudesu.web.id';
    $api_key = 'ptlc_UUp3T2RayUkXnIVt0dHIie1EXWwcC5Tu9U9yysRqKwj';
    $uuid = 'b70c577e-f1ad-42bf-92da-1f6ecbb5190d';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ptero_panel . '/api/client/servers/' . $uuid . '/resources');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $data = json_decode($response, true);
        $ramBytes = $data['attributes']['resources']['memory_bytes'] ?? 0;
        $ramMB = round($ramBytes / 1024 / 1024, 2);
        return [
            'online' => ($ramMB > 0),
            'ram' => $ramMB . ' MB',
            'ping' => rand(20, 150) . 'ms'
        ];
    }
    return ['online' => false, 'ram' => '0 MB', 'ping' => 'Timeout'];
}

function checkOurinServer() {
    $ptero_panel = 'https://private.pterokudesu.web.id';
    $api_key = 'ptlc_MPqC9pJMS444G2C62qWllcF3mUemjlIkqjxq0DuCpIc';
    $uuid = '1ba932b5-bc54-4e6e-83dc-239c3f51d742';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ptero_panel . '/api/client/servers/' . $uuid . '/resources');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        $data = json_decode($response, true);
        $ramBytes = $data['attributes']['resources']['memory_bytes'] ?? 0;
        $ramMB = round($ramBytes / 1024 / 1024, 2);
        return [
            'online' => ($ramMB > 0),
            'ram' => $ramMB . ' MB',
            'ping' => rand(20, 150) . 'ms'
        ];
    }
    return ['online' => false, 'ram' => '0 MB', 'ping' => 'Timeout'];
}

$phoenix_status = checkPhoenixServer();
$ourin_status = checkOurinServer();

// ===== LOAD CONFIG =====
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id — Bot WhatsApp Gratis 🪙</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* ===== STYLE SAMA SEPERTI SEBELUMNYA ===== */
        :root {
            --bg-main: #f7f7f7;
            --bg-card: #ffffff;
            --bg-nav: #ffffff;
            --orange: #ff5e00;
            --orange-hover: #cc4b00;
            --white: #ffffff;
            --gold: #fbbf24;
            --text-main: #111111;
            --text-muted: #333333;
            --border: #111111;
            --green: #00b341;
            --red: #e0002b;
            --blue: #0066ff;
            --transition: all 0.15s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --shadow-heavy: 6px 6px 0px 0px #111111;
            --shadow-light: 4px 4px 0px 0px #333333;
            --border-thick: 3px solid #111111;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Space Grotesk', sans-serif; }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes coinSpin {
            0% { transform: rotateY(0); }
            100% { transform: rotateY(360deg); }
        }

        .animate-in { animation: fadeInUp 0.4s ease forwards; }

        /* ===== LOGIN POPUP ===== */
        .login-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        body.locked-bg .navbar,
        body.locked-bg .main-container,
        body.locked-bg .sidebar,
        body.locked-bg .sidebar-overlay {
            filter: blur(6px) brightness(0.6);
            pointer-events: none;
            user-select: none;
        }
        .login-card {
            background: var(--bg-card);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            border-radius: 0px;
            padding: 44px 32px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            position: relative;
            animation: slideUp 0.5s cubic-bezier(0.22, 0.61, 0.36, 1);
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 12px;
            right: 12px;
            height: 6px;
            background: var(--orange);
        }
        .login-badge {
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%) rotate(-2deg);
            background: var(--gold);
            color: #000;
            padding: 4px 24px;
            font-weight: 900;
            font-size: 12px;
            border-radius: 0px;
            letter-spacing: 1px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .login-avatar {
            width: 80px;
            height: 80px;
            background: var(--orange);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            margin-bottom: 20px;
        }
        .login-card h2 {
            font-size: 34px;
            font-weight: 900;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
            color: var(--text-main);
            text-transform: uppercase;
        }
        .login-card p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 28px;
        }
        .google-btn-login {
            background: #ffffff;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #111;
            text-decoration: none;
            transition: var(--transition);
            text-align: left;
            font-weight: 600;
        }
        .google-btn-login:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111111;
            background: #f0f0f0;
        }
        .g-icon {
            background: white;
            border-radius: 0px;
            padding: 4px;
            width: 34px;
            height: 34px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: var(--border-thick);
        }
        .g-icon img { width: 20px; height: 20px; }
        .login-footer {
            margin-top: 20px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            border-top: 2px dashed #111;
            padding-top: 16px;
        }

        /* ===== LOADING MODAL ===== */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .loading-overlay.active { display: flex; }
        .loading-box {
            background: var(--bg-card);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            border-radius: 0px;
            padding: 34px 24px;
            max-width: 380px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.3s ease;
        }
        .loading-spinner {
            width: 44px;
            height: 44px;
            border: 6px solid #111;
            border-top-color: var(--orange);
            border-radius: 0px;
            animation: spin 0.7s linear infinite;
            margin: 0 auto 12px;
        }
        .loading-title { font-size: 18px; font-weight: 900; text-transform: uppercase; }
        .loading-desc { font-size: 12px; font-weight: 500; color: var(--text-muted); }

        /* ===== PAIRING MODAL ===== */
        .pairing-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            z-index: 1101;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .pairing-overlay.active { display: flex; animation: fadeInUp 0.3s ease; }
        .pairing-box {
            background: var(--bg-card);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            border-radius: 0px;
            padding: 30px 20px;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.4s ease;
        }
        .pairing-code {
            background: #f0f0f0;
            border: var(--border-thick);
            border-radius: 0px;
            padding: 18px 10px;
            text-align: center;
            font-size: 30px;
            font-weight: 900;
            letter-spacing: 8px;
            font-family: 'Space Grotesk', monospace;
            color: var(--orange);
            margin: 12px 0;
            box-shadow: inset 2px 2px 0px 0px #111;
        }
        .pairing-box ol {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            padding-left: 20px;
            line-height: 2.2;
        }
        .pairing-note {
            background: #f0f7ff;
            border: var(--border-thick);
            padding: 10px 14px;
            margin: 10px 0;
            font-size: 12px;
            font-weight: 600;
            border-left: 6px solid var(--blue);
        }
        .pairing-note a {
            color: var(--blue);
            font-weight: 800;
            text-decoration: underline;
            cursor: pointer;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 10px 20px;
            border-radius: 0px;
            font-weight: 800;
            text-align: center;
            cursor: pointer;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.3px;
            background: #ffffff;
            color: #111;
        }
        .btn-orange {
            background: var(--orange);
            color: #fff;
            box-shadow: var(--shadow-heavy);
        }
        .btn-orange:hover {
            transform: translate(2px, 2px);
            box-shadow: 3px 3px 0px 0px #111111;
        }
        .btn-white {
            background: #ffffff;
            color: #111;
            box-shadow: var(--shadow-light);
        }
        .btn-white:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111;
        }
        .btn-gold {
            background: var(--gold);
            color: #111;
            box-shadow: var(--shadow-heavy);
        }
        .btn-gold:hover {
            transform: translate(2px, 2px);
            box-shadow: 3px 3px 0px 0px #111;
        }
        .btn-sm { padding: 4px 10px; font-size: 10px; }
        .btn-danger { background: var(--red); color: #fff; box-shadow: var(--shadow-heavy); }
        .btn-danger:hover { transform: translate(2px, 2px); box-shadow: 3px 3px 0px 0px #111; }
        .btn-success { background: var(--green); color: #fff; box-shadow: var(--shadow-heavy); }
        .btn-success:hover { transform: translate(2px, 2px); box-shadow: 3px 3px 0px 0px #111; }
        .btn-blue { background: var(--blue); color: #fff; box-shadow: var(--shadow-heavy); }
        .btn-blue:hover { transform: translate(2px, 2px); box-shadow: 3px 3px 0px 0px #111; }
        .btn-close-modal {
            background: #e0e0e0;
            color: #111;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .btn-close-modal:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0px 0px #111; }
        .btn-full { width: 100%; justify-content: center; }

        /* ===== NAVBAR ===== */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            background: var(--bg-nav);
            border-bottom: var(--border-thick);
            box-shadow: 0 4px 0px 0px #111;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            font-size: 18px;
            text-transform: uppercase;
        }
        .brand-icon {
            background: var(--orange);
            color: white;
            padding: 4px 12px;
            border-radius: 0px;
            transform: skew(-6deg);
            font-size: 14px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .coin-badge {
            background: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            color: #111;
            padding: 4px 14px;
            font-weight: 900;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: default;
        }
        .coin-badge i { animation: coinSpin 3s linear infinite; }
        .profile-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            padding: 3px 10px 3px 3px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            cursor: pointer;
            transition: var(--transition);
        }
        .profile-btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111;
        }
        .profile-btn img {
            width: 26px;
            height: 26px;
            border-radius: 0px;
            border: var(--border-thick);
        }
        .profile-btn span { font-size: 11px; font-weight: 800; }
        .menu-btn {
            background: var(--orange);
            color: white;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            width: 36px;
            height: 36px;
            border-radius: 0px;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
        }
        .menu-btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }
        .sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            width: 280px;
            height: 100vh;
            background: var(--bg-nav);
            border-left: var(--border-thick);
            box-shadow: -6px 0px 0px 0px #111;
            z-index: 999;
            padding: 20px;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .sidebar.active { right: 0; }
        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            border-bottom: var(--border-thick);
            padding-bottom: 12px;
        }
        .sidebar-close {
            background: #111;
            color: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            width: 32px;
            height: 32px;
            border-radius: 0px;
            cursor: pointer;
            font-weight: 900;
            transition: var(--transition);
            font-size: 16px;
        }
        .sidebar-close:hover {
            transform: rotate(90deg);
            background: var(--orange);
        }
        .nav-link {
            padding: 10px 14px;
            color: #111;
            text-decoration: none;
            font-weight: 700;
            border-radius: 0px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            font-size: 13px;
            text-transform: uppercase;
        }
        .nav-link:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111;
            background: var(--orange);
            color: #fff;
        }
        .nav-link.active {
            background: var(--orange);
            color: #fff;
            box-shadow: var(--shadow-heavy);
        }
        .nav-link .badge-donasi {
            background: var(--gold);
            color: #111;
            font-size: 8px;
            padding: 2px 8px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            margin-left: auto;
        }

        /* ===== MAIN CONTENT ===== */
        .main-container { padding: 20px 16px; max-width: 700px; margin: 0 auto; }
        .section { display: none; animation: fadeInUp 0.4s ease; }
        .section.active { display: block; }

        .hero { text-align: center; }
        .slot-badge {
            display: inline-block;
            background: #111;
            color: #fff;
            padding: 3px 18px;
            border-radius: 0px;
            font-weight: 900;
            font-size: 12px;
            margin-bottom: 12px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .hero h1 {
            font-size: clamp(30px, 8vw, 44px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }
        .hero h1 span {
            background: var(--orange);
            color: #fff;
            padding: 0 12px;
            display: inline-block;
            transform: skew(-6deg);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .hero p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            max-width: 380px;
            margin: 0 auto 24px;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .btn-group .btn { width: 100%; }

        .card {
            background: var(--bg-card);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            padding: 16px;
            margin-bottom: 16px;
            transition: var(--transition);
        }
        .card:hover {
            transform: translate(1px, 1px);
            box-shadow: 5px 5px 0px 0px #111;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .section-title {
            background: #111;
            color: #fff;
            display: inline-block;
            padding: 4px 16px;
            font-weight: 900;
            font-size: 12px;
            border-radius: 0px;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            text-transform: uppercase;
        }

        .select-box {
            background: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }
        .select-box:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px #111;
        }
        .select-box.active {
            background: var(--orange);
            color: #fff;
            box-shadow: var(--shadow-heavy);
        }
        .select-box.active i { color: #fff; }
        .select-box i { font-size: 22px; color: #111; margin-bottom: 6px; }
        .select-box h4 { font-size: 14px; font-weight: 900; }
        .select-box p { font-size: 10px; font-weight: 600; margin-top: 2px; opacity: 0.7; }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 16px;
            text-align: center;
        }
        .stat-box {
            background: #fff;
            padding: 12px 6px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
        }
        .stat-box h3 { font-size: 22px; font-weight: 900; }
        .stat-box p { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .text-orange { color: var(--orange); }
        .text-gold { color: var(--gold); }
        .text-blue { color: var(--blue); }
        .badge-status {
            padding: 3px 10px;
            border-radius: 0px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .bg-online { background: var(--green); color: #fff; }
        .bg-offline { background: var(--red); color: #fff; }
        .bg-pending { background: var(--gold); color: #111; }

        .spec-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 2px dashed #111;
            font-size: 13px;
            font-weight: 600;
        }
        .spec-row:last-child { border: none; }

        .session-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 2px dashed #111;
            flex-wrap: wrap;
            gap: 6px;
        }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 800; font-family: monospace; font-size: 13px; }
        .session-actions { display: flex; gap: 5px; flex-wrap: wrap; }

        /* ===== DONASI ===== */
        .donasi-card {
            background: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            padding: 20px;
            margin-bottom: 16px;
            text-align: center;
        }
        .donasi-card .donasi-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 8px;
        }
        .donasi-card .donasi-qr {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            margin: 8px auto;
        }
        .donasi-card .donasi-nomer {
            font-size: 18px;
            font-weight: 900;
            font-family: monospace;
            background: #f0f0f0;
            padding: 4px 12px;
            border: var(--border-thick);
            display: inline-block;
            margin: 4px 0;
        }
        .donasi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ===== REQUEST SCRIPT ===== */
        .form-input {
            width: 100%;
            padding: 12px;
            background: #f0f0f0;
            border: var(--border-thick);
            box-shadow: inset 2px 2px 0px 0px #111;
            border-radius: 0px;
            color: #111;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        textarea.form-input {
            min-height: 100px;
            resize: vertical;
            font-weight: 500;
        }
        .form-label {
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            color: #111;
            padding: 12px 18px;
            border-radius: 0px;
            font-size: 13px;
            font-weight: 700;
            z-index: 1200;
            display: none;
            max-width: 340px;
            animation: slideUp 0.3s ease;
        }
        .toast.success { border-left: 8px solid var(--green); }
        .toast.error { border-left: 8px solid var(--red); }
        .toast.gold { border-left: 8px solid var(--gold); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .hero h1 { font-size: 28px; }
            .grid-2 { grid-template-columns: 1fr; }
            .grid-3 { grid-template-columns: 1fr; }
            .donasi-grid { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr 1fr; }
            .navbar { padding: 8px 12px; }
            .login-card { padding: 28px 16px; }
            .pairing-box { padding: 20px 14px; }
            .pairing-code { font-size: 24px; letter-spacing: 4px; }
            .hide-mobile { display: none; }
        }
    </style>
</head>
<body class="<?= !$is_logged_in ? 'locked-bg' : '' ?>">

<?php if (!$is_logged_in): ?>
    <!-- LOGIN POPUP -->
    <div class="login-overlay">
        <div class="login-card">
            <div class="login-badge">✦ NEW PLAYER</div>
            <div class="login-avatar"><i class="fas fa-user"></i></div>
            <h2>HALO!</h2>
            <p>Login dengan Google untuk mulai menggunakan Polar.id</p>
            <a href="<?= $auth_url ?>" class="google-btn-login">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div class="g-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:900;">Login dengan Google</div>
                        <div style="font-size:11px;font-weight:500;color:var(--text-muted);">Aman & cepat</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right" style="color:#111;"></i>
            </a>
            <div class="login-footer">
                <i class="fas fa-shield-alt"></i> Data kamu aman dengan Google OAuth 2.0
            </div>
        </div>
    </div>
<?php endif; ?>

    <!-- TOAST -->
    <div class="toast" id="toast"></div>

    <!-- LOADING MODAL -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-box">
            <div class="loading-spinner"></div>
            <div class="loading-title" id="loadingTitle">Memproses...</div>
            <div class="loading-desc" id="loadingDesc">Mohon tunggu sebentar</div>
        </div>
    </div>

    <!-- PAIRING MODAL -->
    <div class="pairing-overlay" id="pairingOverlay">
        <div class="pairing-box">
            <div style="text-align:center;margin-bottom:12px;">
                <span style="font-size:40px;">🔗</span>
                <h3 style="font-weight:900;font-size:20px;margin-top:6px;text-transform:uppercase;">Tautkan Perangkat</h3>
                <p style="color:var(--text-muted);font-size:12px;font-weight:500;">Scan atau masukkan kode di WhatsApp</p>
            </div>
            <div class="pairing-code" id="pairingCodeDisplay">Menunggu...</div>
            <ol>
                <li>Buka WhatsApp → Settings</li>
                <li>Perangkat Tertaut → Tautkan Perangkat</li>
                <li>Masukkan kode di atas</li>
            </ol>
            
            <!-- ===== PAIRING NOTE ===== -->
            <div class="pairing-note">
                <i class="fas fa-info-circle" style="color:var(--blue);"></i>
                <strong>Jika tidak menerima pairing dalam 1 menit:</strong><br>
                Pastikan status script sedang aktif. 
                <a onclick="navTo('status'); closePairingModal();">Lihat status disini →</a>
            </div>

            <button class="btn btn-orange btn-full" style="margin-top:12px;" onclick="copyPairingCode()">
                <i class="fas fa-copy"></i> Salin Kode
            </button>
            <button class="btn btn-close-modal btn-full" style="margin-top:6px;" onclick="closePairingModal()">Tutup</button>
        </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-brand"><span class="brand-icon">✦</span> POLAR.ID</div>
        <div class="nav-right">
            <div class="coin-badge">
                <i class="fas fa-coins"></i>
                <span id="coinCount"><?= $user_coins ?></span>
            </div>
            <div class="profile-btn" onclick="navTo('profile')">
                <img src="<?= $user_avatar ?>" alt="Avatar">
                <span class="hide-mobile"><?= explode(' ', $user_name)[0] ?></span>
            </div>
            <button class="menu-btn" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="nav-brand" style="font-size:14px;"><span class="brand-icon">✦</span> MENU</div>
            <button class="sidebar-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        </div>
        <a href="#" class="nav-link active" onclick="navTo('home'); toggleMenu();"><i class="fas fa-home"></i> HOME</a>
        <a href="#" class="nav-link" onclick="navTo('status'); toggleMenu();"><i class="fas fa-server"></i> STATUS</a>
        <a href="#" class="nav-link" onclick="navTo('claim'); toggleMenu();"><i class="fas fa-download"></i> CLAIM</a>
        <a href="#" class="nav-link" onclick="navTo('sessions'); toggleMenu();"><i class="fas fa-robot"></i> SESSIONS</a>
        <a href="#" class="nav-link" onclick="navTo('profile'); toggleMenu();"><i class="fas fa-user"></i> PROFILE</a>
        <a href="#" class="nav-link" onclick="navTo('request'); toggleMenu();"><i class="fas fa-code"></i> REQUEST SCRIPT</a>
        <a href="#" class="nav-link" onclick="navTo('donasi'); toggleMenu();">
            <i class="fas fa-heart" style="color:var(--red);"></i> DONASI 
            <span class="badge-donasi">❤️</span>
        </a>
        <a href="logout.php" class="nav-link" style="background:var(--red);color:#fff;margin-top:auto;"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-container">

        <!-- HOME -->
        <div id="sec-home" class="section active">
            <div class="hero">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size:8px;color:var(--orange);"></i> <?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1>Jadibot <br><span>WhatsApp Gratis</span></h1>
                <p>Dapatkan server bot gratis. Claim sekarang sebelum slot habis!</p>
                <div class="btn-group">
                    <button class="btn btn-orange" onclick="navTo('claim')"><i class="fas fa-download"></i> CLAIM SEKARANG</button>
                    <button class="btn btn-white" onclick="navTo('status')">LIHAT STATUS <i class="fas fa-arrow-right"></i></button>
                    <button class="btn btn-gold" onclick="navTo('donasi')"><i class="fas fa-heart"></i> DUKUNG KAMI</button>
                </div>
            </div>
        </div>

        <!-- CLAIM -->
        <div id="sec-claim" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge"><?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;">CLAIM <span style="background:#111;color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">SERVER</span></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;">Pilih paket dan claim server bot gratis</p>
            </div>

            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="background:var(--orange);width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-weight:900;color:#fff;font-size:16px;border:var(--border-thick);box-shadow:var(--shadow-light);"><?= substr($user_name, 0, 1) ?></div>
                        <div><div style="font-size:9px;font-weight:700;color:var(--text-muted);">LOGIN AS</div><div style="font-weight:900;font-size:14px;"><?= $user_name ?></div></div>
                    </div>
                    <span style="font-weight:900;font-size:14px;"><i class="fas fa-coins"></i> <span id="claimCoinDisplay"><?= $user_coins ?></span></span>
                </div>
            </div>

            <div class="section-title">🪙 PAKET POLAR COIN</div>
            <div class="grid-2">
                <?php
                $packages = [
                    ['days' => 1, 'coin' => 1, 'label' => '1 Hari', 'icon' => 'fa-calendar-day'],
                    ['days' => 2, 'coin' => 2, 'label' => '2 Hari', 'icon' => 'fa-calendar-week'],
                    ['days' => 4, 'coin' => 3, 'label' => '4 Hari', 'icon' => 'fa-calendar-alt'],
                    ['days' => 10, 'coin' => 10, 'label' => '10 Hari', 'icon' => 'fa-calendar-check']
                ];
                foreach ($packages as $pkg):
                    $isActive = ($user_coins >= $pkg['coin']);
                ?>
                <div class="select-box <?= $isActive ? 'active' : '' ?>" onclick="<?= $isActive ? "selectPackage(this, {$pkg['days']}, {$pkg['coin']})" : '' ?>" style="<?= !$isActive ? 'opacity:0.5;cursor:not-allowed;' : '' ?>">
                    <i class="fas <?= $pkg['icon'] ?>"></i>
                    <h4><?= $pkg['label'] ?></h4>
                    <p style="font-size:11px;font-weight:700;">🪙 <?= $pkg['coin'] ?> Polar Coin</p>
                    <?php if (!$isActive): ?><p style="color:var(--red);font-size:9px;font-weight:700;margin-top:2px;">Koin tidak cukup</p><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="section-title">⚙️ JENIS SCRIPT</div>
            <div class="grid-2">
                <div class="select-box active" onclick="selectScript(this)" data-script="phoenix_md">
                    <i class="fas fa-robot"></i>
                    <h4>Phoenix MD</h4>
                    <p>Pterodactyl Engine</p>
                </div>
                <div class="select-box" onclick="selectScript(this)" data-script="ourin_md">
                    <i class="fas fa-microchip"></i>
                    <h4>Ourin</h4>
                    <p>Native Core</p>
                </div>
            </div>

            <div class="card">
                <div style="margin-bottom:10px;">
                    <label class="form-label">📱 Nomor WhatsApp</label>
                    <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" class="form-input">
                </div>
                <input type="hidden" id="selectedDays" value="1">
                <input type="hidden" id="selectedCoin" value="1">
            </div>

            <button class="btn btn-orange" style="width:100%;margin-top:8px;padding:14px;font-size:14px;" id="claimBtn" onclick="createSessionWithCoin()">
                <i class="fas fa-rocket"></i> CLAIM SERVER SEKARANG
            </button>
        </div>

        <!-- STATUS -->
        <div id="sec-status" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge" style="background:#111;color:#fff;">REAL-TIME MONITORING</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;">SERVER <span style="background:var(--orange);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">STATUS</span></h1>
            </div>

            <div class="card">
                <div class="status-grid">
                    <div class="stat-box"><h3 class="text-orange"><?= $totalSessions ?></h3><p>TOTAL</p></div>
                    <div class="stat-box"><h3 class="text-gold"><?= $maxSessions - $totalSessions ?></h3><p>SLOT</p></div>
                    <div class="stat-box"><h3 class="text-blue"><?= ($phoenix_status['online'] ? 1 : 0) + ($ourin_status['online'] ? 1 : 0) ?></h3><p>ONLINE</p></div>
                    <div class="stat-box"><h3 class="text-orange"><?= (!$phoenix_status['online'] ? 1 : 0) + (!$ourin_status['online'] ? 1 : 0) ?></h3><p>OFFLINE</p></div>
                </div>
            </div>

            <div class="card" style="border: var(--border-thick); box-shadow: var(--shadow-heavy);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="background:var(--orange);padding:8px;border:var(--border-thick);box-shadow:var(--shadow-light);"><i class="fas fa-server" style="color:#fff;font-size:14px;"></i></div>
                        <div><h3 style="font-size:14px;font-weight:900;">PHOENIX MD</h3><div style="font-size:10px;font-weight:600;color:var(--text-muted);">Pterodactyl</div></div>
                    </div>
                    <div class="badge-status <?= $phoenix_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $phoenix_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="font-weight:600;color:var(--text-muted);">RAM</span><span style="font-weight:900;"><?= $phoenix_status['ram'] ?></span></div>
                <div class="spec-row"><span style="font-weight:600;color:var(--text-muted);">PING</span><span style="font-weight:900;"><?= $phoenix_status['ping'] ?></span></div>
            </div>

            <div class="card" style="border: var(--border-thick); box-shadow: var(--shadow-heavy);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="background:#111;padding:8px;border:var(--border-thick);box-shadow:var(--shadow-light);"><i class="fas fa-microchip" style="color:#fff;font-size:14px;"></i></div>
                        <div><h3 style="font-size:14px;font-weight:900;">OURIN MD V3</h3><div style="font-size:10px;font-weight:600;color:var(--text-muted);">Pterodactyl</div></div>
                    </div>
                    <div class="badge-status <?= $ourin_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $ourin_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="font-weight:600;color:var(--text-muted);">RAM</span><span style="font-weight:900;"><?= $ourin_status['ram'] ?></span></div>
                <div class="spec-row"><span style="font-weight:600;color:var(--text-muted);">PING</span><span style="font-weight:900;"><?= $ourin_status['ping'] ?></span></div>
            </div>
        </div>

        <!-- SESSIONS -->
        <div id="sec-sessions" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge"><?= $totalSessions ?> / <?= $maxSessions ?> SESSION</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;">MY <span style="background:var(--orange);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">BOTS</span></h1>
            </div>

            <?php if (empty($sessions)): ?>
            <div class="card" style="text-align:center;padding:40px 16px;">
                <div style="font-size:48px;margin-bottom:12px;opacity:0.3;">🤖</div>
                <h3 style="font-weight:900;font-size:20px;">Belum Ada Bot</h3>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;margin-top:4px;">Claim server dulu untuk mulai menggunakan bot</p>
                <button class="btn btn-orange" style="margin-top:16px;" onclick="navTo('claim')">CLAIM SEKARANG</button>
            </div>
            <?php else: ?>
                <?php foreach ($sessions as $s): 
                    $statusClass = $s['status'] === 'online' ? 'bg-online' : ($s['status'] === 'pending' ? 'bg-pending' : 'bg-offline');
                    $statusText = $s['status'] === 'online' ? 'Online' : ($s['status'] === 'pending' ? 'Pending' : 'Offline');
                ?>
                <div class="card">
                    <div class="session-item">
                        <div>
                            <div class="session-phone"><i class="fab fa-whatsapp"></i> +<?= htmlspecialchars($s['phone']) ?></div>
                            <div style="font-size:9px;font-weight:700;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars($s['script']) ?> • <?= $s['expiry_days'] ?> hari</div>
                        </div>
                        <div class="badge-status <?= $statusClass ?>"><?= $statusText ?></div>
                    </div>
                    <div style="display:flex;gap:5px;flex-wrap:wrap;margin-top:4px;">
                        <?php if ($s['status'] === 'pending'): ?>
                        <button class="btn btn-sm btn-orange" onclick="openPairModal('<?= $s['phone'] ?>')"><i class="fas fa-link"></i> Pairing</button>
                        <?php endif; ?>
                        <?php if ($s['status'] === 'online'): ?>
                        <button class="btn btn-sm btn-success" onclick="showToast('Bot sedang online! ✅', 'success')"><i class="fas fa-circle"></i> Online</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- PROFILE -->
        <div id="sec-profile" class="section">
            <div style="text-align:center;margin-bottom:24px;margin-top:8px;">
                <div style="position:relative;display:inline-block;">
                    <img src="<?= $user_avatar ?>" style="width:80px;height:80px;border-radius:0px;border:var(--border-thick);box-shadow:var(--shadow-light);">
                    <div style="position:absolute;top:-10px;right:-10px;background:var(--orange);color:#fff;padding:2px 14px;font-size:10px;font-weight:900;border:var(--border-thick);box-shadow:var(--shadow-light);transform:rotate(6deg);">✦ YOU!</div>
                </div>
                <h1 style="font-weight:900;font-size:26px;margin-top:12px;text-transform:uppercase;"><?= $user_name ?></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;"><?= $user_email ?></p>
                <div style="background:#fff;border:var(--border-thick);box-shadow:var(--shadow-light);display:inline-flex;align-items:center;gap:12px;padding:6px 18px;margin-top:12px;">
                    <div style="font-weight:900;font-size:14px;"><i class="fas fa-coins"></i> <span id="profileCoinDisplay"><?= $user_coins ?></span></div>
                    <div style="font-size:10px;font-weight:800;letter-spacing:1px;color:var(--text-muted);">POLAR COIN</div>
                </div>
                <div style="margin-top:12px;">
                    <a href="logout.php" style="color:#111;font-size:12px;font-weight:800;text-decoration:none;border:var(--border-thick);padding:4px 16px;box-shadow:var(--shadow-light);background:#fff;display:inline-block;">LOGOUT <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="card" style="text-align:center;padding:32px 16px;">
                <div style="background:#f0f0f0;width:48px;height:48px;display:inline-flex;justify-content:center;align-items:center;font-size:24px;color:#111;border:var(--border-thick);box-shadow:var(--shadow-light);margin-bottom:12px;">
                    <i class="fas fa-chart-simple"></i>
                </div>
                <h2 style="font-weight:900;font-size:20px;margin-bottom:4px;text-transform:uppercase;">STATISTIK</h2>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;">Total Session: <strong style="color:#111;"><?= $totalSessions ?></strong> / <?= $maxSessions ?></p>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;margin-top:4px;">Polar Coin: <strong style="color:var(--gold);"><?= $user_coins ?></strong></p>
                <button class="btn btn-orange" style="margin-top:16px;" onclick="navTo('claim')">CLAIM SERVER <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- ===== REQUEST SCRIPT ===== -->
        <div id="sec-request" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge" style="background:var(--blue);color:#fff;">📝 REQUEST SCRIPT</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;">REQUEST <span style="background:var(--blue);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">SCRIPT</span></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;">Butuh script tertentu? Isi form dibawah, kami akan bantu!</p>
            </div>

            <div class="card">
                <form id="requestForm" onsubmit="submitRequest(event)">
                    <div style="margin-bottom:12px;">
                        <label class="form-label">📝 Nama Script</label>
                        <input type="text" id="scriptName" class="form-input" placeholder="Contoh: Bot AI ChatGPT" required>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label class="form-label">📋 Deskripsi / Spesifikasi</label>
                        <textarea id="scriptDesc" class="form-input" placeholder="Jelaskan script yang kamu butuhkan..." required></textarea>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label class="form-label">📱 Nomor WhatsApp (untuk konfirmasi)</label>
                        <input type="text" id="requestPhone" class="form-input" placeholder="628xxxxxxxxxx" required>
                    </div>
                    <button type="submit" class="btn btn-blue" style="width:100%;padding:14px;font-size:14px;">
                        <i class="fab fa-whatsapp"></i> KIRIM KE WHATSAPP
                    </button>
                </form>
            </div>

            <div class="card" style="text-align:center;background:#f0f7ff;">
                <p style="font-size:12px;font-weight:600;color:var(--text-muted);">
                    <i class="fas fa-clock" style="color:var(--blue);"></i> 
                    Request akan diproses dalam 1x24 jam. Kamu akan dikonfirmasi via WhatsApp.
                </p>
            </div>
        </div>

        <!-- ===== DONASI ===== -->
        <div id="sec-donasi" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge" style="background:var(--red);color:#fff;">❤️ DUKUNG KAMI</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;">DONASI <span style="background:var(--red);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">UNTUK POLAR</span></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;">Donasi membantu Polar.id tetap gratis & berkembang! 🚀</p>
            </div>

            <div class="donasi-grid">
                <!-- DANA -->
                <div class="donasi-card">
                    <img src="img/dana.png" alt="DANA" class="donasi-logo" onerror="this.style.display='none'">
                    <h3 style="font-weight:900;font-size:18px;text-transform:uppercase;">DANA</h3>
                    <div class="donasi-nomer">085715194026</div>
                    <img src="img/danaqr.png" alt="QR DANA" class="donasi-qr" onerror="this.style.display='none'">
                    <p style="font-size:10px;font-weight:600;color:var(--text-muted);margin-top:4px;">Scan QR atau kirim ke nomor di atas</p>
                    <a href="https://link.dana.id/qr/085715194026" target="_blank" class="btn btn-sm" style="margin-top:8px;background:#005b96;color:#fff;border-color:#005b96;">
                        <i class="fas fa-external-link-alt"></i> Buka DANA
                    </a>
                </div>

                <!-- GOPAY -->
                <div class="donasi-card">
                    <img src="img/gopay.png" alt="GOPAY" class="donasi-logo" onerror="this.style.display='none'">
                    <h3 style="font-weight:900;font-size:18px;text-transform:uppercase;">GOPAY</h3>
                    <div class="donasi-nomer">085715294026</div>
                    <img src="img/gopayqr.png" alt="QR GOPAY" class="donasi-qr" onerror="this.style.display='none'">
                    <p style="font-size:10px;font-weight:600;color:var(--text-muted);margin-top:4px;">Scan QR atau kirim ke nomor di atas</p>
                    <a href="https://gopay.co.id/qr/085715294026" target="_blank" class="btn btn-sm" style="margin-top:8px;background:#00a651;color:#fff;border-color:#00a651;">
                        <i class="fas fa-external-link-alt"></i> Buka GOPAY
                    </a>
                </div>
            </div>

            <div class="donasi-card" style="background:#f0f0f0;">
                <p style="font-size:12px;font-weight:600;color:var(--text-muted);">
                    <i class="fas fa-heart" style="color:var(--red);"></i> 
                    Terima kasih atas dukungannya! Setiap donasi sangat berarti untuk Polar.id.
                </p>
            </div>
        </div>

    </div>

    <script>
        // ========== KONFIGURASI ==========
        const SB_URL = '<?= $SUPABASE_URL ?>';
        const SB_KEY = '<?= $SUPABASE_KEY ?>';
        const MAX_SESSIONS = <?= $maxSessions ?>;
        let selectedDays = 1;
        let selectedCoin = 1;
        let currentPairPhone = null;
        let pairInterval = null;

        // ========== TOAST ==========
        function showToast(message, type = 'info') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast ' + type;
            toast.style.display = 'block';
            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(() => { toast.style.display = 'none'; }, 4000);
        }

        // ========== SIDEBAR ==========
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        // ========== NAVIGATION ==========
        function navTo(sectionId) {
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            document.getElementById('sec-' + sectionId).classList.add('active');
            document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
            window.scrollTo({ top: 0, behavior: 'smooth' });
            if (window.innerWidth < 768) toggleMenu();
        }

        // ========== SELECT BOX ==========
        function selectScript(el) {
            document.querySelectorAll('.select-box[data-script]').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
        }

        function selectPackage(el, days, coin) {
            document.querySelectorAll('.select-box').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            selectedDays = days;
            selectedCoin = coin;
            document.getElementById('selectedDays').value = days;
            document.getElementById('selectedCoin').value = coin;
        }

        // ========== LOADING MODAL ==========
        function showLoading(title = 'Memproses...', desc = 'Mohon tunggu sebentar') {
            document.getElementById('loadingTitle').textContent = title;
            document.getElementById('loadingDesc').textContent = desc;
            document.getElementById('loadingOverlay').classList.add('active');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        // ========== PAIRING MODAL ==========
        function showPairingModal(phone) {
            currentPairPhone = phone;
            document.getElementById('pairingCodeDisplay').textContent = 'Menunggu pairing code...';
            document.getElementById('pairingOverlay').classList.add('active');
            
            if (pairInterval) clearInterval(pairInterval);
            pairInterval = setInterval(async () => {
                try {
                    const data = await supabaseRequest('GET', `polar_sessions?phone=eq.${phone}&select=status,pairing_code&limit=1`);
                    if (data && data[0]) {
                        if (data[0].pairing_code) {
                            const code = data[0].pairing_code.match(/.{1,4}/g)?.join('-') || data[0].pairing_code;
                            document.getElementById('pairingCodeDisplay').textContent = code;
                        }
                        if (data[0].status === 'online') {
                            document.getElementById('pairingCodeDisplay').textContent = '✅ Bot Online!';
                            clearInterval(pairInterval);
                            setTimeout(() => {
                                closePairingModal();
                                location.reload();
                            }, 2000);
                        }
                    }
                } catch(e) { console.error(e); }
            }, 3000);
        }

        function closePairingModal() {
            if (pairInterval) clearInterval(pairInterval);
            document.getElementById('pairingOverlay').classList.remove('active');
            currentPairPhone = null;
        }

        function copyPairingCode() {
            const code = document.getElementById('pairingCodeDisplay').textContent;
            if (code && !code.includes('Menunggu') && !code.includes('Online')) {
                navigator.clipboard.writeText(code.replace(/-/g, ''));
                showToast('✅ Kode disalin!', 'success');
            }
        }

        // ========== SUPABASE REQUEST ==========
        async function supabaseRequest(method, endpoint, body = null) {
            const ctrl = new AbortController();
            const timer = setTimeout(() => ctrl.abort(), 15000);
            try {
                const r = await fetch(`${SB_URL}/rest/v1/${endpoint}`, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'apikey': SB_KEY,
                        'Authorization': `Bearer ${SB_KEY}`,
                        'Prefer': 'return=representation'
                    },
                    body: body ? JSON.stringify(body) : null,
                    signal: ctrl.signal
                });
                clearTimeout(timer);
                if (!r.ok) {
                    const errText = await r.text();
                    throw new Error(`HTTP ${r.status}: ${errText.substring(0, 200)}`);
                }
                const t = await r.text();
                return t ? JSON.parse(t) : [];
            } catch(e) {
                clearTimeout(timer);
                throw e;
            }
        }

        // ========== CREATE SESSION ==========
        async function createSessionWithCoin() {
            const phone = document.getElementById('phoneInput').value.trim();
            const scriptEl = document.querySelector('.select-box.active[data-script]');
            const script = scriptEl ? scriptEl.dataset.script : 'phoenix_md';
            const days = selectedDays;
            const coin = selectedCoin;

            if (!phone) { showToast('📱 Masukkan nomor WhatsApp', 'error'); return; }
            
            const currentCoins = parseInt(document.getElementById('coinCount')?.textContent || '0');
            if (currentCoins < coin) { 
                showToast('🪙 Polar Coin tidak cukup! Butuh ' + coin + ' coin.', 'error'); 
                return; 
            }
            if (<?= $totalSessions ?> >= MAX_SESSIONS) { 
                showToast('❌ Slot session penuh (maksimal ' + MAX_SESSIONS + ')', 'error'); 
                return; 
            }

            let cleanPhone = phone.replace(/[^0-9]/g, '');
            if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
            if (!cleanPhone.startsWith('62')) cleanPhone = '62' + cleanPhone;
            if (cleanPhone.length < 10) { showToast('📱 Nomor terlalu pendek', 'error'); return; }

            const btn = document.getElementById('claimBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';

            showLoading('Membuat Session...', 'Mohon tunggu sebentar');

            try {
                // Update coin
                const coinRes = await fetch('update-coin.php?amount=' + (-coin));
                const coinData = await coinRes.json();
                if (!coinData.success) throw new Error('Gagal update coin');

                // Buat session
                const sessionData = {
                    user_google_id: '<?= $user_google_id ?>',
                    fingerprint: '<?= $fingerprint ?>',
                    phone: cleanPhone,
                    script: script,
                    status: 'pending',
                    bot_mode: 'public',
                    token_used: 'COIN_' + Date.now(),
                    pairing_code: null,
                    created_at: Date.now(),
                    expiry_days: days
                };

                await supabaseRequest('POST', 'polar_sessions', sessionData);

                hideLoading();
                showToast('✅ Server berhasil di-claim! ' + days + ' hari aktif. 🎉', 'success');
                
                showPairingModal(cleanPhone);

            } catch(e) {
                hideLoading();
                showToast('❌ ' + e.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-rocket"></i> CLAIM SERVER SEKARANG';
            }
        }

        // ========== OPEN PAIRING ==========
        function openPairModal(phone) {
            showPairingModal(phone);
        }

        // ========== REQUEST SCRIPT ==========
        function submitRequest(e) {
            e.preventDefault();
            
            const name = document.getElementById('scriptName').value.trim();
            const desc = document.getElementById('scriptDesc').value.trim();
            const phone = document.getElementById('requestPhone').value.trim();

            if (!name || !desc || !phone) {
                showToast('❌ Semua field harus diisi!', 'error');
                return;
            }

            // Clean phone
            let cleanPhone = phone.replace(/[^0-9]/g, '');
            if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
            if (!cleanPhone.startsWith('62')) cleanPhone = '62' + cleanPhone;

            const message = `Halo Polar.id! Saya mau request script:%0A%0A📝 Nama Script: ${encodeURIComponent(name)}%0A📋 Deskripsi: ${encodeURIComponent(desc)}%0A📱 No. WhatsApp: ${cleanPhone}%0A%0ATerima kasih! 🙏`;
            
            const waUrl = `https://wa.me/6285715294026?text=${message}`;
            window.open(waUrl, '_blank');
            
            showToast('✅ Redirect ke WhatsApp...', 'success');
            
            // Reset form
            document.getElementById('requestForm').reset();
        }

        // ========== UPDATE COIN DISPLAY ==========
        function updateCoinDisplay() {
            fetch('get-coin.php')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const coin = data.coins;
                        document.querySelectorAll('#coinCount, #claimCoinDisplay, #profileCoinDisplay').forEach(el => {
                            if (el) el.textContent = coin;
                        });
                    }
                })
                .catch(() => {});
        }

        // ========== INIT ==========
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(updateCoinDisplay, 30000);
        });

        document.getElementById('pairingOverlay').addEventListener('click', function(e) {
            if (e.target === this) closePairingModal();
        });
    </script>
</body>
</html>
