<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    
    <!-- Primary Meta Tags -->
    <title>Polar.id — Bot WhatsApp Multi Device Gratis | Dashboard Bot WA</title>
    <meta name="title" content="Polar.id — Bot WhatsApp Multi Device Gratis | Dashboard Bot WA" />
    <meta name="description" content="Platform bot WhatsApp multi device gratis. Kelola session bot WA tanpa login, tanpa registrasi. Cepat, mudah, dan support Phoenix MD & Ourin MD." />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Polar.id — Bot WhatsApp Multi Device Gratis">
    <meta property="og:url" content="https://polar.web.id">
    <meta property="og:image" content="https://polar.web.id/og-image.jpg">
    <meta property="og:description" content="Platform bot WhatsApp multi device gratis. Kelola session bot WA tanpa login, tanpa registrasi. Cepat, mudah, dan support Phoenix MD & Ourin MD.">
    <meta property="og:type" content="website">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta property="twitter:title" content="Polar.id — Bot WhatsApp Multi Device Gratis">
    <meta property="twitter:image" content="https://polar.web.id/og-image.jpg">
    <meta property="twitter:description" content="Platform bot WhatsApp multi device gratis. Kelola session bot WA tanpa login, tanpa registrasi. Cepat, mudah, dan support Phoenix MD & Ourin MD.">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1771884647147524" crossorigin="anonymous"></script>
    
    <style>
        /* ===== SHIKYTERO CYBERPUNK THEME STYLE ===== */
        :root {
            --primary: #ff2a5f;       /* Pink/Crimson utama shikytero */
            --primary-dark: #d91b4b;
            --primary-light: rgba(255, 42, 95, 0.15);
            --primary-glow: rgba(255, 42, 95, 0.35);
            
            --mint: #10b981;          /* Hijau mint aksen status */
            --mint-light: rgba(16, 185, 129, 0.15);
            --cyan: #00e1ff;          /* Cyan elektrik */
            
            --success: #00ffaa;
            --success-dark: #059669;
            --success-light: rgba(0, 255, 170, 0.1);
            
            --danger: #ef4444;
            --danger-dark: #dc2626;
            --danger-light: #fee2e2;
            
            --warning: #f59e0b;
            --warning-light: #fed7aa;
            
            --gold: #ffcc00;          /* Kuning koin shikytero */
            --gold-dark: #e0b000;
            --gold-light: rgba(255, 204, 0, 0.1);
            
            /* Background Gelap Total Sesuai Gambar */
            --bg: #090b11; 
            --card: #121622; 
            --border: #1e2538;
            --border-light: #161c2b;
            --gray-bg: #161c2b;
            
            --dark: #ffffff;
            --dark-2: #f1f5f9;
            --dark-3: #cbd5e1;
            --gray: #94a3b8;
            --gray-light: #64748b;
            
            --radius-sm: 10px;
            --radius: 18px;
            --radius-lg: 26px;
            --radius-xl: 36px;
            
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.5);
            --shadow: 0 8px 16px rgba(0,0,0,0.6);
            --shadow-lg: 0 16px 24px rgba(0,0,0,0.7);
            --shadow-xl: 0 24px 48px rgba(0,0,0,0.8);
            
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--dark);
            transition: var(--transition);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-dark); }

        /* ===== PROGRESS BAR ===== */
        .progress-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 3px; z-index: 1000;
            background: transparent;
        }
        .progress-bar {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--cyan), var(--primary));
            background-size: 200% 100%;
            transition: width 0.15s ease;
            animation: shimmer 2s linear infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ===== SPLASH SCREEN ===== */
        #splash {
            position: fixed; inset: 0; z-index: 9999;
            background: var(--bg);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 20px;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #splash.hide { opacity: 0; visibility: hidden; pointer-events: none; }
        
        .splash-icon {
            width: 64px; height: 64px;
            background: var(--primary);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px;
            box-shadow: 0 8px 30px var(--primary-glow);
            animation: pulse 2s ease-in-out infinite;
        }
        .splash-name {
            font-size: 28px; font-weight: 800; color: #ffffff;
        }
        .splash-bar {
            width: 120px; height: 4px;
            background: var(--border);
            border-radius: 999px;
            overflow: hidden;
        }
        .splash-fill {
            height: 100%; width: 0%;
            background: var(--primary);
            border-radius: 999px;
            animation: fillBar 1s 0.8s ease forwards;
        }
        @keyframes fillBar { to { width: 100%; } }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 8px 30px var(--primary-glow); }
            50% { transform: scale(1.05); box-shadow: 0 8px 50px var(--primary-glow); }
        }

        /* ===== NAVBAR SPERTI DI GAMBAR ===== */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: #090b11;
            border-bottom: 1px solid var(--border);
            padding: 0 clamp(16px, 4vw, 32px);
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
            font-weight: 900;
            box-shadow: 0 4px 12px var(--primary-glow);
        }
        .nav-logo-text {
            font-size: 22px; font-weight: 900;
            color: #ffffff; letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .nav-logo-text span {
            color: var(--primary);
        }
        .nav-links {
            display: flex; align-items: center; gap: 12px;
        }
        .nav-link {
            padding: 8px 12px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600;
            text-decoration: none; color: var(--gray);
            transition: var(--transition);
        }
        .nav-link:hover { color: #ffffff; }
        
        /* Coin Badge Style Shikytero */
        .coin-badge {
            background: #1c1a17;
            border: 1px solid #dcb028;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            color: #ffcc00;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #161c2b;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
        }
        .user-avatar {
            width: 24px; height: 24px;
            background: #00e1ff;
            color: #000;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 11px;
        }
        
        .menu-toggle {
            background: var(--primary);
            border: none; border-radius: 8px;
            width: 38px; height: 38px;
            font-size: 18px; cursor: pointer;
            color: white;
            display: flex; align-items: center; justify-content: center;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            padding: clamp(50px, 8vw, 100px) clamp(16px, 4vw, 32px);
            text-align: center;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at center, rgba(255,42,95,0.06) 0%, var(--bg) 80%);
        }
        
        /* Slot Tersedia Badge */
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 16px; border-radius: 20px;
            background: #052e21;
            border: 1px solid #10b981;
            font-size: 12px; font-weight: 800;
            color: #10b981;
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .hero-badge-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }
        
        .hero h1 {
            font-size: clamp(38px, 6vw, 64px);
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .hero h1 .highlight {
            background: #ffcc00;
            color: #000000;
            padding: 2px 14px;
            border-radius: 6px;
            display: inline-block;
            transform: rotate(-1deg);
        }
        
        .hero-subtitle {
            font-size: clamp(16px, 2vw, 20px);
            font-weight: 500;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto 36px;
            line-height: 1.6;
        }
        
        .hero-btns {
            display: flex; flex-direction: column; gap: 14px;
            align-items: center; justify-content: center;
            margin-bottom: 40px;
        }
        .btn {
            width: 100%; max-width: 320px;
            padding: 16px 32px; border-radius: 12px;
            font-size: 16px; font-weight: 800;
            border: none; cursor: pointer;
            text-decoration: none; display: inline-flex;
            align-items: center; justify-content: center; gap: 10px;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 20px var(--primary-glow);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 28px var(--primary-glow);
        }
        .btn-outline {
            background: #00bfff;
            color: #000000;
        }
        .btn-outline:hover {
            background: #0099cc;
            transform: translateY(-2px);
        }

        /* Trust Badges Shikytero Style */
        .trust-badges {
            display: flex; justify-content: center;
            gap: 20px; flex-wrap: wrap;
            margin-top: 30px;
        }
        .trust-item {
            display: flex; align-items: center; gap: 8px;
            font-size: 14px; color: #ffffff; font-weight: 700;
        }
        .trust-item.gratis i { color: #10b981; font-size: 18px; }
        .trust-item.instan i { color: #00e1ff; font-size: 18px; }
        .trust-item.pro i { color: #ffcc00; font-size: 18px; }

        /* ===== MOCK DASHBOARD (Sperti Di Gambar) ===== */
        .mock-dashboard {
            margin-top: 48px;
            max-width: 450px; margin-left: auto; margin-right: auto;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            border: 2px solid var(--primary);
            background: #111420;
            text-align: left;
        }
        .mock-header {
            display: flex; align-items: center; gap: 8px;
            padding: 14px 18px;
            background: #0a0d16;
            border-bottom: 1px solid var(--border);
        }
        .mock-dot { width: 10px; height: 10px; border-radius: 50%; }
        .mock-dot:nth-child(1) { background: #ff5f57; }
        .mock-dot:nth-child(2) { background: #febc2e; }
        .mock-dot:nth-child(3) { background: #10b981; }
        
        .mock-badge-right {
            margin-left: auto;
            background: #052e21;
            color: #10b981;
            font-size: 11px; font-weight: 800;
            padding: 4px 12px; border-radius: 6px;
            text-transform: uppercase;
        }
        .mock-body { padding: 20px; }
        .mock-label {
            font-size: 13px; color: #64748b;
            text-transform: uppercase; font-weight: 700;
            margin-bottom: 4px; display: block;
        }
        .mock-value {
            font-size: 18px; font-weight: 700; color: #00e1ff;
            font-family: monospace; margin-bottom: 16px;
        }
        .mock-divider {
            border-top: 1px dashed var(--border);
            margin: 14px 0;
        }

        /* ===== STATS STRIP ===== */
        .stats-strip {
            display: grid; grid-template-columns: repeat(2, 1fr);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: #0b0e17;
        }
        .strip-item {
            padding: 24px 16px;
            text-align: center;
            border-right: 1px solid var(--border);
        }
        .strip-item:nth-child(2n) { border-right: none; }
        .strip-number {
            font-size: 28px;
            font-weight: 900; color: #ffffff;
            margin-bottom: 2px;
        }
        .strip-label {
            font-size: 12px; color: var(--gray);
            font-weight: 600; text-transform: uppercase;
        }

        /* ===== JELAJAHI SECTIONS & CARDS SPERTI DI GAMBAR ===== */
        .section {
            padding: 60px 16px;
            max-width: 1100px; margin: 0 auto;
        }
        .section-title {
            font-size: 32px;
            font-weight: 900; letter-spacing: -0.5px;
            text-align: center; margin-bottom: 8px;
            text-transform: uppercase; color: #ffffff;
        }
        .section-desc {
            color: var(--gray); font-size: 14px;
            margin-bottom: 36px; text-align: center; font-weight: 500;
        }

        /* Cards Layout Baru (Shikytero Border Concept) */
        .features-grid {
            display: flex; flex-direction: column; gap: 20px;
        }
        .feature-card {
            background: #111420;
            border-radius: var(--radius);
            padding: 28px 24px;
            position: relative;
            border: 2px solid transparent;
            transition: var(--transition);
        }
        
        /* Pewarnaan Border Custom Per Item Sesuai Gambar 2 */
        .feature-card.card-mint { border-color: #10b981; }
        .feature-card.card-pink { border-color: #ff2a5f; }
        .feature-card.card-gold { border-color: #ffcc00; }
        .feature-card.card-cyan { border-color: #00e1ff; }

        .feature-icon-box {
            width: 54px; height: 54px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 20px;
            color: white;
        }
        .card-mint .feature-icon-box { background: #10b981; }
        .card-pink .feature-icon-box { background: #ff2a5f; }
        .card-gold .feature-icon-box { background: #ffcc00; color: #000; }
        .card-cyan .feature-icon-box { background: #00e1ff; color: #000; }

        .feature-name {
            font-size: 22px; font-weight: 800; margin-bottom: 6px;
            text-transform: uppercase; color: #ffffff;
            letter-spacing: -0.5px;
        }
        .feature-desc {
            font-size: 14px; color: var(--gray);
            line-height: 1.5; margin-bottom: 18px;
        }
        .feature-action-link {
            font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .card-mint .feature-action-link { color: #10b981; }
        .card-pink .feature-action-link { color: #ff2a5f; }
        .card-gold .feature-action-link { color: #ffcc00; }
        .card-cyan .feature-action-link { color: #00e1ff; }

        /* ===== TESTIMONIALS & REVIEWS (DARK) ===== */
        .testimonials-section {
            background: #0b0e17;
            padding: 48px 16px; margin: 20px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .testi-grid {
            display: flex; flex-direction: column; gap: 16px; margin-top: 24px;
        }
        .testi-card {
            background: var(--card); border-radius: var(--radius-sm);
            padding: 20px; border: 1px solid var(--border);
        }
        .testi-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--primary); display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 10px; color: white;
        }
        .testi-rating { color: var(--gold); font-size: 12px; margin-bottom: 6px; }
        .testi-text { font-size: 13px; color: var(--dark-3); font-style: italic; margin-bottom: 8px; }
        .testi-name { font-size: 13px; font-weight: 700; color: var(--primary); }

        /* ===== RATE & COMMENT ===== */
        .rate-section {
            background: #111420; border-radius: var(--radius);
            padding: 28px 20px; text-align: center;
            border: 1px solid var(--border); margin: 20px 16px;
        }
        .star-rating { display: flex; justify-content: center; gap: 8px; margin: 16px 0; }
        .star-rating i { font-size: 28px; cursor: pointer; color: var(--gray-light); }
        .star-rating i.active { color: var(--gold); }
        .comment-input {
            width: 100%; padding: 14px; border: 1px solid var(--border);
            border-radius: 10px; background: var(--bg); color: #fff;
            font-family: inherit; font-size: 14px; margin-bottom: 12px;
        }
        .reviews-list { margin-top: 24px; max-height: 250px; overflow-y: auto; text-align: left; }
        .review-item { background: var(--bg); border-radius: 8px; padding: 12px; margin-bottom: 10px; border: 1px solid var(--border); }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .review-name { font-weight: 700; font-size: 13px; color: #fff; }
        .review-stars { color: var(--gold); font-size: 11px; }
        .review-text { font-size: 13px; color: var(--gray); }

        /* ===== FAQ ===== */
        .faq-grid { display: flex; flex-direction: column; gap: 10px; }
        .faq-item { background: #111420; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .faq-question { padding: 16px; font-size: 15px; font-weight: 700; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .faq-question i { transition: transform 0.2s; }
        .faq-item.open .faq-question i { transform: rotate(180deg); color: var(--primary); }
        .faq-answer { padding: 0 16px; max-height: 0; overflow: hidden; transition: all 0.25s ease; font-size: 13px; color: var(--gray); line-height: 1.6; }
        .faq-item.open .faq-answer { padding: 0 16px 16px; max-height: 200px; }

        /* ===== CTA ===== */
        .cta-wrapper { padding: 40px 16px; }
        .cta-box {
            background: linear-gradient(135deg, #1a1520, #111420);
            border: 2px solid var(--primary); border-radius: var(--radius);
            padding: 40px 20px; text-align: center;
        }
        .cta-box h2 { font-size: 28px; font-weight: 900; margin-bottom: 10px; }
        .cta-box p { color: var(--gray); font-size: 14px; margin-bottom: 24px; }

        /* ===== BACK TO TOP ===== */
        .back-to-top {
            position: fixed; bottom: 24px; left: 24px; width: 44px; height: 44px; border-radius: 50%;
            background: var(--primary); color: white; border: none; cursor: pointer;
            box-shadow: 0 4px 12px var(--primary-glow); display: flex; align-items: center; justify-content: center;
            font-size: 16px; opacity: 0; visibility: hidden; transition: var(--transition); z-index: 150;
        }
        .back-to-top.show { opacity: 1; visibility: visible; }

        /* ===== FOOTER ===== */
        footer { border-top: 1px solid var(--border); padding: 40px 16px 24px; background: #06080d; }
        .footer-content { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .footer-col h4 { font-size: 14px; font-weight: 800; margin-bottom: 12px; text-transform: uppercase; color: #fff; }
        .footer-col a { display: block; color: var(--gray); text-decoration: none; font-size: 13px; margin-bottom: 8px; }
        .footer-bottom { text-align: center; padding-top: 20px; margin-top: 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--gray-light); }

        /* ===== RESPONSIVE LAPTOP / TABLET ===== */
        @media (min-width: 768px) {
            .hero-btns { flex-direction: row; }
            .stats-strip { grid-template-columns: repeat(4, 1fr); }
            .strip-item { border-right: 1px solid var(--border) !important; }
            .strip-item:last-child { border-right: none !important; }
            .features-grid { grid-template-columns: repeat(2, 1fr); display: grid; }
            .testi-grid { grid-template-columns: repeat(3, 1fr); display: grid; }
            .footer-content { grid-template-columns: repeat(4, 1fr); }
        }
    </style>
</head>
<body>

<?php
require_once 'config.php';

// Ambil jumlah session aktif dari Supabase
$sessions = supabase('GET', 'polar_sessions?select=count&status=eq.online');
$activeSessions = $sessions[0]['count'] ?? 0;

// Ambil jumlah user unik
$users = supabase('GET', 'polar_sessions?select=fingerprint');
$uniqueFingerprints = [];
foreach ($users as $u) {
    if ($u['fingerprint']) $uniqueFingerprints[$u['fingerprint']] = true;
}
$totalUsers = count($uniqueFingerprints);

// Ambil reviews
$reviews = supabase('GET', 'reviews?order=created_at.desc&limit=10');
$totalReviews = count($reviews);
$avgRating = 0;
$ratingSum = 0;
foreach ($reviews as $r) {
    $ratingSum += $r['rating'];
}
if ($totalReviews > 0) $avgRating = round($ratingSum / $totalReviews, 1);
?>

<!-- ===== PROGRESS BAR ===== -->
<div class="progress-container"><div class="progress-bar" id="progressBar"></div></div>

<!-- ===== SPLASH SCREEN ===== -->
<div id="splash">
    <div class="splash-icon">❄️</div>
    <div class="splash-name">Polar.id</div>
    <div class="splash-bar"><div class="splash-fill"></div></div>
</div>

<!-- ===== NAVBAR (SHIKYTERO PLATFORM STYLE) ===== -->
<nav class="navbar" id="navbar">
    <a href="index.php" class="nav-logo">
        <div class="nav-logo-icon">S</div>
        <div class="nav-logo-text">POLAR<span>.ID</span></div>
    </a>
    <div class="nav-links">
        <div class="coin-badge">
            <i class="fas fa-coins"></i> 50
        </div>
        <div class="user-profile">
            <div class="user-avatar">K</div>
            <span>Kimtha</span>
        </div>
        <button class="menu-toggle" onclick="toggleMobileMenu()" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero" id="home">
    <div class="hero-content">
        <div class="hero-badge">
            <div class="hero-badge-dot"></div>
            2 Slot Tersedia
        </div>
        
        <h1>Free Bot <span class="highlight">Server</span> Hosting</h1>
        
        <p class="hero-subtitle">
            Dapatkan server bot gratis dengan spesifikasi terbaik. Claim sekarang sebelum slot habis!
        </p>
        
        <div class="hero-btns">
            <a href="dashboard.php" class="btn btn-primary">
                <i class="fas fa-download"></i> Claim Sekarang
            </a>
            <a href="features.php" class="btn btn-outline">
                Lihat Specs <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <!-- Trust Badges -->
        <div class="trust-badges">
            <div class="trust-item gratis"><i class="fas fa-check-circle"></i> 100% Gratis</div>
            <div class="trust-item instan"><i class="fas fa-bolt"></i> Setup Instan</div>
            <div class="trust-item pro"><i class="fas fa-star"></i> PRO Available</div>
        </div>
        
        <!-- Mock Dashboard Specs Window -->
        <div class="mock-dashboard" data-aos="fade-up">
            <div class="mock-header">
                <div class="mock-dot"></div>
                <div class="mock-dot"></div>
                <div class="mock-dot"></div>
                <div class="mock-badge-right">Online</div>
            </div>
            <div class="mock-body">
                <div class="mock-label">RAM</div>
                <div class="mock-value">Unlimited</div>
                
                <div class="mock-label">CPU Cores</div>
                <div class="mock-value">High Performance</div>
                
                <div class="mock-divider"></div>
                
                <div class="mock-label">Active Session ID</div>
                <div class="mock-value" style="color: #ff2a5f;">+6281234567890</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS STRIP ===== -->
<div class="stats-strip">
    <div class="strip-item">
        <div class="strip-number" id="liveSessions"><?= number_format($activeSessions) ?></div>
        <div class="strip-label">Session Aktif</div>
    </div>
    <div class="strip-item">
        <div class="strip-number"><?= number_format($totalUsers) ?>+</div>
        <div class="strip-label">Pengguna</div>
    </div>
    <div class="strip-item">
        <div class="strip-number">100%</div>
        <div class="strip-label">Gratis</div>
    </div>
    <div class="strip-item">
        <div class="strip-number">24/7</div>
        <div class="strip-label">Uptime</div>
    </div>
</div>

<!-- ===== JELAJAHI MENU SECTIONS ===== -->
<section class="section" id="features">
    <div class="section-title">Jelajahi</div>
    <div class="section-desc">Pilih menu yang kamu butuhkan</div>
    
    <div class="features-grid">
        <div class="feature-card card-mint" data-aos="fade-up">
            <div class="feature-icon-box"><i class="fas fa-heartbeat"></i></div>
            <div class="feature-name">Server Status</div>
            <div class="feature-desc">Monitoring real-time keadaan load server bot WhatsApp secara live.</div>
            <a href="dashboard.php" class="feature-action-link">Cek Status <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="feature-card card-pink" data-aos="fade-up">
            <div class="feature-icon-box"><i class="fas fa-download"></i></div>
            <div class="feature-name">Claim Server</div>
            <div class="feature-desc">Dapatkan slot session bot WhatsApp multi-device gratis secara instan.</div>
            <a href="dashboard.php" class="feature-action-link">Claim Sekarang <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="feature-card card-gold" data-aos="fade-up">
            <div class="feature-icon-box"><i class="fas fa-key"></i></div>
            <div class="feature-name">Get Token</div>
            <div class="feature-desc">Generate token aktivasi harian untuk memperpanjang session bot gratisanmu.</div>
            <a href="token.php" class="feature-action-link">Ambil Token <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <div class="feature-card card-cyan" data-aos="fade-up">
            <div class="feature-icon-box"><i class="fas fa-headset"></i></div>
            <div class="feature-name">Customer Service</div>
            <div class="feature-desc">Butuh bantuan teknis atau ingin upgrade slot limit? Hubungi CS kami.</div>
            <a href="https://wa.me/<?= CS_NUMBER ?>" target="_blank" class="feature-action-link">Hubungi CS <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonials-section" data-aos="fade-up">
    <div class="section-title">Apa Kata Mereka?</div>
    <div class="section-desc">Ribuan pengguna aktif telah mempercayakan bot mereka di platform kami.</div>
    
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★★</div>
            <div class="testi-text">"Mudah banget pakenya, tinggal klik langsung jadi. Bot langsung online tanpa ribet. Recommended!"</div>
            <div class="testi-name">— Andi Setiawan</div>
        </div>
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★★</div>
            <div class="testi-text">"Pairing cepat, bot langsung online. Dashboardnya simpel dan mudah dipahami."</div>
            <div class="testi-name">— Budi Santoso</div>
        </div>
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★★</div>
            <div class="testi-text">"Sangat membantu untuk yang butuh bot WA cepat. Gratis tanpa daftar."</div>
            <div class="testi-name">— Citra Dewi</div>
        </div>
    </div>
</section>

<!-- ===== RATE & COMMENT ===== -->
<section class="rate-section" data-aos="fade-up">
    <div class="section-title">Rate & Comment</div>
    <div class="section-desc">Bagikan pengalamanmu menggunakan platform kami</div>
    
    <div class="star-rating" id="starRating">
        <i class="far fa-star" data-rating="1"></i>
        <i class="far fa-star" data-rating="2"></i>
        <i class="far fa-star" data-rating="3"></i>
        <i class="far fa-star" data-rating="4"></i>
        <i class="far fa-star" data-rating="5"></i>
    </div>
    <input type="text" class="comment-input" id="reviewName" placeholder="Nama kamu (opsional)">
    <textarea class="comment-input" id="reviewComment" rows="3" placeholder="Tulis komentar atau saran..."></textarea>
    <button class="btn btn-primary" onclick="submitReview()">
        Kirim Review
    </button>
    
    <div class="reviews-list" id="reviewsList">
        <?php foreach ($reviews as $r): ?>
        <div class="review-item">
            <div class="review-header">
                <span class="review-name"><?= htmlspecialchars($r['name'] ?? 'Anonymous') ?></span>
                <span class="review-stars"><?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?></span>
            </div>
            <div class="review-text"><?= htmlspecialchars($r['comment']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section" data-aos="fade-up">
    <div class="section-title">Pertanyaan Umum</div>
    <div class="section-desc">Jawaban dari pertanyaan yang sering ditanyakan</div>
    
    <div class="faq-grid">
        <div class="faq-item">
            <div class="faq-question"><span>❓ Apa itu Polar.id?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Platform pengelolaan session hosting bot WhatsApp multi-device gratis tanpa ribet registrasi.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🔗 Bagaimana cara pairing bot?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Buka dashboard -> request pairing code -> buka perangkat tertaut di WhatsApp smartphone kamu -> input kodenya.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🛡️ Apakah aman?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Ya, data terenkripsi lokal di browser session ID kamu masing-masing.</div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<div class="cta-wrapper" data-aos="fade-up">
    <div class="cta-box">
        <h2>Siap punya bot WA sendiri?</h2>
        <p>Gratis. Tanpa daftar. Langsung pakai. Buka dashboard dan aktifkan bot kamu sekarang.</p>
        <a href="dashboard.php" class="btn btn-primary">Buka Dashboard</a>
    </div>
</div>

<!-- ===== BACK TO TOP ===== -->
<button class="back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ===== FOOTER ===== -->
<footer>
    <div class="footer-content">
        <div class="footer-col">
            <h4>Polar.id</h4>
            <p style="font-size: 13px; color: var(--gray);">Platform server hosting bot WhatsApp multi-device berkecepatan tinggi.</p>
        </div>
        <div class="footer-col">
            <h4>Menu</h4>
            <a href="index.php">Beranda</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
        <div class="footer-col">
            <h4>Lainnya</h4>
            <a href="token.php">Ambil Token</a>
            <a href="https://polar.web.id/otp-web.html">Beli Nokos</a>
        </div>
        <div class="footer-col">
            <h4>Socials</h4>
            <a href="#">Instagram</a>
            <a href="#">TikTok</a>
        </div>
    </div>
    <div class="footer-bottom">
        © <?= date('Y') ?> Polar.id. All rights reserved.
    </div>
</footer>

<!-- ===== JAVASCRIPT ===== -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Load saved theme (force dark mode sesuai gambar)
    document.documentElement.setAttribute('data-theme', 'dark');

    // SCROLL PROGRESS BAR
    (function initProgressBar() {
        const bar = document.getElementById('progressBar');
        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            const scrollTop = document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const progress = height ? (scrollTop / height) * 100 : 0;
            bar.style.width = progress + '%';
            backBtn.classList.toggle('show', scrollTop > 300);
        });
    })();

    // FAQ ACCORDION
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => q.closest('.faq-item').classList.toggle('open'));
    });

    // STAR RATING
    let selectedRating = 0;
    document.querySelectorAll('#starRating i').forEach(star => {
        const updateStars = (rating) => {
            document.querySelectorAll('#starRating i').forEach(s => {
                const r = parseInt(s.dataset.rating);
                s.className = r <= rating ? 'fas fa-star active' : 'far fa-star';
            });
        };
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            updateStars(selectedRating);
        });
    });

    // SUBMIT REVIEW
    async function submitReview() {
        const rating = selectedRating;
        const name = document.getElementById('reviewName').value.trim();
        const comment = document.getElementById('reviewComment').value.trim();
        if (rating === 0) { alert('Pilih rating bintang!'); return; }
        if (!comment) { alert('Tulis komentar!'); return; }
        
        try {
            const res = await fetch('api/submit-review.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ rating, name: name || 'Anonymous', comment })
            });
            const data = await res.json();
            alert(data.success ? '✅ Review dikirim!' : '❌ Gagal');
            if (data.success) location.reload();
        } catch(e) { alert('❌ Error'); }
    }

    // SPLASH SCREEN
    window.addEventListener('load', () => {
        setTimeout(() => document.getElementById('splash')?.classList.add('hide'), 1200);
    });

    // AOS INIT
    AOS.init({ duration: 600, once: true });
</script>
</body>
</html>
