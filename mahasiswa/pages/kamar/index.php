<?php
include '../conf/conf.php';

// Mengambil data dari database
$result = $conn->query("SELECT kamar.*, asrama.nama AS nama_asrama FROM 
kamar JOIN asrama ON kamar.asrama_id = asrama.id");
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
    <?php include 'partials/footer.php'; ?>
</div>