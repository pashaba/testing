<?php
// ===== PERBAIKAN SESSION =====
// 1. Set session cookie parameters SEBELUM session_start()
session_set_cookie_params([
    'lifetime' => 86400 * 7, // 7 hari
    'path' => '/',
    'domain' => '', // biarkan kosong untuk auto-detect
    'secure' => false, // set true kalau pakai HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// 2. Refresh session untuk mencegah expired
if (isset($_SESSION['user_google_id'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
    if (isset($_SESSION['EXPIRES']) && (time() - $_SESSION['EXPIRES'] > 3600)) {
        session_destroy();
        session_start();
    }
    $_SESSION['EXPIRES'] = time() + 3600; // 1 jam
}

require_once 'config.php';

// ========== KONFIGURASI GOOGLE ==========
$client_id = '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://polar.web.id/dashboard.php';

// ========== PROSES CALLBACK GOOGLE ==========
if (isset($_GET['code']) && !isset($_SESSION['user_google_id'])) {
    $code = $_GET['code'];
    
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

        $google_id = $user_data['id'];
        $name      = $user_data['name'] ?? 'User';
        $email     = $user_data['email'] ?? '';
        $avatar    = $user_data['picture'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=FF6B00&color=fff';

        // ===== UPSERT ke Supabase =====
        $sb_url = rtrim($SUPABASE_URL, '/');
        $sb_key = $SUPABASE_KEY;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sb_url . '/rest/v1/polar_users?google_id=eq.' . urlencode($google_id) . '&select=coins');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apikey: ' . $sb_key,
            'Authorization: Bearer ' . $sb_key
        ]);
        $existing_raw = curl_exec($ch);
        curl_close($ch);

        $existing = json_decode($existing_raw, true);
        $saved_coins = (!empty($existing) && isset($existing[0]['coins'])) ? (int)$existing[0]['coins'] : 0;

        $upsert_data = json_encode([
            'google_id'  => $google_id,
            'name'       => $name,
            'email'      => $email,
            'avatar'     => $avatar,
            'coins'      => $saved_coins,
            'created_at' => time()
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sb_url . '/rest/v1/polar_users');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $upsert_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'apikey: ' . $sb_key,
            'Authorization: Bearer ' . $sb_key,
            'Prefer: resolution=merge-duplicates,return=minimal'
        ]);
        curl_exec($ch);
        curl_close($ch);

        // Set session dengan waktu expire
        $_SESSION['user_google_id'] = $google_id;
        $_SESSION['user_name']      = $name;
        $_SESSION['user_email']     = $email;
        $_SESSION['user_avatar']    = $avatar;
        $_SESSION['user_coins']     = $saved_coins;
        $_SESSION['CREATED']        = time();
        $_SESSION['EXPIRES']        = time() + 3600; // 1 jam
        $_SESSION['LAST_ACTIVITY']  = time();
        
        // Regenerate session ID untuk keamanan
        session_regenerate_id(true);
        
        header('Location: dashboard.php');
        exit;
    }
}

// ========== CEK LOGIN ==========
$is_logged_in = isset($_SESSION['user_google_id']);
$earn_flag_active = !empty($_SESSION['earn_flag']);
$user_name = $_SESSION['user_name'] ?? "Guest";
$user_email = $_SESSION['user_email'] ?? "guest@gmail.com";
$user_avatar = $_SESSION['user_avatar'] ?? "https://ui-avatars.com/api/?name=Guest&background=FF6B00&color=fff";
$user_coins = $_SESSION['user_coins'] ?? 0;

// ========== URL LOGIN GOOGLE ==========
$auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online',
    'prompt' => 'select_account'
]);

// ========== CEK SERVER ==========
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
    $api_key = 'ptlc_qEYuw1Iv0NQXPUMKzCUJhENIJ7P7SL6KFHTQ0kv9ckh';
    $uuid = 'e076c725-f16d-4a7d-93d9-82c294e07f38';

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

