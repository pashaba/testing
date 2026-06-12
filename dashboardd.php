<!DOCTYPE html>
<html lang="id">
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1771884647147524"
     crossorigin="anonymous"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>Dashboard — Polar.id</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --orange:#f6821f;
  --orange-dark:#e07010;
  --orange-light:#fff4eb;
  --blue:#1d4ed8;
  --bg:#f8fafc;
  --white:#ffffff;
  --border:#e2e8f0;
  --border-light:#f1f5f9;
  --text:#0f172a;
  --text-2:#334155;
  --text-3:#64748b;
  --text-4:#94a3b8;
  --green:#16a34a;
  --green-bg:#f0fdf4;
  --green-border:#bbf7d0;
  --red:#dc2626;
  --red-bg:#fef2f2;
  --red-border:#fecaca;
  --yellow:#d97706;
  --yellow-bg:#fffbeb;
  --yellow-border:#fde68a;
  --blue-bg:#eff6ff;
  --blue-border:#bfdbfe;
  --sidebar-w:240px;
  --radius:8px;
  --shadow:0 1px 3px rgba(0,0,0,0.08),0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:0 4px 6px rgba(0,0,0,0.05),0 2px 4px rgba(0,0,0,0.04);
}
*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{background:var(--bg);color:var(--text);font-family:'Inter',sans-serif;min-height:100vh;font-size:14px;}

/* ── SIDEBAR ── */
.sidebar{
  width:var(--sidebar-w);background:var(--white);
  border-right:1px solid var(--border);
  display:flex;flex-direction:column;
  position:fixed;top:0;left:0;bottom:0;z-index:100;
}
.sidebar-logo{
  padding:20px 20px 16px;
  border-bottom:1px solid var(--border-light);
  display:flex;align-items:center;gap:10px;
}
.logo-icon{
  width:32px;height:32px;border-radius:8px;
  background:linear-gradient(135deg,#f6821f,#e07010);
  display:flex;align-items:center;justify-content:center;
  font-size:16px;flex-shrink:0;
  box-shadow:0 2px 6px rgba(246,130,31,0.3);
}
.logo-text{font-size:15px;font-weight:700;color:var(--text);}
.logo-sub{font-size:11px;color:var(--text-4);margin-top:1px;}
.sidebar-nav{padding:12px 10px;flex:1;overflow-y:auto;}
.nav-section{font-size:10px;font-weight:600;letter-spacing:0.8px;text-transform:uppercase;color:var(--text-4);padding:0 10px;margin:14px 0 5px;}
.nav-item{
  display:flex;align-items:center;gap:9px;
  padding:8px 10px;border-radius:6px;
  color:var(--text-3);font-size:13px;font-weight:500;
  text-decoration:none;transition:all 0.12s;margin-bottom:1px;
}
.nav-item:hover{color:var(--text);background:var(--bg);}
.nav-item.active{color:var(--orange);background:var(--orange-light);font-weight:600;}
.nav-icon{font-size:14px;width:16px;text-align:center;flex-shrink:0;}
.sidebar-foot{padding:14px;border-top:1px solid var(--border-light);}
.fp-card{background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:10px 12px;}
.fp-label{font-size:10px;color:var(--text-4);margin-bottom:3px;font-weight:500;text-transform:uppercase;letter-spacing:0.5px;}
.fp-val{font-size:11px;font-weight:500;color:var(--text-3);font-family:monospace;word-break:break-all;}

/* OVERLAY */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:99;}
.sidebar-overlay.show{display:block;}

/* ── MAIN ── */
.main{margin-left:var(--sidebar-w);display:flex;flex-direction:column;min-height:100vh;}

/* TOPBAR */
.topbar{
  height:56px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 24px;background:var(--white);
  position:sticky;top:0;z-index:50;
}
.topbar-left{display:flex;align-items:center;gap:12px;}
.hamburger{display:none;flex-direction:column;gap:4px;cursor:pointer;padding:4px;border:none;background:none;}
.hamburger span{width:18px;height:2px;background:var(--text-3);border-radius:2px;}
.topbar-title{font-size:15px;font-weight:600;color:var(--text);}
.topbar-right{display:flex;align-items:center;gap:8px;}
.tbtn{padding:7px 14px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all 0.12s;font-family:'Inter',sans-serif;border:1px solid transparent;white-space:nowrap;}
.tbtn-primary{background:var(--orange);color:white;border-color:var(--orange-dark);}
.tbtn-primary:hover{background:var(--orange-dark);}
.tbtn-primary:disabled{opacity:0.45;cursor:not-allowed;}
.tbtn-ghost{background:var(--white);color:var(--text-2);border-color:var(--border);}
.tbtn-ghost:hover{background:var(--bg);}

/* CONTENT */
.content{padding:24px;flex:1;}

/* ALERT */
.alert{padding:10px 14px;border-radius:6px;margin-bottom:16px;font-size:13px;display:none;font-weight:500;}
.alert-ok{background:var(--green-bg);border:1px solid var(--green-border);color:var(--green);}
.alert-err{background:var(--red-bg);border:1px solid var(--red-border);color:var(--red);}

