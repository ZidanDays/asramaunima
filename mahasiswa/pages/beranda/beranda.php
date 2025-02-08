<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$namaMhs = $_SESSION['user_name'];
$idMhs = $_SESSION['user_id'];

include '../conf/conf.php';
// include '../conf/aes.php';
if ($_POST) {
    $kamar_id = $_POST['kamar_id'];
    // $mahasiswa = $_POST['mahasiswa'];
    $status_pembayaran = encryptData('pending'); // Misalnya, default 'pending'
    $conn->query("INSERT INTO pemesanan_kamar (kamar_id, mahasiswa_id, status_pembayaran) VALUES ($kamar_id, '$idMhs', '$status_pembayaran')");
    $conn->query("UPDATE kamar SET status='terisi' WHERE id=$kamar_id");
    $conn->query("UPDATE users SET id_kamar=$kamar_id WHERE id=$idMhs");
    echo "<script>alert('Pemesanan berhasil, silakan lakukan pembayaran Ke Operator.');</script>";
}
$kamars = $conn->query("SELECT kamar.*, asrama.nama, asrama.kapasitas FROM kamar JOIN asrama ON kamar.asrama_id = asrama.id
 WHERE kamar.status='kosong'");
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Daftar Asrama</h2>
            <!-- <a href="?q=kamar-tambah" class="btn btn-primary">+ Tambah</a> -->
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">

                        <!-- <div class="form-group">
                            <label>Nama Mahasiswa</label>
                            <input type="text" name="mahasiswa" class="form-control" required>
                        </div> -->
                        <div class="form-group">
                            <label>Kamar</label>
                            <select name="kamar_id" class="form-control" required>
                                <option value="">-- Pilih Kamar --</option>
                                <?php while ($row = $kamars->fetch_assoc()) : ?>
                                <option value="<?= $row['id'] ?>">Kamar <?= $row['nomor_kamar'] ?> Fakultas
                                    <?=$row['nama'] ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <!-- <a href="?q=beranda" class="btn btn-secondary">Kembali</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</div>