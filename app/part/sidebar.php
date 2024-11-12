<?php
$judul = "Smart Health";
$pecahjudul = explode(" ", $judul);
$acronym = "";

foreach ($pecahjudul as $w) {
  $acronym .= $w[0];
}
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php"><?php echo $judul; ?><sup>2.0</sup></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.php"><?php echo $acronym; ?><sup>2.0</sup></a>
        </div>

        <ul class="sidebar-menu">
            <li <?php echo ($page == "Dashboard") ? "class=active" : ""; ?>><a class="nav-link" href="index.php"><i class="fas fa-th-large"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Menu</li>

            <?php if ($_SESSION['level'] == "Administrator") { ?>

                <li <?php echo ($page == "Rawat Jalan") ? "class=active" : ""; ?>><a class="nav-link" href="tambah_pasien.php"><i class="fas fa-user-plus"></i> <span>Tambah Pasien</span></a></li>

                <li <?php echo ($page == "Data Pasien" || @$page1 == "det") ? "class=active" : ""; ?>><a class="nav-link" href="pasien.php"><i class="fas fa-hospital-user"></i> <span>Data Pasien</span></a></li>
                
                <li <?php echo ($page == "Riwayat Rekam Detak Jantung Semua Pasien") ? "class=active" : ""; ?>><a class="nav-link" href="riwayatrekam_all.php"><i class="fas fa-briefcase-medical"></i> <span>Semua Data Rekam</span></a></li>

                <li class="dropdown <?php echo ($page1 == "kamar" || $page1 == "riwayatkamar") ? "active" : ""; ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bed"></i> <span>Kamar</span></a>
                    <ul class="dropdown-menu">
                        <li <?php echo (@$page1 == "kamar") ? "class=active" : ""; ?>><a class="nav-link" href="kamar.php">Detail Kamar</a></li>
                        <li <?php echo (@$page1 == "riwayatkamar") ? "class=active" : ""; ?>><a class="nav-link" href="riwayat_kamar.php">Riwayat Kamar Pasien</a></li>
                    </ul>
                </li>

                <li <?php echo ($page == "My Profile" || @$page1 == "detrot") ? "class=active" : ""; ?>><a class="nav-link" href="myprofile.php"><i class="fas fa-cog"></i> <span>Setting</span></a></li>
                  
                <li class="menu-header">Menu Lainnya</li>
                <li><a class="nav-link" href="" data-target="#ModalLogout" data-toggle="modal" style="color: #ff0000;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>

    <?php } elseif ($_SESSION['level'] == "Pasien") { ?>

        <ul class="sidebar-menu">
        <li <?php echo ($page == "My Profile" || @$page1 == "detrot") ? "class=active" : ""; ?>><a class="nav-link" href="myprofile.php"><i class="fas fa-cog"></i> <span>Setting</span></a></li>
        <li <?php echo ($page == "Riwayat Rekam Detak Jantung") ? "class=active" : ""; ?>><a class="nav-link" href="riwayatrekam.php"><i class="fas fa-briefcase-medical"></i> <span>Riwayat Rekam</span></a></li>
            <li class="menu-header">Menu Lainnya</li>
            <li><a class="nav-link" href="" data-target="#ModalLogout" data-toggle="modal" style="color: #ff0000;"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>

    <?php } ?>

    </aside>
</div>