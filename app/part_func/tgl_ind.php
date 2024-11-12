<?php
    function tgl_lahir($tanggal){
        if (empty($tanggal) || $tanggal == '0000-00-00') {
            return "-";
        }
        
        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        
        $pecahkan = explode('-', $tanggal);
        
        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    function tgl_indo($tanggal){
        if (empty($tanggal) || $tanggal == '0000-00-00') {
            return "-";
        }

        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $timestamp = strtotime($tanggal);
        $tanggal_baru = date('d-m-Y H:i:s', $timestamp);
        $pecahkan_tanggal = explode('-', date('d-m-Y', $timestamp));
        $waktu = date('H:i:s', $timestamp);
        
        return $pecahkan_tanggal[0] . ' ' . $bulan[(int)$pecahkan_tanggal[1]] . ' ' . $pecahkan_tanggal[2] . ' ' . $waktu;
    }

    function waktu_rawat_inap($tgl_masuk, $tgl_keluar) {
        $masuk = new DateTime($tgl_masuk);
        
        if (empty($tgl_keluar)) {
            return "Pasien sedang dirawat...";
        }
        
        $keluar = new DateTime($tgl_keluar);
        $interval = $masuk->diff($keluar);
    
        $bulan = $interval->m;
        $hari = $interval->d;
        $jam = $interval->h;
        $menit = $interval->i;
        $detik = $interval->s;
    
        if ($interval->y > 0 || $bulan > 0) {
            return "$bulan bulan $hari hari $jam jam";
        } elseif ($hari > 0) {
            return "$hari hari $jam jam $menit menit";
        } else {
            return "$jam jam $menit menit $detik detik";
        }
    }
    
?>
