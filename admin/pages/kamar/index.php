<?php
include '../conf/conf.php';

// Mengambil data dari database
$result = $conn->query("SELECT kamar.*, asrama.nama AS nama_asrama FROM 
kamar JOIN asrama ON kamar.asrama_id = asrama.id");


// Ambil data pembayaran mahasiswa
$queryPembayaran = "SELECT pembayaran.*, users.nama, kamar.nomor_kamar 
                    FROM pembayaran 
                    JOIN users ON pembayaran.mahasiswa_id = users.id 
                    JOIN kamar ON pembayaran.kamar_id = kamar.id 
                    ORDER BY pembayaran.bulan DESC";
$resultPembayaran = $conn->query($queryPembayaran);

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Daftar Asrama</h2>
            <a href="?q=kamar-tambah" class="btn btn-primary">+ Tambah</a>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Asrama</th>
                                <th>Nomor Kamar</th>
                                <th>Kapasitas</th>
                                <th>Fasilitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$no}</td>
                                                    <td>{$row['nama_asrama']}</td>
                                                    <td>{$row['nomor_kamar']}</td>
                                                    <td>{$row['kapasitas']}</td>
                                                    <td>{$row['fasilitas']}</td>
                                                    <td>{$row['status']}</td>
                                                    <td>
                                                        <a href='?q=kamar-edit&id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                        <a href='?q=kamar-hapus&id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                                    </td>
                                                </tr>";
                                            $no++;
                                        }
                                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Kelola Pembayaran Mahasiswa</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Bulan</th>
                                <th>Nomor Kamar</th>
                                <th>Status</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $resultPembayaran->fetch_assoc()):
                                $statusClass = ($row['status'] == 'verified') ? 'text-success' : 'text-danger';
                                $bukti_pembayaran = $row['bukti_pembayaran'] 
                                    ? "<a href='../mahasiswa/uploads/" . htmlspecialchars($row['bukti_pembayaran']) . "' target='_blank' class='btn btn-sm btn-info'>Lihat Bukti</a>" 
                                    : "<span class='text-muted'>Belum Upload</span>";
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['bulan']) ?></td>
                                <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                <td class="<?= $statusClass ?> font-weight-bold">
                                    <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                </td>
                                <!-- <td><?= $bukti_pembayaran ?></td> -->
                                <td>
                                    <form action="index.php?q=lihat_bukti" method="POST">
                                        <label for="password">Masukkan Password Dekripsi:</label>
                                        <input type="password" name="password" required><br><br>

                                        <input type="hidden" name="pembayaran_id"
                                            value="<?= htmlspecialchars($row['id']) ?>">
                                        <!-- <input type="hidden" name="pembayaran_id" value="123"> -->
                                        <!-- Sesuaikan dengan ID pembayaran -->

                                        <button type="submit">Lihat Bukti Pembayaran</button>
                                    </form>
                                </td>
                                <td>
                                    <?php if ($row['status'] !== 'verified'): ?>
                                    <a href="index.php?q=verifikasi_pembayaran&id=<?= $row['id'] ?>"
                                        class="btn btn-success btn-sm">Verifikasi</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                $no++;
                            endwhile; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php include 'partials/footer.php'; ?>
    </div>