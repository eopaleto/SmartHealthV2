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
  $page = "My Profile";
  include 'auth/connect.php';
  include "part/head.php";

  // Check if the form is submitted
  if (isset($_POST['submit'])) {
    $id = $_POST['iduser'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alam = $_POST['alamat'];
    $new_pass = $_POST['new_password'];

    if (!empty($new_pass)) {
      $updateQuery = "UPDATE users SET nama_pasien='$nama', nik='$nik', password='$new_pass', alamat='$alam' WHERE id='$id'";
    } else {
      $updateQuery = "UPDATE users SET nama_pasien='$nama', nik='$nik', alamat='$alam' WHERE id='$id'";
    }

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
      echo '<script>
              setTimeout(function() {
                  swal({
                      title: "Data Diubah",
                      text: "Data berhasil diubah!",
                      icon: "success"
                  });
              }, 500);
            </script>';
    } else {
      echo '<script>
      setTimeout(function() {
          swal({
              title: "Gagal",
              text: "Data gagal diubah!",
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
          <div class="col-12">
            <div class="card mb-3" style="max-width: 640px;">
              <div class="row g-0">
                <div class="col-md-4">
                  <?php
                  $sessionid = $_SESSION['id_pasien'];
                  
                  $nama = mysqli_query($conn, "SELECT * FROM users WHERE id=$sessionid");
                  $output = mysqli_fetch_array($nama);
                  
                  $jenisKelamin = strtolower($output['jenis_kelamin']);
                  $avatarFile = ($jenisKelamin == 'perempuan') ? 'user-women.png' : 'user-man.png';
                  ?>
                  <img alt="image" src="assets/img/avatar/<?php echo $avatarFile; ?>" class="card-img">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <?php
                    $userId = isset($_SESSION['id_pasien']) ? $_SESSION['id_pasien'] : null;

                    $queryProfile = "SELECT * FROM users WHERE id = '$userId'";
                    $resultProfile = mysqli_query($conn, $queryProfile);

                    $profile = null;

                    if ($resultProfile) {
                      if (mysqli_num_rows($resultProfile) > 0) {
                        $profile = mysqli_fetch_assoc($resultProfile);

                        echo "<div class='d-flex justify-content-between'>";
                        echo "<h5 class='card-title'>" . $profile['nama_pasien'] . "</h5>";

                        echo "<span data-target='#editUser' data-toggle='modal' data-id='" . $profile['id'] . "' data-nama='" . $profile['nama_pasien'] . "' data-user='" . $profile['nik'] . "' data-alam='" . $profile['alamat'] . "'>";
                        echo "<a class='btn btn-primary btn-action mr-1' title='Edit' data-toggle='tooltip'><i class='fas fa-pencil-alt mr-2'></i> Edit Profile</a>";
                        echo "</span>";

                        echo "</div>";
                        echo "<p class='card-text'>Anda adalah seorang " . $profile['level'] . "</p>";
                        echo "<p class='card-text'><small class='text-body-secondary'>Member sejak " . date('d F Y', strtotime($profile['waktu'])) . "</small></p>";
                      } else {
                        echo "Data profil tidak ditemukan.";
                      }
                    } else {
                      echo "Error in query: " . mysqli_error($conn);
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Modal for Editing User Data -->
      <div class="modal fade" tabindex="-1" role="dialog" id="editUser">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" class="needs-validation" novalidate="">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="iduser" required="" id="getId">
                    <input type="text" class="form-control" name="nama" id="getNama" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">NIK</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nik" id="getUser" readonly>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control" required="" name="alamat" id="getAddrs"></textarea>
                </div>
                <div class="alert alert-light text-center">
                  Jika password tidak diganti, form dibawah dikosongi saja.
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Password Baru</label>
                  <div class="col-sm-9">
                    <input type="password" name="new_password" class="form-control">
                  </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit">Edit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END -->

      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
</body>

<script>
  $('#editUser').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var nama = button.data('nama')
    var user = button.data('user')
    var alam = button.data('alam')
    var id = button.data('id')
    var modal = $(this)
    modal.find('#getId').val(id)
    modal.find('#getNama').val(nama)
    modal.find('#getUser').val(user)
    modal.find('#getAddrs').val(alam)
  })
</script>

</html>
