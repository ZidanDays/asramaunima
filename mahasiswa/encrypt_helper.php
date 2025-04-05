<?php

// Fungsi untuk mengenkripsi file dengan AES-128-CBC
function encryptFile($inputFile, $outputFile, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16); // Ambil 16 byte dari hash password
    $iv = openssl_random_pseudo_bytes(16); // Generate IV secara acak

    // Baca isi file
    $fileContent = file_get_contents($inputFile);
    if ($fileContent === false) {
        return false; // Gagal membaca file
    }

    // Enkripsi isi file
    $encryptedContent = openssl_encrypt($fileContent, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($encryptedContent === false) {
        return false; // Gagal enkripsi
    }

    // Gabungkan IV + Encrypted Data
    $finalData = $iv . $encryptedContent;

    // Simpan hasil enkripsi ke file baru
    if (file_put_contents($outputFile, $finalData) === false) {
        return false; // Gagal menyimpan file
    }

    return true;
}

// Fungsi untuk mendekripsi file dengan AES-128-CBC
function decryptFile($inputFile, $outputFile, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16); // Ambil 16 byte dari hash password

    // Baca isi file terenkripsi
    $fileContent = file_get_contents($inputFile);
    if ($fileContent === false || strlen($fileContent) < 16) {
        return false; // File tidak valid
    }

    // Ambil IV dan data terenkripsi
    $iv = substr($fileContent, 0, 16);
    $encryptedData = substr($fileContent, 16);

    // Dekripsi isi file
    $decryptedContent = openssl_decrypt($encryptedData, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($decryptedContent === false) {
        return false; // Gagal dekripsi (password salah atau data rusak)
    }

    // Simpan hasil dekripsi ke file baru
    if (file_put_contents($outputFile, $decryptedContent) === false) {
        return false; // Gagal menyimpan file
    }

    return true;
}

?>