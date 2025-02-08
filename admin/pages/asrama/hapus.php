<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM asrama WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil dihapus'); window.location='index.php?q=asrama';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data'); window.location='index.php?q=asrama';</script>";
    }
}
?>