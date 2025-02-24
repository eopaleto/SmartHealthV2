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
            <h1>Settings</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Settings</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Overview</h2>
            <p class="section-lead">
              Organize and adjust all settings about this site.
            </p>

            <div class="row">
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-cog"></i>
                  </div>
                  <div class="card-body">
                    <h4>General</h4>
                    <p>General settings such as, site title, site description, address and so on.</p>
                    <a href="#" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-search"></i>
                  </div>
                  <div class="card-body">
                    <h4>SEO</h4>
                    <p>Search engine optimization settings, such as meta tags and social media.</p>
                    <a href="#" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div class="card-body">
                    <h4>Email</h4>
                    <p>Email SMTP settings, notifications and others related to email.</p>
                    <a href="#" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-power-off"></i>
                  </div>
                  <div class="card-body">
                    <h4>System</h4>
                    <p>PHP version settings, time zones and other environments.</p>
                    <a href="#" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-lock"></i>
                  </div>
                  <div class="card-body">
                    <h4>Security</h4>
                    <p>Security settings such as firewalls, server accounts and others.</p>
                    <a href="#" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-stopwatch"></i>
                  </div>
                  <div class="card-body">
                    <h4>Automation</h4>
                    <p>Settings about automation such as cron job, backup automation and so on.</p>
                    <a href="#" class="card-cta text-primary">Change Setting <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

      <?php include 'part/footer.php'; ?>
    </div>
  </div>
  <?php include "part/all-js.php"; ?>
</body>

</html>