<?php
include '../conf/conf.php';
include 'encrypt_helper_text.php';
// session_start();

$lokasi = $_POST['lokasi'];
$deskripsi = $_POST['deskripsi'];
$password = $_POST['password'];
$mahasiswa_id = $_SESSION['user_id'];

$encrypted_desc = encryptText($deskripsi, $password);

$query = "INSERT INTO laporan_fasilitas (mahasiswa_id, lokasi, deskripsi_laporan) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $mahasiswa_id, $lokasi, $encrypted_desc);
$stmt->execute();


echo "<script>alert('Laporan berhasil dikirim!'); window.location='index.php?q=lapor_fasilitas';</script>";