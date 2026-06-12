<?php
require_once 'config.php';

// ========== AUTHENTIKASI SEDERHANA ==========
session_start();

// Ganti dengan password Anda
$ADMIN_PASSWORD = 'admin2024'; // GANTI DENGAN PASSWORD KUAT!

if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if ($_POST['password'] === $ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Password salah!';
        }
    }
    
    // Tampilkan form login
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login — Polar.id</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-card {
                background: rgba(255,255,255,0.05);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px;
                padding: 40px;
                width: 100%;
                max-width: 400px;
                text-align: center;
            }
            .logo {
                font-size: 32px;
                font-weight: 800;
                background: linear-gradient(135deg, #f6821f, #e07010);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 20px;
            }
            .login-card h2 {
                color: white;
                margin-bottom: 8px;
            }
            .login-card p {
                color: #94a3b8;
                font-size: 13px;
                margin-bottom: 30px;
            }
            input {
                width: 100%;
                padding: 14px 16px;
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.2);
                border-radius: 12px;
                color: white;
                font-size: 14px;
                margin-bottom: 20px;
            }
            input:focus {
                outline: none;
                border-color: #f6821f;
            }
            button {
                width: 100%;
                padding: 14px;
                background: linear-gradient(135deg, #f6821f, #e07010);
                border: none;
                border-radius: 12px;
                color: white;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }
            .error {
                background: rgba(239,68,68,0.2);
                border: 1px solid #ef4444;
                border-radius: 10px;
                padding: 10px;
                color: #fca5a5;
                font-size: 13px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="login-card">
            <div class="logo">❄️ Polar.id</div>
            <h2>Admin Panel</h2>
            <p>Masukkan password untuk mengakses</p>
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="password" name="password" placeholder="Password" autofocus>
                <button type="submit"><i class="fas fa-lock"></i> Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ========== FUNGSI ADMIN ==========
// Ambil statistik
function getStats() {
    global $supabase;
    
    $totalSessions = supabase('GET', 'polar_sessions?select=count');
    $onlineSessions = supabase('GET', 'polar_sessions?select=count&status=eq.online');
    $pendingSessions = supabase('GET', 'polar_sessions?select=count&status=eq.pending');
    $offlineSessions = supabase('GET', 'polar_sessions?select=count&status=eq.offline');
    
    $totalTokens = supabase('GET', 'redeems?select=count');
    $usedTokens = supabase('GET', 'redeems?select=count&used=eq.true');
    $unusedTokens = supabase('GET', 'redeems?select=count&used=eq.false');
    
    $totalReviews = supabase('GET', 'reviews?select=count');
    $avgRating = supabase('GET', 'reviews?select=rating');
    $avg = 0;
    if ($avgRating) {
        $sum = 0;
        foreach ($avgRating as $r) $sum += $r['rating'];
        $avg = round($sum / count($avgRating), 1);
    }
    
    // Hitung fingerprint unik
    $fingerprints = supabase('GET', 'polar_sessions?select=fingerprint');
    $uniqueFp = [];
    foreach ($fingerprints as $f) {
        if ($f['fingerprint']) $uniqueFp[$f['fingerprint']] = true;
    }
    
    return [
        'total_sessions' => $totalSessions[0]['count'] ?? 0,
        'online_sessions' => $onlineSessions[0]['count'] ?? 0,
        'pending_sessions' => $pendingSessions[0]['count'] ?? 0,
        'offline_sessions' => $offlineSessions[0]['count'] ?? 0,
        'total_tokens' => $totalTokens[0]['count'] ?? 0,
        'used_tokens' => $usedTokens[0]['count'] ?? 0,
        'unused_tokens' => $unusedTokens[0]['count'] ?? 0,
        'total_reviews' => $totalReviews[0]['count'] ?? 0,
        'avg_rating' => $avg,
        'unique_users' => count($uniqueFp)
    ];
}

// Ambil semua session
function getAllSessions() {
    return supabase('GET', 'polar_sessions?order=created_at.desc');
}

// Ambil semua token
function getAllTokens() {
    return supabase('GET', 'redeems?order=created_at.desc');
}

// Ambil semua review
function getAllReviews() {
    return supabase('GET', 'reviews?order=created_at.desc');
}

// Ambil log aktivitas (contoh)
function getActivityLogs() {
    $logFile = __DIR__ . '/log/cleanup.log';
    $logs = [];
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lines = array_reverse($lines);
        foreach (array_slice($lines, 0, 100) as $line) {
            $logs[] = htmlspecialchars(trim($line));
        }
    }
    return $logs;
}

// Handle action
$action = $_GET['action'] ?? 'dashboard';
$message = '';
$error = '';

// Delete session
if ($action === 'delete_session' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    supabase('DELETE', "polar_sessions?id=eq.$id");
    $message = 'Session berhasil dihapus';
    header('Location: admin.php?action=sessions&msg=' . urlencode($message));
    exit;
}

// Delete token
if ($action === 'delete_token' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    supabase('DELETE', "redeems?id=eq.$id");
    $message = 'Token berhasil dihapus';
    header('Location: admin.php?action=tokens&msg=' . urlencode($message));
    exit;
}

// Generate token
if ($action === 'generate_token' && isset($_POST['generate'])) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < 8; $i++) $code .= $chars[random_int(0, strlen($chars) - 1)];
    supabase('POST', 'redeems', ['code' => $code, 'used' => false, 'created_at' => time() * 1000]);
    $message = "Token $code berhasil digenerate";
}

