<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id - Platform Layanan Digital Gratis</title>
    <meta name="title" content="Polar.id - Platform Layanan Digital Gratis Terpercaya" />
    <meta name="description" content="Platform layanan digital 100% gratis: Jadibot WhatsApp, Tools (Ceknik, YouTube & TikTok Downloader), dan berbagai solusi digital lainnya." />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta property="og:title" content="Polar.id - Platform Layanan Digital Gratis">
    <meta property="og:url" content="https://polar.web.id">
    <meta property="og:image" content="https://polar.web.id/og-image.jpg">
    <meta property="og:description" content="Platform layanan digital 100% gratis: Jadibot WhatsApp, Tools, dan berbagai solusi digital lainnya.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* ============================================================
           ULTRA PREMIUM NEO-BRUTALISM (100% GRATIS EDITION)
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--font-body);
            background: var(--bg-body);
            color: var(--text-body);
            line-height: 1.6;
            min-height: 100vh;
            padding: 16px;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: var(--font-display);
            font-weight: 900;
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        ::-webkit-scrollbar { width: 12px; background: var(--black); }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, var(--primary), var(--purple)); border: 2px solid var(--black); }
        ::-webkit-scrollbar-track { background: var(--off-white); border-left: 2px solid var(--black); }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 12px; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 12px;
            font-family: var(--font-display); font-weight: 800; font-size: 1rem;
            text-transform: uppercase; padding: 14px 32px; border: var(--border-thick);
            box-shadow: var(--shadow-heavy); background: var(--white); color: var(--black);
            cursor: pointer; transition: all 0.15s ease; text-decoration: none;
            letter-spacing: 0.3px; position: relative; overflow: hidden;
        }
        .btn::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .btn:hover::before { left: 100%; }
        .btn:hover { transform: translate(4px, 4px); box-shadow: none; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--purple)); color: var(--white); border-color: var(--black); }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-dark), var(--purple)); }
        .btn-secondary { background: var(--black); color: var(--white); border-color: var(--black); }
        .btn-secondary:hover { background: #1a1a1a; }

        /* ---- SPLASH SCREEN ---- */
        #splash {
            position: fixed; inset: 0; z-index: 9999; background: var(--black);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 28px; transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        #splash.hide { opacity: 0; visibility: hidden; pointer-events: none; }

        .splash-container {
            display: flex; flex-direction: column; align-items: center; gap: 24px;
            animation: splashFloat 2s ease-in-out infinite;
        }
        @keyframes splashFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .splash-logo {
            width: 120px; height: 120px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--purple), var(--secondary));
            display: flex; align-items: center; justify-content: center; font-size: 48px; color: var(--white);
            border: 5px solid var(--white); box-shadow: 0 0 0 4px var(--black), 0 0 60px rgba(255, 0, 85, 0.3);
            animation: logoPulse 2s ease-in-out infinite;
            position: relative;
        }
        .splash-logo::after {
            content: ''; position: absolute; inset: -8px; border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.1);
            animation: logoRipple 2s ease-in-out infinite;
        }
        @keyframes logoRipple {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0; }
        }
        @keyframes logoPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.05) rotate(-3deg); }
        }

        .splash-name {
            font-family: var(--font-display); font-size: 2.8rem; font-weight: 900;
            color: var(--white); text-transform: uppercase; letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--white), var(--secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .splash-spinner {
            width: 50px; height: 50px; border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid var(--primary); border-right: 4px solid var(--secondary);
            border-radius: 50%; animation: spin 0.9s cubic-bezier(0.65, 0, 0.35, 1) infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .splash-sub {
            color: #888; font-weight: 500; font-size: 0.9rem; letter-spacing: 3px; text-transform: uppercase;
            animation: textPulse 2s ease-in-out infinite;
        }
        @keyframes textPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .splash-progress {
            width: 240px; height: 4px; background: #222; border-radius: 4px; overflow: hidden;
            position: relative;
        }
        .splash-progress-bar {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--purple), var(--green));
            animation: loadProgress 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            position: relative;
        }
        .splash-progress-bar::after {
            content: ''; position: absolute; top: 0; right: 0; width: 20px; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3));
        }
        @keyframes loadProgress {
            0% { width: 0%; }
            20% { width: 15%; }
            50% { width: 45%; }
            75% { width: 78%; }
            100% { width: 100%; }
        }

        .splash-particles {
            position: absolute; inset: 0; overflow: hidden; pointer-events: none;
        }
        .splash-particle {
            position: absolute; width: 6px; height: 6px; background: var(--primary);
            border-radius: 50%; opacity: 0.3; animation: particleFloat 3s infinite alternate;
        }
        @keyframes particleFloat {
            0% { transform: translateY(0) scale(1); opacity: 0.3; }
            100% { transform: translateY(-100px) scale(0); opacity: 0; }
        }

        /* ---- PROGRESS BAR ---- */
        .progress-container { position: fixed; top: 0; left: 0; width: 100%; height: 6px; z-index: 1000; background: transparent; }
        .progress-bar { height: 100%; width: 0%; background: linear-gradient(90deg, var(--primary), var(--secondary), var(--purple)); border-bottom: var(--border-thick); transition: width 0.15s ease; position: relative; }
        .progress-bar::after {
            content: ''; position: absolute; top: 0; right: 0; width: 40px; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3));
            animation: progressGlow 1.5s infinite;
        }
        @keyframes progressGlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        /* ---- HERO ---- */
        .hero { padding: 30px 0 50px; border-bottom: var(--border-thick); margin-bottom: 16px; position: relative; overflow: hidden; background: linear-gradient(180deg, var(--white) 0%, var(--off-white) 100%); }
        .hero::before {
            content: ''; position: absolute; top: -50%; right: -20%; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(255, 0, 85, 0.06), transparent 70%);
            border-radius: 50%; pointer-events: none; animation: heroGlow1 8s ease-in-out infinite alternate;
        }
        .hero::after {
            content: ''; position: absolute; bottom: -30%; left: -10%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.04), transparent 70%);
            border-radius: 50%; pointer-events: none; animation: heroGlow2 10s ease-in-out infinite alternate;
        }
        @keyframes heroGlow1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -20px) scale(1.2); }
        }
        @keyframes heroGlow2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-20px, 30px) scale(1.3); }
        }

        .hero-content { max-width: 820px; margin: 0 auto; text-align: center; position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 10px; background: var(--black); color: var(--white);
            font-family: var(--font-display); font-weight: 800; font-size: 0.8rem; text-transform: uppercase;
            padding: 8px 20px; border: var(--border-thick); margin-bottom: 24px; letter-spacing: 0.5px;
            animation: badgePulse 3s ease-in-out infinite; position: relative;
        }
        .hero-badge::before {
            content: ''; position: absolute; inset: -2px; border: 2px solid transparent;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--purple)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor; mask-composite: exclude;
            animation: badgeBorder 4s linear infinite;
        }
        @keyframes badgeBorder {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }
        @keyframes badgePulse {
            0%, 100% { box-shadow: var(--shadow-light); }
            50% { box-shadow: 0 0 0 4px var(--green), 4px 4px 0 4px var(--black); }
        }
        .hero-badge-dot { width: 12px; height: 12px; background: var(--green); border: 2px solid var(--white); border-radius: 50%; animation: dotPulse 1.5s ease-in-out infinite; }
        @keyframes dotPulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.3; transform: scale(0.8); } }

        .hero h1 {
            font-size: clamp(2.8rem, 7vw, 5rem); line-height: 1.05; margin-bottom: 16px; color: var(--black);
            animation: heroTitle 1.2s ease forwards;
        }
        @keyframes heroTitle {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--yellow), var(--gold)); padding: 0 10px; display: inline-block;
            transform: rotate(-0.5deg); border: var(--border-thick); box-shadow: var(--shadow-heavy); position: relative;
            animation: highlightGlow 3s ease-in-out infinite alternate;
        }
        @keyframes highlightGlow {
            0% { box-shadow: var(--shadow-heavy); }
            100% { box-shadow: 0 0 30px rgba(255, 221, 0, 0.3), var(--shadow-heavy); }
        }
        .hero h1 .highlight::after { content: '✦'; position: absolute; top: -20px; right: -20px; font-size: 1.2rem; transform: rotate(15deg); animation: starSpin 10s linear infinite; }
        @keyframes starSpin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .hero-subtitle {
            font-size: clamp(1rem, 1.6vw, 1.25rem); font-weight: 600; color: #1a1a1a;
            max-width: 520px; margin: 0 auto 32px; line-height: 1.5;
            animation: fadeUp 1.4s ease 0.2s both;
        }
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .trust-badges { display: flex; flex-wrap: wrap; justify-content: center; gap: 16px 28px; margin-top: 16px; animation: fadeUp 1.6s ease 0.4s both; }
        .trust-item {
            display: flex; align-items: center; gap: 8px; font-family: var(--font-display); font-weight: 800;
            font-size: 0.85rem; text-transform: uppercase; padding: 8px 16px; background: var(--white);
            border: var(--border-thick); box-shadow: var(--shadow-light); transition: all 0.25s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        .trust-item::after {
            content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, var(--primary), var(--purple));
            opacity: 0; transition: opacity 0.3s ease;
        }
        .trust-item:hover { transform: translate(3px, 3px) scale(1.05); box-shadow: none; background: var(--black); color: var(--white); }
        .trust-item:hover i { color: var(--white); }
        .trust-item i { position: relative; z-index: 1; transition: color 0.3s ease; }
        .trust-item span { position: relative; z-index: 1; }
        .trust-item.gratis i { color: var(--green); }
        .trust-item.instan i { color: var(--secondary); }
        .trust-item.aman i { color: var(--purple); }
        .trust-item.opensource i { color: var(--primary); }

        /* ---- CAROUSEL LAYANAN ---- */
        .carousel-section {
            padding: 40px 0 30px; background: var(--black); border-top: var(--border-thick);
            border-bottom: var(--border-thick); margin: 12px 0; position: relative; overflow: hidden;
        }
        .carousel-section::before {
            content: '✦'; position: absolute; top: -30px; right: -20px; font-size: 10rem;
            color: rgba(255,255,255,0.03); transform: rotate(20deg);
            animation: floatBg 20s linear infinite;
        }
        @keyframes floatBg {
            0% { transform: rotate(0deg) translate(0, 0); }
            100% { transform: rotate(360deg) translate(20px, -20px); }
        }

        .carousel-header { text-align: center; margin-bottom: 30px; position: relative; z-index: 1; }
        .carousel-header .section-title { color: var(--white); }
        .carousel-header .section-title::after { background: var(--green); }
        .carousel-header .section-subtitle { color: #aaa; }
        .carousel-header .section-subtitle span { background: var(--green); color: var(--black); }

        .carousel-wrapper { position: relative; overflow: hidden; padding: 0 40px; }
        .carousel-track { display: flex; gap: 24px; transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); will-change: transform; }
        .carousel-card {
            min-width: 300px; max-width: 320px; flex-shrink: 0; background: var(--white);
            border: var(--border-thick); box-shadow: var(--shadow-heavy); padding: 20px 20px 24px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative; transform: scale(0.92); opacity: 0.5; cursor: pointer;
            display: flex; flex-direction: column;
        }
        .carousel-card.active {
            transform: scale(1); opacity: 1; box-shadow: var(--shadow-2xl);
            animation: cardPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes cardPop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .carousel-card:hover { transform: translate(4px, 4px) scale(1.02); box-shadow: none; }
        .carousel-card.active:hover { transform: translate(4px, 4px); box-shadow: none; }

        /* Thumbnail Mini Webview */
        .carousel-thumbnail {
            width: 100%; height: 150px; background: var(--off-white); border: var(--border-thick);
            margin-bottom: 14px; overflow: hidden; position: relative; display: flex;
            align-items: center; justify-content: center;
        }
        .carousel-thumbnail iframe {
            width: 400%; height: 400%; border: none; transform: scale(0.25); transform-origin: top left;
            pointer-events: none; background: var(--white);
            transition: opacity 0.5s ease;
        }
        .carousel-thumbnail .thumbnail-placeholder {
            position: absolute; inset: 0; font-size: 2.6rem; opacity: 0.25; display: flex;
            flex-direction: column; align-items: center; justify-content: center; gap: 8px; color: var(--gray);
            background: var(--off-white); z-index: 0;
        }
        .carousel-thumbnail .thumbnail-placeholder span { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; font-family: var(--font-display); }
        .carousel-thumbnail .live-badge {
            position: absolute; top: 8px; right: 8px; background: var(--green); color: var(--black);
            font-family: var(--font-display); font-weight: 800; font-size: 0.6rem; text-transform: uppercase;
            padding: 2px 10px; border: 2px solid var(--black); z-index: 2; display: flex; align-items: center; gap: 4px;
            animation: badgePulse 2s ease-in-out infinite;
        }
        .carousel-thumbnail .live-badge .dot { width: 6px; height: 6px; background: var(--black); border-radius: 50%; animation: dotPulse 1.5s ease-in-out infinite; }

        .carousel-card-icon {
            font-size: 1.6rem; margin-bottom: 4px; display: inline-block;
            animation: iconFloat 3s ease-in-out infinite;
        }
        @keyframes iconFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .carousel-card-title { font-family: var(--font-display); font-weight: 900; font-size: 1.15rem; text-transform: uppercase; color: var(--black); }
        .carousel-card-desc { font-size: 0.82rem; font-weight: 500; color: #444; margin: 4px 0 8px; flex: 1; line-height: 1.5; }
        .carousel-card-desc .highlight-tag {
            display: inline-block; background: var(--yellow); padding: 0 4px; font-weight: 700;
            border: 2px solid var(--black); font-size: 0.68rem;
            animation: tagPop 2s ease-in-out infinite;
        }
        @keyframes tagPop {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .carousel-card-tags { display: flex; flex-wrap: wrap; gap: 6px; margin: 4px 0 10px; }
        .carousel-card-tag {
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase; padding: 2px 10px;
            background: var(--off-white); border: 2px solid var(--black); font-family: var(--font-display);
            transition: all 0.3s ease;
        }
        .carousel-card-tag:hover {
            background: var(--black); color: var(--white); transform: scale(1.05);
        }

        .carousel-card-meta {
            display: flex; align-items: center; gap: 12px; font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; color: var(--gray); margin-bottom: 12px; font-family: var(--font-display);
        }
        .carousel-card-meta .status-online { color: #0a8a4a; }
        .carousel-card-meta .status-maintenance { color: var(--orange); }
        .carousel-card-meta .status-offline { color: var(--gray); }

        .carousel-card .btn-small {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: var(--font-display); font-weight: 800; font-size: 0.75rem; text-transform: uppercase;
            padding: 10px 18px; border: var(--border-thick); background: var(--black); color: var(--white);
            text-decoration: none; transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94); width: 100%;
            position: relative; overflow: hidden;
        }
        .carousel-card .btn-small::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }
        .carousel-card .btn-small:hover::before { left: 100%; }
        .carousel-card .btn-small:hover { transform: translate(3px, 3px); box-shadow: none; background: var(--green); color: var(--black); }

        .carousel-btn {
            position: absolute; top: 50%; transform: translateY(-50%); width: 48px; height: 48px;
            background: var(--white); border: var(--border-thick); box-shadow: var(--shadow-heavy); color: var(--black);
            font-size: 1.2rem; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .carousel-btn:hover { transform: translateY(-50%) translate(3px, 3px); box-shadow: none; background: var(--primary); color: var(--white); }
        .carousel-btn.prev { left: 0; }
        .carousel-btn.next { right: 0; }

        .carousel-dots { display: flex; justify-content: center; gap: 10px; margin-top: 24px; position: relative; z-index: 1; }
        .carousel-dot {
            width: 14px; height: 14px; border: var(--border-thick); background: var(--white);
            cursor: pointer; transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); opacity: 0.4;
            position: relative;
        }
        .carousel-dot.active {
            background: var(--green); opacity: 1; transform: scale(1.3);
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.3);
        }
        .carousel-dot:hover { opacity: 0.8; transform: scale(1.1); }

        /* ---- SEARCH ---- */
        .search-section { padding: 20px 0 10px; }
        .search-box {
            max-width: 520px; margin: 0 auto; display: flex; gap: 8px; background: var(--white);
            border: var(--border-thick); box-shadow: var(--shadow-heavy); padding: 4px; transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        .search-box::before {
            content: ''; position: absolute; inset: -2px; z-index: -1;
            background: linear-gradient(135deg, var(--primary), var(--purple), var(--secondary));
            opacity: 0; transition: opacity 0.3s ease;
        }
        .search-box:focus-within::before { opacity: 1; }
        .search-box:focus-within { box-shadow: var(--shadow-xl); transform: translate(-2px, -2px); }
        .search-box input {
            flex: 1; border: none; padding: 14px 18px; font-family: var(--font-body);
            font-weight: 500; font-size: 1rem; background: transparent; outline: none; color: var(--black);
        }
        .search-box input::placeholder { color: var(--gray); font-weight: 500; }
        .search-box button {
            padding: 12px 20px; background: var(--black); color: var(--white); border: none;
            font-size: 1.2rem; cursor: pointer; transition: all 0.3s ease;
        }
        .search-box button:hover { background: linear-gradient(135deg, var(--primary), var(--purple)); transform: scale(1.05) rotate(-5deg); }

        .section-header { text-align: center; margin-bottom: 40px; }
        .section-title {
            font-family: var(--font-display); font-size: clamp(2rem, 4vw, 2.5rem); font-weight: 900;
            text-transform: uppercase; letter-spacing: -0.02em; color: var(--black); margin-bottom: 8px;
            position: relative; display: inline-block;
        }
        .section-title::after {
            content: ''; position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%);
            width: 60%; height: 4px; background: linear-gradient(90deg, var(--primary), var(--purple)); border: 2px solid var(--black);
            animation: titleUnderline 2s ease-in-out infinite alternate;
        }
        @keyframes titleUnderline {
            0% { width: 60%; }
            100% { width: 100%; }
        }
        .section-subtitle { font-size: 1.05rem; font-weight: 500; color: #444; max-width: 500px; margin: 16px auto 0; }
        .section-subtitle span { background: var(--yellow); padding: 0 6px; font-weight: 800; border: 2px solid var(--black); }

        /* ---- STATS ---- */
        .stats-strip {
            display: grid; grid-template-columns: repeat(3, 1fr);
            border: var(--border-thick); background: var(--white); margin: 12px 0 24px;
            box-shadow: var(--shadow-light); overflow: hidden;
        }
        .strip-item {
            padding: 18px 8px; text-align: center; border-right: var(--border-thick);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
        }
        .strip-item::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--purple));
            opacity: 0; transition: opacity 0.3s ease;
        }
        .strip-item:hover::before { opacity: 0.05; }
        .strip-item:hover { transform: scale(1.02); background: var(--off-white); }
        .strip-item:last-child { border-right: none; }
        .strip-number {
            font-family: var(--font-display); font-size: 2rem; font-weight: 900;
            color: var(--black); line-height: 1.1;
            position: relative;
            animation: countUp 1.5s ease forwards;
        }
        @keyframes countUp {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }
        .strip-label { font-family: var(--font-display); font-weight: 800; font-size: 0.7rem; text-transform: uppercase; color: #444; letter-spacing: 0.3px; }

        /* ---- TESTIMONIALS ---- */
        .testimonials-section { background: var(--white); border-top: var(--border-thick); border-bottom: var(--border-thick); padding: 40px 0; margin: 12px 0; }
        .testi-grid { display: grid; grid-template-columns: 1fr; gap: 16px; margin-top: 24px; }
        @media (min-width: 768px) { .testi-grid { grid-template-columns: repeat(3, 1fr); } }
        .testi-card {
            background: var(--off-white); border: var(--border-thick); padding: 18px 22px;
            box-shadow: var(--shadow-light); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative; overflow: hidden;
        }
        .testi-card::before {
            content: '"'; position: absolute; top: -10px; right: 10px; font-size: 6rem;
            opacity: 0.05; font-family: var(--font-display);
        }
        .testi-card:hover { transform: translate(3px, 3px) scale(1.02); box-shadow: none; background: var(--white); }
        .testi-avatar {
            font-size: 1.6rem; margin-bottom: 4px;
            animation: avatarFloat 3s ease-in-out infinite;
        }
        @keyframes avatarFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-5px) rotate(5deg); }
        }
        .testi-rating { color: var(--gold); font-size: 1rem; letter-spacing: 1px; margin-bottom: 4px; }
        .testi-text { font-size: 0.95rem; font-weight: 500; font-style: italic; color: #1a1a1a; margin-bottom: 6px; }
        .testi-name { font-family: var(--font-display); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; }

        /* ---- FAQ ---- */
        .faq-section { padding: 40px 0 50px; }
        .faq-grid { display: flex; flex-direction: column; gap: 10px; max-width: 720px; margin: 0 auto; }
        .faq-item {
            background: var(--white); border: var(--border-thick); box-shadow: var(--shadow-light);
            overflow: hidden; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .faq-item:hover { box-shadow: var(--shadow-heavy); }
        .faq-question {
            padding: 14px 18px; font-family: var(--font-display); font-weight: 800; font-size: 1rem; text-transform: uppercase;
            display: flex; justify-content: space-between; align-items: center; cursor: pointer;
            background: var(--white); border-bottom: 2px solid transparent; transition: all 0.3s ease;
        }
        .faq-question:hover { background: var(--off-white); }
        .faq-question i { font-size: 1rem; transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); }
        .faq-item.open .faq-question {
            border-bottom: var(--border-thick);
            background: linear-gradient(135deg, var(--black), #1a1a1a);
            color: var(--white);
        }
        .faq-item.open .faq-question i { transform: rotate(180deg); }
        .faq-answer {
            padding: 0 18px; max-height: 0; overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 500; color: #1a1a1a;
        }
        .faq-item.open .faq-answer { padding: 14px 18px; max-height: 200px; }

        /* ---- CTA ---- */
        .cta-wrapper { padding: 24px 0 32px; }
        .cta-box {
            background: linear-gradient(135deg, var(--black), #1a1a1a); border: var(--border-thick);
            box-shadow: var(--shadow-heavy); padding: 40px 20px; text-align: center;
            color: var(--white); position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: '✦'; position: absolute; top: -30px; right: -10px; font-size: 10rem;
            color: rgba(255,255,255,0.03); transform: rotate(15deg);
            animation: ctaFloat 10s linear infinite;
        }
        @keyframes ctaFloat {
            0% { transform: rotate(0deg) translate(0, 0); }
            100% { transform: rotate(360deg) translate(-10px, -10px); }
        }
        .cta-box::after {
            content: ''; position: absolute; bottom: -50%; left: -20%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(0, 255, 136, 0.06), transparent 70%);
            border-radius: 50%; pointer-events: none;
            animation: ctaGlow 6s ease-in-out infinite alternate;
        }
        @keyframes ctaGlow {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.3); opacity: 1; }
        }
        .cta-box h2 { font-size: clamp(1.8rem, 3vw, 2.2rem); color: var(--white); margin-bottom: 8px; position: relative; z-index: 1; }
        .cta-box p { font-weight: 500; font-size: 1rem; color: #bbb; margin-bottom: 20px; max-width: 460px; margin-left: auto; margin-right: auto; position: relative; z-index: 1; }
        .cta-box .btn-cta {
            background: linear-gradient(135deg, var(--green), #00cc6a); color: var(--black);
            border-color: var(--white); display: inline-flex; align-items: center; gap: 12px;
            font-family: var(--font-display); font-weight: 800; font-size: 1rem; text-transform: uppercase;
            padding: 14px 32px; border: var(--border-thick); box-shadow: var(--shadow-heavy);
            cursor: pointer; transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none; position: relative; z-index: 1;
        }
        .cta-box .btn-cta:hover { background: var(--white); transform: translate(4px, 4px) scale(1.05); box-shadow: none; }

        /* ---- BACK TO TOP ---- */
        .back-to-top {
            position: fixed; bottom: 24px; left: 24px; width: 50px; height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--purple)); color: var(--white);
            border: var(--border-thick); box-shadow: var(--shadow-heavy); font-size: 1.2rem;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 150; border-radius: 50%;
        }
        .back-to-top.show {
            opacity: 1; visibility: visible;
            animation: bounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes bounceIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
        .back-to-top:hover { transform: translate(4px, 4px) scale(1.1); box-shadow: none; background: var(--black); color: var(--white); }

        /* ---- FOOTER ---- */
        footer { border-top: var(--border-thick); background: var(--white); padding: 32px 0 20px; margin-top: 12px; }
        .footer-content { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .footer-col h4 { font-family: var(--font-display); font-size: 1rem; font-weight: 900; text-transform: uppercase; margin-bottom: 8px; color: var(--black); position: relative; display: inline-block; }
        .footer-col h4::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 30px; height: 3px; background: linear-gradient(90deg, var(--primary), var(--purple)); border: 1px solid var(--black); }
        .footer-col p, .footer-col a { font-size: 0.9rem; font-weight: 500; color: #1a1a1a; text-decoration: none; display: block; margin-bottom: 4px; transition: all 0.3s ease; }
        .footer-col a:hover { color: var(--primary); transform: translateX(4px); }
        .footer-social { display: flex; gap: 12px; margin-top: 8px; }
        .footer-social a {
            display: flex; align-items: center; justify-content: center; width: 40px; height: 40px;
            border: var(--border-thick); background: var(--black); color: var(--white);
            font-size: 1.1rem; transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .footer-social a:hover {
            background: linear-gradient(135deg, var(--primary), var(--purple));
            transform: translate(3px, 3px) scale(1.1); box-shadow: none; text-decoration: none;
        }
        .footer-bottom { text-align: center; padding-top: 16px; margin-top: 16px; border-top: var(--border-thick); font-family: var(--font-display); font-weight: 700; font-size: 0.8rem; }
        @media (min-width: 768px) { .footer-content { grid-template-columns: repeat(4, 1fr); } }

        /* ---- RESPONSIVE ---- */
        @media (max-width: 480px) {
            .section-title { font-size: 1.8rem; }
            .back-to-top { width: 42px; height: 42px; font-size: 1rem; bottom: 16px; left: 16px; }
            .carousel-wrapper { padding: 0 20px; }
            .carousel-card { min-width: 230px; max-width: 260px; }
            .carousel-btn { width: 36px; height: 36px; font-size: 0.9rem; }
            .carousel-thumbnail { height: 110px; }
        }
        @media (max-width: 768px) {
            .carousel-card { min-width: 250px; max-width: 280px; }
        }

        .no-result { text-align: center; padding: 30px; display: none; }
        .no-result.show { display: block; }
        .no-result i { font-size: 2.5rem; color: var(--gray); margin-bottom: 8px; animation: noResultShake 3s ease-in-out infinite; }
        @keyframes noResultShake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }
        .no-result h3 { font-family: var(--font-display); font-size: 1rem; text-transform: uppercase; }

        /* ---- CUSTOM SECTION ---- */
        .custom-section { margin: 20px 0; }
        .custom-section > div {
            background: var(--white); border: var(--border-thick); box-shadow: var(--shadow-heavy);
            padding: 28px 20px; text-align: center;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }
        .custom-section > div::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,0,85,0.02), rgba(124,58,237,0.02));
            pointer-events: none;
        }
        .custom-section > div:hover {
            transform: translate(4px, 4px); box-shadow: none;
        }
    </style>
