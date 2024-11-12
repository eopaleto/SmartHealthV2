<?php

include "../auth/connect.php";

$nama_ruang = array("Melati", "Mawar", "Anggrek", "Copere");

$data = array();

foreach ($nama_ruang as $ruang) {
    $sql_kamar = "SELECT id_pasien FROM kamar WHERE nama_ruang = ?";
    $stmt_kamar = $conn->prepare($sql_kamar);
    $stmt_kamar->bind_param("s", $ruang);
    $stmt_kamar->execute();
    $result_kamar = $stmt_kamar->get_result();

    if ($result_kamar->num_rows > 0) {
        while ($row_kamar = $result_kamar->fetch_assoc()) {
            $id_pasien = $row_kamar['id_pasien'];

            if (is_null($id_pasien)) {
                continue;
            }

            $sql_jantung = "SELECT id_pasien, Waktu, DetakJantung, SaturasiOksigen, KondisiJantung FROM db_jantung WHERE id_pasien = ?";
            $stmt_jantung = $conn->prepare($sql_jantung);
            $stmt_jantung->bind_param("i", $id_pasien);
            $stmt_jantung->execute();
            $result_jantung = $stmt_jantung->get_result();

            if ($result_jantung->num_rows > 0) {
                while ($row_jantung = $result_jantung->fetch_assoc()) {
                    $row_jantung['nama_ruang'] = $ruang;
                    $data[] = $row_jantung;
                }
            }
        }
    }
}

$conn->close();

if (empty($data)) {
    echo json_encode(["message" => "No data available."]);
} else {
    echo json_encode(value: $data);
}

?>
