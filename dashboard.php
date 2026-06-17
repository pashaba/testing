<?php
require_once 'config.php';
require_once 'config-google.php';
session_start();

// Konfigurasi tambahan
define('JADIBOT_EXPIRY_DAYS', 3);
define('JADIBOT_WARNING_DAYS', 1);

// Cek login
$user = getUserInfo();
$isLoggedIn = ($user !== null);

// Jika belum login, tampilkan halaman login
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
        <title>Login — Polar.id</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .login-container { max-width: 440px; width: 100%; }
            .login-card {
                background: white;
                border-radius: 24px;
                padding: 48px 40px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.08);
                border: 1px solid #e2e8f0;
                text-align: center;
            }
            .logo { font-size: 32px; font-weight: 800; background: linear-gradient(135deg, #f6821f, #e07010); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 8px; }
            .subtitle { color: #64748b; font-size: 14px; margin-bottom: 32px; }
            .google-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                width: 100%;
                padding: 14px;
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                font-size: 16px;
                font-weight: 600;
                color: #1e293b;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
            }
            .google-btn:hover { border-color: #f6821f; box-shadow: 0 4px 12px rgba(246,130,31,0.1); transform: translateY(-1px); }
            .google-btn svg { width: 24px; height: 24px; }
            .divider { display: flex; align-items: center; gap: 16px; margin: 24px 0; color: #94a3b8; font-size: 12px; }
            .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
            .features { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-top: 24px; }
            .feature-item { background: #f8fafc; border-radius: 12px; padding: 12px; font-size: 11px; color: #64748b; }
            .feature-item i { display: block; font-size: 20px; color: #f6821f; margin-bottom: 6px; }
            .error-msg { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; }
            @media (max-width: 480px) { .login-card { padding: 32px 24px; } .features { grid-template-columns: 1fr; } }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-card">
                <div class="logo">❄️ Polar.id</div>
                <div class="subtitle">Masuk untuk mengelola bot WhatsApp kamu</div>
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-msg">
                        <?php if ($_GET['error'] === 'email_not_allowed'): ?>
                            <i class="fas fa-exclamation-circle"></i> Email tidak diizinkan untuk mengakses dashboard.
                        <?php elseif ($_GET['error'] === 'token_failed'): ?>
                            <i class="fas fa-exclamation-circle"></i> Gagal login, silakan coba lagi.
                        <?php else: ?>
                            <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan, silakan coba lagi.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <a href="<?= $auth_url ?>" class="google-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Login dengan Google
                </a>
                <div class="divider">atau</div>
                <div class="features">
                    <div class="feature-item"><i class="fas fa-robot"></i> Kelola Bot</div>
                    <div class="feature-item"><i class="fas fa-coins"></i> Dapat Koin</div>
                    <div class="feature-item"><i class="fas fa-server"></i> Hosting Gratis</div>
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
        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #f6821f; }
        .user-name { font-size: 13px; font-weight: 600; color: #0f172a; }
        .user-email { font-size: 11px; color: #94a3b8; }
        .btn-logout { padding: 6px 14px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #64748b; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; }
        .btn-logout:hover { background: #fef2f2; border-color: #ef4444; color: #ef4444; }

        /* ─── CONTENT ─── */
        .content { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }

        /* ─── FREE BOT SERVER CARD ─── */
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
        }
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
                <div class="user-avatar" style="display:flex;align-items:center;justify-content:center;background:#f6821f;color:white;font-weight:700;"><?= strtoupper(substr($userName, 0, 1)) ?></div>
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

    <!-- HERO CARD - FREE BOT SERVER -->
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
            <a href="#claim" class="btn-hero-primary"><i class="fas fa-rocket"></i> CLAIM SEKARANG</a>
            <a href="#specs" class="btn-hero-secondary"><i class="fas fa-chart-simple"></i> LIHAT SPECS →</a>
        </div>
    </div>

    <!-- KOIN SECTION -->
    <div class="coins-section">
        <div class="coins-left">
            <div class="coins-icon"><i class="fas fa-coins"></i></div>
            <div>
                <div class="coins-label">Total Koin Anda</div>
                <div class="coins-amount">🪙 <?= number_format($userCoins) ?></div>
            </div>
        </div>
        <div class="coins-right">
            <button class="btn-coin" onclick="openCoinModal()"><i class="fas fa-plus-circle"></i> Tambah Koin</button>
            <button class="btn-coin btn-coin-primary" onclick="generateCoinLink()"><i class="fas fa-link"></i> Buat Link Koin</button>
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
        <div class="stat-card"><div class="stat-number"><?= number_format($totalSessions) ?></div><div class="stat-label">Total Session</div></div>
        <div class="stat-card"><div class="stat-number" style="color:#10b981;"><?= number_format($activeSessions) ?></div><div class="stat-label">Online</div></div>
        <div class="stat-card"><div class="stat-number"><?= JADIBOT_EXPIRY_DAYS ?></div><div class="stat-label">Hari Aktif</div></div>
        <div class="stat-card"><div class="stat-number">🪙 <?= number_format($userCoins) ?></div><div class="stat-label">Koin Anda</div></div>
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

<!-- ─── MODAL TAMBAH KOIN ─── -->
<div class="modal" id="coinModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:200;display:none;align-items:center;justify-content:center;padding:20px;">
    <div class="modal-content" style="background:white;border-radius:20px;max-width:400px;width:100%;padding:32px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:18px;font-weight:700;"><i class="fas fa-coins"></i> Tambah Koin</h3>
            <button onclick="closeCoinModal()" style="background:none;border:none;font-size:24px;cursor:pointer;color:#94a3b8;">×</button>
        </div>
        <div style="margin-bottom:16px;">
            <label style="font-size:13px;font-weight:600;display:block;margin-bottom:6px;">Jumlah Koin</label>
            <input type="number" id="coinAmount" min="1" value="1" style="width:100%;padding:12px;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;">
        </div>
        <button onclick="generateCoinLink()" class="btn-hero-primary" style="width:100%;justify-content:center;">Buat Link Koin</button>
    </div>
</div>

<!-- ─── MODAL ADD SESSION ─── -->
<div class="modal" id="addModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:200;display:none;align-items:center;justify-content:center;padding:20px;">
    <div class="modal-content" style="background:white;border-radius:20px;max-width:480px;width:100%;padding:32px;">
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
    
    if (!phone) { alert('Masukkan nomor WhatsApp'); return; }
    if (!token) { alert('Masukkan token aktivasi'); return; }
    
    let cleanPhone = phone.replace(/[^0-9]/g, '');
    if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
    if (!cleanPhone.startsWith('62')) cleanPhone = '62' + cleanPhone;
    if (cleanPhone.length < 10) { alert('Nomor terlalu pendek'); return; }
    
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
        alert('✅ Session berhasil dibuat!');
    } catch(e) {
        alert('❌ ' + e.message);
    } finally {
        btn.disabled = false; btn.innerHTML = 'Buat Session';
    }
}

async function deleteSession(id, phone) {
    if (!confirm(`Hapus session +${phone}?`)) return;
    try {
        await supabaseRequest('DELETE', `polar_sessions?id=eq.${id}`);
        await loadSessions();
        alert('✅ Session dihapus');
    } catch(e) { alert('❌ ' + e.message); }
}

function openPairModal(phone) {
    // Buka modal pairing
    window.open('dashboard.php?pair=' + phone, '_blank');
}

// ─── MODAL FUNCTIONS ───
function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}
function openCoinModal() {
    document.getElementById('coinModal').style.display = 'flex';
}
function closeCoinModal() {
    document.getElementById('coinModal').style.display = 'none';
}

async function generateCoinLink() {
    const amount = document.getElementById('coinAmount')?.value || 1;
    closeCoinModal();
    
    try {
        const response = await fetch('api/create-coin-link.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ amount: parseInt(amount) })
        });
        const data = await response.json();
        
        if (data.success) {
            const msg = `✅ Link koin berhasil dibuat!\n\n🪙 ${amount} Koin\n🔗 ${data.short_url || data.original_url}\n\nBagikan link ini ke user untuk claim koin.`;
            alert(msg);
            if (data.short_url) {
                navigator.clipboard.writeText(data.short_url);
                alert('📋 Link sudah disalin ke clipboard!');
            }
        } else {
            alert('❌ ' + (data.message || 'Gagal membuat link'));
        }
    } catch(e) {
        alert('❌ Error: ' + e.message);
    }
}

async function claimPackage(days, coin) {
    if (<?= $userCoins ?> < coin) {
        alert('❌ Koin tidak cukup! Anda punya <?= $userCoins ?> koin, butuh ' + coin + ' koin.');
        return;
    }
    if (!confirm(`Klaim paket ${days} hari dengan ${coin} koin?`)) return;
    
    // Proses klaim paket (kirim ke bot via API)
    alert(`✅ Paket ${days} hari berhasil diklaim! +${days} hari masa aktif.`);
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
