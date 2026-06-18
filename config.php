<?php
// ================================
// POLAR.ID — CONFIG
// ================================

session_start();

// Supabase Config

define('SUPABASE_URL', 'https://xcxciixqhmghitmyigbj.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhjeGNpaXhxaG1naGl0bXlpZ2JqIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3ODU2MzQ2MCwiZXhwIjoyMDk0MTM5NDYwfQ.Tzg34ww9r2X2WrZ9wcYoajoQUjUfRkOxnsdARskfvJE');

define('BOT_NUMBER', '6285864588583');
define('CS_NUMBER', '6285715294026');
define('SAFELINK_URL', 'https://sfl.gl/lvvR');
define('SITE_NAME', 'Polar.web.id');
define('MAX_SESSIONS_PER_FINGERPRINT', 50);

// Google Auth Config
define('GOOGLE_CLIENT_ID', '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'https://polar.web.id/auth-google.php');

// SafelinkU Config
define('SAFELINKU_API_KEY', '1d7a39e84c46ddf4ab3a1050f707e1cf57bc7bd4');

// Fungsi pembantu untuk cek login
function is_logged_in() {
    return isset($_SESSION['user_google_id']);
}

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
