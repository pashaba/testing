<?php
// api/get-stats.php
header('Content-Type: application/json');
require_once '../config.php';

$sessions = supabase('GET', 'polar_sessions?select=count&status=eq.online');
$activeSessions = $sessions[0]['count'] ?? 0;

echo json_encode([
    'success' => true,
    'active_sessions' => $activeSessions
]);
?>