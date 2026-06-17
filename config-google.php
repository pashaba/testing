<?php
// config-google.php
session_start();

define('GOOGLE_CLIENT_ID', '1054465623984-re5q3ehnrk4qrne8da214jjvltnut630.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');

// ⚠️ SESUAIKAN DENGAN YANG ADA DI GOOGLE CONSOLE
define('GOOGLE_REDIRECT_URI', 'https://polar.web.id/auth/google/callback');

$ALLOWED_EMAILS = [];

function getUserInfo() {
    if (isset($_SESSION['user_email'])) {
        return [
            'email' => $_SESSION['user_email'],
            'name' => $_SESSION['user_name'] ?? 'User',
            'picture' => $_SESSION['user_picture'] ?? '',
            'coins' => $_SESSION['user_coins'] ?? 0
        ];
    }
    return null;
}
?>
