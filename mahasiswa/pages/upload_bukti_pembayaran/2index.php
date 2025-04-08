<?php
include '../conf/conf.php'; // Koneksi database
include 'encrypt_helper.php'; // Load fungsi enkripsi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembayaran_id = $_POST['pembayaran_id'];
    $password = $_POST['password']; // Password untuk enkripsi

    if (!empty($_FILES['bukti']['name']) && !empty($password)) {
        $file_tmp = $_FILES['bukti']['tmp_name'];
        $file_name = time() . "_" . $_FILES['bukti']['name']; // Nama unik
        $encrypted_file = "uploads/" . $file_name; // Simpan di folder uploads

        // Enkripsi file
        if (encryptFile($file_tmp, $encrypted_file, $password)) {
            // Simpan nama file ke database
            $query = "UPDATE pembayaran SET bukti_pembayaran=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $file_name, $pembayaran_id);

            if ($stmt->execute()) {
                echo "<script>alert('Bukti pembayaran berhasil diupload dan dienkripsi!'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan bukti pembayaran.'); window.location='index.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengenkripsi bukti pembayaran.'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Pilih file dan masukkan password.'); window.location='index.php';</script>";
    }
}
?>