/* NOKOS BANNER */
.nokos-banner{
  display:flex;align-items:center;justify-content:space-between;gap:14px;
  background:var(--orange-light);border:1px solid #fed7aa;
  border-radius:var(--radius);padding:12px 16px;margin-bottom:20px;flex-wrap:wrap;
}
.nokos-text{font-size:13px;color:var(--text-2);}
.nokos-text b{color:var(--orange-dark);}
.nokos-text span{color:var(--text-3);font-size:12px;display:block;margin-top:2px;}
.nokos-btn{
  padding:7px 14px;background:var(--orange);color:white;
  border-radius:6px;text-decoration:none;font-size:12px;font-weight:600;
  white-space:nowrap;transition:all 0.12s;
}
.nokos-btn:hover{background:var(--orange-dark);}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow);}
.stat-label{font-size:11px;color:var(--text-4);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:6px;}
.stat-val{font-size:24px;font-weight:700;color:var(--text);}
.stat-sub{font-size:11px;color:var(--text-4);margin-top:3px;}

/* TABLE CARD */
.table-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;}
.table-header{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.table-title{font-size:14px;font-weight:600;color:var(--text);}
.table-subtitle{font-size:12px;color:var(--text-4);margin-top:1px;}

table{width:100%;border-collapse:collapse;}
thead th{
  padding:10px 16px;text-align:left;
  font-size:11px;font-weight:600;color:var(--text-4);
  text-transform:uppercase;letter-spacing:0.5px;
  background:var(--bg);border-bottom:1px solid var(--border);
}
tbody tr{border-bottom:1px solid var(--border-light);transition:background 0.1s;}
tbody tr:hover{background:var(--bg);}
tbody tr:last-child{border-bottom:none;}
tbody td{padding:12px 16px;font-size:13px;color:var(--text-2);vertical-align:middle;}
.td-phone{font-weight:600;color:var(--text);font-family:monospace;font-size:13px;}
.td-script{color:var(--text-3);}
.td-date{color:var(--text-4);font-size:12px;}

/* STATUS BADGES */
.badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:999px;font-size:11px;font-weight:600;}
.badge::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0;}
.badge-online{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
.badge-online::before{background:var(--green);}
.badge-offline{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
.badge-offline::before{background:var(--red);}
.badge-pending{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
.badge-pending::before{background:var(--yellow);}
.badge-waiting{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border);}
.badge-waiting::before{background:var(--blue);}

/* TABLE ACTIONS */
.td-actions{display:flex;gap:6px;align-items:center;}
.act{padding:5px 10px;border-radius:5px;font-size:11px;font-weight:600;cursor:pointer;border:1px solid var(--border);background:var(--white);color:var(--text-3);font-family:'Inter',sans-serif;transition:all 0.12s;white-space:nowrap;}
.act:hover{background:var(--bg);color:var(--text);}
.act-view{color:var(--blue);border-color:var(--blue-border);}
.act-view:hover{background:var(--blue-bg);}
.act-del{color:var(--red);border-color:var(--red-border);}
.act-del:hover{background:var(--red-bg);}

/* EMPTY */
.empty-row td{text-align:center;padding:48px;color:var(--text-4);}
.empty-icon{font-size:32px;display:block;margin-bottom:10px;}

/* ── ADD MODAL ── */
.ov{position:fixed;inset:0;background:rgba(15,23,42,0.4);backdrop-filter:blur(4px);z-index:200;display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;pointer-events:none;transition:opacity 0.18s;}
.ov.show{opacity:1;pointer-events:all;}
.modal{background:var(--white);border:1px solid var(--border);border-radius:10px;width:100%;max-width:480px;max-height:92vh;overflow-y:auto;transform:translateY(10px);transition:transform 0.18s;box-shadow:0 20px 60px rgba(0,0,0,0.12);}
.ov.show .modal{transform:translateY(0);}
.mhd{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.mttl{font-size:15px;font-weight:600;color:var(--text);}
.mclose{width:28px;height:28px;border-radius:6px;background:var(--bg);border:1px solid var(--border);color:var(--text-3);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;transition:all 0.12s;}
.mclose:hover{background:var(--red-bg);color:var(--red);border-color:var(--red-border);}
.mbody{padding:20px;}
.fgrp{margin-bottom:14px;}
.flbl{display:block;font-size:12px;font-weight:600;color:var(--text-2);margin-bottom:5px;}
.flbl span{color:var(--text-4);font-weight:400;}
.finp{width:100%;padding:9px 12px;background:var(--white);border:1px solid var(--border);border-radius:6px;color:var(--text);font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:border-color 0.12s;}
.finp:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(246,130,31,0.08);}
.finp::placeholder{color:var(--text-4);}
.tokrow{display:flex;gap:8px;}
.tokrow .finp{flex:1;}
.btnTok{padding:9px 12px;background:var(--bg);border:1px solid var(--border);border-radius:6px;color:var(--text-2);font-size:12px;font-weight:600;cursor:pointer;white-space:nowrap;font-family:'Inter',sans-serif;transition:all 0.12s;}
.btnTok:hover{background:var(--orange-light);border-color:#fed7aa;color:var(--orange-dark);}

/* SCRIPT SELECTOR */
.scgrid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;}
.scopt{border:1px solid var(--border);border-radius:8px;overflow:hidden;cursor:pointer;transition:all 0.12s;position:relative;}
.scopt:hover{border-color:var(--orange);}
.scopt.sel{border-color:var(--orange);box-shadow:0 0 0 2px rgba(246,130,31,0.12);}
.scopt.dis{opacity:0.4;cursor:not-allowed;}
.scimg{height:64px;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:22px;overflow:hidden;border-bottom:1px solid var(--border-light);}
.scimg img{width:100%;height:100%;object-fit:cover;}
.scinf{padding:8px 10px;}
.scn{font-size:12px;font-weight:600;color:var(--text);margin-bottom:2px;}
.scd{font-size:11px;color:var(--text-4);line-height:1.4;}
.sccs{position:absolute;top:5px;right:5px;background:var(--bg);color:var(--text-4);font-size:9px;padding:2px 6px;border-radius:999px;border:1px solid var(--border);font-weight:600;}

.mfoot{display:flex;gap:8px;margin-top:16px;}
.btnCancel{flex:1;padding:9px;border:1px solid var(--border);background:var(--white);color:var(--text-3);border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;}
.btnCancel:hover{background:var(--bg);}
.btnSub{flex:2;padding:9px;background:var(--orange);color:white;border:1px solid var(--orange-dark);border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.12s;}
.btnSub:hover{background:var(--orange-dark);}
.btnSub:disabled{opacity:0.5;cursor:not-allowed;}

/* ── PAIRING MODAL ── */
.pair-ov{position:fixed;inset:0;background:rgba(15,23,42,0.5);backdrop-filter:blur(6px);z-index:300;display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;pointer-events:none;transition:opacity 0.2s;}
.pair-ov.show{opacity:1;pointer-events:all;}
.pair-modal{background:var(--white);border:1px solid var(--border);border-radius:10px;width:100%;max-width:480px;overflow:hidden;transform:scale(0.96);transition:transform 0.2s;box-shadow:0 20px 60px rgba(0,0,0,0.14);}
.pair-ov.show .pair-modal{transform:scale(1);}
.phd{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--bg);}
.phd-info{display:flex;align-items:center;gap:10px;}
.phd-ic{width:32px;height:32px;border-radius:8px;background:var(--orange-light);border:1px solid #fed7aa;display:flex;align-items:center;justify-content:center;font-size:15px;}
.phd-title{font-size:14px;font-weight:600;color:var(--text);}
.phd-sub{font-size:11px;color:var(--text-4);margin-top:1px;font-family:monospace;}
.pbody{padding:20px;display:flex;gap:20px;align-items:flex-start;}
.psteps{flex:1;}
.psteps-lbl{font-size:10px;font-weight:700;color:var(--orange);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:12px;}
.pstep{display:flex;align-items:flex-start;gap:9px;margin-bottom:10px;}
.psn{width:18px;height:18px;border-radius:50%;background:var(--orange-light);border:1px solid #fed7aa;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:var(--orange);flex-shrink:0;margin-top:2px;}
.pst{font-size:12px;color:var(--text-3);line-height:1.5;}
.pst b{color:var(--text);}
.pcode-side{flex-shrink:0;display:flex;flex-direction:column;align-items:center;gap:8px;}
.pcode-box{width:140px;height:140px;border-radius:10px;background:var(--bg);border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;}
.pcode-val{font-family:monospace;font-size:20px;font-weight:700;letter-spacing:2px;color:var(--text);}
.pcode-lbl{font-size:10px;color:var(--text-4);margin-top:5px;font-weight:500;}
.ploading{display:flex;flex-direction:column;align-items:center;gap:8px;}
.spinner{width:28px;height:28px;border:2px solid var(--border);border-top-color:var(--orange);border-radius:50%;animation:spin 0.8s linear infinite;}
@keyframes spin{to{transform:rotate(360deg);}}
.spintxt{font-size:11px;color:var(--text-4);text-align:center;line-height:1.5;}
.pcode-copy{padding:5px 12px;background:var(--orange-light);border:1px solid #fed7aa;border-radius:5px;color:var(--orange-dark);font-size:11px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.12s;display:none;}
.pcode-copy:hover{background:#fed7aa;}
.pfoot{padding:12px 18px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--bg);flex-wrap:wrap;gap:8px;}
.pstatus{display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-3);}
.sdot{width:6px;height:6px;border-radius:50%;background:var(--yellow);}
.sdot.blink{animation:blink 1.2s infinite;}
.sdot.ok{background:var(--green);}
.sdot.err{background:var(--red);}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.2}}

/* TOKEN POPUP */
.tok-ov{position:fixed;inset:0;background:rgba(15,23,42,0.5);backdrop-filter:blur(6px);z-index:400;display:flex;align-items:center;justify-content:center;padding:16px;opacity:0;pointer-events:none;transition:opacity 0.18s;}
.tok-ov.show{opacity:1;pointer-events:all;}
.tok-pop{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:24px;width:100%;max-width:320px;text-align:center;transform:scale(0.96);transition:transform 0.18s;box-shadow:0 20px 60px rgba(0,0,0,0.12);}
.tok-ov.show .tok-pop{transform:scale(1);}
.tok-ic{font-size:36px;margin-bottom:12px;}
.tok-pop h3{font-size:15px;font-weight:700;margin-bottom:6px;color:var(--text);}
.tok-pop p{color:var(--text-3);font-size:12px;line-height:1.6;margin-bottom:16px;}
.tok-btns{display:flex;flex-direction:column;gap:8px;}
.btnGoto{padding:10px;background:var(--orange);color:white;border:none;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:block;transition:all 0.12s;}
.btnGoto:hover{background:var(--orange-dark);}
.btnCloseTok{padding:9px;background:var(--white);border:1px solid var(--border);color:var(--text-3);border-radius:6px;font-size:13px;cursor:pointer;font-family:'Inter',sans-serif;}

/* CS FLOAT */
.cs-float{position:fixed;bottom:20px;right:20px;z-index:150;display:flex;align-items:center;gap:7px;padding:10px 16px;background:#25d366;color:white;border-radius:999px;text-decoration:none;font-size:13px;font-weight:600;box-shadow:0 4px 14px rgba(37,211,102,0.35);transition:all 0.15s;}
.cs-float:hover{background:#1fb855;transform:translateY(-1px);}

/* ── RESPONSIVE ── */
@media(max-width:900px){.stats-row{grid-template-columns:repeat(2,1fr);}}
@media(max-width:768px){
  .sidebar{transform:translateX(-100%);transition:transform 0.22s;}
  .sidebar.open{transform:translateX(0);}
  .main{margin-left:0;}
  .hamburger{display:flex;}
  .content{padding:16px;}
  .topbar{padding:0 16px;}
  .tbtn-ghost{display:none;}
  .nokos-banner{flex-direction:column;align-items:flex-start;}
  .pbody{flex-direction:column;align-items:center;}
  .pcode-side{order:-1;}
  .scgrid{grid-template-columns:1fr;}
  table{display:block;overflow-x:auto;}
}
@media(max-width:480px){
  .stats-row{grid-template-columns:1fr 1fr;}
  .stat-val{font-size:20px;}
}
</style>
</head>
<body>
<?php require_once 'config.php'; ?>

<div class="sidebar-overlay" id="sidebarOv" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<nav class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">❄️</div>
    <div>
      <div class="logo-text">Polar.id</div>
      <div class="logo-sub">Bot Dashboard</div>
    </div>
  </div>
  <div class="sidebar-nav">
    <div class="nav-section">Menu</div>
    <a href="dashboard.php" class="nav-item active"><span class="nav-icon">🤖</span> Session Bot</a>
          <a href="premium.php" class="nav-item"><span class="nav-icon">💎</span> Premium</a>
    <a href="features.php" class="nav-item"><span class="nav-icon">📋</span> Fitur Script</a>
    <a href="event.php" class="nav-item"><span class="nav-icon">🎁</span> Event</a>
    <div class="nav-section">Lainnya</div>
    <a href="token.php" target="_blank" class="nav-item"><span class="nav-icon">🎟️</span> Ambil Token</a>
    <a href="https://wa.me/6285715294026" target="_blank" class="nav-item"><span class="nav-icon">💬</span> Customer Service</a>
    <a href="index.php" class="nav-item"><span class="nav-icon">🏠</span> Beranda</a>
  </div>
  <div class="sidebar-foot">
    <div class="fp-card">
      <div class="fp-label">Device ID</div>
      <div class="fp-val" id="fpDisplay">Memuat...</div>
    </div>
  </div>
</nav>

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <button class="hamburger" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
      </button>
      <div class="topbar-title">Session Bot</div>
    </div>
    <div class="topbar-right">
      <a href="https://sfl.gl/rHjdO" target="_blank" class="tbtn tbtn-ghost">🎟 Token Gratis</a>
      <button class="tbtn tbtn-primary" id="btnAdd" onclick="openAdd()" disabled>+ Tambah Session</button>
    </div>
  </div>

  <div class="content">
    <div class="alert" id="alertEl"></div>

    <!-- NOKOS BANNER -->
    <div class="nokos-banner">
      <div class="nokos-text">
        📱 <b>Belum punya nomor untuk bot?</b>
        <span>Beli nomor kosong (nokos) murah, langsung siap pakai sebagai bot WhatsApp.</span>
      </div>
      <a href="https://wa.me/6285715294026?text=Halo%20kak%2C%20mau%20beli%20nomor%20kosong%20untuk%20bot%20WA" target="_blank" class="nokos-btn">Beli Nokos →</a>
    </div>

    <!-- STATS -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-label">Total Session</div>
        <div class="stat-val" id="statCount">—</div>
        <div class="stat-sub">Session terdaftar</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Maks Session</div>
        <div class="stat-val"><?= MAX_SESSIONS_PER_FINGERPRINT ?></div>
        <div class="stat-sub">Batas per device</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Slot Tersisa</div>
        <div class="stat-val" id="statSisa">—</div>
        <div class="stat-sub">Bisa ditambah</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Online</div>
        <div class="stat-val" id="statOnline">—</div>
        <div class="stat-sub">Bot aktif sekarang</div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header">
        <div>
          <div class="table-title">Daftar Session</div>
          <div class="table-subtitle">Kelola semua bot WhatsApp kamu</div>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Nomor Bot</th>
            <th>Script</th>
            <th>Status</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="sessBody">
          <tr class="empty-row"><td colspan="5"><span class="empty-icon">⏳</span>Memuat session......</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ADD MODAL -->
<div class="ov" id="addOv">
  <div class="modal">
    <div class="mhd">
      <div class="mttl">Tambah Session Baru</div>
      <button class="mclose" onclick="closeAdd()">✕</button>
    </div>
    <div class="mbody">
      <div class="fgrp">
        <span class="flbl">Pilih Script</span>
        <div class="scgrid">
          <div class="scopt sel" onclick="selSc('phoenix_premium',this)" id="sc-phoenix_premium">
            <div class="scimg"><img src="assets/img/phoenix.jpg" onerror="this.parentElement.innerHTML='🤖'"></div>
            <div class="scinf"><div class="scn">Phoenix premium MD</div><div class="scd">Bot lengkap multi device.</div></div>
          </div>
              
          <div class="scopt dis">
            <div class="scimg">🔜</div>
            <div class="sccs">Coming Soon</div>
            <div class="scinf"><div class="scn">Nyx Bot</div><div class="scd">Bot premium AI.</div></div>
          </div>
        </div>
        <input type="hidden" id="selScr" value="phoenix_mmd">
      </div>
      <div class="fgrp">
        <label class="flbl">Nomor WhatsApp Bot <span>(format internasional, contoh: 628xxx)</span></label>
        <input type="text" class="finp" id="inpPhone" placeholder="628xxxxxxxxxx" inputmode="numeric">
      </div>
      <div class="fgrp">
        <label class="flbl">Token Aktivasi <span>(berlaku 10 menit)</span></label>
        <div class="tokrow">
          <input type="text" class="finp" id="inpToken" placeholder="Masukkan token">
          <button class="btnTok" onclick="showTok()">Gratis →</button>
        </div>
      </div>
      <div class="mfoot">
        <button class="btnCancel" onclick="closeAdd()">Batal</button>
        <button class="btnSub" id="btnSub" onclick="createSession()">Buat Session</button>
      </div>
    </div>
  </div>
</div>

<!-- PAIRING MODAL -->
<div class="pair-ov" id="pairOv">
  <div class="pair-modal">
    <div class="phd">
      <div class="phd-info">
        <div class="phd-ic">🔗</div>
        <div>
          <div class="phd-title">Tautkan Perangkat</div>
          <div class="phd-sub" id="pairPhone">+62xxx</div>
        </div>
      </div>
      <button class="mclose" onclick="closePair()">✕</button>
    </div>
    <div class="pbody">
      <div class="psteps">
        <div class="psteps-lbl">Cara menautkan</div>
        <div class="pstep"><div class="psn">1</div><div class="pst">Buka <b>WhatsApp</b> di HP kamu</div></div>
        <div class="pstep"><div class="psn">2</div><div class="pst">Ketuk <b>⋮ → Perangkat Tertaut</b></div></div>
        <div class="pstep"><div class="psn">3</div><div class="pst">Ketuk <b>Tautkan dengan nomor telepon</b></div></div>
        <div class="pstep"><div class="psn">4</div><div class="pst">Masukkan kode yang tampil di kanan</div></div>
      </div>
      <div class="pcode-side">
        <div class="pcode-box" id="pairBox">
          <div class="ploading"><div class="spinner"></div><div class="spintxt">Menunggu<br>pairing code...</div></div>
        </div>
        <button class="pcode-copy" id="btnCopy" onclick="copyCode()">Salin Kode</button>
      </div>
    </div>
    <div class="pfoot">
      <div class="pstatus">
        <div class="sdot blink" id="pairDot"></div>
        <span id="pairTxt">Menunggu pairing code...</span>
      </div>
      <button class="act act-del" onclick="closePair()">Tutup</button>
    </div>
  </div>
</div>

<!-- TOKEN POPUP -->
<div class="tok-ov" id="tokOv">
  <div class="tok-pop">
    <div class="tok-ic">🎟️</div>
    <h3>Token Gratis</h3>
    <p>Dapatkan token aktivasi gratis untuk mengaktifkan session bot kamu. Token berlaku 10 menit.</p>
    <div class="tok-btns">
      <a href="https://sfl.gl/lvvR" target="_blank" class="btnGoto" onclick="closeTok()">Dapatkan Token Gratis</a>
      <button class="btnCloseTok" onclick="closeTok()">Tutup</button>
    </div>
  </div>
</div>

<a href="https://wa.me/6285715294026" target="_blank" class="cs-float">💬 CS</a>

<script>
const SB_URL = '<?= SUPABASE_URL ?>'
const SB_KEY = '<?= SUPABASE_KEY ?>'
const MAX = <?= MAX_SESSIONS_PER_FINGERPRINT ?>

let fp='', sessions=[], activePair=null, curCode=null

// ✅ FIX: Generate UNIQUE device ID yang benar-benar unik per browser/perangkat
async function getFP() {
  // Cek apakah sudah ada ID tersimpan di localStorage
  let uniqueId = localStorage.getItem('polar_device_unique_id');
  
  if (!uniqueId) {
    // Generate ID unik menggunakan kombinasi random + timestamp
    const randomPart = crypto.randomUUID(); // UUID v4 yang sangat unik
    const timestamp = Date.now();
    const randomNum = Math.random().toString(36).substring(2, 15);
    uniqueId = `${randomPart}-${timestamp}-${randomNum}`;
    
    // Simpan ke localStorage agar tetap sama untuk browser ini
    localStorage.setItem('polar_device_unique_id', uniqueId);
    
    // Tambahkan juga timestamp registrasi pertama kali
    localStorage.setItem('polar_device_registered_at', timestamp.toString());
  }
  
  // Dapatkan registration time
  const regTime = localStorage.getItem('polar_device_registered_at') || Date.now();
  
  // Data browser yang lebih lengkap dan unik
  const raw = [
    navigator.userAgent,
    navigator.language,
    navigator.platform,
    screen.width,
    screen.height,
    screen.colorDepth,
    new Date().getTimezoneOffset(),
    navigator.hardwareConcurrency || '',
    navigator.deviceMemory || '',
    uniqueId,              // ← KUNCI UTAMA: ID unik dari localStorage
    regTime,               // ← Waktu registrasi pertama
    navigator.maxTouchPoints || 0,  // Tambahan: touch support (beda HP vs PC)
    !!window.chrome,       // Apakah Chrome?
    !!navigator.userAgentData, // User agent data modern
    screen.availWidth,     // Lebar layar available
    screen.availHeight,    // Tinggi layar available
    window.devicePixelRatio || 1  // Rasio pixel (beda layar retina vs non-retina)
  ].join('|')
  
  // Hash dengan SHA-256
  const buf = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(raw))
  const hash = Array.from(new Uint8Array(buf)).map(b => b.toString(16).padStart(2,'0')).join('')
  
  // Kembalikan 32 karakter pertama
  return hash.slice(0, 32)
}

// Fungsi untuk reset device ID (kalau perlu)
async function resetDeviceID() {
  if (confirm('Reset Device ID akan menghapus semua session yang tersimpan di perangkat ini. Lanjutkan?')) {
    localStorage.removeItem('polar_device_unique_id');
    localStorage.removeItem('polar_device_registered_at');
    alert2('Device ID akan di-reset setelah refresh halaman.','ok');
    setTimeout(() => location.reload(), 1500);
  }
}

async function sb(m,ep,body=null) {
  const ctrl=new AbortController()
  const timer=setTimeout(()=>ctrl.abort(),15000)
  try {
    const r=await fetch(`${SB_URL}/rest/v1/${ep}`,{
      method:m,headers:{'Content-Type':'application/json',apikey:SB_KEY,Authorization:`Bearer ${SB_KEY}`,Prefer:'return=representation'},
      body:body?JSON.stringify(body):null,signal:ctrl.signal
    })
    clearTimeout(timer)
    if(!r.ok){const e=await r.text();throw new Error(`HTTP ${r.status}: ${e}`)}
    const t=await r.text();return t?JSON.parse(t):[]
  } catch(e){clearTimeout(timer);if(e.name==='AbortError')throw new Error('Koneksi timeout');throw e}
}

function validatePhone(raw) {
  const phone=raw.replace(/[\s\-\(\)\+]/g,'')
  if(!/^\d+$/.test(phone))return{valid:false,msg:'❌ Nomor hanya boleh angka'}
  if(phone.length<7)return{valid:false,msg:'❌ Nomor terlalu pendek'}
  if(phone.length>15)return{valid:false,msg:'❌ Nomor terlalu panjang'}
  return{valid:true,phone}
}

async function syncStatus() {
  let changed=false
  for(const s of sessions){
    if(s.status==='online')continue
    try{
      const pair=await sb('GET',`polar_sessions?phone=eq.${s.phone}&select=status,pairing_code&limit=1`)
      if(!pair?.length)continue
      const{status,pairing_code}=pair[0]
      if(status!==s.status||pairing_code!==s.pairing_code){
        s.status=status;s.pairing_code=pairing_code;changed=true
        if(activePair===s.phone)updatePairUI(s)
      }
    }catch{}
  }
  if(changed){renderTable();updateStats()}
}

async function load() {
  try{const res=await sb('GET',`polar_sessions?fingerprint=eq.${fp}&order=created_at.desc`);sessions=Array.isArray(res)?res:[]}
  catch{sessions=[]}
  renderTable();updateStats()
}

function updateStats() {
  const online=sessions.filter(s=>s.status==='online').length
  document.getElementById('statCount').textContent=sessions.length
  document.getElementById('statSisa').textContent=Math.max(0,MAX-sessions.length)
  document.getElementById('statOnline').textContent=online
  document.getElementById('btnAdd').disabled=sessions.length>=MAX
}

function badgeClass(s){return{online:'badge-online',offline:'badge-offline',pending:'badge-pending',waiting_pair:'badge-waiting',processing:'badge-waiting'}[s]||'badge-pending'}
function badgeLabel(s){return{online:'Online',offline:'Offline',pending:'Pending',waiting_pair:'Waiting Pair',processing:'Processing'}[s]||s}

function renderTable() {
  const tb=document.getElementById('sessBody')
  if(!sessions.length){
    tb.innerHTML=`<tr class="empty-row"><td colspan="5"><span class="empty-icon">🤖</span>Belum ada session. Klik <b>Tambah Session</b> untuk mulai.</td></tr>`
    return
  }
  tb.innerHTML=sessions.map(s=>{
    const d=new Date(s.created_at)
    const dt=d.toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'})
    const showView=['pending','processing','waiting_pair'].includes(s.status)
    return `<tr>
      <td><span class="td-phone">+${s.phone}</span></td>
      <td><span class="td-script">${s.script}</span></td>
      <td><span class="badge ${badgeClass(s.status)}">${badgeLabel(s.status)}</span></td>
      <td><span class="td-date">${dt}</span></td>
      <td><div class="td-actions">
        ${showView?`<button class="act act-view" onclick="openPair('${s.phone}')">Lihat Pairing</button>`:''}
        <button class="act act-del" onclick="delSession(${s.id},'${s.phone}')">Hapus</button>
      </div></td>
    </tr>`
  }).join('')
}

async function createSession() {
  const rawPhone=document.getElementById('inpPhone').value.trim()
  const token=document.getElementById('inpToken').value.trim().toUpperCase()
  const script=document.getElementById('selScr').value
  const phoneCheck=validatePhone(rawPhone)
  if(!phoneCheck.valid)return alert2(phoneCheck.msg,'err')
  const phone=phoneCheck.phone
  if(!token)return alert2('❌ Token tidak boleh kosong','err')
  if(token.length<6)return alert2('❌ Token terlalu pendek','err')
  if(sessions.length>=MAX)return alert2('❌ Slot session penuh. Hubungi CS untuk tambah slot.','err')
  if(sessions.find(s=>s.phone===phone))return alert2('❌ Nomor ini sudah punya session aktif','err')
  const btn=document.getElementById('btnSub')
  const orig=btn.textContent;btn.disabled=true;btn.textContent='Mengecek token...'
  try{
    let rd;try{rd=await sb('GET',`redeems?code=eq.${token}&select=*`)}
    catch(e){throw new Error('Gagal terhubung ke server. Periksa koneksi internet.')}
    if(!rd?.length)throw new Error('Token tidak ditemukan. Pastikan token sudah benar.')
    if(rd[0].used)throw new Error('Token sudah pernah digunakan. Ambil token baru.')
    const age=Date.now()-rd[0].created_at
    if(age>600000){const m=Math.floor(age/60000);throw new Error(`Token expired (${m} menit lalu). Token hanya berlaku 10 menit.`)}
    btn.textContent='Membuat session...'
    await sb('PATCH',`redeems?code=eq.${token}`,{used:true,used_by:fp,phone})
    await sb('POST','polar_sessions',{fingerprint:fp,phone,script,status:'pending',token_used:token,pairing_code:null,created_at:Date.now()})
    closeAdd();await load()
    alert2('✅ Session dibuat! Pairing code akan muncul dalam beberapa detik.','ok')
    setTimeout(()=>openPair(phone),800)
  }catch(e){alert2('❌ '+e.message,'err')}
  finally{btn.disabled=false;btn.textContent=orig}
}

async function delSession(id,phone) {
  if(!confirm(`Hapus session +${phone}?`))return
  try{await sb('DELETE',`polar_sessions?id=eq.${id}`);if(activePair===phone)closePair();alert2('✅ Session dihapus.','ok');load()}
  catch(e){alert2('❌ Gagal hapus: '+e.message,'err')}
}

function openPair(phone) {
  activePair=phone;curCode=null
  document.getElementById('pairPhone').textContent='+'+phone
  document.getElementById('pairOv').classList.add('show')
  const s=sessions.find(x=>x.phone===phone)
  if(s)updatePairUI(s);else resetPair()
}
function closePair(){document.getElementById('pairOv').classList.remove('show');activePair=null;curCode=null}

function updatePairUI(s) {
  const box=document.getElementById('pairBox'),dot=document.getElementById('pairDot'),txt=document.getElementById('pairTxt'),cp=document.getElementById('btnCopy')
  if(s.status==='waiting_pair'&&s.pairing_code){
    curCode=s.pairing_code
    box.innerHTML=`<div class="pcode-val">${s.pairing_code}</div><div class="pcode-lbl">Kode Pairing</div>`
    dot.className='sdot blink';txt.textContent='Masukkan kode ini di WhatsApp';cp.style.display='block'
  }else if(s.status==='online'){
    box.innerHTML=`<div style="font-size:36px">✅</div><div style="font-size:11px;color:var(--green);margin-top:6px;font-weight:600">Terhubung!</div>`
    dot.className='sdot ok';txt.textContent='Bot berhasil terhubung';cp.style.display='none'
  }else if(s.status==='offline'){
    box.innerHTML=`<div style="font-size:36px">❌</div><div style="font-size:11px;color:var(--red);margin-top:6px;font-weight:600">Offline</div>`
    dot.className='sdot err';txt.textContent='Bot terputus';cp.style.display='none'
  }else{
    resetPair()
    txt.textContent={pending:'Menunggu bot memproses...',processing:'Bot sedang memproses...'}[s.status]||'Menunggu...'
  }
}

function resetPair(){
  document.getElementById('pairBox').innerHTML=`<div class="ploading"><div class="spinner"></div><div class="spintxt">Menunggu<br>pairing code...</div></div>`
  document.getElementById('pairDot').className='sdot blink'
  document.getElementById('btnCopy').style.display='none'
}

function copyCode(){
  if(!curCode)return
  navigator.clipboard.writeText(curCode).then(()=>{const b=document.getElementById('btnCopy');b.textContent='✓ Disalin';setTimeout(()=>b.textContent='Salin Kode',2000)})
}

function alert2(msg,type){
  const el=document.getElementById('alertEl');el.className=`alert alert-${type}`;el.style.display='block';el.textContent=msg
  clearTimeout(el._t);el._t=setTimeout(()=>el.style.display='none',6000)
}
function openAdd(){document.getElementById('inpPhone').value='';document.getElementById('inpToken').value='';document.getElementById('addOv').classList.add('show')}
function closeAdd(){document.getElementById('addOv').classList.remove('show')}
function showTok(){document.getElementById('tokOv').classList.add('show')}
function closeTok(){document.getElementById('tokOv').classList.remove('show')}
function selSc(k,el){document.querySelectorAll('.scopt:not(.dis)').forEach(e=>e.classList.remove('sel'));el.classList.add('sel');document.getElementById('selScr').value=k}
function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sidebarOv').classList.toggle('show')}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarOv').classList.remove('show')}

