<?php
  session_start();
  if (!isset($_SESSION['level'])) {
    header("Location: ../auth/");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $idnama = $_POST['id'];
  $page1 = "det";
  $page = "Detail Pasien : " . $idnama;
  include 'auth/connect.php';
  include "part/head.php";

  $cek = mysqli_query($conn, "SELECT * FROM users WHERE nama_pasien='$idnama'");
  $pasien = mysqli_fetch_array($cek);
  $idid = $pasien['id'];
  ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <?php
      include 'part/navbar.php';
      include 'part/sidebar.php';
      include 'part_func/umur.php';
      include 'part_func/tgl_ind.php';
      ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Detail Pasien - <?php echo ucwords($idnama); ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="pasien.php">Data Pasien</a></div>
              <div class="breadcrumb-item">Detail Pasien : <?php echo ucwords($idnama); ?></div>
            </div>
          </div>

          <div class="section-body">
            <?php include 'part/info_pasien.php'; ?>

            <div class="section-body">
              <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="gallery">
                        <table class="table table-striped table-sm">
                          <tbody>
                            <tr>
                              <th scope="row">Nama Lengkap</th>
                              <td> : <?php echo ucwords($idnama); ?></td>
                            </tr>
                            <tr>
                              <th scope="row">NIK / No.KTP</th>
                              <td> : <?php echo ($pasien['nik']); ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Password Akun</th>
                              <td>: <?php echo $pasien['password']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tanggal Lahir</th>
                              <td> : <?php echo tgl_lahir($pasien['tgl_lahir']); ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tinggi Bandan</th>
                              <td> : <?php echo $pasien['tinggi_badan'] . " cm"; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Berat Badan</th>
                              <td> : <?php echo $pasien['berat_badan'] . " kg"; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Alamat</th>
                              <td> : <?php echo $pasien['alamat']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Status</th>
                              <td> : <?php
																if ($pasien['level'] == 'Administrator') {
																	echo '<div class="badge badge-pill badge-dark mb-1">Admin';
																} else {
																	echo '<div class="badge badge-pill badge-success mb-1">Pasien';
																} ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Catatan Rekam Detak Jantung Pasien</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table-1">
                          <thead>
                            <tr class="text-center">
                              <th style="width: 10px;">#</th>
                              <th>Waktu</th>
                              <th>Detak Jantung (Bpm)</th>
                              <th>Saturasi Oksigen (%)</th>
                              <th>Kondisi Jantung</th>
                            </tr>
                          </thead>
                            <tbody>
                            <?php

                            $result_jantung = mysqli_query($conn, "SELECT * FROM db_jantung WHERE id_pasien='$idid'");

                            $i = 0;
                            while ($data_jantung = mysqli_fetch_array($result_jantung)) {
                              $i++;
                            ?>
                              <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td class="text-center"><?php echo tgl_indo($data_jantung['Waktu']); ?></td>
                                <td class="text-center"><?php echo $data_jantung['DetakJantung']; ?></td>
                                <td class="text-center"><?php echo $data_jantung['SaturasiOksigen']; ?></td>
                                <td class="text-center <?php 
                                  if ($data_jantung['KondisiJantung'] == 'Normal') {
                                      echo 'text-success font-weight-bold';
                                  } elseif ($data_jantung['KondisiJantung'] == 'Tidak Normal') {
                                      echo 'text-danger font-weight-bold';
                                  } elseif ($data_jantung['KondisiJantung'] == 'Kurang Normal') {
                                      echo 'text-warning font-weight-bold';
                                  } elseif ($data_jantung['KondisiJantung'] == 'Tidak Diketahui') {
                                      echo 'text-grey font-weight-bold';
                                  } 
                                ?>">
                                    <?php echo $data_jantung['KondisiJantung']; ?>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        </section>
      </div>

      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
</body>
</html>