<?php
define('ENCRYPTION_KEY', 'your-secret-key-16'); // Harus 16 karakter untuk AES-128

function encryptData($data) {
    $key = ENCRYPTION_KEY;
    $iv = openssl_random_pseudo_bytes(16); // 16-byte IV
    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted); // Gabungkan IV dan data terenkripsi
}

function decryptData($data) {
    $key = ENCRYPTION_KEY;
    $data = base64_decode($data);
    $iv = substr($data, 0, 16); // Ambil IV dari data
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
}