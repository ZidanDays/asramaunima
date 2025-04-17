<?php
include '../conf/conf.php'; // Koneksi database
include 'encrypt_helper.php'; // Load fungsi enkripsi
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembayaran_id = $_POST['pembayaran_id'];
    $password = $_POST['password']; // Password untuk enkripsi

    if (!empty($_FILES['bukti']['name']) && !empty($password)) {
        $file_tmp = $_FILES['bukti']['tmp_name'];
        $file_name = time() . "_" . $_FILES['bukti']['name']; // Nama unik
        $encrypted_file = "uploads/" . $file_name; // Simpan di folder uploads

        // Enkripsi file
        if (encryptFile($file_tmp, $encrypted_file, $password)) {
            // Simpan nama file ke database
            $query = "UPDATE pembayaran SET bukti_pembayaran=?, password=? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $file_name, $password, $pembayaran_id);

            if ($stmt->execute()) {
                // === Tambahkan Notifikasi untuk Admin ===
                $admin_id = 7; // ID admin, sesuaikan jika perlu
                $nama_mahasiswa = $_SESSION['user_name'];
                $judul = "Bukti Pembayaran Masuk";
                $pesan = "Mahasiswa <b>$nama_mahasiswa</b> telah mengunggah bukti pembayaran.";
                $icon = "calendar";
                $warna = "warning";
                $status = "belum_dibaca";

                $conn->query("INSERT INTO notifikasi (user_id, judul, pesan, icon, warna, status) 
                              VALUES ('$admin_id', '$judul', '$pesan', '$icon', '$warna', '$status')");
                // === End Notifikasi ===

                echo "<script>alert('Bukti pembayaran berhasil diupload dan dienkripsi!'); window.location='index.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan bukti pembayaran.'); window.location='index.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Gagal mengenkripsi bukti pembayaran.'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Pilih file dan masukkan password.'); window.location='index.php';</script>";
    }
}

// // Kalau admin lebih dari satu dan kamu ingin broadcast ke semua admin, tinggal diganti bagian ini:
// $getAdmins = $conn->query("SELECT id FROM users WHERE role = 'admin'");
// while ($admin = $getAdmins->fetch_assoc()) {
//     $admin_id = $admin['id'];
//     $conn->query("INSERT INTO notifikasi (user_id, judul, pesan, icon, warna, status) 
//                   VALUES ('$admin_id', '$judul', '$pesan', '$icon', '$warna', '$status')");
// }

?>