<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan id adalah integer
    $idKmr = intval($_GET['idKmr']); // Pastikan id adalah integer
    $conn->query("UPDATE kamar SET status='terisi' WHERE id=$idKmr");
    $verifiedStatus = encryptData('verified'); // Enkripsi 'verified'

    if ($verifiedStatus) { // Pastikan enkripsi berhasil
        // Gunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("UPDATE pemesanan_kamar SET status_pembayaran=? WHERE id=?");
        $stmt->bind_param("si", $verifiedStatus, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Pembayaran berhasil diverifikasi'); window.location='?q=beranda';</script>";
        } else {
            echo "<script>alert('Gagal memverifikasi pembayaran');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Kesalahan dalam enkripsi data');</script>";
    }
}

// Ambil data pemesanan dengan informasi kamar dan mahasiswa
$pemesanan = $conn->query("
SELECT pemesanan_kamar.*, kamar.nomor_kamar, users.nama, users.nim, users.tempat_lahir, users.no_hp, users.jurusan, users.fakultas,  asrama.nama AS na
FROM pemesanan_kamar
JOIN kamar ON pemesanan_kamar.kamar_id = kamar.id
JOIN users ON users.id_kamar = kamar.id
JOIN asrama ON kamar.asrama_id = asrama.id
");

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Verifikasi Pembayaran</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Tambahkan div ini -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Tempat Lahir</th>
                                    <th>No HP</th>
                                    <th>Jurusan</th>
                                    <th>Fakultas</th>
                                    <th>Asrama</th>
                                    <th>Nomor Kamar</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $pemesanan->fetch_assoc()) {
                                    $status_pembayaran = decryptData($row['status_pembayaran']);

                                    // Jika decryptData gagal, tampilkan pesan default
                                    if (!$status_pembayaran) {
                                        $status_pembayaran = "[Data Tidak Valid]";
                                    }

                                    echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['nim']}</td>
                                        <td>{$row['tempat_lahir']}</td>
                                        <td>{$row['no_hp']}</td>
                                        <td>{$row['jurusan']}</td>
                                        <td>{$row['fakultas']}</td>
                                        <td>{$row['na']}</td>
                                        <td>{$row['nomor_kamar']}</td>
                                        <td>{$status_pembayaran}</td>
                                        <td>";

                                    // Tombol verifikasi hanya muncul jika belum 'verified'
                                    if ($status_pembayaran !== 'verified') {
                                        echo "<a href='?id={$row['id']}&idKmr={$row['kamar_id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Yakin ingin memverifikasi pembayaran ini?\")'>Verifikasi</a>";
                                    } else {
                                        echo "<span class='badge badge-success'>Terverifikasi</span>";
                                    }

                                    echo "</td></tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- Akhir table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</div>