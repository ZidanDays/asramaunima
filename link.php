<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {

        case 'beranda':
            include './pages/beranda/beranda.php';
            break;



            //SURAT MASUK
        case 'data-arsip':
            include './pages/data-arsip/data-arsip.php';
            break;

        case 'data-arsip-preview':
            include './pages/data-arsip/preview/arsip_preview.php';
            break;

        case 'data-arsip-download':
            include './pages/data-arsip/download/arsip_download.php';
            break;


            //SURAT KELUAR
        case 'surat_keluar':
            include './pages/surat_keluar/surat_keluar.php';
            break;

        case 'surat_keluar_preview':
            include './pages/surat_keluar/preview/arsip_preview.php';
            break;

        case 'surat_keluar_download':
            include './pages/surat_keluar/download/arsip_download.php';
            break;

            //data_user
        case 'data_user':
            include './pages/data_user/data_user.php';
            break;

        case 'user_tambah':
            include './pages/data_user/user_tambah/user_tambah.php';
            break;

        case 'user_edit':
            include './pages/data_user/user_edit/user_edit.php';
            break;

        case 'user_aksi':
            include './pages/data_user/user_aksi/user_aksi.php';
            break;

        case 'user_hapus':
            include './pages/data_user/user_hapus/user_hapus.php';
            break;

        case 'user_update':
            include './pages/data_user/user_update/user_update.php';
            break;

            //end of data user

        case 'gantipas':
            include './pages/gantipas/gantipas.php';
            break;

        case 'gantipasproses':
            include './pages/gantipas/gantipasproses/gantipasproses.php';
            break;

        case 'load_data_table':
            include './pages/data-arsip/load_data_table/load_data_table.php';
            break;

        case 'tables':
            include './pages/tables/tables.php';
            break;

        case 'logout':
            include './pages/logout/logout.php';
            break;
    }
} else {
    include './pages/beranda/beranda.php';
}
