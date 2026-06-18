<?php
session_start();
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
        
        $_SESSION['user_google_id'] = $user_data['id'];
        $_SESSION['user_name'] = $user_data['name'] ?? 'User';
        $_SESSION['user_email'] = $user_data['email'] ?? '';
        $_SESSION['user_avatar'] = $user_data['picture'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user_data['name'] ?? 'User') . '&background=FF6B00&color=fff';
        $_SESSION['user_coins'] = 0;
        
        header('Location: dashboard.php');
        exit;
    }
}

// ========== CEK LOGIN ==========
$is_logged_in = isset($_SESSION['user_google_id']);
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-main: #0a0a0f;
            --bg-card: #14141e;
            --bg-nav: #0f0f17;
            --orange: #FF6B00;
            --orange-hover: #e05e00;
            --orange-glow: rgba(255,107,0,0.3);
            --white: #ffffff;
            --gold: #fbbf24;
            --gold-glow: rgba(251,191,36,0.2);
            --text-main: #ffffff;
            --text-muted: #8b8b9b;
            --border: #2a2a35;
            --green: #22c55e;
            --red: #ef4444;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: radial-gradient(circle at 20% 50%, rgba(255,107,0,0.03) 0%, transparent 50%),
                              radial-gradient(circle at 80% 50%, rgba(255,107,0,0.03) 0%, transparent 50%);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes glow { 0%,100% { box-shadow: 0 0 20px var(--orange-glow); } 50% { box-shadow: 0 0 40px var(--orange-glow); } }
        @keyframes coinSpin { 0% { transform: rotateY(0); } 100% { transform: rotateY(360deg); } }
        .animate-in { animation: fadeInUp 0.5s ease forwards; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-glow { animation: glow 2s ease-in-out infinite; }
        .animate-coin { animation: coinSpin 1s ease forwards; }

        /* ===== LOGIN POPUP ===== */
        .login-overlay {
            position: fixed; inset: 0; background: rgba(10,10,15,0.55); backdrop-filter: blur(10px);
            z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px;
            animation: fadeInUp 0.5s ease;
        }
        /* Dashboard tetap terlihat samar di belakang popup login */
        body.locked-bg .navbar,
        body.locked-bg .main-container,
        body.locked-bg .sidebar,
        body.locked-bg .sidebar-overlay {
            filter: blur(4px) brightness(0.55) saturate(0.7);
            pointer-events: none;
            user-select: none;
        }
        .login-card {
            background: var(--bg-card);
            border: 2px solid var(--orange);
            border-radius: 24px;
            padding: 48px 36px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            position: relative;
            animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 30px 80px rgba(255,107,0,0.15);
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 20%;
            right: 20%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--orange), transparent);
            border-radius: 10px;
        }
        .login-badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%) skew(-5deg);
            background: var(--gold);
            color: #000;
            padding: 4px 24px;
            font-weight: 900;
            font-size: 11px;
            border-radius: 10px;
            letter-spacing: 1.5px;
        }
        .login-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #000;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px rgba(255,107,0,0.2);
        }
        .login-card h2 { font-size: 32px; font-weight: 900; margin-bottom: 6px; color: var(--text-main); }
        .login-card p { color: var(--text-muted); font-size: 14px; margin-bottom: 28px; }
        .google-btn-login {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            text-decoration: none;
            transition: var(--transition);
            text-align: left;
        }
        .google-btn-login:hover {
            border-color: var(--orange);
            background: rgba(255,107,0,0.08);
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255,107,0,0.1);
        }
        .g-icon {
            background: white;
            border-radius: 50%;
            padding: 6px;
            width: 34px;
            height: 34px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .g-icon img { width: 20px; height: 20px; }
        .login-footer { margin-top: 20px; font-size: 11px; color: var(--text-muted); }

        /* ===== LOADING MODAL ===== */
        .loading-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);
            z-index: 1100; display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .loading-overlay.active { display: flex; }
        .loading-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 28px;
            max-width: 380px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.3s ease;
        }
        .loading-spinner {
            width: 44px;
            height: 44px;
            border: 4px solid var(--border);
            border-top-color: var(--orange);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 12px;
        }
        .loading-title { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
        .loading-desc { font-size: 12px; color: var(--text-muted); }

        /* ===== PAIRING MODAL ===== */
        .pairing-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(12px);
            z-index: 1101; display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .pairing-overlay.active { display: flex; animation: fadeInUp 0.4s ease; }
        .pairing-box {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px 24px;
            max-width: 400px;
            width: 100%;
            animation: slideUp 0.5s ease;
        }
        .pairing-code {
            background: var(--bg-main);
            border: 2px dashed var(--orange);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 6px;
            font-family: monospace;
            color: var(--orange);
            margin: 12px 0;
        }
        .pairing-box ol { font-size: 12px; color: var(--text-muted); padding-left: 20px; line-height: 2; }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .btn-orange { background: linear-gradient(135deg, var(--orange), var(--orange-hover)); color: white; box-shadow: 0 4px 20px var(--orange-glow); }
        .btn-orange:hover { transform: translateY(-2px); box-shadow: 0 8px 30px var(--orange-glow); }
        .btn-white { background: var(--white); color: #000; }
        .btn-white:hover { background: #e0e0e0; transform: translateY(-2px); }
        .btn-gold { background: linear-gradient(135deg, var(--gold), #f59e0b); color: #000; }
        .btn-gold:hover { transform: translateY(-2px); }
        .btn-sm { padding: 5px 10px; font-size: 10px; border-radius: 6px; }
        .btn-danger { background: var(--red); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-success { background: var(--green); color: white; }
        .btn-success:hover { background: #16a34a; }
        .btn-close-modal { background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: var(--text-muted); }
        .btn-close-modal:hover { background: rgba(255,255,255,0.1); }
        .btn-full { width: 100%; justify-content: center; }

        /* ===== NAVBAR ===== */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            background: rgba(15,15,23,0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 8px; font-weight: 900; font-size: 17px; text-transform: uppercase; letter-spacing: 0.5px; }
        .brand-icon { background: linear-gradient(135deg, var(--orange), var(--orange-hover)); color: white; padding: 4px 10px; border-radius: 8px; transform: skew(-6deg); font-size: 14px; }
        .nav-right { display: flex; align-items: center; gap: 8px; }
        .coin-badge { background: rgba(251,191,36,0.1); border: 1px solid var(--gold); color: var(--gold); padding: 4px 12px; border-radius: 30px; font-weight: 700; font-size: 11px; display: flex; align-items: center; gap: 5px; cursor: default; }
        .coin-badge i { animation: coinSpin 3s linear infinite; }
        .profile-btn { display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.05); padding: 3px 10px 3px 3px; border-radius: 30px; cursor: pointer; transition: var(--transition); border: 1px solid transparent; }
        .profile-btn:hover { background: rgba(255,255,255,0.08); border-color: var(--orange); }
        .profile-btn img { width: 26px; height: 26px; border-radius: 50%; border: 2px solid var(--orange); }
        .profile-btn span { font-size: 11px; font-weight: 600; }
        .menu-btn { background: var(--orange); color: white; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 14px; cursor: pointer; transition: var(--transition); }
        .menu-btn:hover { transform: scale(1.08); background: var(--orange-hover); }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); z-index: 998; opacity: 0; visibility: hidden; transition: var(--transition); }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }
        .sidebar { position: fixed; top: 0; right: -300px; width: 270px; height: 100vh; background: var(--bg-nav); border-left: 1px solid var(--border); z-index: 999; padding: 20px; transition: var(--transition); display: flex; flex-direction: column; gap: 6px; }
        .sidebar.active { right: 0; }
        .sidebar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 12px; }
        .sidebar-close { background: var(--white); color: #000; border: none; width: 28px; height: 28px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: var(--transition); }
        .sidebar-close:hover { transform: rotate(90deg); background: var(--orange); color: white; }
        .nav-link { padding: 10px 14px; color: var(--text-muted); text-decoration: none; font-weight: 600; border-radius: 8px; transition: var(--transition); display: flex; align-items: center; gap: 10px; background: var(--bg-card); font-size: 13px; }
        .nav-link:hover, .nav-link.active { background: var(--orange); color: white; transform: translateX(4px); box-shadow: 0 4px 20px var(--orange-glow); }

        /* ===== MAIN CONTENT ===== */
        .main-container { padding: 20px 16px; max-width: 700px; margin: 0 auto; }
        .section { display: none; animation: fadeInUp 0.4s ease; }
        .section.active { display: block; }

        .hero { text-align: center; }
        .slot-badge { display: inline-block; background: var(--white); color: #000; padding: 3px 14px; border-radius: 30px; font-weight: 800; font-size: 11px; margin-bottom: 12px; }
        .hero h1 { font-size: clamp(28px, 7vw, 40px); font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
        .hero h1 span { background: linear-gradient(135deg, var(--gold), var(--orange)); color: #000; padding: 0 10px; display: inline-block; transform: skew(-5deg); }
        .hero p { color: var(--text-muted); font-size: 13px; margin-bottom: 24px; max-width: 380px; margin: 0 auto 24px; }
        .btn-group { display: flex; flex-direction: column; gap: 10px; align-items: center; }
        .btn-group .btn { width: 100%; }

        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 16px; margin-bottom: 16px; transition: var(--transition); }
        .card:hover { border-color: var(--orange); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .section-title { background: var(--gold); color: #000; display: inline-block; padding: 3px 12px; font-weight: 800; font-size: 10px; border-radius: 5px; margin-bottom: 12px; letter-spacing: 0.5px; }

        .select-box { background: var(--bg-main); border: 2px solid var(--border); border-radius: 10px; padding: 14px; text-align: center; cursor: pointer; transition: var(--transition); }
        .select-box:hover { border-color: var(--white); transform: translateY(-2px); }
        .select-box.active { border-color: var(--orange); background: rgba(255,107,0,0.06); }
        .select-box i { font-size: 20px; color: var(--text-muted); margin-bottom: 8px; transition: var(--transition); }
        .select-box.active i { color: var(--orange); }
        .select-box h4 { font-size: 13px; font-weight: 800; }
        .select-box p { font-size: 10px; color: var(--text-muted); margin-top: 3px; }

        .status-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 16px; text-align: center; }
        .stat-box { background: var(--bg-main); padding: 12px 8px; border-radius: 8px; border: 1px solid var(--border); }
        .stat-box h3 { font-size: 18px; font-weight: 900; }
        .stat-box p { font-size: 9px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
        .text-orange { color: var(--orange); }
        .text-gold { color: var(--gold); }
        .badge-status { padding: 3px 10px; border-radius: 5px; font-size: 9px; font-weight: 800; text-transform: uppercase; }
        .bg-online { background: rgba(34,197,94,0.12); color: var(--green); border: 1px solid var(--green); }
        .bg-offline { background: rgba(239,68,68,0.12); color: var(--red); border: 1px solid var(--red); }
        .bg-pending { background: rgba(255,204,0,0.12); color: var(--gold); border: 1px solid var(--gold); }
        .spec-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed var(--border); font-size: 12px; }
        .spec-row:last-child { border: none; }

        .session-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 6px; }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 600; font-family: monospace; font-size: 12px; }
        .session-actions { display: flex; gap: 5px; flex-wrap: wrap; }

        .earn-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: linear-gradient(135deg, var(--gold), var(--orange)); color: #000; border: none; border-radius: 8px; font-weight: 800; font-size: 11px; cursor: pointer; transition: var(--transition); }
        .earn-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(251,191,36,0.2); }
        .earn-btn:active { transform: scale(0.97); }

        /* ===== TOAST ===== */
        .toast { position: fixed; bottom: 20px; right: 20px; background: var(--bg-card); border: 1px solid var(--border); color: white; padding: 12px 18px; border-radius: 12px; font-size: 13px; z-index: 1200; box-shadow: 0 8px 40px rgba(0,0,0,0.5); display: none; max-width: 340px; animation: slideUp 0.3s ease; }
        .toast.success { border-left: 4px solid var(--green); }
        .toast.error { border-left: 4px solid var(--red); }
        .toast.gold { border-left: 4px solid var(--gold); }

        /* ===== TUTORIAL SPOTLIGHT ===== */
        .tutorial-overlay {
            position: fixed; inset: 0; z-index: 1300; display: none;
        }
        .tutorial-overlay.active { display: block; }
        .tutorial-dim {
            position: fixed; inset: 0;
            background: rgba(5,5,8,0.78);
            transition: clip-path 0.35s cubic-bezier(0.4,0,0.2,1), background 0.3s ease;
        }
        .tutorial-spotlight-ring {
            position: absolute;
            border: 3px solid var(--orange);
            border-radius: 14px;
            box-shadow: 0 0 0 6px rgba(255,107,0,0.18), 0 0 30px rgba(255,107,0,0.35);
            transition: top 0.35s cubic-bezier(0.4,0,0.2,1), left 0.35s cubic-bezier(0.4,0,0.2,1),
                        width 0.35s cubic-bezier(0.4,0,0.2,1), height 0.35s cubic-bezier(0.4,0,0.2,1);
            pointer-events: none;
            animation: tutorialPulse 1.6s ease-in-out infinite;
        }
        @keyframes tutorialPulse {
            0%,100% { box-shadow: 0 0 0 6px rgba(255,107,0,0.18), 0 0 30px rgba(255,107,0,0.35); }
            50% { box-shadow: 0 0 0 10px rgba(255,107,0,0.1), 0 0 45px rgba(255,107,0,0.5); }
        }
        .tutorial-arrow {
            position: absolute;
            font-size: 26px;
            color: var(--orange);
            filter: drop-shadow(0 0 8px rgba(255,107,0,0.6));
            animation: tutorialBounce 1.2s ease-in-out infinite;
            pointer-events: none;
            z-index: 1302;
        }
        @keyframes tutorialBounce {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .tutorial-card {
            position: absolute;
            z-index: 1302;
            background: var(--bg-card);
            border: 2px solid var(--orange);
            border-radius: 16px;
            padding: 16px 18px;
            max-width: 260px;
            box-shadow: 0 16px 50px rgba(0,0,0,0.5);
            animation: fadeInUp 0.35s ease;
        }
        .tutorial-step-badge {
            display: inline-block;
            background: var(--gold);
            color: #000;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .tutorial-card h4 { font-size: 14px; font-weight: 800; margin-bottom: 4px; }
        .tutorial-card p { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; line-height: 1.5; }
        .tutorial-card-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .tutorial-skip { font-size: 11px; color: var(--text-muted); background: none; border: none; cursor: pointer; font-weight: 600; text-decoration: underline; }
        .tutorial-next { padding: 7px 16px; font-size: 11px; }
        .tutorial-dots { display: flex; gap: 4px; }
        .tutorial-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--border); transition: var(--transition); }
        .tutorial-dot.active { background: var(--orange); width: 16px; border-radius: 4px; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .hero h1 { font-size: 26px; }
            .grid-2 { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr 1fr; }
            .navbar { padding: 8px 12px; }
            .login-card { padding: 32px 20px; }
            .pairing-box { padding: 24px 16px; }
            .pairing-code { font-size: 22px; letter-spacing: 4px; }
        }
    </style>
</head>
<body class="<?= !$is_logged_in ? 'locked-bg' : '' ?>">
<?php if (!$is_logged_in): ?>
    <!-- LOGIN POPUP (mengambang di atas dashboard yang diblur) -->
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
                        <div style="font-size:14px;font-weight:700;">Login dengan Google</div>
                        <div style="font-size:11px;color:var(--text-muted);">Aman & cepat</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right" style="color:var(--text-muted);"></i>
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
                <h3 style="font-weight:800;font-size:18px;margin-top:6px;">Tautkan Perangkat</h3>
                <p style="color:var(--text-muted);font-size:12px;">Scan atau masukkan kode di WhatsApp</p>
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
            <div class="nav-brand" style="font-size:14px;"><span class="brand-icon">✦</span> MENU</div>
            <button class="sidebar-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        </div>
        <a href="#" class="nav-link active" data-tut="nav-home" onclick="navTo('home'); toggleMenu();"><i class="fas fa-home"></i> HOME</a>
        <a href="#" class="nav-link" data-tut="nav-status" onclick="navTo('status'); toggleMenu();"><i class="fas fa-server"></i> STATUS</a>
        <a href="#" class="nav-link" data-tut="nav-claim" onclick="navTo('claim'); toggleMenu();"><i class="fas fa-download"></i> CLAIM</a>
        <a href="#" class="nav-link" data-tut="nav-sessions" onclick="navTo('sessions'); toggleMenu();"><i class="fas fa-robot"></i> SESSIONS</a>
        <a href="#" class="nav-link" data-tut="nav-profile" onclick="navTo('profile'); toggleMenu();"><i class="fas fa-user"></i> PROFILE</a>
        <a href="#" class="nav-link" data-tut="nav-earn" onclick="earnCoin()" style="background:linear-gradient(135deg,rgba(255,107,0,0.1),rgba(251,191,36,0.05));border:1px solid var(--orange);">
            <i class="fas fa-coins" style="color:var(--gold);"></i> EARN POLAR COIN
        </a>
        <a href="logout.php" class="nav-link" style="color:var(--orange);margin-top:auto;"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
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
                </div>
            </div>
        </div>

        <!-- CLAIM -->
        <div id="sec-claim" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge"><?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1 style="font-weight:900;font-size:clamp(24px,5vw,32px);text-transform:uppercase;">CLAIM <span style="background:var(--white);color:#000;padding:0 10px;transform:skew(-5deg);display:inline-block;">SERVER</span></h1>
                <p style="color:var(--text-muted);font-size:12px;">Pilih paket dan claim server bot gratis</p>
            </div>

            <div class="card">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="background:linear-gradient(135deg,var(--gold),var(--orange));width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:900;color:#000;font-size:14px;"><?= substr($user_name, 0, 1) ?></div>
                        <div><div style="font-size:9px;color:var(--text-muted);font-weight:600;">LOGIN AS</div><div style="font-weight:700;font-size:13px;"><?= $user_name ?></div></div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="color:var(--gold);font-weight:700;font-size:13px;"><i class="fas fa-coins"></i> <span id="claimCoinDisplay"><?= $user_coins ?></span></span>
                        <button class="earn-btn" onclick="earnCoin()" style="font-size:9px;padding:3px 10px;"><i class="fas fa-plus"></i></button>
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
                    <p style="color:var(--gold);font-size:11px;">🪙 <?= $pkg['coin'] ?> Polar Coin</p>
                    <?php if (!$isActive): ?><p style="color:var(--red);font-size:9px;margin-top:2px;">Koin tidak cukup</p><?php endif; ?>
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
                    <label style="font-size:11px;font-weight:600;color:var(--text-muted);display:block;margin-bottom:4px;">📱 Nomor WhatsApp</label>
                    <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" style="width:100%;padding:12px;background:var(--bg-main);border:1px solid var(--border);border-radius:8px;color:white;font-size:13px;">
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
                <div class="slot-badge" style="background:var(--white);color:#000;">REAL-TIME MONITORING</div>
                <h1 style="font-weight:900;font-size:clamp(24px,5vw,32px);text-transform:uppercase;">SERVER <span style="background:var(--orange);color:white;padding:0 10px;transform:skew(-5deg);display:inline-block;">STATUS</span></h1>
            </div>

            <div class="card">
                <div class="status-grid">
                    <div class="stat-box"><h3 class="text-orange"><?= $totalSessions ?></h3><p>TOTAL</p></div>
                    <div class="stat-box"><h3 class="text-gold"><?= $maxSessions - $totalSessions ?></h3><p>SLOT</p></div>
                    <div class="stat-box"><h3 class="text-white"><?= ($phoenix_status['online'] ? 1 : 0) + ($ourin_status['online'] ? 1 : 0) ?></h3><p>ONLINE</p></div>
                    <div class="stat-box"><h3 class="text-orange"><?= (!$phoenix_status['online'] ? 1 : 0) + (!$ourin_status['online'] ? 1 : 0) ?></h3><p>OFFLINE</p></div>
                </div>
            </div>

            <div class="card" style="border-color:<?= $phoenix_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="background:var(--orange);padding:8px;border-radius:8px;"><i class="fas fa-server" style="color:white;font-size:14px;"></i></div>
                        <div><h3 style="font-size:14px;font-weight:900;">PHOENIX MD</h3><div style="font-size:10px;color:var(--text-muted);">Pterodactyl</div></div>
                    </div>
                    <div class="badge-status <?= $phoenix_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $phoenix_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="color:var(--text-muted);">RAM</span><span style="font-weight:bold;"><?= $phoenix_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color:var(--text-muted);">PING</span><span style="font-weight:bold;"><?= $phoenix_status['ping'] ?></span></div>
            </div>

            <div class="card" style="border-color:<?= $ourin_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="background:var(--white);padding:8px;border-radius:8px;"><i class="fas fa-microchip" style="color:#000;font-size:14px;"></i></div>
                        <div><h3 style="font-size:14px;font-weight:900;">OURIN CORE</h3><div style="font-size:10px;color:var(--text-muted);">Native</div></div>
                    </div>
                    <div class="badge-status <?= $ourin_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $ourin_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="color:var(--text-muted);">RAM</span><span style="font-weight:bold;"><?= $ourin_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color:var(--text-muted);">PING</span><span style="font-weight:bold;"><?= $ourin_status['ping'] ?></span></div>
            </div>
        </div>

        <!-- SESSIONS -->
        <div id="sec-sessions" class="section">
            <div style="text-align:center;margin-bottom:16px;">
                <div class="slot-badge"><?= $totalSessions ?> / <?= $maxSessions ?> SESSION</div>
                <h1 style="font-weight:900;font-size:clamp(24px,5vw,32px);text-transform:uppercase;">MY <span style="background:var(--orange);color:white;padding:0 10px;transform:skew(-5deg);display:inline-block;">BOTS</span></h1>
            </div>

            <?php if (empty($sessions)): ?>
            <div class="card" style="text-align:center;padding:40px 16px;">
                <div style="font-size:48px;margin-bottom:12px;opacity:0.3;">🤖</div>
                <h3 style="font-weight:700;font-size:18px;">Belum Ada Bot</h3>
                <p style="color:var(--text-muted);font-size:12px;margin-top:4px;">Claim server dulu untuk mulai menggunakan bot</p>
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
                            <div style="font-size:9px;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars($s['script']) ?></div>
                        </div>
                        <div class="session-status <?= $statusClass ?>"><?= $statusText ?></div>
                    </div>
                    <div style="display:flex;gap:5px;flex-wrap:wrap;">
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
                    <img src="<?= $user_avatar ?>" style="width:80px;height:80px;border-radius:50%;border:4px solid var(--orange);">
                    <div style="position:absolute;top:0;right:-8px;background:var(--orange);color:white;padding:2px 10px;font-size:9px;font-weight:800;border-radius:8px;transform:rotate(12deg);">✦ YOU!</div>
                </div>
                <h1 style="font-weight:900;font-size:24px;margin-top:12px;"><?= $user_name ?></h1>
                <p style="color:var(--text-muted);font-size:12px;"><?= $user_email ?></p>
                <div style="background:rgba(255,255,255,0.05);border:1px solid var(--border);display:inline-flex;align-items:center;gap:12px;padding:6px 18px;border-radius:50px;margin-top:12px;">
                    <div style="font-weight:700;color:var(--gold);font-size:13px;"><i class="fas fa-coins"></i> <span id="profileCoinDisplay"><?= $user_coins ?></span></div>
                    <div style="font-size:10px;font-weight:700;letter-spacing:1px;color:var(--text-muted);">POLAR COIN</div>
                    <button class="earn-btn" onclick="earnCoin()" style="font-size:9px;padding:3px 10px;"><i class="fas fa-plus"></i> EARN</button>
                </div>
                <div style="margin-top:12px;">
                    <a href="logout.php" style="color:var(--text-muted);font-size:11px;font-weight:600;text-decoration:none;">LOGOUT <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="card" style="text-align:center;padding:32px 16px;">
                <div style="background:rgba(255,255,255,0.05);width:48px;height:48px;border-radius:12px;display:inline-flex;justify-content:center;align-items:center;font-size:24px;color:var(--text-muted);margin-bottom:12px;">
                    <i class="fas fa-chart-simple"></i>
                </div>
                <h2 style="font-weight:900;font-size:18px;margin-bottom:4px;">STATISTIK</h2>
                <p style="color:var(--text-muted);font-size:12px;">Total Session: <strong style="color:white;"><?= $totalSessions ?></strong> / <?= $maxSessions ?></p>
                <p style="color:var(--text-muted);font-size:12px;margin-top:4px;">Polar Coin: <strong style="color:var(--gold);"><?= $user_coins ?></strong></p>
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
                            setTimeout(() => closePairingModal(), 2000);
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
        function earnCoin() {
            if (isProcessing) return;
            isProcessing = true;
            
            const btn = event?.target?.closest?.('.earn-btn') || document.querySelector('.earn-btn');
            const originalText = btn ? btn.innerHTML : 'EARN';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
                btn.classList.add('loading');
            }
            
            fetch('earn-coin.php')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.url) {
                        showToast('🪙 Klik link di bawah untuk dapat Polar Coin!', 'gold');
                        window.open(data.url, '_blank');
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        showToast('❌ ' + (data.message || 'Gagal mengambil Polar Coin'), 'error');
                    }
                })
                .catch(() => {
                    showToast('❌ Gagal terhubung ke server', 'error');
                })
                .finally(() => {
                    isProcessing = false;
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        btn.classList.remove('loading');
                    }
                });
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
                
                setTimeout(() => location.reload(), 3000);

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

            // Cutout: blur semua kecuali area spotlight
            const dim = document.getElementById('tutorialDim');
            const top = rect.top - pad, left = rect.left - pad, right = rect.right + pad, bottom = rect.bottom + pad;
            dim.style.clipPath = `polygon(
                0 0, 100% 0, 100% 100%, 0 100%, 0 0,
                ${left}px ${top}px, ${right}px ${top}px, ${right}px ${bottom}px, ${left}px ${bottom}px, ${left}px ${top}px
            )`;

            // Posisi arrow & card relatif ke arah yang ditentukan
            arrow.className = 'tutorial-arrow fas fa-arrow-' + (step.arrow === 'left' ? 'right' : 'up');
            let cardTop, cardLeft, arrowTop, arrowLeft;

            if (step.arrow === 'left') {
                arrowTop = rect.top + rect.height / 2 - 13;
                arrowLeft = rect.left - 38;
                cardTop = rect.top + rect.height / 2 - 60;
                cardLeft = rect.left - 280;
                if (cardLeft < 10) { cardLeft = rect.right + 20; arrow.className = 'tutorial-arrow fas fa-arrow-left'; arrowLeft = rect.right + 8; }
            } else {
                arrowTop = rect.bottom + 8;
                arrowLeft = rect.left + rect.width / 2 - 13;
                cardTop = rect.bottom + 40;
                cardLeft = Math.max(10, Math.min(window.innerWidth - 280, rect.left + rect.width / 2 - 130));
                if (cardTop + 140 > window.innerHeight) {
                    cardTop = rect.top - 150;
                    arrowTop = rect.top - 34;
                    arrow.className = 'tutorial-arrow fas fa-arrow-down';
                }
            }

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

            // Step 5 ke atas berarti sudah masuk daftar sidebar -> buka sidebar otomatis
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

            // Kasih sedikit delay biar sidebar transition selesai sebelum diukur posisinya
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
            try { localStorage.setItem('polar_tutorial_done', '1'); } catch(e) {}
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

            const isLoggedIn = <?= $is_logged_in ? 'true' : 'false' ?>;
            if (isLoggedIn) {
                let tutorialDone = false;
                try { tutorialDone = localStorage.getItem('polar_tutorial_done') === '1'; } catch(e) {}
                if (!tutorialDone) {
                    setTimeout(startTutorial, 600);
                }
            }
        });

        document.getElementById('pairingOverlay').addEventListener('click', function(e) {
            if (e.target === this) closePairingModal();
        });
    </script>
</body>
</html>
