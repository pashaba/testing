<?php
require_once 'config.php';

// ========== MENU DATA - COPY PASTE SEMUA KATEGORI ANDA DI SINI ==========
$MENU_DATA = [
  // ============================================================
  // 1. ⚙️ MAIN MENU
  // ============================================================
     [
 "title" => "⚙️ Main Menu",
    "rows" => [
      [ "id" => "toggle", "title" => "Toggle" ],
      [ "id" => "allmenu", "title" => "AllMenu" ],
      [ "id" => "menu", "title" => "Menu" ],
      [ "id" => "profil", "title" => "Profil" ],
      [ "id" => "ping", "title" => "Ping" ],
      [ "id" => "runtime", "title" => "Runtime" ],
      [ "id" => "owner", "title" => "Owner" ],
[ "id" => "self", "title" => "Self" ],
[ "id" => "public", "title" => "Public" ]
    ]
  ],
  [
    "title" => "👥 Group Menu",
    "rows" => [
      [ "id" => "kick", "title" => "Kick" ],
      [ "id" => "add", "title" => "Add" ],
      [ "id" => "promote", "title" => "Promote" ],
      [ "id" => "demote", "title" => "Demote" ],
        [ "id" => "creategc", "title" => "creategc" ],
      [ "id" => "tagall", "title" => "TagAll" ],
      [ "id" => "rename", "title" => "Rename" ],
      [ "id" => "desc", "title" => "Desc" ],
      [ "id" => "hidetag", "title" => "Hidetag" ],
            [ "id" => "open", "title" => "open" ],
            [ "id" => "close", "title" => "clode" ],
      [ "id" => "welcome on/off", "title" => "Welcome" ],
      [ "id" => "leave on/off", "title" => "Leave" ],
      [ "id" => "setwelcome", "title" => "SetWelcome" ],
      [ "id" => "setleave", "title" => "SetLeave" ],  
        [ "id" => "antilink", "title" => "Antilink" ],
[ "id" => "antilinkaction", "title" => "AntilinkAction" ],
[ "id" => "antitoxic", "title" => "Antitoxic" ],
[ "id" => "addtoxic", "title" => "AddToxic" ],
[ "id" => "deltoxic", "title" => "DelToxic" ],
[ "id" => "listtoxic", "title" => "ListToxic" ],
[ "id" => "antitoxicaction", "title" => "AntitoxicAction" ],        
[ "id" => "totalchat", "title" => "TotalChat" ],
[ "id" => "topchat", "title" => "TopChat" ],
[ "id" => "resettopchat", "title" => "ResetTopChat" ]
    ]
  ],
  [
    "title" => "🤖 AI Menu",
    "rows" => [
      [ "id" => "ai", "title" => "AI" ],
      [ "id" => "chatgpt", "title" => "ChatGPT" ],
      [ "id" => "bypass", "title" => "Bypass" ],
      [ "id" => "andisearch", "title" => "AndiSearch" ],
      [ "id" => "copilot", "title" => "Copilot" ],
      [ "id" => "deepseek", "title" => "DeepSeek" ],
      [ "id" => "duck", "title" => "Duck AI" ],
      [ "id" => "gemini", "title" => "Gemini" ],
      [ "id" => "gpt35", "title" => "GPT35" ],
      [ "id" => "llamacoder", "title" => "LlamaCoder" ],
      [ "id" => "openai", "title" => "OpenAI" ],
      [ "id" => "perplexity", "title" => "Perplexity" ],
      [ "id" => "veo2", "title" => "Veo2" ],
      [ "id" => ".claude", "title" => "Claude" ]
    ]
  ],
  [
    "title" => "📥 Downloader",
    "rows" => [
        
      [ "id" => "aio", "title" => "aio" ],
      [ "id" => "tt", "title" => "TikTok" ],
      [ "id" => "douyin", "title" => "Douyin" ],
      [ "id" => "fb", "title" => "Facebook" ],
      [ "id" => "ig", "title" => "Instagram" ],
      [ "id" => "snackvideo", "title" => "SnackVideo" ],
      [ "id" => "rednote", "title" => "Rednote" ],
      [ "id" => "videy", "title" => "Videy" ],
      [ "id" => "ytmp3", "title" => "ytmp3" ],
      [ "id" => "ytmp4", "title" => "ytmp4" ],
      [ "id" => "spotify", "title" => "Spotify" ],
      [ "id" => "play", "title" => "Play" ],
      [ "id" => "mediafire", "title" => "Mediafire" ],
      [ "id" => "github", "title" => "GitHub" ],
      [ "id" => "npm", "title" => "NPM" ],
      [ "id" => "sfile", "title" => "Sfile" ]
    ]
  ],
  [
    "title" => "🛠 Tools",
    "rows" => [
      [ "id" => "cekresi", "title" => "Cek Resi" ],
           [ "id" => "cekbola", "title" => "Cek bola" ],
           [ "id" => "ceknegara", "title" => "Cek negara" ],
           [ "id" => "cekgempa", "title" => "Cek gempa" ],
           [ "id" => "cekjadwalsholat", "title" => "Cek jadwal sholat" ],
           [ "id" => "harilibur", "title" => "hari libur" ],
      [ "id" => "enhance", "title" => "Enhance" ],
      [ "id" => "enhancer", "title" => "Enhancer" ],
      [ "id" => "remini", "title" => "Remini" ],
      [ "id" => "removebg", "title" => "RemoveBG" ],
      [ "id" => "ocr", "title" => "OCR" ],
      [ "id" => "hd", "title" => "HD" ],
      [ "id" => "hdr", "title" => "HDR" ],
      [ "id" => "hdvideo", "title" => "HDVideo" ],
      [ "id" => "hdvid", "title" => "HDVid" ],
      [ "id" => "vidhd", "title" => "VidHD" ],
      [ "id" => "dewatermark", "title" => "DeWatermark" ],
      [ "id" => "spamngl", "title" => "SpamNGL" ],
      [ "id" => "subfinder", "title" => "Subfinder" ],
      [ "id" => "subdomainfinder", "title" => "Subdomain" ],
      [ "id" => "emojimix", "title" => "EmojiMix" ],
      [ "id" => "ttsjokowi", "title" => "TTSJokowi" ],
      [ "id" => "ttsprabowo", "title" => "TTSPrabowo" ],
      [ "id" => "ttsmegawati", "title" => "TTSMegawati" ],
      [ "id" => "ttspresiden", "title" => "TTSPresiden" ],
      [ "id" => "sticker", "title" => "Sticker" ],
      [ "id" => "stiker", "title" => "Stiker" ],
           [ "id" => "jadwaltv", "title" => "jadwal tv" ],
      [ "id" => "s", "title" => "S" ],
      [ "id" => "rvo", "title" => "RVO" ]
    ]
  ],
  
  [
    "title" => "🎨 Maker",
    "rows" => [
      [ "id" => "avengers", "title" => "Avengers" ],
      [ "id" => "pornhub", "title" => "Pornhub" ],
      [ "id" => "phlogo", "title" => "PHLogo" ],
      [ "id" => "marvel", "title" => "Marvel" ],
      [ "id" => "comic", "title" => "Comic" ],
      [ "id" => "blackpink", "title" => "Blackpink" ],
      [ "id" => "bpink", "title" => "BPink" ],
      [ "id" => "bear", "title" => "Bear" ],
      [ "id" => "balogo", "title" => "BALogo" ],
      [ "id" => "bratanime", "title" => "BratAnime" ],
      [ "id" => "brathd", "title" => "BratHD" ],
      [ "id" => "bratvid", "title" => "BratVid" ],
      [ "id" => "bratvidhd", "title" => "BratVidHD" ],
      [ "id" => "fakebank", "title" => "FakeBank" ],
      [ "id" => "fakebankjago", "title" => "FakeBankJago" ],
      [ "id" => "fakedana", "title" => "FakeDana" ],
          [ "id" => "fakelobbyff", "title" => "Fakelobbyff" ],
          [ "id" => "fakestory", "title" => "Fakestory" ],
        
          [ "id" => "fakecall", "title" => "Fakecall" ],
          [ "id" => "fakethreads", "title" => "Fakethreads" ],
      [ "id" => "iqc", "title" => "IQC" ],
              [ "id" => "iqcv1", "title" => "IQC" ],
      [ "id" => "nulis", "title" => "Nulis" ]
    ]
  ],
        [
  "title" => "👥 Stalker",
  "rows" => [
    [ "id" => "wastalk", "title" => "WhatsApp Stalk" ],
    [ "id" => "robloxstalk", "title" => "Roblox Stalk" ]
  ]
],
  [
    "title" => "🎲 Random",
    "rows" => [
      [ "id" => "cecanjapan", "title" => "CecanJapan" ],
      [ "id" => "cecanindo", "title" => "CecanIndo" ],
      [ "id" => "cecanchina", "title" => "CecanChina" ],
      [ "id" => "cecankorea", "title" => "CecanKorea" ],
      [ "id" => "cecanthailand", "title" => "CecanThailand" ],
      [ "id" => "loli", "title" => "Loli" ],
      [ "id" => "pap", "title" => "PAP" ]
    ]
  ],
  [
    "title" => "🔮 Primbon",
    "rows" => [
      [ "id" => "artinama", "title" => "ArtiNama" ],
      [ "id" => "nomerhoki", "title" => "NomorHoki" ],
      [ "id" => "nomorhoki", "title" => "NomorHoki2" ],
      [ "id" => "zodiak", "title" => "Zodiak" ],
      [ "id" => "tafsirmimpi", "title" => "TafsirMimpi" ],
      [ "id" => "mimpi", "title" => "Mimpi" ]
    ]
  ],
  [
    "title" => "🏹 RPG",
    "rows" => [
      [ "id" => "bank", "title" => "Bank" ],
      [ "id" => "toko/market/shop", "title" => "Shop" ],
      [ "id" => "cariperak", "title" => "CariPerak" ],
      [ "id" => "buy", "title" => "Buy" ],
      [ "id" => "sell", "title" => "Sell" ],
      [ "id" => "mining", "title" => "Mining" ],
      [ "id" => "inventory", "title" => "Inventory" ],
      [ "id" => "nebang", "title" => "Nebang" ],
      [ "id" => "mancing", "title" => "Mancing" ],
      [ "id" => "craft", "title" => "Craft" ],
      [ "id" => "hunt", "title" => "Hunt" ]
    ]
  ],
  [
    "title" => "💰 Economy",
    "rows" => [
      [ "id" => "saldo", "title" => "Saldo" ],
      [ "id" => "bank", "title" => "Bank" ],
      [ "id" => "deposit", "title" => "Deposit" ],
      [ "id" => "withdraw", "title" => "Withdraw" ],
      [ "id" => "daily", "title" => "Daily" ],
      [ "id" => "kerja", "title" => "Kerja" ],
      [ "id" => "karir", "title" => "Karir" ],
      [ "id" => "resign", "title" => "Resign" ],
      [ "id" => "training", "title" => "Training" ],
      [ "id" => "belajar", "title" => "Belajar" ],
      [ "id" => "skill", "title" => "Skill" ],
      [ "id" => "tf", "title" => "Transfer" ],
      [ "id" => "leaderboard", "title" => "Leaderboard" ],
      [ "id" => "maling", "title" => "Maling" ],
      [ "id" => "rampok", "title" => "Rampok" ],
      [ "id" => "begal", "title" => "Begal" ],
      [ "id" => "kill", "title" => "Kill" ],
      [ "id" => "robbank", "title" => "RobBank" ],
      [ "id" => "bankrob", "title" => "Bankrob" ],
      [ "id" => "profilejudi", "title" => "ProfileJudi" ],
      [ "id" => "slot", "title" => "Slot" ],
      [ "id" => "bulkslot", "title" => "BulkSlot" ],
      [ "id" => "casino", "title" => "Casino" ],
      [ "id" => "bulkcasino", "title" => "BulkCasino" ],
      [ "id" => "blackjack", "title" => "Blackjack" ],
      [ "id" => "hit", "title" => "Hit" ],
      [ "id" => "stand", "title" => "Stand" ],
      [ "id" => "saham", "title" => "Saham" ],
      [ "id" => "news", "title" => "News" ],
      [ "id" => "portofolio", "title" => "Portofolio" ],
      [ "id" => "beli", "title" => "Beli" ],
      [ "id" => "jual", "title" => "Jual" ],
      [ "id" => "topsaham", "title" => "Topsaham" ],
      [ "id" => "prop", "title" => "Prop" ],
      [ "id" => "propshop", "title" => "PropShop" ],
      [ "id" => "claimprop", "title" => "ClaimProp" ],
      [ "id" => "rebirth", "title" => "Rebirth" ],
      [ "id" => "prediksi", "title" => "Prediksi" ],
      [ "id" => "shop", "title" => "Shop" ],
      [ "id" => "inventory", "title" => "Inventory" ]
    ]
  ],
  [
    "title" => "🐾 Pet",
    "rows" => [
      [ "id" => "gacha", "title" => "Gacha" ],
      [ "id" => "mypet", "title" => "MyPet" ],
      [ "id" => "equip", "title" => "Equip" ],
      [ "id" => "unequip", "title" => "Unequip" ],
      [ "id" => "team", "title" => "Team" ],
      [ "id" => "petshop", "title" => "PetShop" ],
      [ "id" => "petduel", "title" => "PetDuel" ]
    ]
  ],
  [
    "title" => "🎉 Fun",
    "rows" => [
      [ "id" => "cekganteng", "title" => "CekGanteng" ],
      [ "id" => "cekbejat", "title" => "CekBejat" ],
      [ "id" => "cekcantik", "title" => "CekCantik" ],
      [ "id" => "cekkaya", "title" => "CekKaya" ],
      [ "id" => "ceksabar", "title" => "CekSabar" ],
      [ "id" => "cekkhodam", "title" => "CekKhodam" ],
      [ "id" => "seberapa ganteng", "title" => "SeberapaGanteng" ],
      [ "id" => "seberapa cantik", "title" => "SeberapaCantik" ],
      [ "id" => "seberapa kaya", "title" => "SeberapaKaya" ]
    ]
  ],
  [
    "title" => "🎯 Tebak",
    "rows" => [
      [ "id" => "tebakangka", "title" => "TebakAngka" ],
      [ "id" => "tebakemoji", "title" => "TebakEmoji" ],
      [ "id" => "tebakkata", "title" => "TebakKata" ],
      [ "id" => "tebakbendera", "title" => "TebakBendera" ]
    ]
 ]
  
  // ============================================================
  // 2. 👥 GROUP MENU - COPY PASTE DARI SINI KE BAWAH
  // ============================================================
  /*
  [
    "title" => "👥 Group Menu",
    "rows" => [
      ["id" => "kick", "title" => "Kick"],
      ["id" => "add", "title" => "Add"],
      ...
    ]
  ],
  */
  
  // ============================================================
  // 3. 🤖 AI MENU
  // ============================================================
  /*
  [
    "title" => "🤖 AI Menu",
    "rows" => [
      ["id" => "ai", "title" => "AI"],
      ["id" => "chatgpt", "title" => "ChatGPT"],
      ...
    ]
  ],
  */
  
  // ============================================================
  // 4. 📥 DOWNLOADER MENU
  // ============================================================
  /*
  [
    "title" => "📥 Downloader",
    "rows" => [
      ["id" => "tt", "title" => "TikTok"],
      ["id" => "ytmp3", "title" => "ytmp3"],
      ...
    ]
  ],
  */
  
  // ============================================================
  // 5. 🛠 TOOLS MENU
  // ============================================================
  /*
  [
    "title" => "🛠 Tools",
    "rows" => [
      ["id" => "sticker", "title" => "Sticker"],
      ["id" => "removebg", "title" => "RemoveBG"],
      ...
    ]
  ],
  */
  
  // ============================================================
  // LANJUTKAN DENGAN KATEGORI LAINNYA:
  // - 🎨 Maker
  // - 👥 Stalker
  // - 🎲 Random
  // - 🔮 Primbon
  // - 🏹 RPG
  // - 💰 Economy
  // - 🐾 Pet
  // - 🎉 Fun
  // - 🎯 Tebak
  // ============================================================
];

