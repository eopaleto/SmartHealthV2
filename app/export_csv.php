<?php
session_start(); 

$sessionid = $_SESSION['id_pasien'];

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

include 'auth/connect.php';

$query = "SELECT * FROM db_jantung WHERE id_pasien = '$sessionid' AND Waktu BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($conn, $query);

$nama_pasien = "SELECT nama_pasien FROM users WHERE id = '$sessionid'";
$result_nama = mysqli_query($conn, $nama_pasien);
$row_nama = mysqli_fetch_assoc($result_nama);
$nama_pasien = $row_nama['nama_pasien'];

$filename = 'Rekam Detak Jantung - ' . $nama_pasien . date('- d-m-Y') . '.csv';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . $filename . '"');

$output = fopen('php://output', 'w');

// Menuliskan header CSV
fputcsv($output, array('No', 'Detak Jantung (Bpm)', 'Saturasi Oksigen (%)', 'Kondisi Jantung', 'Waktu'));

// Isi data
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array($i++, $row['DetakJantung'], $row['SaturasiOksigen'], $row['KondisiJantung'], $row['Waktu']));
}

fclose($output);
exit;
?>
