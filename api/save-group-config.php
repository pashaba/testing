<?php
// api/save-group-config.php
header('Content-Type: application/json');
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$groupId = $input['groupId'] ?? '';
$antilink = $input['antilink'] ?? 'off';
$antitoxic = $input['antitoxic'] ?? 'off';

if (!$phone || !$groupId) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $supabase = new Supabase(SUPABASE_URL, SUPABASE_KEY);
    
    // Cek apakah sudah ada
    $existing = $supabase->get('group_configs', [
        'phone' => 'eq.' . $phone,
        'group_id' => 'eq.' . $groupId
    ]);
    
    if (count($existing) > 0) {
        $result = $supabase->patch('group_configs', [
            'antilink' => $antilink,
            'antitoxic' => $antitoxic,
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => 'eq.' . $existing[0]['id']]);
    } else {
        $result = $supabase->post('group_configs', [
            'phone' => $phone,
            'group_id' => $groupId,
            'antilink' => $antilink,
            'antitoxic' => $antitoxic,
            'toxic_words' => '[]',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}