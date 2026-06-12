<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>Dashboard — Polar.id</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.3);z-index:99;}
.sidebar-overlay.show{display:block;}

/* ── MAIN ── */
.main{margin-left:var(--sidebar-w);display:flex;flex-direction:column;min-height:100vh;}
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
.tbtn{padding:7px 14px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all 0.12s;font-family:'Inter',sans-serif;border:1px solid transparent;white-space:nowrap;}
.tbtn-primary{background:var(--orange);color:white;border-color:var(--orange-dark);}
.tbtn-primary:hover{background:var(--orange-dark);}
.tbtn-primary:disabled{opacity:0.45;cursor:not-allowed;}

.content{padding:24px;flex:1;}

/* ALERT */
.alert{padding:10px 14px;border-radius:6px;margin-bottom:16px;font-size:13px;display:none;font-weight:500;}
.alert-ok{background:var(--green-bg);border:1px solid var(--green-border);color:var(--green);}
.alert-err{background:var(--red-bg);border:1px solid var(--red-border);color:var(--red);}

/* SESSION CARD */
.sessions-grid{display:flex;flex-direction:column;gap:24px;}
.session-card{
  background:var(--white);
  border:1px solid var(--border);
  border-radius:12px;
  overflow:hidden;
  box-shadow:var(--shadow);
  transition:box-shadow 0.2s;
}
.session-card:hover{box-shadow:var(--shadow-md);}
.session-card-header{
  padding:16px 20px;
  background:var(--bg);
  border-bottom:1px solid var(--border);
  display:flex;
  align-items:center;
  justify-content:space-between;
  flex-wrap:wrap;
  gap:12px;
}
.session-info{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
.session-phone{
  font-size:16px;
  font-weight:700;
  color:var(--text);
  font-family:monospace;
}
.session-badge{
  display:inline-flex;
  align-items:center;
  gap:5px;
  padding:3px 9px;
  border-radius:999px;
  font-size:11px;
  font-weight:600;
}
.session-badge::before{
  content:'';
  width:5px;
  height:5px;
  border-radius:50%;
  flex-shrink:0;
}
.badge-online{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
.badge-online::before{background:var(--green);}
.badge-offline{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
.badge-offline::before{background:var(--red);}
.badge-pending{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
.badge-pending::before{background:var(--yellow);}
.session-script{
  font-size:12px;
  color:var(--text-3);
  background:var(--bg);
  padding:4px 8px;
  border-radius:6px;
}
.session-package{
  font-size:12px;
  padding:4px 10px;
  border-radius:6px;
  font-weight:600;
}
.package-free{background:var(--bg);color:var(--text-3);border:1px solid var(--border);}
.package-premium{background:linear-gradient(135deg,var(--orange-light),#fffbf5);color:var(--orange-dark);border:1px solid #fed7aa;}
.session-actions{display:flex;gap:8px;}

/* SESSION BODY */
.session-card-body{padding:20px;}
.session-stats-row{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:16px;
  margin-bottom:20px;
}
.mini-stat{
  background:var(--bg);
  border-radius:8px;
  padding:12px;
  border:1px solid var(--border-light);
}
.mini-stat-label{
  font-size:11px;
  color:var(--text-4);
  text-transform:uppercase;
  font-weight:600;
  margin-bottom:4px;
}
.mini-stat-val{
  font-size:18px;
  font-weight:700;
  color:var(--text);
}
.chart-container{
  background:var(--bg);
  border-radius:8px;
  padding:12px;
  border:1px solid var(--border-light);
  margin-bottom:16px;
}
.chart-title{
  font-size:12px;
  font-weight:600;
  color:var(--text-2);
  margin-bottom:12px;
  display:flex;
  align-items:center;
  gap:6px;
}
canvas.ram-chart{max-height:200px;width:100%;}

/* TOGGLE SWITCH */
.toggle-group{display:flex;gap:16px;margin-top:8px;}
.toggle-item{flex:1;}
.toggle-label{
  font-size:11px;
  font-weight:600;
  color:var(--text-3);
  margin-bottom:6px;
  display:flex;
  align-items:center;
  gap:6px;
}
.switch{
  position:relative;
  display:inline-block;
  width:44px;
  height:22px;
}
.switch input{opacity:0;width:0;height:0;}
.slider{
  position:absolute;
  cursor:pointer;
  top:0;
  left:0;
  right:0;
  bottom:0;
  background-color:var(--border);
  transition:0.2s;
  border-radius:22px;
}
.slider:before{
  position:absolute;
  content:"";
  height:18px;
  width:18px;
  left:2px;
  bottom:2px;
  background-color:white;
  transition:0.2s;
  border-radius:50%;
}
input:checked + .slider{background-color:var(--orange);}
input:checked + .slider:before{transform:translateX(22px);}
.toggle-status{
  font-size:11px;
  color:var(--text-4);
  margin-top:4px;
}

/* MODAL */
.ov{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,0.4);
  backdrop-filter:blur(4px);
  z-index:200;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:16px;
  opacity:0;
  pointer-events:none;
  transition:opacity 0.18s;
}
.ov.show{opacity:1;pointer-events:all;}
.modal{
  background:var(--white);
  border:1px solid var(--border);
  border-radius:10px;
  width:100%;
  max-width:500px;
  max-height:92vh;
  overflow-y:auto;
  transform:translateY(10px);
  transition:transform 0.18s;
  box-shadow:0 20px 60px rgba(0,0,0,0.12);
}
.ov.show .modal{transform:translateY(0);}
.mhd{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.mttl{font-size:15px;font-weight:600;color:var(--text);}
.mclose{
  width:28px;height:28px;border-radius:6px;
  background:var(--bg);border:1px solid var(--border);
  color:var(--text-3);cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  font-size:14px;
}
.mclose:hover{background:var(--red-bg);color:var(--red);}
.mbody{padding:20px;}
.fgrp{margin-bottom:14px;}
.flbl{display:block;font-size:12px;font-weight:600;color:var(--text-2);margin-bottom:5px;}
.finp{
  width:100%;padding:9px 12px;
  background:var(--white);border:1px solid var(--border);
  border-radius:6px;color:var(--text);font-size:13px;
  outline:none;
}
.finp:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(246,130,31,0.08);}
.tokrow{display:flex;gap:8px;}
.tokrow .finp{flex:1;}
.btnTok{
  padding:9px 12px;background:var(--bg);
  border:1px solid var(--border);border-radius:6px;
  font-size:12px;font-weight:600;cursor:pointer;
}
.btnTok:hover{background:var(--orange-light);border-color:#fed7aa;color:var(--orange-dark);}

/* PACKAGE SELECTOR */
.pkg-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;}
.pkg-opt{
  border:2px solid var(--border);
  border-radius:10px;
  padding:12px;
  cursor:pointer;
  transition:all 0.12s;
  position:relative;
}
.pkg-opt:hover{border-color:var(--orange);}
.pkg-opt.sel{border-color:var(--orange);background:var(--orange-light);}
.pkg-name{font-size:14px;font-weight:700;margin-bottom:4px;}
.pkg-name.free{color:var(--text-2);}
.pkg-name.prem{color:var(--orange-dark);}
.pkg-price{font-size:12px;color:var(--text-4);font-weight:500;}
.pkg-desc{font-size:11px;color:var(--text-3);margin-top:6px;}

/* SCRIPT SELECTOR */
.scgrid{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;}
.scopt{
  border:1px solid var(--border);
  border-radius:8px;
  overflow:hidden;
  cursor:pointer;
  transition:all 0.12s;
}
.scopt:hover{border-color:var(--orange);}
.scopt.sel{border-color:var(--orange);box-shadow:0 0 0 2px rgba(246,130,31,0.12);}
.scopt.dis{opacity:0.4;cursor:not-allowed;}
.scimg{
  height:64px;
  background:var(--bg);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:22px;
  border-bottom:1px solid var(--border-light);
}
.scinf{padding:8px 10px;}
.scn{font-size:12px;font-weight:600;color:var(--text);margin-bottom:2px;}
.scd{font-size:11px;color:var(--text-4);}

.mfoot{display:flex;gap:8px;margin-top:16px;}
.btnCancel{flex:1;padding:9px;border:1px solid var(--border);background:var(--white);color:var(--text-3);border-radius:6px;cursor:pointer;}
.btnCancel:hover{background:var(--bg);}
.btnSub{flex:2;padding:9px;background:var(--orange);color:white;border:1px solid var(--orange-dark);border-radius:6px;font-weight:600;cursor:pointer;}
.btnSub:hover{background:var(--orange-dark);}
.btnSub:disabled{opacity:0.5;cursor:not-allowed;}

/* PAIRING MODAL */
.pair-ov{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,0.5);
  backdrop-filter:blur(6px);
  z-index:300;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:16px;
  opacity:0;
  pointer-events:none;
  transition:opacity 0.2s;
}
.pair-ov.show{opacity:1;pointer-events:all;}
.pair-modal{
  background:var(--white);
  border:1px solid var(--border);
  border-radius:10px;
  width:100%;
  max-width:480px;
  overflow:hidden;
  transform:scale(0.96);
  transition:transform 0.2s;
}
.pair-ov.show .pair-modal{transform:scale(1);}
.phd{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--bg);}
.phd-info{display:flex;align-items:center;gap:10px;}
.phd-ic{width:32px;height:32px;border-radius:8px;background:var(--orange-light);display:flex;align-items:center;justify-content:center;font-size:15px;}
.phd-title{font-size:14px;font-weight:600;color:var(--text);}
.pbody{padding:20px;display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap;}
.psteps{flex:1;}
.psteps-lbl{font-size:10px;font-weight:700;color:var(--orange);text-transform:uppercase;margin-bottom:12px;}
.pstep{display:flex;align-items:flex-start;gap:9px;margin-bottom:10px;}
.psn{width:18px;height:18px;border-radius:50%;background:var(--orange-light);border:1px solid #fed7aa;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:var(--orange);flex-shrink:0;}
.pst{font-size:12px;color:var(--text-3);}
.pcode-side{flex-shrink:0;text-align:center;}
.pcode-box{
  width:140px;height:140px;
  border-radius:10px;
  background:var(--bg);
  border:1px solid var(--border);
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
}
.pcode-val{font-family:monospace;font-size:20px;font-weight:700;letter-spacing:2px;color:var(--text);}
.pcode-copy{padding:5px 12px;margin-top:8px;background:var(--orange-light);border:1px solid #fed7aa;border-radius:5px;color:var(--orange-dark);font-size:11px;font-weight:600;cursor:pointer;display:none;}
.pfoot{padding:12px 18px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--bg);}
.pstatus{display:flex;align-items:center;gap:7px;font-size:12px;color:var(--text-3);}
.sdot{width:6px;height:6px;border-radius:50%;background:var(--yellow);}
.sdot.blink{animation:blink 1.2s infinite;}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.2}}

/* TOKEN POPUP */
.tok-ov{
  position:fixed;
  inset:0;
  background:rgba(15,23,42,0.5);
  backdrop-filter:blur(6px);
  z-index:400;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:16px;
  opacity:0;
  pointer-events:none;
  transition:opacity 0.18s;
}
.tok-ov.show{opacity:1;pointer-events:all;}
.tok-pop{
  background:var(--white);
  border-radius:10px;
  padding:24px;
  width:100%;
  max-width:320px;
  text-align:center;
}
.tok-pop h3{font-size:15px;font-weight:700;margin-bottom:6px;}
.tok-pop p{color:var(--text-3);font-size:12px;margin-bottom:16px;}
.btnGoto{
  display:block;padding:10px;background:var(--orange);color:white;
  border-radius:6px;text-decoration:none;font-size:13px;font-weight:600;
  margin-bottom:8px;
}
.btnCloseTok{padding:9px;background:var(--white);border:1px solid var(--border);border-radius:6px;cursor:pointer;width:100%;}

/* CS FLOAT */
.cs-float{position:fixed;bottom:20px;right:20px;z-index:150;display:flex;align-items:center;gap:7px;padding:10px 16px;background:#25d366;color:white;border-radius:999px;text-decoration:none;font-size:13px;font-weight:600;box-shadow:0 4px 14px rgba(37,211,102,0.35);}

@media(max-width:768px){
  .sidebar{transform:translateX(-100%);transition:transform 0.22s;}
  .sidebar.open{transform:translateX(0);}
  .main{margin-left:0;}
  .hamburger{display:flex;}
  .content{padding:16px;}
  .session-stats-row{grid-template-columns:1fr;}
  .pkg-grid{grid-template-columns:1fr;}
}
</style>
</head>
<body>
<?php require_once 'config.php'; ?>

<div class="sidebar-overlay" id="sidebarOv" onclick="closeSidebar()"></div>

<nav class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">❄️</div>
    <div><div class="logo-text">Polar.id</div><div class="logo-sub">Bot Dashboard</div></div>
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
    <div class="fp-card"><div class="fp-label">Device ID</div><div class="fp-val" id="fpDisplay">Memuat...</div></div>
  </div>
</nav>

<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <button class="hamburger" onclick="toggleSidebar()"><span></span><span></span><span></span></button>
      <div class="topbar-title">Session Bot</div>
    </div>
    <div class="topbar-right">
      <a href="https://sfl.gl/rHjdO" target="_blank" class="tbtn tbtn-ghost" style="background:white;border:1px solid var(--border);padding:7px 14px;border-radius:6px;text-decoration:none;color:var(--text-2);margin-right:8px;">🎟 Token Gratis</a>
      <button class="tbtn tbtn-primary" id="btnAdd" onclick="openAdd()">+ Tambah Session</button>
    </div>
  </div>

  <div class="content">
    <div class="alert" id="alertEl"></div>

    <!-- SESSIONS GRID -->
    <div class="sessions-grid" id="sessionsGrid">
      <div style="text-align:center;padding:48px;color:var(--text-4);">⏳ Memuat session...</div>
    </div>
  </div>
</div>

<!-- ADD MODAL -->
<div class="ov" id="addOv">
  <div class="modal">
    <div class="mhd"><div class="mttl">Tambah Session Baru</div><button class="mclose" onclick="closeAdd()">✕</button></div>
    <div class="mbody">
      <div class="fgrp">
        <span class="flbl">Pilih Paket</span>
        <div class="pkg-grid">
          <div class="pkg-opt sel" onclick="selectPackage('free',this)">
            <div class="pkg-name free">📦 Free</div>
            <div class="pkg-price">Rp0 / bulan</div>
            <div class="pkg-desc">Shared resource, cocok untuk uji coba</div>
          </div>
          <div class="pkg-opt" onclick="selectPackage('premium',this)">
            <div class="pkg-name prem">⭐ Premium</div>
            <div class="pkg-price">Rp10.000 / bulan</div>
            <div class="pkg-desc">Private resource, performa maksimal</div>
          </div>
        </div>
        <input type="hidden" id="selectedPackage" value="free">
      </div>
      <div class="fgrp">
        <span class="flbl">Pilih Script</span>
        <div class="scgrid">
          <div class="scopt sel" onclick="selectScript('phoenix_md',this)">
            <div class="scimg">🤖</div>
            <div class="scinf"><div class="scn">Phoenix MD</div><div class="scd">Bot lengkap multi device</div></div>
          </div>
          <div class="scopt dis">
            <div class="scimg">🔜</div>
            <div class="scinf"><div class="scn">Nyx Bot</div><div class="scd">Coming Soon</div></div>
          </div>
        </div>
        <input type="hidden" id="selectedScript" value="phoenix_md">
      </div>
      <div class="fgrp">
        <label class="flbl">Nomor WhatsApp Bot <span>(628xxx)</span></label>
        <input type="text" class="finp" id="inpPhone" placeholder="628xxxxxxxxxx">
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

<!-- SETTING MODAL -->
<div class="ov" id="settingOv">
  <div class="modal">
    <div class="mhd"><div class="mttl">⚙️ Pengaturan Session</div><button class="mclose" onclick="closeSetting()">✕</button></div>
    <div class="mbody">
      <div class="fgrp">
        <label class="flbl">Mode Privasi Bot</label>
        <div class="toggle-group">
          <div class="toggle-item">
            <div class="toggle-label">🔒 Self Mode</div>
            <label class="switch">
              <input type="checkbox" id="selfToggle" onchange="toggleSelfMode()">
              <span class="slider"></span>
            </label>
            <div class="toggle-status" id="selfStatus">Hanya bisa direspon owner</div>
          </div>
          <div class="toggle-item">
            <div class="toggle-label">🌍 Public Mode</div>
            <label class="switch">
              <input type="checkbox" id="publicToggle" onchange="togglePublicMode()">
              <span class="slider"></span>
            </label>
            <div class="toggle-status" id="publicStatus">Bisa direspon semua orang</div>
          </div>
        </div>
      </div>
      <div class="mfoot">
        <button class="btnCancel" onclick="closeSetting()">Tutup</button>
        <button class="btnSub" onclick="saveSettings()">Simpan Pengaturan</button>
      </div>
    </div>
  </div>
</div>

<!-- PAIRING MODAL -->
<div class="pair-ov" id="pairOv">
  <div class="pair-modal">
    <div class="phd"><div class="phd-info"><div class="phd-ic">🔗</div><div><div class="phd-title">Tautkan Perangkat</div><div class="phd-sub" id="pairPhone"></div></div></div><button class="mclose" onclick="closePair()">✕</button></div>
    <div class="pbody">
      <div class="psteps"><div class="psteps-lbl">Cara menautkan</div><div class="pstep"><div class="psn">1</div><div class="pst">Buka <b>WhatsApp</b> di HP</div></div><div class="pstep"><div class="psn">2</div><div class="pst">Ketuk <b>⋮ → Perangkat Tertaut</b></div></div><div class="pstep"><div class="psn">3</div><div class="pst">Ketuk <b>Tautkan dengan nomor telepon</b></div></div><div class="pstep"><div class="psn">4</div><div class="pst">Masukkan kode yang tampil</div></div></div>
      <div class="pcode-side"><div class="pcode-box" id="pairBox"><div class="pcode-val">---</div></div><button class="pcode-copy" id="btnCopy" onclick="copyCode()">Salin Kode</button></div>
    </div>
    <div class="pfoot"><div class="pstatus"><div class="sdot blink" id="pairDot"></div><span id="pairTxt">Menunggu pairing code...</span></div><button class="act act-del" onclick="closePair()">Tutup</button></div>
  </div>
</div>

<!-- TOKEN POPUP -->
<div class="tok-ov" id="tokOv"><div class="tok-pop"><div class="tok-ic">🎟️</div><h3>Token Gratis</h3><p>Dapatkan token aktivasi gratis untuk mengaktifkan session bot kamu. Token berlaku 10 menit.</p><a href="https://sfl.gl/rHjdO" target="_blank" class="btnGoto" onclick="closeTok()">Dapatkan Token Gratis</a><button class="btnCloseTok" onclick="closeTok()">Tutup</button></div></div>

<a href="https://wa.me/6285715294026" target="_blank" class="cs-float">💬 CS</a>

<script>
const SB_URL = '<?= SUPABASE_URL ?>'
const SB_KEY = '<?= SUPABASE_KEY ?>'
const MAX = <?= MAX_SESSIONS_PER_FINGERPRINT ?>

let fp = '', sessions = [], activePair = null, curCode = null, activeSessionForSetting = null
let ramCharts = {}

async function getFP() {
  const raw = [navigator.userAgent, navigator.language, navigator.platform, screen.width, screen.height, screen.colorDepth, new Date().getTimezoneOffset(), navigator.hardwareConcurrency || '', navigator.deviceMemory || ''].join('|')
  const buf = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(raw))
  return Array.from(new Uint8Array(buf)).map(b => b.toString(16).padStart(2, '0')).join('').slice(0, 32)
}

async function sb(m, ep, body = null) {
  try {
    const r = await fetch(`${SB_URL}/rest/v1/${ep}`, {
      method: m,
      headers: { 'Content-Type': 'application/json', apikey: SB_KEY, Authorization: `Bearer ${SB_KEY}`, Prefer: 'return=representation' },
      body: body ? JSON.stringify(body) : null
    })
    if (!r.ok) throw new Error(`HTTP ${r.status}`)
    const t = await r.text()
    return t ? JSON.parse(t) : []
  } catch (e) { throw e }
}

async function load() {
  try {
    const res = await sb('GET', `polar_sessions?fingerprint=eq.${fp}&order=created_at.desc`)
    sessions = Array.isArray(res) ? res : []
    renderSessions()
  } catch (e) {
    console.error(e)
    document.getElementById('sessionsGrid').innerHTML = '<div style="text-align:center;padding:48px;color:var(--red);">❌ Gagal memuat session</div>'
  }
}

async function loadRamData(phone) {
  try {
    const res = await sb('GET', `ram_usage?phone=eq.${phone}&order=created_at.desc&limit=20`)
    if (res && res.length) {
      const labels = res.reverse().map(r => new Date(r.created_at).toLocaleTimeString())
      const data = res.map(r => r.ram_used || 0)
      return { labels, data }
    }
    return { labels: [], data: [] }
  } catch { return { labels: [], data: [] } }
}

async function renderSessions() {
  const grid = document.getElementById('sessionsGrid')
  if (!sessions.length) {
    grid.innerHTML = `<div style="text-align:center;padding:48px;color:var(--text-4);background:var(--white);border-radius:12px;border:1px solid var(--border);">🤖 Belum ada session. Klik <b>Tambah Session</b> untuk mulai.</div>`
    return
  }

  grid.innerHTML = ''
  for (const s of sessions) {
    const ramData = await loadRamData(s.phone)
    const cardId = `card-${s.id}`
    const badgeClass = { online: 'badge-online', offline: 'badge-offline', pending: 'badge-pending', waiting_pair: 'badge-pending', processing: 'badge-pending' }[s.status] || 'badge-pending'
    const badgeLabel = { online: 'Online', offline: 'Offline', pending: 'Pending', waiting_pair: 'Waiting Pair', processing: 'Processing' }[s.status] || s.status
    const packageClass = s.package === 'premium' ? 'package-premium' : 'package-free'
    const packageLabel = s.package === 'premium' ? '⭐ Premium' : '📦 Free'

    grid.innerHTML += `
      <div class="session-card" id="${cardId}">
        <div class="session-card-header">
          <div class="session-info">
            <span class="session-phone">+${s.phone}</span>
            <span class="session-badge ${badgeClass}">${badgeLabel}</span>
            <span class="session-script">${s.script}</span>
            <span class="session-package ${packageClass}">${packageLabel}</span>
          </div>
          <div class="session-actions">
            <button class="act act-view" onclick="openPair('${s.phone}')">🔗 Pairing</button>
            <button class="act" onclick="openSetting('${s.phone}','${s.self_mode || false}','${s.public_mode !== false}')">⚙️ Setting</button>
            <button class="act act-del" onclick="delSession(${s.id},'${s.phone}')">🗑 Hapus</button>
          </div>
        </div>
        <div class="session-card-body">
          <div class="session-stats-row">
            <div class="mini-stat">
              <div class="mini-stat-label">RAM Used</div>
              <div class="mini-stat-val" id="ram-val-${s.id}">${ramData.data.length ? ramData.data[ramData.data.length-1] : '0'} MB</div>
            </div>
            <div class="mini-stat">
              <div class="mini-stat-label">Uptime</div>
              <div class="mini-stat-val" id="uptime-${s.id}">${s.uptime || '0h'}</div>
            </div>
            <div class="mini-stat">
              <div class="mini-stat-label">Total Pesan</div>
              <div class="mini-stat-val" id="msg-${s.id}">${s.total_messages || 0}</div>
            </div>
          </div>
          <div class="chart-container">
            <div class="chart-title">📊 RAM Usage (20 menit terakhir)</div>
            <canvas id="chart-${s.id}" class="ram-chart" style="max-height:180px;"></canvas>
          </div>
        </div>
      </div>
    `

    // Render chart
    const ctx = document.getElementById(`chart-${s.id}`).getContext('2d')
    if (ramCharts[s.id]) ramCharts[s.id].destroy()
    ramCharts[s.id] = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ramData.labels.length ? ramData.labels : ['No Data'],
        datasets: [{
          label: 'RAM (MB)',
          data: ramData.data.length ? ramData.data : [0],
          borderColor: '#f6821f',
          backgroundColor: 'rgba(246,130,31,0.1)',
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { position: 'top', labels: { font: { size: 10 } } } },
        scales: { y: { beginAtZero: true, title: { display: true, text: 'MB' } } }
      }
    })
  }
}

