<?php
// =========================================================
// KONFIGURASI — GANTI SEMUA NILAI DI BAWAH INI
// =========================================================

// Personal Access Token GitHub (Settings > Developer settings > Personal access tokens > Fine-grained / classic)
// Minimal scope: "repo" (classic) atau "Contents: Read and write" (fine-grained)
define('GITHUB_TOKEN', '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');

// Username/organisasi pemilik repo
define('GITHUB_OWNER', 'pashaba');

// Nama repository (tanpa owner, tanpa .git)
define('GITHUB_REPO', 'testing');

// Branch yang dipakai sebagai sumber file
define('GITHUB_BRANCH', 'main');

// Password sederhana buat proteksi file manager ini (WAJIB diganti, jangan biarkan default!)
define('FM_PASSWORD', 'pashapro');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// =========================================================
// JANGAN UBAH DI BAWAH INI
// =========================================================
session_start();
date_default_timezone_set('Asia/Jakarta');

function require_login() {
    if (empty($_SESSION['fm_logged_in'])) {
        header('Location: login.php');
        exit;
    }
}
