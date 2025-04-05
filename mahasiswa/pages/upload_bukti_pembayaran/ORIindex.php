<?php
include '../conf/conf.php'; // File koneksi database
include 'encrypt_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembayaran_id = $_POST['pembayaran_id'];
    
    // if (!empty($_FILES['bukti_pembayaran']['name'])) {
    if (!empty($_FILES['bukti']['name'])) {
        // $file_name = time() . "_" . $_FILES['bukti_pembayaran']['name'];
        $file_name = time() . "_" . $_FILES['bukti']['name'];
        // $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
        $file_tmp = $_FILES['bukti']['tmp_name'];
        $upload_path = "uploads/" . $file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $query = "UPDATE pembayaran SET bukti_pembayaran='$file_name' WHERE id='$pembayaran_id'";
            mysqli_query($conn, $query);
            // echo "Bukti pembayaran berhasil diupload!";
            echo "<script>alert('Bukti pembayaran berhasil diupload!'); window.location='index.php';</script>";
        } else {
            // echo "Gagal mengupload bukti pembayaran.";
            echo "<script>alert('Gagal mengupload bukti pembayaran.'); window.location='index.php';</script>";
        }
    } else {
        echo "Pilih file terlebih dahulu.";
    }
}
?>