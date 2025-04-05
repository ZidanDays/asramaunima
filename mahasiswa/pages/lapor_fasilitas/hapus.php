<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $kamarId = $_GET['kamarId'];
    $conn->query("UPDATE kamar SET status='kosong' WHERE id=$kamarId");
    $query = "DELETE FROM pemesanan_kamar WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil dihapus'); window.location='index.php?q=kamar-saya';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location='index.php?q=kamar-saya';</script>";
    }
}
?>