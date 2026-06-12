<?php
require_once 'config.php';

$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$code = '';
for ($i = 0; $i < 8; $i++) $code .= $chars[random_int(0, strlen($chars) - 1)];

$res = supabase('POST', 'redeems', ['code' => $code, 'used' => false, 'created_at' => time() * 1000]);
$ok = isset($res[0]['code']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Token Aktivasi — Polar.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #f6821f;
            --primary-dark: #e07010;
            --primary-light: #fee7d6;
            --primary-glow: rgba(246, 130, 31, 0.2);
            --success: #10b981;
            --success-dark: #059669;
            --success-light: #d1fae5;
            --danger: #ef4444;
            --danger-dark: #dc2626;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --warning-light: #fed7aa;
            --info: #3b82f6;
            --info-light: #dbeafe;
            --dark: #0f172a;
            --dark-2: #1e293b;
            --dark-3: #334155;
            --gray: #64748b;
            --gray-light: #94a3b8;
            --gray-bg: #f1f5f9;
            --bg: #f8fafc;
            --card: #ffffff;
            --border: #e2e8f0;
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 20px;
            --shadow: 0 1px 3px rgba(0,0,0,0.08),0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05),0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05);
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --card: #1e293b;
            --border: #334155;
            --gray-bg: #1e293b;
            --dark: #f1f5f9;
            --dark-2: #e2e8f0;
            --dark-3: #cbd5e1;
            --gray: #94a3b8;
            --gray-light: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: all 0.3s ease;
        }

        /* Card */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 36px 32px;
            width: 100%;
            max-width: 460px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        /* Logo */
        .logo {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .logo-icon {
            font-size: 24px;
            margin-right: 6px;
        }

        /* Title */
        h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .sub {
            color: var(--gray);
            font-size: 13px;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        /* Token Box */
        .token-box {
            background: var(--gray-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            margin: 20px 0;
        }

        .token {
            font-family: 'Inter', monospace;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 6px;
            color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .expire {
            font-size: 12px;
            color: var(--gray);
            margin-top: 10px;
        }

        .countdown {
            color: var(--warning);
            font-weight: 600;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 8px var(--primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-outline {
            background: var(--card);
            border: 1px solid var(--border);
            color: var(--dark-3);
        }

        .btn-outline:hover {
            background: var(--gray-bg);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Steps */
        .steps {
            text-align: left;
            background: var(--gray-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            margin-top: 20px;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 12px;
        }

        .step:last-child {
            margin-bottom: 0;
        }

        .step-number {
            width: 20px;
            height: 20px;
            background: var(--primary-light);
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text {
            flex: 1;
            line-height: 1.5;
        }

        /* Hint */
        .hint {
            font-size: 11px;
            color: var(--gray);
            margin-top: 16px;
            padding: 10px;
            background: var(--primary-light);
            border-radius: var(--radius-sm);
            line-height: 1.5;
        }

        /* Error Box */
        .error-box {
            background: var(--danger-light);
            border: 1px solid var(--danger);
            border-radius: var(--radius);
            padding: 24px;
            text-align: center;
        }

        .error-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .error-title {
            font-weight: 700;
            font-size: 18px;
            color: var(--danger-dark);
            margin-bottom: 8px;
        }

        .error-text {
            font-size: 13px;
            color: var(--danger-dark);
        }

        /* Back Link */
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--gray);
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--card);
            border: 1px solid var(--border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            z-index: 100;
        }

        .theme-toggle:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card {
                padding: 24px 20px;
            }
            .token {
                font-size: 24px;
                letter-spacing: 4px;
            }
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<button class="theme-toggle" onclick="toggleTheme()">
    <i class="fas fa-moon" id="themeIcon"></i>
</button>

<div class="card">
    <a href="index.php" class="logo">
        <span class="logo-icon">❄️</span> Polar.id
    </a>

    <?php if ($ok): ?>
        <h2>✨ Token Siap Digunakan</h2>
        <p class="sub">Salin token di bawah dan gunakan di dashboard untuk mengaktifkan session bot.</p>

        <div class="token-box">
            <div class="token" id="tokenValue"><?= $code ?></div>
            <div class="expire">
                <i class="fas fa-hourglass-half"></i> Berlaku 
                <span class="countdown" id="countdownTimer">10:00</span>
            </div>
        </div>

        <button class="btn btn-primary" onclick="copyToken()">
            <i class="fas fa-copy"></i> Salin Token
        </button>
        
        <a href="dashboard.php" class="btn btn-outline">
            <i class="fas fa-robot"></i> Buka Dashboard
        </a>

        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-text">Salin token di atas</div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-text">Buka Dashboard → Tambah Session</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-text">Pilih script, paste token, masukkan nomor bot</div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-text">Pairing code muncul otomatis — scan dan bot online</div>
            </div>
        </div>

        <div class="hint">
            <i class="fas fa-info-circle"></i> Token hanya bisa digunakan <strong>sekali</strong> dan berlaku <strong>10 menit</strong>.
        </div>

    <?php else: ?>
        <div class="error-box">
            <div class="error-icon">❌</div>
            <div class="error-title">Gagal Generate Token</div>
            <div class="error-text">Terjadi kesalahan. Silakan coba lagi.</div>
        </div>
    <?php endif; ?>

    <a href="token.php" class="back-link">
        <i class="fas fa-sync-alt"></i> Generate token baru
    </a>
</div>

<script>
// Theme Toggle
function toggleTheme() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    if (isDark) {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
        document.getElementById('themeIcon').className = 'fas fa-moon';
    } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        document.getElementById('themeIcon').className = 'fas fa-sun';
    }
}

// Load saved theme
const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
    document.getElementById('themeIcon').className = 'fas fa-sun';
}

// Copy Token
function copyToken() {
    const token = document.getElementById('tokenValue').innerText;
    navigator.clipboard.writeText(token).then(() => {
        const btn = document.querySelector('.btn-primary');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        setTimeout(() => btn.innerHTML = originalText, 2000);
    });
}

// Countdown Timer
let seconds = 600;
const timerEl = document.getElementById('countdownTimer');
if (timerEl) {
    const interval = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
            clearInterval(interval);
            timerEl.innerText = 'EXPIRED';
            timerEl.style.color = '#ef4444';
            return;
        }
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        timerEl.innerText = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        if (seconds <= 60) {
            timerEl.style.color = '#ef4444';
        }
    }, 1000);
}
</script>
</body>
</html>