// Delete review
if ($action === 'delete_review' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    supabase('DELETE', "reviews?id=eq.$id");
    $message = 'Review berhasil dihapus';
    header('Location: admin.php?action=reviews&msg=' . urlencode($message));
    exit;
}

$stats = getStats();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin Panel — Polar.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 260px;
            background: #1e293b;
            border-right: 1px solid #334155;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #334155;
        }
        .sidebar-logo {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #f6821f, #e07010);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-nav {
            padding: 20px 12px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .nav-item:hover, .nav-item.active {
            background: rgba(246, 130, 31, 0.1);
            color: #f6821f;
        }
        .nav-icon { width: 24px; text-align: center; }
        
        /* Main Content */
        .main {
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .page-title { font-size: 20px; font-weight: 700; }
        .logout-btn {
            background: rgba(239,68,68,0.2);
            border: 1px solid #ef4444;
            color: #fca5a5;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
        }
        .content { padding: 24px 32px; }
        
        /* Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 20px;
        }
        .stat-value { font-size: 32px; font-weight: 800; color: #f6821f; }
        .stat-label { font-size: 12px; color: #94a3b8; margin-top: 8px; }
        
        /* Tables */
        .table-container {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #334155; }
        th { color: #94a3b8; font-weight: 600; font-size: 12px; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-online { background: rgba(16,185,129,0.2); color: #10b981; }
        .badge-offline { background: rgba(239,68,68,0.2); color: #ef4444; }
        .badge-pending { background: rgba(245,158,11,0.2); color: #f59e0b; }
        .btn-delete {
            background: rgba(239,68,68,0.2);
            border: 1px solid #ef4444;
            color: #fca5a5;
            padding: 4px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 11px;
        }
        .btn-generate {
            background: rgba(246,130,31,0.2);
            border: 1px solid #f6821f;
            color: #f6821f;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .alert-success { background: rgba(16,185,129,0.2); border: 1px solid #10b981; color: #10b981; }
        .alert-error { background: rgba(239,68,68,0.2); border: 1px solid #ef4444; color: #ef4444; }
        
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 32px;
        }
        .chart-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 20px;
        }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .charts-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-snowflake"></i> Polar.id
        </div>
        <div style="font-size: 11px; color: #64748b; margin-top: 8px;">Admin Panel</div>
    </div>
    <div class="sidebar-nav">
        <a href="?action=dashboard" class="nav-item <?= $action === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-chart-line nav-icon"></i> Dashboard
        </a>
        <a href="?action=sessions" class="nav-item <?= $action === 'sessions' ? 'active' : '' ?>">
            <i class="fas fa-robot nav-icon"></i> Sessions
        </a>
        <a href="?action=tokens" class="nav-item <?= $action === 'tokens' ? 'active' : '' ?>">
            <i class="fas fa-ticket-alt nav-icon"></i> Tokens
        </a>
        <a href="?action=reviews" class="nav-item <?= $action === 'reviews' ? 'active' : '' ?>">
            <i class="fas fa-star nav-icon"></i> Reviews
        </a>
        <a href="?action=logs" class="nav-item <?= $action === 'logs' ? 'active' : '' ?>">
            <i class="fas fa-history nav-icon"></i> Activity Logs
        </a>
        <a href="?action=settings" class="nav-item <?= $action === 'settings' ? 'active' : '' ?>">
            <i class="fas fa-cog nav-icon"></i> Settings
        </a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <h1 class="page-title">
            <?php
            switch($action) {
                case 'sessions': echo '<i class="fas fa-robot"></i> Manage Sessions'; break;
                case 'tokens': echo '<i class="fas fa-ticket-alt"></i> Manage Tokens'; break;
                case 'reviews': echo '<i class="fas fa-star"></i> Manage Reviews'; break;
                case 'logs': echo '<i class="fas fa-history"></i> Activity Logs'; break;
                case 'settings': echo '<i class="fas fa-cog"></i> Settings'; break;
                default: echo '<i class="fas fa-chart-line"></i> Dashboard';
            }
            ?>
        </h1>
        <a href="?action=logout" class="logout-btn" onclick="return confirm('Logout?')"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div class="content">
        <?php if ($message): ?>
            <div class="alert alert-success">✅ <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <!-- DASHBOARD -->
        <?php if ($action === 'dashboard'): ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stats['total_sessions']) ?></div>
                <div class="stat-label">Total Sessions</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #10b981;"><?= number_format($stats['online_sessions']) ?></div>
                <div class="stat-label">Online</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #f59e0b;"><?= number_format($stats['pending_sessions']) ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #64748b;"><?= number_format($stats['offline_sessions']) ?></div>
                <div class="stat-label">Offline</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stats['unique_users']) ?></div>
                <div class="stat-label">Unique Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stats['total_tokens']) ?></div>
                <div class="stat-label">Total Tokens</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stats['used_tokens']) ?> / <?= number_format($stats['unused_tokens']) ?></div>
                <div class="stat-label">Used / Unused Tokens</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= number_format($stats['total_reviews']) ?> ⭐ <?= $stats['avg_rating'] ?></div>
                <div class="stat-label">Reviews & Rating</div>
            </div>
        </div>
        
        <div class="charts-row">
            <div class="chart-card">
                <h3 style="margin-bottom: 16px;">Status Session</h3>
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-card">
                <h3 style="margin-bottom: 16px;">Aktivitas Session (7 Hari)</h3>
                <canvas id="activityChart"></canvas>
            </div>
        </div>
        
        <script>
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Online', 'Pending', 'Offline'],
                    datasets: [{
                        data: [<?= $stats['online_sessions'] ?>, <?= $stats['pending_sessions'] ?>, <?= $stats['offline_sessions'] ?>],
                        backgroundColor: ['#10b981', '#f59e0b', '#64748b']
                    }]
                }
            });
            
            // Ambil data 7 hari terakhir (simulasi)
            const last7days = [<?php
                $sessions = getAllSessions();
                $days = array_fill(0, 7, 0);
                foreach ($sessions as $s) {
                    $date = date('Y-m-d', strtotime($s['created_at']));
                    $dayIndex = 6 - floor((time() - strtotime($s['created_at'])) / 86400);
                    if ($dayIndex >= 0 && $dayIndex < 7) $days[$dayIndex]++;
                }
                echo implode(',', $days);
            ?>];
            
            new Chart(document.getElementById('activityChart'), {
                type: 'line',
                data: {
                    labels: ['7 hari lalu', '6 hari', '5 hari', '4 hari', '3 hari', '2 hari', 'Hari ini'],
                    datasets: [{
                        data: last7days,
                        borderColor: '#f6821f',
                        backgroundColor: 'rgba(246,130,31,0.1)',
                        fill: true
                    }]
                }
            });
        </script>
        <?php endif; ?>
        
        <!-- SESSIONS -->
        <?php if ($action === 'sessions'): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>ID</th><th>Phone</th><th>Script</th><th>Status</th><th>Mode</th><th>Created</th><th>Action</th</tr>
                </thead>
                <tbody>
                    <?php $sessions = getAllSessions(); ?>
                    <?php foreach ($sessions as $s): ?>
                    <tr>
                        <td><?= $s['id'] ?></td>
                        <td><?= htmlspecialchars($s['phone']) ?></td>
                        <td><?= htmlspecialchars($s['script']) ?></td>
                        <td>
                            <span class="badge badge-<?= $s['status'] ?>">
                                <?= $s['status'] ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($s['bot_mode'] ?? 'public') ?></td>
                        <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
                        <td>
                            <a href="?action=delete_session&id=<?= $s['id'] ?>" class="btn-delete" onclick="return confirm('Hapus session ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- TOKENS -->
        <?php if ($action === 'tokens'): ?>
        <div style="margin-bottom: 20px;">
            <form method="POST" style="display: inline;">
                <button type="submit" name="generate" class="btn-generate"><i class="fas fa-plus"></i> Generate Token Baru</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>ID</th><th>Code</th><th>Used</th><th>Used By</th><th>Phone</th><th>Created</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php $tokens = getAllTokens(); ?>
                    <?php foreach ($tokens as $t): ?>
                    <tr>
                        <td><?= $t['id'] ?></td>
                        <td><code><?= htmlspecialchars($t['code']) ?></code></td>
                        <td><?= $t['used'] ? '✅ Used' : '🟢 Available' ?></td>
                        <td><?= htmlspecialchars($t['used_by'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($t['phone'] ?? '-') ?></td>
                        <td><?= date('d M Y H:i', $t['created_at'] / 1000) ?></td>
                        <td>
                            <a href="?action=delete_token&id=<?= $t['id'] ?>" class="btn-delete" onclick="return confirm('Hapus token ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- REVIEWS -->
        <?php if ($action === 'reviews'): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>ID</th><th>Rating</th><th>Name</th><th>Comment</th><th>Created</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php $reviews = getAllReviews(); ?>
                    <?php foreach ($reviews as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td>⭐ <?= $r['rating'] ?></td>
                        <td><?= htmlspecialchars($r['name'] ?? 'Anonymous') ?></td>
                        <td><?= htmlspecialchars(substr($r['comment'], 0, 50)) ?>...</td>
                        <td><?= date('d M Y H:i', strtotime($r['created_at'])) ?></td>
                        <td>
                            <a href="?action=delete_review&id=<?= $r['id'] ?>" class="btn-delete" onclick="return confirm('Hapus review ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- LOGS -->
        <?php if ($action === 'logs'): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Log Entry</th></tr>
                </thead>
                <tbody>
                    <?php $logs = getActivityLogs(); ?>
                    <?php foreach ($logs as $log): ?>
                    <tr><td style="font-family: monospace; font-size: 11px;"><?= $log ?></td></tr>
                    <?php endforeach; ?>
                    <?php if (empty($logs)): ?>
                    <tr><td style="text-align: center; padding: 40px;">Belum ada log aktivitas</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <!-- SETTINGS -->
        <?php if ($action === 'settings'): ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?= JADIBOT_EXPIRY_DAYS ?> Hari</div>
                <div class="stat-label">Masa Aktif Session</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= MAX_SESSIONS_PER_FINGERPRINT ?></div>
                <div class="stat-label">Max Session per Device</div>
            </div>
        </div>
        
        <div class="table-container" style="padding: 20px;">
            <h3 style="margin-bottom: 16px;">Konfigurasi Sistem</h3>
            <p><strong>Supabase URL:</strong> <code><?= SUPABASE_URL ?></code></p>
            <p><strong>Script Name:</strong> <code><?= SCRIPT_NAME ?></code></p>
            <p><strong>Main Phone:</strong> <code><?= MAIN_PHONE ?></code></p>
            <p><strong>Prefix:</strong> <code><?= PREFIX ?></code></p>
            <hr style="margin: 16px 0; border-color: #334155;">
            <p><strong>Total Sessions:</strong> <?= $stats['total_sessions'] ?></p>
            <p><strong>Total Users (Fingerprint):</strong> <?= $stats['unique_users'] ?></p>
            <p><strong>Total Tokens Generated:</strong> <?= $stats['total_tokens'] ?></p>
            <p><strong>Token Usage Rate:</strong> <?= $stats['total_tokens'] > 0 ? round(($stats['used_tokens'] / $stats['total_tokens']) * 100, 1) : 0 ?>%</p>
        </div>
        <?php endif; ?>
        
        <!-- LOGOUT -->
        <?php if ($action === 'logout'): ?>
        <?php
        session_destroy();
        header('Location: admin.php');
        exit;
        ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>