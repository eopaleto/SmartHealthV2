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
  $page = "Dashboard";
  include 'auth/connect.php';
  include "part/head.php";
  include 'part_func/tgl_ind.php';

  $userLevel = $_SESSION['level'];
  $pasien = mysqli_query($conn, "SELECT * FROM users");
  $jumpasien = mysqli_num_rows($pasien);
  $kamar_kosong = mysqli_query($conn, "SELECT * FROM kamar WHERE id_pasien IS NULL");
  $jumkamarkosong = mysqli_num_rows($kamar_kosong);
  $admin = mysqli_query($conn, "SELECT * FROM users WHERE level='Administrator'");
  $jumlahadmin = mysqli_num_rows($admin);

  $nama_pasien_kamar = [];
  $nama_ruang_array = ['Melati', 'Mawar', 'Anggrek', 'Copere'];

  $nama_ruang_list = "'" . implode("', '", $nama_ruang_array) . "'";

  $query = "SELECT k.nama_ruang, u.nama_pasien 
            FROM kamar k 
            LEFT JOIN users u ON k.id_pasien = u.id 
            WHERE k.nama_ruang IN ($nama_ruang_list)";

  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $index = array_search($row['nama_ruang'], $nama_ruang_array);
    if ($index !== false) {
      $nama_pasien_kamar[$index] = $row['nama_pasien'] ?? "Tidak Ada Pasien";
    }
  }

  foreach ($nama_ruang_array as $index => $nama_ruang) {
    if (!isset($nama_pasien_kamar[$index])) {
      $nama_pasien_kamar[$index] = "Tidak Ada Pasien";
    }
  }
  ?>
</head>

