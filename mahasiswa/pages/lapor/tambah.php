<?php
include '../conf/conf.php';

// Ambil daftar asrama
$asramas = $conn->query("SELECT * FROM asrama");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asrama_id = $_POST['asrama_id'];
    $nomor_kamar = $_POST['nomor_kamar'];

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("INSERT INTO kamar (asrama_id, nomor_kamar, ) VALUES (?, ?)");
    $stmt->bind_param("ii", $asrama_id, $nomor_kamar);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location='index.php?q=kamar';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Tambah Kamar</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label>Asrama</label>
                            <select name="asrama_id" class="form-control" required>
                                <option value="">-- Pilih Asrama --</option>
                                <?php while ($row = $asramas->fetch_assoc()) : ?>
                                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nomor Kamar</label>
                            <input type="number" name="nomor_kamar" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="?q=kamar" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>