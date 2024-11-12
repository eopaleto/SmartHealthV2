<?php
session_start();
include '../auth/connect.php';

if ($_SESSION['level'] == "Pasien") {
    $id_pasien = $_SESSION['id_pasien'];
    
    $query_jantung = "SELECT * FROM db_jantung WHERE id_pasien = '$id_pasien'";
    $result_jantung = mysqli_query($conn, $query_jantung);
    $data_jantung = [];
    
    while ($row = mysqli_fetch_assoc($result_jantung)) {
        $data_jantung[] = $row;
    }
    
    echo json_encode($data_jantung);
} else {
    echo json_encode([]);
}
?>
