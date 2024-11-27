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
	$page1 = "kamar";
	$page = "Status Kamar";
	include 'auth/connect.php';
	include "part/head.php";
	include "part_func/tgl_ind.php";

	if (isset($_POST['submit'])) {
		$id = $_POST['id'];
		$nama = $_POST['nama'];
		$stat = $_POST['status'];


		$up2 = mysqli_query($conn, "UPDATE kamar SET nama_ruang='$nama', status='$stat' WHERE id_kamar='$id'");
		echo '<script>
				setTimeout(function() {
					swal({
					title: "Data Diubah",
					text: "Data Kamar berhasil diubah!",
					icon: "success"
					});
					}, 500);
				</script>';
	}

	if (isset($_POST['submit2'])) {
		$nama = $_POST['nama'];

		$cekuser = mysqli_query($conn, "SELECT * FROM kamar WHERE nama_ruang='$nama'");
		$baris = mysqli_num_rows($cekuser);
		if ($baris >= 1) {
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Nama Kamar sudah digunakan",
						text: "Nama Kamar sudah digunakan, gunakan nama lain!",
						icon: "error"
						});
					}, 500);
			</script>';
		} else {
			$add = mysqli_query($conn, "INSERT INTO kamar (nama_ruang, status) VALUES ('$nama', '0')");
			echo '<script>
				setTimeout(function() {
					swal({
						title: "Berhasil!",
						text: "Kamar baru telah ditambahkan!",
						icon: "success"
						});
					}, 500);
			</script>';
		}
	}

	if (isset($_POST['submit_pasien'])) {
		$id_pasien = $_POST['id_pasien'];
		$id_ruang = $_POST['id_ruang'];
	
		$cek_pasien = mysqli_query($conn, "SELECT * FROM kamar WHERE id_pasien='$id_pasien'");
		$pasien_exist = mysqli_num_rows($cek_pasien);
	
		if ($pasien_exist > 0) {
			echo '<script>
					setTimeout(function() {
						swal({
							title: "Gagal Menambahkan !",
							text: "Pasien sudah terdaftar di kamar lain.",
							icon: "error"
						});
					}, 500);
				  </script>';
		} else {
			$nama_ruang_result = mysqli_query($conn, "SELECT nama_ruang FROM kamar WHERE id_kamar='$id_ruang'");
			$nama_ruang_row = mysqli_fetch_assoc($nama_ruang_result);
			$nama_ruang = $nama_ruang_row['nama_ruang'];
	
			$update_ruang = mysqli_query($conn, "UPDATE kamar SET id_pasien='$id_pasien', tgl_masuk=NOW(), jam_masuk=NOW(), status='1' WHERE id_kamar='$id_ruang'");
			$insert_riwayat = mysqli_query($conn, "INSERT INTO riwayat_kamar (id_pasien, nama_ruangan, tgl_masuk, tgl_keluar) VALUES ('$id_pasien', '$nama_ruang', NOW(), NULL)");
		
			if ($update_ruang && $insert_riwayat) {
				echo '<script>
						setTimeout(function() {
							swal({
								title: "Berhasil!",
								text: "Pasien berhasil dimasukkan ke Kamar!",
								icon: "success"
							});
						}, 500);
					  </script>';
			} else {
				echo '<script>
						setTimeout(function() {
							swal({
								title: "Gagal!",
								text: "Terjadi kesalahan, silahkan coba lagi.",
								icon: "error"
							});
						}, 500);
					  </script>';
			}
		}
	}	

	if (isset($_GET['pasien_keluar'])) {
		$id_pasien = $_GET['id_pasien'];
		$id_ruang = $_GET['id_ruang'];
	
		$reset_ruang = mysqli_query($conn, "UPDATE kamar SET id_pasien=NULL, tgl_masuk=NULL, jam_masuk=NULL, status='0' WHERE id_kamar='$id_ruang'");
		$update_riwayat = mysqli_query($conn, "UPDATE riwayat_kamar SET tgl_keluar=NOW() WHERE id_pasien='$id_pasien'");
		
		if ($reset_ruang) {
			echo '<script>
					setTimeout(function() {
						swal({
							title: "Berhasil!",
							text: "Pasien berhasil keluar dari Kamar!",
							icon: "success"
						}).then(function() {
							window.location.href = window.location.pathname; // Reload the page
						});
					}, 500);
				  </script>';
		} else {
			echo '<script>
					setTimeout(function() {
						swal({
							title: "Gagal!",
							text: "Terjadi kesalahan, silahkan coba lagi.",
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
						<h1>Detail Kamar Kosong</h1>
					</div>
					<div class="section-body">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4><?php echo $page; ?></h4>
										<div class="card-header-action">
											<a href="#" class="btn btn-primary" data-target="#addUser" data-toggle="modal"><i class="fas fa-plus mr-2"></i>Tambah Kamar</a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-striped" id="table-1">
												<thead>
													<tr class="text-center">
														<th>#</th>
														<th>Nama Kamar</th>
														<th>Dipakai Sejak</th>
														<th>Dipakai Oleh</th>
														<th>Status</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sql = mysqli_query($conn, "SELECT * FROM kamar");
													$i = 0;
													while ($row = mysqli_fetch_array($sql)) {
														$defpasien = $row['id_pasien'];
														$i++;
													?>
														<tr class="text-center">
															<td><?php echo $i; ?></td>
															<th><?php echo ucwords($row['nama_ruang']); ?></th>
															<td><?php if ($row['tgl_masuk'] == "") {
																		echo 'Belum digunakan';
																	} else {
																		echo tgl_indo($row['tgl_masuk']);
																	} ?></td>
															<td><?php
																	if ($defpasien == '') {
																		echo 'Belum ada pasien';
																	} else {
																		$sqlnama = mysqli_query($conn, "SELECT * FROM users WHERE id='$defpasien'");
																		$namapasien = mysqli_fetch_array($sqlnama);
																		echo '<b>Sdr. ' . ucwords($namapasien["nama_pasien"]) . '</b>';
																	} ?></td>
															<td><?php
																	if ($row["status"] == "0") {
																		echo '<div class="badge badge-pill badge-success mb-1">';
																		echo '<i class="ion-checkmark-round"></i> Tersedia';
																	} elseif ($row["status"] == "1") {
																		echo '<div class="badge badge-pill badge-danger mb-1">';
																		echo '<i class="ion-close"></i> Dipakai';
																	} else {
																		echo '<div class="badge badge-pill badge-warning mb-1">';
																		echo '<i class="ion-gear-b"></i>  Dalam Perbaikan';
																	} ?>
										</div>
										</td>
										<td>
											<?php if ($row['status'] == '1') { ?>
												<span data-toggle="tooltip" title="Status masih dipakai, Data tidak dapat diedit">
													<a class="btn btn-primary disabled btn-action mr-1"><i class="fas fa-pencil-alt"></i></a>
												</span>
												<span data-toggle="tooltip" title="Status masih dipakai, Data tidak dapat dihapus">
													<a class="btn btn-danger disabled btn-action mr-1"><i class="fas fa-trash"></i></a>
												</span>
												<a data-toggle="tooltip" title="Konfirmasi pasien keluar" class="btn btn-warning btn-action mr-1" data-confirm="Pasien Keluar|Apakah benar pasien yang bernama <b><?php echo ucwords($namapasien["nama_pasien"]) ?></b> akan keluar?" data-confirm-yes="window.location.href='?pasien_keluar=true&id_pasien=<?php echo $defpasien; ?>&id_ruang=<?php echo $row['id_kamar']; ?>';"><i class="ion-log-out"></i></a>
												<?php } else { ?>
												<span data-target="#editRuang" data-toggle="modal" data-id="<?php echo $row['id_kamar']; ?>" data-nama="<?php echo $row['nama_ruang']; ?>">
													<a class="btn btn-primary btn-action mr-1" title="Edit" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></a>
												</span>
												<a class="btn btn-danger btn-action mr-1" data-toggle="tooltip" title="Hapus" data-confirm="Hapus Data|Apakah anda ingin menghapus data ini?" data-confirm-yes="window.location.href = 'auth/delete.php?type=kamar&id=<?php echo $row['id_kamar']; ?>'" ;><i class="fas fa-trash"></i></a>
												<span data-target="#selectPasien" data-toggle="modal" data-id="<?php echo $row['id_kamar']; ?>">
													<a data-toggle="tooltip" title="Pasien masuk" class="btn btn-success btn-action"><i class="ion-log-in"></i></a>
												</span>
											<?php } ?>
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

		<div class="modal fade" tabindex="-1" role="dialog" id="addUser">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Tambah Kamar</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="POST" class="needs-validation" novalidate="">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Nama Kamar</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="nama" required="">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
					</div>
					<div class="modal-footer bg-whitesmoke br">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="submit2">Tambah</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" tabindex="-1" role="dialog" id="editRuang">
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
								<label class="col-sm-3 col-form-label">Nama Kamar</label>
								<div class="col-sm-9">
									<input type="hidden" class="form-control" name="id" required="" id="getId">
									<input type="text" class="form-control" name="nama" required="" id="getNama">
									<div class="invalid-feedback">
										Mohon data diisi!
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Status Kamar</label>
								<select class="form-control selectric" name="status">
									<option value="">Terserdia</option>
									<option value="2">Dalam Perbaikan</option>
								</select>
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

		<div class="modal fade" tabindex="-1" role="dialog" id="selectPasien">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Pilih Pasien</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="POST" class="needs-validation" novalidate="">
							<div class="form-group">
								<label>Nama Pasien</label>
								<select class="form-control selectric" name="id_pasien" required="">
									<option value="">Pilih Pasien</option>
									<?php
									$sqlpasien = mysqli_query($conn, "SELECT * FROM users");
									
									$sqlKamar = mysqli_query($conn, "SELECT id_pasien FROM kamar");
									$pasienDiKamar = [];
									while ($rowKamar = mysqli_fetch_array($sqlKamar)) {
										$pasienDiKamar[] = $rowKamar['id_pasien'];
									}

									while ($rowpasien = mysqli_fetch_array($sqlpasien)) {
										$disabled = in_array($rowpasien['id'], $pasienDiKamar) ? 'disabled' : '';
										echo '<option class="text-dark" value="'.$rowpasien['id'].'" '.$disabled.'>'.ucwords($rowpasien['nama_pasien']).'</option>';
									}
									?>
								</select>
								<div class="invalid-feedback">
									Mohon pilih pasien!
								</div>
							</div>
							<input type="hidden" name="id_ruang" id="idRuang">
					</div>
					<div class="modal-footer bg-whitesmoke br">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="submit_pasien">Simpan</button>
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
		$('#editRuang').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var nama = button.data('nama')
			var id = button.data('id')
			var modal = $(this)
			modal.find('#getId').val(id)
			modal.find('#getNama').val(nama)
		})

		$('#selectPasien').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var id = button.data('id')
			var modal = $(this)
			modal.find('#idRuang').val(id)
		})
	</script>
</body>

</html>