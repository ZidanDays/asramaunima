<?php
include '../conf/conf.php';
$query = "SELECT lokasi, status, tanggal_lapor FROM laporan_fasilitas WHERE mahasiswa_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Lapor Fasilitas</h2>
        </div>

        <!-- Tabel Laporan -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Laporan Fasilitas Saya</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if ($result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal Lapor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= date("d M Y H:i", strtotime($row['tanggal_lapor'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <div class="alert alert-info">Belum ada laporan yang Anda kirimkan.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Kirim Laporan -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Kirim Laporan Fasilitas</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?q=proses_lapor">
                    <div class="form-group">
                        <label for="lokasi">Lokasi Kerusakan</label>
                        <input type="text" name="lokasi" class="form-control"
                            placeholder="Contoh: Kamar A1, Kamar Mandi" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Masalah</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan kerusakan..."
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="password">Password untuk Enkripsi</label>
                        <input type="password" name="password" class="form-control" placeholder="Password rahasia"
                            required>
                    </div>
                    <button type="submit" class="btn btn-success">Kirim Laporan</button>
                </form>
            </div>
        </div>

    </div>
    <?php include 'partials/footer.php'; ?>
</div>