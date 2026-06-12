<?php
// api/delete-toxic-word.php
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
    
    if (count($existing) > 0) {
        $toxicWords = json_decode($existing[0]['toxic_words'] ?? '[]', true);
        $toxicWords = array_filter($toxicWords, fn($w) => $w !== $word);
        
        $result = $supabase->patch('group_configs', [
            'toxic_words' => json_encode(array_values($toxicWords)),
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => 'eq.' . $existing[0]['id']]);
    }
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}