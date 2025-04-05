<?php
session_start();
include '../conf/config.php';
$user_id = $_SESSION['user_id'];
$queryNotif = "SELECT * FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
$stmt = $conn->prepare($queryNotif);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultNotif = $stmt->get_result();


$queryJumlah = "SELECT COUNT(*) as jumlah FROM notifikasi WHERE user_id = ? AND status = 'belum_dibaca'";
$stmtJumlah = $conn->prepare($queryJumlah);
$stmtJumlah->bind_param("i", $user_id);
$stmtJumlah->execute();
$resultJumlah = $stmtJumlah->get_result()->fetch_assoc();
$jumlahNotif = $resultJumlah['jumlah'];

?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

        <a href="index.php"><img src="../assets/images/AUW.png" style="width: 30%; margin-top: 30px;" alt="logo" /></a>
        <!-- <a class="navbar-brand brand-logo" href="index.php"><img src="../assets/images/logo.svg" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="../assets/images/logo-mini.svg"
                alt="logo" /></a> -->
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <!-- <div class="search-field d-none d-xl-block">
            <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search products">
                </div>
            </form>
        </div> -->
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <!-- <img src="../assets/images/faces/face28.png" alt="image"> -->
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">Operator</p>
                    </div>
                </a>
                <!-- <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
                    aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                    <div class="p-3 text-center bg-primary">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="../assets/images/faces/face28.png"
                            alt="">
                    </div>
                    <div class="p-2">
                        <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                            <span>Inbox</span>
                            <span class="p-0">
                                <span class="badge badge-primary">3</span>
                                <i class="mdi mdi-email-open-outline ml-1"></i>
                            </span>
                        </a>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                            <span>Profile</span>
                            <span class="p-0">
                                <span class="badge badge-success">1</span>
                                <i class="mdi mdi-account-outline ml-1"></i>
                            </span>
                        </a>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                            href="javascript:void(0)">
                            <span>Settings</span>
                            <i class="mdi mdi-settings"></i>
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                            <span>Lock Account</span>
                            <i class="mdi mdi-lock ml-1"></i>
                        </a>
                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                            <span>Log Out</span>
                            <i class="mdi mdi-logout ml-1"></i>
                        </a>
                    </div>
                </div> -->
            </li>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="mdi mdi-email-outline"></i>
                    <span class="count-symbol bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="messageDropdown">
                    <h6 class="p-3 mb-0 bg-primary text-white py-4">Messages</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="../assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message
                            </h6>
                            <p class="text-gray mb-0"> 1 Minutes ago </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="../assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a
                                message</h6>
                            <p class="text-gray mb-0"> 15 Minutes ago </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="../assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated
                            </h6>
                            <p class="text-gray mb-0"> 18 Minutes ago </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <h6 class="p-3 mb-0 text-center">4 new messages</h6>
                </div>
            </li> -->


            <!-- notifikasi bell -->
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
                    <div class="dropdown-divider"></div>
                    <span class="count-symbol bg-danger"><?= $jumlahNotif ?></span>
                    <!-- Optional: tambahkan hitung notifikasi belum dibaca -->
                    <?php while ($notif = $resultNotif->fetch_assoc()): ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-<?= htmlspecialchars($notif['warna']) ?>">
                                <i class="mdi mdi-<?= htmlspecialchars($notif['icon']) ?>"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                            <h6 class="preview-subject font-weight-normal mb-1"><?= htmlspecialchars($notif['judul']) ?>
                            </h6>
                            <p class="text-gray ellipsis mb-0"><?= htmlspecialchars($notif['pesan']) ?></p>
                        </div>
                    </a>
                    <?php endwhile; ?>
                    <div class="dropdown-divider"></div>
                    <a href="dsvdvs">
                        <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                    </a>
                </div>
            </li>
            <!-- end of notifikasi -->
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>