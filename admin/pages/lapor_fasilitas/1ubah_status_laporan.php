<?php
include '../conf/conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE laporan_fasilitas SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        // header("Location: laporan_fasilitas.php");
        echo "<script>alert('Update Status Laporan Berhasil!'); window.location='index.php?q=lapor_fasilitas';</script>";
    } else {
        // echo "Gagal mengubah status.";
        echo "<script>alert('Gagal mengubah status.'); window.location='index.php?q=lapor_fasilitas';</script>";
    }

    $stmt->close();
}
?>