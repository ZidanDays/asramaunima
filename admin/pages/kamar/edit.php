<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Menghindari SQL Injection dengan casting ke integer
    $result = $conn->query("SELECT kamar.*, asrama.nama AS nama_asrama FROM 
        kamar JOIN asrama ON kamar.asrama_id = asrama.id WHERE kamar.id = $id");
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $conn->real_escape_string($_POST['status']); // Mencegah SQL Injection
    $fasilitas = $_POST['fasilitas'];
    
    $query = "UPDATE kamar SET status='$status', fasilitas='$fasilitas' WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diupdate'); window.location='index.php?q=kamar';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Daftar Asrama</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-dark font-weight-bold">Edit Asrama</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label>Nama Asrama</label>
                            <input type="text" name="nama_asrama" class="form-control" readonly
                                value="<?php echo htmlspecialchars($data['nama_asrama'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Kamar</label>
                            <input type="text" name="nomor_kama" class="form-control" readonly
                                value="<?php echo htmlspecialchars($data['nomor_kamar'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Fasilitas</label>
                            <input type="text" name="fasilitas" class="form-control"
                                value="<?php echo ($data['fasilitas'] ?? ''); ?>" required>

                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="<?php echo htmlspecialchars($data['status'] ?? ''); ?>">
                                    <?php echo htmlspecialchars($data['status'] ?? 'Pilih Status'); ?>
                                </option>
                                <option value="kosong">kosong</option>
                                <option value="terisi">terisi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="?q=kamar" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <?php include '../partials/footer.php'; ?> -->
</div>