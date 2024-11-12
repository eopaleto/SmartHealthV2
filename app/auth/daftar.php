<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_pegawai']);
  $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

  $query_sql = "INSERT INTO pegawai (nama_pegawai, jenis_kelamin, username, password, alamat) VALUES ('$nama', '$jenis_kelamin', '$username', '$password', '$alamat')";

  $checkQuery = "SELECT * FROM pegawai WHERE nama_pegawai = '$nama' OR username = '$username'";
  $result = $conn->query($checkQuery);

  if ($result->num_rows > 0) {
    $message = 'Data sudah terdaftar. Silakan gunakan username atau nama lain.';
    echo '<script>
                setTimeout(function() {
                    swal({
                        title: "Maaf Akun mu belum berhasil didaftarkan",
                        text: "' . $message . '",
                        icon: "error"
                    });
                }, 500);
              </script>';
  } elseif (mysqli_query($conn, $query_sql)) {
    $message = 'Pendaftaran berhasil! Silakan login.';
    echo '<script>
                setTimeout(function() {
                    swal({
                        title: "Selamat! Akun mu berhasil didaftarkan",
                        text: "' . $message . '",
                        icon: "success"
                    }).then(function() {
                        // Redirect to login.php after clicking OK in the sweetalert
                        window.location.href = "index.php";
                    });
                }, 500);
              </script>';
  } else {
    echo "Pendaftaran Gagal : " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/stisla.svg" />
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <title>Rekam Medis - Daftar</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/modules/fontawesome/css/all.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Daftar</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="" autocomplete="off">

                  <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input id="nama_pegawai" type="nama" class="form-control" name="nama_pegawai" tabindex="1" placeholder="Masukan Nama Lengkap" required>
                    <div class="invalid-feedback">
                      Mohon isi Nama Lengkap anda dengan benar!
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required="" tabindex="2">
                      <option value="Laki-Laki" <?php echo (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-Laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                      <option value="Perempuan" <?php echo (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                    <div class="invalid-feedback">
                      Mohon memilih jenis kelamin!
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" class="form-control" minlength="2" name="username" tabindex="3" placeholder="Masukan Username" required autofocus>
                    <div class="invalid-feedback">
                      Mohon isi username anda dengan benar!
                    </div>
                  </div>

                  <div class="form-group password-container">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="4" placeholder="Masukan Password Anda" required>
                    <span class="show-password-btn" onclick="togglePassword()">
                      <i id="showPasswordIcon" class='bx bxs-hide show-password-icon'></i>
                    </span>
                    <div class="invalid-feedback">
                      Mohon isi password anda!
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" type="alamat" class="form-control" name="alamat" tabindex="5" placeholder="Masukan Alamat Tempat Tinggal Anda" required></textarea>
                    <div class="invalid-feedback">
                      Mohon isi Alamat anda dengan benar!
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" tabindex="6">
                      Daftar
                    </button>
                  </div>
                  <div class="text-center">
                    Sudah punya akun? <a href="index.php">Login disini</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </section>
  </div>

  <style>
    .password-container {
      position: relative;
    }

    .show-password-btn {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(25%);
      cursor: pointer;
    }

    .show-password-btn:hover {
      color: #007bff;
    }
  </style>

  <script>
    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var showPasswordIcon = document.getElementById("showPasswordIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showPasswordIcon.classList.remove('bxs-hide');
        showPasswordIcon.classList.add('bx-show');
      } else {
        passwordInput.type = "password";
        showPasswordIcon.classList.remove('bx-show');
        showPasswordIcon.classList.add('bxs-hide');
      }
    }
  </script>

  <script src="../assets/modules/jquery.min.js"></script>
  <script src="../assets/modules/popper.js"></script>
  <script src="../assets/modules/tooltip.js"></script>
  <script src="../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../assets/modules/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
  <!-- Sweet Alert -->
  <script src="../assets/modules/sweetalert/sweetalert.min.js"></script>
  <script src="../assets/js/page/modules-sweetalert.js"></script>

</body>

</html>