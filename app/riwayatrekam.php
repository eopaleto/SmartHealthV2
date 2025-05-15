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
  $page = "Riwayat Rekam Detak Jantung";
  include 'auth/connect.php';
  include "part/head.php";
  include "part_func/tgl_ind.php";
  ?>
</head>

<style>
    .rounded-20 {
    border-radius: 20px;
  }
  
  .welcome-banner {
    background-color: #e7effd;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    cursor: pointer;
    align-items: center;
  }

  .welcome-banner:hover {
    transform: scale(1.02);
  }

  .welcome-image {
    margin: 0;
  }

  .welcome-text {
    font-size: 32px;
    font-weight: bold;
    color: #1f6de7;
    margin: 0;
  }

  .kamar-text {
    color: #66788A;
    margin-top: 10px;
    font-style: italic;
  }

  .welcome-subtext {
    color: #66788A;
    font-size: 16px;
    font-style: italic;
    margin-top: 5px;
  }
</style>

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
              <div class="col-lg-12">
                <div class="welcome-banner alert" role="alert">
                  <div class="row align-items-center">
                    <div class="col-md-3 col-12 text-center">
                      <img src="assets/img/background-welcome.png" alt="Welcome Image" class="img-fluid welcome-image">
                    </div>
                    <div class="col-md-8 col-12 text-center text-md-left">
                      <h1 class="welcome-text">Halaman Riwayat Rekam Detak Jantung, <?php echo strtoupper(ucwords($output['nama_pasien'])); ?></h1>
                      <p class="welcome-subtext">Smart Health V2</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><?php echo $page; ?></h4>
                    <div class="card-header-action">
                      <a href="#" class="btn btn-success" data-target="#csv" data-toggle="modal"><i class="fas fa-file-csv mr-2"></i>Download .csv</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th style="width: 10px;">#</th>
                            <th>Waktu</th>
                            <th>Detak Jantung (Bpm)</th>
                            <th>Saturasi Oksigen (%)</th>
                            <th>Kondisi Jantung</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sessionid = $_SESSION['id_pasien'];
                          
                          $result_pasien = mysqli_query($conn, "SELECT id FROM users WHERE id='$sessionid'");
                          $row_pasien = mysqli_fetch_assoc($result_pasien);
                          $id_pasien = $row_pasien['id'];
                          
                          $result_jantung = mysqli_query($conn, "SELECT * FROM db_jantung WHERE id_pasien='$id_pasien'");
                          
                          $i = 0;
                          while ($row_jantung = mysqli_fetch_array($result_jantung)) {
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i . '.'; ?></td>
                              <td><?php echo tgl_indo($row_jantung['Waktu']); ?></td>
                              <td><?php echo $row_jantung['DetakJantung']; ?></td>
                              <td><?php echo $row_jantung['SaturasiOksigen']; ?></td>
                              <td class="<?php 
                                  if ($row_jantung['KondisiJantung'] == 'Normal') {
                                      echo 'text-success font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'Tidak Normal') {
                                      echo 'text-danger font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'Kurang Normal') {
                                    echo 'text-warning font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'Tidak Diketahui') {
                                      echo 'text-grey font-weight-bold';
                                  } 
                              ?>">
                                  <?php echo $row_jantung['KondisiJantung']; ?>
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
          </div>
        </section>
      </div>

      <!-- Modal Download -->
      <div class="modal fade" id="csv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Download Data as .csv</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="export_csv.php" method="GET">
              <div class="modal-body">
                <label for="start_date">Mulai:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
                <label for="end_date" class="mt-2">Sampai:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Download</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php";?>
    
  <style>
    th {
      align-items: center;
      text-align: center;
    }

    td{
      align-items: center;
      text-align: center ;
    }
  </style>

</body>

</html>