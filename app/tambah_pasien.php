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
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <?php
  $page = "Rawat Jalan";
  include 'auth/connect.php';
  include "part/head.php";


  @$nama = $_POST['nama'];
  $cek = mysqli_query($conn, "SELECT * FROM users WHERE nama_pasien='$nama' OR id='$nama'");
  $cekrow = mysqli_num_rows($cek);
  $tokne = mysqli_fetch_array($cek);
  $tglnow = date('Y-m-d');

  if (isset($_POST['jalan1'])) {
    if ($cekrow == 0) {
      mysqli_query($conn, "INSERT INTO users (nama_pasien, nik, tgl_lahir, umur, jenis_kelamin, tinggi_badan, berat_badan) VALUES ('$nama', '0', '0', '0', '0','0', '0')");
      echo '<script> location.reload(); </script>';
    } else {
      echo '<script>
				setTimeout(function() {
					swal({
						title: "Pasien Telah Terdaftar!",
						text: "Pasien yang bernama ' . ucwords($tokne['nama_pasien']) . ' sudah terdaftar, silahkan lanjutkan ke menu selanjutnya",
						icon: "success"
						});
					}, 500);
			</script>';
    }
  }

  if (isset($_POST['jalan2'])) {
    $namamu = $_POST['nama'];
    $nik = $_POST['nik'];
    @$tgl = $_POST['tgl'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];
    $alam = $_POST['alamat'];
    
    if (!empty($tgl)) {
        $tanggal_lahir = new DateTime($tgl);
        $today = new DateTime();
        $umur = $today->diff($tanggal_lahir)->y;
        $umur = NULL;
    }

    $query = "UPDATE users SET nik='$nik', alamat='$alam', tgl_lahir='$tgl', umur='$umur', jenis_kelamin='$jenis_kelamin', berat_badan='$berat', tinggi_badan='$tinggi' WHERE nama_pasien='$namamu'";
    
    if (mysqli_query($conn, $query)) {
        echo '<script>
        setTimeout(function() {
            swal({
                title: "Informasi Umum Disimpan!",
                text: "Data Informasi Umum ' . ucwords($namamu) . ' telah tersimpan!.",
                icon: "success"
            });
        }, 500);
        </script>';
    } else {
        echo '<script>
        setTimeout(function() {
            swal({
                title: "Kesalahan!",
                text: "Data tidak dapat disimpan. Silakan coba lagi.",
                icon: "error"
            });
        }, 500);
        </script>';
    }
}

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
            <div class="row justify-content-center">
              <div class="col-12 col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Tambah Pasien Baru</h4>
                  </div>
                  <div class="card-body">
                    <div class="row mt-4">
                      <div class="col-12">
                        <div class="wizard-steps">


                          <!-- Label 1 -->

                          <div class="wizard-step wizard-step-active">
                            <div class="wizard-step-icon">
                              <i class="far fa-user"></i>
                            </div>
                            <div class="wizard-step-label">
                              Identitas Pasien
                            </div>
                          </div>

                          <!-- LABEL 2 -->

                          <div class="wizard-step <?php echo (isset($_POST['jalan1']) || isset($_POST['jalan2'])) ? "wizard-step-active" : ""; ?>">
                            <div class="wizard-step-icon">
                              <i class="fas fa-server"></i>
                            </div>
                            <div class="wizard-step-label">
                              Informasi Umum
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <form class="wizard-content mt-2 needs-validation" novalidate="" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="wizard-pane text-center <?php echo (isset($_POST['jalan1']) || isset($_POST['jalan2']) || isset($_POST['jalan3'])) ? "wizard-step-active" : ""; ?>">
                      <?php if (empty($_POST)) { ?>

                        <!-- PART 1 -->

                        <div class="form-group row align-items-center">
                          <label class="col-md-4 text-md-right text-left">Nama Lengkap / ID</label>
                          <div class="col-lg-4 col-md-6">
                            <input id="myInput" type="text" class="form-control" required="" name="nama" placeholder="Nama / ID Calon Pasien">
                            <div class="invalid-feedback">
                              Mohon isi Nama Lengkap!
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4"></div>
                          <div class="col-lg-4 col-md-6 text-center">
                            <button class="btn btn-icon icon-center btn-primary" title="Selanjutnya" data-toggle="tooltip" name="jalan1">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                          </div>
                        </div>
                      <?php }
                      if (isset($_POST['jalan1'])) { ?>

                        <!-- PART 2 -->

                        <div class="form-group row align-items-center">
                          <label class="col-md-4 text-md-right text-left">Nama Lengkap</label>
                          <div class="col-lg-4 col-md-6">
                            <input type="hidden" name="nama" class="form-control" required="" value="<?php echo $tokne['nama_pasien']; ?>">
                            <input type="text" class="form-control" required="" value="<?php echo $tokne['nama_pasien']; ?>" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left">Nik / No.KTP</label>
                          <div class="col-lg-4 col-md-6">
                            <input type="number" class="form-control" name="nik" required="" value="<?php echo $tokne['nik']; ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left">Tanggal lahir</label>
                          <div class="col-lg-4 col-md-6">
                            <input type="date" class="form-control" name="tgl" required="" value="<?php echo $tokne['tgl_lahir']; ?>">
                          </div>
                          <div class="invalid-feedback">
                              Mohon data diisi!
                            </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left col-form-label">Tinggi Badan</label>
                          <div class="input-group col-sm-6 col-lg-4">
                            <input type="number" class="form-control" name="tinggi" required="" value="<?php echo $tokne['tinggi_badan']; ?>">
                            <div class="invalid-feedback">
                              Mohon data diisi!
                            </div>
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                Cm
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left col-form-label">Jenis Kelamin</label>
                          <div class="col-sm-6 col-lg-4">
                            <select class="form-control" name="jenis_kelamin" required="">
                              <option value="Laki-Laki" <?php echo ($tokne['jenis_kelamin'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                              <option value="Perempuan" <?php echo ($tokne['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                              Mohon memilih jenis kelamin!
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left col-form-label">Berat Badan</label>
                          <div class="input-group col-sm-6 col-lg-4">
                            <input type="number" class="form-control" name="berat" required="" value="<?php echo $tokne['berat_badan']; ?>">
                            <div class="invalid-feedback">
                              Mohon data diisi!
                            </div>
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                Kg
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-4 text-md-right text-left">Alamat</label>
                          <div class="col-lg-4 col-md-6">
                            <textarea type="number" class="form-control" name="alamat" required=""><?php echo $tokne['alamat']; ?></textarea>
                            <div class="invalid-feedback">
                              Mohon data diisi!
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-md-4"></div>
                          <div class="col-lg-4 col-md-6 text-center">
                            <button class="btn btn-icon icon-center btn-primary" title="Selesai" data-toggle="tooltip" name="jalan2">Selesai <i class="fas fa-arrow-right"></i></button>
                          </div>
                        </div>
                      <?php }

                      if (isset($_POST['jalan2'])) { ?>

                        <!-- PART 3 -->

                        <div class="wizard-pane text-center mt-1" style="margin-bottom: 25px;">
                          <form method="POST">
                            <div class="btn-group">
                              <button type="button" class="btn btn-info" onclick="window.location.href='index.php'" title="Ke Menu Utama" data-toggle="tooltip"><i class="fas fa-arrow-left"></i> Ke Menu Utama</button>
                              <button type="submit" class="btn btn-primary" title="Tambah Pasien" formaction="tambah_pasien.php" data-toggle="tooltip"><i class="fas fa-plus"></i> Tambah Pasien</button>
                            </div>
                          </form>
                        </div>
                      <?php } ?>
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
  <?php include "part/all-js.php";
  include "part/autocomplete.php"; ?>
</body>

</html>