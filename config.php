<?php
// ================================
// POLAR.ID — CONFIG
// ================================

define('SUPABASE_URL', 'https://xcxciixqhmghitmyigbj.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhjeGNpaXhxaG1naGl0bXlpZ2JqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODU2MzQ2MCwiZXhwIjoyMDk0MTM5NDYwfQ.Tzg34ww9r2X2WrZ9wcYoajoQUjUfRkOxnsdARskfvJE');

define('BOT_NUMBER', '6285864588583');
define('CS_NUMBER', '6285715294026');
define('SAFELINK_URL', 'https://sfl.gl/lvvR');
define('SITE_NAME', 'Polar.web.id');
define('MAX_SESSIONS_PER_FINGERPRINT', 50);

function supabase($method, $endpoint, $body = null) {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $endpoint);
    $headers = [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Prefer: return=representation'
    ];
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $body ? json_encode($body) : null,
        CURLOPT_TIMEOUT => 10
    ]);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true) ?? [];
}