</head>
<body>

<?php
// ============================================================
// KONFIGURASI LAYANAN — SEMUA 100% GRATIS
// ============================================================
$services = [
    [
        'id' => 'jadibot',
        'type' => 'jadibot',
        'name' => 'Jadibot WhatsApp',
        'desc' => 'Bot WhatsApp multi-device gratis. Pairing cepat, tanpa registrasi, langsung online! Support Phoenix MD & Ourin MD.',
        'icon' => 'fa-brands fa-whatsapp',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/dashboard.php',
        'target' => '_self',
        'users' => '1.2k+',
        'featured' => true,
        'tags' => ['Multi-Device', 'Pairing', 'No Login'],
        'created_at' => '2024-01-01'
    ],
    [
        'id' => 'tools',
        'type' => 'tools',
        'name' => 'Tools Collection',
        'desc' => 'Kumpulan tools digital lengkap: <span class="highlight-tag">Ceknik</span> (Cek NIK KTP), <span class="highlight-tag">YouTube Downloader</span>, <span class="highlight-tag">TikTok Downloader</span>, QR Generator & banyak lagi!',
        'icon' => 'fa-solid fa-toolbox',
        'status' => 'Online',
        'status_type' => 'online',
        'url' => 'https://polar.web.id/tools/index.html',
        'target' => '_self',
        'users' => '500+',
        'featured' => true,
        'tags' => ['Ceknik', 'YT Downloader', 'TT Downloader', 'QR Generator'],
        'created_at' => '2024-03-15'
    ],
];

