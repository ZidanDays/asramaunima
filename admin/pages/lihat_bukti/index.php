<?php
include '../conf/conf.php'; // Koneksi database
include 'encrypt_helper.php'; // Load fungsi enkripsi

// $pembayaran_id = $_GET['pembayaran_id']; // ID pembayaran yang dipilih
$pembayaran_id = $_POST['pembayaran_id']; // ID pembayaran yang dipilih
$password = $_POST['password']; // Password untuk dekripsi

// Ambil nama file dari database
$query = "SELECT bukti_pembayaran FROM pembayaran WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $pembayaran_id);
$stmt->execute();
$stmt->bind_result($file_name);
$stmt->fetch();
$stmt->close();

if (!$file_name) {
    die("Bukti pembayaran tidak ditemukan.");
}

// $encrypted_file = "uploads/" . $file_name; // Path file terenkripsi
$encrypted_file = "../mahasiswa/uploads/" . $file_name; // Path file terenkripsi
// $decrypted_file = "temp/decrypted_" . time() . ".pdf"; // Simpan sementara
$decrypted_file = "../mahasiswa/temp/decrypted_" . time() . ".pdf"; // Simpan sementara

// Dekripsi file
if (decryptFile($encrypted_file, $decrypted_file, $password)) {
    // Redirect ke file yang sudah didekripsi
    // header("Location: $decrypted_file");
    echo "<script>window.location.href = '$decrypted_file';</script>";

    exit;
} else {
    echo "<script>alert('Gagal mendekripsi file. Password salah atau file rusak.'); window.location='index.php';</script>";
}
?>