// ========== JANGAN UBAH KODE DI BAWAH INI ==========
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Fitur Script — Polar.id</title>
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
            --purple: #8b5cf6;
            --purple-light: #ede9fe;
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
            --shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
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
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-bg); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--gray-light); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* Navbar */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--card);
            border-bottom: 1px solid var(--border);
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(16px, 4vw, 48px);
            backdrop-filter: blur(10px);
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .logo i { font-size: 20px; color: var(--primary); -webkit-text-fill-color: var(--primary); }
        .nav-right { display: flex; align-items: center; gap: 12px; }
        .nav-link {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            color: var(--gray);
            transition: all 0.2s;
        }
        .nav-link:hover { color: var(--primary); background: var(--gray-bg); }
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
        }
        .nav-cta {
            padding: 8px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            transition: all 0.2s;
            box-shadow: 0 2px 8px var(--primary-glow);
        }
        .nav-cta:hover { transform: translateY(-2px); box-shadow: 0 4px 12px var(--primary-glow); }

        /* Layout */
        .layout { display: flex; padding-top: 0; min-height: calc(100vh - 64px); }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--card);
            border-right: 1px solid var(--border);
            padding: 24px 0;
            position: sticky;
            top: 64px;
            height: calc(100vh - 64px);
            overflow-y: auto;
        }
        .sidebar-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--gray);
            padding: 0 20px 12px;
        }
        .category-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            width: 100%;
            border: none;
            background: transparent;
            color: var(--dark-3);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }
        .category-btn:hover { background: var(--gray-bg); color: var(--primary); }
        .category-btn.active {
            background: var(--primary-light);
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }
        .category-count {
            margin-left: auto;
            font-size: 11px;
            color: var(--gray-light);
            background: var(--gray-bg);
            padding: 2px 8px;
            border-radius: 20px;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 28px 32px;
            min-width: 0;
        }
        .page-header { margin-bottom: 28px; }
        .page-title { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .page-desc { color: var(--gray); font-size: 14px; }
        
        /* Search Bar */
        .search-bar {
            margin-bottom: 24px;
        }
        .search-input {
            width: 100%;
            max-width: 320px;
            padding: 10px 16px 10px 40px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 40px;
            font-size: 13px;
            transition: all 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }
        .search-wrapper { position: relative; display: inline-block; }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gray); font-size: 14px; }
        
        /* Stats */
        .stats-bar {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            padding: 16px 20px;
            background: var(--gray-bg);
            border-radius: var(--radius);
            flex-wrap: wrap;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .stat-number { font-size: 24px; font-weight: 800; color: var(--primary); }
        .stat-label { font-size: 12px; color: var(--gray); }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 16px;
        }
        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            transition: all 0.2s;
        }
        .feature-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }
        .feature-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .feature-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
        }
        .feature-cmd {
            font-family: monospace;
            font-size: 12px;
            background: var(--gray-bg);
            padding: 4px 8px;
            border-radius: 6px;
            margin: 10px 0;
            color: var(--primary);
        }
        .feature-desc {
            font-size: 12px;
            color: var(--gray);
            line-height: 1.6;
            margin-top: 8px;
        }
        .empty-state {
            text-align: center;
            padding: 60px;
            color: var(--gray);
        }
        .empty-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 24px clamp(16px, 4vw, 48px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            background: var(--card);
        }
        .footer-links { display: flex; gap: 20px; }
        .footer-links a { color: var(--gray); text-decoration: none; font-size: 12px; }
        .footer-links a:hover { color: var(--primary); }
        .copyright { font-size: 11px; color: var(--gray-light); }

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
            box-shadow: 0 4px 16px rgba(34,197,94,0.35);
            transition: all 0.2s;
        }
        .cs-float:hover { transform: translateY(-2px); }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { padding: 20px 16px; }
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php" class="logo"><i class="fas fa-snowflake"></i> Polar.id</a>
    <div class="nav-right">
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="event.php" class="nav-link">Event</a>
        <a href="token.php" class="nav-link">Token</a>
        <button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon" id="themeIcon"></i></button>
        <a href="dashboard.php" class="nav-cta"><i class="fas fa-robot"></i> Dashboard</a>
    </div>