// Parameter pencarian
$search = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

// Filter berdasarkan pencarian
$filtered_services = array_filter($services, function($service) use ($search) {
    if (empty($search)) return true;
    return strpos(strtolower($service['name']), $search) !== false ||
           strpos(strtolower(strip_tags($service['desc'])), $search) !== false ||
           strpos(strtolower($service['id']), $search) !== false ||
           array_reduce($service['tags'] ?? [], function($carry, $tag) use ($search) {
               return $carry || strpos(strtolower($tag), $search) !== false;
           }, false);
});

// Featured dulu, baru regular
$featured_services = array_filter($filtered_services, function($s) { return isset($s['featured']) && $s['featured'] === true; });
$regular_services  = array_filter($filtered_services, function($s) { return !isset($s['featured']) || $s['featured'] !== true; });
$sorted_services   = array_values(array_merge($featured_services, $regular_services));

// Statistik
$total_services  = count($services);
$active_services = count(array_filter($services, function($s) { return $s['status_type'] === 'online'; }));
?>

<!-- PROGRESS BAR -->
<div class="progress-container"><div class="progress-bar" id="progressBar"></div></div>

<!-- SPLASH SCREEN -->
<div id="splash">
    <div class="splash-particles" id="splashParticles"></div>
    <div class="splash-container">
        <div class="splash-logo">❄️</div>
        <div class="splash-name">Polar.id</div>
        <div class="splash-spinner"></div>
        <div class="splash-progress"><div class="splash-progress-bar"></div></div>
        <div class="splash-sub">Memuat layanan gratis...</div>
    </div>
