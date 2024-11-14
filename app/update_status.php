<?php
include 'auth/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data POST `status_alat` dan `nama_ruang` tersedia
    if (!empty($_POST['status_alat']) && !empty($_POST['nama_ruang'])) {
        $statusAlat = $_POST['status_alat'];
        $namaRuang = $_POST['nama_ruang'];

        // Update status_alat dan otomatis memperbarui last_update
        $sql = "UPDATE kamar SET status_alat = ?, last_update = CURRENT_TIMESTAMP WHERE nama_ruang = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $statusAlat, $namaRuang);

            if ($stmt->execute()) {
                echo "Status updated successfully.";
            } else {
                echo "Error updating status.";
            }

            $stmt->close();
        } else {
            echo "Error preparing statement.";
        }
    } else {
        echo "Required data not provided. Update aborted.";
    }

    $conn->close();
} else {
    include 'errors-404.php';
}
