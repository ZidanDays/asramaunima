<?php
include '../conf/conf.php';

if (isset($_GET['asrama_id'])) {
    $asrama_id = intval($_GET['asrama_id']);
    $query = $conn->prepare("SELECT id, nomor_kamar FROM kamar WHERE asrama_id = ? AND status = 'kosong' ORDER BY nomor_kamar ASC");
    $query->bind_param("i", $asrama_id);
    $query->execute();
    $result = $query->get_result();

    $kamars = [];
    while ($row = $result->fetch_assoc()) {
        $kamars[] = $row;
    }

    echo json_encode($kamars);
}
?>