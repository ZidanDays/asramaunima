<?php
include '../conf/conf.php'; // Koneksi database
include 'encrypt_helper.php'; // Load fungsi enkripsi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembayaran_id = $_POST['pembayaran_id'];
    $password = $_POST['password']; // Ambil password dari mahasiswa

    if (!empty($_FILES['bukti']['name']) && !empty($password)) {
        $file_tmp = $_FILES['bukti']['tmp_name'];
        $encrypted_content = encryptFile($file_tmp, $password); // Enkripsi file

        // Simpan ke database (tanpa menyimpan password!)
        $query = "UPDATE pembayaran SET bukti_pembayaran=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $encrypted_content, $pembayaran_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Bukti pembayaran berhasil diupload dan dienkripsi!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan bukti pembayaran.'); window.location='index.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Pilih file dan masukkan password.'); window.location='index.php';</script>";
    }
}
?>