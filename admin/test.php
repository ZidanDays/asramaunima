<?php
include '../conf/conf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $verifiedStatus = encryptData('verified'); // Enkripsi 'verified'

    // Gunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("UPDATE pemesanan_kamar SET status_pembayaran=? WHERE id=?");
    $stmt->bind_param("si", $verifiedStatus, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Pembayaran berhasil diverifikasi'); window.location='?q=beranda';</script>";
    } else {
        echo "<script>alert('Gagal memverifikasi pembayaran');</script>";
    }
}



// Ambil data pemesanan dengan informasi kamar dan mahasiswa
$pemesanan = $conn->query("
    SELECT pemesanan_kamar.*, kamar.nomor_kamar, users.nama
FROM pemesanan_kamar
JOIN kamar ON pemesanan_kamar.kamar_id = kamar.id
JOIN users ON users.id_kamar = kamar.id;
");


var_dump($status_pembayaran);
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Verifikasi Pembayaran</h2>
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mahasiswa</th>
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
                                echo $status_pembayaran;
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['nomor_kamar']}</td>
                                    <td>{$row['status_pembayaran']}</td>
                                    <td>";

                                // Tombol verifikasi hanya muncul jika belum verified
                                if ($status_pembayaran !== 'verified') {
                                    echo "<a href='?id={$row['id']}' class='btn btn-warning btn-sm' onclick='return confirm(\"Yakin ingin memverifikasi pembayaran ini?\")'>Verifikasi</a>";
                                } else {
                                    echo "<span class='badge badge-success'>Verifikasi</span>";
                                }

                                echo "</td></tr>";
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