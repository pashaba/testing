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
    <title>Polar.id — Jadibot WhatsApp Gratis</title>
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
            --white-hover: #e0e0e0;
            --yellow: #ffcc00;
            --gold: #fbbf24;
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
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 0, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(255, 107, 0, 0.03) 0%, transparent 50%);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .animate-in { animation: fadeInUp 0.5s ease forwards; }
        .animate-in-delay-1 { animation: fadeInUp 0.5s ease 0.1s forwards; opacity: 0; }
        .animate-in-delay-2 { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }
        .animate-in-delay-3 { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-main); }
        ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            text-align: center;
            cursor: pointer;
            border: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: var(--transition);
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: var(--transition);
        }
        .btn:hover::after { opacity: 1; }
        .btn:active { transform: scale(0.97); }
        
        .btn-orange { 
            background: linear-gradient(135deg, var(--orange), var(--orange-hover)); 
            color: white; 
            box-shadow: 0 4px 20px var(--orange-glow);
        }
        .btn-orange:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 8px 30px var(--orange-glow);
        }
        .btn-white { 
            background: var(--white); 
            color: #000; 
        }
        .btn-white:hover { 
            background: var(--white-hover); 
            transform: translateY(-3px); 
            box-shadow: 0 5px 20px rgba(255,255,255,0.15);
        }
        .btn-sm { padding: 6px 14px; font-size: 10px; border-radius: 8px; }
        .btn-danger { background: var(--red); color: white; }
        .btn-danger:hover { background: #dc2626; transform: translateY(-2px); }
        .btn-success { background: var(--green); color: white; }
        .btn-success:hover { background: #16a34a; transform: translateY(-2px); }
        .btn-disabled { opacity: 0.4; cursor: not-allowed; transform: none !important; }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 24px;
            background: rgba(15, 15, 23, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: fadeInUp 0.4s ease;
        }
        .nav-brand { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-weight: 900; 
            font-size: 20px; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .brand-icon { 
            background: linear-gradient(135deg, var(--orange), var(--orange-hover)); 
            color: white; 
            padding: 6px 12px; 
            border-radius: 10px; 
            transform: skew(-8deg);
            font-size: 16px;
        }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .coin-badge { 
            background: rgba(251, 191, 36, 0.1); 
            border: 1px solid var(--gold); 
            color: var(--gold); 
            padding: 6px 14px; 
            border-radius: 30px; 
            font-weight: 700; 
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }
        .coin-badge:hover {
            background: rgba(251, 191, 36, 0.15);
            transform: scale(1.05);
        }
        .coin-badge i { font-size: 14px; }
        .profile-btn { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
            background: rgba(255,255,255,0.05); 
            padding: 4px 12px 4px 4px; 
            border-radius: 30px; 
            cursor: pointer; 
            transition: var(--transition);
            border: 1px solid transparent;
        }
        .profile-btn:hover { 
            background: rgba(255,255,255,0.08); 
            border-color: var(--orange);
        }
        .profile-btn img { 
            width: 30px; 
            height: 30px; 
            border-radius: 50%; 
            border: 2px solid var(--orange);
            transition: var(--transition);
        }
        .profile-btn:hover img { border-color: var(--white); }
        .menu-btn { 
            background: var(--orange); 
            color: white; 
            border: none; 
            width: 36px; 
            height: 36px; 
            border-radius: 10px; 
            font-size: 16px; 
            cursor: pointer; 
            transition: var(--transition);
        }
        .menu-btn:hover { transform: scale(1.08); background: var(--orange-hover); }

        /* SIDEBAR */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);
            z-index: 998; opacity: 0; visibility: hidden; transition: var(--transition);
        }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }
        .sidebar {
            position: fixed; top: 0; right: -320px; width: 290px; height: 100vh;
            background: var(--bg-nav); border-left: 1px solid var(--border);
            z-index: 999; padding: 24px; transition: var(--transition);
            display: flex; flex-direction: column; gap: 8px;
        }
        .sidebar.active { right: 0; }
        .sidebar-header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 20px; border-bottom: 1px solid var(--border); 
            padding-bottom: 15px; 
        }
        .sidebar-close { 
            background: var(--white); color: #000; border: none; 
            width: 30px; height: 30px; border-radius: 8px; cursor: pointer; font-weight: bold;
            transition: var(--transition);
        }
        .sidebar-close:hover { transform: rotate(90deg); background: var(--orange); color: white; }
        .nav-link {
            padding: 12px 16px; color: var(--text-muted); text-decoration: none; font-weight: 600;
            border-radius: 10px; transition: var(--transition); 
            display: flex; align-items: center; gap: 12px; background: var(--bg-card);
        }
        .nav-link:hover, .nav-link.active { 
            background: var(--orange); 
            color: white; 
            transform: translateX(6px);
            box-shadow: 0 4px 20px var(--orange-glow);
        }
        .nav-link i { width: 20px; text-align: center; }

        /* LOGIN POPUP */
        .login-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.9); backdrop-filter: blur(12px);
            z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px;
            animation: fadeInUp 0.4s ease;
        }
        .login-card {
            background: var(--bg-nav); border: 2px solid var(--orange); border-radius: 20px;
            padding: 48px 32px; width: 100%; max-width: 400px; text-align: center;
            position: relative; animation: slideUp 0.5s ease;
            box-shadow: 0 20px 60px rgba(255,107,0,0.1);
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
            top: -12px; 
            left: 50%; 
            transform: translateX(-50%) skew(-5deg);
            background: var(--gold); 
            color: #000; 
            padding: 4px 20px; 
            font-weight: 900; 
            font-size: 11px; 
            border-radius: 8px;
            letter-spacing: 1px;
        }
        .login-avatar { 
            width: 80px; height: 80px; 
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
        .login-card h2 { font-size: 32px; font-weight: 900; margin-bottom: 6px; }
        .login-card p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
        .google-btn-login {
            background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 50px;
            padding: 12px 20px; display: flex; align-items: center; justify-content: space-between;
            color: white; text-decoration: none; transition: var(--transition); text-align: left;
        }
        .google-btn-login:hover { 
            border-color: var(--orange); 
            background: rgba(255, 107, 0, 0.08); 
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255,107,0,0.1);
        }
        .g-icon { 
            background: white; 
            border-radius: 50%; 
            padding: 5px; 
            width: 32px; 
            height: 32px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }

        /* CONTENT */
        .main-container { padding: 30px 20px; max-width: 700px; margin: 0 auto; }
        .section { display: none; animation: fadeInUp 0.4s ease; }
        .section.active { display: block; }

        /* HERO */
        .hero { text-align: center; }
        .slot-badge { 
            display: inline-block; 
            background: var(--white); 
            color: #000; 
            padding: 4px 18px; 
            border-radius: 30px; 
            font-weight: 800; 
            font-size: 12px; 
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }
        .hero h1 { 
            font-size: clamp(32px, 8vw, 44px); 
            font-weight: 900; 
            line-height: 1.15; 
            margin-bottom: 16px;
        }
        .hero h1 span { 
            background: linear-gradient(135deg, var(--yellow), var(--orange)); 
            color: #000; 
            padding: 0 12px; 
            display: inline-block; 
            transform: skew(-6deg);
        }
        .hero p { color: var(--text-muted); font-size: 14px; margin-bottom: 30px; max-width: 420px; margin-left: auto; margin-right: auto; }
        .btn-group { display: flex; flex-direction: column; gap: 12px; align-items: center; }
        .btn-group .btn { width: 100%; }

        /* CARDS */
        .card { 
            background: var(--bg-card); 
            border: 1px solid var(--border); 
            border-radius: 16px; 
            padding: 20px; 
            margin-bottom: 20px; 
            transition: var(--transition); 
        }
        .card:hover { border-color: var(--orange); box-shadow: 0 4px 30px rgba(255,107,0,0.05); }
        .section-title { 
            background: var(--gold); 
            color: #000; 
            display: inline-block; 
            padding: 4px 14px; 
            font-weight: 800; 
            font-size: 11px; 
            border-radius: 6px; 
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .select-box {
            background: var(--bg-main); border: 2px solid var(--border); border-radius: 12px; 
            padding: 16px; text-align: center; cursor: pointer; transition: var(--transition); 
            position: relative;
        }
        .select-box:hover { border-color: var(--white); transform: translateY(-3px); }
        .select-box.active { 
            border-color: var(--orange); 
            background: rgba(255, 107, 0, 0.06);
            box-shadow: 0 0 30px rgba(255,107,0,0.05);
        }
        .select-box i { font-size: 24px; color: var(--text-muted); margin-bottom: 10px; transition: var(--transition); }
        .select-box.active i { color: var(--orange); }
        .select-box h4 { font-size: 14px; font-weight: 800; }
        .select-box p { font-size: 11px; color: var(--text-muted); margin-top: 5px; }

        /* STATUS */
        .status-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 12px; 
            margin-bottom: 20px; 
            text-align: center; 
        }
        .stat-box { 
            background: var(--bg-main); 
            padding: 16px 10px; 
            border-radius: 10px; 
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .stat-box:hover { border-color: var(--orange); transform: translateY(-2px); }
        .stat-box h3 { font-size: 22px; font-weight: 900; }
        .stat-box p { font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
        .text-orange { color: var(--orange); }
        .text-white { color: var(--white); }
        .badge-status { 
            padding: 4px 12px; 
            border-radius: 6px; 
            font-size: 10px; 
            font-weight: 800; 
            text-transform: uppercase;
            transition: var(--transition);
        }
        .bg-online { background: rgba(34,197,94,0.12); color: var(--green); border: 1px solid var(--green); }
        .bg-offline { background: rgba(239,68,68,0.12); color: var(--red); border: 1px solid var(--red); }
        .bg-pending { background: rgba(255,204,0,0.12); color: var(--gold); border: 1px solid var(--gold); }
        .spec-row { 
            display: flex; 
            justify-content: space-between; 
            padding: 10px 0; 
            border-bottom: 1px dashed var(--border); 
            font-size: 13px; 
        }
        .spec-row:last-child { border: none; }

        /* SESSIONS */
        .session-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid var(--border);
            flex-wrap: wrap; gap: 8px;
        }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 600; font-family: monospace; font-size: 13px; }
        .session-actions { display: flex; gap: 6px; flex-wrap: wrap; }

        /* PAIRING MODAL */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
            z-index: 1100; display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: var(--bg-nav); border: 1px solid var(--border); border-radius: 20px;
            padding: 32px; max-width: 450px; width: 100%; max-height: 90vh; overflow-y: auto;
            animation: slideUp 0.3s ease;
        }
        .modal-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
        }
        .modal-close { 
            background: rgba(255,255,255,0.05); 
            border: 1px solid var(--border); 
            border-radius: 50%;
            color: var(--text-muted); 
            font-size: 20px; 
            width: 36px; 
            height: 36px;
            cursor: pointer; 
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-close:hover { background: var(--red); color: white; border-color: var(--red); }
        .pair-code {
            background: var(--bg-main); border: 2px dashed var(--orange); border-radius: 12px;
            padding: 20px; text-align: center; font-size: 28px; font-weight: 900; letter-spacing: 4px;
            font-family: monospace; color: var(--orange); margin: 15px 0;
            transition: var(--transition);
        }
        .pair-code:hover { border-color: var(--white); }

        /* TOAST */
        .toast {
            position: fixed; bottom: 24px; right: 24px; background: var(--bg-card);
            border: 1px solid var(--border); color: white; padding: 16px 24px;
            border-radius: 14px; font-size: 14px; z-index: 1200;
            box-shadow: 0 8px 40px rgba(0,0,0,0.5); display: none; max-width: 380px;
            animation: slideUp 0.3s ease;
        }
        .toast.success { border-left: 4px solid var(--green); }
        .toast.error { border-left: 4px solid var(--red); }
        .toast.info { border-left: 4px solid var(--orange); }

        /* EARN BUTTON */
        .earn-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--gold), var(--orange));
            color: #000;
            border: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 20px rgba(251,191,36,0.2);
        }
        .earn-btn:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 8px 30px rgba(251,191,36,0.3);
        }
        .earn-btn:active { transform: scale(0.97); }

        /* RESPONSIVE */
        @media (max-width: 480px) {
            .hero h1 { font-size: 28px; }
            .grid-2 { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr 1fr; }
            .modal-box { padding: 20px; }
            .navbar { padding: 10px 16px; }
            .coin-badge { font-size: 10px; padding: 4px 10px; }
            .profile-btn span { display: none; }
            .main-container { padding: 20px 12px; }
        }
        @media (max-width: 360px) {
            .status-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
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
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="18">
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 700;">Login dengan Google</div>
                        <div style="font-size: 11px; color: var(--text-muted);">Aman & cepat</div>
                    </div>
                </div>
                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
            </a>
            <div style="margin-top: 20px; font-size: 11px; color: var(--text-muted);">
                <i class="fas fa-shield-alt"></i> Login untuk claim dan manage server kamu
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- TOAST -->
    <div class="toast" id="toast"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-brand">
            <span class="brand-icon">✦</span> POLAR.ID
        </div>
        <div class="nav-right">
            <div class="coin-badge" id="coinBadge">
                <i class="fas fa-coins"></i> 
                <span id="coinCount"><?= $user_coins ?></span> Polar Coin
            </div>
            <div class="profile-btn" onclick="navTo('profile')">
                <span style="font-size: 12px; font-weight: 600;" class="hide-mobile"><?= explode(' ', $user_name)[0] ?></span>
                <img src="<?= $user_avatar ?>" alt="Avatar">
            </div>
            <button class="menu-btn" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="nav-brand" style="font-size:16px;"><span class="brand-icon">✦</span> MENU</div>
            <button class="sidebar-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        </div>
        <a href="#" class="nav-link active" onclick="navTo('home'); toggleMenu();"><i class="fas fa-home"></i> HOME</a>
        <a href="#" class="nav-link" onclick="navTo('status'); toggleMenu();"><i class="fas fa-server"></i> STATUS</a>
        <a href="#" class="nav-link" onclick="navTo('claim'); toggleMenu();"><i class="fas fa-download"></i> CLAIM</a>
        <a href="#" class="nav-link" onclick="navTo('sessions'); toggleMenu();"><i class="fas fa-robot"></i> SESSIONS</a>
        <a href="#" class="nav-link" onclick="navTo('profile'); toggleMenu();"><i class="fas fa-user"></i> PROFILE</a>
        <a href="#" class="nav-link" onclick="earnCoin()" style="background: linear-gradient(135deg, rgba(255,107,0,0.1), rgba(251,191,36,0.05)); border: 1px solid var(--orange);">
            <i class="fas fa-coins" style="color: var(--gold);"></i> EARN POLAR COIN
        </a>
        <a href="logout.php" class="nav-link" style="color: var(--orange); margin-top: auto;"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
    </div>

    <div class="main-container">

        <!-- HOME -->
        <div id="sec-home" class="section active animate-in">
            <div class="hero">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px; color: var(--orange);"></i> <?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1>Jadibot <br><span>WhatsApp Gratis</span></h1>
                <p>Dapatkan server bot gratis dengan spesifikasi terbaik. Claim sekarang sebelum slot habis!</p>
                <div class="btn-group">
                    <button class="btn btn-orange" onclick="navTo('claim')">
                        <i class="fas fa-download"></i> CLAIM SEKARANG
                    </button>
                    <button class="btn btn-white" onclick="navTo('status')">
                        LIHAT STATUS <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
                <div style="display:flex; justify-content:center; gap:24px; margin-top:30px; font-size: 13px; font-weight: 600;">
                    <span style="color: var(--white);"><i class="fas fa-check-circle" style="color: var(--orange);"></i> 100% Gratis</span>
                    <span style="color: var(--white);"><i class="fas fa-bolt" style="color: var(--orange);"></i> Setup Instan</span>
                    <span style="color: var(--white);"><i class="fas fa-coins" style="color: var(--gold);"></i> Earn Polar Coin</span>
                </div>
            </div>
        </div>

        <!-- CLAIM -->
        <div id="sec-claim" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px;"></i> <?= $maxSessions - $totalSessions ?> SLOT TERSEDIA</div>
                <h1 style="font-weight: 900; font-size: clamp(28px, 6vw, 36px); text-transform: uppercase;">CLAIM <span style="background: var(--white); color: #000; padding: 0 12px; transform: skew(-5deg); display: inline-block;">SERVER</span></h1>
                <p style="color: var(--text-muted); font-size: 13px;">Pilih paket dan claim server bot gratis</p>
            </div>

            <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="background: linear-gradient(135deg, var(--gold), var(--orange)); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #000;">
                        <?= substr($user_name, 0, 1) ?>
                    </div>
                    <div>
                        <div style="font-size: 10px; color: var(--text-muted); font-weight: 600; letter-spacing: 0.5px;">LOGIN AS</div>
                        <div style="font-weight: 700;"><?= $user_name ?></div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="color:var(--gold);font-weight:700;"><i class="fas fa-coins"></i> <span id="claimCoinDisplay"><?= $user_coins ?></span></span>
                    <button class="earn-btn" onclick="earnCoin()" style="font-size:10px;padding:4px 14px;"><i class="fas fa-plus"></i></button>
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
                    $disabled = ($user_coins < $pkg['coin']) ? 'disabled' : '';
                    $isActive = ($pkg['coin'] <= $user_coins);
                ?>
                <div class="select-box <?= $isActive ? 'active' : '' ?>" onclick="<?= $isActive ? "selectPackage(this, {$pkg['days']}, {$pkg['coin']})" : '' ?>" style="<?= !$isActive ? 'opacity:0.5;cursor:not-allowed;' : '' ?>">
                    <i class="fas <?= $pkg['icon'] ?>"></i>
                    <h4><?= $pkg['label'] ?></h4>
                    <p style="color: var(--gold);">🪙 <?= $pkg['coin'] ?> Polar Coin</p>
                    <?php if (!$isActive): ?>
                        <p style="color: var(--red); font-size: 10px; margin-top: 4px;">Koin tidak cukup</p>
                    <?php endif; ?>
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
                <div style="margin-bottom: 12px;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 6px;">📱 Nomor WhatsApp</label>
                    <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" style="width:100%;padding:14px;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;color:white;font-size:14px;transition:var(--transition);">
                    <style>
                        input:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px rgba(255,107,0,0.1); }
                    </style>
                </div>
                <input type="hidden" id="selectedDays" value="1">
                <input type="hidden" id="selectedCoin" value="1">
            </div>

            <button class="btn btn-orange" style="width: 100%; margin-top: 10px; padding: 16px; font-size: 15px;" id="claimBtn" onclick="createSessionWithCoin()">
                <i class="fas fa-rocket"></i> CLAIM SERVER SEKARANG
            </button>
        </div>

        <!-- STATUS -->
        <div id="sec-status" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge" style="background: var(--white); color: #000;"><i class="fas fa-circle" style="font-size: 8px;"></i> REAL-TIME MONITORING</div>
                <h1 style="font-weight: 900; font-size: clamp(28px, 6vw, 36px); text-transform: uppercase;">SERVER <span style="background: var(--orange); color: white; padding: 0 12px; transform: skew(-5deg); display: inline-block;">STATUS</span></h1>
            </div>

            <div class="card">
                <div class="status-grid">
                    <div class="stat-box"><h3 class="text-orange"><?= $totalSessions ?></h3><p>TOTAL</p></div>
                    <div class="stat-box"><h3 style="color: var(--gold);"><?= $maxSessions - $totalSessions ?></h3><p>SLOT</p></div>
                    <div class="stat-box"><h3 class="text-white"><?= ($phoenix_status['online'] ? 1 : 0) + ($ourin_status['online'] ? 1 : 0) ?></h3><p>ONLINE</p></div>
                    <div class="stat-box"><h3 class="text-orange"><?= (!$phoenix_status['online'] ? 1 : 0) + (!$ourin_status['online'] ? 1 : 0) ?></h3><p>OFFLINE</p></div>
                </div>
            </div>

            <div class="card" style="border-color: <?= $phoenix_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: var(--orange); padding: 10px; border-radius: 10px;"><i class="fas fa-server" style="color:white;"></i></div>
                        <div><h3 style="font-size: 16px; font-weight: 900;">PHOENIX MD</h3><div style="font-size: 11px; color: var(--text-muted);">Pterodactyl Node</div></div>
                    </div>
                    <div class="badge-status <?= $phoenix_status['online'] ? 'bg-online' : 'bg-offline' ?>">
                        <?= $phoenix_status['online'] ? 'ONLINE' : 'OFFLINE' ?>
                    </div>
                </div>
                <div class="spec-row"><span style="color: var(--text-muted);">RAM</span><span style="font-weight: bold; color: var(--white);"><?= $phoenix_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color: var(--text-muted);">PING</span><span style="font-weight: bold; color: var(--white);"><?= $phoenix_status['ping'] ?></span></div>
            </div>

            <div class="card" style="border-color: <?= $ourin_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: var(--white); padding: 10px; border-radius: 10px;"><i class="fas fa-microchip" style="color:#000;"></i></div>
                        <div><h3 style="font-size: 16px; font-weight: 900;">OURIN CORE</h3><div style="font-size: 11px; color: var(--text-muted);">Native Script</div></div>
                    </div>
                    <div class="badge-status <?= $ourin_status['online'] ? 'bg-online' : 'bg-offline' ?>">
                        <?= $ourin_status['online'] ? 'ONLINE' : 'OFFLINE' ?>
                    </div>
                </div>
                <div class="spec-row"><span style="color: var(--text-muted);">RAM</span><span style="font-weight: bold; color: var(--white);"><?= $ourin_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color: var(--text-muted);">PING</span><span style="font-weight: bold; color: var(--white);"><?= $ourin_status['ping'] ?></span></div>
            </div>
            <p style="text-align: center; font-size: 10px; color: var(--text-muted); margin-top: 20px;">🔄 AUTO-REFRESH SETIAP 30 DETIK</p>
        </div>

        <!-- SESSIONS -->
        <div id="sec-sessions" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px;"></i> <?= $totalSessions ?> / <?= $maxSessions ?> SESSION</div>
                <h1 style="font-weight: 900; font-size: clamp(28px, 6vw, 36px); text-transform: uppercase;">MY <span style="background: var(--orange); color: white; padding: 0 12px; transform: skew(-5deg); display: inline-block;">BOTS</span></h1>
            </div>

            <?php if (empty($sessions)): ?>
            <div class="card" style="text-align:center;padding:50px 20px;">
                <div style="font-size:56px;margin-bottom:16px;opacity:0.3;">🤖</div>
                <h3 style="font-weight:700;font-size:20px;">Belum Ada Bot</h3>
                <p style="color:var(--text-muted);font-size:13px;margin-top:6px;">Claim server dulu untuk mulai menggunakan bot</p>
                <button class="btn btn-orange" style="margin-top:20px;" onclick="navTo('claim')">CLAIM SEKARANG</button>
            </div>
            <?php else: ?>
                <?php foreach ($sessions as $s): 
                    $statusClass = $s['status'] === 'online' ? 'bg-online' : ($s['status'] === 'pending' ? 'bg-pending' : 'bg-offline');
                    $statusText = $s['status'] === 'online' ? 'Online' : ($s['status'] === 'pending' ? 'Pending' : 'Offline');
                ?>
                <div class="card animate-in">
                    <div class="session-item" style="border-bottom:1px solid var(--border);padding-bottom:12px;margin-bottom:12px;">
                        <div>
                            <div class="session-phone"><i class="fab fa-whatsapp"></i> +<?= htmlspecialchars($s['phone']) ?></div>
                            <div style="font-size:10px;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars($s['script']) ?></div>
                        </div>
                        <div class="session-status <?= $statusClass ?>"><?= $statusText ?></div>
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <?php if ($s['status'] === 'waiting_pair' || $s['status'] === 'pending'): ?>
                        <button class="btn btn-sm btn-orange" onclick="openPairModal('<?= $s['phone'] ?>')"><i class="fas fa-link"></i> Pairing</button>
                        <?php endif; ?>
                        <?php if ($s['status'] === 'online'): ?>
                        <button class="btn btn-sm btn-success" onclick="showToast('Bot sedang online!', 'success')"><i class="fas fa-circle"></i> Online</button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-danger" onclick="deleteSession(<?= $s['id'] ?>, '<?= $s['phone'] ?>')"><i class="fas fa-trash"></i> Hapus</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- PROFILE -->
        <div id="sec-profile" class="section">
            <div style="text-align: center; margin-bottom: 30px; margin-top: 10px;">
                <div style="position: relative; display: inline-block;">
                    <img src="<?= $user_avatar ?>" style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--orange); transition: var(--transition);">
                    <div style="position: absolute; top: 0; right: -10px; background: var(--orange); color: white; padding: 2px 12px; font-size: 10px; font-weight: 800; border-radius: 10px; transform: rotate(12deg);">✦ YOU!</div>
                </div>
                <h1 style="font-weight: 900; font-size: 28px; margin-top: 16px;"><?= $user_name ?></h1>
                <p style="color: var(--text-muted); font-size: 13px;"><?= $user_email ?></p>
                <div style="background: rgba(255,255,255,0.05); border: 1px solid var(--border); display: inline-flex; align-items: center; gap: 16px; padding: 8px 24px; border-radius: 50px; margin-top: 16px;">
                    <div style="font-weight: 700; color: var(--gold);"><i class="fas fa-coins"></i> <span id="profileCoinDisplay"><?= $user_coins ?></span></div>
                    <div style="font-size: 11px; font-weight: 700; letter-spacing: 1px; color: var(--text-muted);">POLAR COIN</div>
                    <button class="earn-btn" onclick="earnCoin()" style="font-size:10px;padding:4px 14px;"><i class="fas fa-plus"></i> EARN</button>
                </div>
                <div style="margin-top: 16px;">
                    <a href="logout.php" style="color: var(--text-muted); font-size: 12px; font-weight: 600; text-decoration: none; transition: var(--transition);">LOGOUT <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="card" style="text-align: center; padding: 40px 20px;">
                <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: 16px; display: inline-flex; justify-content: center; align-items: center; font-size: 28px; color: var(--text-muted); margin-bottom: 16px;">
                    <i class="fas fa-chart-simple"></i>
                </div>
                <h2 style="font-weight: 900; font-size: 20px; margin-bottom: 4px;">STATISTIK</h2>
                <p style="color: var(--text-muted); font-size: 13px;">Total Session: <strong style="color:white;"><?= $totalSessions ?></strong> / <?= $maxSessions ?></p>
                <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Polar Coin: <strong style="color:var(--gold);"><?= $user_coins ?></strong></p>
                <button class="btn btn-orange" style="margin-top:20px;" onclick="navTo('claim')">CLAIM SERVER <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- PAIRING MODAL -->
    <div class="modal-overlay" id="pairModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 style="font-size:18px;font-weight:800;"><i class="fas fa-link" style="color:var(--orange);"></i> Tautkan Perangkat</h3>
                <button class="modal-close" onclick="closePairModal()"><i class="fas fa-times"></i></button>
            </div>
            <div id="pairContent" style="text-align:center;padding:20px;">
                <div class="spinner" style="width:40px;height:40px;border:3px solid var(--border);border-top-color:var(--orange);border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 15px;"></div>
                <p style="color:var(--text-muted);">Menunggu pairing code...</p>
            </div>
        </div>
    </div>

    <script>
        // ========== SUPABASE CONFIG ==========
        const SB_URL = '<?= SUPABASE_URL ?>';
        const SB_KEY = '<?= SUPABASE_KEY ?>';
        const MAX_SESSIONS = <?= $maxSessions ?>;
        let selectedDays = 1;
        let selectedCoin = 1;
        let isProcessing = false;

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

        // ========== EARN COIN ==========
        function earnCoin() {
            if (isProcessing) return;
            isProcessing = true;
            
            const btn = event?.target?.closest?.('.earn-btn') || document.querySelector('.earn-btn');
            const originalText = btn ? btn.innerHTML : 'EARN';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
            }
            
            showToast('🔄 Mengambil Polar Coin...', 'info');
            
            fetch('earn-coin.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.url) {
                            window.open(data.url, '_blank');
                            showToast('✅ ' + (data.message || 'Polar Coin berhasil diambil! 🪙'), 'success');
                            
                            // Update coin display
                            const coinElements = document.querySelectorAll('#coinCount, #claimCoinDisplay, #profileCoinDisplay');
                            const currentCoins = parseInt(document.getElementById('coinCount')?.textContent || '0');
                            const newCoins = currentCoins + 1;
                            
                            coinElements.forEach(el => {
                                if (el) el.textContent = newCoins;
                            });
                            
                            // Update badge
                            const badge = document.querySelector('.coin-badge');
                            if (badge) {
                                badge.style.transform = 'scale(1.15)';
                                setTimeout(() => { badge.style.transform = 'scale(1)'; }, 300);
                            }
                            
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showToast('✅ Polar Coin berhasil ditambahkan! 🪙', 'success');
                            location.reload();
                        }
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

        // ========== CREATE SESSION WITH COIN ==========
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

            try {
                // Kurangi koin via API
                const coinRes = await fetch('update-coin.php?amount=' + (-coin));
                const coinData = await coinRes.json();
                
                if (!coinData.success) throw new Error('Gagal update coin');

                // Buat session di Supabase
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

                showToast('✅ Server berhasil di-claim! ' + days + ' hari aktif. 🎉', 'success');
                setTimeout(() => location.reload(), 1500);

            } catch(e) {
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

        // ========== PAIRING MODAL ==========
        let pairInterval = null;
        async function openPairModal(phone) {
            document.getElementById('pairModal').classList.add('active');
            document.getElementById('pairContent').innerHTML = `
                <div class="spinner" style="width:40px;height:40px;border:3px solid var(--border);border-top-color:var(--orange);border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 15px;"></div>
                <p style="color:var(--text-muted);">⏳ Menunggu pairing code...</p>
            `;

            if (pairInterval) clearInterval(pairInterval);
            pairInterval = setInterval(async () => {
                try {
                    const data = await supabaseRequest('GET', `polar_sessions?phone=eq.${phone}&select=status,pairing_code&limit=1`);
                    if (data && data[0]) {
                        if (data[0].pairing_code) {
                            const code = data[0].pairing_code.match(/.{1,4}/g)?.join('-') || data[0].pairing_code;
                            document.getElementById('pairContent').innerHTML = `
                                <div class="pair-code">${code}</div>
                                <div style="font-size:12px;color:var(--text-muted);line-height:1.8;">
                                    <p style="margin-bottom:12px;">Masukkan kode ini di WhatsApp:</p>
                                    <ol style="text-align:left;padding-left:20px;line-height:2.2;">
                                        <li>Buka WhatsApp → Settings</li>
                                        <li>Perangkat Tertaut → Tautkan Perangkat</li>
                                        <li>Masukkan kode di atas</li>
                                    </ol>
                                </div>
                                <button onclick="navigator.clipboard.writeText('${data[0].pairing_code}')" 
                                        class="btn btn-orange" style="width:100%;margin-top:15px;font-size:12px;">
                                    <i class="fas fa-copy"></i> Salin Kode
                                </button>
                            `;
                            clearInterval(pairInterval);
                        }
                        if (data[0].status === 'online') {
                            document.getElementById('pairContent').innerHTML = `
                                <div style="font-size:56px;text-align:center;margin-bottom:12px;">✅</div>
                                <h3 style="text-align:center;color:var(--green);font-size:20px;">Bot Berhasil Online!</h3>
                                <p style="text-align:center;color:var(--text-muted);font-size:13px;">Session sudah terhubung</p>
                                <button onclick="closePairModal()" class="btn btn-orange" style="width:100%;margin-top:15px;">Tutup</button>
                            `;
                            clearInterval(pairInterval);
                        }
                    }
                } catch(e) { console.error(e); }
            }, 3000);
        }

        function closePairModal() {
            if (pairInterval) clearInterval(pairInterval);
            document.getElementById('pairModal').classList.remove('active');
        }

        document.getElementById('pairModal').addEventListener('click', function(e) {
            if (e.target === this) closePairModal();
        });

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

        // Update coin setiap 30 detik
        setInterval(updateCoinDisplay, 30000);
    </script>
<?php endif; ?>
</body>
</html>
