<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Update status pembayaran menjadi 'verified'
    $query = "UPDATE pembayaran SET status = 'verified' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pembayaran berhasil diverifikasi!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal verifikasi pembayaran.'); window.location='index.php';</script>";
    }
}
?>