</div>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="hero" id="home">
    <div class="container hero-content">
        <div class="hero-badge" data-aos="fade-down" data-aos-delay="100">
            <div class="hero-badge-dot"></div>
            <?= $active_services ?> Layanan Aktif • 100% Gratis
        </div>

        <h1 data-aos="fade-up" data-aos-delay="200">Platform Layanan <span class="highlight">Digital</span> Gratis</h1>

        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="300">
            Temukan berbagai layanan digital gratis untuk kebutuhan Anda. Dari bot WhatsApp hingga tools lengkap, semua tanpa biaya.
        </p>

        <div class="trust-badges" data-aos="fade-up" data-aos-delay="400">
            <div class="trust-item gratis"><i class="fas fa-check-circle"></i> <span>100% Gratis</span></div>
            <div class="trust-item instan"><i class="fas fa-bolt"></i> <span>Akses Instan</span></div>
            <div class="trust-item aman"><i class="fas fa-shield-alt"></i> <span>Aman & Terpercaya</span></div>
            <div class="trust-item opensource"><i class="fas fa-infinity"></i> <span>Tanpa Batas</span></div>
        </div>
    </div>
</section>

<!-- ============================================================
     STATS
     ============================================================ -->
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="stats-strip">
        <div class="strip-item">
            <div class="strip-number" data-count="<?= $total_services ?>">0</div>
            <div class="strip-label">Total Layanan</div>
        </div>
        <div class="strip-item">
            <div class="strip-number" data-count="<?= $active_services ?>">0</div>
            <div class="strip-label">Layanan Online</div>
        </div>
        <div class="strip-item">
            <div class="strip-number" data-count="10000">0</div>
            <div class="strip-label">Pengguna</div>
        </div>
    </div>
