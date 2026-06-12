<?php
// api/submit-review.php
header('Content-Type: application/json');
require_once '../config.php';

$input = json_decode(file_get_contents('php://input'), true);
$rating = intval($input['rating'] ?? 0);
$name = trim($input['name'] ?? 'Anonymous');
$comment = trim($input['comment'] ?? '');

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Rating harus 1-5']);
    exit;
}
if (empty($comment)) {
    echo json_encode(['success' => false, 'message' => 'Komentar tidak boleh kosong']);
    exit;
}

$result = supabase('POST', 'reviews', [
    'rating' => $rating,
    'name' => $name,
    'comment' => $comment,
    'created_at' => date('Y-m-d H:i:s')
]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan review']);
}
?>