<?php
include 'auth/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_ruang = $_POST['nama_ruang']; 
    $DetakJantung = $_POST['DetakJantung'];
    $SaturasiOksigen = $_POST['SaturasiOksigen'];

    if (!empty($nama_ruang)) {
        
        $query_kamar = "SELECT id_pasien FROM kamar WHERE nama_ruang = ?";
        $stmt = $conn->prepare($query_kamar);
        $stmt->bind_param("s", $nama_ruang);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_pasien = $row['id_pasien'];

            $query_last_id = "SELECT MAX(id_jantung) AS last_id FROM db_jantung WHERE id_pasien = ?";
            $stmt_last_id = $conn->prepare($query_last_id);
            $stmt_last_id->bind_param("i", $id_pasien);
            $stmt_last_id->execute();
            $result_last_id = $stmt_last_id->get_result();
            
            $id_jantung = 1;

            if ($result_last_id->num_rows > 0) {
                $row_last_id = $result_last_id->fetch_assoc();
                if ($row_last_id['last_id'] !== null) {
                    $id_jantung = $row_last_id['last_id'] + 1;
                }
            }

            $query_insert = "INSERT INTO db_jantung (id_jantung, id_pasien, DetakJantung, SaturasiOksigen) 
                            VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($query_insert);
            $stmt_insert->bind_param("iiii", $id_jantung, $id_pasien, $DetakJantung, $SaturasiOksigen);

            if ($stmt_insert->execute()) {
                echo "Data berhasil disimpan untuk kamar $nama_ruang dan pasien ID $id_pasien .";
            } else {
                echo "Gagal menyimpan data: " . $stmt_insert->error;
            }

            $stmt_last_id->close();
        } else {
            echo "Kamar dengan nama $nama_ruang tidak ditemukan.";
        }
        $stmt->close();

    } else {
        echo "Data tidak lengkap, pastikan nama ruang terkirim.";
    }

} else {
    include 'errors-404.php';
}

$conn->close();
?>