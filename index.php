<!DOCTYPE html>
<html lang="id">
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
    <meta name="twitter:image" content="https://polar.web.id/og-image.jpg">
    <meta property="twitter:description" content="Platform bot WhatsApp multi device gratis. Kelola session bot WA tanpa login, tanpa registrasi. Cepat, mudah, dan support Phoenix MD & Ourin MD.">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1771884647147524" crossorigin="anonymous"></script>
    
    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary: #f6821f;
            --primary-dark: #e07010;
            --primary-light: #fff4eb;
            --primary-glow: rgba(246, 130, 31, 0.25);
            
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
            
            --bg: #fafbfc;
            --card: #ffffff;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --bg: #0f172a;
            --card: #1e293b;
            --border: #334155;
            --border-light: #1e293b;
            --gray-bg: #1e293b;
            --dark: #f1f5f9;
            --dark-2: #e2e8f0;
            --dark-3: #cbd5e1;
            --gray: #94a3b8;
            --gray-light: #64748b;
        }

        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--dark);
            transition: var(--transition);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-bg); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-dark); }

        /* ===== PROGRESS BAR ===== */
        .progress-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 3px; z-index: 1000;
            background: transparent;
        }
        .progress-bar {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--gold), var(--primary));
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
            background: var(--card);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 20px;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        #splash.hide { opacity: 0; visibility: hidden; pointer-events: none; }
        
        .splash-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px;
            box-shadow: 0 8px 30px var(--primary-glow);
            animation: pulse 2s ease-in-out infinite;
        }
        .splash-name {
            font-size: 28px; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .splash-bar {
            width: 120px; height: 4px;
            background: var(--border);
            border-radius: 999px;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 0.4s 0.6s ease forwards;
        }
        .splash-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--gold));
            border-radius: 999px;
            animation: fillBar 1s 0.8s ease forwards;
        }
        @keyframes fillBar { to { width: 100%; } }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 8px 30px var(--primary-glow); }
            50% { transform: scale(1.05); box-shadow: 0 8px 50px var(--primary-glow); }
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(var(--card-rgb, 255,255,255), 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 clamp(16px, 4vw, 48px);
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }
        [data-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.85);
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            box-shadow: 0 2px 10px var(--primary-glow);
        }
        .nav-logo-text {
            font-size: 18px; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .nav-links {
            display: flex; align-items: center; gap: 6px;
        }
        .nav-link {
            padding: 8px 14px; border-radius: var(--radius-sm);
            font-size: 13px; font-weight: 500;
            text-decoration: none; color: var(--gray);
            transition: var(--transition);
            position: relative;
        }
        .nav-link::after {
            content: ''; position: absolute; bottom: 2px; left: 50%;
            width: 0; height: 2px; background: var(--primary);
            transition: var(--transition); transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 60%; }
        .nav-link:hover { color: var(--primary); }
        
        .theme-toggle {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--gray-bg);
            border: 1px solid var(--border);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
            font-size: 16px;
            color: var(--dark-3);
        }
        .theme-toggle:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }
        .nav-cta {
            padding: 9px 22px;
            border-radius: var(--radius-sm);
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transition: var(--transition);
            box-shadow: 0 2px 12px var(--primary-glow);
        }
        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px var(--primary-glow);
        }
        .menu-toggle {
            display: none;
            background: none; border: none;
            font-size: 22px; cursor: pointer;
            color: var(--dark-3);
            padding: 8px;
        }

        /* ===== HERO ===== */
        .hero {
            padding: clamp(60px, 10vw, 120px) clamp(16px, 4vw, 48px);
            text-align: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, var(--primary-light) 0%, var(--bg) 70%);
        }
        .hero::before {
            content: ''; position: absolute;
            top: -30%; left: -20%; width: 80%; height: 80%;
            background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
            pointer-events: none;
            opacity: 0.3;
        }
        .hero::after {
            content: ''; position: absolute;
            bottom: -20%; right: -10%; width: 60%; height: 60%;
            background: radial-gradient(circle, rgba(251,191,36,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-content { position: relative; z-index: 1; }
        
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 18px; border-radius: 40px;
            border: 1px solid var(--primary);
            background: var(--card);
            font-size: 12px; font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }
        .hero-badge-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--primary);
            animation: pulse 2s infinite;
        }
        
        .hero h1 {
            font-size: clamp(40px, 7vw, 72px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 16px;
        }
        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--primary), var(--gold));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            font-size: clamp(18px, 2.5vw, 28px);
            font-weight: 600;
            color: var(--dark-3);
            margin-bottom: 16px;
            min-height: 50px;
        }
        .hero-subtitle .typing {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-subtitle .cursor {
            display: inline-block; width: 3px; height: 0.9em;
            background: var(--primary);
            margin-left: 2px;
            animation: blink 1s step-end infinite;
        }
        @keyframes blink { 50% { opacity: 0; } }
        
        .hero-desc {
            font-size: clamp(15px, 1.2vw, 18px);
            color: var(--gray);
            max-width: 540px;
            margin: 0 auto 32px;
            line-height: 1.8;
        }
        .hero-btns {
            display: flex; gap: 14px;
            justify-content: center; flex-wrap: wrap;
        }
        .btn {
            padding: 12px 28px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 600;
            border: none; cursor: pointer;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 8px;
            transition: var(--transition);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 12px var(--primary-glow);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px var(--primary-glow);
        }
        .btn-outline {
            background: var(--card);
            color: var(--dark-3);
            border: 1px solid var(--border);
        }
        .btn-outline:hover {
            background: var(--gray-bg);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ===== TRUST BADGES ===== */
        .trust-badges {
            display: flex; justify-content: center;
            gap: 40px; flex-wrap: wrap;
            margin-top: 40px;
            padding: 20px 30px;
            background: var(--card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .trust-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: var(--gray);
        }
        .trust-item i { font-size: 20px; color: var(--primary); }

        /* ===== MOCK DASHBOARD ===== */
        .mock-dashboard {
            margin-top: 56px;
            max-width: 760px; margin-left: auto; margin-right: auto;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border);
            background: var(--card);
            transition: var(--transition);
        }
        .mock-dashboard:hover { transform: translateY(-4px); box-shadow: 0 24px 48px rgba(0,0,0,0.1); }
        .mock-header {
            display: flex; align-items: center; gap: 8px;
            padding: 12px 16px;
            background: var(--gray-bg);
            border-bottom: 1px solid var(--border);
        }
        .mock-dot {
            width: 10px; height: 10px; border-radius: 50%;
        }
        .mock-dot:nth-child(1) { background: #ff5f57; }
        .mock-dot:nth-child(2) { background: #febc2e; }
        .mock-dot:nth-child(3) { background: #28c840; }
        .mock-url {
            margin-left: 10px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 4px 14px;
            font-size: 12px;
            color: var(--gray-light);
            font-family: monospace;
            flex: 1;
            text-align: left;
        }
        .mock-body { padding: 20px; display: grid; grid-template-columns: 140px 1fr; gap: 16px; }
        .mock-sidebar {
            display: flex; flex-direction: column; gap: 4px;
        }
        .mock-nav {
            padding: 8px 12px; border-radius: var(--radius-sm);
            font-size: 12px; color: var(--gray);
            display: flex; align-items: center; gap: 8px;
        }
        .mock-nav.active {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 600;
        }
        .mock-nav-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: currentColor;
        }
        .mock-stats {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 10px; margin-bottom: 12px;
        }
        .mock-stat {
            background: var(--gray-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 10px;
        }
        .mock-stat-label {
            font-size: 9px; color: var(--gray-light);
            text-transform: uppercase; font-weight: 600;
        }
        .mock-stat-value {
            font-size: 18px; font-weight: 700; color: var(--dark);
        }
        .mock-card-item {
            background: var(--gray-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .mock-phone { font-size: 12px; font-weight: 600; }
        .mock-online {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; color: var(--success-dark);
            background: var(--success-light);
            padding: 3px 10px; border-radius: 30px;
            font-weight: 600;
        }

        /* ===== STATS STRIP ===== */
        .stats-strip {
            display: grid; grid-template-columns: repeat(4, 1fr);
            border-bottom: 1px solid var(--border);
            background: var(--card);
        }
        .strip-item {
            padding: clamp(28px, 3vw, 40px) clamp(16px, 3vw, 32px);
            text-align: center;
            border-right: 1px solid var(--border);
            transition: var(--transition);
        }
        .strip-item:last-child { border-right: none; }
        .strip-item:hover { background: var(--gray-bg); }
        .strip-number {
            font-size: clamp(32px, 4vw, 44px);
            font-weight: 800; color: var(--primary);
            margin-bottom: 4px;
        }
        .strip-label {
            font-size: 12px; color: var(--gray);
            font-weight: 500;
        }

        /* ===== SECTIONS ===== */
        .section {
            padding: clamp(60px, 8vw, 100px) clamp(16px, 4vw, 48px);
            max-width: 1100px; margin: 0 auto;
        }
        .section-label {
            font-size: 12px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--primary);
            text-align: center; margin-bottom: 12px;
        }
        .section-title {
            font-size: clamp(28px, 3.5vw, 40px);
            font-weight: 800; letter-spacing: -1px;
            text-align: center; margin-bottom: 12px;
        }
        .section-desc {
            color: var(--gray); font-size: 15px;
            max-width: 600px; margin: 0 auto 40px;
            text-align: center; line-height: 1.7;
        }

        /* ===== FEATURES ===== */
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px 24px;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: linear-gradient(90deg, var(--primary), var(--gold));
            opacity: 0; transition: var(--transition);
        }
        .feature-card:hover::before { opacity: 1; }
        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }
        .feature-icon {
            width: 60px; height: 60px;
            background: var(--primary-light);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin: 0 auto 16px;
            transition: var(--transition);
        }
        .feature-card:hover .feature-icon {
            background: var(--primary);
            color: white;
        }
        .feature-name {
            font-size: 16px; font-weight: 700; margin-bottom: 8px;
        }
        .feature-desc {
            font-size: 13px; color: var(--gray);
            line-height: 1.6;
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials-section {
            background: var(--gray-bg);
            border-radius: var(--radius-lg);
            padding: 48px 24px;
            margin: 40px 0;
        }
        .testi-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px; margin-top: 40px;
        }
        .testi-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 24px;
            text-align: center;
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .testi-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }
        .testi-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 14px;
            color: white;
        }
        .testi-rating { color: var(--gold); font-size: 14px; margin-bottom: 10px; }
        .testi-text {
            font-size: 13px; color: var(--dark-3);
            line-height: 1.6; font-style: italic;
            margin-bottom: 12px;
        }
        .testi-name { font-size: 12px; font-weight: 600; color: var(--primary); }

        /* ===== RATE & COMMENT ===== */
        .rate-section {
            background: linear-gradient(135deg, var(--primary-light), var(--card));
            border-radius: var(--radius-lg);
            padding: 40px;
            text-align: center;
            border: 1px solid var(--border);
            margin: 40px 0;
        }
        .star-rating {
            display: flex; justify-content: center; gap: 10px;
            margin: 20px 0;
        }
        .star-rating i {
            font-size: 36px; cursor: pointer;
            transition: var(--transition);
            color: var(--gray-light);
        }
        .star-rating i:hover,
        .star-rating i.active {
            color: var(--gold);
            transform: scale(1.15);
        }
        .comment-input {
            width: 100%; max-width: 500px;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--card);
            font-family: inherit;
            font-size: 14px;
            transition: var(--transition);
        }
        .comment-input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }
        .reviews-list {
            margin-top: 30px; max-height: 300px; overflow-y: auto;
        }
        .review-item {
            background: var(--card);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 10px;
            text-align: left;
            border: 1px solid var(--border);
        }
        .review-header {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 6px;
        }
        .review-name { font-weight: 600; font-size: 13px; }
        .review-stars { color: var(--gold); font-size: 12px; }
        .review-text { font-size: 12px; color: var(--gray); line-height: 1.5; }
        .review-date { font-size: 10px; color: var(--gray-light); margin-top: 4px; }

        /* ===== FAQ ===== */
        .faq-grid { max-width: 800px; margin: 0 auto; }
        .faq-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 12px;
            overflow: hidden;
            transition: var(--transition);
        }
        .faq-item:hover { border-color: var(--primary); }
        .faq-question {
            padding: 16px 20px;
            font-size: 15px; font-weight: 600;
            cursor: pointer;
            display: flex; justify-content: space-between;
            align-items: center;
            background: var(--card);
            transition: var(--transition);
        }
        .faq-question:hover { background: var(--gray-bg); }
        .faq-question i { transition: transform 0.3s; }
        .faq-item.open .faq-question i { transform: rotate(180deg); }
        .faq-answer {
            padding: 0 20px; max-height: 0; overflow: hidden;
            transition: all 0.3s ease;
            font-size: 13px; color: var(--gray);
            line-height: 1.7;
        }
        .faq-item.open .faq-answer {
            padding: 0 20px 18px; max-height: 300px;
        }

        /* ===== CTA ===== */
        .cta-wrapper {
            padding: 0 clamp(16px, 4vw, 48px) clamp(60px, 8vw, 100px);
        }
        .cta-box {
            max-width: 700px; margin: 0 auto;
            background: linear-gradient(135deg, var(--primary-light), rgba(246,130,31,0.05));
            border: 1px solid var(--primary);
            border-radius: var(--radius-lg);
            padding: clamp(40px, 5vw, 60px) clamp(24px, 4vw, 48px);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute;
            top: -50%; right: -30%; width: 60%; height: 100%;
            background: radial-gradient(circle, rgba(246,130,31,0.05) 0%, transparent 70%);
        }
        .cta-box h2 {
            font-size: clamp(26px, 3vw, 36px);
            font-weight: 800; letter-spacing: -1px;
            margin-bottom: 12px;
        }
        .cta-box p {
            color: var(--gray); font-size: 15px;
            margin-bottom: 28px; line-height: 1.7;
        }
        .cta-buttons {
            display: flex; gap: 14px;
            justify-content: center; flex-wrap: wrap;
        }

        /* ===== LIVE CHAT ===== */
        .live-chat-preview {
            position: fixed; bottom: 100px; right: 20px;
            z-index: 150; cursor: pointer;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .chat-bubble {
            background: var(--card);
            border-radius: 20px; padding: 12px 18px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            max-width: 240px;
            position: relative;
        }
        .chat-bubble::after {
            content: ''; position: absolute;
            bottom: -8px; right: 20px;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid var(--card);
        }
        .chat-agent {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 6px;
        }
        .chat-agent-img {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; color: white;
        }
        .chat-agent-name { font-size: 12px; font-weight: 600; }
        .chat-agent-status { font-size: 10px; color: var(--success); }
        .chat-message { font-size: 12px; color: var(--dark-3); line-height: 1.4; }
        .chat-typing {
            display: inline-block; width: 4px; height: 4px;
            border-radius: 50%; background: var(--gray);
            animation: typing 1.4s infinite;
        }
        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-4px); }
        }

        /* ===== BACK TO TOP ===== */
        .back-to-top {
            position: fixed; bottom: 30px; left: 20px;
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white; border: none; cursor: pointer;
            box-shadow: 0 4px 16px var(--primary-glow);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            opacity: 0; visibility: hidden;
            transition: var(--transition);
            z-index: 150;
        }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { transform: scale(1.1); }

        /* ===== FOOTER ===== */
        footer {
            border-top: 1px solid var(--border);
            padding: 40px clamp(16px, 4vw, 48px) 24px;
            background: var(--card);
        }
        .footer-content {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 32px; max-width: 1100px; margin: 0 auto;
        }
        .footer-col h4 {
            font-size: 14px; font-weight: 700; margin-bottom: 16px;
        }
        .footer-col a {
            display: block; color: var(--gray);
            text-decoration: none; font-size: 12px;
            margin-bottom: 8px; transition: var(--transition);
        }
        .footer-col a:hover { color: var(--primary); transform: translateX(4px); }
        .footer-bottom {
            text-align: center; padding-top: 24px;
            margin-top: 24px; border-top: 1px solid var(--border);
            font-size: 11px; color: var(--gray-light);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .features-grid { grid-template-columns: 1fr 1fr; }
            .mock-body { grid-template-columns: 1fr; }
            .mock-sidebar { display: none; }
        }
        @media (max-width: 768px) {
            .features-grid { grid-template-columns: 1fr; }
            .stats-strip { grid-template-columns: 1fr 1fr; }
            .trust-badges { gap: 16px; }
            .trust-item { font-size: 11px; }
            .testi-grid { grid-template-columns: 1fr; }
            .rate-section { padding: 24px; }
            .star-rating i { font-size: 28px; }
            .nav-links .nav-link { display: none; }
            .menu-toggle { display: block; }
            .live-chat-preview { display: none; }
            .mock-stats { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .hero-btns { flex-direction: column; align-items: stretch; }
            .stats-strip { grid-template-columns: 1fr; }
            .strip-item { border-right: none; border-bottom: 1px solid var(--border); }
            .strip-item:last-child { border-bottom: none; }
            .mock-body { padding: 12px; }
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

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar">
    <a href="index.php" class="nav-logo">
        <div class="nav-logo-icon">❄️</div>
        <div class="nav-logo-text">Polar.id</div>
    </a>
    <div class="nav-links">
        <a href="features.php" class="nav-link">Fitur</a>
        <a href="event.php" class="nav-link">Event</a>
        <a href="token.php" class="nav-link">Token</a>
        <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
        <a href="https://wa.me/<?= CS_NUMBER ?>" target="_blank" class="nav-link"><i class="fab fa-whatsapp"></i> CS</a>
        <a href="dashboard.php" class="nav-cta"><i class="fas fa-robot"></i> Dashboard</a>
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
            Bot WhatsApp Multi Device
        </div>
        
        <h1>Bot WA Kamu,<br><span class="highlight">Satu Dashboard.</span></h1>
        
        <div class="hero-subtitle">
            <span class="typing" id="typingText"></span><span class="cursor">|</span>
        </div>
        
        <p class="hero-desc">
            Aktifkan dan kelola session bot WhatsApp tanpa login, tanpa ribet. 
            Buka dashboard dan langsung pakai. Gratis selamanya!
        </p>
        
        <div class="hero-btns">
            <a href="dashboard.php" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> Buka Dashboard
            </a>
            <a href="features.php" class="btn btn-outline">
                <i class="fas fa-list"></i> Lihat Fitur
            </a>
        </div>
        
        <!-- Trust Badges -->
        <div class="trust-badges" data-aos="fade-up" data-aos-delay="100">
            <div class="trust-item"><i class="fas fa-check-circle"></i> 100% Gratis</div>
            <div class="trust-item"><i class="fas fa-shield-alt"></i> No Login Required</div>
            <div class="trust-item"><i class="fas fa-headset"></i> 24/7 Support</div>
            <div class="trust-item"><i class="fas fa-database"></i> Data Terenkripsi</div>
        </div>
        
        <!-- Mock Dashboard -->
        <div class="mock-dashboard" data-aos="fade-up" data-aos-delay="200">
            <div class="mock-header">
                <div class="mock-dot"></div>
                <div class="mock-dot"></div>
                <div class="mock-dot"></div>
                <div class="mock-url">polar.web.id/dashboard</div>
            </div>
            <div class="mock-body">
                <div class="mock-sidebar">
                    <div class="mock-nav active"><div class="mock-nav-dot"></div> Dashboard</div>
                    <div class="mock-nav"><div class="mock-nav-dot"></div> Session</div>
                    <div class="mock-nav"><div class="mock-nav-dot"></div> Settings</div>
                </div>
                <div>
                    <div class="mock-stats">
                        <div class="mock-stat">
                            <div class="mock-stat-label">Session</div>
                            <div class="mock-stat-value">3</div>
                        </div>
                        <div class="mock-stat">
                            <div class="mock-stat-label">Online</div>
                            <div class="mock-stat-value" style="color: var(--success);">2</div>
                        </div>
                        <div class="mock-stat">
                            <div class="mock-stat-label">Expired</div>
                            <div class="mock-stat-value">1</div>
                        </div>
                    </div>
                    <div class="mock-card-item">
                        <div>
                            <div class="mock-phone">+6281234567890</div>
                            <div style="font-size: 10px; color: var(--gray); margin-top: 2px;">Phoenix MD</div>
                        </div>
                        <div class="mock-online"><i class="fas fa-circle" style="font-size: 6px;"></i> Online</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS STRIP ===== -->
<div class="stats-strip">
    <div class="strip-item">
        <div class="strip-number" id="liveSessions"><?= number_format($activeSessions) ?></div>
        <div class="strip-label"><i class="fas fa-circle" style="font-size: 8px; color: var(--success);"></i> Session Aktif</div>
    </div>
    <div class="strip-item">
        <div class="strip-number"><?= number_format($totalUsers) ?>+</div>
        <div class="strip-label"><i class="fas fa-users"></i> Pengguna Aktif</div>
    </div>
    <div class="strip-item">
        <div class="strip-number">100%</div>
        <div class="strip-label"><i class="fas fa-charging-station"></i> Gratis</div>
    </div>
    <div class="strip-item">
        <div class="strip-number">24/7</div>
        <div class="strip-label"><i class="fas fa-clock"></i> Bot Online</div>
    </div>
</div>

<!-- ===== FEATURES ===== -->
<section class="section" id="features">
    <div class="section-label">Kenapa Polar.id?</div>
    <div class="section-title">Semua yang kamu butuhkan.</div>
    <div class="section-desc">
        Platform lengkap untuk menjalankan bot WhatsApp. Tanpa akun, tanpa login — langsung pakai.
    </div>
    
    <div class="features-grid">
        <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
            <div class="feature-icon">⚡</div>
            <div class="feature-name">Tanpa Login</div>
            <div class="feature-desc">Tidak perlu daftar. Browser kamu jadi identitasmu — langsung buka dan pakai.</div>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-icon">🛡️</div>
            <div class="feature-name">Privasi Terjaga</div>
            <div class="feature-desc">Data session terikat ke browser kamu. Orang lain tidak bisa akses session milikmu.</div>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-icon">🎛️</div>
            <div class="feature-name">Dashboard Bersih</div>
            <div class="feature-desc">Tambah session, lihat pairing code, hapus — semua dari satu halaman yang simpel.</div>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-icon">🔄</div>
            <div class="feature-name">Pairing Ulang</div>
            <div class="feature-desc">Session terputus? Request pairing code baru langsung dari dashboard tanpa repot.</div>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-icon">🆓</div>
            <div class="feature-name">Token Gratis</div>
            <div class="feature-desc">Generate token aktivasi gratis kapan saja. Tidak perlu bayar untuk memulai.</div>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
            <div class="feature-icon">💬</div>
            <div class="feature-name">Support Aktif</div>
            <div class="feature-desc">CS kami siap membantu via WhatsApp. Beli nokos murah juga tersedia.</div>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonials-section" data-aos="fade-up">
    <div class="section-label">Testimoni</div>
    <div class="section-title">💬 Apa Kata Mereka?</div>
    <div class="section-desc">Ribuan pengguna sudah merasakan kemudahan menggunakan Polar.id</div>
    
    <div class="testi-grid">
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★★</div>
            <div class="testi-text">"Mudah banget pakenya, tinggal klik langsung jadi. Bot langsung online tanpa ribet. Recommended banget!"</div>
            <div class="testi-name">— Andi Setiawan</div>
        </div>
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★★</div>
            <div class="testi-text">"Pairing cepat, bot langsung online. Dashboardnya simpel dan mudah dipahami. CS juga responsif banget."</div>
            <div class="testi-name">— Budi Santoso</div>
        </div>
        <div class="testi-card">
            <div class="testi-avatar">👤</div>
            <div class="testi-rating">★★★★☆</div>
            <div class="testi-text">"Sangat membantu untuk yang butuh bot WA cepat. Gratis tanpa daftar, langsung bisa pakai. Mantap!"</div>
            <div class="testi-name">— Citra Dewi</div>
        </div>
    </div>
</section>

<!-- ===== RATE & COMMENT ===== -->
<section class="rate-section" data-aos="fade-up">
    <div class="section-label">Beri Penilaian</div>
    <div class="section-title">⭐ Rate & Comment</div>
    <div class="section-desc">Bagikan pengalamanmu menggunakan Polar.id</div>
    
    <div class="star-rating" id="starRating">
        <i class="far fa-star" data-rating="1"></i>
        <i class="far fa-star" data-rating="2"></i>
        <i class="far fa-star" data-rating="3"></i>
        <i class="far fa-star" data-rating="4"></i>
        <i class="far fa-star" data-rating="5"></i>
    </div>
    <input type="text" class="comment-input" id="reviewName" placeholder="Nama kamu (opsional)">
    <textarea class="comment-input" id="reviewComment" rows="3" placeholder="Tulis komentar atau saran..."></textarea>
    <button class="btn btn-primary" onclick="submitReview()" style="margin-top: 10px;">
        <i class="fas fa-paper-plane"></i> Kirim Review
    </button>
    
    <div class="reviews-list" id="reviewsList">
        <?php foreach ($reviews as $r): ?>
        <div class="review-item">
            <div class="review-header">
                <span class="review-name"><?= htmlspecialchars($r['name'] ?? 'Anonymous') ?></span>
                <span class="review-stars"><?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?></span>
            </div>
            <div class="review-text"><?= htmlspecialchars($r['comment']) ?></div>
            <div class="review-date"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section" data-aos="fade-up">
    <div class="section-label">FAQ</div>
    <div class="section-title">❓ Pertanyaan Umum</div>
    <div class="section-desc">Temukan jawaban dari pertanyaan yang sering ditanyakan</div>
    
    <div class="faq-grid">
        <div class="faq-item">
            <div class="faq-question"><span>❓ Apa itu Polar.id?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Polar.id adalah platform untuk mengaktifkan dan mengelola bot WhatsApp secara gratis tanpa perlu registrasi. Cukup buka dashboard, generate token, dan masukkan nomor bot.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🔗 Bagaimana cara pairing bot?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Setelah membuat session, akan muncul pairing code. Buka WhatsApp di HP → Settings → Linked Devices → Link with phone number → Masukkan kode pairing yang muncul.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🛡️ Apakah aman menggunakan Polar.id?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Ya, aman. Data session tersimpan di browser kamu sendiri (fingerprint). Tidak ada orang lain yang bisa mengakses session milikmu karena terikat dengan device ID unik.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>💰 Apakah benar-benar gratis?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Ya, 100% gratis untuk membuat dan menjalankan bot WhatsApp. Token aktivasi juga gratis bisa didapatkan kapan saja.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>📱 Bisa pakai berapa session?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Setiap device ID bisa membuat maksimal 3 session. Jika butuh lebih, hubungi CS untuk menambah slot.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>⏰ Berapa lama session aktif?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Session aktif selama 3 hari. Kamu bisa memperpanjang session menggunakan token baru melalui dashboard.</div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<div class="cta-wrapper" data-aos="fade-up">
    <div class="cta-box">
        <h2>🚀 Siap punya bot WA sendiri?</h2>
        <p>Gratis. Tanpa daftar. Langsung pakai.<br>Buka dashboard dan aktifkan bot pertama kamu sekarang.</p>
        <div class="cta-buttons">
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Buka Dashboard — Gratis</a>
            <a href="https://wa.me/<?= CS_NUMBER ?>" target="_blank" class="btn btn-outline"><i class="fab fa-whatsapp"></i> Tanya CS dulu</a>
        </div>
    </div>
</div>

<!-- ===== LIVE CHAT PREVIEW ===== -->
<div class="live-chat-preview" onclick="window.open('https://wa.me/<?= CS_NUMBER ?>', '_blank')">
    <div class="chat-bubble">
        <div class="chat-agent">
            <div class="chat-agent-img">🤖</div>
            <div>
                <div class="chat-agent-name">Polar.id Bot</div>
                <div class="chat-agent-status">● Online</div>
            </div>
        </div>
        <div class="chat-message">
            Halo! Ada yang bisa dibantu? <span class="chat-typing"></span>
        </div>
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
            <h4><i class="fas fa-snowflake"></i> Polar.id</h4>
            <p style="font-size: 12px; color: var(--gray); line-height: 1.6;">Platform bot WhatsApp multi device. Gratis, cepat, dan mudah digunakan.</p>
        </div>
        <div class="footer-col">
            <h4>Menu</h4>
            <a href="index.php">Beranda</a>
            <a href="features.php">Fitur</a>
            <a href="event.php">Event</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
        <div class="footer-col">
            <h4>Lainnya</h4>
            <a href="https://sfl.gl/lvvR">Ambil Token</a>
            <a href="https://wa.me/<?= CS_NUMBER ?>">Customer Service</a>
            <a href="https://polar.web.id/otp-web.html">Beli Nokos</a>
        </div>
        <div class="footer-col">
            <h4>Ikuti Kami</h4>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#"><i class="fab fa-tiktok"></i> TikTok</a>
            <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
        </div>
    </div>
    <div class="footer-bottom">
        © <?= date('Y') ?> Polar.id — Bot WhatsApp Multi Device. All rights reserved.
    </div>
</footer>

<!-- ============================================================ -->
<!-- ===== JAVASCRIPT ===== -->
<!-- ============================================================ -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // ============================================================
    // 1. THEME TOGGLE
    // ============================================================
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
    (function loadTheme() {
        const saved = localStorage.getItem('theme');
        if (saved === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.getElementById('themeIcon').className = 'fas fa-sun';
        }
    })();

    // ============================================================
    // 2. TYPING ANIMATION
    // ============================================================
    (function initTyping() {
        const words = ["Bot WhatsApp", "Auto Reply", "Group Manager", "AI Assistant", "Multi Device"];
        let i = 0, j = 0, isDeleting = false;
        const el = document.getElementById('typingText');
        if (!el) return;

        function typeEffect() {
            const current = words[i];
            if (isDeleting) {
                el.textContent = current.substring(0, j - 1);
                j--;
            } else {
                el.textContent = current.substring(0, j + 1);
                j++;
            }
            if (!isDeleting && j === current.length) {
                isDeleting = true;
                setTimeout(typeEffect, 2000);
            } else if (isDeleting && j === 0) {
                isDeleting = false;
                i = (i + 1) % words.length;
                setTimeout(typeEffect, 500);
            } else {
                setTimeout(typeEffect, isDeleting ? 50 : 100);
            }
        }
        typeEffect();
    })();

    // ============================================================
    // 3. SCROLL PROGRESS BAR
    // ============================================================
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

    // ============================================================
    // 4. FAQ ACCORDION
    // ============================================================
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => q.closest('.faq-item').classList.toggle('open'));
    });

    // ============================================================
    // 5. STAR RATING
    // ============================================================
    let selectedRating = 0;
    document.querySelectorAll('#starRating i').forEach(star => {
        const updateStars = (rating) => {
            document.querySelectorAll('#starRating i').forEach(s => {
                const r = parseInt(s.dataset.rating);
                s.className = r <= rating ? 'fas fa-star' : 'far fa-star';
                s.style.color = r <= rating ? '#fbbf24' : '';
            });
        };
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            updateStars(selectedRating);
        });
        star.addEventListener('mouseenter', function() {
            updateStars(parseInt(this.dataset.rating));
        });
        star.addEventListener('mouseleave', function() {
            if (selectedRating > 0) updateStars(selectedRating);
            else {
                document.querySelectorAll('#starRating i').forEach(s => {
                    s.className = 'far fa-star';
                    s.style.color = '';
                });
            }
        });
    });

    // ============================================================
    // 6. SUBMIT REVIEW
    // ============================================================
    async function submitReview() {
        const rating = selectedRating;
        const name = document.getElementById('reviewName').value.trim();
        const comment = document.getElementById('reviewComment').value.trim();
        if (rating === 0) { alert('Pilih rating bintang!'); return; }
        if (!comment) { alert('Tulis komentar!'); return; }
        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengirim...';
        try {
            const res = await fetch('api/submit-review.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ rating, name: name || 'Anonymous', comment })
            });
            const data = await res.json();
            alert(data.success ? '✅ Terima kasih atas review-nya!' : '❌ Gagal: ' + data.message);
            if (data.success) location.reload();
        } catch(e) { alert('❌ Error: ' + e.message); }
        finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Review'; }
    }

    // ============================================================
    // 7. LIVE COUNTER UPDATE
    // ============================================================
    async function updateLiveCounter() {
        try {
            const res = await fetch('api/get-stats.php');
            const data = await res.json();
            if (data.active_sessions) {
                document.getElementById('liveSessions').textContent = data.active_sessions.toLocaleString();
            }
        } catch(e) {}
    }
    setInterval(updateLiveCounter, 30000);

    // ============================================================
    // 8. SPLASH SCREEN
    // ============================================================
    window.addEventListener('load', () => {
        setTimeout(() => document.getElementById('splash')?.classList.add('hide'), 1800);
    });

    // ============================================================
    // 9. MOBILE MENU
    // ============================================================
    let mobileMenuOpen = false;
    function toggleMobileMenu() {
        // Implementasi sederhana: toggle class pada navbar
        document.querySelector('.nav-links').classList.toggle('mobile-open');
        const icon = document.querySelector('.menu-toggle i');
        if (icon) icon.className = mobileMenuOpen ? 'fas fa-bars' : 'fas fa-times';
        mobileMenuOpen = !mobileMenuOpen;
    }

    // ============================================================
    // 10. AOS INIT
    // ============================================================
    AOS.init({
        duration: 700,
        once: true,
        offset: 50,
        easing: 'ease-out-cubic'
    });

    // ============================================================
    // 11. HIDE CHAT ON MOBILE
    // ============================================================
    if (window.innerWidth < 768) {
        document.querySelector('.live-chat-preview')?.remove();
    }

    // ============================================================
    // 12. SMOOTH SCROLL FOR NAV LINKS
    // ============================================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    console.log('🚀 Polar.id loaded successfully!');
    console.log('📊 Active sessions:', document.getElementById('liveSessions')?.textContent || 'N/A');
</script>
</body>
</html>