</nav>

<div class="layout">
    <!-- Sidebar Kategori -->
    <div class="sidebar" id="sidebarCategories">
        <div class="sidebar-title">📂 Kategori Fitur</div>
        <div id="categoryList"></div>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="page-header">
            <h1 class="page-title">📋 Daftar Fitur Script</h1>
            <p class="page-desc">Semua perintah yang tersedia di bot WhatsApp Polar.id</p>
        </div>

        <div class="search-bar">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Cari fitur atau command...">
            </div>
        </div>

        <div class="stats-bar" id="statsBar"></div>

        <div class="features-grid" id="featuresGrid"></div>
    </div>
</div>

<a href="https://wa.me/<?= CS_NUMBER ?>" target="_blank" class="cs-float"><i class="fab fa-whatsapp"></i> CS</a>

<footer>
    <div class="copyright">© 2025 Polar.id — Bot WhatsApp Multi Device</div>
    <div class="footer-links">
        <a href="index.php">Beranda</a>
        <a href="features.php">Fitur</a>
        <a href="event.php">Event</a>
        <a href="token.php">Token</a>
    </div>
</footer>

<script>
// ========== DATA MENU - COPY PASTE LENGKAP DI SINI ==========
const MENU_DATA = <?php echo json_encode($MENU_DATA, JSON_PRETTY_PRINT); ?>;

