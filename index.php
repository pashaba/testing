<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id - Platform Layanan Digital Premium</title>
    <meta name="title" content="Polar.id - Platform Layanan Digital Premium Terpercaya" />
    <meta name="description" content="Platform layanan digital premium: Jadibot WhatsApp, Tools (Ceknik, YouTube & TikTok Downloader), Hosting, Domain, dan berbagai solusi digital lainnya." />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta property="og:title" content="Polar.id - Platform Layanan Digital Premium">
    <meta property="og:url" content="https://polar.web.id">
    <meta property="og:image" content="https://polar.web.id/og-image.jpg">
    <meta property="og:description" content="Platform layanan digital premium: Jadibot WhatsApp, Tools, Hosting, Domain, dan berbagai solusi digital lainnya.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* ============================================================
           ULTRA PREMIUM NEO-BRUTALISM
           ============================================================ */
        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --off-white: #f4f4ef;
            --gray: #888888;
            --light-gray: #e8e8e8;
            
            --primary: #ff0055;
            --primary-dark: #cc0044;
            --secondary: #00e5ff;
            --yellow: #ffdd00;
            --green: #00ff88;
            --orange: #ff6b35;
            --purple: #7c3aed;
            --pink: #ec4899;
            --teal: #14b8a6;
            --gold: #f59e0b;
            
            --border-thick: 4px solid var(--black);
            --shadow-heavy: 8px 8px 0px 0px var(--black);
            --shadow-light: 4px 4px 0px 0px var(--black);
            --shadow-xl: 12px 12px 0px 0px var(--black);
            --shadow-2xl: 16px 16px 0px 0px var(--black);
            
            --radius: 0px;
            --font-display: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            --bg-body: #f0ede8;
            --text-body: #0a0a0a;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg-body);
            color: var(--text-body);
            line-height: 1.6;
            min-height: 100vh;
            padding: 16px;
            overflow-x: hidden;
        }

        /* ---- TYPOGRAPHY ---- */
        h1, h2, h3, h4 {
            font-family: var(--font-display);
            font-weight: 900;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        /* ---- SCROLLBAR ---- */
        ::-webkit-scrollbar {
            width: 12px;
            background: var(--black);
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary), var(--purple));
            border: 2px solid var(--black);
        }
        ::-webkit-scrollbar-track {
            background: var(--off-white);
            border-left: 2px solid var(--black);
        }

        /* ---- UTILITY ---- */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            padding: 14px 32px;
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            background: var(--white);
            color: var(--black);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            color: var(--white);
            border-color: var(--black);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--purple));
        }

        .btn-secondary {
            background: var(--black);
            color: var(--white);
            border-color: var(--black);
        }

        .btn-secondary:hover {
            background: #1a1a1a;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--black);
            border-color: var(--black);
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #fbbf24, var(--gold));
        }

        /* ---- SPLASH SCREEN ---- */
        #splash {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: var(--black);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        #splash.hide {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .splash-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--purple), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 44px;
            color: var(--white);
            border: 5px solid var(--white);
            box-shadow: 0 0 0 4px var(--black), 0 12px 40px rgba(255, 0, 85, 0.4);
            animation: logoPulse 2s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.04) rotate(-3deg); }
        }

        .splash-name {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .splash-spinner {
            width: 48px;
            height: 48px;
            border: 5px solid #222;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .splash-sub {
            color: #888;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .splash-progress {
            width: 200px;
            height: 4px;
            background: #222;
            border-radius: 2px;
            overflow: hidden;
        }

        .splash-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--purple));
            animation: loadProgress 1.5s ease forwards;
        }

        @keyframes loadProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        /* ---- PROGRESS BAR ---- */
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            z-index: 1000;
            background: transparent;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--purple));
            border-bottom: var(--border-thick);
            transition: width 0.15s ease;
        }

        /* ---- HERO ---- */
        .hero {
            padding: 30px 0 50px;
            border-bottom: var(--border-thick);
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, var(--white) 0%, var(--off-white) 100%);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 0, 85, 0.06), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.04), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            max-width: 820px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--black);
            color: var(--white);
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            padding: 8px 20px;
            border: var(--border-thick);
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            animation: badgePulse 3s ease-in-out infinite;
        }

        @keyframes badgePulse {
            0%, 100% { box-shadow: var(--shadow-light); }
            50% { box-shadow: 0 0 0 4px var(--primary), 4px 4px 0 4px var(--black); }
        }

        .hero-badge-dot {
            width: 12px;
            height: 12px;
            background: var(--green);
            border: 2px solid var(--white);
            border-radius: 50%;
            animation: dotPulse 1.5s ease-in-out infinite;
        }

        @keyframes dotPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.8); }
        }

        .hero h1 {
            font-size: clamp(2.8rem, 7vw, 5rem);
            line-height: 1.05;
            margin-bottom: 16px;
            color: var(--black);
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--yellow), var(--gold));
            padding: 0 10px;
            display: inline-block;
            transform: rotate(-0.5deg);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            position: relative;
        }

        .hero h1 .highlight::after {
            content: '✦';
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 1.2rem;
            transform: rotate(15deg);
        }

        .hero-subtitle {
            font-size: clamp(1rem, 1.6vw, 1.25rem);
            font-weight: 600;
            color: #1a1a1a;
            max-width: 520px;
            margin: 0 auto 32px;
            line-height: 1.5;
        }

        /* ---- TRUST BADGES ---- */
        .trust-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px 28px;
            margin-top: 16px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 8px 16px;
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            transition: all 0.15s ease;
        }

        .trust-item:hover {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .trust-item i { font-size: 1.1rem; }
        .trust-item.gratis i { color: var(--green); }
        .trust-item.instan i { color: var(--secondary); }
        .trust-item.pro i { color: var(--gold); }
        .trust-item.aman i { color: var(--purple); }

        /* ============================================================
           CAROUSEL LAYANAN PREMIUM
           ============================================================ */
        .carousel-section {
            padding: 40px 0 30px;
            background: var(--black);
            border-top: var(--border-thick);
            border-bottom: var(--border-thick);
            margin: 12px 0;
            position: relative;
            overflow: hidden;
        }

        .carousel-section::before {
            content: '✦';
            position: absolute;
            top: -30px;
            right: -20px;
            font-size: 10rem;
            color: rgba(255,255,255,0.03);
            transform: rotate(20deg);
        }

        .carousel-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .carousel-header .section-title {
            color: var(--white);
        }

        .carousel-header .section-title::after {
            background: var(--gold);
        }

        .carousel-header .section-subtitle {
            color: #aaa;
        }

        .carousel-header .section-subtitle span {
            background: var(--gold);
            color: var(--black);
        }

        .carousel-wrapper {
            position: relative;
            overflow: hidden;
            padding: 0 40px;
        }

        .carousel-track {
            display: flex;
            gap: 24px;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
        }

        .carousel-card {
            min-width: 280px;
            max-width: 320px;
            flex-shrink: 0;
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            padding: 24px 20px;
            transition: all 0.3s ease;
            position: relative;
            transform: scale(0.95);
            opacity: 0.7;
            cursor: pointer;
        }

        .carousel-card.active {
            transform: scale(1);
            opacity: 1;
            box-shadow: var(--shadow-2xl);
        }

        .carousel-card:hover {
            transform: translate(4px, 4px) scale(1.02);
            box-shadow: none;
        }

        .carousel-card.active:hover {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        /* Thumbnail/Webview Mini */
        .carousel-thumbnail {
            width: 100%;
            height: 140px;
            background: var(--off-white);
            border: var(--border-thick);
            margin-bottom: 14px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-thumbnail iframe {
            width: 100%;
            height: 100%;
            border: none;
            transform: scale(0.3);
            transform-origin: top left;
            width: 333%;
            height: 333%;
            pointer-events: none;
        }

        .carousel-thumbnail .thumbnail-placeholder {
            font-size: 3rem;
            opacity: 0.3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--gray);
        }

        .carousel-thumbnail .thumbnail-placeholder span {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            font-family: var(--font-display);
        }

        .carousel-thumbnail .premium-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--black);
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.6rem;
            text-transform: uppercase;
            padding: 2px 10px;
            border: 2px solid var(--black);
        }

        .carousel-card-icon {
            font-size: 1.8rem;
            margin-bottom: 6px;
            display: inline-block;
        }

        .carousel-card-title {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 1.1rem;
            text-transform: uppercase;
            color: var(--black);
        }

        .carousel-card-desc {
            font-size: 0.8rem;
            font-weight: 500;
            color: #444;
            margin: 4px 0 10px;
        }

        .carousel-card-price {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 1.3rem;
            color: var(--black);
        }

        .carousel-card-price .price-original {
            font-size: 0.8rem;
            color: var(--gray);
            text-decoration: line-through;
            font-weight: 600;
            margin-right: 8px;
        }

        .carousel-card .btn-small {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.7rem;
            text-transform: uppercase;
            padding: 8px 18px;
            border: var(--border-thick);
            background: var(--black);
            color: var(--white);
            text-decoration: none;
            transition: all 0.15s ease;
            margin-top: 10px;
        }

        .carousel-card .btn-small:hover {
            transform: translate(3px, 3px);
            box-shadow: none;
            background: var(--gold);
            color: var(--black);
        }

        /* Carousel Controls */
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            color: var(--black);
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .carousel-btn:hover {
            transform: translateY(-50%) translate(3px, 3px);
            box-shadow: none;
            background: var(--primary);
            color: var(--white);
        }

        .carousel-btn.prev {
            left: 0;
        }

        .carousel-btn.next {
            right: 0;
        }

        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 24px;
            position: relative;
            z-index: 1;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border: var(--border-thick);
            background: var(--white);
            cursor: pointer;
            transition: all 0.15s ease;
            opacity: 0.4;
        }

        .carousel-dot.active {
            background: var(--gold);
            opacity: 1;
            transform: scale(1.2);
        }

        .carousel-dot:hover {
            opacity: 0.8;
        }

        /* ============================================================
           SEARCH / FILTER
           ============================================================ */
        .search-section {
            padding: 20px 0 10px;
        }

        .search-box {
            max-width: 520px;
            margin: 0 auto;
            display: flex;
            gap: 8px;
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            padding: 4px;
            transition: all 0.15s ease;
        }

        .search-box:focus-within {
            box-shadow: var(--shadow-xl);
            transform: translate(-2px, -2px);
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 14px 18px;
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 1rem;
            background: transparent;
            outline: none;
            color: var(--black);
        }

        .search-box input::placeholder {
            color: var(--gray);
            font-weight: 500;
        }

        .search-box button {
            padding: 12px 20px;
            background: var(--black);
            color: var(--white);
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .search-box button:hover {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            transform: scale(1.05);
        }

        /* ============================================================
           LAYANAN / SERVICES GRID
           ============================================================ */
        .services-section {
            padding: 40px 0 50px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 2.5rem);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            color: var(--black);
            margin-bottom: 8px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--purple));
            border: 2px solid var(--black);
        }

        .section-subtitle {
            font-size: 1.05rem;
            font-weight: 500;
            color: #444;
            max-width: 500px;
            margin: 16px auto 0;
        }

        .section-subtitle span {
            background: var(--yellow);
            padding: 0 6px;
            font-weight: 800;
            border: 2px solid var(--black);
        }

        /* ---- SERVICE CARDS GRID ---- */
        .services-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            margin-top: 20px;
        }

        @media (min-width: 640px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* ---- SERVICE CARD ---- */
        .service-card {
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            padding: 28px 24px 24px;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            cursor: default;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--purple));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        .service-card::after {
            content: '✦';
            position: absolute;
            bottom: 8px;
            right: 12px;
            font-size: 0.6rem;
            color: var(--gray);
            opacity: 0.3;
        }

        /* Badge */
        .service-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.6rem;
            text-transform: uppercase;
            padding: 4px 12px;
            border: var(--border-thick);
            background: var(--yellow);
            color: var(--black);
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .service-badge.gratis {
            background: var(--green);
            color: var(--black);
        }

        .service-badge.populer {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            color: var(--white);
        }

        .service-badge.baru {
            background: var(--secondary);
            color: var(--black);
        }

        .service-badge.promo {
            background: var(--orange);
            color: var(--white);
        }

        .service-badge.premium {
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--black);
        }

        /* Icon */
        .service-icon {
            font-size: 2.8rem;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--black);
            color: var(--white);
            border: var(--border-thick);
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .service-card.type-jadibot .service-icon { background: linear-gradient(135deg, #25D366, #128C7E); }
        .service-card.type-tools .service-icon { background: linear-gradient(135deg, var(--secondary), var(--teal)); color: var(--black); }
        .service-card.type-hosting .service-icon { background: linear-gradient(135deg, var(--green), #059669); color: var(--black); }
        .service-card.type-domain .service-icon { background: linear-gradient(135deg, var(--purple), #6d28d9); }
        .service-card.type-premium .service-icon { background: linear-gradient(135deg, var(--gold), #d97706); color: var(--black); }
        .service-card.type-other .service-icon { background: linear-gradient(135deg, var(--orange), #ea580c); }

        .service-name {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 900;
            text-transform: uppercase;
            color: var(--black);
            margin-bottom: 4px;
        }

        .service-desc {
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            flex: 1;
            line-height: 1.5;
        }

        .service-desc .highlight-tag {
            display: inline-block;
            background: var(--yellow);
            padding: 0 4px;
            font-weight: 700;
            border: 2px solid var(--black);
            font-size: 0.7rem;
        }

        .service-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 6px 0 12px;
        }

        .service-tag {
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 10px;
            background: var(--off-white);
            border: 2px solid var(--black);
            font-family: var(--font-display);
        }

        .service-tag i {
            margin-right: 4px;
        }

        .service-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 16px;
            font-family: var(--font-display);
        }

        .service-meta i {
            margin-right: 4px;
        }

        .service-meta .status-online {
            color: var(--green);
        }

        .service-meta .status-maintenance {
            color: var(--orange);
        }

        .service-meta .status-offline {
            color: var(--gray);
        }

        .service-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 12px 24px;
            border: var(--border-thick);
            background: var(--black);
            color: var(--white);
            text-decoration: none;
            transition: all 0.15s ease;
            margin-top: 4px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .service-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transform: rotate(45deg) translateX(100%);
            transition: transform 0.4s ease;
        }

        .service-btn:hover::after {
            transform: rotate(45deg) translateX(-100%);
        }

        .service-btn:hover {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .service-card.type-jadibot .service-btn { 
            background: linear-gradient(135deg, #25D366, #128C7E); 
            color: var(--white);
        }
        .service-card.type-jadibot .service-btn:hover { 
            background: var(--black);
        }

        .service-card.type-tools .service-btn { 
            background: linear-gradient(135deg, var(--secondary), var(--teal)); 
            color: var(--black);
        }
        .service-card.type-tools .service-btn:hover { 
            background: var(--black); 
            color: var(--white);
        }

        .service-card.type-premium .service-btn {
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--black);
        }
        .service-card.type-premium .service-btn:hover {
            background: var(--black);
            color: var(--white);
        }

        /* ============================================================
           STATS STRIP
           ============================================================ */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            border: var(--border-thick);
            background: var(--white);
            margin: 12px 0 24px;
            box-shadow: var(--shadow-light);
        }

        .strip-item {
            padding: 18px 8px;
            text-align: center;
            border-right: var(--border-thick);
            border-bottom: var(--border-thick);
            transition: all 0.15s ease;
        }

        .strip-item:hover {
            background: var(--off-white);
            transform: scale(1.02);
        }

        .strip-item:nth-child(2n) { border-right: none; }
        .strip-item:nth-child(3),
        .strip-item:nth-child(4) { border-bottom: none; }

        .strip-number {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 900;
            color: var(--black);
            line-height: 1.1;
        }

        .strip-label {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #444;
            letter-spacing: 0.3px;
        }

        @media (min-width: 768px) {
            .stats-strip {
                grid-template-columns: repeat(4, 1fr);
            }
            .strip-item {
                border-right: var(--border-thick) !important;
                border-bottom: none !important;
            }
            .strip-item:last-child { border-right: none !important; }
        }

        /* ============================================================
           TESTIMONIALS
           ============================================================ */
        .testimonials-section {
            background: var(--white);
            border-top: var(--border-thick);
            border-bottom: var(--border-thick);
            padding: 40px 0;
            margin: 12px 0;
        }

        .testi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-top: 24px;
        }

        @media (min-width: 768px) {
            .testi-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .testi-card {
            background: var(--off-white);
            border: var(--border-thick);
            padding: 18px 22px;
            box-shadow: var(--shadow-light);
            transition: all 0.15s ease;
        }

        .testi-card:hover {
            transform: translate(3px, 3px);
            box-shadow: none;
        }

        .testi-avatar { font-size: 1.6rem; margin-bottom: 4px; }
        .testi-rating { color: var(--gold); font-size: 1rem; letter-spacing: 1px; margin-bottom: 4px; }
        .testi-text { font-size: 0.95rem; font-weight: 500; font-style: italic; color: #1a1a1a; margin-bottom: 6px; }
        .testi-name { font-family: var(--font-display); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; }

        /* ============================================================
           FAQ
           ============================================================ */
        .faq-section {
            padding: 40px 0 50px;
        }

        .faq-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 720px;
            margin: 0 auto;
        }

        .faq-item {
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
            overflow: hidden;
            transition: all 0.15s ease;
        }

        .faq-item:hover {
            box-shadow: var(--shadow-heavy);
        }

        .faq-question {
            padding: 14px 18px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background: var(--white);
            border-bottom: 2px solid transparent;
            transition: all 0.15s ease;
        }

        .faq-question:hover { background: var(--off-white); }
        .faq-question i { font-size: 1rem; transition: transform 0.2s ease; }

        .faq-item.open .faq-question {
            border-bottom: var(--border-thick);
            background: linear-gradient(135deg, var(--black), #1a1a1a);
            color: var(--white);
        }

        .faq-item.open .faq-question i { transform: rotate(180deg); }

        .faq-answer {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #1a1a1a;
        }

        .faq-item.open .faq-answer {
            padding: 14px 18px;
            max-height: 200px;
        }

        /* ============================================================
           CTA
           ============================================================ */
        .cta-wrapper { padding: 24px 0 32px; }

        .cta-box {
            background: linear-gradient(135deg, var(--black), #1a1a1a);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            padding: 40px 20px;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '✦';
            position: absolute;
            top: -30px;
            right: -10px;
            font-size: 10rem;
            color: rgba(255,255,255,0.03);
            transform: rotate(15deg);
        }

        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 0, 85, 0.05), transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cta-box h2 {
            font-size: clamp(1.8rem, 3vw, 2.2rem);
            color: var(--white);
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .cta-box p {
            font-weight: 500;
            font-size: 1rem;
            color: #bbb;
            margin-bottom: 20px;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 1;
        }

        .cta-box .btn-cta {
            background: linear-gradient(135deg, var(--gold), #d97706);
            color: var(--black);
            border-color: var(--white);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            padding: 14px 32px;
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .cta-box .btn-cta:hover {
            background: var(--white);
            transform: translate(4px, 4px);
            box-shadow: none;
        }

        /* ============================================================
           BACK TO TOP
           ============================================================ */
        .back-to-top {
            position: fixed;
            bottom: 24px;
            left: 24px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            color: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-heavy);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 150;
            border-radius: 50%;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translate(4px, 4px);
            box-shadow: none;
            background: var(--black);
            color: var(--white);
        }

        /* ============================================================
           FOOTER
           ============================================================ */
        footer {
            border-top: var(--border-thick);
            background: var(--white);
            padding: 32px 0 20px;
            margin-top: 12px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .footer-col h4 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--black);
            position: relative;
            display: inline-block;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--purple));
            border: 1px solid var(--black);
        }

        .footer-col p,
        .footer-col a {
            font-size: 0.9rem;
            font-weight: 500;
            color: #1a1a1a;
            text-decoration: none;
            display: block;
            margin-bottom: 4px;
            transition: all 0.15s ease;
        }

        .footer-col a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: var(--border-thick);
            background: var(--black);
            color: var(--white);
            font-size: 1.1rem;
            transition: all 0.15s ease;
        }

        .footer-social a:hover {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            transform: translate(3px, 3px);
            box-shadow: none;
            text-decoration: none;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 16px;
            margin-top: 16px;
            border-top: var(--border-thick);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.8rem;
        }

        @media (min-width: 768px) {
            .footer-content {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* ============================================================
           RESPONSIVE FIXES
           ============================================================ */
        @media (max-width: 480px) {
            .service-card { padding: 20px 16px; }
            .service-name { font-size: 1.1rem; }
            .service-icon { width: 56px; height: 56px; font-size: 2rem; }
            .section-title { font-size: 1.8rem; }
            .back-to-top { 
                width: 42px; 
                height: 42px; 
                font-size: 1rem;
                bottom: 16px;
                left: 16px;
            }
            .carousel-wrapper { padding: 0 20px; }
            .carousel-card { min-width: 220px; max-width: 260px; }
            .carousel-btn { width: 36px; height: 36px; font-size: 0.9rem; }
        }

        @media (max-width: 768px) {
            .carousel-card { min-width: 240px; max-width: 280px; }
            .carousel-thumbnail { height: 100px; }
        }

        /* ---- EMPTY STATE ---- */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: var(--white);
            border: var(--border-thick);
            box-shadow: var(--shadow-light);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-family: var(--font-display);
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .empty-state p {
            color: #666;
            font-weight: 500;
        }

        .no-result {
            text-align: center;
            padding: 30px;
            display: none;
        }

        .no-result.show {
            display: block;
        }

        .no-result i {
            font-size: 2.5rem;
            color: var(--gray);
            margin-bottom: 8px;
        }

        .no-result h3 {
            font-family: var(--font-display);
            font-size: 1rem;
            text-transform: uppercase;
        }

        /* ANIMATIONS */
        .service-card.type-jadibot .service-icon i {
            animation: whatsappPulse 2s ease-in-out infinite;
        }

        @keyframes whatsappPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .service-card.type-tools .service-icon i {
            animation: toolsSpin 8s linear infinite;
        }

        @keyframes toolsSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .service-card.type-premium .service-icon i {
            animation: premiumGlow 2s ease-in-out infinite;
        }

        @keyframes premiumGlow {
            0%, 100% { filter: drop-shadow(0 0 0px rgba(245, 158, 11, 0)); }
            50% { filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.5)); }
        }
    </style>
</head>
<body>

<?php
// ============================================================
// KONFIGURASI LAYANAN
// ============================================================
$services = [
    // FREE LAYANAN
    [
        'id' => 'jadibot',
        'type' => 'jadibot',
        'name' => 'Jadibot WhatsApp',
        'desc' => 'Bot WhatsApp multi-device gratis. Pairing cepat, tanpa registrasi, langsung online! Support Phoenix MD & Ourin MD.',
        'icon' => 'fa-brands fa-whatsapp',
        'badge' => 'Gratis',
        'badge_type' => 'gratis',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/dashboard.php',
        'target' => '_self',
        'users' => '1.2k+',
        'featured' => true,
        'is_premium' => false,
        'tags' => ['Multi-Device', 'Pairing', 'No Login'],
        'created_at' => '2024-01-01'
    ],
    [
        'id' => 'tools',
        'type' => 'tools',
        'name' => 'Tools Collection',
        'desc' => 'Kumpulan tools digital lengkap: <span class="highlight-tag">Ceknik</span> (Cek NIK KTP), <span class="highlight-tag">YouTube Downloader</span>, <span class="highlight-tag">TikTok Downloader</span>, QR Generator & banyak lagi!',
        'icon' => 'fa-solid fa-toolbox',
        'badge' => 'Populer',
        'badge_type' => 'populer',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/tools/index.html',
        'target' => '_self',
        'users' => '500+',
        'featured' => true,
        'is_premium' => false,
        'tags' => ['Ceknik', 'YT Downloader', 'TT Downloader', 'QR Generator'],
        'created_at' => '2024-03-15'
    ],
    
    // ============================================================
    // PREMIUM LAYANAN — Untuk Carousel
    // ============================================================
    [
        'id' => 'premium-hosting',
        'type' => 'premium',
        'name' => 'Premium Hosting',
        'desc' => 'Hosting premium dengan performa tinggi, uptime 99.9%, dan support 24/7.',
        'icon' => 'fa-solid fa-server',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/hosting',
        'target' => '_blank',
        'users' => '250+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 50.000',
        'price_original' => 'Rp 100.000',
        'thumbnail' => 'hosting',
        'tags' => ['SSD', 'SSL', '24/7 Support'],
        'created_at' => '2024-06-01'
    ],
    [
        'id' => 'premium-domain',
        'type' => 'premium',
        'name' => 'Domain .com',
        'desc' => 'Dapatkan domain .com premium dengan harga spesial dan perlindungan privasi gratis.',
        'icon' => 'fa-solid fa-globe',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/domain',
        'target' => '_blank',
        'users' => '180+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 120.000',
        'price_original' => 'Rp 200.000',
        'thumbnail' => 'domain',
        'tags' => ['.com', 'Privacy', 'Free SSL'],
        'created_at' => '2024-07-10'
    ],
    [
        'id' => 'premium-api',
        'type' => 'premium',
        'name' => 'API Premium',
        'desc' => 'Akses API premium dengan rate limit tinggi dan support priority untuk bisnis Anda.',
        'icon' => 'fa-solid fa-code',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/api',
        'target' => '_blank',
        'users' => '95+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 200.000',
        'price_original' => 'Rp 350.000',
        'thumbnail' => 'api',
        'tags' => ['REST API', 'High Rate', 'Priority Support'],
        'created_at' => '2024-08-20'
    ],
    [
        'id' => 'premium-bot',
        'type' => 'premium',
        'name' => 'Bot WhatsApp Pro',
        'desc' => 'Bot WhatsApp premium dengan fitur lengkap: auto reply, schedule, AI response, dan analytics.',
        'icon' => 'fa-brands fa-whatsapp',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/bot',
        'target' => '_blank',
        'users' => '300+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 75.000',
        'price_original' => 'Rp 150.000',
        'thumbnail' => 'bot',
        'tags' => ['Auto Reply', 'AI', 'Analytics'],
        'created_at' => '2024-09-01'
    ],
    [
        'id' => 'premium-storage',
        'type' => 'premium',
        'name' => 'Cloud Storage',
        'desc' => 'Penyimpanan cloud aman dengan enkripsi end-to-end dan akses dari mana saja.',
        'icon' => 'fa-solid fa-cloud',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/storage',
        'target' => '_blank',
        'users' => '120+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 45.000',
        'price_original' => 'Rp 90.000',
        'thumbnail' => 'storage',
        'tags' => ['Encrypted', '50GB', 'Sync'],
        'created_at' => '2024-10-15'
    ],
    [
        'id' => 'premium-cdn',
        'type' => 'premium',
        'name' => 'CDN Premium',
        'desc' => 'Jaringan distribusi konten global dengan kecepatan tinggi dan keamanan DDoS protection.',
        'icon' => 'fa-solid fa-network-wired',
        'badge' => 'Premium',
        'badge_type' => 'premium',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/premium/cdn',
        'target' => '_blank',
        'users' => '65+',
        'featured' => false,
        'is_premium' => true,
        'price' => 'Rp 150.000',
        'price_original' => 'Rp 280.000',
        'thumbnail' => 'cdn',
        'tags' => ['Global', 'DDoS Protection', 'Fast'],
        'created_at' => '2024-11-01'
    ]
];

// Filter FREE services untuk grid
$free_services = array_filter($services, function($s) {
    return !isset($s['is_premium']) || $s['is_premium'] === false;
});

// Filter PREMIUM services untuk carousel
$premium_services = array_filter($services, function($s) {
    return isset($s['is_premium']) && $s['is_premium'] === true;
});

// Ambil parameter filter dari URL
$search = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

// Filter free services berdasarkan pencarian
$filtered_services = array_filter($free_services, function($service) use ($search) {
    if (empty($search)) return true;
    return strpos(strtolower($service['name']), $search) !== false ||
           strpos(strtolower($service['desc']), $search) !== false ||
           strpos(strtolower($service['id']), $search) !== false ||
           array_reduce($service['tags'] ?? [], function($carry, $tag) use ($search) {
               return $carry || strpos(strtolower($tag), $search) !== false;
           }, false);
});

// Pisahkan featured dan regular
$featured_services = array_filter($filtered_services, function($s) {
    return isset($s['featured']) && $s['featured'] === true;
});
$regular_services = array_filter($filtered_services, function($s) {
    return !isset($s['featured']) || $s['featured'] !== true;
});

$sorted_services = array_merge($featured_services, $regular_services);

// Statistik
$total_services = count($services);
$total_free = count($free_services);
$total_premium = count($premium_services);
$active_services = count(array_filter($services, function($s) {
    return $s['status_type'] === 'online';
}));
?>

<!-- PROGRESS BAR -->
<div class="progress-container"><div class="progress-bar" id="progressBar"></div></div>

<!-- SPLASH SCREEN -->
<div id="splash">
    <div class="splash-logo">❄️</div>
    <div class="splash-name">Polar.id</div>
    <div class="splash-spinner"></div>
    <div class="splash-progress"><div class="splash-progress-bar"></div></div>
    <div class="splash-sub">Memuat layanan premium...</div>
</div>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="hero" id="home">
    <div class="container hero-content">
        <div class="hero-badge">
            <div class="hero-badge-dot"></div>
            <?= $active_services ?> Layanan Aktif • <?= $total_premium ?> Premium
        </div>

        <h1>Platform Layanan <span class="highlight">Digital</span> Premium</h1>

        <p class="hero-subtitle">
            Temukan berbagai layanan digital gratis & premium untuk kebutuhan Anda. Dari bot WhatsApp hingga tools lengkap.
        </p>

        <div class="trust-badges">
            <div class="trust-item gratis"><i class="fas fa-check-circle"></i> 100% Gratis</div>
            <div class="trust-item instan"><i class="fas fa-bolt"></i> Akses Instan</div>
            <div class="trust-item pro"><i class="fas fa-crown"></i> Premium Tersedia</div>
            <div class="trust-item aman"><i class="fas fa-shield-alt"></i> Aman & Terpercaya</div>
        </div>
    </div>
</section>

<!-- ============================================================
     CAROUSEL PREMIUM
     ============================================================ -->
<?php if (count($premium_services) > 0): ?>
<section class="carousel-section" id="premium">
    <div class="container">
        <div class="carousel-header">
            <div class="section-title">✨ Layanan Premium</div>
            <div class="section-subtitle">
                <span><?= $total_premium ?></span> layanan premium dengan fitur eksklusif untuk kebutuhan profesional
            </div>
        </div>

        <div class="carousel-wrapper">
            <button class="carousel-btn prev" id="carouselPrev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="carousel-track" id="carouselTrack">
                <?php foreach ($premium_services as $index => $service): ?>
                <div class="carousel-card <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                    <!-- Thumbnail / Webview Mini -->
                    <div class="carousel-thumbnail">
                        <?php if ($service['thumbnail'] === 'hosting'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fas fa-server"></i>
                                <span>Premium Hosting</span>
                            </div>
                        <?php elseif ($service['thumbnail'] === 'domain'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fas fa-globe"></i>
                                <span>Domain .com</span>
                            </div>
                        <?php elseif ($service['thumbnail'] === 'api'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fas fa-code"></i>
                                <span>API Premium</span>
                            </div>
                        <?php elseif ($service['thumbnail'] === 'bot'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fab fa-whatsapp"></i>
                                <span>Bot Pro</span>
                            </div>
                        <?php elseif ($service['thumbnail'] === 'storage'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fas fa-cloud"></i>
                                <span>Cloud Storage</span>
                            </div>
                        <?php elseif ($service['thumbnail'] === 'cdn'): ?>
                            <div class="thumbnail-placeholder">
                                <i class="fas fa-network-wired"></i>
                                <span>CDN Premium</span>
                            </div>
                        <?php else: ?>
                            <div class="thumbnail-placeholder">
                                <i class="<?= $service['icon'] ?>"></i>
                                <span><?= $service['name'] ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="premium-badge">★ Premium</div>
                    </div>

                    <div class="carousel-card-icon">
                        <i class="<?= $service['icon'] ?>"></i>
                    </div>
                    <div class="carousel-card-title"><?= $service['name'] ?></div>
                    <div class="carousel-card-desc"><?= strip_tags($service['desc']) ?></div>
                    
                    <div class="carousel-card-price">
                        <span class="price-original"><?= $service['price_original'] ?? '' ?></span>
                        <?= $service['price'] ?? 'Hubungi' ?>
                    </div>
                    
                    <a href="<?= $service['url'] ?>" target="<?= $service['target'] ?>" class="btn-small">
                        <i class="fas fa-crown"></i> Beli Sekarang
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-btn next" id="carouselNext" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="carousel-dots" id="carouselDots">
            <?php foreach ($premium_services as $index => $service): ?>
            <button class="carousel-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     STATS
     ============================================================ -->
<div class="container">
    <div class="stats-strip">
        <div class="strip-item">
            <div class="strip-number"><?= $total_services ?></div>
            <div class="strip-label">Total Layanan</div>
        </div>
        <div class="strip-item">
            <div class="strip-number"><?= $total_free ?></div>
            <div class="strip-label">Layanan Gratis</div>
        </div>
        <div class="strip-item">
            <div class="strip-number"><?= $total_premium ?></div>
            <div class="strip-label">Layanan Premium</div>
        </div>
        <div class="strip-item">
            <div class="strip-number">10k+</div>
            <div class="strip-label">Pengguna</div>
        </div>
    </div>
</div>

<!-- ============================================================
     SEARCH + FREE LAYANAN GRID
     ============================================================ -->
<section class="services-section container" id="services">
    <div class="section-header">
        <div class="section-title">🎯 Layanan Gratis</div>
        <div class="section-subtitle">
            <span><?= $total_free ?></span> layanan gratis siap pakai untuk kebutuhan digital Anda
        </div>
    </div>

    <!-- Search Box -->
    <div class="search-section">
        <form class="search-box" method="GET" action="">
            <input type="text" name="q" placeholder="Cari layanan... (contoh: downloader, ceknik, bot)" value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
            <a href="?q=" style="display:flex;align-items:center;padding:0 12px;color:var(--black);text-decoration:none;font-weight:700;font-size:1.2rem;">✕</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Grid Layanan Free -->
    <?php if (count($sorted_services) > 0): ?>
    <div class="services-grid" id="servicesGrid">
        <?php foreach ($sorted_services as $service): ?>
        <div class="service-card type-<?= $service['type'] ?>" data-aos="fade-up" data-service="<?= $service['id'] ?>">
            
            <?php if (!empty($service['badge'])): ?>
            <div class="service-badge <?= $service['badge_type'] ?>">
                <?= $service['badge'] ?>
            </div>
            <?php endif; ?>

            <div class="service-icon">
                <i class="<?= $service['icon'] ?>"></i>
            </div>

            <div class="service-name"><?= $service['name'] ?></div>
            <div class="service-desc"><?= $service['desc'] ?></div>

            <?php if (!empty($service['tags'])): ?>
            <div class="service-tags">
                <?php foreach (array_slice($service['tags'], 0, 4) as $tag): ?>
                <span class="service-tag"><i class="fas fa-tag"></i> <?= $tag ?></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="service-meta">
                <span class="status-<?= $service['status_type'] ?>">
                    <i class="fas fa-circle"></i> <?= $service['status'] ?>
                </span>
                <span>
                    <i class="fas fa-users"></i> <?= $service['users'] ?>
                </span>
            </div>

            <?php if (!empty($service['url']) && $service['url'] !== '#'): ?>
            <a href="<?= $service['url'] ?>" target="<?= $service['target'] ?>" class="service-btn">
                <i class="fas fa-arrow-right"></i> Akses Layanan
            </a>
            <?php else: ?>
            <button class="service-btn" style="opacity:0.6;cursor:not-allowed;" disabled>
                <i class="fas fa-clock"></i> Segera Hadir
            </button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="no-result show">
        <i class="fas fa-search"></i>
        <h3>Layanan tidak ditemukan</h3>
        <p>Maaf, tidak ada layanan yang cocok dengan pencarian "<strong><?= htmlspecialchars($search) ?></strong>".</p>
        <br>
        <a href="?" class="btn btn-secondary" style="display:inline-flex;">Lihat Semua Layanan</a>
    </div>
    <?php endif; ?>

    <div style="text-align:center;margin-top:24px;font-weight:600;color:#666;font-size:0.85rem;">
        Menampilkan <?= count($sorted_services) ?> dari <?= $total_free ?> layanan gratis
        <?php if (!empty($search)): ?>
        untuk pencarian "<strong><?= htmlspecialchars($search) ?></strong>"
        <?php endif; ?>
    </div>
</section>

<!-- ============================================================
     CUSTOM SECTION
     ============================================================ -->
<section class="custom-section container" data-aos="fade-up">
    <div style="background:var(--white);border:var(--border-thick);box-shadow:var(--shadow-heavy);padding:28px 20px;text-align:center;">
        <h3 style="font-family:var(--font-display);text-transform:uppercase;font-weight:900;font-size:1.2rem;">
            <i class="fas fa-rocket" style="color:var(--primary);"></i> Butuh layanan khusus?
        </h3>
        <p style="font-weight:500;color:#444;margin:8px 0 16px;">
            Kami siap membantu kebutuhan digital Anda. Hubungi kami untuk custom solution.
        </p>
        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-primary" style="display:inline-flex;">
            <i class="fab fa-whatsapp"></i> Hubungi Kami
        </a>
    </div>
</section>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="testimonials-section" data-aos="fade-up">
    <div class="container">
        <div class="section-header">
            <div class="section-title">💬 Testimoni</div>
            <div class="section-subtitle">Apa kata mereka tentang layanan kami</div>
        </div>

        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Jadibot WhatsApp-nya sangat mudah digunakan. Premium hosting juga kencang banget!"</div>
                <div class="testi-name">— Andi Setiawan</div>
            </div>
            <div class="testi-card">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Tools collection lengkap banget. Ada Ceknik, YouTube & TikTok downloader, semua gratis dan cepat!"</div>
                <div class="testi-name">— Budi Santoso</div>
            </div>
            <div class="testi-card">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Layanan premium sangat worth it. Support cepat dan fitur lengkap. Highly recommended!"</div>
                <div class="testi-name">— Citra Dewi</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     FAQ
     ============================================================ -->
<section class="faq-section container" data-aos="fade-up" id="faq">
    <div class="section-header">
        <div class="section-title">❓ FAQ</div>
        <div class="section-subtitle">Jawaban untuk pertanyaan yang sering diajukan</div>
    </div>

    <div class="faq-grid">
        <div class="faq-item">
            <div class="faq-question"><span>❓ Apa itu Polar.id?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Platform layanan digital terpercaya yang menyediakan berbagai solusi gratis & premium seperti bot WhatsApp, tools (Ceknik, YouTube/TikTok Downloader), hosting, domain, dan lainnya.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🔗 Apa perbedaan layanan gratis dan premium?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Layanan gratis dapat diakses tanpa biaya dengan fitur standar. Layanan premium menawarkan fitur eksklusif, performa lebih tinggi, dan support prioritas dengan harga terjangkau.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🛡️ Apakah aman menggunakan layanan ini?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Sangat aman. Data Anda terenkripsi dan kami tidak menyimpan informasi sensitif pengguna.</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>🎥 Apa saja yang ada di Tools Collection?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Tools Collection menyediakan berbagai alat digital seperti Ceknik (Cek NIK KTP), YouTube Downloader, TikTok Downloader, QR Code Generator, Password Generator, dan masih banyak lagi!</div>
        </div>
        <div class="faq-item">
            <div class="faq-question"><span>💳 Bagaimana cara membeli layanan premium?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Cukup pilih layanan premium dari carousel di atas, klik tombol "Beli Sekarang", dan ikuti petunjuk pembayaran yang tersedia.</div>
        </div>
    </div>
</section>

<!-- ============================================================
     CTA
     ============================================================ -->
<div class="cta-wrapper container" data-aos="fade-up">
    <div class="cta-box">
        <h2>🚀 Siap memulai?</h2>
        <p>Jelajahi semua layanan digital kami. Gratis, cepat, dan premium tersedia.</p>
        <a href="#services" class="btn-cta">
            <i class="fas fa-arrow-down"></i> Lihat Semua Layanan
        </a>
    </div>
</div>

<!-- BACK TO TOP -->
<button class="back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-col">
                <h4>Polar.id</h4>
                <p style="font-weight:500;">Platform layanan digital premium terpercaya untuk berbagai kebutuhan Anda.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <?php foreach (array_slice($services, 0, 4) as $s): ?>
                <a href="<?= $s['url'] ?>" target="<?= $s['target'] ?>"><?= $s['name'] ?></a>
                <?php endforeach; ?>
                <a href="#premium">✨ Premium</a>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <a href="index.php">Beranda</a>
                <a href="#services">Layanan</a>
                <a href="#premium">Premium</a>
                <a href="#faq">FAQ</a>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <p><i class="fab fa-whatsapp" style="color:#25D366;"></i> +62 812-3456-7890</p>
                <p><i class="fas fa-envelope"></i> support@polar.web.id</p>
            </div>
        </div>
        <div class="footer-bottom">
            © <?= date('Y') ?> Polar.id. All rights reserved. Made with ❤️
        </div>
    </div>
</footer>

<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // ============================================================
    // SPLASH SCREEN
    // ============================================================
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('splash')?.classList.add('hide');
        }, 1800);
    });

    // ============================================================
    // PROGRESS BAR + BACK TO TOP
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
    // FAQ ACCORDION
    // ============================================================
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) {
                item.classList.add('open');
            }
        });
    });
    document.querySelector('.faq-item')?.classList.add('open');

    // ============================================================
    // CAROUSEL PREMIUM
    // ============================================================
    (function initCarousel() {
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('carouselPrev');
        const nextBtn = document.getElementById('carouselNext');
        const dots = document.querySelectorAll('.carousel-dot');
        const cards = document.querySelectorAll('.carousel-card');
        let currentIndex = 0;
        const totalSlides = cards.length;

        if (totalSlides === 0) return;

        const updateCarousel = (index) => {
            // Update cards
            cards.forEach((card, i) => {
                card.classList.toggle('active', i === index);
            });

            // Update dots
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            // Scroll track
            const cardWidth = cards[0].offsetWidth + 24; // width + gap
            const offset = index * cardWidth;
            track.style.transform = `translateX(-${offset}px)`;
        };

        const goTo = (index) => {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentIndex = index;
            updateCarousel(currentIndex);
        };

        // Event listeners
        prevBtn?.addEventListener('click', () => goTo(currentIndex - 1));
        nextBtn?.addEventListener('click', () => goTo(currentIndex + 1));

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => goTo(i));
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goTo(currentIndex - 1);
            if (e.key === 'ArrowRight') goTo(currentIndex + 1);
        });

        // Auto play (pause on hover)
        let autoPlayInterval = setInterval(() => goTo(currentIndex + 1), 4000);
        const carouselWrapper = document.querySelector('.carousel-wrapper');
        carouselWrapper?.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
        carouselWrapper?.addEventListener('mouseleave', () => {
            autoPlayInterval = setInterval(() => goTo(currentIndex + 1), 4000);
        });

        // Update on resize
        window.addEventListener('resize', () => updateCarousel(currentIndex));
    })();

    // ============================================================
    // AOS INIT
    // ============================================================
    AOS.init({ 
        duration: 500, 
        once: true,
        offset: 50
    });

    // ============================================================
    // SMOOTH SCROLL
    // ============================================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ============================================================
    // KEYBOARD SHORTCUT: Ctrl+/ untuk search
    // ============================================================
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === '/') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-box input');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
    });
</script>
</body>
</html>