</div>

<!-- ============================================================
     SEARCH
     ============================================================ -->
<section class="container" id="services">
    <div class="section-header" data-aos="fade-up">
        <div class="section-title">🎯 Layanan Kami</div>
        <div class="section-subtitle">
            <span><?= $total_services ?></span> layanan gratis siap pakai, geser untuk lihat semua
        </div>
    </div>

    <div class="search-section" data-aos="fade-up" data-aos-delay="100">
        <form class="search-box" method="GET" action="">
            <input type="text" name="q" placeholder="Cari layanan... (contoh: downloader, ceknik, bot)" value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
            <a href="?q=" style="display:flex;align-items:center;padding:0 12px;color:var(--black);text-decoration:none;font-weight:700;font-size:1.2rem;">✕</a>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- ============================================================
     CAROUSEL LAYANAN
     ============================================================ -->
<?php if (count($sorted_services) > 0): ?>
<section class="carousel-section" data-aos="fade-up">
    <div class="container">
        <div class="carousel-header">
            <div class="section-title">⚡ Semua Layanan</div>
            <div class="section-subtitle">
                <span><?= count($sorted_services) ?></span> layanan gratis dengan preview langsung dari halamannya
            </div>
        </div>

        <div class="carousel-wrapper">
            <button class="carousel-btn prev" id="carouselPrev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="carousel-track" id="carouselTrack">
                <?php foreach ($sorted_services as $index => $service): ?>
                <div class="carousel-card <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">

                    <!-- Mini Webview Thumbnail -->
                    <div class="carousel-thumbnail">
                        <div class="thumbnail-placeholder">
                            <i class="<?= $service['icon'] ?>"></i>
                            <span><?= $service['name'] ?></span>
                        </div>
                        <iframe
                            src="<?= $service['url'] ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                            sandbox="allow-same-origin allow-scripts"
                            onload="this.style.opacity=1"
                            style="opacity:0;transition:opacity .5s ease;position:relative;z-index:1;"
                            title="Preview <?= htmlspecialchars($service['name']) ?>"></iframe>
                        <div class="live-badge"><span class="dot"></span> Live</div>
                    </div>

                    <div class="carousel-card-icon"><i class="<?= $service['icon'] ?>"></i></div>
                    <div class="carousel-card-title"><?= $service['name'] ?></div>
                    <div class="carousel-card-desc"><?= $service['desc'] ?></div>

                    <?php if (!empty($service['tags'])): ?>
                    <div class="carousel-card-tags">
                        <?php foreach (array_slice($service['tags'], 0, 3) as $tag): ?>
                        <span class="carousel-card-tag"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="carousel-card-meta">
                        <span class="status-<?= $service['status_type'] ?>"><i class="fas fa-circle"></i> <?= $service['status'] ?></span>
                        <span><i class="fas fa-users"></i> <?= $service['users'] ?></span>
                    </div>

                    <a href="<?= $service['url'] ?>" target="<?= $service['target'] ?>" class="btn-small">
                        <i class="fas fa-arrow-right"></i> Akses Layanan
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-btn next" id="carouselNext" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="carousel-dots" id="carouselDots">
            <?php foreach ($sorted_services as $index => $service): ?>
            <button class="carousel-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php else: ?>
