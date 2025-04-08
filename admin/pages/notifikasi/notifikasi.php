<?php
// include '../conf/conf.php';
// // session_start();

// $user_id = $_SESSION['user_id'];

// // Ambil semua notifikasi user
// $query = "SELECT * FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC";
// $stmt = $conn->prepare($query);
// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();


include '../conf/conf.php';
// session_start();

$user_id = $_SESSION['user_id'];

// Update semua notifikasi yang belum dibaca menjadi sudah dibaca
$updateQuery = "UPDATE notifikasi SET status = 'dibaca' WHERE user_id = ? AND status = 'belum_dibaca'";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("i", $user_id);
$updateStmt->execute();

// Ambil semua notifikasi user
$query = "SELECT * FROM notifikasi WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<div class="main-panel">
    <div class="content-wrapper">
        <h2 class="mb-4">Semua Notifikasi</h2>

        <?php if ($result->num_rows > 0): ?>
        <div class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="list-group-item list-group-item-action flex-column align-items-start mb-2 shadow-sm">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        <i
                            class="mdi mdi-<?= htmlspecialchars($row['icon']) ?> text-<?= htmlspecialchars($row['warna']) ?>"></i>
                        <?= htmlspecialchars($row['judul']) ?>
                    </h5>
                    <small><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></small>
                </div>
                <p class="mb-1"><?= $row['pesan'] ?></p>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="alert alert-info">Belum ada notifikasi.</div>
        <?php endif; ?>
    </div>