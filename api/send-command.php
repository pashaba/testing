<?php
// api/send-command.php
header('Content-Type: application/json');
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$command = $input['command'] ?? '';

if (!$phone || !$command) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

// Kirim command ke bot via HTTP (asumsikan bot punya API endpoint)
// Atau bisa juga via Webhook/Supabase

// Method 1: Update langsung ke database supabase (bot akan membaca perubahan)
try {
    $supabase = new Supabase(SUPABASE_URL, SUPABASE_KEY);
    $result = $supabase->patch('polar_sessions', ['bot_mode' => $command], ['phone' => 'eq.' . $phone]);
    
    echo json_encode(['success' => true, 'message' => 'Command sent']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}