<div class="container">
    <div class="no-result show">
        <i class="fas fa-search"></i>
        <h3>Layanan tidak ditemukan</h3>
        <p>Maaf, tidak ada layanan yang cocok dengan pencarian "<strong><?= htmlspecialchars($search) ?></strong>".</p>
        <br>
        <a href="?" class="btn btn-secondary" style="display:inline-flex;">Lihat Semua Layanan</a>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================
     CUSTOM SECTION
     ============================================================ -->
<section class="custom-section container" data-aos="fade-up" data-aos-delay="100">
    <div>
        <h3 style="font-family:var(--font-display);text-transform:uppercase;font-weight:900;font-size:1.2rem;">
            <i class="fas fa-rocket" style="color:var(--primary);"></i> Butuh layanan khusus?
        </h3>
        <p style="font-weight:500;color:#444;margin:8px 0 16px;">
            Kami siap membantu kebutuhan digital Anda. Hubungi kami untuk request fitur atau layanan baru.
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
            <div class="testi-card" data-aos="fade-up" data-aos-delay="100">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Jadibot WhatsApp-nya sangat mudah digunakan. Gratis pula, mantap!"</div>
                <div class="testi-name">— Andi Setiawan</div>
            </div>
            <div class="testi-card" data-aos="fade-up" data-aos-delay="200">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Tools collection lengkap banget. Ada Ceknik, YouTube & TikTok downloader, semua gratis dan cepat!"</div>
                <div class="testi-name">— Budi Santoso</div>
            </div>
            <div class="testi-card" data-aos="fade-up" data-aos-delay="300">
                <div class="testi-avatar">👤</div>
                <div class="testi-rating">★★★★★</div>
                <div class="testi-text">"Suka banget nggak ada biaya tersembunyi. Semua fitur bisa dipakai bebas!"</div>
                <div class="testi-name">— Citra Dewi</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     FAQ
     ============================================================ -->
