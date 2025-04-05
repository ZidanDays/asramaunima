<?php
include '../conf/conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update status laporan
    $query = "UPDATE laporan_fasilitas SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        // Ambil user_id (mahasiswa_id) dari laporan
        $q = "SELECT mahasiswa_id FROM laporan_fasilitas WHERE id = $id";
        $res = mysqli_query($conn, $q);
        $row = mysqli_fetch_assoc($res);
        $mahasiswa_id = $row['mahasiswa_id'];

        // Siapkan data notifikasi
        $judul = "Status Laporan Diperbarui";
        $pesan = "Laporan fasilitas Anda kini berstatus: <b>$status</b>.";
        $icon = "settings";
        $warna = "info";

        // Insert notifikasi (manual query)
        $judul = mysqli_real_escape_string($conn, $judul);
        $pesan = mysqli_real_escape_string($conn, $pesan);
        $queryNotif = "INSERT INTO notifikasi (user_id, judul, pesan, icon, warna) 
                       VALUES ('$mahasiswa_id', '$judul', '$pesan', '$icon', '$warna')";

        if (!mysqli_query($conn, $queryNotif)) {
            echo "<script>alert('Status berhasil diupdate, tapi notifikasi gagal disimpan: " . mysqli_error($conn) . "');</script>";
        }

        echo "<script>alert('Update Status Laporan Berhasil!'); window.location='index.php?q=lapor_fasilitas';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status.'); window.location='index.php?q=lapor_fasilitas';</script>";
    }

    $stmt->close();
}
?>