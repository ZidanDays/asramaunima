<?php
function encryptText($plaintext, $password) {
    $method = "AES-128-CBC";
    $key = substr(hash('sha256', $password, true), 0, 16); // 128-bit key
    $iv = openssl_random_pseudo_bytes(16); // generate IV

    $encrypted = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encrypted); // gabungkan IV dan data terenkripsi
}

function decryptText($ciphertext_base64, $password) {
    $method = "AES-128-CBC";
    $key = substr(hash('sha256', $password, true), 0, 16); // sama seperti saat enkripsi
    $ciphertext_combined = base64_decode($ciphertext_base64);

    if ($ciphertext_combined === false || strlen($ciphertext_combined) < 16) {
        return null; // invalid ciphertext
    }

    $iv = substr($ciphertext_combined, 0, 16); // ambil IV
    $ciphertext = substr($ciphertext_combined, 16);

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}
?>