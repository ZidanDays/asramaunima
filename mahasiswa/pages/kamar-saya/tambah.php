<?php
include '../conf/conf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_asrama'];
    $kapasitas = $_POST['kapasitas'];

    $query = "INSERT INTO asrama (nama, kapasitas) VALUES ('$nama', '$kapasitas')";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php?q=asrama';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Daftar Asrama</h2>
            <!-- <a href="tambah.php" class="btn btn-primary">+ Tambah Asrama</a> -->
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
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
                        <a href="?q=asrama" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include '../partials/footer.php'; ?> -->
</div>