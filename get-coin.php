<?php
session_start();
if (!isset($_SESSION['user_google_id'])) { echo json_encode(['success' => false]); exit; }
echo json_encode(['success' => true, 'coins' => $_SESSION['user_coins'] ?? 0])
