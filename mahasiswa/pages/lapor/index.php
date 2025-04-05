<?php
include '../conf/conf.php';

// Mengambil data dari database
$result = $conn->query("SELECT kamar.*, asrama.nama AS nama_asrama FROM 
kamar JOIN asrama ON kamar.asrama_id = asrama.id");
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Lapor</h2>
            <!-- <a href="?q=kamar-tambah" class="btn btn-primary">+ Tambah</a> -->
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- <p>Untuk Lakukan Pembayaran Online, Bisa Hubungi Nomor WhatsApp ini
                        <a href="https://wa.me/+6287759038021" target="_blank">0877-5903-8021</a> (Operator)
                    </p> -->
                </div>
            </div>
        </div>

    </div>
    <?php include 'partials/footer.php'; ?>
</div>