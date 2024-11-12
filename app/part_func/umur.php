<?php
function umur($tgl_lahir){
  // Cek apakah tanggal lahir kosong atau tidak valid
  if (empty($tgl_lahir) || $tgl_lahir == '0000-00-00') {
      echo "-";
      return;
  }
  $lahir = new DateTime($tgl_lahir);
  $hari_ini = new DateTime();
    
  $diff = $hari_ini->diff($lahir);
    
  echo $diff->y ." Tahun";
  if($diff->m > 0){
  echo " ". $diff->m ." Bulan";
  }
  }
?>