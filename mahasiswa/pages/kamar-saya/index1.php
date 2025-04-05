<?php
include '../conf/conf.php';

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validasi user_id
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

$idMhs = $_SESSION['user_id'];

// Query untuk menampilkan informasi kamar mahasiswa
$queryKamar = "SELECT pemesanan_kamar.*, kamar.nomor_kamar, kamar.status, asrama.nama AS asrama_nama
               FROM pemesanan_kamar 
               JOIN kamar ON pemesanan_kamar.kamar_id = kamar.id
               JOIN asrama ON kamar.asrama_id = asrama.id 
               WHERE pemesanan_kamar.mahasiswa_id = ?";

$stmtKamar = $conn->prepare($queryKamar);
$stmtKamar->bind_param("i", $idMhs);
$stmtKamar->execute();
$resultKamar = $stmtKamar->get_result();

// Query untuk menampilkan jadwal pembayaran
$queryPembayaran = "SELECT pembayaran.*, kamar.nomor_kamar 
                    FROM pembayaran 
                    JOIN kamar ON pembayaran.kamar_id = kamar.id 
                    WHERE pembayaran.mahasiswa_id = ? 
                    ORDER BY pembayaran.bulan DESC";

$stmtPembayaran = $conn->prepare($queryPembayaran);
$stmtPembayaran->bind_param("i", $idMhs);
$stmtPembayaran->execute();
$resultPembayaran = $stmtPembayaran->get_result();

$tanggal_sekarang = date('d');
$peringatan = ($tanggal_sekarang >= 15) 
    ? "<span class='text-danger font-weight-bold'>Segera bayar sebelum tanggal 20!</span>" 
    : "<span class='text-success'>Jadwal pembayaran masih jauh.</span>";
?>

<div class="main-panel">
    <div class="content-wrapper">
        <!-- Bagian Kamar Saya -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Kamar Saya</h4>
            </div>
            <div class="card-body">
                <?php if ($resultKamar->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Asrama</th>
                            <th>Nomor Kamar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $resultKamar->fetch_assoc()):
                            $statusClass = ($row['status'] == 'terisi') ? 'text-success' : 'text-warning';
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($row['asrama_nama']) ?></td>
                            <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                            <td class="<?= $statusClass ?> font-weight-bold"><?= htmlspecialchars($row['status']) ?>
                            </td>
                            <td>
                                <a href="?q=kamar-saya-hapus&id=<?= htmlspecialchars($row['id']) ?>&kamarId=<?= htmlspecialchars($row['kamar_id']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            $no++;
                        endwhile; 
                        ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-info">Anda belum memiliki kamar yang dipesan.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bagian Jadwal Pembayaran -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Jadwal Pembayaran</h4>
            </div>
            <div class="card-body">
                <?php if ($resultPembayaran->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Nomor Kamar</th>
                            <th>Status Pembayaran</th>
                            <th>Jadwal Pembayaran</th>
                            <th>Jumlah Tagihan</th>
                            <th>Bukti Pembayaran</th>
                            <th>Upload Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $resultPembayaran->fetch_assoc()):
                            $status_pembayaran = $row['status'];
                            $statusClass = ($status_pembayaran == 'verified') ? 'text-success' : 'text-danger';
                            $bukti_pembayaran = $row['bukti_pembayaran'] 
                                ? "<a href='../uploads/" . htmlspecialchars($row['bukti_pembayaran']) . "' target='_blank' class='btn btn-sm btn-info'>Lihat Bukti</a>" 
                                : "<span class='text-muted'>Belum Upload</span>";
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($row['bulan_pembayaran']) ?></td>
                            <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                            <td class="<?= $statusClass ?> font-weight-bold">
                                <?= ucfirst(htmlspecialchars($status_pembayaran)) ?>
                            </td>
                            <td>Setiap tanggal 20 <br><?= $peringatan ?></td>
                            <td>Rp. 400.000</td>
                            <td><?= $bukti_pembayaran ?></td>
                            <td>
                                <form action="upload_bukti.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="pembayaran_id" value="<?= $row['id'] ?>">
                                    <div class="form-group mb-2">
                                        <input type="file" name="bukti" accept="image/*,application/pdf"
                                            class="form-control-file" required>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                </form>
                            </td>
                        </tr>
                        <?php 
                            $no++;
                        endwhile; 
                        ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-info">Tidak ada jadwal pembayaran yang ditemukan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>
</div>

<?php
$stmtKamar->close();
$stmtPembayaran->close();
$conn->close();
?>