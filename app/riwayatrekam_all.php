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
  $page = "Riwayat Rekam Detak Jantung Semua Pasien";
  include 'auth/connect.php';
  include "part/head.php";
  include 'part_func/tgl_ind.php';
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
                    <h4><?php echo $page; ?></h4>
                    <div class="card-header-action">
                    </div>
                    <a href="#" class="btn btn-danger ml-2" data-target="#hapusdata" data-toggle="modal"><i class="fas fa-trash mr-2"></i>Hapus Data</a>
                    <a href="#" class="btn btn-success ml-2" data-target="#csvModal" data-toggle="modal"><i class="fas fa-file-csv mr-2"></i>Download .csv</a>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nama Pasien</th>
                            <th>ID Pasien</th>
                            <th>Detak Jantung (Bpm)</th>
                            <th>Saturasi Oksigen (%)</th>
                            <th>Kondisi Jantung</th>
                            <th>Waktu</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $result_jantung = mysqli_query($conn, "SELECT db_jantung.*, users.nama_pasien FROM db_jantung 
                                        JOIN users ON db_jantung.id_pasien = users.id");
                          
                          $i = 0;
                          while ($row_jantung = mysqli_fetch_array($result_jantung)) {
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i . '.'; ?></td>
                              <td><?php echo $row_jantung['nama_pasien']; ?></td>
                              <td><?php echo $row_jantung['id_pasien']; ?></td>
                              <td><?php echo $row_jantung['DetakJantung']; ?></td>
                              <td><?php echo $row_jantung['SaturasiOksigen']; ?></td>
                              <td class="<?php 
                                  if ($row_jantung['KondisiJantung'] == 'SEHAT') {
                                      echo 'text-success font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'TIDAK SEHAT') {
                                      echo 'text-danger font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'KURANG SEHAT') {
                                      echo 'text-warning font-weight-bold';
                                  } elseif ($row_jantung['KondisiJantung'] == 'TIDAK DIKETAHUI') {
                                      echo 'text-grey font-weight-bold';
                                  } 
                              ?>">
                                  <?php echo $row_jantung['KondisiJantung']; ?>
                              </td>
                              <td><?php echo tgl_indo($row_jantung['Waktu']); ?></td>
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

      <!-- Modal for CSV Export -->
      <div class="modal fade" id="csvModal" tabindex="-1" role="dialog" aria-labelledby="csvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="csvModalLabel">Download Data CSV</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="export_csv_admin.php">
              <div class="modal-body">
                <div class="form-group">
                  <label for="csvPasien">Pilih Pasien</label>
                  <select name="id_pasien" id="csvPasien" class="form-control selectric" required>
                    <option value="">Pilih Pasien</option>
                    <option value="ALL">Seluruh Pasien</option>
                    <?php
                    $result_pasien = mysqli_query($conn, "SELECT id, nama_pasien FROM users");
                    while ($row_pasien = mysqli_fetch_array($result_pasien)) {
                      echo "<option value='" . $row_pasien['id'] . "'>" . $row_pasien['nama_pasien'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="csvStartDate">Mulai Tanggal</label>
                  <input type="date" class="form-control" name="start_date" id="csvStartDate" required>
                </div>
                <div class="form-group">
                  <label for="csvEndDate">Sampai Tanggal</label>
                  <input type="date" class="form-control" name="end_date" id="csvEndDate" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Download .csv</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Hapus Data Pasien -->
      <div class="modal fade" id="hapusdata" tabindex="-1" role="dialog" aria-labelledby="hapusdataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="hapusdataLabel">Hapus Data Pasien</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- Form untuk hapus pasien -->
            <form method="POST" action="">
              <div class="modal-body">
                <div class="form-group">
                  <label for="id_pasien">Pilih Pasien</label>
                  <select name="id_pasien" id="id_pasien" class="form-control selectric" required>
                    <option value="">Pilih Pasien</option>
                    <?php
                    $result_pasien = mysqli_query($conn, "SELECT id, nama_pasien FROM users");
                    while ($row_pasien = mysqli_fetch_array($result_pasien)) {
                      echo "<option value='" . $row_pasien['id'] . "'>" . $row_pasien['nama_pasien'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-2"></i>Hapus Data</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php
      // Proses penghapusan data ketika form dikirim
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pasien'])) {
        $id_pasien = mysqli_real_escape_string($conn, $_POST['id_pasien']);
        $check_query = "SELECT * FROM db_jantung WHERE id_pasien = '$id_pasien'";
        $result_check = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result_check) > 0) {
          // Jika data pasien ditemukan, lanjutkan proses penghapusan
          $delete_query = "DELETE FROM db_jantung WHERE id_pasien = '$id_pasien'";

          if (mysqli_query($conn, $delete_query)) {
            echo '<script>
                setTimeout(function() {
                  swal({
                    title: "Berhasil!",
                    text: "Data pasien dengan ID ' . $id_pasien . ' berhasil dihapus.",
                    icon: "success"
                  }).then(() => {
                      location.reload();
                    });
                }, 500);
            </script>';
          } else {
            echo '<script>
                setTimeout(function() {
                  swal({
                    title: "Gagal!",
                    text: "Gagal menghapus data pasien dengan ID ' . $id_pasien . '!",
                    icon: "error"
                  });
                }, 500);
            </script>';
          }
        } else {
          echo '<script>
              setTimeout(function() {
                swal({
                  title: "Data Tidak Ditemukan!",
                  text: "Data pasien dengan ID ' . $id_pasien . ' tidak ditemukan.",
                  icon: "warning"
                });
              }, 500);
          </script>';
        }
      }
      ?>

      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
  
  <script>
    document.getElementById('confirmDelete').onclick = function () {
      var id_pasien = document.getElementById('id_pasien').value;
      if (id_pasien) {
        document.getElementById('deleteForm').submit();
      }
    }
  </script>

  <style>
    th {
      align-items: center;
      text-align: center;
    }

    td {
      align-items: center;
      text-align: center;
    }
  </style>

</body>
</html>