<section class="faq-section container" id="faq" data-aos="fade-up">
    <div class="section-header">
        <div class="section-title">❓ FAQ</div>
        <div class="section-subtitle">Jawaban untuk pertanyaan yang sering diajukan</div>
    </div>

    <div class="faq-grid">
        <div class="faq-item" data-aos="fade-up" data-aos-delay="50">
            <div class="faq-question"><span>❓ Apa itu Polar.id?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Platform layanan digital gratis dan terpercaya yang menyediakan berbagai solusi seperti bot WhatsApp dan tools (Ceknik, YouTube/TikTok Downloader).</div>
        </div>
        <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
            <div class="faq-question"><span>💸 Benar-benar gratis tanpa biaya?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Betul, semua layanan di Polar.id 100% gratis tanpa biaya tersembunyi.</div>
        </div>
        <div class="faq-item" data-aos="fade-up" data-aos-delay="150">
            <div class="faq-question"><span>🛡️ Apakah aman menggunakan layanan ini?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Sangat aman. Data Anda terenkripsi dan kami tidak menyimpan informasi sensitif pengguna.</div>
        </div>
        <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
            <div class="faq-question"><span>🎥 Apa saja yang ada di Tools Collection?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Tools Collection menyediakan berbagai alat digital seperti Ceknik (Cek NIK KTP), YouTube Downloader, TikTok Downloader, QR Code Generator, Password Generator, dan masih banyak lagi!</div>
        </div>
        <div class="faq-item" data-aos="fade-up" data-aos-delay="250">
            <div class="faq-question"><span>🖼️ Kenapa ada preview mini di setiap kartu?</span><i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">Setiap kartu layanan menampilkan preview langsung (mini webview) dari halaman aslinya, supaya Anda tahu tampilannya sebelum membuka layanan.</div>
        </div>
    </div>
