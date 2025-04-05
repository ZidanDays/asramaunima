<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {


        case 'beranda':
            include './pages/beranda/index.php';
            break; 

        //asrama
        case 'asrama':
            include './pages/asrama/index.php';
            break; 
        case 'asrama-tambah':
            include './pages/asrama/tambah.php';
            break; 
        case 'asrama-edit':
            include './pages/asrama/edit.php';
            break; 
        case 'asrama-hapus':
            include './pages/asrama/hapus.php';
            break; 
        //end of asrama

            
        //kamar
        case 'kamar':
            include './pages/kamar/index.php';
            break; 
        case 'kamar-tambah':
            include './pages/kamar/tambah.php';
            break; 
        case 'kamar-edit':
            include './pages/kamar/edit.php';
            break; 
        case 'kamar-hapus':
            include './pages/kamar/hapus.php';
            break; 
        //end of kamar


        
            // laporfasilitas
            case 'lapor_fasilitas':
                include './pages/lapor_fasilitas/index.php';
                break;
            case 'proses_lapor':
                include './pages/lapor_fasilitas/proses_lapor.php';
                break;

            case 'ubah_status_laporan':
                include './pages/lapor_fasilitas/ubah_status_laporan.php';
                break;
                // end of lapor fasilitas

        // verifikasi pembayaran
        case 'verifikasi_pembayaran':
            include './pages/verifikasi_pembayaran/index.php';
            break;
        // end of verifikasi pembayaran


        // lihat bukti
        case 'lihat_bukti':
            include './pages/lihat_bukti/index.php';
            break;
        // end of lihat bukti

        case 'logout':
            include './pages/logout/logout.php';
            break;
    }
} else {
    include './pages/beranda/index.php';
}