<?php
// api/get-group-config.php
header('Content-Type: application/json');
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$groupId = $input['groupId'] ?? '';

if (!$phone || !$groupId) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

// Ambil dari database group_config
try {
    $supabase = new Supabase(SUPABASE_URL, SUPABASE_KEY);
    $result = $supabase->get('group_configs', [
        'phone' => 'eq.' . $phone,
        'group_id' => 'eq.' . $groupId
    ]);
    
    $config = $result[0] ?? [];
    echo json_encode([
        'success' => true,
        'antilink' => $config['antilink'] ?? 'off',
        'antitoxic' => $config['antitoxic'] ?? 'off',
        'toxicWords' => json_decode($config['toxic_words'] ?? '[]', true)
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}