// Tambahkan tombol reset device ID di sidebar (opsional)
// Bisa ditambahkan di sidebar-foot jika ingin
document.addEventListener('DOMContentLoaded', () => {
  // Tambahkan tombol reset di footer (opsional - uncomment jika ingin)
  // const footDiv = document.querySelector('.sidebar-foot');
  // const resetBtn = document.createElement('button');
  // resetBtn.textContent = '🔄 Reset Device ID';
  // resetBtn.style.cssText = 'margin-top:10px;padding:6px;font-size:11px;background:#f0f0f0;border:1px solid #ddd;border-radius:5px;cursor:pointer;width:100%';
  // resetBtn.onclick = resetDeviceID;
  // footDiv.appendChild(resetBtn);
});

document.getElementById('addOv').addEventListener('click',e=>{if(e.target===e.currentTarget)closeAdd()})
document.getElementById('pairOv').addEventListener('click',e=>{if(e.target===e.currentTarget)closePair()})
document.getElementById('tokOv').addEventListener('click',e=>{if(e.target===e.currentTarget)closeTok()})
document.getElementById('inpToken').addEventListener('input',function(){this.value=this.value.toUpperCase()})

async function init(){
  fp = await getFP()
  // Tampilkan fingerprint dengan format lebih rapi
  const fpDisplay = document.getElementById('fpDisplay')
  fpDisplay.textContent = fp.slice(0, 16) + '...' + fp.slice(-8)
  fpDisplay.title = fp // Tampilkan full fingerprint saat hover
  
  await load()
  setInterval(async()=>{
    try{
      await syncStatus()
      if(sessions.some(s=>['pending','waiting_pair','processing'].includes(s.status)))await load()
    }catch{}
  },3000)
}
init()
</script>
</body>
</html>