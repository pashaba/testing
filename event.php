<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Event — Polar.id</title>
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
            --gold: #fbbf24;
            --gold-dark: #f59e0b;
            --gold-light: #fef3c7;
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
            transition: all 0.3s ease;
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            height: 64px;
            background: rgba(var(--bg-rgb), 0.9);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo i {
            font-size: 20px;
            color: var(--primary);
            -webkit-text-fill-color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: var(--gray);
            transition: all 0.15s;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--gray-bg);
        }

        .nav-cta {
            padding: 8px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transition: all 0.2s;
            box-shadow: 0 2px 8px var(--primary-glow);
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gray-bg);
            border: 1px solid var(--border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .theme-toggle:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        /* Page Content */
        .page {
            padding: 100px 24px 80px;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Hero Section */
        .event-hero {
            text-align: center;
            margin-bottom: 56px;
            padding: 52px 32px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .event-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--gold), var(--primary));
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            border: 1px solid var(--gold);
            background: rgba(251, 191, 36, 0.1);
            font-size: 12px;
            font-weight: 600;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .event-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .event-title {
            font-size: clamp(32px, 6vw, 48px);
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .event-title .gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .event-desc {
            color: var(--gray);
            font-size: 15px;
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto 24px;
        }

        .event-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 999px;
            background: var(--success-light);
            border: 1px solid var(--success);
            color: var(--success-dark);
            font-size: 13px;
            font-weight: 600;
        }

        .hashtag-box {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary-light), var(--gold-light));
            border: 1px solid var(--primary);
            border-radius: 40px;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-dark);
            font-family: monospace;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 16px;
        }

        .hashtag-box:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        /* Section Title */
        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .section-sub {
            color: var(--gray);
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* Reward Grid */
        .reward-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }

        .reward-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 16px;
            text-align: center;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .reward-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary);
        }

        .reward-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
        }

        .reward-card.featured {
            border-color: var(--gold);
        }

        .reward-views {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 4px;
        }

        .reward-label {
            font-size: 11px;
            color: var(--gray);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .reward-amount {
            font-size: 24px;
            font-weight: 800;
            color: var(--gold);
        }

        .reward-idr {
            font-size: 11px;
            color: var(--gray);
            margin-top: 4px;
        }

        /* Steps */
        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            transition: all 0.2s;
        }

        .step-item:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .step-num {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            flex-shrink: 0;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.6;
        }

        .step-tag {
            display: inline-block;
            margin-top: 10px;
            padding: 4px 12px;
            background: var(--gray-bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--primary);
            font-weight: 600;
            font-family: monospace;
        }

        .step-tag i {
            margin-right: 4px;
        }

        /* Submit Section */
        .submit-section {
            background: linear-gradient(135deg, var(--primary-light), rgba(251, 191, 36, 0.1));
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px 32px;
            text-align: center;
            margin: 40px 0;
        }

        .submit-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .submit-desc {
            color: var(--gray);
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .btn-submit-wa {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border-radius: 40px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(34, 197, 94, 0.35);
        }

        .btn-submit-wa:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45);
        }

        /* Rules Grid */
        .rules-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 40px;
        }

        .rule-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
        }

        .rule-icon {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .rule-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .rule-desc {
            font-size: 12px;
            color: var(--gray);
            line-height: 1.6;
        }

        /* FAQ */
        .faq-item {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .faq-q {
            padding: 16px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--card);
        }

        .faq-q:hover {
            background: var(--gray-bg);
        }

        .faq-q i {
            transition: transform 0.2s;
        }

        .faq-item.open .faq-q i {
            transform: rotate(180deg);
        }

        .faq-a {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s;
            font-size: 13px;
            color: var(--gray);
            line-height: 1.7;
        }

        .faq-item.open .faq-a {
            padding: 0 20px 16px;
            max-height: 200px;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 22px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 40px;
        }

        footer .copy {
            font-size: 12px;
            color: var(--gray);
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-size: 12px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* CS Float */
        .cs-float {
            position: fixed;
            bottom: 22px;
            right: 22px;
            z-index: 200;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            border-radius: 40px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(34, 197, 94, 0.35);
            transition: all 0.2s;
        }

        .cs-float:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45);
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav {
                padding: 0 20px;
            }
            .page {
                padding: 80px 16px 60px;
            }
            .event-hero {
                padding: 32px 20px;
            }
            .rules-grid {
                grid-template-columns: 1fr;
            }
            .reward-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            footer {
                padding: 18px 20px;
            }
        }

        @media (max-width: 480px) {
            .reward-grid {
                grid-template-columns: 1fr;
            }
            .nav-link {
                display: none;
            }
            .step-item {
                flex-direction: column;
            }
            .step-num {
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo">
        <i class="fas fa-snowflake"></i> Polar.id
    </a>
    <div class="nav-right">
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="features.php" class="nav-link">Fitur</a>
        <a href="https://wa.me/6285715294026" target="_blank" class="nav-link">CS</a>
        <button class="theme-toggle" onclick="toggleTheme()">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
        <a href="dashboard.php" class="nav-cta">
            <i class="fas fa-robot"></i> Dashboard
        </a>
    </div>
</nav>

<div class="page">

    <!-- HERO -->
    <div class="event-hero">
        <div class="event-badge">
            <div class="event-badge-dot"></div>
            Event Aktif
        </div>

        <div class="event-title">
            Share Link & <span class="gold">Dapat Reward!</span>
        </div>

        <p class="event-desc">
            Bagikan link website Polar.id ke media sosial kamu dan dapatkan reward berdasarkan jumlah pengunjung website yang berhasil kamu datangkan. Semakin banyak traffic website yang masuk, semakin besar hadiah yang kamu dapatkan.
        </p>

        <div class="event-status">
            <i class="fas fa-circle" style="font-size: 8px;"></i> Program traffic website sedang berlangsung
        </div>

        <div>
            <div class="hashtag-box" onclick="copyHashtag()" id="hashtagBox">
                <i class="fas fa-hashtag"></i> polaridbot &nbsp; <i class="fas fa-copy"></i>
            </div>
            <div style="font-size: 11px; color: var(--gray); margin-top: 8px;">
                Klik untuk salin hashtag
            </div>
        </div>
    </div>

    <!-- REWARD -->
    <div class="reward-section">
        <div class="section-title">💰 Tabel Reward</div>
        <div class="section-sub">
            Semakin banyak pengunjung website yang kamu hasilkan, semakin besar reward yang didapat
        </div>

        <div class="reward-grid">
            <div class="reward-card">
                <div class="reward-views">500</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$1</div>
                <div class="reward-idr">≈ Rp16.000</div>
            </div>
            <div class="reward-card">
                <div class="reward-views">1.000</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$2</div>
                <div class="reward-idr">≈ Rp32.000</div>
            </div>
            <div class="reward-card">
                <div class="reward-views">5.000</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$10</div>
                <div class="reward-idr">≈ Rp160.000</div>
            </div>
            <div class="reward-card">
                <div class="reward-views">10.000</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$20</div>
                <div class="reward-idr">≈ Rp320.000</div>
            </div>
            <div class="reward-card">
                <div class="reward-views">50.000</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$100</div>
                <div class="reward-idr">≈ Rp1.600.000</div>
            </div>
            <div class="reward-card featured">
                <div class="reward-views" style="color: var(--gold);">100K+</div>
                <div class="reward-label">Website Visits</div>
                <div class="reward-amount">$200+</div>
                <div class="reward-idr">≈ Rp3.200.000+</div>
            </div>
        </div>
    </div>

    <!-- HOW TO -->
    <div class="howto-section">
        <div class="section-title">📋 Cara Ikut Event</div>
        <div class="section-sub">
            Mudah, gratis, dan bisa dilakukan siapa saja
        </div>

        <div class="steps-list">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-content">
                    <div class="step-title">Bagikan website Polar.id</div>
                    <div class="step-desc">
                        Promosikan website Polar.id di TikTok, Instagram, Facebook, YouTube, Telegram, WhatsApp, atau platform lainnya agar orang mengunjungi website melalui link yang kamu bagikan.
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-content">
                    <div class="step-title">Sertakan link website & hashtag</div>
                    <div class="step-desc">
                        Pastikan link website Polar.id dan hashtag resmi event dicantumkan agar traffic kamu bisa diverifikasi.
                    </div>
                    <div>
                        <span class="step-tag"><i class="fas fa-link"></i> polar.web.id</span>
                        <span class="step-tag" style="margin-left: 8px;"><i class="fas fa-hashtag"></i> #polaridbot</span>
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-content">
                    <div class="step-title">Datangkan traffic website</div>
                    <div class="step-desc">
                        Semakin banyak orang membuka website dari link promosi kamu, semakin besar reward yang bisa kamu klaim.
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-num">4</div>
                <div class="step-content">
                    <div class="step-title">Klaim reward ke CS</div>
                    <div class="step-desc">
                        Setelah traffic website mencapai target, kirim bukti statistik atau screenshot jumlah pengunjung website ke CS untuk proses verifikasi dan pencairan reward.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SUBMIT SECTION -->
    <div class="submit-section">
        <div class="submit-title">🎉 Siap Klaim Reward?</div>
        <div class="submit-desc">
            Hubungi Customer Service kami untuk melakukan verifikasi dan klaim reward Anda.
        </div>
        <a href="https://wa.me/6285715294026" target="_blank" class="btn-submit-wa">
            <i class="fab fa-whatsapp"></i> Klaim Sekarang
        </a>
    </div>

    <!-- RULES -->
    <div class="rules-section">
        <div class="section-title">📜 Peraturan & Ketentuan</div>
        <div class="section-sub">
            Baca dengan saksama agar event berjalan lancar
        </div>

        <div class="rules-grid">
            <div class="rule-card">
                <div class="rule-icon">✅</div>
                <div class="rule-title">Traffic Valid</div>
                <div class="rule-desc">Hanya traffic organik yang dihitung. Dilarang menggunakan bot atau layanan generate traffic palsu.</div>
            </div>
            <div class="rule-card">
                <div class="rule-icon">🔄</div>
                <div class="rule-title">Satu Akun</div>
                <div class="rule-desc">Setiap pengguna hanya bisa menggunakan satu akun untuk mengikuti event ini.</div>
            </div>
            <div class="rule-card">
                <div class="rule-icon">📸</div>
                <div class="rule-title">Bukti Screenshot</div>
                <div class="rule-desc">Setiap klaim wajib menyertakan screenshot bukti traffic dari website.</div>
            </div>
            <div class="rule-card">
                <div class="rule-icon">⏰</div>
                <div class="rule-title">Periode Event</div>
                <div class="rule-desc">Event berlangsung dari 1 Juni 2026 hingga 31 Desember 2026.</div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="faq-section">
        <div class="section-title">❓ FAQ</div>

        <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">
                Bagaimana cara melihat jumlah traffic website saya?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-a">
                Kamu bisa menggunakan Google Analytics, Statcounter, atau tools analisis website lainnya untuk memantau jumlah pengunjung website dari link promosi kamu.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">
                Apakah bisa menggunakan link shortener?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-a">
                Tidak disarankan. Sebaiknya gunakan link langsung website Polar.id agar traffic bisa diverifikasi dengan lebih mudah.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">
                Kapan reward akan dicairkan?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-a">
                Reward akan dicairkan maksimal 3x24 jam setelah verifikasi berhasil. Pencairan melalui OVO, DANA, GoPay, atau transfer bank.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-q" onclick="toggleFaq(this)">
                Apakah bisa gabung dengan event lain?
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-a">
                Event ini dapat diikuti bersamaan dengan event atau program afiliasi lainnya.
            </div>
        </div>
    </div>
</div>

<a href="https://wa.me/6285715294026" target="_blank" class="cs-float">
    <i class="fab fa-whatsapp"></i> CS
</a>

<footer>
    <div class="logo" style="font-size: 14px;">
        <i class="fas fa-snowflake"></i> Polar.id
    </div>
    <div class="copy">© 2025 Polar.id</div>
    <a href="https://wa.me/6285715294026">Customer Service</a>
</footer>

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

    // Copy Hashtag
    function copyHashtag() {
        navigator.clipboard.writeText('#polaridbot').then(() => {
            const el = document.getElementById('hashtagBox');
            el.innerHTML = '<i class="fas fa-hashtag"></i> polaridbot &nbsp; <i class="fas fa-check"></i>';
            setTimeout(() => {
                el.innerHTML = '<i class="fas fa-hashtag"></i> polaridbot &nbsp; <i class="fas fa-copy"></i>';
            }, 2000);
        });
    }

    // FAQ Toggle
    function toggleFaq(element) {
        const item = element.closest('.faq-item');
        item.classList.toggle('open');
    }
</script>
</body>
</html>