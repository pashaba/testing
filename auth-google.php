<?php
require_once 'config.php';

// Jika ada kode balasan dari Google
if (isset($_GET['code'])) {
    
    // 1. Tukar 'code' dengan Access Token
    $token_url = 'https://oauth2.googleapis.com/token';
    $post_data = [
        'code'          => $_GET['code'],
        'client_id'     => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri'  => GOOGLE_REDIRECT_URI,
        'grant_type'    => 'authorization_code',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $token_response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($token_response, true);

    if (isset($token_data['access_token'])) {
        // 2. Ambil data profil user menggunakan Access Token
        $profile_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
        
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $profile_url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token_data['access_token']
        ]);
        $profile_response = curl_exec($ch2);
        curl_close($ch2);

        $google_user = json_decode($profile_response, true);

        if (isset($google_user['id'])) {
            $google_id = $google_user['id'];
            $email = $google_user['email'];
            $name = $google_user['name'];
            $avatar = $google_user['picture'];

            // 3. Simpan atau Update ke database Supabase (UPSERT)
            $supabase_url = SUPABASE_URL . '/rest/v1/users';
            $user_data = json_encode([
                'google_id' => $google_id,
                'email'     => $email,
                'name'      => $name,
                'avatar'    => $avatar
            ]);

            $ch3 = curl_init($supabase_url);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_POST, true);
            curl_setopt($ch3, CURLOPT_POSTFIELDS, $user_data);
            curl_setopt($ch3, CURLOPT_HTTPHEADER, [
                'apikey: ' . SUPABASE_KEY,
                'Authorization: Bearer ' . SUPABASE_KEY,
                'Content-Type: application/json',
                'Prefer: resolution=merge-duplicates' // Ini perintah UPSERT di Supabase
            ]);
            
            $db_response = curl_exec($ch3);
            curl_close($ch3);

            // 4. Set Session PHP untuk user
            $_SESSION['user_google_id'] = $google_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_avatar'] = $avatar;
            
            // Ambil data coin dari Supabase (opsional, untuk memastikan update terbaru)
            $db_data = json_decode($db_response, true);
            // Default 0 jika user baru
            $_SESSION['user_coins'] = isset($db_data[0]['coins']) ? $db_data[0]['coins'] : 0; 

            // 5. Sukses! Lempar ke dashboard
            header('Location: dashboard.php');
            exit();
        }
    }
}

// Jika terjadi error atau tidak ada 'code'
echo "Gagal Login dengan Google. <a href='index.php'>Kembali ke Beranda</a>";
exit();
?>
