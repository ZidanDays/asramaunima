<?php
include '../conf/conf.php';

$idMhs = $_SESSION['user_id'];

// Mengambil data dari database
$result = $conn->query("SELECT pemesanan_kamar.*, kamar.nomor_kamar, kamar.status, asrama.nama AS nasr
FROM pemesanan_kamar JOIN kamar 
ON pemesanan_kamar.kamar_id = kamar.id JOIN
asrama ON kamar.asrama_id = asrama.id WHERE pemesanan_kamar.mahasiswa_id = $idMhs");

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Kamar Saya</h2>
            <!-- <a href="?q=asrama-tambah" class="btn btn-primary">+ Tambah Asrama</a> -->
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Asrama</th>
                                <th>Nomor Kamar</th>
                                <th>Status Pembayaran</th>
                                <th>Status</th>
                                <!-- <th>Waktu</th> -->
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$no}</td>
                                                    <td>{$row['nasr']}</td>
                                                    <td>{$row['nomor_kamar']}</td>
                                                    <td>{$row['status_pembayaran']}</td>
                                                    <td>{$row['status']}</td>
                                                    <td>

                                                        <a href='?q=kamar-saya-hapus&id={$row['id']}&kamarId={$row['kamar_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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
    <?php include 'partials/footer.php'; ?>
</div>