<style>
    /* .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
      transform: scale(1.02);
      cursor: pointer;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  } */

  .sehat {
    color: lightgreen;
  }

  .tidak-sehat {
    color: lightcoral;
  }

  .kurang-sehat {
    color: #ffb347;
  }

  .detak-jantung {
    color: lightblue;
  }

  .saturasi-oksigen {
    color: lightgreen;
  }

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
    margin-left: 30px;
    margin-bottom: 10px;
  }

  .welcome-text {
    font-size: 32px;
    font-weight: bold;
    color: #1f6de7;
    margin: 0;
  }

  .welcome-subtext {
    color: #66788A;
    font-size: 16px;
    margin: 0;
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
            <h1>Dashboard</h1>
          </div>
      <?php if ($_SESSION['level'] == "Administrator") { ?>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Jumlah Pasien</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumpasien; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-bed"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Jumlah Kamar Kosong</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumkamarkosong; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                  <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Jumlah Admin</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $jumlahadmin; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        <div class="row">
        <!-- Grafik Kamar 1 -->
          <div class="col-xl-3 col-lg-2">
            <div class="card shadow mb-4 rounded-20">
              <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Kamar Melati</h6>
                  <?php include "part/filter_kamar1.php"; ?>
              </div>
              <div class="card-body">
                <div class="chart-bar">
                      <canvas id="ChartPasien1" width="200" height="200"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle detak-jantung"></i> Detak Jantung
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle saturasi-oksigen"></i> Saturasi Oksigen
                  </span>
                </div>
                <div class="mt-4 text-center small">
                  <span class="font-weight-bold">Nama Pasien: 
                    <strong class="<?php echo ($nama_pasien_kamar[0] === "Tidak Ada Pasien") ? 'text-danger' : 'text-warning'; ?>">
                        <?php echo $nama_pasien_kamar[0]; ?>
                    </strong>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Grafik Kamar 2 -->
          <div class="col-xl-3 col-lg-2">
            <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Kamar Mawar</h6>
                    <?php include "part/filter_kamar2.php"; ?>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="ChartPasien2" width="200" height="200"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle detak-jantung"></i> Detak Jantung
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle saturasi-oksigen"></i> Saturasi Oksigen
                        </span>
                    </div>
                    <div class="mt-4 text-center small">
                      <span class="font-weight-bold">Nama Pasien: 
                        <strong class="<?php echo ($nama_pasien_kamar[1] === "Tidak Ada Pasien") ? 'text-danger' : 'text-warning'; ?>">
                            <?php echo $nama_pasien_kamar[1]; ?>
                        </strong>
                      </span>
                    </div>
                </div>
            </div>
        </div>

          <!-- Grafik Kamar 3 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kamar Anggrek</h6>
                    <?php include "part/filter_kamar3.php"; ?>
                  </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPasien3" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle detak-jantung"></i> Detak Jantung
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle saturasi-oksigen"></i> Saturasi Oksigen
                    </span>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="font-weight-bold">Nama Pasien: 
                      <strong class="<?php echo ($nama_pasien_kamar[2] === "Tidak Ada Pasien") ? 'text-danger' : 'text-warning'; ?>">
                          <?php echo $nama_pasien_kamar[2]; ?>
                      </strong>
                    </span>
                  </div>
                </div>
              </div>
            </div>

          <!-- Grafik Kamar 4 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kamar Copere</h6>
                    <?php include "part/filter_kamar4.php"; ?>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPasien4" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle detak-jantung"></i> Detak Jantung
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle saturasi-oksigen"></i> Saturasi Oksigen
                    </span>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="font-weight-bold">Nama Pasien: 
                      <strong class="<?php echo ($nama_pasien_kamar[3] === "Tidak Ada Pasien") ? 'text-danger' : 'text-warning'; ?>">
                          <?php echo $nama_pasien_kamar[3]; ?>
                      </strong>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          
          <!-- Grafik Kondisi Kesehatan Kamar 1 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kondisi Kesehatan Kamar 1</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPiePasien1" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle sehat"></i> Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle kurang-sehat"></i> Kurang Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle tidak-sehat"></i> Tidak Sehat
                    </span>
                  </div>
                </div>
              </div>
          </div>

          <!-- Grafik Sehat Kamar 2 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kondisi Kesehatan Kamar 2</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPiePasien2" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle sehat"></i> Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle kurang-sehat"></i> Kurang Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle tidak-sehat"></i> Tidak Sehat
                    </span>
                  </div>
                </div>
              </div>
          </div>

          <!-- Grafik Sehat Kamar 3 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kondisi Kesehatan Kamar 3</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPiePasien3" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle sehat"></i> Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle kurang-sehat"></i> Kurang Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle tidak-sehat"></i> Tidak Sehat
                    </span>
                  </div>
                </div>
              </div>
          </div>

          <!-- Grafik Sehat Kamar 4 -->
          <div class="col-xl-3 col-lg-2">
              <div class="card shadow mb-4 rounded-20">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                  <h6 class="m-0 font-weight-bold text-primary">Grafik Kondisi Kesehatan Kamar 4</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                        <canvas id="ChartPiePasien4" width="200" height="200"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle sehat"></i> Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle kurang-sehat"></i> Kurang Sehat
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle tidak-sehat"></i> Tidak Sehat
                    </span>
                  </div>
                </div>
              </div>
          </div>

          <!-- Grafik Seluruh Pasien -->
          <div class="col-xl-12 col-lg-4">
              <div class="card shadow mb-4 rounded-20">
                  <div class="card-header py-3 d-flex justify-content-between align-items-center">
                      <h6 class="m-0 font-weight-bold text-primary">Grafik Seluruh Kamar</h6>
                        <?php include 'part/filter_all.php' ;?>
                  </div>
                  <div class="card-body">
                      <div class="chart-bar">
                          <canvas id="ChartJantungSemua" width="200" height="50"></canvas>
                      </div>
                      <div class="mt-4 text-center small">
                          <span class="mr-2">
                              <i class="fas fa-circle text-primary"></i> Kamar 1
                          </span>
                          <span class="mr-2">
                              <i class="fas fa-circle text-success"></i> Kamar 2
                          </span>
                          <span class="mr-2">
                              <i class="fas fa-circle text-danger"></i> Kamar 3
                          </span>
                          <span class="mr-2">
                              <i class="fas fa-circle text-black"></i> Kamar 4
                          </span>
                      </div>
                  </div>
              </div>
          </div>
        
        <!-- Pasien -->
        <?php } elseif ($_SESSION['level'] == "Pasien") { 
          $id_pasien = $_SESSION['id_pasien'];

          $query_kamar = "SELECT * FROM kamar WHERE id_pasien = '$id_pasien'";
          $result_kamar = mysqli_query($conn, $query_kamar);
          $data_kamar = mysqli_fetch_assoc($result_kamar);

          if ($data_kamar) {
              $query_jantung = "SELECT * FROM db_jantung WHERE id_pasien = '$id_pasien'";
              $result_jantung = mysqli_query($conn, $query_jantung);
              $data_jantung = [];
              while ($row = mysqli_fetch_assoc($result_jantung)) {
                  $data_jantung[] = $row;
              }
              $json_data_jantung = json_encode($data_jantung);
              $showChart = true;
          } else {
              $showChart = false;
              $json_data_jantung = json_encode([]);
          }       
        ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="welcome-banner alert" role="alert">
            <div class="row align-items-center">
                <img src="assets/img/background-welcome.png" alt="Welcome Image" width="250" class="img-fluid welcome-image">
              <div class="col-md-8 col-sm-12 text-center text-md-left">
                <h1 class="welcome-text">Halo <?php echo ucwords($output['nama_pasien']); ?></>, Selamat Datang!</h1>
                <p class="welcome-subtext">Smart Health v2</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Grafik Pasien -->
      <div class="row">
        <div class="col-xl-8 col-lg-2">
            <div class="card shadow mb-4 rounded-20">
              <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Detak Jantung Pasien</h6>
                  <?php  include 'part/filter.php';?>
              </div>
              <div class="card-body">
                <div class="chart-line">
                      <canvas id="ChartPasien" data-jantung='<?php echo $json_data_jantung; ?>' data-showchart='<?php echo $showChart ? 'true' : 'false'; ?>' width="100" height="42"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle detak-jantung"></i> Detak Jantung
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle saturasi-oksigen"></i> Saturasi Oksigen
                  </span>
                </div>
                <?php if ($data_kamar): ?>
                  <div class="mt-4 text-center small">
                    <span class="font-weight-bold">Anda Berada di kamar : 
                      <strong class="text-warning"><?php echo $data_kamar['nama_ruang']; ?></strong>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Grafik Sehat Pasien -->
          <div class="col-xl-4 col-lg-3">
            <div class="card shadow mb-4 rounded-20">
              <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kondisi Jantung Pasien</h6>
              </div>
              <div class="card-body">
                <div class="chart-pie">
                      <canvas id="ChartPiePasien" width="100" height="50"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle sehat"></i> Sehat
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle kurang-sehat"></i> Kurang Sehat
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle tidak-sehat"></i> Tidak Sehat
                  </span>
                </div>
              </div>
            </div>
          </div>
      </div>

          <?php } ?>
        </section>
      </div>
      <?php include 'part/footer.php'; ?>
    </div>
  </div>

  <?php include "part/all-js.php"; ?>
  <script src="GrafikPasien/ChartPasien.js"></script>
  <script src="GrafikPasien/ChartAllPasien.js"></script>
  <script src="GrafikPasien/Pasien.js"></script>

</body>
</html>