async function createSession() {
  const rawPhone = document.getElementById('inpPhone').value.trim()
  const token = document.getElementById('inpToken').value.trim().toUpperCase()
  const script = document.getElementById('selectedScript').value
  const packageType = document.getElementById('selectedPackage').value

  if (!rawPhone) return alert2('❌ Nomor tidak boleh kosong', 'err')
  const phone = rawPhone.replace(/[\s\-\(\)\+]/g, '')
  if (!/^\d+$/.test(phone) || phone.length < 7) return alert2('❌ Nomor tidak valid', 'err')
  if (!token) return alert2('❌ Token tidak boleh kosong', 'err')
  if (sessions.length >= MAX && packageType === 'free') return alert2('❌ Slot free penuh. Upgrade ke premium untuk tambah slot!', 'err')
  if (sessions.find(s => s.phone === phone)) return alert2('❌ Nomor sudah terdaftar', 'err')

  const btn = document.getElementById('btnSub')
  const orig = btn.textContent
  btn.disabled = true
  btn.textContent = 'Mengecek...'

  try {
    const rd = await sb('GET', `redeems?code=eq.${token}&select=*`)
    if (!rd?.length) throw new Error('Token tidak ditemukan')
    if (rd[0].used) throw new Error('Token sudah digunakan')
    if (Date.now() - rd[0].created_at > 600000) throw new Error('Token expired')

    await sb('PATCH', `redeems?code=eq.${token}`, { used: true, used_by: fp, phone })
    await sb('POST', 'polar_sessions', {
      fingerprint: fp,
      phone,
      script,
      package: packageType,
      status: 'pending',
      token_used: token,
      self_mode: false,
      public_mode: true,
      created_at: Date.now()
    })

    closeAdd()
    await load()
    alert2('✅ Session dibuat!', 'ok')
    setTimeout(() => openPair(phone), 800)
  } catch (e) {
    alert2('❌ ' + e.message, 'err')
  } finally {
    btn.disabled = false
    btn.textContent = orig
  }
}

