<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pengelolaan_asrama";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

define('ENCRYPTION_KEY', 'your-secret-key-16'); // Harus 16 karakter untuk AES-128

function encryptData($data) {
    $key = ENCRYPTION_KEY;
    $iv = openssl_random_pseudo_bytes(16); // 16-byte IV
    $encrypted = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted); // Gabungkan IV dan data terenkripsi
}

// function decryptData($data) {
//     $key = ENCRYPTION_KEY;
//     $data = base64_decode($data);
//     $iv = substr($data, 0, 16); // Ambil IV dari data
//     $encrypted = substr($data, 16);
//     return openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
// }

function decryptData($data) {
    $key = ENCRYPTION_KEY;
    $data = base64_decode($data); // Decode base64

    if (strlen($data) < 16) { // Cek apakah panjang data cukup
        return false;
    }

    $iv = substr($data, 0, 16); // Ambil 16 byte pertama sebagai IV
    $encrypted = substr($data, 16); // Sisanya adalah data terenkripsi

    return openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
}