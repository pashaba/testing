<?php
// api/test-pterodactyl-v2.php
header('Content-Type: application/json');

$panel = 'https://private.pterokudesu.web.id';
$apiKey = 'ptlc_MPqC9pJMS444G2C62qWllcF3mUemjlIkqjxq0DuCpIc';
$identifier = 'b70c577e';

/**
 * Fungsi untuk coba berbagai kemungkinan endpoint
 */
function callAPI($endpoint, $method = 'GET') {
    global $panel, $apiKey;
    
    $url = rtrim($panel, '/') . '/' . ltrim($endpoint, '/');
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'endpoint' => $url,
        'http_code' => $httpCode,
        'success' => $httpCode >= 200 && $httpCode < 300,
        'response' => json_decode($response, true),
        'raw' => $response,
        'error' => $error
    ];
}

// Daftar endpoint yang akan dicoba
$endpointsToTry = [
    // Endpoint umum Pterodactyl
    '/api/client',
    '/api/client/account',
    '/api/client/permissions',
    '/api/client/servers',
    
    // Dengan prefix lain
    '/api/application/servers',
    '/api/application/users',
    
    // Endpoint lama / alternatif
    '/api/v1/client/servers',
    '/api/v1/servers',
    
    // Cek server spesifik dengan identifier
    '/api/client/servers/' . $identifier,
    '/api/servers/' . $identifier,
];

$results = [];
$results['config'] = [
    'panel_url' => $panel,
    'api_key_prefix' => substr($apiKey, 0, 15) . '...',
    'server_identifier' => $identifier,
    'timestamp' => date('Y-m-d H:i:s')
];

$results['tests'] = [];

foreach ($endpointsToTry as $endpoint) {
    $result = callAPI($endpoint);
    $results['tests'][$endpoint] = [
        'http_code' => $result['http_code'],
        'success' => $result['success'],
        'response_preview' => is_array($result['response']) ? 
            (isset($result['response']['errors']) ? 'Error: ' . ($result['response']['errors'][0]['detail'] ?? 'Unknown') : 
            (isset($result['response']['data']) ? 'Data found' : json_encode($result['response']))) : 
            substr($result['raw'], 0, 200)
    ];
    
    // Jika berhasil, simpan response lengkapnya
    if ($result['success']) {
        $results['success_endpoint'] = $endpoint;
        $results['full_response'] = $result['response'];
        break;
    }
}

// Jika tidak ada endpoint yang berhasil, coba tanpa auth untuk cek panel
if (!isset($results['success_endpoint'])) {
    $results['panel_check'] = callAPI('', 'GET');
    $results['suggestion'] = "Panel mungkin menggunakan versi berbeda atau perlu login terlebih dahulu. Coba akses langsung panel di browser.";
}

echo json_encode($results, JSON_PRETTY_PRINT);
?>