async function delSession(id, phone) {
  if (!confirm(`Hapus session +${phone}?`)) return
  try {
    await sb('DELETE', `polar_sessions?id=eq.${id}`)
    if (activePair === phone) closePair()
    alert2('✅ Session dihapus', 'ok')
    load()
  } catch (e) {
    alert2('❌ Gagal hapus: ' + e.message, 'err')
  }
}

function openSetting(phone, selfMode, publicMode) {
  activeSessionForSetting = phone
  document.getElementById('selfToggle').checked = selfMode === 'true' || selfMode === true
  document.getElementById('publicToggle').checked = publicMode === 'true' || publicMode === true
  updateSettingStatus()
  document.getElementById('settingOv').classList.add('show')
}

function updateSettingStatus() {
  const selfOn = document.getElementById('selfToggle').checked
  const publicOn = document.getElementById('publicToggle').checked
  document.getElementById('selfStatus').innerHTML = selfOn ? '✅ Hanya owner yang bisa menggunakan bot' : '❌ Self mode mati'
  document.getElementById('publicStatus').innerHTML = publicOn ? '✅ Semua orang bisa menggunakan bot' : '❌ Public mode mati'
}

function toggleSelfMode() {
  updateSettingStatus()
}

function togglePublicMode() {
  updateSettingStatus()
}

