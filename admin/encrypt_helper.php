<?php

function encryptFile($inputFile, $outputFile, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16);
    $iv = openssl_random_pseudo_bytes(16);

    $fileContent = file_get_contents($inputFile);
    if ($fileContent === false) return false;

    $encryptedContent = openssl_encrypt($fileContent, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($encryptedContent === false) return false;

    return file_put_contents($outputFile, $iv . $encryptedContent) !== false;
}

function decryptFile($inputFile, $outputFile, $password) {
    $key = substr(hash('sha256', $password, true), 0, 16);

    $fileContent = file_get_contents($inputFile);
    if ($fileContent === false || strlen($fileContent) < 16) return false;

    $iv = substr($fileContent, 0, 16);
    $encryptedData = substr($fileContent, 16);

    $decryptedContent = openssl_decrypt($encryptedData, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    if ($decryptedContent === false) return false;

    return file_put_contents($outputFile, $decryptedContent) !== false;
}
?>