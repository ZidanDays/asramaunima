<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM asrama WHERE id = $id");
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_asrama'];
    $kapasitas = $_POST['kapasitas'];

    $query = "UPDATE asrama SET nama='$nama', kapasitas='$kapasitas' WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diupdate'); window.location='index.php?q=asrama';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
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
                    <h2 class="text-dark font-weight-bold">Edit Asrama</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label>Nama Asrama</label>
                            <input type="text" name="nama_asrama" class="form-control"
                                value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control"
                                value="<?php echo htmlspecialchars($data['kapasitas']); ?>" required>
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