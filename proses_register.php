<?php

include "conf/conf.php";

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jurusan = $_POST['jurusan'];
    $fakultas = $_POST['fakultas'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    // Validasi password
    if ($password !== $password_confirmation) {
        echo "<script>alert('Password dan Konfirmasi Password Tidak Cocok!'); window.location.href='index.php';</script>";
        exit();
    }

    // Enkripsi password menggunakan bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data ke database
    $sql = "INSERT INTO users (nama, nim, tempat_lahir, tanggal_lahir, jurusan, fakultas, no_hp, email, password)
            VALUES ('$nama', '$nim', '$tempat_lahir', '$tanggal_lahir', '$jurusan', '$fakultas', '$no_hp', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registrasi berhasil!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
?>