<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$namaMhs = $_SESSION['user_name'];
$idMhs = $_SESSION['user_id'];

include '../conf/conf.php';
// include '../conf/aes.php';
if ($_POST) {
    $kamar_id = $_POST['kamar_id'];
    // $mahasiswa = $_POST['mahasiswa'];

    // encrypt dan input ke table
    $status_pembayaran = encryptData('pending'); // Misalnya, default 'pending'
    $conn->query("INSERT INTO pemesanan_kamar (kamar_id, mahasiswa_id, status_pembayaran) VALUES ($kamar_id, '$idMhs', '$status_pembayaran')");
    $conn->query("UPDATE kamar SET status='belum bayar' WHERE id=$kamar_id");
    $conn->query("UPDATE users SET id_kamar=$kamar_id WHERE id=$idMhs");
    echo "<script>alert('Pemesanan berhasil, silakan lakukan pembayaran Ke Operator.');</script>";
}
$asramas = $conn->query("SELECT kamar.*, asrama.nama, asrama.kapasitas FROM kamar JOIN asrama ON kamar.asrama_id = asrama.id
 WHERE kamar.status='kosong'");


?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-dark font-weight-bold">Daftar Asrama</h2>
            <!-- <a href="?q=kamar-tambah" class="btn btn-primary">+ Tambah</a> -->
        </div>

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">

                        <!-- <div class="form-group">
                            <label>Nama Mahasiswa</label>
                            <input type="text" name="mahasiswa" class="form-control" required>
                        </div> -->
                        <div class="form-group">
                            <label>Asrama</label>
                            <select name="asrama_id" id="asrama_id" class="form-control" required
                                onchange="getKamarKosong()">
                                <option value="">-- Pilih Asrama --</option>
                                <?php 
                                $asramas = $conn->query("SELECT * FROM asrama");
                                while ($row = $asramas->fetch_assoc()) : ?>
                                <option value="<?= $row['id'] ?>">Asrama <?= $row['nama'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kamar</label>
                            <select name="kamar_id" id="kamar_id" class="form-control" required>
                                <option value="">-- Pilih Kamar --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Fasilitas</label>
                            <input type="text" name="fasilitas" id="fasilitas" class="form-control" required readonly>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <!-- <a href="?q=beranda" class="btn btn-secondary">Kembali</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include 'partials/footer.php'; ?>
</div>
<script>
function getKamarKosong() {
    var asrama_id = document.getElementById("asrama_id").value;
    var kamarSelect = document.getElementById("kamar_id");
    var fasilitasInput = document.getElementById("fasilitas");

    // Kosongkan dropdown kamar & input fasilitas
    kamarSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';
    fasilitasInput.value = '';

    if (asrama_id) {
        fetch('get_kamar.php?asrama_id=' + asrama_id)
            .then(response => response.json())
            .then(data => {
                data.forEach(kamar => {
                    var option = document.createElement("option");
                    option.value = kamar.id;
                    option.textContent = "Kamar Nomor " + kamar.nomor_kamar;
                    option.dataset.fasilitas = kamar.fasilitas; // Simpan data fasilitas
                    kamarSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching kamar:', error));
    }
}

// Event listener untuk mengisi fasilitas otomatis saat kamar dipilih
document.getElementById("kamar_id").addEventListener("change", function() {
    var selectedOption = this.options[this.selectedIndex];
    var fasilitasInput = document.getElementById("fasilitas");

    if (selectedOption.value) {
        // Pastikan dataset.fasilitas tidak undefined, jika ya, beri nilai default kosong
        fasilitasInput.value = selectedOption.dataset.fasilitas !== undefined ? selectedOption.dataset
            .fasilitas : '';
    } else {
        fasilitasInput.value = '';
    }
});
</script>