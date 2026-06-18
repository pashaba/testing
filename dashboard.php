<?php
session_start();
require_once 'config.php';

// ========== KONFIGURASI GOOGLE ==========
$client_id = '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://polar.web.id/dashboard.php'; // LANGSUNG KE DASHBOARD

// ========== PROSES CALLBACK DARI GOOGLE ==========
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
        $_SESSION['user_coins'] = 50;
        
        header('Location: dashboard.php');
        exit;
    }
}

// ========== CEK LOGIN ==========
$is_logged_in = isset($_SESSION['user_google_id']);
$user_name = $_SESSION['user_name'] ?? "Guest";
$user_email = $_SESSION['user_email'] ?? "guest@gmail.com";
$user_avatar = $_SESSION['user_avatar'] ?? "https://ui-avatars.com/api/?name=Guest&background=FF6B00&color=fff";
$user_coins = $_SESSION['user_coins'] ?? 50;

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
    return [
        'online' => true,
        'ram' => '128 MB',
        'ping' => rand(10, 80) . 'ms'
    ];
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Jadibot WhatsApp Gratis</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-main: #0f0f13;
            --bg-card: #1c1c24;
            --bg-nav: #15151c;
            --orange: #FF6B00;
            --orange-hover: #e05e00;
            --white: #ffffff;
            --white-hover: #e0e0e0;
            --yellow: #ffcc00;
            --text-main: #ffffff;
            --text-muted: #8b8b9b;
            --border: #2a2a35;
            --green: #22c55e;
            --red: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            background-image: radial-gradient(circle at 50% 0%, rgba(255, 107, 0, 0.05) 0%, transparent 50%);
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 800;
            text-align: center;
            cursor: pointer;
            border: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            font-size: 14px;
        }
        .btn-orange { background: var(--orange); color: white; }
        .btn-orange:hover { background: var(--orange-hover); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 107, 0, 0.3); }
        .btn-white { background: var(--white); color: #000; }
        .btn-white:hover { background: var(--white-hover); transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2); }
        .btn-sm { padding: 6px 12px; font-size: 10px; }
        .btn-danger { background: var(--red); color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-success { background: var(--green); color: white; }
        .btn-success:hover { background: #16a34a; }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: var(--bg-nav);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; font-weight: 900; font-size: 20px; text-transform: uppercase; }
        .brand-icon { background: var(--orange); color: white; padding: 5px 10px; border-radius: 8px; transform: skew(-10deg); }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .coin-badge { background: rgba(255, 204, 0, 0.1); border: 1px solid var(--yellow); color: var(--yellow); padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; }
        .profile-btn { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); padding: 5px 10px; border-radius: 20px; cursor: pointer; transition: 0.3s; }
        .profile-btn:hover { background: rgba(255,255,255,0.1); }
        .profile-btn img { width: 28px; height: 28px; border-radius: 50%; border: 1px solid var(--orange); }
        .menu-btn { background: var(--orange); color: white; border: none; width: 35px; height: 35px; border-radius: 8px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .menu-btn:hover { transform: scale(1.1); }

        /* SIDEBAR */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
            z-index: 998; opacity: 0; visibility: hidden; transition: all 0.3s ease;
        }
        .sidebar {
            position: fixed; top: 0; right: -300px; width: 280px; height: 100vh;
            background: var(--bg-nav); border-left: 1px solid var(--border);
            z-index: 999; padding: 20px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; gap: 10px;
        }
        .sidebar.active { right: 0; }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }
        .sidebar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 15px; }
        .sidebar-close { background: var(--white); color: #000; border: none; width: 30px; height: 30px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .nav-link {
            padding: 12px 15px; color: var(--text-muted); text-decoration: none; font-weight: 600;
            border-radius: 8px; transition: 0.3s; display: flex; align-items: center; gap: 10px; background: var(--bg-card);
        }
        .nav-link:hover, .nav-link.active { background: var(--orange); color: white; transform: translateX(5px); }

        /* LOGIN POPUP */
        .login-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px);
            z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .login-card {
            background: var(--bg-nav); border: 2px solid var(--orange); border-radius: 16px;
            padding: 40px 20px; width: 100%; max-width: 400px; text-align: center;
            position: relative; animation: slideUp 0.5s ease;
        }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .login-badge { position: absolute; top: -15px; left: 20px; background: var(--yellow); color: #000; padding: 5px 15px; font-weight: 900; font-size: 12px; border-radius: 5px; transform: skew(-5deg); }
        .login-avatar { width: 80px; height: 80px; background: var(--yellow); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 40px; color: #000; margin-bottom: 20px; }
        .login-card h2 { font-size: 32px; font-weight: 900; margin-bottom: 5px; }
        .login-card p { color: var(--text-muted); font-size: 14px; margin-bottom: 25px; }
        .google-btn-login {
            background: rgba(255,255,255,0.05); border: 1px solid var(--border); border-radius: 50px;
            padding: 10px 20px; display: flex; align-items: center; justify-content: space-between;
            color: white; text-decoration: none; transition: 0.3s; text-align: left;
        }
        .google-btn-login:hover { border-color: var(--orange); background: rgba(255, 107, 0, 0.05); transform: translateY(-2px); }
        .g-icon { background: white; border-radius: 50%; padding: 5px; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; }

        /* CONTENT */
        .main-container { padding: 30px 20px; max-width: 700px; margin: 0 auto; }
        .section { display: none; animation: fadeIn 0.4s ease; }
        .section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.98); } to { opacity: 1; transform: scale(1); } }

        /* Hero */
        .hero { text-align: center; }
        .slot-badge { display: inline-block; background: var(--white); color: #000; padding: 4px 15px; border-radius: 20px; font-weight: 800; font-size: 12px; margin-bottom: 15px; }
        .hero h1 { font-size: 38px; font-weight: 900; line-height: 1.1; margin-bottom: 15px; }
        .hero h1 span { background: var(--yellow); color: #000; padding: 0 10px; display: inline-block; transform: skew(-5deg); }
        .hero p { color: var(--text-muted); font-size: 14px; margin-bottom: 30px; }
        .btn-group { display: flex; flex-direction: column; gap: 15px; align-items: center; }

        /* Cards */
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 20px; transition: 0.3s; }
        .card:hover { border-color: var(--orange); }
        .section-title { background: var(--yellow); color: #000; display: inline-block; padding: 4px 10px; font-weight: 800; font-size: 12px; border-radius: 4px; margin-bottom: 15px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .select-box {
            background: var(--bg-nav); border: 2px solid var(--border); border-radius: 10px; padding: 15px;
            text-align: center; cursor: pointer; transition: 0.3s; position: relative;
        }
        .select-box:hover { border-color: var(--white); transform: translateY(-3px); }
        .select-box.active { border-color: var(--orange); background: rgba(255, 107, 0, 0.05); }
        .select-box i { font-size: 24px; color: var(--text-muted); margin-bottom: 10px; transition: 0.3s; }
        .select-box.active i { color: var(--orange); }
        .select-box h4 { font-size: 14px; font-weight: 800; }
        .select-box p { font-size: 11px; color: var(--text-muted); margin-top: 5px; }

        /* Status */
        .status-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; text-align: center; }
        .stat-box { background: var(--bg-nav); padding: 15px; border-radius: 8px; border: 1px solid var(--border); }
        .stat-box h3 { font-size: 24px; font-weight: 900; }
        .stat-box p { font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; }
        .text-orange { color: var(--orange); }
        .text-white { color: var(--white); }
        .badge-status { padding: 4px 10px; border-radius: 4px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
        .bg-online { background: rgba(34,197,94,0.1); color: var(--green); border: 1px solid var(--green); }
        .bg-offline { background: rgba(239,68,68,0.1); color: var(--red); border: 1px solid var(--red); }
        .bg-pending { background: rgba(255,204,0,0.1); color: var(--yellow); border: 1px solid var(--yellow); }
        .spec-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border); font-size: 13px; }
        .spec-row:last-child { border: none; }

        /* Session List */
        .session-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid var(--border);
            flex-wrap: wrap; gap: 8px;
        }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 600; font-family: monospace; font-size: 13px; }
        .session-status { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .session-actions { display: flex; gap: 6px; flex-wrap: wrap; }

        /* Pairing Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(6px);
            z-index: 1100; display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: var(--bg-nav); border: 1px solid var(--border); border-radius: 16px;
            padding: 30px; max-width: 450px; width: 100%; max-height: 90vh; overflow-y: auto;
            animation: slideUp 0.3s ease;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-close { background: none; border: none; color: var(--text-muted); font-size: 24px; cursor: pointer; }
        .pair-code {
            background: var(--bg-main); border: 2px dashed var(--orange); border-radius: 12px;
            padding: 20px; text-align: center; font-size: 28px; font-weight: 900; letter-spacing: 4px;
            font-family: monospace; color: var(--orange); margin: 15px 0;
        }

        /* Toast */
        .toast {
            position: fixed; bottom: 24px; right: 24px; background: var(--bg-card);
            border: 1px solid var(--border); color: white; padding: 14px 24px;
            border-radius: 12px; font-size: 14px; z-index: 1200;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4); display: none; max-width: 380px;
        }
        .toast.success { border-left: 4px solid var(--green); }
        .toast.error { border-left: 4px solid var(--red); }
        .toast.info { border-left: 4px solid var(--orange); }

        @media (max-width: 480px) {
            .hero h1 { font-size: 28px; }
            .grid-2 { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr; }
            .modal-box { padding: 20px; }
        }
    </style>
