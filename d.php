<?php
require_once 'config.php';

// Konfigurasi tambahan
define('JADIBOT_EXPIRY_DAYS', 3);
define('JADIBOT_WARNING_DAYS', 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1771884647147524" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Polar.id | Bot Management Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --sidebar-w: 260px;
            --header-h: 60px;
            --radius-sm: 8px;
            --radius: 12px;
            --radius-lg: 20px;
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

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--card);
            border-right: 1px solid var(--border);
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .logo-title {
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-sub {
            font-size: 10px;
            color: var(--gray);
            margin-top: 2px;
        }

        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 24px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            padding: 0 12px;
            margin-bottom: 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: var(--dark-3);
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .nav-item:hover {
            background: var(--gray-bg);
            color: var(--primary);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--primary-light), transparent);
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }

        .nav-icon { font-size: 18px; width: 24px; text-align: center; }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--border);
        }

        .device-card {
            background: var(--gray-bg);
            border-radius: var(--radius-sm);
            padding: 12px;
            margin-bottom: 12px;
        }

        .device-label {
            font-size: 10px;
            color: var(--gray);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .device-id {
            font-size: 11px;
            font-family: monospace;
            color: var(--dark-2);
            word-break: break-all;
        }

        .reset-btn {
            width: 100%;
            padding: 8px;
            background: var(--danger-light);
            border: none;
            border-radius: var(--radius-sm);
            color: var(--danger);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .reset-btn:hover {
            background: var(--danger);
            color: white;
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        .sidebar-overlay.show { display: block; }

        /* Main Content */
        .main {
            margin-left: var(--sidebar-w);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* Header */
        .header {
            height: var(--header-h);
            background: var(--card);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--dark);
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gray-bg);
            border: 1px solid var(--border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn {
            padding: 8px 20px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 2px 8px var(--primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--dark-3);
        }

        .btn-outline:hover {
            background: var(--gray-bg);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Content */
        .content {
            padding: 28px;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1000;
        }

        .toast {
            background: var(--card);
            border-radius: var(--radius);
            padding: 12px 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }
        .toast-success { border-left-color: var(--success); }
        .toast-error { border-left-color: var(--danger); }
        .toast-info { border-left-color: var(--info); }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray);
            font-weight: 500;
        }

        /* Charts */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .chart-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border);
        }

        .chart-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        canvas { max-height: 200px; }

        /* Console */
        .console-section {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .console-header {
            padding: 16px 20px;
            background: var(--gray-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .console-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .console-filters {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            background: var(--card);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .console-actions {
            display: flex;
            gap: 8px;
        }

        .console-btn {
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 500;
            background: var(--card);
            border: 1px solid var(--border);
            cursor: pointer;
        }

        .console-log {
            height: 200px;
            overflow-y: auto;
            padding: 12px;
            font-family: monospace;
            font-size: 11px;
            background: #1a1a2e;
            color: #e2e8f0;
        }

        .log-entry {
            padding: 6px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .log-time { color: #6c6c8a; }
        .log-level { width: 65px; font-weight: 600; }
        .log-level-info { color: #3b82f6; }
        .log-level-success { color: #10b981; }
        .log-level-warning { color: #f59e0b; }
        .log-level-error { color: #ef4444; }
        .log-message { color: #e2e8f0; word-break: break-word; flex: 1; }

        /* Search */
        .search-bar { margin-bottom: 20px; }
        .search-input {
            width: 100%;
            max-width: 300px;
            padding: 10px 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 40px;
            font-size: 13px;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* Session Cards */
        .sessions-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .session-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s;
        }
        .session-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1); transform: translateY(-2px); }

        .session-header {
            padding: 16px 20px;
            background: var(--gray-bg);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .session-info {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .session-phone {
            font-size: 16px;
            font-weight: 700;
            font-family: monospace;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .session-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-online { background: var(--success-light); color: var(--success-dark); }
        .badge-offline { background: var(--danger-light); color: var(--danger-dark); }
        .badge-pending { background: var(--warning-light); color: var(--warning); }
        .badge-waiting { background: var(--info-light); color: var(--info); }

        .mode-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
        }
        .mode-public { background: var(--success-light); color: var(--success-dark); }
        .mode-self { background: var(--primary-light); color: var(--primary-dark); }

        .session-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border);
            background: var(--card);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .action-btn:hover { transform: scale(1.02); }
        .action-view { color: var(--info); border-color: var(--info-light); }
        .action-view:hover { background: var(--info-light); }
        .action-extend { color: var(--purple); border-color: var(--purple-light); }
        .action-extend:hover { background: var(--purple-light); }
        .action-self { color: var(--primary); border-color: var(--primary-light); }
        .action-self:hover { background: var(--primary-light); }
        .action-public { color: var(--success); border-color: var(--success-light); }
        .action-public:hover { background: var(--success-light); }
        .action-config { color: var(--warning); border-color: var(--warning-light); }
        .action-config:hover { background: var(--warning-light); }
        .action-delete { color: var(--danger); border-color: var(--danger-light); }
        .action-delete:hover { background: var(--danger-light); }

        .session-body {
            padding: 16px 20px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 20px;
        }

        .session-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            flex-wrap: wrap;
        }
        .detail-label { width: 80px; color: var(--gray); font-weight: 500; }

        .expiry-normal { color: var(--gray); }
        .expiry-warning { color: var(--warning); font-weight: 600; }
        .expiry-danger { color: var(--danger); font-weight: 700; }

        .session-console {
            background: #1a1a2e;
            border-radius: var(--radius-sm);
            overflow: hidden;
        }
        .session-console-header {
            padding: 8px 12px;
            background: #2a2a3e;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .session-console-title { font-size: 10px; font-weight: 600; color: #a0a0c0; }
        .session-console-clear { background: none; border: none; color: #6c6c8a; cursor: pointer; font-size: 10px; }
        .session-console-log {
            height: 100px;
            overflow-y: auto;
            padding: 8px;
            font-family: monospace;
            font-size: 10px;
        }
        .session-log-entry {
            padding: 3px 6px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .session-log-time { color: #6c6c8a; }
        .session-log-msg { color: #e2e8f0; flex: 1; }
        .session-log-msg.info { color: #3b82f6; }
        .session-log-msg.success { color: #10b981; }
        .session-log-msg.warning { color: #f59e0b; }
        .session-log-msg.error { color: #ef4444; }

        /* Modal */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .modal.show { opacity: 1; visibility: visible; }
        .modal-content {
            background: var(--card);
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 520px;
            max-height: 85vh;
            overflow-y: auto;
            transform: scale(0.95);
            transition: transform 0.3s;
        }
        .modal.show .modal-content { transform: scale(1); }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-title { font-size: 18px; font-weight: 700; }
        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gray-bg);
            border: none;
            cursor: pointer;
        }
        .modal-body { padding: 24px; }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--card);
            font-size: 14px;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* Script Selector with Images */
        .script-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }
        .script-option {
            border: 2px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--card);
        }
        .script-option.selected {
            border-color: var(--primary);
            background: var(--primary-light);
        }
        .script-option.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(0.3);
        }
        .script-img {
            width: 80px;
            height: 80px;
            margin: 0 auto 12px;
            border-radius: 16px;
            overflow: hidden;
            background: var(--gray-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .script-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .script-img .no-img {
            font-size: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .script-name {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .script-desc {
            font-size: 10px;
            color: var(--gray);
        }
        .maintenance-badge {
            display: inline-block;
            margin-top: 6px;
            padding: 2px 8px;
            background: var(--warning-light);
            color: var(--warning);
            border-radius: 20px;
            font-size: 9px;
            font-weight: 600;
        }

        .toxic-list {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            margin-top: 8px;
        }
        .toxic-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border-bottom: 1px solid var(--border);
        }
        .toxic-del { cursor: pointer; color: var(--danger); }
        .add-toxic { display: flex; gap: 8px; margin-top: 12px; }

        .empty-state { text-align: center; padding: 60px; color: var(--gray); }
        .empty-icon { font-size: 64px; margin-bottom: 20px; opacity: 0.5; }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .charts-row { grid-template-columns: 1fr; }
            .session-body { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .menu-toggle { display: block; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .header-right .btn-outline { display: none; }
            .content { padding: 16px; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-icon">❄️</div>
            <div>
                <div class="logo-title">Polar.id</div>
                <div class="logo-sub">Bot Management</div>
            </div>
        </div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu</div>
            <a href="dashboard.php" class="nav-item active"><span class="nav-icon">🤖</span><span>Dashboard</span></a>
            <a href="premium.php" class="nav-item"><span class="nav-icon">💎</span><span>Premium</span></a>
            <a href="features.php" class="nav-item"><span class="nav-icon">📋</span><span>Fitur Script</span></a>
            <a href="event.php" class="nav-item"><span class="nav-icon">🎁</span><span>Event</span></a>
        </div>
        <div class="nav-section">
            <div class="nav-section-title">Lainnya</div>
            <a href="token.php" target="_blank" class="nav-item"><span class="nav-icon">🎟️</span><span>Ambil Token</span></a>
            <a href="https://wa.me/6285715294026" target="_blank" class="nav-item"><span class="nav-icon">💬</span><span>Customer Service</span></a>
            <a href="index.php" class="nav-item"><span class="nav-icon">🏠</span><span>Beranda</span></a>
        </div>
    </div>
    <div class="sidebar-footer">
        <div class="device-card">
            <div class="device-label"><i class="fas fa-fingerprint"></i> Device ID</div>
            <div class="device-id" id="deviceId">Memuat...</div>
        </div>
        <button class="reset-btn" onclick="resetDevice()"><i class="fas fa-sync-alt"></i> Reset Device ID</button>
    </div>
</aside>

<!-- MAIN -->
<main class="main" id="mainContent">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="header-right">
            <button class="theme-toggle" onclick="toggleTheme()"><i class="fas fa-moon" id="themeIcon"></i></button>
            <a href="https://sfl.gl/rHjdO" target="_blank" class="btn btn-outline"><i class="fas fa-ticket-alt"></i> Token Gratis</a>
            <button class="btn btn-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Tambah Session</button>
        </div>
    </header>

    <div class="content">
        <div class="toast-container" id="toastContainer"></div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-header"><div class="stat-icon"><i class="fas fa-robot"></i></div></div><div class="stat-value" id="statTotal">0</div><div class="stat-label">Total Session</div></div>
            <div class="stat-card"><div class="stat-header"><div class="stat-icon"><i class="fas fa-charging-station"></i></div></div><div class="stat-value" id="statOnline">0</div><div class="stat-label">Online</div></div>
            <div class="stat-card"><div class="stat-header"><div class="stat-icon"><i class="fas fa-hourglass-half"></i></div></div><div class="stat-value" id="statExpiring">0</div><div class="stat-label">Hampir Expired</div></div>
            <div class="stat-card"><div class="stat-header"><div class="stat-icon"><i class="fas fa-sliders-h"></i></div></div><div class="stat-value" id="statSlot">0</div><div class="stat-label">Slot Tersisa</div></div>
            <div class="stat-card"><div class="stat-header"><div class="stat-icon"><i class="fas fa-calendar-day"></i></div></div><div class="stat-value"><?= JADIBOT_EXPIRY_DAYS ?></div><div class="stat-label">Hari Aktif</div></div>
        </div>

        <!-- Charts -->
        <div class="charts-row">
            <div class="chart-card"><div class="chart-title"><i class="fas fa-chart-pie"></i> Status Session</div><canvas id="statusChart"></canvas></div>
            <div class="chart-card"><div class="chart-title"><i class="fas fa-chart-line"></i> Aktivitas Session</div><canvas id="activityChart"></canvas></div>
        </div>

        <!-- Console -->
        <div class="console-section">
            <div class="console-header">
                <div class="console-title"><i class="fas fa-terminal"></i> Console Log <span id="logCount" style="font-size:11px;background:var(--primary-light);padding:2px 8px;border-radius:20px;">0</span></div>
                <div class="console-filters" id="logFilters">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="info">Info</button>
                    <button class="filter-btn" data-filter="success">Success</button>
                    <button class="filter-btn" data-filter="warning">Warning</button>
                    <button class="filter-btn" data-filter="error">Error</button>
                </div>
                <div class="console-actions">
                    <button class="console-btn" onclick="clearAllLogs()"><i class="fas fa-trash"></i> Clear</button>
                    <button class="console-btn" onclick="exportLogs()"><i class="fas fa-download"></i> Export</button>
                </div>
            </div>
            <div class="console-log" id="consoleLog"><div class="log-entry"><span class="log-time">[--:--:--]</span><span class="log-level log-level-info">INFO</span><span class="log-message">Dashboard siap digunakan</span></div></div>
        </div>

        <!-- Search -->
        <div class="search-bar"><input type="text" class="search-input" id="searchInput" placeholder="🔍 Cari session berdasarkan nomor..."></div>

        <!-- Sessions -->
        <div class="sessions-container" id="sessionsContainer"><div class="empty-state"><div class="empty-icon"><i class="fas fa-spinner fa-pulse"></i></div><div>Memuat session...</div></div></div>
    </div>
</main>

<!-- ADD MODAL -->
<div class="modal" id="addModal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Session</h3><button class="modal-close" onclick="closeAddModal()">✕</button></div>
        <div class="modal-body">
            <div class="form-group"><label class="form-label">Pilih Script</label>
                <div class="script-grid">
                    <div class="script-option" onclick="selectScript('phoenix_md',this)" id="scriptPhoenix">
                        <div class="script-img"><img src="assets/phoenix.jpg" onerror="this.parentElement.innerHTML='<div class=\'no-img\'>🔥</div>'"></div>
                        <div class="script-name">Phoenix MD</div>
                        <div class="script-desc">Bot lengkap multi device</div>
                    </div>
                    <div class="script-option disabled" id="scriptOurin">
                        <div class="script-img"><img src="assets/ourin.jpg" onerror="this.parentElement.innerHTML='<div class=\'no-img\'>🦊</div>'"></div>
                        <div class="script-name">Ourin MD</div>
                        <div class="script-desc">Bot Multi Device</div>
                        <div class="maintenance-badge"><i class="fas fa-tools"></i> Maintenance</div>
                    </div>
                </div>
                <input type="hidden" id="selectedScript" value="phoenix_md">
            </div>
            <div class="form-group"><label class="form-label">Nomor WhatsApp</label><input type="text" class="form-input" id="phoneInput" placeholder="628xxxxxxxxxx"></div>
            <div class="form-group"><label class="form-label">Token Aktivasi</label><div style="display:flex;gap:8px;"><input type="text" class="form-input" id="tokenInput" placeholder="Masukkan token" style="flex:1;"><button class="btn btn-outline" onclick="openTokenPopup()" style="padding:10px 16px;">Gratis →</button></div></div>
        </div>
        <div class="modal-footer"><button class="btn btn-outline" onclick="closeAddModal()">Batal</button><button class="btn btn-primary" id="createBtn" onclick="createSession()">Buat Session</button></div>
    </div>
</div>

<!-- EXTEND MODAL -->
<div class="modal" id="extendModal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title"><i class="fas fa-clock"></i> Perpanjang Session</h3><button class="modal-close" onclick="closeExtendModal()">✕</button></div>
        <div class="modal-body">
            <div class="form-group"><label class="form-label">Nomor Bot</label><input type="text" class="form-input" id="extendPhone" readonly style="background:var(--gray-bg);"></div>
            <div class="form-group"><label class="form-label">Token Perpanjangan</label><div style="display:flex;gap:8px;"><input type="text" class="form-input" id="extendToken" placeholder="Token baru" style="flex:1;"><button class="btn btn-outline" onclick="openTokenPopup()" style="padding:10px 16px;">Gratis →</button></div></div>
            <div class="form-group"><label class="form-label">Masa Aktif Baru</label><div class="form-input" style="background:var(--success-light);color:var(--success-dark);">+<?= JADIBOT_EXPIRY_DAYS ?> hari dari sekarang</div></div>
        </div>
        <div class="modal-footer"><button class="btn btn-outline" onclick="closeExtendModal()">Batal</button><button class="btn btn-primary" id="extendBtn" onclick="doExtend()">Perpanjang</button></div>
    </div>
</div>

<!-- GROUP CONFIG MODAL -->
<div class="modal" id="groupConfigModal">
    <div class="modal-content">
        <div class="modal-header"><h3 class="modal-title"><i class="fas fa-cog"></i> Pengaturan Grup</h3><button class="modal-close" onclick="closeGroupConfigModal()">✕</button></div>
        <div class="modal-body">
            <input type="hidden" id="configPhone"><input type="hidden" id="configGroupId">
            <div class="form-group"><label class="form-label">🔗 Anti Link</label>
                <select class="form-input" id="cfgAntilink"><option value="off">Off</option><option value="warn">Warn (Peringatan)</option><option value="kick">Kick (Keluarkan)</option></select>
            </div>
            <div class="form-group"><label class="form-label">⚠️ Anti Toxic</label>
                <select class="form-input" id="cfgAntitoxic"><option value="off">Off</option><option value="warn">Warn (Peringatan)</option><option value="kick">Kick (Keluarkan)</option></select>
            </div>
            <div class="form-group"><label class="form-label">📝 Kata Terlarang (Toxic Words)</label>
                <div class="toxic-list" id="toxicWordsList"></div>
                <div class="add-toxic"><input type="text" class="form-input" id="newToxicWord" placeholder="Tambah kata"><button class="btn btn-primary" onclick="addToxicWord()" style="padding:8px 16px;">+ Tambah</button></div>
            </div>
        </div>
        <div class="modal-footer"><button class="btn btn-outline" onclick="closeGroupConfigModal()">Tutup</button><button class="btn btn-primary" onclick="saveGroupConfig()">Simpan</button></div>
    </div>
</div>

<!-- PAIRING MODAL -->
<div class="modal" id="pairModal">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header"><h3 class="modal-title"><i class="fas fa-link"></i> Tautkan Perangkat</h3><button class="modal-close" onclick="closePairModal()">✕</button></div>
        <div class="modal-body" style="text-align:center;">
            <div id="pairCodeBox" style="background:var(--gray-bg);border-radius:16px;padding:30px;margin-bottom:20px;"><div class="spinner" style="width:32px;height:32px;border:3px solid var(--border);border-top-color:var(--primary);border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 15px;"></div><div>Menunggu pairing code...</div></div>
            <button class="btn btn-primary" id="copyPairBtn" onclick="copyPairCode()" style="display:none;width:100%;"><i class="fas fa-copy"></i> Salin Kode</button>
            <div style="margin-top:20px;text-align:left;font-size:12px;color:var(--gray);"><strong>Cara menautkan:</strong><ol style="padding-left:20px;margin-top:8px;"><li>Buka WhatsApp di HP kamu</li><li>Tekan ⋮ → Perangkat Tertaut</li><li>Tekan Tautkan dengan nomor telepon</li><li>Masukkan kode pairing di atas</li></ol></div>
        </div>
        <div class="modal-footer"><button class="btn btn-outline" onclick="closePairModal()">Tutup</button></div>
    </div>
</div>

<!-- TOKEN POPUP -->
<div class="modal" id="tokenPopup">
    <div class="modal-content" style="max-width: 350px;text-align:center;">
        <div class="modal-body"><div style="font-size:48px;margin-bottom:16px;">🎟️</div><h3 style="margin-bottom:8px;">Token Gratis</h3><p style="color:var(--gray);margin-bottom:20px;">Dapatkan token aktivasi gratis untuk mengaktifkan session bot. Token berlaku 10 menit.</p><a href="https://sfl.gl/lvvR" target="_blank" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;" onclick="closeTokenPopup()"><i class="fas fa-external-link-alt"></i> Dapatkan Token</a><button class="btn btn-outline" style="width:100%;" onclick="closeTokenPopup()">Tutup</button></div>
    </div>
</div>

<script>
const SB_URL = '<?= SUPABASE_URL ?>';
const SB_KEY = '<?= SUPABASE_KEY ?>';
const MAX_SESSIONS = <?= MAX_SESSIONS_PER_FINGERPRINT ?>;
const EXPIRY_DAYS = <?= JADIBOT_EXPIRY_DAYS ?>;

let fingerprint = '';
let sessions = [];
let activePairPhone = null;
let currentPairCode = null;
let pairInterval = null;
let globalLogs = [];
let sessionLogs = {};
let currentLogFilter = 'all';
let statusChart = null;
let activityChart = null;

function toggleTheme() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    if (isDark) { document.documentElement.removeAttribute('data-theme'); localStorage.setItem('theme', 'light'); document.getElementById('themeIcon').className = 'fas fa-moon'; }
    else { document.documentElement.setAttribute('data-theme', 'dark'); localStorage.setItem('theme', 'dark'); document.getElementById('themeIcon').className = 'fas fa-sun'; }
}

function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i> ${message}`;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

function addLog(level, message, phone = null) {
    const time = new Date().toLocaleTimeString('id-ID');
    globalLogs.unshift({ time, level, message });
    if (globalLogs.length > 200) globalLogs.pop();
    updateConsole();
    if (phone) {
        if (!sessionLogs[phone]) sessionLogs[phone] = [];
        sessionLogs[phone].unshift({ time, level, message });
        if (sessionLogs[phone].length > 50) sessionLogs[phone].pop();
        updateSessionConsole(phone);
    }
}

function updateConsole() {
    const container = document.getElementById('consoleLog');
    const filtered = currentLogFilter === 'all' ? globalLogs : globalLogs.filter(l => l.level === currentLogFilter);
    document.getElementById('logCount').textContent = globalLogs.length;
    if (filtered.length === 0) { container.innerHTML = '<div class="log-entry"><span class="log-time">[--:--:--]</span><span class="log-level log-level-info">INFO</span><span class="log-message">Belum ada log</span></div>'; return; }
    container.innerHTML = filtered.slice(0, 100).map(l => `<div class="log-entry"><span class="log-time">[${l.time}]</span><span class="log-level log-level-${l.level}">${l.level.toUpperCase()}</span><span class="log-message">${escapeHtml(l.message)}</span></div>`).join('');
}

function updateSessionConsole(phone) {
    const container = document.getElementById(`session-console-${phone}`);
    if (!container) return;
    const logs = sessionLogs[phone] || [];
    if (logs.length === 0) { container.innerHTML = '<div class="session-log-entry"><span class="session-log-time">[--:--:--]</span><span class="session-log-msg info">Belum ada aktivitas</span></div>'; return; }
    container.innerHTML = logs.slice(0, 30).map(l => `<div class="session-log-entry"><span class="session-log-time">[${l.time}]</span><span class="session-log-msg ${l.level}">${escapeHtml(l.message)}</span></div>`).join('');
}

function clearSessionConsole(phone) { if (sessionLogs[phone]) sessionLogs[phone] = []; updateSessionConsole(phone); addLog('info', `Console session +${phone} dibersihkan`); }
function clearAllLogs() { globalLogs = []; sessionLogs = {}; updateConsole(); renderSessions(); addLog('info', 'Semua log dibersihkan'); showToast('Semua log dibersihkan', 'info'); }
function exportLogs() { const data = { exported_at: new Date().toISOString(), fingerprint, global_logs: globalLogs, session_logs: sessionLogs }; const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' }); const url = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = url; a.download = `dashboard_logs_${Date.now()}.json`; a.click(); URL.revokeObjectURL(url); addLog('info', `Logs diexport (${globalLogs.length} global)`); showToast('Logs berhasil diexport', 'success'); }
function escapeHtml(str) { return String(str).replace(/[&<>]/g, m => m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;'); }

async function getFingerprint() {
    let uniqueId = localStorage.getItem('polar_device_id');
    if (!uniqueId) { uniqueId = crypto.randomUUID() + '-' + Date.now(); localStorage.setItem('polar_device_id', uniqueId); }
    const components = [navigator.userAgent, navigator.language, screen.width, screen.height, screen.colorDepth, new Date().getTimezoneOffset(), navigator.hardwareConcurrency || '', uniqueId].join('|');
    const hash = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(components));
    return Array.from(new Uint8Array(hash)).map(b => b.toString(16).padStart(2,'0')).join('').slice(0, 32);
}

async function resetDevice() {
    if (confirm('Reset Device ID akan menghapus semua session di perangkat ini. Lanjutkan?')) {
        localStorage.removeItem('polar_device_id');
        addLog('warning', 'Device ID direset, halaman akan refresh...');
        showToast('Device ID direset, refresh halaman...', 'info');
        setTimeout(() => location.reload(), 1500);
    }
}

async function supabaseRequest(method, endpoint, body = null) {
    const ctrl = new AbortController();
    const timer = setTimeout(() => ctrl.abort(), 15000);
    try {
        const r = await fetch(`${SB_URL}/rest/v1/${endpoint}`, { method, headers: { 'Content-Type': 'application/json', apikey: SB_KEY, Authorization: `Bearer ${SB_KEY}`, Prefer: 'return=representation' }, body: body ? JSON.stringify(body) : null, signal: ctrl.signal });
        clearTimeout(timer);
        if (!r.ok) throw new Error(`HTTP ${r.status}`);
        const t = await r.text();
        return t ? JSON.parse(t) : [];
    } catch(e) { clearTimeout(timer); throw e; }
}

async function loadSessions() {
    addLog('debug', 'Memuat session...');
    try { const data = await supabaseRequest('GET', `polar_sessions?fingerprint=eq.${fingerprint}&order=created_at.desc`); sessions = Array.isArray(data) ? data : []; addLog('success', `Memuat ${sessions.length} session`); renderSessions(); updateStats(); updateCharts(); }
    catch(e) { addLog('error', `Gagal memuat session: ${e.message}`); sessions = []; renderSessions(); }
}

function getExpiryDate(createdAt) { const d = new Date(createdAt); d.setDate(d.getDate() + EXPIRY_DAYS); return d; }
function getRemainingDays(expiry) { return Math.ceil((expiry - new Date()) / (1000*60*60*24)); }
function formatExpiry(expiry, remaining) {
    if (remaining <= 0) return '<span class="expiry-danger"><i class="fas fa-exclamation-circle"></i> Expired</span>';
    if (remaining <= 1) return `<span class="expiry-warning"><i class="fas fa-hourglass-end"></i> ${remaining} hari (Segera!)</span>`;
    if (remaining <= 3) return `<span class="expiry-warning"><i class="fas fa-hourglass-half"></i> ${remaining} hari</span>`;
    return `<span class="expiry-normal"><i class="far fa-calendar-alt"></i> ${expiry.toLocaleDateString('id-ID')}</span>`;
}

function updateStats() {
    const total = sessions.length, online = sessions.filter(s => s.status === 'online').length, expiring = sessions.filter(s => { if (s.status === 'offline') return false; const remaining = getRemainingDays(getExpiryDate(s.created_at)); return remaining <= 1 && remaining > 0; }).length;
    document.getElementById('statTotal').textContent = total; document.getElementById('statOnline').textContent = online; document.getElementById('statExpiring').textContent = expiring; document.getElementById('statSlot').textContent = Math.max(0, MAX_SESSIONS - total);
}

function updateCharts() {
    const online = sessions.filter(s => s.status === 'online').length, offline = sessions.filter(s => s.status === 'offline').length, pending = sessions.filter(s => ['pending', 'processing', 'waiting_pair'].includes(s.status)).length;
    if (statusChart) statusChart.destroy();
    statusChart = new Chart(document.getElementById('statusChart'), { type: 'doughnut', data: { labels: ['Online', 'Offline', 'Pending'], datasets: [{ data: [online, offline, pending], backgroundColor: ['#10b981', '#ef4444', '#f59e0b'], borderWidth: 0 }] }, options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } } });
    const last7days = Array(7).fill(0);
    sessions.forEach(s => { const d = new Date(s.created_at); const day = Math.floor((Date.now() - d) / (1000*60*60*24)); if (day >= 0 && day < 7) last7days[6-day]++; });
    if (activityChart) activityChart.destroy();
    activityChart = new Chart(document.getElementById('activityChart'), { type: 'line', data: { labels: ['7 hari lalu', '6 hari', '5 hari', '4 hari', '3 hari', '2 hari', 'Hari ini'], datasets: [{ data: last7days, borderColor: '#f6821f', backgroundColor: 'rgba(246,130,31,0.1)', fill: true, tension: 0.4 }] }, options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } } } });
}

function getStatusBadge(status) { const map = { online: 'badge-online', offline: 'badge-offline', pending: 'badge-pending', waiting_pair: 'badge-waiting', processing: 'badge-waiting' }, text = { online: 'Online', offline: 'Offline', pending: 'Pending', waiting_pair: 'Waiting Pair', processing: 'Processing' }; return `<span class="badge ${map[status] || 'badge-pending'}"><i class="fas ${status === 'online' ? 'fa-circle' : status === 'offline' ? 'fa-circle' : 'fa-clock'}"></i> ${text[status] || status}</span>`; }
function getModeBadge(mode) { if (mode === 'self') return '<span class="mode-badge mode-self"><i class="fas fa-lock"></i> Self</span>'; return '<span class="mode-badge mode-public"><i class="fas fa-globe"></i> Public</span>'; }

let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() { clearTimeout(searchTimeout); searchTimeout = setTimeout(() => renderSessions(), 300); });

function renderSessions() {
    const container = document.getElementById('sessionsContainer');
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    let filtered = searchTerm ? sessions.filter(s => s.phone.includes(searchTerm)) : sessions;
    if (filtered.length === 0) { container.innerHTML = '<div class="empty-state"><div class="empty-icon"><i class="fas fa-inbox"></i></div><div>Tidak ada session ditemukan</div></div>'; return; }
    container.innerHTML = filtered.map(s => { const expiry = getExpiryDate(s.created_at); const remaining = getRemainingDays(expiry); const status = (remaining <= 0 && s.status !== 'online') ? 'expired' : s.status; const showPairing = ['pending', 'processing', 'waiting_pair'].includes(status); const isOnline = status === 'online'; return `<div class="session-card"><div class="session-header"><div class="session-info"><span class="session-phone"><i class="fab fa-whatsapp"></i> +${s.phone}</span><div class="session-badges">${getStatusBadge(status)}${getModeBadge(s.bot_mode || 'public')}<span class="badge" style="background:var(--gray-bg);">${s.script}</span></div></div><div class="session-actions">${showPairing ? `<button class="action-btn action-view" onclick="openPairModal('${s.phone}')"><i class="fas fa-link"></i> Pairing</button>` : ''}${isOnline ? `<button class="action-btn action-self" onclick="changeMode('${s.phone}', 'self')"><i class="fas fa-lock"></i> Self</button><button class="action-btn action-public" onclick="changeMode('${s.phone}', 'public')"><i class="fas fa-globe"></i> Public</button>` : ''}<button class="action-btn action-config" onclick="openGroupConfigModal('${s.phone}', '')"><i class="fas fa-sliders-h"></i> Group</button><button class="action-btn action-extend" onclick="openExtendModal('${s.phone}')"><i class="fas fa-clock"></i> Perpanjang</button><button class="action-btn action-delete" onclick="deleteSession(${s.id}, '${s.phone}')"><i class="fas fa-trash"></i> Hapus</button></div></div><div class="session-body"><div class="session-details"><div class="detail-row"><span class="detail-label"><i class="fas fa-calendar"></i> Dibuat</span><span>${new Date(s.created_at).toLocaleDateString('id-ID')}</span></div><div class="detail-row"><span class="detail-label"><i class="fas fa-hourglass"></i> Expired</span><span>${formatExpiry(expiry, remaining)}</span></div><div class="detail-row"><span class="detail-label"><i class="fas fa-fingerprint"></i> Fingerprint</span><span style="font-family:monospace;">${fingerprint.slice(0,12)}...</span></div></div><div class="session-console"><div class="session-console-header"><span class="session-console-title"><i class="fas fa-terminal"></i> Console Log</span><button class="session-console-clear" onclick="clearSessionConsole('${s.phone}')"><i class="fas fa-trash"></i></button></div><div class="session-console-log" id="session-console-${s.phone}"><div class="session-log-entry"><span class="session-log-time">[--:--:--]</span><span class="session-log-msg info">Menunggu aktivitas...</span></div></div></div></div></div>`; }).join('');
    sessions.forEach(s => updateSessionConsole(s.phone));
}

async function changeMode(phone, mode) {
    addLog('info', `Mengubah mode +${phone} ke ${mode.toUpperCase()}`); addLog('info', `Mode diubah ke ${mode.toUpperCase()}`, phone);
    try { await supabaseRequest('PATCH', `polar_sessions?phone=eq.${phone}`, { bot_mode: mode }); const session = sessions.find(s => s.phone === phone); if (session) session.bot_mode = mode; renderSessions(); addLog('success', `Mode +${phone} berhasil diubah ke ${mode.toUpperCase()}`); showToast(`Mode berhasil diubah ke ${mode.toUpperCase()}`, 'success'); }
    catch(e) { addLog('error', `Gagal ubah mode: ${e.message}`); showToast('Gagal ubah mode', 'error'); }
}

async function deleteSession(id, phone) {
    if (!confirm(`Hapus session +${phone}?`)) return;
    addLog('warning', `Menghapus session +${phone}`);
    try { await supabaseRequest('DELETE', `polar_sessions?id=eq.${id}`); delete sessionLogs[phone]; await loadSessions(); addLog('success', `Session +${phone} dihapus`); showToast('Session berhasil dihapus', 'success'); if (activePairPhone === phone) closePairModal(); }
    catch(e) { addLog('error', `Gagal hapus: ${e.message}`); showToast('Gagal hapus session', 'error'); }
}

let selectedScriptValue = 'phoenix_md';
function selectScript(script, el) { if (el.classList.contains('disabled')) return; document.querySelectorAll('.script-option').forEach(e => e.classList.remove('selected')); el.classList.add('selected'); selectedScriptValue = script; document.getElementById('selectedScript').value = script; }

async function createSession() {
    const phone = document.getElementById('phoneInput').value.trim();
    const token = document.getElementById('tokenInput').value.trim().toUpperCase();
    if (!phone) { showToast('Masukkan nomor WhatsApp', 'error'); return; }
    if (!token) { showToast('Masukkan token aktivasi', 'error'); return; }
    if (sessions.length >= MAX_SESSIONS) { showToast('Slot session penuh', 'error'); return; }
    if (sessions.find(s => s.phone === phone)) { showToast('Nomor sudah terdaftar', 'error'); return; }
    const btn = document.getElementById('createBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    addLog('info', `Membuat session baru untuk +${phone}`);
    try {
        const rd = await supabaseRequest('GET', `redeems?code=eq.${token}&select=*`);
        if (!rd?.length) throw new Error('Token tidak valid');
        if (rd[0].used) throw new Error('Token sudah digunakan');
        if (Date.now() - rd[0].created_at > 600000) throw new Error('Token expired');
        await supabaseRequest('PATCH', `redeems?code=eq.${token}`, { used: true, used_by: fingerprint, phone });
        await supabaseRequest('POST', 'polar_sessions', { fingerprint, phone, script: selectedScriptValue, status: 'pending', bot_mode: 'public', token_used: token, created_at: new Date().toISOString() });
        closeAddModal();
        await loadSessions();
        addLog('success', `Session +${phone} berhasil dibuat`);
        showToast('Session berhasil dibuat!', 'success');
        setTimeout(() => openPairModal(phone), 1000);
    } catch(e) { addLog('error', `Gagal: ${e.message}`); showToast(e.message, 'error'); }
    finally { btn.disabled = false; btn.innerHTML = 'Buat Session'; }
}

let currentExtendPhone = '';
function openExtendModal(phone) { currentExtendPhone = phone; document.getElementById('extendPhone').value = '+' + phone; document.getElementById('extendToken').value = ''; document.getElementById('extendModal').classList.add('show'); }
function closeExtendModal() { document.getElementById('extendModal').classList.remove('show'); }

async function doExtend() {
    const phone = currentExtendPhone;
    const token = document.getElementById('extendToken').value.trim().toUpperCase();
    if (!token) { showToast('Masukkan token perpanjangan', 'error'); return; }
    const btn = document.getElementById('extendBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    addLog('info', `Memperpanjang session +${phone}`); addLog('info', 'Memproses perpanjangan...', phone);
    try {
        const rd = await supabaseRequest('GET', `redeems?code=eq.${token}&select=*`);
        if (!rd?.length) throw new Error('Token tidak valid');
        if (rd[0].used) throw new Error('Token sudah digunakan');
        if (Date.now() - rd[0].created_at > 600000) throw new Error('Token expired');
        await supabaseRequest('PATCH', `redeems?code=eq.${token}`, { used: true, used_by: fingerprint, phone, extension_for: phone });
        await supabaseRequest('PATCH', `polar_sessions?phone=eq.${phone}`, { created_at: new Date().toISOString(), extend_token: token, extended_at: new Date().toISOString() });
        closeExtendModal();
        await loadSessions();
        addLog('success', `Session +${phone} diperpanjang +${EXPIRY_DAYS} hari`); addLog('success', `Session diperpanjang +${EXPIRY_DAYS} hari`, phone);
        showToast(`Session diperpanjang +${EXPIRY_DAYS} hari`, 'success');
    } catch(e) { addLog('error', `Gagal: ${e.message}`); showToast(e.message, 'error'); }
    finally { btn.disabled = false; btn.innerHTML = 'Perpanjang'; }
}

let configPhoneValue = '', configGroupIdValue = '';
function openGroupConfigModal(phone, groupId) {
    configPhoneValue = phone; configGroupIdValue = groupId;
    document.getElementById('configPhone').value = phone;
    document.getElementById('configGroupId').value = groupId;
    document.getElementById('cfgAntilink').value = 'off';
    document.getElementById('cfgAntitoxic').value = 'off';
    document.getElementById('toxicWordsList').innerHTML = '<div style="padding:10px;text-align:center;">Memuat...</div>';
    document.getElementById('groupConfigModal').classList.add('show');
    loadGroupConfig();
}
function closeGroupConfigModal() { document.getElementById('groupConfigModal').classList.remove('show'); }

async function loadGroupConfig() {
    const phone = document.getElementById('configPhone').value, groupId = document.getElementById('configGroupId').value;
    try { const data = await supabaseRequest('GET', `group_configs?phone=eq.${phone}&group_id=eq.${groupId}&limit=1`); if (data && data[0]) { document.getElementById('cfgAntilink').value = data[0].antilink || 'off'; document.getElementById('cfgAntitoxic').value = data[0].antitoxic || 'off'; renderToxicWords(JSON.parse(data[0].toxic_words || '[]')); } else { renderToxicWords([]); } }
    catch(e) { renderToxicWords([]); }
}

function renderToxicWords(words) {
    const container = document.getElementById('toxicWordsList');
    if (!words || words.length === 0) { container.innerHTML = '<div style="padding:10px;text-align:center;color:var(--gray);">Belum ada kata terlarang</div>'; return; }
    container.innerHTML = words.map(word => `<div class="toxic-item"><span class="toxic-word">${escapeHtml(word)}</span><span class="toxic-del" onclick="deleteToxicWord('${escapeHtml(word)}')"><i class="fas fa-trash"></i></span></div>`).join('');
}

async function addToxicWord() {
    const word = document.getElementById('newToxicWord').value.trim().toLowerCase();
    if (!word) return;
    const phone = document.getElementById('configPhone').value, groupId = document.getElementById('configGroupId').value;
    try {
        const existing = await supabaseRequest('GET', `group_configs?phone=eq.${phone}&group_id=eq.${groupId}&limit=1`);
        let toxicWords = existing && existing[0] ? JSON.parse(existing[0].toxic_words || '[]') : [];
        if (!toxicWords.includes(word)) toxicWords.push(word);
        if (existing && existing[0]) { await supabaseRequest('PATCH', `group_configs?id=eq.${existing[0].id}`, { toxic_words: JSON.stringify(toxicWords), updated_at: new Date().toISOString() }); }
        else { await supabaseRequest('POST', 'group_configs', { phone, group_id: groupId, antilink: 'off', antitoxic: 'off', toxic_words: JSON.stringify(toxicWords), created_at: new Date().toISOString() }); }
        document.getElementById('newToxicWord').value = ''; loadGroupConfig(); addLog('info', `Tambah kata terlarang: ${word}`); showToast('Kata terlarang ditambahkan', 'success');
    } catch(e) { showToast(e.message, 'error'); }
}

async function deleteToxicWord(word) {
    const phone = document.getElementById('configPhone').value, groupId = document.getElementById('configGroupId').value;
    try {
        const existing = await supabaseRequest('GET', `group_configs?phone=eq.${phone}&group_id=eq.${groupId}&limit=1`);
        if (existing && existing[0]) { let toxicWords = JSON.parse(existing[0].toxic_words || '[]'); toxicWords = toxicWords.filter(w => w !== word); await supabaseRequest('PATCH', `group_configs?id=eq.${existing[0].id}`, { toxic_words: JSON.stringify(toxicWords), updated_at: new Date().toISOString() }); loadGroupConfig(); addLog('info', `Hapus kata terlarang: ${word}`); showToast('Kata terlarang dihapus', 'success'); }
    } catch(e) { showToast(e.message, 'error'); }
}

async function saveGroupConfig() {
    const phone = document.getElementById('configPhone').value, groupId = document.getElementById('configGroupId').value, antilink = document.getElementById('cfgAntilink').value, antitoxic = document.getElementById('cfgAntitoxic').value;
    try {
        const existing = await supabaseRequest('GET', `group_configs?phone=eq.${phone}&group_id=eq.${groupId}&limit=1`);
        if (existing && existing[0]) { await supabaseRequest('PATCH', `group_configs?id=eq.${existing[0].id}`, { antilink, antitoxic, updated_at: new Date().toISOString() }); }
        else { await supabaseRequest('POST', 'group_configs', { phone, group_id: groupId, antilink, antitoxic, toxic_words: '[]', created_at: new Date().toISOString() }); }
        closeGroupConfigModal(); addLog('info', `Pengaturan grup ${groupId} disimpan`); showToast('Pengaturan grup disimpan', 'success');
    } catch(e) { showToast(e.message, 'error'); }
}

async function openPairModal(phone) {
    activePairPhone = phone; currentPairCode = null;
    document.getElementById('pairModal').classList.add('show');
    document.getElementById('pairCodeBox').innerHTML = '<div class="spinner" style="width:32px;height:32px;border:3px solid var(--border);border-top-color:var(--primary);border-radius:50%;animation:spin 0.8s linear infinite;margin:0 auto 15px;"></div><div>Menunggu pairing code...</div>';
    document.getElementById('copyPairBtn').style.display = 'none';
    if (pairInterval) clearInterval(pairInterval);
    pairInterval = setInterval(async () => {
        try { const data = await supabaseRequest('GET', `polar_sessions?phone=eq.${phone}&select=status,pairing_code&limit=1`); if (data && data[0]) { if (data[0].pairing_code && data[0].pairing_code !== currentPairCode) { currentPairCode = data[0].pairing_code; const code = currentPairCode.match(/.{1,4}/g)?.join('-') || currentPairCode; document.getElementById('pairCodeBox').innerHTML = `<div style="font-family:monospace;font-size:28px;font-weight:700;letter-spacing:4px;">${code}</div><div style="margin-top:8px;font-size:12px;">Kode Pairing</div>`; document.getElementById('copyPairBtn').style.display = 'block'; addLog('info', `Pairing code: ${currentPairCode}`, phone); } if (data[0].status === 'online') { addLog('success', 'Bot berhasil online!', phone); addLog('success', `Session +${phone} online`); clearInterval(pairInterval); setTimeout(() => closePairModal(), 2000); loadSessions(); } } } catch(e) {}
    }, 3000);
}
function closePairModal() { if (pairInterval) clearInterval(pairInterval); document.getElementById('pairModal').classList.remove('show'); activePairPhone = null; currentPairCode = null; }
function copyPairCode() { if (!currentPairCode) return; navigator.clipboard.writeText(currentPairCode); const btn = document.getElementById('copyPairBtn'); btn.innerHTML = '<i class="fas fa-check"></i> Tersalin'; setTimeout(() => btn.innerHTML = '<i class="fas fa-copy"></i> Salin Kode', 2000); }

function openAddModal() { document.getElementById('phoneInput').value = ''; document.getElementById('tokenInput').value = ''; document.getElementById('addModal').classList.add('show'); }
function closeAddModal() { document.getElementById('addModal').classList.remove('show'); }
function openTokenPopup() { document.getElementById('tokenPopup').classList.add('show'); }
function closeTokenPopup() { document.getElementById('tokenPopup').classList.remove('show'); }

function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebarOverlay').classList.toggle('show'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('show'); }

document.querySelectorAll('.filter-btn').forEach(btn => { btn.addEventListener('click', () => { document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active')); btn.classList.add('active'); currentLogFilter = btn.dataset.filter; updateConsole(); }); });
// ========== PTERODACTYL SERVER STATUS CHECK ==========
async function checkServerStatus() {
    try {
        const response = await fetch('api/pterodactyl-status.php');
        const data = await response.json();
        
        const maintenanceMode = !data.is_online;
        
        if (maintenanceMode) {
            // Tampilkan banner merah
            showMaintenanceBanner(data.message);
            // Nonaktifkan tombol tambah session
            const btnAdd = document.getElementById('btnAdd');
            if (btnAdd) {
                btnAdd.disabled = true;
                btnAdd.title = 'Server offline, tidak bisa tambah session';
            }
            // Nonaktifkan juga tombol di header jika ada
            const addBtn = document.querySelector('.btn-primary');
            if (addBtn && addBtn.innerHTML.includes('Tambah Session')) {
                addBtn.disabled = true;
                addBtn.style.opacity = '0.5';
                addBtn.style.cursor = 'not-allowed';
            }
        } else {
            // Sembunyikan banner
            hideMaintenanceBanner();
            // Aktifkan tombol tambah session
            const btnAdd = document.getElementById('btnAdd');
            if (btnAdd) {
                btnAdd.disabled = false;
                btnAdd.title = '';
            }
            const addBtn = document.querySelector('.btn-primary');
            if (addBtn && addBtn.innerHTML.includes('Tambah Session')) {
                addBtn.disabled = false;
                addBtn.style.opacity = '1';
                addBtn.style.cursor = 'pointer';
            }
        }
        
        return maintenanceMode;
    } catch (error) {
        console.error('Gagal cek server:', error);
        return false;
    }
}

function showMaintenanceBanner(message) {
    let banner = document.getElementById('maintenanceBanner');
    if (!banner) {
        banner = document.createElement('div');
        banner.id = 'maintenanceBanner';
        banner.style.cssText = `
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(239,68,68,0.3);
        `;
        
        // Cari elemen .content dan sisipkan setelah alert
        const content = document.querySelector('.content');
        const alertEl = document.getElementById('alertEl');
        if (alertEl) {
            content.insertBefore(banner, alertEl.nextSibling);
        } else {
            content.insertBefore(banner, content.firstChild);
        }
    }
    banner.innerHTML = `
    <div style="display: flex; align-items: center; gap: 12px;">
        <i class="fas fa-exclamation-triangle" style="font-size: 20px;"></i>
        <span>⚠️ GANGGUAN LAYANAN — ${message || 'Server bot WhatsApp sedang offline. Fitur pembuatan session baru akan aktif kembali setelah server normal :)'}</span>
    </div>
    <button onclick="location.reload()" style="background: rgba(255,255,255,0.2); border: none; color: white; padding: 6px 12px; border-radius: 8px; cursor: pointer; font-size: 12px;">
        <i class="fas fa-sync-alt"></i> Cek Lagi
    </button>
`;
    banner.style.display = 'flex';
}

function hideMaintenanceBanner() {
    const banner = document.getElementById('maintenanceBanner');
    if (banner) banner.style.display = 'none';
}

// Jalankan setiap 30 detik
setInterval(checkServerStatus, 30000);
// Jalankan sekali saat halaman load
checkServerStatus();
async function syncStatus() {
    let changed = false;
    for (const s of sessions) {
        if (s.status === 'online') continue;
        try { const data = await supabaseRequest('GET', `polar_sessions?phone=eq.${s.phone}&select=status,pairing_code,bot_mode&limit=1`); if (data && data[0]) { if (data[0].status !== s.status || data[0].pairing_code !== s.pairing_code || data[0].bot_mode !== s.bot_mode) { if (data[0].status !== s.status) addLog('info', `Status: ${s.status} → ${data[0].status}`, s.phone); s.status = data[0].status; s.pairing_code = data[0].pairing_code; s.bot_mode = data[0].bot_mode || 'public'; changed = true; if (activePairPhone === s.phone && s.pairing_code) { const code = s.pairing_code.match(/.{1,4}/g)?.join('-') || s.pairing_code; document.getElementById('pairCodeBox').innerHTML = `<div style="font-family:monospace;font-size:28px;font-weight:700;letter-spacing:4px;">${code}</div><div style="margin-top:8px;font-size:12px;">Kode Pairing</div>`; document.getElementById('copyPairBtn').style.display = 'block'; } } } } catch(e) {}
    }
    if (changed) { renderSessions(); updateStats(); updateCharts(); }
}

async function init() {
    fingerprint = await getFingerprint();
    document.getElementById('deviceId').textContent = fingerprint.slice(0,16)+'...'+fingerprint.slice(-8);
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') { document.documentElement.setAttribute('data-theme', 'dark'); document.getElementById('themeIcon').className = 'fas fa-sun'; }
    await loadSessions();
    setInterval(async () => { try { await syncStatus(); } catch(e) {} }, 5000);
    addLog('info', 'Dashboard siap digunakan');
}

init();
</script>
</body>
</html>