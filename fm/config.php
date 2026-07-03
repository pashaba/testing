<?php
// =========================================================
// KONFIGURASI — GANTI SEMUA NILAI DI BAWAH INI
// =========================================================

// Personal Access Token GitHub (Settings > Developer settings > Personal access tokens > Fine-grained / classic)
// Minimal scope: "repo" (classic) atau "Contents: Read and write" (fine-grained)
define('GITHUB_TOKEN', 'ghp_GANTI_DENGAN_TOKEN_ASLI_KAMU');

// Username/organisasi pemilik repo
define('GITHUB_OWNER', 'username-github-kamu');

// Nama repository (tanpa owner, tanpa .git)
define('GITHUB_REPO', 'nama-repo-kamu');

// Branch yang dipakai sebagai sumber file
define('GITHUB_BRANCH', 'main');

// Password sederhana buat proteksi file manager ini (WAJIB diganti, jangan biarkan default!)
define('FM_PASSWORD', 'ganti-password-ini');

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
