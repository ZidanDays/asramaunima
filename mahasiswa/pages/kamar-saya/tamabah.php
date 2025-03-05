<?php
include '../../conf/conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_asrama'];
    $kapasitas = $_POST['kapasitas'];

    $query = "INSERT INTO asrama (nama, kapasitas) VALUES ('$nama', '$kapasitas')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location='asrama.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Asrama</title>
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <div class="container">
        <h2 class="text-dark font-weight-bold">Tambah Asrama</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Asrama</label>
                <input type="text" name="nama_asrama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="asrama.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>