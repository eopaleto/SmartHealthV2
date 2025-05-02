<?php
require 'auth/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pasien = $_POST['id_pasien'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Format the date for the file name
    $formatted_start = date('Ymd', strtotime($start_date));
    $formatted_end = date('Ymd', strtotime($end_date));

    // Tentukan nama file berdasarkan pilihan pasien
    if ($id_pasien == "ALL") {
        $file_name = "Rekam_Detak_Jantung_Semua_Pasien_{$formatted_start}_{$formatted_end}.csv";
        $query = "SELECT db_jantung.*, users.nama_pasien 
                  FROM db_jantung 
                  JOIN users ON db_jantung.id_pasien = users.id
                  WHERE db_jantung.Waktu BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    } else {
        $file_name = "Rekam_Detak_Jantung_{$formatted_start}_{$formatted_end}.csv";
        $query = "SELECT db_jantung.*, users.nama_pasien 
                  FROM db_jantung 
                  JOIN users ON db_jantung.id_pasien = users.id
                  WHERE db_jantung.id_pasien = '$id_pasien' 
                  AND db_jantung.Waktu BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    }

    $result = mysqli_query($conn, $query);

    // Set headers to download the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=\"$file_name\"");

    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Set CSV column headers
    fputcsv($output, array('Nama Pasien', 'ID Pasien', 'Detak Jantung (Bpm)', 'Saturasi Oksigen (%)', 'Kondisi Jantung', 'Waktu'));

    // Write data into CSV
    while ($data = mysqli_fetch_assoc($result)) {
        fputcsv($output, array($data['nama_pasien'], $data['id_pasien'], $data['DetakJantung'], $data['SaturasiOksigen'], $data['KondisiJantung'], $data['Waktu']));
    }

    fclose($output);
    exit;
}
