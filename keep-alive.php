<?php
session_start();
// Cukup akses session untuk memperbarui waktu aktivitas
if (isset($_SESSION['user_google_id'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
    $_SESSION['EXPIRES'] = time() + 3600;
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'expired']);
}
?>
