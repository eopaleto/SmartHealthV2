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
  $page1 = "riwayatkamar";
  $page = "Riwayat Kamar Pasien";
  include 'auth/connect.php';
  include "part/head.php";
  include "part_func/tgl_ind.php";
  ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <?php
      include 'part/navbar.php';
      include 'part/sidebar.php';
      ?>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $page; ?></h1>
          </div>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th style="width: 10px;">#</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Nama Ruangan</th>
                            <th class="text-center">Tanggal Masuk</th>
                            <th class="text-center">Tanggal Keluar</th>
                            <th class="text-center">Waktu Rawat Inap</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM riwayat_kamar");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $defpasien = $row['id_pasien'];
                            $i++;
                          ?>
                            <tr>
                            <td><?php echo $i . '.'; ?></td>
                            <td class="text-center"><?php
                                  $sqlnama = mysqli_query($conn, "SELECT * FROM users WHERE id='$defpasien'");
                                  $namapasien = mysqli_fetch_array($sqlnama);
                                  echo '<b>Sdr. ' . ucwords($namapasien["nama_pasien"]) . '</b>';
                                  ?>
                              </td>
                              <td class="text-center"><?php echo($row['nama_ruangan']); ?></td>
                              <td class="text-center"><?php echo tgl_indo($row['tgl_masuk']); ?></td>
                              <td class="text-center"><?php echo tgl_indo($row['tgl_keluar']); ?></td>
                              <td class="text-center"><?php echo waktu_rawat_inap($row['tgl_masuk'], $row['tgl_keluar']); ?></td>
                              </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
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