<?php
  session_start();
  $page = "Error 404";
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
   <title>Smart Health | <?php echo $page; ?></title>
   <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/icon.png" />

   <!-- General CSS Files -->
   <link rel="stylesheet" href="../../assets/modules/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="../../assets/modules/fontawesome/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
   <link rel="stylesheet" href="../../assets/modules/ionicons/css/ionicons.min.css">
   <link rel="stylesheet" href="../../assets/modules/bootstrap-daterangepicker/daterangepicker.css">
   <link rel="stylesheet" href="../../assets/css/components.css">

   <!-- CSS Libraries -->
   <link rel="stylesheet" href="../../assets/modules/summernote/summernote-bs4.css">
   <link rel="stylesheet" href="../../assets/modules/jquery-selectric/selectric.css">
   <link rel="stylesheet" href="../../assets/modules/chocolat/dist/css/chocolat.css">
   <link rel="stylesheet" href="../../assets/modules/select2/dist/css/select2.min.css">

   <!-- Template CSS -->
   <link rel="stylesheet" href="../../assets/css/style.css">
   <link rel="stylesheet" href="../../assets/css/components.css">

   <link rel="stylesheet" href="../../assets/modules/datatables/datatables.min.css">
   <link rel="stylesheet" href="../../assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="../../assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

   <!-- Charts -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
   <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

   <style>
      /* btn yang mirip link */
      #btn-link {
         border: none;
         outline: none;
         background: none;
         cursor: pointer;
         padding: 0;
         font-family: inherit;
         font-size: inherit;
      }

      /*auto completenya dirawat jalan */
      .autocomplete {
         position: relative;
         display: inline-block;
      }
      .autocomplete-items {
         position: absolute;
         border: 1px solid;
         border-bottom: none;
         border-top: none;
         z-index: 99;
      }
      .autocomplete-items div {
         padding: 10px;
         cursor: pointer;
         border-bottom: 1px solid;
      }
   </style>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="page-error">
          <div class="page-inner">
            <h1>404</h1>
            <div class="page-description">
              Maaf, untuk saat ini halaman sedang dilakukan pengembangan.🙏🏻😄
            </div>
            <div class="page-search">
              <form>
                <div class="form-group floating-addon floating-addon-not-append">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">                          
                        <i class="fas fa-search"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-lg">
                        Search
                      </button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="mt-3">
                <a href="../">Back to Home</a>
              </div>
            </div>
          </div>
        </div>
        <div class="simple-footer mt-5">
          Copyright &copy; 2024 By | Smarth Health <sup>2.0</sup>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../../assets/modules/jquery.min.js"></script>
  <script src="../../assets/modules/popper.js"></script>
  <script src="../../assets/modules/tooltip.js"></script>
  <script src="../../assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../../assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../../assets/modules/moment.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>
</body>
</html>