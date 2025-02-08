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

        case 'logout':
            include './pages/logout/logout.php';
            break;
    }
} else {
    include './pages/beranda/index.php';
}