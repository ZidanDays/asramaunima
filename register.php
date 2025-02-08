<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Connect Plus</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css" />
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="assets/images/logo-dark.svg" />
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3" action="proses_register.php" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputUserNama"
                                        name="nama" placeholder="Nama" required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputUserNIM"
                                        name="nim" placeholder="NIM" required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="tempat_lahir"
                                        placeholder="Tempat Lahir" required />
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-lg" name="tanggal_lahir"
                                        required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="jurusan"
                                        placeholder="Jurusan" required />
                                </div>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="fakultas" required>
                                        <option value="" disabled selected>Pilih Fakultas</option>
                                        <option value="Fakultas Ilmu Pendidikan">Fakultas Ilmu Pendidikan</option>
                                        <option value="Fakultas Teknik">Fakultas Teknik</option>
                                        <option value="Fakultas Ilmu Keolahragaan">Fakultas Ilmu Keolahragaan</option>
                                        <option value="Fakultas Bahasa dan Seni">Fakultas Bahasa dan Seni</option>
                                        <option value="Fakultas Matematika dan Ilmu Pengetahuan Alam">Fakultas
                                            Matematika dan Ilmu Pengetahuan Alam</option>
                                        <option value="Fakultas Ilmu Sosial">Fakultas Ilmu Sosial</option>
                                        <option value="Fakultas Ekonomi">Fakultas Ekonomi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" name="no_hp"
                                        placeholder="Nomor HP/WA" required />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        placeholder="Email" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" name="password" placeholder="Password" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword2" name="password_confirmation"
                                        placeholder="Konfirmasi Password" required />
                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="termsCheck" required />
                                        <label class="form-check-label text-muted" for="termsCheck">
                                            Saya setuju dengan Syarat & Ketentuan
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        DAFTAR
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Sudah punya akun?
                                    <a href="index.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div> <!-- Menutup div yang hilang -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.querySelector("form").addEventListener("submit", function(e) {
        var password = document.getElementById("exampleInputPassword1").value;
        var confirmPassword = document.getElementById("exampleInputPassword2").value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert("Password dan Konfirmasi Password Tidak Cocok!")
        }
    });
    </script>

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
</body>

</html>