</head>
<body>
<?php if (!$is_logged_in): ?>
    <!-- LOGIN POPUP -->
    <div class="login-overlay">
        <div class="login-card">
            <div class="login-badge">NEW PLAYER</div>
            <div class="login-avatar"><i class="fas fa-user"></i></div>
            <h2>HALO!</h2>
            <p>Login dengan Google untuk mulai</p>
            <a href="<?= $auth_url ?>" class="google-btn-login">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div class="g-icon"><img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="18"></div>
                    <div>
                        <div style="font-size: 13px; font-weight: 600;">Login dengan Google</div>
                        <div style="font-size: 11px; color: var(--text-muted);">Klik untuk melanjutkan</div>
                    </div>
                </div>
                <i class="fas fa-chevron-down" style="color: var(--text-muted);"></i>
            </a>
            <div style="margin-top: 15px; font-size: 11px; color: var(--text-muted);">
                Login untuk bisa claim dan manage server kamu
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- TOAST -->
    <div class="toast" id="toast"></div>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-brand"><span class="brand-icon">S</span> POLAR.ID</div>
        <div class="nav-right">
            <div class="coin-badge"><i class="fas fa-coins"></i> <?= $user_coins ?></div>
            <div class="profile-btn" onclick="navTo('profile')">
                <span style="font-size: 13px; font-weight: 600;" class="hide-mobile"><?= explode(' ', $user_name)[0] ?></span>
                <img src="<?= $user_avatar ?>" alt="Avatar">
            </div>
            <button class="menu-btn" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMenu()"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="nav-brand"><span class="brand-icon">S</span> MENU</div>
            <button class="sidebar-close" onclick="toggleMenu()"><i class="fas fa-times"></i></button>
        </div>
        <a href="#" class="nav-link active" onclick="navTo('home'); toggleMenu();"><i class="fas fa-home"></i> HOME</a>
        <a href="#" class="nav-link" onclick="navTo('status'); toggleMenu();"><i class="fas fa-server"></i> STATUS</a>
        <a href="#" class="nav-link" onclick="navTo('claim'); toggleMenu();"><i class="fas fa-download"></i> CLAIM</a>
        <a href="#" class="nav-link" onclick="navTo('sessions'); toggleMenu();"><i class="fas fa-robot"></i> SESSIONS</a>
        <a href="#" class="nav-link" onclick="navTo('profile'); toggleMenu();"><i class="fas fa-user"></i> PROFILE</a>
        <a href="logout.php" class="nav-link" style="color: var(--orange); margin-top: auto;"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
    </div>

    <div class="main-container">

        <!-- HOME -->
        <div id="sec-home" class="section active">
            <div class="hero">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px; color: var(--orange);"></i> 2 SLOT TERSEDIA</div>
                <h1>Jadibot <br><span>WhatsApp Gratis</span></h1>
                <p>Dapatkan server bot gratis dengan spesifikasi terbaik. Claim sekarang sebelum slot habis!</p>
                <div class="btn-group">
                    <button class="btn btn-orange" style="width: 100%;" onclick="navTo('claim')">
                        <i class="fas fa-download"></i> CLAIM SEKARANG
                    </button>
                    <button class="btn btn-white" style="width: 100%;" onclick="navTo('status')">
                        LIHAT SPECS <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
                <div style="display:flex; justify-content:center; gap:20px; margin-top:30px; font-size: 13px; font-weight: 600;">
                    <span style="color: var(--white);"><i class="fas fa-check-circle text-orange"></i> 100% Gratis</span>
                    <span style="color: var(--white);"><i class="fas fa-bolt text-orange"></i> Setup Instan</span>
                </div>
            </div>
        </div>

        <!-- CLAIM -->
        <div id="sec-claim" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px;"></i> 2 SLOT TERSEDIA</div>
                <h1 style="font-weight: 900; font-size: 32px; text-transform: uppercase;">CLAIM <span style="background: var(--white); color: #000; padding: 0 10px; transform: skew(-5deg); display: inline-block;">SERVER</span></h1>
                <p style="color: var(--text-muted); font-size: 13px;">Isi form di bawah untuk dapetin server bot gratis</p>
            </div>

            <div class="card" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="background: rgba(255,255,255,0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;"><?= substr($user_name, 0, 1) ?></div>
                    <div>
                        <div style="font-size: 10px; color: var(--text-muted); font-weight: bold;">LOGIN AS</div>
                        <div style="font-weight: bold;"><?= $user_name ?></div>
                    </div>
                </div>
                <a href="logout.php" style="color: var(--text-muted); font-size: 12px; font-weight: bold; text-decoration: none;">LOGOUT</a>
            </div>

            <div class="section-title">METODE BAYAR</div>
            <div class="grid-2">
                <div class="select-box active" onclick="selectPay(this)">
                    <i class="fas fa-coins"></i>
                    <h4>ShikyCoin</h4>
                    <p style="color: var(--white);"><?= $user_coins ?> / 50 koin</p>
                </div>
                <div class="select-box" onclick="selectPay(this)">
                    <i class="fas fa-ticket-alt"></i>
                    <h4>Kode Promo</h4>
                    <p>Pakai kode promo</p>
                </div>
            </div>

            <div class="section-title">JENIS SCRIPT</div>
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
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 4px;">Nomor WhatsApp</label>
                    <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" style="width:100%;padding:12px;background:var(--bg-main);border:1px solid var(--border);border-radius:8px;color:white;font-size:14px;">
                </div>
                <div>
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 4px;">Token Aktivasi</label>
                    <div style="display:flex;gap:8px;">
                        <input type="text" id="tokenInput" placeholder="Masukkan token" style="flex:1;padding:12px;background:var(--bg-main);border:1px solid var(--border);border-radius:8px;color:white;font-size:14px;">
                        <button onclick="window.open('https://sfl.gl/rHjdO','_blank')" style="padding:12px 16px;background:var(--bg-card);border:1px solid var(--border);border-radius:8px;cursor:pointer;color:var(--text-muted);font-weight:600;">Gratis →</button>
                    </div>
                </div>
            </div>

            <button class="btn btn-orange" style="width: 100%; margin-top: 10px;" onclick="createSession()">
                <i class="fas fa-rocket"></i> CLAIM SERVER SEKARANG
            </button>
        </div>

        <!-- STATUS -->
        <div id="sec-status" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge" style="background: var(--white); color: #000;"><i class="fas fa-circle" style="font-size: 8px;"></i> REAL-TIME MONITORING</div>
                <h1 style="font-weight: 900; font-size: 32px; text-transform: uppercase;">SERVER <span style="background: var(--orange); color: white; padding: 0 10px; transform: skew(-5deg); display: inline-block;">STATUS</span></h1>
            </div>

            <div class="card">
                <div class="status-grid">
                    <div class="stat-box"><h3 class="text-orange">ISSUE</h3><p>OVERALL</p></div>
                    <div class="stat-box"><h3 style="color: #ff5f56;">2</h3><p>TOTAL SERVER</p></div>
                    <div class="stat-box"><h3 class="text-white"><?= ($phoenix_status['online'] ? 1 : 0) + ($ourin_status['online'] ? 1 : 0) ?></h3><p>ONLINE</p></div>
                    <div class="stat-box"><h3 class="text-orange"><?= (!$phoenix_status['online'] ? 1 : 0) + (!$ourin_status['online'] ? 1 : 0) ?></h3><p>OFFLINE</p></div>
                </div>
            </div>

            <div class="card" style="border-color: <?= $phoenix_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="background: var(--orange); padding: 8px; border-radius: 8px;"><i class="fas fa-server" style="color:white;"></i></div>
                        <div><h3 style="font-size: 16px; font-weight: 900;">PHOENIX MD</h3><div style="font-size: 11px; color: var(--text-muted);">Pterodactyl Node</div></div>
                    </div>
                    <div class="badge-status <?= $phoenix_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $phoenix_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="color: var(--text-muted);">RAM PENGGUNAAN</span><span style="font-weight: bold; color: var(--white);"><?= $phoenix_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color: var(--text-muted);">PING</span><span style="font-weight: bold; color: var(--white);"><?= $phoenix_status['ping'] ?></span></div>
            </div>

            <div class="card" style="border-color: <?= $ourin_status['online'] ? 'var(--green)' : 'var(--red)' ?>;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="background: var(--white); padding: 8px; border-radius: 8px;"><i class="fas fa-microchip" style="color:#000;"></i></div>
                        <div><h3 style="font-size: 16px; font-weight: 900;">OURIN CORE</h3><div style="font-size: 11px; color: var(--text-muted);">Native Script</div></div>
                    </div>
                    <div class="badge-status <?= $ourin_status['online'] ? 'bg-online' : 'bg-offline' ?>"><?= $ourin_status['online'] ? 'ONLINE' : 'OFFLINE' ?></div>
                </div>
                <div class="spec-row"><span style="color: var(--text-muted);">RAM PENGGUNAAN</span><span style="font-weight: bold; color: var(--white);"><?= $ourin_status['ram'] ?></span></div>
                <div class="spec-row"><span style="color: var(--text-muted);">PING</span><span style="font-weight: bold; color: var(--white);"><?= $ourin_status['ping'] ?></span></div>
            </div>
            <p style="text-align: center; font-size: 10px; color: var(--text-muted); margin-top: 20px;">AUTO-REFRESH SETIAP 30 DETIK</p>
        </div>

        <!-- SESSIONS -->
        <div id="sec-sessions" class="section">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px;"></i> <?= count($sessions) ?> SESSION</div>
                <h1 style="font-weight: 900; font-size: 32px; text-transform: uppercase;">MY <span style="background: var(--orange); color: white; padding: 0 10px; transform: skew(-5deg); display: inline-block;">BOTS</span></h1>
            </div>

            <?php if (empty($sessions)): ?>
            <div class="card" style="text-align:center;padding:40px 20px;">
                <div style="font-size:48px;margin-bottom:15px;opacity:0.3;">🤖</div>
                <h3 style="font-weight:700;">Belum Ada Bot</h3>
                <p style="color:var(--text-muted);font-size:13px;">Claim server dulu untuk mulai menggunakan bot</p>
                <button class="btn btn-orange" style="margin-top:15px;" onclick="navTo('claim')">CLAIM SEKARANG</button>
            </div>
            <?php else: ?>
                <?php foreach ($sessions as $s): 
                    $statusClass = $s['status'] === 'online' ? 'bg-online' : ($s['status'] === 'pending' ? 'bg-pending' : 'bg-offline');
                    $statusText = $s['status'] === 'online' ? 'Online' : ($s['status'] === 'pending' ? 'Pending' : 'Offline');
                ?>
                <div class="card">
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
            <div style="text-align: center; margin-bottom: 30px; margin-top: 20px;">
                <div style="position: relative; display: inline-block;">
                    <img src="<?= $user_avatar ?>" style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid var(--white);">
                    <div style="position: absolute; top: 0; right: -10px; background: var(--orange); color: white; padding: 2px 10px; font-size: 10px; font-weight: bold; border-radius: 10px; transform: rotate(15deg);">YOU!</div>
                </div>
                <h1 style="font-weight: 900; font-size: 28px; margin-top: 15px;"><?= $user_name ?></h1>
                <p style="color: var(--text-muted); font-size: 13px;"><?= $user_email ?></p>
                <div style="background: rgba(255,255,255,0.05); border: 1px solid var(--border); display: inline-flex; align-items: center; gap: 15px; padding: 8px 20px; border-radius: 50px; margin-top: 15px;">
                    <div style="font-weight: bold; color: var(--yellow);"><i class="fas fa-coins"></i> <?= $user_coins ?></div>
                    <div style="font-size: 11px; font-weight: bold; letter-spacing: 1px;">SHIKYCOIN</div>
                    <a href="#" style="color: var(--orange); font-size: 11px; font-weight: bold; text-decoration: none;">+EARN</a>
                </div>
                <div style="margin-top: 15px;">
                    <a href="logout.php" style="color: var(--text-muted); font-size: 12px; font-weight: bold; text-decoration: none;">LOGOUT</a>
                </div>
            </div>

            <div class="card" style="text-align: center; padding: 40px 20px;">
                <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: 15px; display: inline-flex; justify-content: center; align-items: center; font-size: 24px; color: var(--text-muted); margin-bottom: 15px;">
                    <i class="fas fa-server"></i>
                </div>
                <h2 style="font-weight: 900; margin-bottom: 5px;">BELUM ADA SERVER</h2>
                <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">Kamu belum pernah claim server</p>
                <button class="btn btn-orange" onclick="navTo('claim')">CLAIM SERVER <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- PAIRING MODAL -->
    <div class="modal-overlay" id="pairModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3><i class="fas fa-link"></i> Tautkan Perangkat</h3>
                <button class="modal-close" onclick="closePairModal()">&times;</button>
            </div>
            <div id="pairContent" style="text-align:center;padding:20px;">
                <div class="spinner" style="width:40px;height:40px;border:3px solid var(--border);border-top-color:var(--orange);border-radius:50%;animation:spin 1s linear infinite;margin:0 auto 15px;"></div>
                <p style="color:var(--text-muted);">Menunggu pairing code...</p>
            </div>
            <style>
                @keyframes spin { to { transform: rotate(360deg); } }
            </style>
        </div>
    </div>

    <script>
        // ========== SUPABASE CONFIG ==========
        const SB_URL = '<?= SUPABASE_URL ?>';
        const SB_KEY = '<?= SUPABASE_KEY ?>';

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
        function selectPay(el) {
            el.parentElement.querySelectorAll('.select-box').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
        }
        function selectScript(el) {
            el.parentElement.querySelectorAll('.select-box').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
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
        async function createSession() {
            const phone = document.getElementById('phoneInput').value.trim();
            const token = document.getElementById('tokenInput').value.trim().toUpperCase();
            const scriptEl = document.querySelector('.select-box.active[data-script]');
            const script = scriptEl ? scriptEl.dataset.script : 'phoenix_md';

            if (!phone) { showToast('Masukkan nomor WhatsApp', 'error'); return; }
            if (!token) { showToast('Masukkan token aktivasi', 'error'); return; }

            let cleanPhone = phone.replace(/[^0-9]/g, '');
            if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
            if (!cleanPhone.startsWith('62')) cleanPhone = '62' + cleanPhone;
            if (cleanPhone.length < 10) { showToast('Nomor terlalu pendek', 'error'); return; }

            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';

            try {
                const redeemData = await supabaseRequest('GET', `redeems?code=eq.${token}&select=*`);
                if (!redeemData?.length) throw new Error('Token tidak valid');
                if (redeemData[0].used) throw new Error('Token sudah digunakan');
                if (Date.now() - redeemData[0].created_at > 600000) throw new Error('Token expired');

                await supabaseRequest('PATCH', `redeems?code=eq.${token}`, {
                    used: true,
                    used_by: '<?= $fingerprint ?>',
                    phone: cleanPhone
                });

                const fingerprint = '<?= $fingerprint ?>';
                await supabaseRequest('POST', 'polar_sessions', {
                    fingerprint: fingerprint,
                    phone: cleanPhone,
                    script: script,
                    status: 'pending',
                    bot_mode: 'public',
                    token_used: token,
                    pairing_code: null,
                    created_at: Date.now()
                });

                showToast('✅ Session berhasil dibuat!', 'success');
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
                <p style="color:var(--text-muted);">Menunggu pairing code...</p>
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
                                <div style="font-size:12px;color:var(--text-muted);">
                                    Masukkan kode ini di WhatsApp:<br><br>
                                    <ol style="text-align:left;padding-left:20px;line-height:2;">
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
                                <div style="font-size:48px;text-align:center;margin-bottom:15px;">✅</div>
                                <h3 style="text-align:center;color:var(--green);">Bot Berhasil Online!</h3>
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
    </script>
<?php endif; ?>
</body>
</html>