</section>

<!-- ============================================================
     CTA
     ============================================================ -->
<div class="cta-wrapper container" data-aos="fade-up">
    <div class="cta-box">
        <h2>🚀 Siap memulai?</h2>
        <p>Jelajahi semua layanan digital kami. 100% gratis, cepat, dan tanpa ribet.</p>
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
                <p style="font-weight:500;">Platform layanan digital gratis terpercaya untuk berbagai kebutuhan Anda.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Layanan</h4>
                <?php foreach ($services as $s): ?>
                <a href="<?= $s['url'] ?>" target="<?= $s['target'] ?>"><?= $s['name'] ?></a>
                <?php endforeach; ?>
            </div>
            <div class="footer-col">
                <h4>Menu</h4>
                <a href="index.php">Beranda</a>
                <a href="#services">Layanan</a>
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
    // SPLASH PARTICLES
    (function createSplashParticles() {
        const container = document.getElementById('splashParticles');
        if (!container) return;
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.className = 'splash-particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.width = (Math.random() * 6 + 2) + 'px';
            p.style.height = p.style.width;
            p.style.animationDelay = (Math.random() * 3) + 's';
            p.style.animationDuration = (Math.random() * 3 + 2) + 's';
            p.style.background = ['var(--primary)', 'var(--secondary)', 'var(--purple)', 'var(--green)'][Math.floor(Math.random() * 4)];
            container.appendChild(p);
        }
    })();

    // SPLASH SCREEN
    window.addEventListener('load', () => {
        setTimeout(() => { document.getElementById('splash')?.classList.add('hide'); }, 2500);
    });

    // PROGRESS BAR + BACK TO TOP
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

    // ANIMATED COUNTER
    (function initCounters() {
        const counters = document.querySelectorAll('.strip-number[data-count]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.count);
                    if (target <= 0) { el.textContent = target; return; }
                    let current = 0;
                    const duration = 1500;
                    const steps = 60;
                    const increment = target / steps;
                    let step = 0;
                    const timer = setInterval(() => {
                        step++;
                        current += increment;
                        if (step >= steps) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = Math.floor(current);
                    }, duration / steps);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => observer.observe(c));
    })();

    // FAQ ACCORDION
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => {
            const item = q.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });
    document.querySelector('.faq-item')?.classList.add('open');

    // CAROUSEL LAYANAN
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
            cards.forEach((card, i) => card.classList.toggle('active', i === index));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
            const cardWidth = cards[0].offsetWidth + 24;
            track.style.transform = `translateX(-${index * cardWidth}px)`;
        };

        const goTo = (index) => {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentIndex = index;
            updateCarousel(currentIndex);
        };

        prevBtn?.addEventListener('click', () => goTo(currentIndex - 1));
        nextBtn?.addEventListener('click', () => goTo(currentIndex + 1));
        dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goTo(currentIndex - 1);
            if (e.key === 'ArrowRight') goTo(currentIndex + 1);
        });

        let autoPlayInterval = setInterval(() => goTo(currentIndex + 1), 4500);
        const carouselWrapper = document.querySelector('.carousel-wrapper');
        carouselWrapper?.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
        carouselWrapper?.addEventListener('mouseleave', () => {
            autoPlayInterval = setInterval(() => goTo(currentIndex + 1), 4500);
        });

        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;
        track?.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        track?.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) goTo(currentIndex + 1);
                else goTo(currentIndex - 1);
            }
        });

        window.addEventListener('resize', () => updateCarousel(currentIndex));
    })();

    // PARALLAX HERO
    (function initParallax() {
        const hero = document.querySelector('.hero');
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            if (hero && scrolled < window.innerHeight) {
                hero.style.backgroundPositionY = (scrolled * 0.3) + 'px';
            }
        });
    })();

    // AOS INIT
    AOS.init({
        duration: 800,
        once: true,
        offset: 80,
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
    });

    // SMOOTH SCROLL
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // KEYBOARD SHORTCUT: Ctrl+/ untuk search
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === '/') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-box input');
            if (searchInput) { searchInput.focus(); searchInput.select(); }
        }
    });
</script>
</body>
</html>