async function saveSettings() {
  if (!activeSessionForSetting) return
  const selfMode = document.getElementById('selfToggle').checked
  const publicMode = document.getElementById('publicToggle').checked

  try {
    await sb('PATCH', `polar_sessions?phone=eq.${activeSessionForSetting}`, {
      self_mode: selfMode,
      public_mode: publicMode
    })
    alert2('✅ Pengaturan disimpan!', 'ok')
    closeSetting()
    load()
  } catch (e) {
    alert2('❌ Gagal simpan: ' + e.message, 'err')
  }
}

function openPair(phone) {
  activePair = phone
  document.getElementById('pairPhone').innerHTML = '+' + phone
  document.getElementById('pairOv').classList.add('show')
  const s = sessions.find(x => x.phone === phone)
  if (s && s.pairing_code) {
    document.getElementById('pairBox').innerHTML = `<div class="pcode-val">${s.pairing_code}</div>`
    document.getElementById('btnCopy').style.display = 'block'
    curCode = s.pairing_code
  } else {
    document.getElementById('pairBox').innerHTML = `<div class="pcode-val">---</div>`
    document.getElementById('btnCopy').style.display = 'none'
  }
}

function closePair() {
  document.getElementById('pairOv').classList.remove('show')
  activePair = null
}

function copyCode() {
  if (!curCode) return
  navigator.clipboard.writeText(curCode)
  const btn = document.getElementById('btnCopy')
  btn.textContent = '✓ Disalin'
  setTimeout(() => btn.textContent = 'Salin Kode', 2000)
}

