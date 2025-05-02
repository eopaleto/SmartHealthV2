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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php
  $page = "Data Pasien";
  include 'auth/connect.php';
  include "part/head.php";
  include "part_func/tgl_ind.php";
  include "part_func/umur.php";

  if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];
    $tgl = $_POST['tgl'];

    $up2 = mysqli_query($conn, "UPDATE users SET nama_pasien='$nama', nik='$nik', tgl_lahir='$tgl', jenis_kelamin='$jenis_kelamin', berat_badan='$berat', tinggi_badan='$tinggi' WHERE id='$id'");
    echo '<script>
				setTimeout(function() {
					swal({
					title: "Data Diubah",
					text: "Data Pasien berhasil diubah!",
					icon: "success"
					});
					}, 500);
				</script>';
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
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Pasien yang telah terdaftar</h4>
                    <div class="card-header-action">
                      <a href="tambah_pasien.php" class="btn btn-primary"><i class="fas fa-user-plus mr-2"></i>Tambah Pasien baru</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Id Pasien</th>
                            <th class="text-center">Nik / No.KTP</th>
                            <th class="text-center">Tanggal Lahir</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Usia</th>
                            <th class="text-center">Waktu Pendaftaran</th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = mysqli_query($conn, "SELECT * FROM users");
                          $i = 0;
                          while ($row = mysqli_fetch_array($sql)) {
                            $idpasien = $row['id'];
                            $i++;
                          ?>
                            <tr>
                              <td><?php echo $i . '.'; ?></td>
                              <th class="text-center"><?php echo ucwords($row['nama_pasien']); ?></th>
                              <td class="text-center"><?php echo $row['id']; ?></td>
                              <td class="text-center"><?php echo $row['nik']; ?></td>
                              <td class="text-center"><?php echo tgl_lahir($row['tgl_lahir']); ?></td>
                              <td class="text-center"><?php echo isset($row['jenis_kelamin']) ? ucfirst($row['jenis_kelamin']) : "-"; ?></td>
                              <td class="text-center"><?php if ($row['tgl_lahir'] == "") {
                                    echo "-";
                                  } else {
                                    umur($row['tgl_lahir']);
                                  } ?></td>
                              <td class="text-center"><?php echo isset($row['waktu']) ? date('d-m-Y H:i', strtotime($row['waktu'])) : "-"; ?></td>
                              <td class="text-center">
                              <form method="POST" action="detail_pasien.php">
                                <span data-target="#editPasien" data-toggle="modal"
                                      data-id="<?php echo $idpasien; ?>"
                                      data-nama="<?php echo $row['nama_pasien']; ?>"
                                      data-nik="<?php echo $row['nik']; ?>"
                                      data-lahir="<?php echo $row['tgl_lahir']; ?>"
                                      data-jenis="<?php echo $row['jenis_kelamin']; ?>"
                                      data-berat="<?php echo $row['berat_badan']; ?>"
                                      data-tinggi="<?php echo $row['tinggi_badan']; ?>">
                                  <a class="btn btn-primary btn-action mr-1" title="Edit Data Pasien" data-toggle="tooltip">
                                    <i class="fas fa-pencil-alt"></i>
                                  </a>
                                </span>
                                <a href="auth/delete.php?type=users&id=<?php echo $row['id']; ?>" 
                                  class="btn btn-danger btn-action mr-1 delete-btn" 
                                  data-id="<?php echo $row['id']; ?>" 
                                  title="Hapus">
                                  <i class="fas fa-trash"></i>
                                </a>
                                <input type="hidden" name="id" value="<?php echo $row['nama_pasien']; ?>">
                                <button type="submit" class="btn btn-info btn-action mr-1" title="Detail Pasien" data-toggle="tooltip" name="submit">
                                  <i class="fas fa-info-circle"></i>
                                </button>
                              </form>
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

      <div class="modal fade" tabindex="-1" role="dialog" id="editPasien">
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
                  <label class="col-sm-3 col-form-label">Nama Pasien</label>
                  <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="id" required="" id="getId">
                    <input type="text" class="form-control" name="nama" required="" id="getNama">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nik / No.KTP</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="nik" required="" id="getNik">
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tanggal lahir</label>
                  <div class="form-group col-sm-9">
                    <input type="text" class="form-control datepicker" id="getTgl" name="tgl">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="jenis_kelamin" required="" id="getJenisKelamin">
                      <option value="Laki-laki">Laki-laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Berat Badan</label>
                  <div class="input-group col-sm-9">
                    <input type="number" class="form-control" name="berat" required="" id="getBerat">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Kg
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tinggi Badan</label>
                  <div class="col-sm-9 input-group">
                    <input type="number" class="form-control" name="tinggi" required="" id="getTinggi">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Cm
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Mohon data diisi!
                    </div>
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
      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>

  <script>
  document.addEventListener("click", function (event) {
      let button = event.target.closest(".delete-btn");

      if (button) {
          event.preventDefault();
          let deleteUrl = button.getAttribute("href");

          Swal.fire({
              title: "Hapus Data?",
              text: "Apakah Anda yakin ingin menghapus data ini?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Ya, Hapus!",
              cancelButtonText: "Batal"
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = deleteUrl;
              }
          });
      }
  });
</script>

  <script>
    $('#editPasien').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var nama = button.data('nama');
      var nik = button.data('nik');
      var tgl = button.data('lahir');
      var jenisKelamin = button.data('jenis');
      var berat = button.data('berat');
      var tinggi = button.data('tinggi');

      var modal = $(this);
      modal.find('#getId').val(id);
      modal.find('#getNama').val(nama);
      modal.find('#getNik').val(nik);
      modal.find('#getTgl').val(tgl);
      modal.find('#getJenisKelamin').val(jenisKelamin);
      modal.find('#getBerat').val(berat);
      modal.find('#getTinggi').val(tinggi);
    });
  </script>

</body>

</html>