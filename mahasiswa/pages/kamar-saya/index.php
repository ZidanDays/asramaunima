<?php
include '../conf/conf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

$idMhs = $_SESSION['user_id'];
$tanggal_sekarang = date('Y-m-d');
$bulan_ini = date('Y-m');

// Cek apakah tagihan untuk bulan ini sudah ada
$queryCek = "SELECT id FROM pembayaran WHERE mahasiswa_id = ? AND bulan = ?";
$stmtCek = $conn->prepare($queryCek);
$stmtCek->bind_param("is", $idMhs, $bulan_ini);
$stmtCek->execute();
$resultCek = $stmtCek->get_result();

// if ($resultCek->num_rows == 0 && date('d') >= 20) {
if ($resultCek->num_rows == 0 && date('d') >= 1) {
    // Ambil kamar yang dipesan oleh mahasiswa
    $queryKamar = "SELECT kamar_id FROM pemesanan_kamar WHERE mahasiswa_id = ?";
    $stmtKamar = $conn->prepare($queryKamar);
    $stmtKamar->bind_param("i", $idMhs);
    $stmtKamar->execute();
    $resultKamar = $stmtKamar->get_result();

    if ($rowKamar = $resultKamar->fetch_assoc()) {
        $kamarId = $rowKamar['kamar_id'];
        
        // Buat tagihan otomatis
        $queryInsert = "INSERT INTO pembayaran (mahasiswa_id, kamar_id, bulan, status, jumlah) 
                        VALUES (?, ?, ?, 'pending', 250000)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param("iis", $idMhs, $kamarId, $bulan_ini);
        $stmtInsert->execute();
    }
    $stmtKamar->close();
}
$stmtCek->close();

// Query ulang untuk "Kamar Saya"
$queryKamarUlang = "SELECT k.id, k.nomor_kamar, a.nama as asrama_nama, k.status 
                    FROM pemesanan_kamar pk
                    JOIN kamar k ON pk.kamar_id = k.id
                    JOIN asrama a ON k.asrama_id = a.id
                    WHERE pk.mahasiswa_id = ?";
$stmtKamarUlang = $conn->prepare($queryKamarUlang);
$stmtKamarUlang->bind_param("i", $idMhs);
$stmtKamarUlang->execute();
$resultKamarUlang = $stmtKamarUlang->get_result();

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

// $peringatan = (date('d') >= 15) 
$peringatan = (date('d') >= 1) 
    ? "<span class='text-danger font-weight-bold'>Segera bayar sebelum tanggal 20!</span>" 
    : "<span class='text-success'>Jadwal pembayaran masih jauh.</span>";
?>

<div class="main-panel">
    <!-- Bagian Kamar Saya -->
    <div class="content-wrapper">
        <div class="card mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Kamar Saya</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if ($resultKamarUlang->num_rows > 0): ?>
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
                while ($row = $resultKamarUlang->fetch_assoc()):
                    $statusClass = ($row['status'] == 'terisi') ? 'text-success' : 'text-warning';
                ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= htmlspecialchars($row['asrama_nama']) ?></td>
                                    <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                    <td class="<?= $statusClass ?> font-weight-bold">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </td>
                                    <td>
                                        <a href="?q=kamar-saya-hapus&id=<?= htmlspecialchars($row['id']) ?>&kamarId=<?= htmlspecialchars($row['id']) ?>"
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

            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Bagian Jadwal Pembayaran -->
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Jadwal Pembayaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                    $statusClass = ($row['status'] == 'verified') ? 'text-success' : 'text-danger';
                    $bukti_pembayaran = $row['bukti_pembayaran'] 
                        ? "<a href='uploads/" . htmlspecialchars($row['bukti_pembayaran']) . "' target='_blank' class='btn btn-sm btn-info'>Lihat Bukti</a>" 
                        : "<span class='text-muted'>Belum Upload</span>";
                ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= htmlspecialchars($row['bulan']) ?></td>
                                <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                <td class="<?= $statusClass ?> font-weight-bold">
                                    <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                </td>
                                <td>Setiap tanggal 20</td>
                                <td>Rp. 250.000</td>
                                <td><?= $bukti_pembayaran ?></td>
                                <td>
                                    <!-- <form action="index.php?q=upload_bukti_pembayaran" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="pembayaran_id"
                                            value="<?= htmlspecialchars($row['id']) ?>">
                                        <input type="file" name="bukti" class="form-control-file mb-2" required>
                                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                    </form> -->
                                    <form action="index.php?q=upload_bukti_pembayaran" method="POST"
                                        enctype="multipart/form-data">
                                        <label for="bukti">Upload Bukti Pembayaran:</label>
                                        <input type="file" name="bukti" required><br><br>

                                        <label for="password">Password Enkripsi:</label>
                                        <input type="password" name="password" required><br><br>

                                        <!-- <input type="hidden" name="pembayaran_id" value="123"> -->
                                        <input type="hidden" name="pembayaran_id"
                                            value="<?= htmlspecialchars($row['id']) ?>">
                                        <!-- <input type="hidden" name="kamar_id" value="123">
                                        <input type="hidden" name="mahasiswa_id" value="123"> -->
                                        <!-- Sesuaikan dengan ID pembayaran -->

                                        <button type="submit">Upload & Enkripsi</button>
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
    </div>
    <?php include 'partials/footer.php'; ?>
</div>

<?php
$stmtPembayaran->close();
$stmtKamarUlang->close();
$conn->close();
?>