function selectPackage(pkg, el) {
  document.querySelectorAll('.pkg-opt').forEach(e => e.classList.remove('sel'))
  el.classList.add('sel')
  document.getElementById('selectedPackage').value = pkg
}

function selectScript(scr, el) {
  document.querySelectorAll('.scopt:not(.dis)').forEach(e => e.classList.remove('sel'))
  el.classList.add('sel')
  document.getElementById('selectedScript').value = scr
}

function alert2(msg, type) {
  const el = document.getElementById('alertEl')
  el.className = `alert alert-${type}`
  el.style.display = 'block'
  el.textContent = msg
  clearTimeout(el._t)
  el._t = setTimeout(() => el.style.display = 'none', 5000)
}

function openAdd() {
  document.getElementById('inpPhone').value = ''
  document.getElementById('inpToken').value = ''
  document.getElementById('addOv').classList.add('show')
}

function closeAdd() { document.getElementById('addOv').classList.remove('show') }
function closeSetting() { document.getElementById('settingOv').classList.remove('show') }
function showTok() { document.getElementById('tokOv').classList.add('show') }
function closeTok() { document.getElementById('tokOv').classList.remove('show') }
function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebarOv').classList.toggle('show') }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOv').classList.remove('show') }

document.getElementById('addOv').addEventListener('click', e => { if (e.target === e.currentTarget) closeAdd() })
document.getElementById('settingOv').addEventListener('click', e => { if (e.target === e.currentTarget) closeSetting() })
document.getElementById('pairOv').addEventListener('click', e => { if (e.target === e.currentTarget) closePair() })
document.getElementById('tokOv').addEventListener('click', e => { if (e.target === e.currentTarget) closeTok() })
document.getElementById('inpToken').addEventListener('input', function () { this.value = this.value.toUpperCase() })

async function init() {
  fp = await getFP()
  document.getElementById('fpDisplay').textContent = fp.slice(0, 20) + '...'
  await load()
  setInterval(async () => {
    await load()
    for (const s of sessions) {
      const ramData = await loadRamData(s.phone)
      if (ramCharts[s.id] && ramData.data.length) {
        ramCharts[s.id].data.labels = ramData.labels
        ramCharts[s.id].data.datasets[0].data = ramData.data
        ramCharts[s.id].update()
        document.getElementById(`ram-val-${s.id}`).innerHTML = ramData.data[ramData.data.length - 1] + ' MB'
      }
    }
  }, 10000)
}
init()
</script>
</body>
</html>