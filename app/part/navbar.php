<?php

$sessionid = $_SESSION['id_pasien'];

if (!isset($sessionid)) {
  header('location:auth');
}
$nama = mysqli_query($conn, "SELECT * FROM users WHERE id=$sessionid");
$output = mysqli_fetch_array($nama);

$jenisKelamin = strtolower($output['jenis_kelamin']);
$avatarFile = ($jenisKelamin == 'perempuan') ? 'user-women.png' : 'user-man.png';

$sql = "SELECT status_alat FROM kamar WHERE id_pasien = '$sessionid'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) == 0) {
  $status_text = "Anda tidak dikamar !";
} else {
  $row = mysqli_fetch_assoc($result);
  $status_alat = $row['status_alat'];

  if ($status_alat == 1) {
      $status_text = "Online";
      $status_class = "fas fa-circle text-success";
  } else {
      $status_text = "Offline";
      $status_class = "fas fa-circle text-danger";
  }
}
?>

<style>
  @media (max-width: 767.98px) {
    .status-text {
      display: none; 
    }
  }
  @media (min-width: 768px) { 
    .status-text {
      display: inline; 
    }
  }
</style>

<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    
  <?php if ($output["level"] == "Pasien") { ?>
    <li class="dropdown dropdown-list-toggle">
      <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle">
          <i class="fa-solid fa-heart-pulse mr-2"></i>
          <span class="text-center"> / <i class="<?php echo $status_class; ?> mr-1 ml-1" style="font-size: 12px;"></i><?php echo $status_text; ?></span>
      </a>
    </li>
  <?php } ?>

    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="assets/img/avatar/<?php echo $avatarFile; ?>" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, <?php echo ucwords($output['nama_pasien']); ?></div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">
          <?php
          if ($output["level"] == "Administrator") {
            echo '<i class="fas fa-circle text-dark"></i> Administrator';
          } else {
            echo '<i class="fas fa-circle text-success"></i> Pasien';
          }
          ?>
        </div>
        <div class="dropdown-title">Logged 5 Min Ago</div>
        <a href="myprofile.php" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
        <a href="#" class="dropdown-item has-icon">
          <i class="fas fa-bolt"></i> Activities
        </a>
        <a href="$" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> Setting
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" data-target="#ModalLogout" data-toggle="modal" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<div class="modal fade" tabindex="-1" role="dialog" id="ModalLogout">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda Yakin Ingin Logout?</p>
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="window.location.href = 'auth/logout.php';" class="btn btn-danger">Ya</button>
      </div>
    </div>
  </div>
</div>