<?php
require_once 'config.php';
require_once 'config-google.php';
session_start();

// Konfigurasi tambahan
define('JADIBOT_EXPIRY_DAYS', 3);
define('JADIBOT_WARNING_DAYS', 1);

// Cek login - dengan remember me
$isLoggedIn = isset($_SESSION['user_email']);
if (!$isLoggedIn && isset($_COOKIE['polar_user_email'])) {
    $_SESSION['user_email'] = $_COOKIE['polar_user_email'];
    $_SESSION['user_name'] = $_COOKIE['polar_user_name'] ?? 'User';
    $_SESSION['user_picture'] = $_COOKIE['polar_user_picture'] ?? '';
    $_SESSION['user_coins'] = intval($_COOKIE['polar_user_coins'] ?? 0);
    $isLoggedIn = true;
}

$user = getUserInfo();
$isLoggedIn = ($user !== null);

// Jika belum login, tampilkan halaman dengan popup login
if (!$isLoggedIn) {
    $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => GOOGLE_CLIENT_ID,
        'redirect_uri' => GOOGLE_REDIRECT_URI,
        'response_type' => 'code',
        'scope' => 'email profile',
        'access_type' => 'online',
        'prompt' => 'select_account'
    ]);
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Polar.id — Login</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Inter', sans-serif;
                background: #f8fafc;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            /* ─── OVERLAY ─── */
            .overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(12px);
                z-index: 999;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 0.3s ease;
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            /* ─── POPUP CARD ─── */
            .popup {
                background: white;
                border-radius: 32px;
                padding: 48px 40px;
                max-width: 420px;
                width: 100%;
                text-align: center;
                box-shadow: 0 24px 80px rgba(0,0,0,0.15);
                animation: slideUp 0.4s ease;
                position: relative;
                overflow: hidden;
            }
            .popup::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #f6821f, #fbbf24);
            }
            @keyframes slideUp {
                from { transform: translateY(30px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            /* ─── LOGO ─── */
            .logo-icon {
                width: 64px;
                height: 64px;
                background: linear-gradient(135deg, #f6821f, #e07010);
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                margin: 0 auto 16px;
                box-shadow: 0 8px 24px rgba(246,130,31,0.25);
            }
            .logo-icon i { color: white; }
            
            .popup-title {
                font-size: 24px;
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 6px;
            }
            .popup-title span { color: #f6821f; }
            
            .popup-sub {
                font-size: 13px;
                color: #94a3b8;
                margin-bottom: 24px;
                line-height: 1.6;
            }
            
            /* ─── USER PREVIEW ─── */
            .user-preview {
                background: #f8fafc;
                border-radius: 16px;
                padding: 16px 20px;
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 24px;
                border: 1px solid #e2e8f0;
            }
            .user-preview-avatar {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: linear-gradient(135deg, #f6821f, #e07010);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 700;
                font-size: 18px;
                flex-shrink: 0;
            }
            .user-preview-info { text-align: left; flex: 1; }
            .user-preview-name {
                font-size: 14px;
                font-weight: 600;
                color: #0f172a;
            }
            .user-preview-email {
                font-size: 12px;
                color: #94a3b8;
            }
            
            /* ─── BUTTON ─── */
            .btn-google {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                width: 100%;
                padding: 14px;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                color: #1e293b;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
            }
            .btn-google:hover {
                border-color: #f6821f;
                box-shadow: 0 4px 16px rgba(246,130,31,0.12);
                transform: translateY(-1px);
            }
            .btn-google svg { width: 22px; height: 22px; flex-shrink: 0; }
            
            /* ─── FOOTER ─── */
            .popup-footer {
                margin-top: 20px;
                font-size: 11px;
                color: #cbd5e1;
            }
            .popup-footer a {
                color: #f6821f;
                text-decoration: none;
                font-weight: 600;
            }
            
            /* ─── RESPONSIVE ─── */
            @media (max-width: 480px) {
                .popup { padding: 32px 24px; }
                .logo-icon { width: 48px; height: 48px; font-size: 20px; }
                .popup-title { font-size: 20px; }
            }
        </style>
    </head>
    <body>
        <div class="overlay">
            <div class="popup">
                <!-- Logo -->
                <div class="logo-icon"><i class="fas fa-snowflake"></i></div>
                
                <!-- Title -->
                <div class="popup-title">Halo! <span>Login</span></div>
                <div class="popup-sub">Login dengan Google untuk mulai mengelola bot WhatsApp kamu</div>
                
                <!-- User Preview -->
                <div class="user-preview">
                    <div class="user-preview-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-preview-info">
                        <div class="user-preview-name">Login sebagai Kimtha</div>
                        <div class="user-preview-email">Login untuk bisa claim dan manage server kamu</div>
                    </div>
                    <div style="color: #f6821f; font-size: 20px;">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                
                <!-- Google Button -->
                <a href="<?= $auth_url ?>" class="btn-google">
                    <svg width="22" height="22" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Login dengan Google
                </a>
                
                <!-- Footer -->
                <div class="popup-footer">
                    <i class="fas fa-shield-alt"></i> Aman dengan Google OAuth 2.0
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== DASHBOARD SETELAH LOGIN ==========
$userCoins = $_SESSION['user_coins'] ?? 0;
$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userPicture = $_SESSION['user_picture'] ?? '';

// Ambil session dari Supabase
$sessions = supabase('GET', 'polar_sessions?select=count&status=eq.online');
$activeSessions = $sessions[0]['count'] ?? 0;
$totalSessions = supabase('GET', 'polar_sessions?select=count');
$totalSessions = $totalSessions[0]['count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id — Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
        }

        /* ─── HEADER ─── */
        .header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .logo { font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #f6821f, #e07010); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .user-info { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 4px 12px 4px 4px; border-radius: 30px; border: 1px solid #e2e8f0; transition: all 0.2s; }
        .user-info:hover { border-color: #f6821f; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        .user-name { font-size: 13px; font-weight: 600; color: #0f172a; }
        .user-email { font-size: 11px; color: #94a3b8; display: none; }
        .btn-logout { padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #64748b; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-logout:hover { background: #fef2f2; border-color: #ef4444; color: #ef4444; }

        /* ─── CONTENT ─── */
        .content { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }

        /* ─── HERO CARD ─── */
        .hero-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 24px;
            padding: 40px 48px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
            border: 1px solid #334155;
            position: relative;
            overflow: hidden;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(246,130,31,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-left { flex: 1; min-width: 240px; position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.3);
            color: #10b981;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .hero-badge i { font-size: 8px; }
        .hero-title { font-size: 28px; font-weight: 800; color: white; margin-bottom: 8px; }
        .hero-title span { color: #f6821f; }
        .hero-desc { font-size: 14px; color: #94a3b8; line-height: 1.6; max-width: 420px; }
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .hero-stat { display: flex; align-items: center; gap: 8px; }
        .hero-stat-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(246,130,31,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #f6821f;
        }
        .hero-stat-text { color: #94a3b8; font-size: 12px; }
        .hero-stat-text strong { color: white; font-size: 16px; display: block; }
        .hero-right { display: flex; gap: 12px; flex-wrap: wrap; position: relative; z-index: 1; }
        .btn-hero-primary {
            padding: 12px 28px;
            background: linear-gradient(135deg, #f6821f, #e07010);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(246,130,31,0.35); }
        .btn-hero-secondary {
            padding: 12px 24px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            color: #94a3b8;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.15); color: white; }

        /* ─── KOIN SECTION ─── */
        .coins-section {
            background: white;
            border-radius: 16px;
            padding: 24px 32px;
            border: 1px solid #e2e8f0;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .coins-left { display: flex; align-items: center; gap: 16px; }
        .coins-icon {
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
        }
        .coins-label { font-size: 12px; color: #64748b; }
        .coins-amount { font-size: 28px; font-weight: 800; color: #0f172a; }
        .coins-right { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-coin {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            color: #0f172a;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-coin:hover { border-color: #f6821f; background: #fff4eb; color: #f6821f; }
        .btn-coin-primary {
            background: linear-gradient(135deg, #f6821f, #e07010);
            color: white;
            border: none;
        }
        .btn-coin-primary:hover { background: #e07010; color: white; }

        /* ─── PAKET JADIBOT ─── */
        .packages-section { margin-bottom: 32px; }
        .packages-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .packages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }
        .package-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            text-align: center;
            transition: all 0.2s;
        }
        .package-card:hover { border-color: #f6821f; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
        .package-card.best { border-color: #f6821f; background: #fff4eb; }
        .package-days { font-size: 24px; font-weight: 800; color: #0f172a; }
        .package-label { font-size: 12px; color: #64748b; margin-bottom: 8px; }
        .package-coin { font-size: 14px; font-weight: 600; color: #f59e0b; margin-bottom: 12px; }
        .package-coin span { font-size: 20px; }
        .package-badge {
            display: inline-block;
            padding: 2px 10px;
            background: #f6821f;
            color: white;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .btn-package {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-package:hover { background: #f6821f; color: white; border-color: #f6821f; }
        .btn-package.disabled { opacity: 0.4; cursor: not-allowed; }

        /* ─── SESSION STATS ─── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
        }
        .stat-card:hover { border-color: #f6821f; transform: translateY(-2px); }
        .stat-number { font-size: 28px; font-weight: 800; color: #f6821f; }
        .stat-label { font-size: 12px; color: #64748b; margin-top: 4px; }

        /* ─── SESSIONS ─── */
        .sessions-section { background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; }
        .sessions-header { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .sessions-title { font-size: 16px; font-weight: 700; }
        .sessions-body { padding: 20px 24px; }
        .session-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap; gap: 8px;
        }
        .session-item:last-child { border-bottom: none; }
        .session-phone { font-weight: 600; font-family: monospace; }
        .session-status {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .session-status.online { background: #d1fae5; color: #059669; }
        .session-status.offline { background: #fee2e2; color: #dc2626; }
        .session-status.pending { background: #fef3c7; color: #d97706; }
        .session-actions { display: flex; gap: 6px; }
        .btn-sm {
            padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;
            border: 1px solid #e2e8f0; background: white; cursor: pointer; text-decoration: none;
            color: #0f172a; transition: all 0.2s;
        }
        .btn-sm:hover { background: #f8fafc; }
        .btn-sm.danger { color: #dc2626; border-color: #fecaca; }
        .btn-sm.danger:hover { background: #fee2e2; }
        .btn-sm.primary { color: #f6821f; border-color: #fed7aa; }
        .btn-sm.primary:hover { background: #fff4eb; }

        .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
        .empty-state i { font-size: 40px; margin-bottom: 12px; opacity: 0.5; }

        /* ─── TOAST ─── */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 14px;
            z-index: 999;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            animation: toastSlide 0.3s ease;
            display: none;
        }
        .toast.success { border-left: 4px solid #10b981; }
        .toast.error { border-left: 4px solid #ef4444; }
        @keyframes toastSlide {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .hero-card { padding: 24px; }
            .hero-title { font-size: 22px; }
            .hero-stats { gap: 16px; }
            .coins-section { padding: 16px 20px; }
            .packages-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .header { padding: 12px 16px; flex-wrap: wrap; gap: 8px; }
            .content { padding: 16px; }
            .hero-card { padding: 20px; }
            .hero-right { width: 100%; }
            .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
            .packages-grid { grid-template-columns: 1fr; }
            .coins-right { width: 100%; }
            .btn-coin { flex: 1; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- ─── HEADER ─── -->
<header class="header">
    <div class="header-left">
        <div class="logo"><i class="fas fa-snowflake"></i> Polar.id</div>
    </div>
    <div class="header-right">
        <div class="user-info">
            <?php if ($userPicture): ?>
                <img src="<?= $userPicture ?>" class="user-avatar" alt="Avatar">
            <?php else: ?>
                <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;background:#f6821f;color:white;font-weight:700;font-size:14px;"><?= strtoupper(substr($userName, 0, 1)) ?></div>
            <?php endif; ?>
            <div>
                <div class="user-name"><?= htmlspecialchars($userName) ?></div>
                <div class="user-email"><?= htmlspecialchars($userEmail) ?></div>
            </div>
        </div>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</header>

<!-- ─── CONTENT ─── -->
<div class="content">

    <!-- TOAST -->
    <div class="toast" id="toast"></div>

    <!-- HERO CARD -->
    <div class="hero-card">
        <div class="hero-left">
            <div class="hero-badge"><i class="fas fa-circle"></i> 2 SLOT TERSEDIA</div>
            <div class="hero-title">Free Bot <span>Server Hosting</span></div>
            <div class="hero-desc">Dapatkan server bot gratis dengan spesifikasi terbaik. Claim sekarang sebelum slot habis!</div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-globe"></i></div>
                    <div class="hero-stat-text"><strong>100% Gratis</strong> Setup Instan</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-bolt"></i></div>
                    <div class="hero-stat-text"><strong>PRO</strong> Available</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-circle-check"></i></div>
                    <div class="hero-stat-text"><strong>Online</strong> Unlimited</div>
                </div>
            </div>
        </div>
        <div class="hero-right">
            <button class="btn-hero-primary" onclick="showToast('Coming soon! Fitur claim akan segera hadir.', 'info')"><i class="fas fa-rocket"></i> CLAIM SEKARANG</button>
            <button class="btn-hero-secondary" onclick="showToast('Specs: RAM 1GB, CPU 2 Core, Disk 5GB', 'info')"><i class="fas fa-chart-simple"></i> LIHAT SPECS →</button>
        </div>
    </div>

    <!-- KOIN SECTION -->
    <div class="coins-section">
        <div class="coins-left">
            <div class="coins-icon"><i class="fas fa-coins"></i></div>
            <div>
                <div class="coins-label">Total Koin Anda</div>
                <div class="coins-amount" id="userCoins">🪙 <?= number_format($userCoins) ?></div>
            </div>
        </div>
        <div class="coins-right">
            <button class="btn-coin btn-coin-primary" id="createCoinBtn"><i class="fas fa-link"></i> Buat Link Koin</button>
        </div>
    </div>

    <!-- PAKET JADIBOT -->
    <div class="packages-section">
        <div class="packages-title"><i class="fas fa-robot"></i> Paket Jadibot</div>
        <div class="packages-grid">
            <?php
            $packages = [
                ['days' => 1, 'coin' => 1, 'label' => '1 Hari', 'best' => false],
                ['days' => 2, 'coin' => 2, 'label' => '2 Hari', 'best' => false],
                ['days' => 5, 'coin' => 4, 'label' => '5 Hari (Hemat)', 'best' => true],
                ['days' => 14, 'coin' => 10, 'label' => '14 Hari (Best Value)', 'best' => false]
            ];
            foreach ($packages as $pkg):
                $disabled = ($userCoins < $pkg['coin']) ? 'disabled' : '';
            ?>
            <div class="package-card <?= $pkg['best'] ? 'best' : '' ?>">
                <?php if ($pkg['best']): ?>
                    <div class="package-badge">⭐ BEST DEAL</div>
                <?php endif; ?>
                <div class="package-days"><?= $pkg['days'] ?> Hari</div>
                <div class="package-label">Masa Aktif</div>
                <div class="package-coin"><span>🪙 <?= $pkg['coin'] ?></span> Koin</div>
                <button class="btn-package <?= $disabled ?>" onclick="claimPackage(<?= $pkg['days'] ?>, <?= $pkg['coin'] ?>)">
                    <?= $disabled ? 'Koin Tidak Cukup' : 'Klaim Sekarang' ?>
                </button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SESSION STATS -->
    <div class="stats-grid">
        <div class="stat-card" onclick="showToast('Total session terdaftar: <?= number_format($totalSessions) ?>', 'info')">
            <div class="stat-number"><?= number_format($totalSessions) ?></div>
            <div class="stat-label">Total Session</div>
        </div>
        <div class="stat-card" onclick="showToast('Session online: <?= number_format($activeSessions) ?>', 'info')">
            <div class="stat-number" style="color:#10b981;"><?= number_format($activeSessions) ?></div>
            <div class="stat-label">Online</div>
        </div>
        <div class="stat-card" onclick="showToast('Masa aktif session: <?= JADIBOT_EXPIRY_DAYS ?> hari', 'info')">
            <div class="stat-number"><?= JADIBOT_EXPIRY_DAYS ?></div>
            <div class="stat-label">Hari Aktif</div>
        </div>
        <div class="stat-card" onclick="showToast('Koin Anda: <?= number_format($userCoins) ?>', 'info')">
            <div class="stat-number">🪙 <?= number_format($userCoins) ?></div>
            <div class="stat-label">Koin Anda</div>
        </div>
    </div>

    <!-- SESSIONS LIST -->
    <div class="sessions-section">
        <div class="sessions-header">
            <div class="sessions-title"><i class="fas fa-robot"></i> Session Bot Anda</div>
            <button class="btn-coin btn-coin-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Tambah Session</button>
        </div>
        <div class="sessions-body" id="sessionsContainer">
            <div class="empty-state"><i class="fas fa-inbox"></i><div>Belum ada session</div></div>
        </div>
    </div>
</div>

<!-- ─── MODAL ADD SESSION ─── -->
<div class="modal" id="addModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:200;display:none;align-items:center;justify-content:center;padding:20px;">
    <div class="modal-content" style="background:white;border-radius:20px;max-width:480px;width:100%;padding:32px;animation:slideUp 0.3s ease;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;"><i class="fas fa-plus-circle"></i> Tambah Session</h3>
            <button onclick="closeAddModal()" style="background:none;border:none;font-size:24px;cursor:pointer;color:#94a3b8;">×</button>
        </div>
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Pilih Script</label>
            <select id="scriptSelect" style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;background:white;">
                <option value="phoenix_md">🔥 Phoenix MD</option>
                <option value="ourin_md" disabled>🦊 Ourin MD (Maintenance)</option>
            </select>
        </div>
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Nomor WhatsApp</label>
            <input type="text" id="phoneInput" placeholder="628xxxxxxxxxx" style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;">
        </div>
        <div style="margin-bottom:20px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Token Aktivasi</label>
            <div style="display:flex;gap:8px;">
                <input type="text" id="tokenInput" placeholder="Masukkan token" style="flex:1;padding:12px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;">
                <button onclick="window.open('https://sfl.gl/rHjdO','_blank')" style="padding:12px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;cursor:pointer;font-weight:600;">Gratis →</button>
            </div>
        </div>
        <button onclick="createSession()" class="btn-hero-primary" style="width:100%;justify-content:center;"><i class="fas fa-rocket"></i> Buat Session</button>
    </div>
</div>

<script>
// ─── TOAST ───
function showToast(message, type = 'info') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast ' + type;
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
}

// ─── CREATE COIN LINK (1 KLIK → 1 KOIN) ───
document.getElementById('createCoinBtn').addEventListener('click', async function() {
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    btn.disabled = true;
    
    try {
        const response = await fetch('api/create-coin-link.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ amount: 1 })
        });
        const data = await response.json();
        
        if (data.success) {
            const link = data.short_url || data.original_url;
            showToast('✅ Link koin berhasil dibuat! 1 koin siap diklaim.', 'success');
            navigator.clipboard.writeText(link).then(() => {
                showToast('📋 Link sudah disalin ke clipboard!', 'success');
            }).catch(() => {
                showToast('🔗 Link: ' + link, 'info');
            });
            // Update koin (nanti akan refresh otomatis setelah claim)
        } else {
            showToast('❌ ' + (data.message || 'Gagal membuat link'), 'error');
        }
    } catch(e) {
        showToast('❌ Error: ' + e.message, 'error');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
});

// ─── SESSION DATA ───
let sessions = [];
const SB_URL = '<?= SUPABASE_URL ?>';
const SB_KEY = '<?= SUPABASE_KEY ?>';
const MAX_SESSIONS = <?= MAX_SESSIONS_PER_FINGERPRINT ?>;
const EXPIRY_DAYS = <?= JADIBOT_EXPIRY_DAYS ?>;
let fingerprint = '';

async function getFingerprint() {
    let uniqueId = localStorage.getItem('polar_device_id');
    if (!uniqueId) { uniqueId = crypto.randomUUID() + '-' + Date.now(); localStorage.setItem('polar_device_id', uniqueId); }
    const components = [navigator.userAgent, navigator.language, screen.width, screen.height, screen.colorDepth, new Date().getTimezoneOffset(), navigator.hardwareConcurrency || '', uniqueId].join('|');
    const hash = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(components));
    return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2,'0')).join('').slice(0, 32);
}

async function supabaseRequest(method, endpoint, body = null) {
    const ctrl = new AbortController();
    const timer = setTimeout(() => ctrl.abort(), 15000);
    try {
        const r = await fetch(`${SB_URL}/rest/v1/${endpoint}`, {
            method, headers: { 'Content-Type': 'application/json', apikey: SB_KEY, Authorization: `Bearer ${SB_KEY}`, Prefer: 'return=representation' },
            body: body ? JSON.stringify(body) : null, signal: ctrl.signal
        });
        clearTimeout(timer);
        if (!r.ok) { const errText = await r.text(); throw new Error(`HTTP ${r.status}: ${errText.substring(0, 200)}`); }
        const t = await r.text();
        return t ? JSON.parse(t) : [];
    } catch(e) { clearTimeout(timer); throw e; }
}

async function loadSessions() {
    try {
        fingerprint = await getFingerprint();
        const data = await supabaseRequest('GET', `polar_sessions?fingerprint=eq.${fingerprint}&order=created_at.desc`);
        sessions = Array.isArray(data) ? data : [];
        renderSessions();
    } catch(e) { console.error(e); sessions = []; renderSessions(); }
}

function renderSessions() {
    const container = document.getElementById('sessionsContainer');
    if (!sessions.length) {
        container.innerHTML = `<div class="empty-state"><i class="fas fa-inbox"></i><div>Belum ada session</div></div>`;
        return;
    }
    container.innerHTML = sessions.map(s => {
        const statusClass = s.status === 'online' ? 'online' : (s.status === 'pending' ? 'pending' : 'offline');
        const statusLabel = s.status === 'online' ? 'Online' : (s.status === 'pending' ? 'Pending' : 'Offline');
        return `
            <div class="session-item">
                <span class="session-phone"><i class="fab fa-whatsapp"></i> +${s.phone}</span>
                <span class="session-status ${statusClass}"><i class="fas fa-circle" style="font-size:6px;"></i> ${statusLabel}</span>
                <div class="session-actions">
                    <button class="btn-sm primary" onclick="openPairModal('${s.phone}')"><i class="fas fa-link"></i> Pairing</button>
                    <button class="btn-sm danger" onclick="deleteSession(${s.id}, '${s.phone}')"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
    }).join('');
}

async function createSession() {
    const phone = document.getElementById('phoneInput').value.trim();
    const token = document.getElementById('tokenInput').value.trim().toUpperCase();
    const script = document.getElementById('scriptSelect').value;
    
    if (!phone) { showToast('Masukkan nomor WhatsApp', 'error'); return; }
    if (!token) { showToast('Masukkan token aktivasi', 'error'); return; }
    
    let cleanPhone = phone.replace(/[^0-9]/g, '');
    if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
    if (!cleanPhone.startsWith('62')) cleanPhone = '62' + cleanPhone;
    if (cleanPhone.length < 10) { showToast('Nomor terlalu pendek', 'error'); return; }
    
    const btn = event.target;
    btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    
    try {
        const redeemData = await supabaseRequest('GET', `redeems?code=eq.${token}&select=*`);
        if (!redeemData?.length) throw new Error('Token tidak valid');
        if (redeemData[0].used) throw new Error('Token sudah digunakan');
        if (Date.now() - redeemData[0].created_at > 600000) throw new Error('Token expired');
        
        await supabaseRequest('PATCH', `redeems?code=eq.${token}`, { used: true, used_by: fingerprint, phone: cleanPhone });
        await supabaseRequest('POST', 'polar_sessions', {
            fingerprint, phone: cleanPhone, script, status: 'pending',
            bot_mode: 'public', token_used: token, pairing_code: null,
            created_at: Date.now()
        });
        
        closeAddModal();
        await loadSessions();
        showToast('✅ Session berhasil dibuat!', 'success');
    } catch(e) {
        showToast('❌ ' + e.message, 'error');
    } finally {
        btn.disabled = false; btn.innerHTML = 'Buat Session';
    }
}

async function deleteSession(id, phone) {
    if (!confirm(`Hapus session +${phone}?`)) return;
    try {
        await supabaseRequest('DELETE', `polar_sessions?id=eq.${id}`);
        await loadSessions();
        showToast('✅ Session dihapus', 'success');
    } catch(e) { showToast('❌ ' + e.message, 'error'); }
}

function openPairModal(phone) {
    showToast('🔗 Pairing code akan muncul di modal', 'info');
    // Implementasi pairing modal...
}

async function claimPackage(days, coin) {
    if (<?= $userCoins ?> < coin) {
        showToast('❌ Koin tidak cukup! Butuh ' + coin + ' koin.', 'error');
        return;
    }
    if (!confirm(`Klaim paket ${days} hari dengan ${coin} koin?`)) return;
    showToast('✅ Paket ' + days + ' hari berhasil diklaim!', 'success');
}

// ─── MODAL FUNCTIONS ───
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

// ─── CLOSE MODAL ON OVERLAY ───
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
});

// ─── INIT ───
loadSessions();
setInterval(loadSessions, 30000);
</script>

</body>
</html>
