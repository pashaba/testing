<?php
// api/pterodactyl-simple-check.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('PTERO_PANEL', 'https://private.pterokudesu.web.id');
define('PTERO_API_KEY', 'ptlc_qEYuw1Iv0NQXPUMKzCUJhENIJ7P7SL6KFHTQ0kv9ckh');
define('SERVER_UUID', 'e076c725-f16d-4a7d-93d9-82c294e07f38');

function callAPI($endpoint) {
    $url = PTERO_PANEL . '/api/client/' . ltrim($endpoint, '/');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . PTERO_API_KEY,
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'data' => json_decode($response, true)
    ];
}

$resources = callAPI('servers/' . SERVER_UUID . '/resources');
$serverInfo = callAPI('servers/' . SERVER_UUID);

$ramBytes = $resources['data']['attributes']['resources']['memory_bytes'] ?? 0;
$ramMB = round($ramBytes / 1024 / 1024, 2);

// LOGIKA: RAM > 0 = ONLINE, RAM = 0 = OFFLINE
$isOnline = ($ramMB > 0);
$maintenanceMode = !$isOnline;

$attributes = $serverInfo['data']['attributes'] ?? [];

echo json_encode([
    'success' => true,
    'is_online' => $isOnline,
    'maintenance_mode' => $maintenanceMode,
    'server' => [
        'name' => $attributes['name'] ?? 'Unknown',
        'node' => $attributes['node'] ?? 'Unknown'
    ],
    'resources' => [
        'ram_mb' => $ramMB
    ],
    'message' => $isOnline ? 'Server ONLINE' : 'Server OFFLINE',
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);
?>