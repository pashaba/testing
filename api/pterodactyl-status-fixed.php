<?php
// api/pterodactyl-status-fixed.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

define('PTERO_PANEL', 'https://private.pterokudesu.web.id');
define('PTERO_API_KEY', 'ptlc_qEYuw1Iv0NQXPUMKzCUJhENIJ7P7SL6KFHTQ0kv9ckh');
define('SERVER_UUID', 'e076c725-f16d-4a7d-93d9-82c294e07f38');

function pterodactylRequest($endpoint) {
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

$result = pterodactylRequest('servers/' . SERVER_UUID);
$resources = pterodactylRequest('servers/' . SERVER_UUID . '/resources');

$attributes = $result['data']['attributes'] ?? [];
$resourcesAttr = $resources['data']['attributes']['resources'] ?? [];
$limits = $resources['data']['attributes']['limits'] ?? [];

$rawStatus = $attributes['status'];
$isSuspended = $attributes['is_suspended'] ?? false;
$isInstalling = $attributes['is_installing'] ?? false;

// ✅ INTERPRETASI STATUS YANG BENAR
// null = OFFLINE (server mati)
// "running" = ONLINE (server hidup)
if ($isSuspended) {
    $serverStatus = 'suspended';
    $statusText = '🔴 SUSPENDED';
    $isOnline = false;
} elseif ($isInstalling) {
    $serverStatus = 'installing';
    $statusText = '📦 INSTALLING';
    $isOnline = false;
} elseif ($rawStatus === 'running') {
    $serverStatus = 'running';
    $statusText = '🟢 ONLINE - Running';
    $isOnline = true;
} else {
    // null atau status lainnya = OFFLINE
    $serverStatus = 'offline';
    $statusText = '🔴 OFFLINE - Server Mati';
    $isOnline = false;
}

// Hitung resource usage (persen)
$cpuPercent = 0;
$ramPercent = 0;
$diskPercent = 0;

if ($limits['cpu'] ?? 0) {
    $cpuPercent = round(($resourcesAttr['cpu_absolute'] ?? 0) / $limits['cpu'] * 100, 1);
}
if ($limits['memory'] ?? 0) {
    $ramPercent = round(($resourcesAttr['memory_bytes'] ?? 0) / 1024 / 1024 / $limits['memory'] * 100, 1);
}
if ($limits['disk'] ?? 0) {
    $diskPercent = round(($resourcesAttr['disk_bytes'] ?? 0) / 1024 / 1024 / $limits['disk'] * 100, 1);
}

$output = [
    'success' => true,
    'server' => [
        'name' => $attributes['name'] ?? 'Unknown',
        'node' => $attributes['node'] ?? 'Unknown',
        'status' => $serverStatus,
        'status_text' => $statusText,
        'is_online' => $isOnline,
        'raw_status' => $rawStatus,
        'is_suspended' => $isSuspended,
        'is_installing' => $isInstalling
    ],
    'resources' => [
        'cpu' => [
            'current' => $resourcesAttr['cpu_absolute'] ?? 0,
            'limit' => $limits['cpu'] ?? 0,
            'percent' => $cpuPercent
        ],
        'memory' => [
            'current_mb' => round(($resourcesAttr['memory_bytes'] ?? 0) / 1024 / 1024, 2),
            'limit_mb' => $limits['memory'] ?? 0,
            'percent' => $ramPercent
        ],
        'disk' => [
            'current_mb' => round(($resourcesAttr['disk_bytes'] ?? 0) / 1024 / 1024, 2),
            'limit_mb' => $limits['disk'] ?? 0,
            'percent' => $diskPercent
        ],
        'uptime' => $resourcesAttr['uptime'] ?? 0
    ],
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($output, JSON_PRETTY_PRINT);
?>