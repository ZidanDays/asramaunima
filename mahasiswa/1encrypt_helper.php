<?php
function encryptFile($file_path, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16); // Buat kunci dari password
    $iv = openssl_random_pseudo_bytes(16); // IV random untuk keamanan lebih baik
    
    $file_data = file_get_contents($file_path);
    $encrypted_data = openssl_encrypt($file_data, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
    return base64_encode($iv . $encrypted_data); // Simpan dalam format Base64
}

function decryptFile($encrypted_data, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16);
    $data = base64_decode($encrypted_data);
    
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    
    return openssl_decrypt($ciphertext, 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
}
?>