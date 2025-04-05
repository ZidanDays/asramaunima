<?php
include '../conf/conf.php';

$idMhs = $_SESSION['user_id'];

// Mengambil data dari database
$query = "SELECT pemesanan_kamar.*, kamar.nomor_kamar, kamar.status, asrama.nama AS nasr
          FROM pemesanan_kamar 
          JOIN kamar ON pemesanan_kamar.kamar_id = kamar.id
          JOIN asrama ON kamar.asrama_id = asrama.id 
          WHERE pemesanan_kamar.mahasiswa_id = ?";


$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idMhs);
$stmt->execute();
$result = $stmt->get_result();

$tanggal_sekarang = date('d');
$jadwal_pembayaran = "Setiap tanggal 20";
$peringatan = ($tanggal_sekarang >= 15) 
    ? "<span style='color: red; font-weight: bold;'>Segera bayar sebelum tanggal 20!</span>" 
    : "<span style='color: green;'>Jadwal pembayaran masih jauh.</span>";
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Kamar Saya</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="table-responsive">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asrama</th>
                                    <th>Nomor Kamar</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $status_pembayaran = isset($row['status_pembayaran']) ? decryptData($row['status_pembayaran']) : "Tidak Diketahui"; 

                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>" . htmlspecialchars($row['nasr']) . "</td>
                                            <td>" . htmlspecialchars($row['nomor_kamar']) . "</td>
                                            <td style='color: " . ($status_pembayaran == 'verified' ? "green" : "red") . ";'>
                                                " . htmlspecialchars($status_pembayaran) . "
                                            </td>
                                            <td>" . htmlspecialchars($row['status']) . "</td>
                                            <td>
                                                <a href='?q=kamar-saya-hapus&id=" . htmlspecialchars($row['id']) . "&kamarId=" . htmlspecialchars($row['kamar_id']) . "' 
                                                   class='btn btn-danger btn-sm' 
                                                   onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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
    </div>

    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Jadwal Pembayaran</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="table-responsive">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status</th>
                                    <th>Jadwal Pembayaran</th>
                                    <th>Jumlah Tagihan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Keterangan</th>
                                    <th>Bukti Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $no = 1;

                                while ($row = $result->fetch_assoc()) {
                                    $status_pembayaran = isset($row['status_pembayaran']) ? decryptData($row['status_pembayaran']) : "Tidak Diketahui";

                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td style='color: " . ($status_pembayaran == 'verified' ? "green" : "red") . ";'>
                                                " . htmlspecialchars($status_pembayaran) . "
                                            </td>
                                            <td>" . htmlspecialchars($row['status']) . "</td>
                                            <td>{$jadwal_pembayaran} <br> {$peringatan}</td>
                                            <td>Rp. 400.000</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <a href='?q=kamar-saya-hapus&id=" . htmlspecialchars($row['id']) . "&kamarId=" . htmlspecialchars($row['kamar_id']) . "' 
                                                   class='btn btn-danger btn-sm' 
                                                   onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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
    </div>

    <?php include 'partials/footer.php'; ?>
</div>

<?php
$stmt->close();
?>