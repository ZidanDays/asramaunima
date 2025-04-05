<?php
@$page = $_GET['q'];
if (!empty($page)) {
    switch ($page) {


        //asrama
        // case 'asrama':
        //     include './pages/asrama/index.php';
        //     break; 
        // case 'asrama-tambah':
        //     include './pages/asrama/tambah.php';
        //     break; 
        // case 'asrama-edit':
        //     include './pages/asrama/edit.php';
        //     break; 
        // case 'asrama-hapus':
        //     include './pages/asrama/hapus.php';
        //     break; 
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


        //kamar saya        
        case 'kamar-saya':
            include './pages/kamar-saya/index.php';
            break;

        case 'kamar-saya-hapus':
            include './pages/kamar-saya/hapus.php';
            break;

        //end of kamar saya


        // pembayaran
            case 'upload_bukti_pembayaran':
                include './pages/upload_bukti_pembayaran/index.php';
                break;
        // end of permbayaran

        case 'info':
            include './pages/info/index.php';
            break;

            // laporfasilitas
        case 'lapor_fasilitas':
            include './pages/lapor_fasilitas/index.php';
            break;
        case 'proses_lapor':
            include './pages/lapor_fasilitas/proses_lapor.php';
            break;
            // end of lapor fasilitas

            case 'notifikasi':
                include './pages/notifikasi/notifikasi.php';
                break;

        case 'logout':
            include './pages/logout/logout.php';
            break;
    }
} else {
    include './pages/beranda/beranda.php';
}