// ========== PROSES DATA ==========
let allFeatures = [];
let currentCategory = 'all';
let currentSearch = '';

// Konversi MENU_DATA ke flat array fitur
function buildFeatures() {
    allFeatures = [];
    for (const category of MENU_DATA) {
        const catTitle = category.title;
        for (const cmd of category.rows) {
            allFeatures.push({
                id: cmd.id,
                name: cmd.title,
                category: catTitle,
                cmd: cmd.id
            });
        }
    }
}

// Render sidebar kategori
function renderCategories() {
    const categories = {};
    for (const feat of allFeatures) {
        if (!categories[feat.category]) categories[feat.category] = 0;
        categories[feat.category]++;
    }
    
    const categoryList = document.getElementById('categoryList');
    const totalFitur = allFeatures.length;
    
    let html = `
        <button class="category-btn ${currentCategory === 'all' ? 'active' : ''}" onclick="setCategory('all')">
            <i class="fas fa-th-large"></i> Semua Fitur
            <span class="category-count">${totalFitur}</span>
        </button>
    `;
    
    for (const [cat, count] of Object.entries(categories)) {
        html += `
            <button class="category-btn ${currentCategory === cat ? 'active' : ''}" onclick="setCategory('${cat.replace(/'/g, "\\'")}')">
                ${getIconForCategory(cat)} ${cat}
                <span class="category-count">${count}</span>
            </button>
        `;
    }
    
    categoryList.innerHTML = html;
}