// ========== AMBIL SESSION DARI SUPABASE ==========
function getSessions($fingerprint) {
    global $SUPABASE_URL, $SUPABASE_KEY;
    $url = $SUPABASE_URL . '/rest/v1/polar_sessions?fingerprint=eq.' . urlencode($fingerprint) . '&order=created_at.desc';
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

$fingerprint = $_SESSION['fingerprint'] ?? '';
if (!$fingerprint) {
    $fingerprint = hash('sha256', $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . session_id());
    $_SESSION['fingerprint'] = $fingerprint;
}
$sessions = getSessions($fingerprint);
$totalSessions = count($sessions);
$maxSessions = 10;
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
        /* ============================================================
           NEOBRUTALISM STYLE — FULL INTEGRATION
           ============================================================ */
        :root {
            --bg-main: #f7f7f7;
            --bg-card: #ffffff;
            --bg-nav: #ffffff;
            --orange: #ff5e00;
            --orange-hover: #cc4b00;
            --orange-glow: rgba(255,94,0,0.4);
            --white: #ffffff;
            --gold: #fbbf24;
            --gold-glow: rgba(251,191,36,0.3);
            --text-main: #111111;
            --text-muted: #333333;
            --border: #111111;
            --green: #00b341;
            --red: #e0002b;
            --neon-pink: #ff006e;
            --neon-blue: #00d4ff;
            --neon-green: #00ff87;
            --brutal-yellow: #ffe600;
            --transition: all 0.12s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --shadow-heavy: 8px 8px 0px 0px #111111;
            --shadow-light: 6px 6px 0px 0px #333333;
            --shadow-orange: 8px 8px 0px 0px #ff5e00;
            --shadow-gold: 8px 8px 0px 0px #fbbf24;
            --shadow-pink: 8px 8px 0px 0px #ff006e;
            --shadow-blue: 8px 8px 0px 0px #00d4ff;
            --shadow-green: 8px 8px 0px 0px #00ff87;
            --border-thick: 3px solid #111111;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Space Grotesk', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                repeating-linear-gradient(45deg, rgba(255,94,0,0.04) 0px, rgba(255,94,0,0.04) 15px, transparent 15px, transparent 30px),
                repeating-linear-gradient(-45deg, rgba(0,0,0,0.03) 0px, rgba(0,0,0,0.03) 15px, transparent 15px, transparent 30px),
                repeating-linear-gradient(90deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 4px);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes coinSpin {
            0% { transform: rotateY(0); }
            100% { transform: rotateY(360deg); }
        }
        @keyframes brutalShake {
            0%, 100% { transform: translate(0, 0); }
            25% { transform: translate(-3px, 3px); }
            75% { transform: translate(3px, -3px); }
        }
        @keyframes glitch {
            0% { transform: translate(0); }
            20% { transform: translate(-3px, 3px); }
            40% { transform: translate(3px, -3px); }
            60% { transform: translate(-2px, 2px); }
            80% { transform: translate(2px, -2px); }
            100% { transform: translate(0); }
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        @keyframes pulseBorder {
            0%, 100% { box-shadow: var(--shadow-heavy); }
            50% { box-shadow: 4px 4px 0px 0px #111111; }
        }
        @keyframes rainbowShadow {
            0% { box-shadow: 8px 8px 0px 0px #ff006e; }
            25% { box-shadow: 8px 8px 0px 0px #ff5e00; }
            50% { box-shadow: 8px 8px 0px 0px #ffe600; }
            75% { box-shadow: 8px 8px 0px 0px #00d4ff; }
            100% { box-shadow: 8px 8px 0px 0px #ff006e; }
        }
        @keyframes rainbowBg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes skeletonPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes glitchText {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(2px, -2px); }
            60% { transform: translate(-1px, 1px); }
            80% { transform: translate(1px, -1px); }
        }
        .animate-in { animation: fadeInUp 0.4s ease forwards; }
        .animate-float { animation: float 2.4s ease-in-out infinite; }
        .animate-coin { animation: coinSpin 1s ease forwards; }

        /* ===== LOGIN POPUP ===== */
        .login-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeInUp 0.4s ease;
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
            border-radius: 0px;
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
            animation: brutalShake 0.2s ease;
        }
        .google-btn-login:active {
            transform: translate(4px, 4px);
            box-shadow: 2px 2px 0px 0px #111;
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
        .loading-box.active { animation: glitch 0.3s ease; }
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
            backdrop-filter: blur(4px);
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
            max-width: 400px;
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
            position: relative;
        }
        .btn:hover {
            animation: brutalShake 0.2s ease;
            transform: translate(-2px, -2px);
        }
        .btn:active {
            transform: translate(4px, 4px) !important;
            box-shadow: 2px 2px 0px 0px #111 !important;
            transition: all 0.05s ease;
        }
        .btn-orange {
            background: var(--orange);
            color: #fff;
            box-shadow: var(--shadow-heavy);
        }
        .btn-orange:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px 0px #111111;
        }
        .btn-white {
            background: #ffffff;
            color: #111;
            box-shadow: var(--shadow-light);
        }
        .btn-white:hover {
            transform: translate(-2px, -2px);
            box-shadow: 8px 8px 0px 0px #111;
        }
        .btn-gold {
            background: var(--gold);
            color: #111;
            box-shadow: var(--shadow-heavy);
        }
        .btn-gold:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px 0px #111;
        }
        .btn-pink {
            background: var(--neon-pink);
            color: #fff;
            box-shadow: var(--shadow-pink);
        }
        .btn-pink:hover {
            background: #e60062;
            box-shadow: 10px 10px 0px 0px #111;
        }
        .btn-blue {
            background: var(--neon-blue);
            color: #111;
            box-shadow: var(--shadow-blue);
        }
        .btn-blue:hover {
            background: #00b8e6;
            box-shadow: 10px 10px 0px 0px #111;
        }
        .btn-green {
            background: var(--neon-green);
            color: #111;
            box-shadow: var(--shadow-green);
        }
        .btn-green:hover {
            background: #00e67a;
            box-shadow: 10px 10px 0px 0px #111;
        }
        .btn-rainbow {
            background: linear-gradient(45deg, #ff006e, #ff5e00, #ffe600, #00d4ff);
            color: #fff;
            box-shadow: var(--shadow-heavy);
            background-size: 300% 300%;
            animation: rainbowBg 3s ease infinite;
        }
        .btn-rainbow:hover {
            animation: rainbowBg 3s ease infinite, brutalShake 0.2s ease;
        }
        .btn-sm { padding: 4px 10px; font-size: 10px; }
        .btn-danger { background: var(--red); color: #fff; box-shadow: var(--shadow-heavy); }
        .btn-danger:hover { transform: translate(-2px, -2px); box-shadow: 10px 10px 0px 0px #111; }
        .btn-success { background: var(--green); color: #fff; box-shadow: var(--shadow-heavy); }
        .btn-success:hover { transform: translate(-2px, -2px); box-shadow: 10px 10px 0px 0px #111; }
        .btn-close-modal {
            background: #e0e0e0;
            color: #111;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .btn-close-modal:hover { transform: translate(-2px, -2px); box-shadow: 8px 8px 0px 0px #111; }
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
            letter-spacing: 0px;
            overflow: hidden;
            white-space: nowrap;
            animation: typing 2s steps(10) 1s forwards;
            width: 0;
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
            transform: translate(-2px, -2px);
            box-shadow: 8px 8px 0px 0px #111;
            animation: brutalShake 0.2s ease;
        }
        .profile-btn:active {
            transform: translate(3px, 3px);
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
            transform: translate(-2px, -2px);
            box-shadow: 8px 8px 0px 0px #111;
            animation: brutalShake 0.2s ease;
        }
        .menu-btn:active {
            transform: translate(3px, 3px);
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
            transform: translate(-4px, -4px);
            box-shadow: 10px 10px 0px 0px #111 !important;
            background: var(--orange);
            color: #fff;
            animation: brutalShake 0.2s ease;
        }
        .nav-link:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0px 0px #111 !important;
        }
        .nav-link.active {
            background: var(--orange);
            color: #fff;
            box-shadow: var(--shadow-heavy);
        }

        /* ===== MAIN CONTENT ===== */
        .main-container { padding: 20px 16px; max-width: 700px; margin: 0 auto; }
        .section { display: none; animation: fadeInUp 0.4s ease; }
        .section.active { display: block; }

        .hero { text-align: center; }
        .slot-badge {
            display: inline-block;
            background: var(--orange) !important;
            color: #fff !important;
            padding: 3px 18px;
            border-radius: 0px;
            font-weight: 900;
            font-size: 12px;
            margin-bottom: 12px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            transform: rotate(-1deg);
        }
        .hero h1 {
            font-size: clamp(30px, 8vw, 44px);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            overflow: hidden;
            white-space: nowrap;
            animation: typing 2s steps(30) 1s forwards;
            width: 0;
        }
        .hero h1 span {
            background: var(--orange);
            color: #fff;
            padding: 0 12px;
            display: inline-block;
            transform: skew(-6deg) rotate(-2deg);
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

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            padding: 16px;
            margin-bottom: 16px;
            transition: var(--transition);
            position: relative;
        }
        .card:hover {
            transform: translate(-3px, -3px);
            box-shadow: 12px 12px 0px 0px #111 !important;
        }
        .card:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0px 0px #111 !important;
        }
        /* Corner accents */
        .card::before {
            content: '◆';
            position: absolute;
            top: -10px;
            left: -10px;
            font-size: 24px;
            color: var(--orange);
            background: #fff;
            padding: 0 4px;
            border: var(--border-thick);
            line-height: 1;
        }
        .card::after {
            content: '◆';
            position: absolute;
            bottom: -10px;
            right: -10px;
            font-size: 24px;
            color: var(--orange);
            background: #fff;
            padding: 0 4px;
            border: var(--border-thick);
            line-height: 1;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
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

        /* ===== SELECT BOX ===== */
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
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0px 0px #111 !important;
        }
        .select-box:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0px 0px #111 !important;
        }
        .select-box.active {
            background: var(--orange) !important;
            color: #fff !important;
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px 0px #111 !important;
        }
        .select-box.active i { color: #fff; }
        .select-box i { font-size: 22px; color: #111; margin-bottom: 6px; }
        .select-box h4 { font-size: 14px; font-weight: 900; }
        .select-box p { font-size: 10px; font-weight: 600; margin-top: 2px; opacity: 0.7; }

        /* ===== STATUS GRID ===== */
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
            transition: var(--transition);
        }
        .stat-box:hover {
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0px 0px #111 !important;
        }
        .stat-box:active {
            transform: translate(3px, 3px);
            box-shadow: 2px 2px 0px 0px #111 !important;
        }
        .stat-box h3 { font-size: 22px; font-weight: 900; }
        .stat-box p { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .text-orange { color: var(--orange); }
        .text-gold { color: var(--gold); }

        /* ===== BADGES ===== */
        .badge-status {
            padding: 3px 10px;
            border-radius: 0px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            transition: var(--transition);
        }
        .badge-status:hover {
            transform: scale(1.05) rotate(-2deg);
        }
        .bg-online { background: var(--green); color: #fff; }
        .bg-offline { background: var(--red); color: #fff; }
        .bg-pending { background: var(--gold); color: #111; }

        /* ===== SPEC ROW ===== */
        .spec-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 2px dashed #111;
            font-size: 13px;
            font-weight: 600;
        }
        .spec-row:last-child { border: none; }

        /* ===== SESSION ITEMS ===== */
        .session-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 2px dashed #111;
            flex-wrap: wrap;
            gap: 6px;
            transition: var(--transition);
        }
        .session-item:hover {
            padding-left: 8px;
            border-left: 6px solid var(--orange);
        }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 800; font-family: monospace; font-size: 13px; }
        .session-actions { display: flex; gap: 5px; flex-wrap: wrap; }

        /* ===== EARN BUTTON ===== */
        .earn-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--gold);
            color: #111;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            border-radius: 0px;
            font-weight: 900;
            font-size: 11px;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
        }
        .earn-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 8px 8px 0px 0px #111;
            animation: brutalShake 0.2s ease;
        }
        .earn-btn:active { transform: scale(0.96); }

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
        .toast.success { border-left: 12px solid var(--green); }
        .toast.error { border-left: 12px solid var(--red); }
        .toast.gold { border-left: 12px solid var(--gold); }
        .toast.info { border-left: 12px solid var(--neon-blue); }

        /* ===== TUTORIAL SPOTLIGHT ===== */
        .tutorial-overlay {
            position: fixed;
            inset: 0;
            z-index: 1300;
            display: none;
        }
        .tutorial-overlay.active { display: block; }
        .tutorial-dim {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            transition: clip-path 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .tutorial-spotlight-ring {
            position: absolute;
            border: 4px solid var(--orange);
            border-radius: 0px;
            box-shadow: 0 0 0 8px rgba(255,94,0,0.2), 0 0 30px rgba(255,94,0,0.3);
            transition: top 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                        left 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                        width 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                        height 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none;
            animation: pulseBorder 1.6s ease-in-out infinite;
        }
        .tutorial-arrow {
            position: absolute;
            font-size: 28px;
            color: var(--orange);
            filter: drop-shadow(2px 2px 0px #111);
            animation: float 1.4s ease-in-out infinite;
            pointer-events: none;
            z-index: 1302;
        }
        .tutorial-card {
            position: absolute;
            z-index: 1302;
            background: #fff;
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            border-radius: 0px;
            padding: 16px 18px;
            max-width: 260px;
            animation: fadeInUp 0.3s ease;
        }
        .tutorial-step-badge {
            display: inline-block;
            background: var(--gold);
            color: #111;
            font-size: 10px;
            font-weight: 900;
            padding: 2px 12px;
            border-radius: 0px;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }
        .tutorial-card h4 { font-size: 15px; font-weight: 900; margin-bottom: 4px; }
        .tutorial-card p { font-size: 12px; font-weight: 500; color: var(--text-muted); margin-bottom: 12px; line-height: 1.5; }
        .tutorial-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .tutorial-skip {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            background: none;
            border: var(--border-thick);
            padding: 4px 12px;
            cursor: pointer;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
        }
        .tutorial-skip:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0px 0px #111; }
        .tutorial-next { padding: 6px 16px; font-size: 11px; }
        .tutorial-dots { display: flex; gap: 4px; }
        .tutorial-dot {
            width: 8px;
            height: 8px;
            border-radius: 0px;
            background: #ccc;
            border: var(--border-thick);
            transition: var(--transition);
        }
        .tutorial-dot.active { background: var(--orange); width: 20px; }

        /* ===== INPUT FIELDS ===== */
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            transition: var(--transition);
        }
        input:focus,
        textarea:focus,
        select:focus {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #111 !important;
            outline: none;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 16px;
            height: 16px;
        }
        ::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-left: var(--border-thick);
            border-top: var(--border-thick);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--orange);
            border: var(--border-thick);
            border-radius: 0px;
            box-shadow: inset 2px 2px 0px 0px rgba(255,255,255,0.3);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--orange-hover);
        }
        ::-webkit-scrollbar-corner {
            background: #f0f0f0;
            border: var(--border-thick);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .hero h1 {
                white-space: normal;
                animation: none;
                width: auto;
            }
            .grid-2 { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr 1fr; }
            .navbar { padding: 8px 12px; }
            .login-card { padding: 28px 16px; }
            .pairing-box { padding: 20px 14px; }
            .pairing-code { font-size: 24px; letter-spacing: 4px; }
            .hide-mobile { display: none; }
            .card::before, .card::after {
                font-size: 18px;
                top: -6px;
                left: -6px;
                bottom: -6px;
                right: -6px;
            }
        }

        /* ===== PRINT STYLES ===== */
        @media print {
            .btn, .earn-btn, .menu-btn {
                display: none !important;
            }
            .card {
                box-shadow: none !important;
                border: 2px solid #111 !important;
            }
        }

        /* ===== EXTRA: STICKER ===== */
        .sticker {
            transform: rotate(-2deg);
            border: 4px solid #111;
            box-shadow: 8px 8px 0px 0px #111;
            background: var(--orange);
            color: white;
            padding: 8px 24px;
            display: inline-block;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 14px;
        }
        .sticker-gold {
            background: var(--gold);
            transform: rotate(3deg);
        }

        /* ===== EXTRA: PROGRESS BAR ===== */
        .progress-bar {
            width: 100%;
            height: 24px;
            background: #fff;
            border: var(--border-thick);
            box-shadow: inset 3px 3px 0px 0px #111;
            border-radius: 0px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: var(--orange);
            border-right: var(--border-thick);
            width: 0%;
            transition: width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ===== EXTRA: MARQUEE ===== */
        .marquee {
            background: #111;
            color: #fff;
            padding: 10px 0;
            overflow: hidden;
            white-space: nowrap;
            border-top: var(--border-thick);
            border-bottom: var(--border-thick);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 20s linear infinite;
        }

        /* ===== EXTRA: RIBBON ===== */
        .ribbon {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--orange);
            color: #fff;
            padding: 4px 20px;
            font-weight: 900;
            font-size: 11px;
            transform: rotate(6deg);
            border: var(--border-thick);
            box-shadow: 6px 6px 0px 0px #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .ribbon::before {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            border: 8px solid transparent;
            border-right-color: #111;
            border-bottom-color: #111;
        }
        .ribbon-gold {
            background: var(--gold);
            color: #111;
            transform: rotate(-4deg);
        }

        /* ===== EXTRA: TOGGLE ===== */
        .toggle {
            width: 64px;
            height: 32px;
            background: #fff;
            border: var(--border-thick);
            border-radius: 0px;
            cursor: pointer;
            position: relative;
            box-shadow: inset 3px 3px 0px 0px #111;
            transition: var(--transition);
        }
        .toggle::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 22px;
            height: 20px;
            background: var(--orange);
            border: var(--border-thick);
            transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .toggle.active::after {
            left: 35px;
            background: var(--green);
        }
        .toggle:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px 0px #111;
        }

        /* ===== EXTRA: TOOLTIP ===== */
        .tooltip {
            position: relative;
            cursor: help;
            border-bottom: 2px dashed #111;
        }
        .tooltip::after {
            content: attr(data-tip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #111;
            color: #fff;
            padding: 6px 16px;
            border: var(--border-thick);
            white-space: nowrap;
            font-size: 11px;
            font-weight: 700;
            opacity: 0;
            pointer-events: none;
            transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 999;
        }
        .tooltip:hover::after {
            opacity: 1;
            transform: translateX(-50%) translateY(-6px);
        }

        /* ===== EXTRA: GLITCH TEXT ===== */
        .glitch-text {
            animation: glitchText 2s infinite;
            position: relative;
        }

        /* ===== EXTRA: SIDEBAR NAV LINK ACTIVE ===== */
        .sidebar .nav-link.active {
            background: var(--orange);
            color: #fff;
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
            <button class="btn btn-orange btn-full" style="margin-top:12px;" onclick="copyPairingCode()">
                <i class="fas fa-copy"></i> Salin Kode
            </button>
            <button class="btn btn-close-modal btn-full" style="margin-top:6px;" onclick="closePairingModal()">Tutup</button>
        </div>
    </div>

    <!-- TUTORIAL SPOTLIGHT OVERLAY -->
    <div class="tutorial-overlay" id="tutorialOverlay">
        <div class="tutorial-dim" id="tutorialDim"></div>
        <div class="tutorial-spotlight-ring" id="tutorialRing"></div>
        <i class="fas fa-arrow-up tutorial-arrow" id="tutorialArrow"></i>
        <div class="tutorial-card" id="tutorialCard">
            <span class="tutorial-step-badge" id="tutorialStepBadge">STEP 1/5</span>
            <h4 id="tutorialTitle">Judul</h4>
            <p id="tutorialDesc">Deskripsi</p>
            <div class="tutorial-card-footer">
                <button class="tutorial-skip" onclick="skipTutorial()">Lewati</button>
                <div class="tutorial-dots" id="tutorialDots"></div>
                <button class="btn btn-orange tutorial-next" id="tutorialNextBtn" onclick="nextTutorialStep()">Lanjut <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-brand" id="tut-brand"><span class="brand-icon">✦</span> POLAR.ID</div>
        <div class="nav-right">
            <div class="coin-badge" id="coinBadge" data-tut="coin">
                <i class="fas fa-coins"></i>
                <span id="coinCount"><?= $user_coins ?></span>
            </div>
            <div class="profile-btn" id="profileBtn" data-tut="profile" onclick="navTo('profile')">
                <img src="<?= $user_avatar ?>" alt="Avatar">
                <span class="hide-mobile"><?= explode(' ', $user_name)[0] ?></span>
            </div>
            <button class="menu-btn" id="menuBtn" data-tut="menu" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="nav-brand" style="font-size:14px;animation:none;width:auto;"><span class="brand-icon">✦</span> MENU</div>
            <button class="sidebar-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        </div>
        <a href="#" class="nav-link" data-tut="nav-home" onclick="navTo('home'); toggleMenu();"><i class="fas fa-home"></i> HOME</a>
        <a href="#" class="nav-link" data-tut="nav-status" onclick="navTo('status'); toggleMenu();"><i class="fas fa-server"></i> STATUS</a>
        <a href="#" class="nav-link" data-tut="nav-claim" onclick="navTo('claim'); toggleMenu();"><i class="fas fa-download"></i> CLAIM</a>
        <a href="#" class="nav-link" data-tut="nav-sessions" onclick="navTo('sessions'); toggleMenu();"><i class="fas fa-robot"></i> SESSIONS</a>
        <a href="#" class="nav-link" data-tut="nav-profile" onclick="navTo('profile'); toggleMenu();"><i class="fas fa-user"></i> PROFILE</a>
        <a href="#" class="nav-link" onclick="toggleMenu(); setTimeout(startTutorial, 350);"><i class="fas fa-circle-question"></i> MULAI TUTORIAL</a>
        <a href="#" class="nav-link" data-tut="nav-earn" onclick="<?= $earn_flag_active ? 'return false;' : 'earnCoin()' ?>" style="background:var(--gold);border:var(--border-thick);box-shadow:var(--shadow-light);<?= $earn_flag_active ? 'opacity:0.5;cursor:not-allowed;' : '' ?>">
            <i class="fas fa-coins" style="color:#111;"></i> <?= $earn_flag_active ? 'MENUNGGU...' : 'EARN POLAR COIN' ?>
        </a>
        <a href="logout.php" class="nav-link" style="background:var(--red);color:#fff;margin-top:auto;"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-container">

        <!-- HOME -->
        <div id="sec-home" class="section active">
            <div class="hero">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size:8px;color:#fff;"></i> <?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1>Jadibot <br><span>WhatsApp Gratis</span></h1>
                <p>Dapatkan server bot gratis. Claim sekarang sebelum slot habis!</p>
                <div class="btn-group">
                    <button class="btn btn-orange" onclick="navTo('claim')"><i class="fas fa-download"></i> CLAIM SEKARANG</button>
                    <button class="btn btn-white" onclick="navTo('status')">LIHAT STATUS <i class="fas fa-arrow-right"></i></button>
                    <button class="btn btn-close-modal" onclick="startTutorial()" style="border:var(--border-thick);"><i class="fas fa-circle-question"></i> MULAI TUTORIAL</button>
                </div>
            </div>
        </div>

        <!-- CLAIM -->
        <div id="sec-claim" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge"><?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;animation:none;width:auto;white-space:normal;">CLAIM <span style="background:#111;color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">SERVER</span></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;">Pilih paket dan claim server bot gratis</p>
            </div>

            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="background:var(--orange);width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-weight:900;color:#fff;font-size:16px;border:var(--border-thick);box-shadow:var(--shadow-light);"><?= substr($user_name, 0, 1) ?></div>
                        <div><div style="font-size:9px;font-weight:700;color:var(--text-muted);">LOGIN AS</div><div style="font-weight:900;font-size:14px;"><?= $user_name ?></div></div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-weight:900;font-size:14px;"><i class="fas fa-coins"></i> <span id="claimCoinDisplay"><?= $user_coins ?></span></span>
                        <button class="earn-btn" id="earnBtnClaim" onclick="earnCoin()" <?= $earn_flag_active ? 'disabled style="font-size:9px;padding:3px 10px;opacity:0.5;cursor:not-allowed;"' : 'style="font-size:9px;padding:3px 10px;"' ?>><i class="fas <?= $earn_flag_active ? 'fa-clock' : 'fa-plus' ?>"></i></button>
                    </div>
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
                    <label style="font-size:11px;font-weight:800;color:var(--text-muted);display:block;margin-bottom:4px;text-transform:uppercase;">📱 Nomor WhatsApp</label>
                    <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" style="width:100%;padding:12px;background:#f0f0f0;border:var(--border-thick);box-shadow:inset 2px 2px 0px 0px #111;border-radius:0px;color:#111;font-size:14px;font-weight:600;">
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
                <div class="slot-badge" style="background:#111 !important;color:#fff !important;">REAL-TIME MONITORING</div>
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;animation:none;width:auto;white-space:normal;">SERVER <span style="background:var(--orange);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">STATUS</span></h1>
            </div>

            <div class="card">
                <div class="status-grid">
                    <div class="stat-box"><h3 class="text-orange"><?= $totalSessions ?></h3><p>TOTAL</p></div>
                    <div class="stat-box"><h3 class="text-gold"><?= $maxSessions - $totalSessions ?></h3><p>SLOT</p></div>
                    <div class="stat-box"><h3 style="color:#111;"><?= ($phoenix_status['online'] ? 1 : 0) + ($ourin_status['online'] ? 1 : 0) ?></h3><p>ONLINE</p></div>
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
                        <div><h3 style="font-size:14px;font-weight:900;">OURIN CORE</h3><div style="font-size:10px;font-weight:600;color:var(--text-muted);">Native</div></div>
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
                <h1 style="font-weight:900;font-size:clamp(26px,6vw,36px);text-transform:uppercase;animation:none;width:auto;white-space:normal;">MY <span style="background:var(--orange);color:#fff;padding:0 12px;transform:skew(-6deg);display:inline-block;border:var(--border-thick);box-shadow:var(--shadow-light);">BOTS</span></h1>
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
                            <div style="font-size:9px;font-weight:700;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars($s['script']) ?></div>
                        </div>
                        <div class="badge-status <?= $statusClass ?>"><?= $statusText ?></div>
                    </div>
                    <div style="display:flex;gap:5px;flex-wrap:wrap;margin-top:4px;">
                        <?php if ($s['status'] === 'waiting_pair' || $s['status'] === 'pending'): ?>
                        <button class="btn btn-sm btn-orange" onclick="openPairModal('<?= $s['phone'] ?>')"><i class="fas fa-link"></i> Pairing</button>
                        <?php endif; ?>
                        <?php if ($s['status'] === 'online'): ?>
                        <button class="btn btn-sm btn-success" onclick="showToast('Bot sedang online! ✅', 'success')"><i class="fas fa-circle"></i> Online</button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-danger" onclick="deleteSession(<?= $s['id'] ?>, '<?= $s['phone'] ?>')"><i class="fas fa-trash"></i> Hapus</button>
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
                <h1 style="font-weight:900;font-size:26px;margin-top:12px;text-transform:uppercase;animation:none;width:auto;white-space:normal;"><?= $user_name ?></h1>
                <p style="color:var(--text-muted);font-size:13px;font-weight:500;"><?= $user_email ?></p>
                <div style="background:#fff;border:var(--border-thick);box-shadow:var(--shadow-light);display:inline-flex;align-items:center;gap:12px;padding:6px 18px;margin-top:12px;">
                    <div style="font-weight:900;font-size:14px;"><i class="fas fa-coins"></i> <span id="profileCoinDisplay"><?= $user_coins ?></span></div>
                    <div style="font-size:10px;font-weight:800;letter-spacing:1px;color:var(--text-muted);">POLAR COIN</div>
                    <button class="earn-btn" id="earnBtnProfile" onclick="earnCoin()" <?= $earn_flag_active ? 'disabled style="font-size:9px;padding:3px 10px;opacity:0.5;cursor:not-allowed;"' : 'style="font-size:9px;padding:3px 10px;"' ?>><i class="fas <?= $earn_flag_active ? 'fa-clock' : 'fa-plus' ?>"></i> <?= $earn_flag_active ? 'MENUNGGU' : 'EARN' ?></button>
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
    </div>

    <script>
        // ========== KONFIGURASI ==========
        const SB_URL = '<?= SUPABASE_URL ?>';
        const SB_KEY = '<?= SUPABASE_KEY ?>';
        const MAX_SESSIONS = <?= $maxSessions ?>;
        let selectedDays = 1;
        let selectedCoin = 1;
        let isProcessing = false;
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

        // ========== EARN COIN (Session Flag) ==========
        const EARN_FLAG_ACTIVE = <?= $earn_flag_active ? 'true' : 'false' ?>;
        function earnCoin() {
            if (EARN_FLAG_ACTIVE) {
                showToast('⏳ Selesaikan dulu earn coin yang sedang berjalan!', 'error');
                return;
            }
            window.location.href = 'start-earn.php';
        }

        // ========== HANDLE REDIRECT BALIK DARI earn-coin.php ==========
        function checkEarnCoinReturn() {
            const params = new URLSearchParams(window.location.search);
            const earn = params.get('earn');
            if (!earn) return;

            history.replaceState(null, '', window.location.pathname);

            if (earn === 'success') {
                const coins = params.get('coins') || '?';
                showToast('🎉 +1 Polar Coin berhasil diklaim! Total: ' + coins + ' 🪙', 'gold');
                document.querySelectorAll('#coinCount, #claimCoinDisplay, #profileCoinDisplay').forEach(el => {
                    if (el) el.textContent = coins;
                });
            } else if (earn === 'expired') {
                showToast('⏰ Link kadaluarsa. Silakan earn coin lagi.', 'error');
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
                const coinRes = await fetch('update-coin.php?amount=' + (-coin));
                const coinData = await coinRes.json();
                if (!coinData.success) throw new Error('Gagal update coin');

                const fingerprint = '<?= $fingerprint ?>';
                const token = 'COIN_' + Date.now();
                
                await supabaseRequest('POST', 'polar_sessions', {
                    fingerprint: fingerprint,
                    phone: cleanPhone,
                    script: script,
                    status: 'pending',
                    bot_mode: 'public',
                    token_used: token,
                    pairing_code: null,
                    created_at: Date.now(),
                    expiry_days: days
                });

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

        // ========== DELETE SESSION ==========
        async function deleteSession(id, phone) {
            if (!confirm(`Hapus session +${phone}?`)) return;
            try {
                await supabaseRequest('DELETE', `polar_sessions?id=eq.${id}`);
                showToast('✅ Session dihapus', 'success');
                setTimeout(() => location.reload(), 1000);
            } catch(e) {
                showToast('❌ ' + e.message, 'error');
            }
        }

        // ========== OPEN PAIRING ==========
        function openPairModal(phone) {
            showPairingModal(phone);
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

        // ========== TUTORIAL SPOTLIGHT ==========
        const TUTORIAL_STEPS = [
            {
                selector: '#tut-brand',
                title: 'Selamat Datang di Polar.id! 👋',
                desc: 'Ini logo Polar.id. Yuk kenalan dulu sama bagian-bagian penting di dashboard.',
                arrow: 'down'
            },
            {
                selector: '[data-tut="coin"]',
                title: 'Polar Coin 🪙',
                desc: 'Ini saldo Polar Coin kamu. Coin dipakai untuk claim server bot WhatsApp.',
                arrow: 'down'
            },
            {
                selector: '[data-tut="profile"]',
                title: 'Profil Kamu',
                desc: 'Tap di sini buat lihat profil, statistik, dan info akun Google kamu.',
                arrow: 'down'
            },
            {
                selector: '[data-tut="menu"]',
                title: 'Menu Navigasi ☰',
                desc: 'Tombol ini buka menu utama buat pindah-pindah halaman dashboard.',
                arrow: 'down'
            }
        ];
        let tutStep = 0;
        let tutSidebarOpened = false;

        function getTutorialSidebarSteps() {
            return [
                { selector: '[data-tut="nav-home"]', title: 'Home', desc: 'Halaman utama buat claim server dengan cepat.', arrow: 'left' },
                { selector: '[data-tut="nav-status"]', title: 'Status Server', desc: 'Pantau status server Phoenix MD & Ourin secara real-time.', arrow: 'left' },
                { selector: '[data-tut="nav-claim"]', title: 'Claim Server', desc: 'Pilih paket, masukkan nomor WhatsApp, dan claim bot gratis di sini.', arrow: 'left' },
                { selector: '[data-tut="nav-sessions"]', title: 'My Bots', desc: 'Lihat semua bot WhatsApp yang sudah kamu claim dan kelola statusnya.', arrow: 'left' },
                { selector: '[data-tut="nav-earn"]', title: 'Earn Polar Coin', desc: 'Dapatkan Polar Coin gratis di sini buat claim lebih banyak server.', arrow: 'left' }
            ];
        }

        function allTutorialSteps() {
            return TUTORIAL_STEPS.concat(getTutorialSidebarSteps());
        }

        function positionTutorialStep(step) {
            const el = document.querySelector(step.selector);
            if (!el) { nextTutorialStep(); return; }

            const rect = el.getBoundingClientRect();
            const pad = 8;
            const ring = document.getElementById('tutorialRing');
            const arrow = document.getElementById('tutorialArrow');
            const card = document.getElementById('tutorialCard');

            ring.style.top = (rect.top - pad) + 'px';
            ring.style.left = (rect.left - pad) + 'px';
            ring.style.width = (rect.width + pad * 2) + 'px';
            ring.style.height = (rect.height + pad * 2) + 'px';

            const dim = document.getElementById('tutorialDim');
            const top = rect.top - pad, left = rect.left - pad, right = rect.right + pad, bottom = rect.bottom + pad;
            dim.style.clipPath = `polygon(
                0 0, 100% 0, 100% 100%, 0 100%, 0 0,
                ${left}px ${top}px, ${right}px ${top}px, ${right}px ${bottom}px, ${left}px ${bottom}px, ${left}px ${top}px
            )`;

            arrow.className = 'tutorial-arrow fas fa-arrow-' + (step.arrow === 'left' ? 'right' : 'up');
            let cardTop, cardLeft, arrowTop, arrowLeft;

            const vw = window.innerWidth;
            const vh = window.innerHeight;
            const isMobile = vw < 540;
            const cardW = Math.min(260, vw - 24);

            if (step.arrow === 'left') {
                arrowTop = rect.top + rect.height / 2 - 13;
                arrowLeft = rect.left - 38;

                if (!isMobile) {
                    cardTop = rect.top + rect.height / 2 - 60;
                    cardLeft = rect.left - cardW - 20;
                    if (cardLeft < 10) {
                        cardLeft = rect.right + 20;
                        arrow.className = 'tutorial-arrow fas fa-arrow-left';
                        arrowLeft = rect.right + 8;
                    }
                } else {
                    cardLeft = (vw - cardW) / 2;
                    cardTop = vh - 200;
                    if (rect.top > vh * 0.6) cardTop = rect.top - 180;
                    arrowTop = rect.bottom + 6;
                    arrowLeft = rect.left + rect.width / 2 - 13;
                    arrow.className = 'tutorial-arrow fas fa-arrow-up';
                }
            } else {
                arrowTop = rect.bottom + 8;
                arrowLeft = rect.left + rect.width / 2 - 13;
                cardTop = rect.bottom + 40;
                cardLeft = Math.max(10, Math.min(vw - cardW - 10, rect.left + rect.width / 2 - cardW / 2));
                if (cardTop + 160 > vh) {
                    cardTop = rect.top - 160;
                    arrowTop = rect.top - 34;
                    arrow.className = 'tutorial-arrow fas fa-arrow-down';
                }
            }

            cardTop = Math.max(10, Math.min(cardTop, vh - 180));
            cardLeft = Math.max(10, Math.min(cardLeft, vw - cardW - 10));

            card.style.width = cardW + 'px';

            arrow.style.top = arrowTop + 'px';
            arrow.style.left = arrowLeft + 'px';
            card.style.top = cardTop + 'px';
            card.style.left = cardLeft + 'px';

            document.getElementById('tutorialTitle').textContent = step.title;
            document.getElementById('tutorialDesc').textContent = step.desc;
        }

        function renderTutorialDots(total) {
            const dotsEl = document.getElementById('tutorialDots');
            dotsEl.innerHTML = '';
            for (let i = 0; i < total; i++) {
                const dot = document.createElement('span');
                dot.className = 'tutorial-dot' + (i === tutStep ? ' active' : '');
                dotsEl.appendChild(dot);
            }
        }

        function showTutorialStep() {
            const steps = allTutorialSteps();
            if (tutStep >= steps.length) { finishTutorial(); return; }

            if (tutStep >= TUTORIAL_STEPS.length && !tutSidebarOpened) {
                document.getElementById('sidebar').classList.add('active');
                document.getElementById('sidebarOverlay').classList.add('active');
                tutSidebarOpened = true;
            }

            const total = steps.length;
            document.getElementById('tutorialStepBadge').textContent = `STEP ${tutStep + 1}/${total}`;
            document.getElementById('tutorialNextBtn').innerHTML = (tutStep === total - 1)
                ? 'Selesai <i class="fas fa-check"></i>'
                : 'Lanjut <i class="fas fa-arrow-right"></i>';
            renderTutorialDots(total);

            requestAnimationFrame(() => {
                setTimeout(() => positionTutorialStep(steps[tutStep]), tutSidebarOpened && tutStep === TUTORIAL_STEPS.length ? 320 : 0);
            });
        }

        function nextTutorialStep() {
            tutStep++;
            showTutorialStep();
        }

        function startTutorial() {
            tutStep = 0;
            tutSidebarOpened = false;
            document.getElementById('tutorialOverlay').classList.add('active');
            showTutorialStep();
        }

        function skipTutorial() { finishTutorial(); }

        function finishTutorial() {
            document.getElementById('tutorialOverlay').classList.remove('active');
            if (tutSidebarOpened) {
                document.getElementById('sidebar').classList.remove('active');
                document.getElementById('sidebarOverlay').classList.remove('active');
            }
            const uid = '<?= $_SESSION['user_google_id'] ?? '' ?>';
            try { localStorage.setItem('polar_tutorial_done_' + uid, '1'); } catch(e) {}
        }

        window.addEventListener('resize', () => {
            const overlay = document.getElementById('tutorialOverlay');
            if (overlay.classList.contains('active')) {
                const steps = allTutorialSteps();
                positionTutorialStep(steps[tutStep]);
            }
        });

        // ========== INIT ==========
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(updateCoinDisplay, 30000);
            checkEarnCoinReturn();
        });

        document.getElementById('pairingOverlay').addEventListener('click', function(e) {
            if (e.target === this) closePairingModal();
        });

        // ========== SESSION KEEP ALIVE ==========
        // Kirim ping setiap 5 menit untuk keep session alive
        setInterval(() => {
            fetch('keep-alive.php', { 
                method: 'POST',
                cache: 'no-cache'
            }).catch(() => {});
        }, 300000);
    </script>
</body>
</html>
