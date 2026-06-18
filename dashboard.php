<?php
require_once 'config.php';
// Cek Login (Paksa ke halaman login jika belum)
if (!is_logged_in()) {
    // Untuk preview UI, kita komen dulu. Nanti hilangkan komennya.
    // header("Location: index.php"); 
    // exit();
}

// Simulasi Data User untuk UI (Hapus jika sudah connect API)
$user_name = $_SESSION['user_name'] ?? "Guest User";
$user_avatar = $_SESSION['user_avatar'] ?? "https://ui-avatars.com/api/?name=Guest&background=1dd3b0&color=fff";
$user_coins = $_SESSION['user_coins'] ?? 50;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id | Dashboard Bot</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bg-main: #0f0f13;
            --bg-card: #1c1c24;
            --bg-nav: #15151c;
            --pink: #ff2a5f;
            --pink-hover: #e01b4c;
            --cyan: #1dd3b0;
            --cyan-hover: #15b596;
            --yellow: #ffcc00;
            --text-main: #ffffff;
            --text-muted: #8b8b9b;
            --border: #2a2a35;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background-color: var(--bg-main);
            background-image: radial-gradient(circle at 50% 0%, #2a1b2a 0%, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Top Navbar */
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

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            font-size: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .brand-icon {
            background: var(--pink);
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            transform: skew(-10deg);
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .coin-badge {
            background: rgba(255, 204, 0, 0.1);
            border: 1px solid var(--yellow);
            color: var(--yellow);
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid var(--cyan);
        }

        .menu-btn {
            background: var(--pink);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 40px 20px;
        }

        .slot-badge {
            display: inline-block;
            background: var(--cyan);
            color: #000;
            padding: 4px 15px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 15px;
            transform: skew(-5deg);
        }

        .hero h1 {
            font-size: 36px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 15px;
        }

        .hero h1 span {
            background: var(--yellow);
            color: #000;
            padding: 0 10px;
            display: inline-block;
            transform: skew(-5deg);
        }

        .hero p {
            color: var(--text-muted);
            font-size: 14px;
            max-width: 400px;
            margin: 0 auto 25px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 300px;
            padding: 14px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            cursor: pointer;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-pink { background: var(--pink); color: white; }
        .btn-pink:hover { background: var(--pink-hover); }
        .btn-cyan { background: var(--cyan); color: #000; }
        .btn-cyan:hover { background: var(--cyan-hover); }

        .features-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--cyan);
        }

        /* Server Status Card */
        .status-container {
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .status-card {
            background: var(--bg-card);
            border: 1px solid var(--pink);
            border-radius: 16px;
            padding: 20px;
            position: relative;
        }

        .status-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .status-dots {
            display: flex;
            gap: 6px;
        }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }

        .online-badge {
            background: rgba(29, 211, 176, 0.1);
            color: var(--cyan);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 800;
            border: 1px solid var(--cyan);
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed var(--border);
            font-size: 14px;
        }
        .spec-row:last-child { border: none; }
        .spec-label { color: var(--text-muted); }
        .spec-val { font-weight: 600; color: var(--cyan); }

        /* Modal Claim Server (Packages) */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active { display: flex; }

        .modal-content {
            background: var(--bg-nav);
            width: 100%;
            max-width: 450px;
            border-radius: 16px;
            border: 1px solid var(--pink);
            padding: 25px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: -15px;
            right: -15px;
            background: var(--pink);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .section-title {
            background: var(--yellow);
            color: #000;
            display: inline-block;
            padding: 4px 10px;
            font-weight: 800;
            font-size: 12px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        /* Packages Grid */
        .pkg-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .pkg-card {
            background: var(--bg-card);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
        }

        .pkg-card.active {
            border-color: var(--cyan);
            background: rgba(29, 211, 176, 0.05);
        }

        .pkg-best {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--pink);
            color: white;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 10px;
            white-space: nowrap;
        }

        .pkg-day { font-size: 18px; font-weight: 900; color: white; }
        .pkg-coin { font-size: 13px; color: var(--yellow); font-weight: 600; margin-top: 5px; }

        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; color: var(--text-muted); font-size: 12px; margin-bottom: 8px; }
        .input-group input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 16px;
        }
        .input-group input:focus { outline: none; border-color: var(--cyan); }

    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar">
        <div class="nav-brand">
            <span class="brand-icon">S</span> POLAR.ID
        </div>
        <div class="nav-user">
            <div class="coin-badge">
                <i class="fas fa-coins"></i> <span id="userCoinBalance"><?= $user_coins ?></span>
            </div>
            <div class="user-profile">
                <span style="font-weight: 600; font-size: 14px;" class="hide-mobile"><?= explode(' ', $user_name)[0] ?></span>
                <img src="<?= $user_avatar ?>" alt="Avatar">
            </div>
            <button class="menu-btn"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="slot-badge"><i class="fas fa-circle" style="font-size: 8px;"></i> Server Tersedia</div>
        <h1>Free Bot <br><span>Hosting WhatsApp</span></h1>
        <p>Dapatkan server bot WhatsApp dengan performa terbaik menggunakan sistem koin. Claim sekarang juga!</p>
        
        <div class="btn-group">
            <button class="btn btn-pink" onclick="openModal()"><i class="fas fa-download"></i> Claim Session</button>
            <a href="earn-coin.php" class="btn btn-cyan" style="background: transparent; border: 2px solid var(--cyan); color: var(--cyan);"><i class="fas fa-plus-circle"></i> Tambah Koin</a>
        </div>

        <div class="features-row">
            <span><i class="fas fa-check-circle"></i> Anti Banned</span>
            <span><i class="fas fa-bolt"></i> Setup Instan</span>
        </div>
    </section>

    <!-- STATUS CARD -->
    <section class="status-container">
        <div class="status-card">
            <div class="status-header">
                <div class="status-dots">
                    <div class="dot dot-red"></div>
                    <div class="dot dot-yellow"></div>
                    <div class="dot dot-green"></div>
                </div>
                <div class="online-badge">ONLINE</div>
            </div>
            <div class="spec-row">
                <span class="spec-label">Script Engine</span>
                <span class="spec-val">Phoenix MD / Ourin</span>
            </div>
            <div class="spec-row">
                <span class="spec-label">Total Session Saya</span>
                <span class="spec-val">0 Aktif</span>
            </div>
            <div class="spec-row">
                <span class="spec-label">Sistem</span>
                <span class="spec-val" style="color: var(--yellow);">Bayar Pakai Koin</span>
            </div>
        </div>
    </section>

    <!-- MODAL CLAIM SERVER -->
    <div class="modal" id="claimModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
            
            <div class="section-title">PILIH PAKET JADIBOT</div>
            <div class="pkg-grid">
                <div class="pkg-card" onclick="selectPkg(this, 1, 1)">
                    <div class="pkg-day">1 HARI</div>
                    <div class="pkg-coin"><i class="fas fa-coins"></i> 1 Koin</div>
                </div>
                <div class="pkg-card" onclick="selectPkg(this, 2, 2)">
                    <div class="pkg-day">2 HARI</div>
                    <div class="pkg-coin"><i class="fas fa-coins"></i> 2 Koin</div>
                </div>
                <div class="pkg-card active" onclick="selectPkg(this, 5, 4)">
                    <div class="pkg-best">BEST DEAL!</div>
                    <div class="pkg-day">5 HARI</div>
                    <div class="pkg-coin"><i class="fas fa-coins"></i> 4 Koin</div>
                </div>
                <div class="pkg-card" onclick="selectPkg(this, 14, 10)">
                    <div class="pkg-day">14 HARI</div>
                    <div class="pkg-coin"><i class="fas fa-coins"></i> 10 Koin</div>
                </div>
            </div>

            <div class="section-title" style="margin-top: 10px;">NOMOR WHATSAPP</div>
            <div class="input-group">
                <label>Masukkan nomor WhatsApp yang akan dijadikan bot</label>
                <input type="text" id="phoneInput" placeholder="Contoh: 628123456789" autocomplete="off">
            </div>

            <input type="hidden" id="selectedDays" value="5">
            <input type="hidden" id="selectedCoins" value="4">

            <button class="btn btn-pink" style="width: 100%; max-width: 100%;" onclick="processClaim()">
                <i class="fas fa-rocket"></i> Buat Session Sekarang
            </button>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('claimModal');
        function openModal() { modal.classList.add('active'); }
        function closeModal() { modal.classList.remove('active'); }

        // Package Selection Logic
        function selectPkg(element, days, coins) {
            // Remove active from all
            document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('active'));
            // Add active to clicked
            element.classList.add('active');
            
            // Set hidden values
            document.getElementById('selectedDays').value = days;
            document.getElementById('selectedCoins').value = coins;
        }

        // Process Claim Dummy
        function processClaim() {
            const phone = document.getElementById('phoneInput').value;
            const days = document.getElementById('selectedDays').value;
            const cost = document.getElementById('selectedCoins').value;
            const currentCoins = parseInt(document.getElementById('userCoinBalance').innerText);

            if (!phone || phone.length < 10) {
                alert("Masukkan nomor telepon yang valid!");
                return;
            }

            if (currentCoins < cost) {
                alert("Koin tidak cukup! Silakan tambah koin terlebih dahulu.");
                window.location.href = "earn-coin.php";
                return;
            }

            // Di sini nanti Anda memasukkan logika Fetch API Supabase Anda (seperti createSession sebelumnya)
            // Dengan mengirimkan `active_days: days` dan mengurangi saldo koin.
            
            alert(`Berhasil! Memproses session untuk +${phone} selama ${days} hari. Koin dipotong: ${cost}`);
            closeModal();
        }
    </script>
</body>
</html>
