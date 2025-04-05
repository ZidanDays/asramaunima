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
                                    <!-- <th>Waktu</th> -->
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $no = 1;
                                        $no = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            $status_pembayaran = decryptData($row['status_pembayaran']); // Dekripsi data
                                        
                                            echo "<tr>
                                                    <td>{$no}</td>
                                                    <td>{$row['nasr']}</td>
                                                    <td>{$row['nomor_kamar']}</td>";
                                        
                                                    if ($status_pembayaran == 'verified') {
                                                        echo "<td style='color: green;'>{$status_pembayaran} : {$row['status_pembayaran']}</td>";
                                                    } else {
                                                        echo "<td style='color: red;'>{$status_pembayaran} : {$row['status_pembayaran']}</td>";
                                                    }
                                                    
                                        
                                            echo "<td>{$row['status']}</td>
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
    </div>
    <?php include 'partials/footer.php'; ?>
</div>