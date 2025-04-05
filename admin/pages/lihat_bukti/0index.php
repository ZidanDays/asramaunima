<?php
include '../conf/conf.php';
include 'encrypt_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembayaran_id = $_POST['pembayaran_id'];
    $password = $_POST['password']; // Ambil password dari admin

    $query = "SELECT bukti_pembayaran FROM pembayaran WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pembayaran_id);
    $stmt->execute();
    $stmt->bind_result($encrypted_file);
    $stmt->fetch();
    $stmt->close();

    if ($encrypted_file) {
        $decrypted_content = decryptFile($encrypted_file, $password);

        if ($decrypted_content === false) {
            echo "<script>alert('Password salah! Tidak dapat mendekripsi bukti pembayaran.'); window.history.back();</script>";
            exit();
        }

        // Simpan sementara agar bisa dilihat
        $temp_file = "temp/decrypted_" . time() . ".pdf";
        file_put_contents($temp_file, $decrypted_content);
        
        // Redirect ke file dekripsi
        header("Location: $temp_file");
        exit();
    } else {
        echo "<script>alert('Bukti pembayaran tidak ditemukan.'); window.history.back();</script>";
    }
}
?>