function getIconForCategory(cat) {
    const icons = {
        '⚙️ Main Menu': '⚙️',
        '👥 Group Menu': '👥',
        '🤖 AI Menu': '🤖',
        '📥 Downloader': '📥',
        '🛠 Tools': '🛠️',
        '🎨 Maker': '🎨',
        '👥 Stalker': '👀',
        '🎲 Random': '🎲',
        '🔮 Primbon': '🔮',
        '🏹 RPG': '🏹',
        '💰 Economy': '💰',
        '🐾 Pet': '🐾',
        '🎉 Fun': '🎉',
        '🎯 Tebak': '🎯'
    };
    return icons[cat] || '📌';
}

function setCategory(cat) {
    currentCategory = cat;
    renderCategories();
    renderFeatures();
}

function renderFeatures() {
    const searchTerm = currentSearch.toLowerCase();
    let filtered = allFeatures;
    
    if (currentCategory !== 'all') {
        filtered = filtered.filter(f => f.category === currentCategory);
    }
    
    if (searchTerm) {
        filtered = filtered.filter(f => 
            f.name.toLowerCase().includes(searchTerm) || 
            f.cmd.toLowerCase().includes(searchTerm)
        );
    }
    
    // Update stats
    const statsBar = document.getElementById('statsBar');
    statsBar.innerHTML = `
        <div class="stat-item"><span class="stat-number">${filtered.length}</span><span class="stat-label">Fitur ditampilkan</span></div>
        <div class="stat-item"><span class="stat-number">${allFeatures.length}</span><span class="stat-label">Total Fitur</span></div>
        <div class="stat-item"><span class="stat-number">${Object.keys(MENU_DATA).length}</span><span class="stat-label">Kategori</span></div>
    `;
    
    // Render grid
    const grid = document.getElementById('featuresGrid');
    if (filtered.length === 0) {
        grid.innerHTML = `<div class="empty-state"><div class="empty-icon"><i class="fas fa-search"></i></div><div>Tidak ada fitur ditemukan</div></div>`;
        return;
    }
    
    grid.innerHTML = filtered.map(feat => `
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">${getIconForCategory(feat.category)}</div>
                <div>
                    <div class="feature-name">${escapeHtml(feat.name)}</div>
                    <div style="font-size: 10px; color: var(--gray);">${feat.category}</div>
                </div>
            </div>
            <div class="feature-cmd">${escapeHtml(feat.cmd.startsWith('.') ? feat.cmd : '.' + feat.cmd)}</div>
            <div class="feature-desc">Command untuk mengakses fitur ${escapeHtml(feat.name)}</div>
        </div>
    `).join('');
}

function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Search handler
document.getElementById('searchInput').addEventListener('input', function(e) {
    currentSearch = e.target.value;
    renderFeatures();
});

// Theme toggle
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

// Init
buildFeatures();
renderCategories();
renderFeatures();
</script>
</body>
</html>