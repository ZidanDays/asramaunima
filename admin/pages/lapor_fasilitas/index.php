<?php
include '../conf/conf.php';
include '../mahasiswa/encrypt_helper_text.php'; // Gunakan helper yang sama

// Ambil data laporan fasilitas
$query = "SELECT id, mahasiswa_id, lokasi, deskripsi_laporan, tanggal_lapor, status FROM laporan_fasilitas ORDER BY tanggal_lapor DESC";
$result = mysqli_query($conn, $query);
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Laporan Fasilitas</h2>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Daftar Laporan Mahasiswa</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if ($result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Lokasi</th>
                                <th>Deskripsi (Dekripsi Manual)</th>
                                <th>Tanggal Lapor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td>
                                    <form method="post" action="" class="d-flex align-items-center">
                                        <input type="hidden" name="encrypted_text"
                                            value="<?= base64_encode($row['deskripsi_laporan']); ?>">
                                        <input type="password" name="decrypt_password" placeholder="Password" required>
                                        <button type="submit" name="decrypt"
                                            class="btn btn-sm btn-info ml-2">Decrypt</button>
                                    </form>

                                    <?php
                                    if (isset($_POST['decrypt']) && base64_encode($row['deskripsi_laporan']) == $_POST['encrypted_text']) {
                                        $decrypted = decryptText($row['deskripsi_laporan'], $_POST['decrypt_password']);
                                        echo "<div class='mt-2'><strong>Deskripsi:</strong><br>" . nl2br(htmlspecialchars($decrypted)) . "</div>";
                                    }
                                    ?>
                                </td>
                                <td><?= $row['tanggal_lapor']; ?></td>
                                <td><?= $row['status']; ?></td>
                                <td>
                                    <form method="POST" action="?q=ubah_status_laporan" class="form-inline">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <select name="status" class="form-control mr-2">
                                            <option value="Diajukan"
                                                <?= $row['status'] == 'Diajukan' ? 'selected' : '' ?>>Diajukan
                                            </option>
                                            <option value="Diproses"
                                                <?= $row['status'] == 'Diproses' ? 'selected' : '' ?>>Diproses
                                            </option>
                                            <option value="Selesai"
                                                <?= $row['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm">Ubah</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info">Belum ada laporan fasilitas.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>