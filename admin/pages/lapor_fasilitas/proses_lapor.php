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

// $judul = "Laporan Terkirim";
// $pesan = "Laporan Anda telah berhasil dikirim dan sedang dalam proses verifikasi.";
// $icon = "calendar";
// $warna = "success";

$judul = "Laporan Diterima";
$pesan = "Laporan fasilitas Anda telah berhasil dikirim. Kami akan segera menindaklanjuti.";
$icon = "calendar";
$warna = "success";

$queryNotif = "INSERT INTO notifikasi (user_id, judul, pesan, icon, warna) 
               VALUES ('$mahasiswa_id', '$judul', '$pesan', '$icon', '$warna')";
mysqli_query($conn, $queryNotif) or die("Gagal insert notifikasi: " . mysqli_error($conn));


// $queryNotif = "INSERT INTO notifikasi (user_id, judul, pesan, icon, warna) VALUES (?, ?, ?, ?, ?)";
// $stmtNotif = $conn->prepare($queryNotif);
// $stmtNotif->bind_param("issss", $mahasiswa_id, $judul, $pesan, $icon, $warna);
// $stmtNotif->execute();

if ($stmtNotif === false) {
    die("Query Error: " . $conn->error);
}

if (!$stmtNotif->execute()) {
    die("Execute Error: " . $stmtNotif->error);
}


echo "<script>alert('Laporan berhasil dikirim!'); window.location='index.php?q=lapor_fasilitas';</script>";