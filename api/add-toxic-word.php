<?php
// api/add-toxic-word.php
header('Content-Type: application/json');
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$groupId = $input['groupId'] ?? '';
$word = strtolower(trim($input['word'] ?? ''));

if (!$phone || !$groupId || !$word) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $supabase = new Supabase(SUPABASE_URL, SUPABASE_KEY);
    
    $existing = $supabase->get('group_configs', [
        'phone' => 'eq.' . $phone,
        'group_id' => 'eq.' . $groupId
    ]);
    
    $toxicWords = [];
    if (count($existing) > 0) {
        $toxicWords = json_decode($existing[0]['toxic_words'] ?? '[]', true);
    }
    
    if (!in_array($word, $toxicWords)) {
        $toxicWords[] = $word;
    }
    
    if (count($existing) > 0) {
        $result = $supabase->patch('group_configs', [
            'toxic_words' => json_encode($toxicWords),
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => 'eq.' . $existing[0]['id']]);
    } else {
        $result = $supabase->post('group_configs', [
            'phone' => $phone,
            'group_id' => $groupId,
            'antilink' => 'off',
            'antitoxic' => 'off',
            'toxic_words' => json_encode($toxicWords),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}