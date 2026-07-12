<?php
// pterodactyl-tester.php
// Tool untuk test Pterodactyl Client API - input panel URL & API key langsung di web

$panel = $_POST['panel'] ?? $_GET['panel'] ?? '';
$apiKey = $_POST['api_key'] ?? $_GET['api_key'] ?? '';
$identifier = $_POST['identifier'] ?? $_GET['identifier'] ?? '';
$endpointCustom = $_POST['endpoint'] ?? $_GET['endpoint'] ?? '';

function callAPI($panel, $apiKey, $endpoint, $method = 'GET') {
    $url = rtrim($panel, '/') . '/' . ltrim($endpoint, '/');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
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

$results = null;

if ($panel && $apiKey) {
    $panel = trim($panel);
    $apiKey = trim($apiKey);
    $identifier = trim($identifier);

    $endpointsToTry = $endpointCustom ? [trim($endpointCustom)] : [
        '/api/client',
        '/api/client/account',
        '/api/client/permissions',
        '/api/client/servers',
        '/api/application/servers',
        '/api/application/users',
        '/api/v1/client/servers',
        '/api/v1/servers',
    ];

    if ($identifier) {
        $endpointsToTry[] = '/api/client/servers/' . $identifier;
        $endpointsToTry[] = '/api/client/servers/' . $identifier . '/resources';
        $endpointsToTry[] = '/api/servers/' . $identifier;
    }

    $results = [];
    $results['config'] = [
        'panel_url' => $panel,
        'api_key_prefix' => substr($apiKey, 0, 15) . '...',
        'server_identifier' => $identifier ?: '(kosong)',
        'timestamp' => date('Y-m-d H:i:s')
    ];

    $results['tests'] = [];
    $allResponses = [];

    foreach ($endpointsToTry as $endpoint) {
        $result = callAPI($panel, $apiKey, $endpoint);
        $results['tests'][$endpoint] = [
            'http_code' => $result['http_code'],
            'success' => $result['success'],
        ];
        $allResponses[$endpoint] = $result;

        if ($result['success'] && !isset($results['success_endpoint'])) {
            $results['success_endpoint'] = $endpoint;
        }
    }

    $results['all_raw_responses'] = array_map(function ($r) {
        return [
            'endpoint' => $r['endpoint'],
            'http_code' => $r['http_code'],
            'success' => $r['success'],
            'error' => $r['error'],
            'raw' => $r['raw'],
        ];
    }, $allResponses);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pterodactyl API Tester</title>
<style>
  * { box-sizing: border-box; }
  body {
    font-family: 'Courier New', monospace;
    background: #f0f0f0;
    margin: 0;
    padding: 20px;
    color: #111;
  }
  .container { max-width: 900px; margin: 0 auto; }
  h1 { font-size: 20px; border-bottom: 3px solid #111; padding-bottom: 10px; }
  form {
    background: #fff;
    border: 3px solid #111;
    box-shadow: 6px 6px 0 #111;
    padding: 20px;
    margin-bottom: 20px;
  }
  label { display: block; font-weight: bold; margin-top: 12px; margin-bottom: 4px; font-size: 13px; }
  input {
    width: 100%;
    padding: 8px;
    border: 2px solid #111;
    font-family: monospace;
    font-size: 13px;
  }
  button {
    margin-top: 16px;
    background: #ffde59;
    border: 3px solid #111;
    box-shadow: 4px 4px 0 #111;
    padding: 10px 20px;
    font-weight: bold;
    cursor: pointer;
    font-family: monospace;
  }
  button:active { box-shadow: 1px 1px 0 #111; transform: translate(3px,3px); }
  .result-block {
    background: #fff;
    border: 3px solid #111;
    margin-bottom: 14px;
    box-shadow: 4px 4px 0 #111;
  }
  .result-header {
    padding: 8px 12px;
    font-weight: bold;
    font-size: 13px;
    display: flex;
    justify-content: space-between;
    border-bottom: 2px solid #111;
  }
  .ok { background: #b6ffb0; }
  .fail { background: #ffb0b0; }
  pre {
    margin: 0;
    padding: 12px;
    white-space: pre-wrap;
    word-break: break-all;
    font-size: 12px;
    max-height: 400px;
    overflow-y: auto;
    background: #fafafa;
  }
  .success-tag {
    background: #111;
    color: #fff;
    padding: 6px 10px;
    display: inline-block;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 13px;
  }
</style>
</head>
<body>
<div class="container">
  <h1>🦖 Pterodactyl API Tester</h1>

  <form method="POST">
    <label>Panel URL</label>
    <input type="text" name="panel" placeholder="https://private.pterokudesu.web.id" value="<?= htmlspecialchars($panel) ?>" required>

    <label>API Key (Client API Key, awalan ptlc_)</label>
    <input type="text" name="api_key" placeholder="ptlc_xxxxxxxxxxxxxxxxxxxxx" value="<?= htmlspecialchars($apiKey) ?>" required>

    <label>Server Identifier (opsional)</label>
    <input type="text" name="identifier" placeholder="b70c577e" value="<?= htmlspecialchars($identifier) ?>">

    <label>Endpoint custom (opsional, kalau diisi cuma test ini aja)</label>
    <input type="text" name="endpoint" placeholder="/api/client/servers/xxxx/resources" value="<?= htmlspecialchars($endpointCustom) ?>">

    <button type="submit">🚀 Test API</button>
  </form>

  <?php if ($results): ?>
    <?php if (isset($results['success_endpoint'])): ?>
      <div class="success-tag">✅ Endpoint sukses: <?= htmlspecialchars($results['success_endpoint']) ?></div>
    <?php else: ?>
      <div class="success-tag" style="background:#a30000;">❌ Tidak ada endpoint yang berhasil (semua gagal)</div>
    <?php endif; ?>

    <?php foreach ($results['all_raw_responses'] as $endpoint => $r): ?>
      <div class="result-block">
        <div class="result-header <?= $r['success'] ? 'ok' : 'fail' ?>">
          <span><?= htmlspecialchars($endpoint) ?></span>
          <span>HTTP <?= $r['http_code'] ?></span>
        </div>
        <pre><?= htmlspecialchars($r['raw'] ?: ($r['error'] ?: '(kosong / no response)')) ?></pre>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
</body>
</html>
