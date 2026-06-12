<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>Premium — Polar.id</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --orange:#f6821f;
  --orange-dark:#e07010;
  --orange-light:#fff4eb;
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
  --sidebar-w:240px;
  --radius:8px;
  --shadow:0 1px 3px rgba(0,0,0,0.08),0 1px 2px rgba(0,0,0,0.04);
  --shadow-md:0 4px 6px rgba(0,0,0,0.05),0 2px 4px rgba(0,0,0,0.04);
  --shadow-lg:0 10px 25px rgba(0,0,0,0.08),0 4px 10px rgba(0,0,0,0.05);
}
*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{background:var(--bg);color:var(--text);font-family:'Inter',sans-serif;min-height:100vh;font-size:14px;}

/* ── SIDEBAR ── */
.sidebar{width:var(--sidebar-w);background:var(--white);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;}
.sidebar-logo{padding:20px 20px 16px;border-bottom:1px solid var(--border-light);display:flex;align-items:center;gap:10px;}
.logo-icon{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#f6821f,#e07010);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;box-shadow:0 2px 6px rgba(246,130,31,0.3);}
.logo-text{font-size:15px;font-weight:700;color:var(--text);}
.logo-sub{font-size:11px;color:var(--text-4);margin-top:1px;}
.sidebar-nav{padding:12px 10px;flex:1;overflow-y:auto;}
.nav-section{font-size:10px;font-weight:600;letter-spacing:0.8px;text-transform:uppercase;color:var(--text-4);padding:0 10px;margin:14px 0 5px;}
.nav-item{display:flex;align-items:center;gap:9px;padding:8px 10px;border-radius:6px;color:var(--text-3);font-size:13px;font-weight:500;text-decoration:none;transition:all 0.12s;margin-bottom:1px;}
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
.topbar{height:56px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 24px;background:var(--white);position:sticky;top:0;z-index:50;}
.topbar-left{display:flex;align-items:center;gap:12px;}
.hamburger{display:none;flex-direction:column;gap:4px;cursor:pointer;padding:4px;border:none;background:none;}
.hamburger span{width:18px;height:2px;background:var(--text-3);border-radius:2px;}
.topbar-title{font-size:15px;font-weight:600;color:var(--text);}
.tbtn{padding:7px 14px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all 0.12s;font-family:'Inter',sans-serif;border:1px solid transparent;white-space:nowrap;}
.tbtn-primary{background:var(--orange);color:white;border-color:var(--orange-dark);}
.tbtn-primary:hover{background:var(--orange-dark);}

.content{padding:24px;flex:1;}

/* ── HERO BANNER ── */
.premium-hero{
  position:relative;overflow:hidden;
  background:linear-gradient(135deg,#1e1b4b 0%,#312e81 40%,#4338ca 70%,#f6821f 100%);
  border-radius:12px;padding:40px 32px;margin-bottom:28px;
  display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;
}
.premium-hero::before{
  content:'';position:absolute;top:-60px;right:-60px;
  width:300px;height:300px;border-radius:50%;
  background:rgba(246,130,31,0.15);
}
.premium-hero::after{
  content:'';position:absolute;bottom:-80px;left:20%;
  width:200px;height:200px;border-radius:50%;
  background:rgba(255,255,255,0.04);
}
.hero-left{position:relative;z-index:1;}
.hero-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(246,130,31,0.2);border:1px solid rgba(246,130,31,0.4);
  color:#fbbf24;font-size:11px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;
  padding:4px 10px;border-radius:999px;margin-bottom:12px;
}
.hero-title{font-size:28px;font-weight:800;color:white;line-height:1.2;margin-bottom:8px;}
.hero-title span{color:#fbbf24;}
.hero-desc{font-size:13px;color:rgba(255,255,255,0.7);line-height:1.6;max-width:420px;}
.hero-price-block{
  position:relative;z-index:1;
  background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);
  backdrop-filter:blur(10px);border-radius:12px;padding:20px 24px;text-align:center;flex-shrink:0;
}
.hero-price-label{font-size:11px;color:rgba(255,255,255,0.6);font-weight:600;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:6px;}
.hero-price{font-size:32px;font-weight:800;color:white;}
.hero-price span{font-size:14px;font-weight:500;color:rgba(255,255,255,0.6);}
.hero-price-note{font-size:11px;color:rgba(255,255,255,0.5);margin-top:4px;margin-bottom:16px;}
.hero-order-btn{
  display:block;width:100%;padding:11px 20px;
  background:linear-gradient(135deg,#f6821f,#e07010);
  color:white;border-radius:8px;text-decoration:none;
  font-size:13px;font-weight:700;text-align:center;
  border:1px solid rgba(255,255,255,0.2);
  box-shadow:0 4px 14px rgba(246,130,31,0.4);
  transition:all 0.15s;white-space:nowrap;
}
.hero-order-btn:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(246,130,31,0.5);}

/* ── COMPARISON SECTION ── */
.section-title{font-size:16px;font-weight:700;color:var(--text);margin-bottom:4px;}
.section-sub{font-size:13px;color:var(--text-4);margin-bottom:20px;}

/* ── PLAN CARDS ── */
.plans-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:28px;}
.plan-card{
  background:var(--white);border:1px solid var(--border);
  border-radius:12px;overflow:hidden;box-shadow:var(--shadow);
  transition:box-shadow 0.2s;
}
.plan-card:hover{box-shadow:var(--shadow-md);}
.plan-card.premium{border-color:var(--orange);box-shadow:0 0 0 1px var(--orange),var(--shadow-md);}
.plan-head{padding:20px;border-bottom:1px solid var(--border);}
.plan-card.premium .plan-head{background:linear-gradient(135deg,#fff4eb,#fffbf5);}
.plan-name-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;}
.plan-name{font-size:15px;font-weight:700;color:var(--text);}
.plan-chip{font-size:10px;font-weight:700;padding:3px 8px;border-radius:999px;text-transform:uppercase;letter-spacing:0.5px;}
.chip-free{background:var(--bg);color:var(--text-4);border:1px solid var(--border);}
.chip-premium{background:var(--orange-light);color:var(--orange-dark);border:1px solid #fed7aa;}
.plan-price{font-size:26px;font-weight:800;color:var(--text);}
.plan-price span{font-size:13px;font-weight:500;color:var(--text-4);}
.plan-desc{font-size:12px;color:var(--text-4);margin-top:4px;}
.plan-body{padding:16px 20px;}
.plan-feat{display:flex;align-items:flex-start;gap:8px;margin-bottom:10px;font-size:13px;}
.plan-feat:last-child{margin-bottom:0;}
.feat-ic{width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;flex-shrink:0;margin-top:1px;}
.feat-ic.ok{background:var(--green-bg);color:var(--green);}
.feat-ic.no{background:#fef2f2;color:var(--red);}
.feat-ic.ok::before{content:'✓';font-weight:700;}
.feat-ic.no::before{content:'✕';font-weight:700;}
.feat-txt{color:var(--text-2);line-height:1.4;}
.feat-txt b{color:var(--orange-dark);}
.feat-txt s{color:var(--text-4);}
.plan-foot{padding:14px 20px;border-top:1px solid var(--border-light);}
.btn-order-premium{
  display:block;width:100%;padding:10px;
  background:linear-gradient(135deg,#f6821f,#e07010);
  color:white;border-radius:7px;text-decoration:none;
  font-size:13px;font-weight:700;text-align:center;
  border:none;cursor:pointer;font-family:'Inter',sans-serif;
  box-shadow:0 3px 10px rgba(246,130,31,0.3);
  transition:all 0.15s;
}
.btn-order-premium:hover{background:linear-gradient(135deg,#e07010,#c96008);box-shadow:0 4px 14px rgba(246,130,31,0.4);transform:translateY(-1px);}
.btn-free-current{
  display:block;width:100%;padding:10px;
  background:var(--bg);color:var(--text-3);border-radius:7px;
  font-size:13px;font-weight:600;text-align:center;
  border:1px solid var(--border);cursor:default;
}

/* ── COMPARISON TABLE ── */
.cmp-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:24px;}
.cmp-head{padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;}
.cmp-title{font-size:14px;font-weight:600;color:var(--text);}
.cmp-sub{font-size:12px;color:var(--text-4);margin-top:1px;}

table.cmp{width:100%;border-collapse:collapse;}
table.cmp thead th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--text-4);text-transform:uppercase;letter-spacing:0.5px;background:var(--bg);border-bottom:1px solid var(--border);}
table.cmp thead th.col-feat{width:45%;}
table.cmp thead th.col-free,table.cmp thead th.col-premium{width:27.5%;text-align:center;}
table.cmp thead th.col-premium{color:var(--orange);}
table.cmp tbody tr{border-bottom:1px solid var(--border-light);transition:background 0.1s;}
table.cmp tbody tr:hover{background:var(--bg);}
table.cmp tbody tr:last-child{border-bottom:none;}
table.cmp tbody tr.cmp-section{background:var(--bg);}
table.cmp tbody tr.cmp-section td{padding:8px 16px;font-size:10px;font-weight:700;color:var(--text-4);text-transform:uppercase;letter-spacing:0.8px;border-top:1px solid var(--border);}
table.cmp td{padding:11px 16px;font-size:13px;color:var(--text-2);vertical-align:middle;}
table.cmp td.col-free,table.cmp td.col-premium{text-align:center;}
table.cmp td .feat-name{font-weight:500;color:var(--text);}
table.cmp td .feat-note{font-size:11px;color:var(--text-4);margin-top:2px;}

.cval{display:inline-flex;align-items:center;justify-content:center;gap:4px;font-size:12px;font-weight:600;}
.cval.yes{color:var(--green);}
.cval.no{color:var(--red);}
.cval.txt{color:var(--text-2);}
.cval.txt-or{color:var(--orange-dark);font-weight:700;}
.cval svg{width:13px;height:13px;}

/* ── FAQ ── */
.faq-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:24px;}
.faq-item{border-bottom:1px solid var(--border-light);}
.faq-item:last-child{border-bottom:none;}
.faq-q{padding:14px 18px;font-size:13px;font-weight:600;color:var(--text);cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:background 0.1s;}
.faq-q:hover{background:var(--bg);}
.faq-chevron{font-size:11px;color:var(--text-4);transition:transform 0.2s;flex-shrink:0;}
.faq-item.open .faq-chevron{transform:rotate(180deg);}
.faq-a{padding:0 18px;max-height:0;overflow:hidden;transition:max-height 0.25s ease,padding 0.2s;}
.faq-item.open .faq-a{max-height:200px;padding:0 18px 14px;}
.faq-a p{font-size:13px;color:var(--text-3);line-height:1.6;}

/* CTA BOTTOM */
.cta-bottom{
  background:linear-gradient(135deg,var(--orange-light),#fffbf5);
  border:1px solid #fed7aa;border-radius:12px;padding:28px 24px;
  display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;
  margin-bottom:24px;
}
.cta-txt h3{font-size:16px;font-weight:700;color:var(--text);margin-bottom:4px;}
.cta-txt p{font-size:13px;color:var(--text-3);line-height:1.5;max-width:420px;}
.cta-actions{display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0;}
.btn-wa{
  display:inline-flex;align-items:center;gap:7px;
  padding:10px 18px;background:#25d366;color:white;
  border-radius:7px;text-decoration:none;font-size:13px;font-weight:700;
  box-shadow:0 3px 10px rgba(37,211,102,0.3);transition:all 0.15s;
}
.btn-wa:hover{background:#1fb855;transform:translateY(-1px);}
.btn-outline{
  display:inline-flex;align-items:center;gap:7px;
  padding:10px 18px;background:var(--white);color:var(--orange-dark);
  border-radius:7px;text-decoration:none;font-size:13px;font-weight:600;
  border:1px solid #fed7aa;transition:all 0.15s;
}
.btn-outline:hover{background:var(--orange-light);}

/* CS FLOAT */
.cs-float{position:fixed;bottom:20px;right:20px;z-index:150;display:flex;align-items:center;gap:7px;padding:10px 16px;background:#25d366;color:white;border-radius:999px;text-decoration:none;font-size:13px;font-weight:600;box-shadow:0 4px 14px rgba(37,211,102,0.35);transition:all 0.15s;}
.cs-float:hover{background:#1fb855;transform:translateY(-1px);}

/* ── RESPONSIVE ── */
@media(max-width:768px){
  .sidebar{transform:translateX(-100%);transition:transform 0.22s;}
  .sidebar.open{transform:translateX(0);}
  .main{margin-left:0;}
  .hamburger{display:flex;}
  .content{padding:16px;}
  .topbar{padding:0 16px;}
  .plans-row{grid-template-columns:1fr;}
  .premium-hero{flex-direction:column;}
  .hero-price-block{width:100%;}
  .cta-bottom{flex-direction:column;}
  table.cmp{display:block;overflow-x:auto;}
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
    <a href="dashboard.php" class="nav-item"><span class="nav-icon">🤖</span> Session Bot</a>
    <a href="features.php" class="nav-item"><span class="nav-icon">📋</span> Fitur Script</a>
    <a href="event.php" class="nav-item"><span class="nav-icon">🎁</span> Event</a>
    <a href="premium.php" class="nav-item active"><span class="nav-icon">⭐</span> Premium</a>
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
      <div class="topbar-title">⭐ Premium</div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
      <a href="https://wa.me/6285715294026?text=Halo%20kak%2C%20mau%20order%20Polar.id%20Premium%20dong!" target="_blank" class="tbtn tbtn-primary">⭐ Order Premium — Rp10.000</a>
    </div>
  </div>

  <div class="content">

    <!-- HERO -->
    <div class="premium-hero">
      <div class="hero-left">
        <div class="hero-badge">⭐ Polar.id Premium</div>
        <div class="hero-title">Upgrade ke <span>Premium</span><br>Performa Lebih Kencang</div>
        <div class="hero-desc">Resource dedicated khusus untuk bot kamu. RAM & disk private, lebih stabil, lebih cepat respon — tanpa gangguan dari user lain.</div>
      </div>
      <div class="hero-price-block">
        <div class="hero-price-label">Harga Per Bulan</div>
        <div class="hero-price">Rp10.000 <span>/ bulan</span></div>
        <div class="hero-price-note">Bayar lewat WhatsApp CS</div>
        <a href="https://wa.me/6285715294026?text=Halo%20kak%2C%20mau%20order%20Polar.id%20Premium%20dong!" target="_blank" class="hero-order-btn">💬 Order Sekarang →</a>
      </div>
    </div>

    <!-- PLAN CARDS -->
    <div class="section-title">Pilih Paket Kamu</div>
    <div class="section-sub">Bandingkan paket Free dan Premium sebelum upgrade</div>
    <div class="plans-row">

      <!-- FREE -->
      <div class="plan-card">
        <div class="plan-head">
          <div class="plan-name-row">
            <div class="plan-name">Free</div>
            <div class="plan-chip chip-free">Gratis</div>
          </div>
          <div class="plan-price">Rp0 <span>/ bulan</span></div>
          <div class="plan-desc">Cocok untuk coba-coba dan penggunaan ringan.</div>
        </div>
        <div class="plan-body">
          <div class="plan-feat"><div class="feat-ic no"></div><div class="feat-txt"><s>RAM Shared</s> — berbagi dengan user lain</div></div>
          <div class="plan-feat"><div class="feat-ic no"></div><div class="feat-txt"><s>Disk Shared</s> — storage bersama</div></div>
          <div class="plan-feat"><div class="feat-ic no"></div><div class="feat-txt"><s>CPU Shared</s> — bisa lambat saat ramai</div></div>
          <div class="plan-feat"><div class="feat-ic no"></div><div class="feat-txt"><s>Prioritas Antrian</s> — normal queue</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt">Semua fitur bot dasar</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt">Pairing via kode</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt">Support via CS</div></div>
        </div>
        <div class="plan-foot">
          <div class="btn-free-current">Paket Saat Ini</div>
        </div>
      </div>

      <!-- PREMIUM -->
      <div class="plan-card premium">
        <div class="plan-head">
          <div class="plan-name-row">
            <div class="plan-name">Premium ⭐</div>
            <div class="plan-chip chip-premium">Recommended</div>
          </div>
          <div class="plan-price" style="color:var(--orange-dark);">Rp10.000 <span>/ bulan</span></div>
          <div class="plan-desc">Resource dedicated, performa optimal, prioritas tinggi.</div>
        </div>
        <div class="plan-body">
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt"><b>RAM Private</b> — dedicated hanya untuk bot kamu</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt"><b>Disk Private</b> — storage eksklusif, data lebih aman</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt"><b>CPU Prioritas</b> — respon lebih cepat & stabil</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt"><b>Antrian Prioritas</b> — perintah diproses duluan</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt">Semua fitur bot dasar</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt">Pairing via kode</div></div>
          <div class="plan-feat"><div class="feat-ic ok"></div><div class="feat-txt"><b>Support Prioritas</b> — direspon lebih cepat</div></div>
        </div>
        <div class="plan-foot">
          <a href="https://wa.me/6285715294026?text=Halo%20kak%2C%20mau%20order%20Polar.id%20Premium%20dong!" target="_blank" class="btn-order-premium">⭐ Order Premium — Rp10.000/bulan</a>
        </div>
      </div>

    </div>

    <!-- COMPARISON TABLE -->
    <div class="section-title">Perbandingan Detail</div>
    <div class="section-sub">Lihat semua perbedaan Free vs Premium secara lengkap</div>
    <div class="cmp-card">
      <table class="cmp">
        <thead>
          <tr>
            <th class="col-feat">Fitur</th>
            <th class="col-free">Free</th>
            <th class="col-premium">⭐ Premium</th>
          </tr>
        </thead>
        <tbody>

          <!-- RESOURCE -->
          <tr class="cmp-section"><td colspan="3">💾 Resource & Infrastruktur</td></tr>
          <tr>
            <td><div class="feat-name">RAM</div><div class="feat-note">Memori untuk proses bot</div></td>
            <td class="col-free"><span class="cval txt">Shared</span></td>
            <td class="col-premium"><span class="cval txt-or">Private</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Disk / Storage</div><div class="feat-note">Penyimpanan data & session</div></td>
            <td class="col-free"><span class="cval txt">Shared</span></td>
            <td class="col-premium"><span class="cval txt-or">Private</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">CPU / Prosesor</div><div class="feat-note">Kecepatan eksekusi perintah</div></td>
            <td class="col-free"><span class="cval txt">Shared</span></td>
            <td class="col-premium"><span class="cval txt-or">Prioritas</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Jaringan / Bandwidth</div><div class="feat-note">Kecepatan upload/download data</div></td>
            <td class="col-free"><span class="cval txt">Shared</span></td>
            <td class="col-premium"><span class="cval txt-or">Prioritas</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Isolasi Resource</div><div class="feat-note">Tidak terdampak user lain</div></td>
            <td class="col-free"><span class="cval no">✕</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>

          <!-- PERFORMA -->
          <tr class="cmp-section"><td colspan="3">⚡ Performa & Stabilitas</td></tr>
          <tr>
            <td><div class="feat-name">Stabilitas Koneksi</div><div class="feat-note">Bot jarang disconnect</div></td>
            <td class="col-free"><span class="cval txt">Normal</span></td>
            <td class="col-premium"><span class="cval txt-or">Tinggi</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Kecepatan Respon Bot</div><div class="feat-note">Delay antara kirim & balas</div></td>
            <td class="col-free"><span class="cval txt">Normal</span></td>
            <td class="col-premium"><span class="cval txt-or">Lebih Cepat</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Prioritas Antrian Perintah</div><div class="feat-note">Urutan proses command</div></td>
            <td class="col-free"><span class="cval no">Normal</span></td>
            <td class="col-premium"><span class="cval yes">Prioritas</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Auto Restart Cepat</div><div class="feat-note">Recovery saat bot crash</div></td>
            <td class="col-free"><span class="cval txt">Standar</span></td>
            <td class="col-premium"><span class="cval txt-or">Lebih Cepat</span></td>
          </tr>

          <!-- FITUR BOT -->
          <tr class="cmp-section"><td colspan="3">🤖 Fitur Bot</td></tr>
          <tr>
            <td><div class="feat-name">Semua Command Phoenix MD</div><div class="feat-note">Game, tools, hiburan, dll</div></td>
            <td class="col-free"><span class="cval yes">✓</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Pairing via Kode Telepon</div></td>
            <td class="col-free"><span class="cval yes">✓</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Jumlah Session Bot</div><div class="feat-note">Maks bot per device</div></td>
            <td class="col-free"><span class="cval txt"><?= MAX_SESSIONS_PER_FINGERPRINT ?></span></td>
            <td class="col-premium"><span class="cval txt-or">Lebih Banyak</span></td>
          </tr>

          <!-- SUPPORT -->
          <tr class="cmp-section"><td colspan="3">💬 Support</td></tr>
          <tr>
            <td><div class="feat-name">Support via CS WhatsApp</div></td>
            <td class="col-free"><span class="cval yes">✓</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Prioritas Respon CS</div><div class="feat-note">Direspon lebih cepat</div></td>
            <td class="col-free"><span class="cval no">✕</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>
          <tr>
            <td><div class="feat-name">Setup & Panduan Khusus</div><div class="feat-note">Bantuan konfigurasi premium</div></td>
            <td class="col-free"><span class="cval no">✕</span></td>
            <td class="col-premium"><span class="cval yes">✓</span></td>
          </tr>

        </tbody>
      </table>
    </div>

    <!-- FAQ -->
    <div class="section-title">Pertanyaan Umum</div>
    <div class="section-sub">Masih bingung? Cek FAQ di bawah ini</div>
    <div class="faq-card" style="margin-bottom:24px;">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          Apa bedanya RAM Shared vs Private?
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a"><p>RAM Shared artinya memori server dipakai bersama-sama dengan semua user Free. Kalau banyak user aktif serentak, bot bisa lebih lambat atau sering restart. RAM Private berarti alokasi memori khusus untuk bot kamu saja — tidak terdampak aktivitas user lain.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          Bagaimana cara bayar Premium?
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a"><p>Klik tombol "Order Premium" mana saja di halaman ini, kamu akan diarahkan ke WhatsApp CS kami. CS akan memberikan instruksi pembayaran (transfer bank / e-wallet). Setelah konfirmasi, akun kamu langsung diupgrade.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          Apakah bisa batal kapan saja?
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a"><p>Premium berlaku per bulan. Kamu bisa memilih untuk tidak memperpanjang di bulan berikutnya — akun akan otomatis kembali ke paket Free. Hubungi CS untuk proses pembatalan.</p></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          Apakah data & session aman saat upgrade?
          <span class="faq-chevron">▼</span>
        </div>
        <div class="faq-a"><p>Ya, semua session dan data bot kamu tetap aman saat proses upgrade. Kamu tidak perlu pairing ulang — bot langsung berjalan di infrastruktur Premium setelah proses migrasi selesai (biasanya dalam beberapa menit).</p></div>
      </div>
    </div>

    <!-- CTA BOTTOM -->
    <div class="cta-bottom">
      <div class="cta-txt">
        <h3>Siap upgrade ke Premium? 🚀</h3>
        <p>Hanya Rp10.000/bulan untuk performa bot yang jauh lebih baik. Hubungi CS kami sekarang dan bot kamu akan diupgrade dalam hitungan menit.</p>
      </div>
      <div class="cta-actions">
        <a href="https://wa.me/6285715294026?text=Halo%20kak%2C%20mau%20order%20Polar.id%20Premium%20dong!" target="_blank" class="btn-wa">💬 Order via WhatsApp</a>
        <a href="dashboard.php" class="btn-outline">← Kembali ke Dashboard</a>
      </div>
    </div>

  </div>
</div>

<a href="https://wa.me/6285715294026" target="_blank" class="cs-float">💬 CS</a>

<script>
async function getFP() {
  const raw=[navigator.userAgent,navigator.language,navigator.platform,screen.width,screen.height,screen.colorDepth,new Date().getTimezoneOffset(),navigator.hardwareConcurrency||'',navigator.deviceMemory||''].join('|')
  const buf=await crypto.subtle.digest('SHA-256',new TextEncoder().encode(raw))
  return Array.from(new Uint8Array(buf)).map(b=>b.toString(16).padStart(2,'0')).join('').slice(0,32)
}

function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sidebarOv').classList.toggle('show')}
function closeSidebar(){document.getElementById('sidebar').classList.remove('open');document.getElementById('sidebarOv').classList.remove('show')}

function toggleFaq(el){
  const item=el.parentElement
  const wasOpen=item.classList.contains('open')
  document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open'))
  if(!wasOpen)item.classList.add('open')
}

async function init(){
  const fp=await getFP()
  document.getElementById('fpDisplay').textContent=fp.slice(0,20)+'...'
}
init()
</script>
</body>
</html>
