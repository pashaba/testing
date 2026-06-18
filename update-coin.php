<?php
session_start();

$amount = intval($_GET['amount'] ?? 0);

if (!isset($_SESSION['user_google_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$_SESSION['user_coins'] = max(0, ($_SESSION['user_coins'] ?? 0) + $amount);

echo json_encode(['success' => true, 'coins' => $_SESSION['user_coins']]);
?>
