<?php
class EncryptHelper {
    private static $key = "your-secret-key"; // Gantilah dengan kunci yang aman
    private static $cipher = "AES-256-CBC";

    public static function encrypt($data) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$cipher));
        $encrypted = openssl_encrypt($data, self::$cipher, self::$key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function decrypt($data) {
        $decoded = base64_decode($data);
        $ivLength = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($decoded, 0, $ivLength);
        $encrypted = substr($decoded, $ivLength);
        return openssl_decrypt($encrypted, self::$cipher, self::$key, 0, $iv);
    }
}
?>