<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Tabla</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Tabla</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <?php
          if (isset($_SESSION['status'])) {
          ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo $_SESSION['status']; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
              </button>
            </div>
          <?php
            unset($_SESSION['status']);
          }
          ?>
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php
                      $sql = "SELECT id FROM tblpatient ORDER BY id";
                      $query_run = mysqli_query($conn, $sql);

                      $row = mysqli_num_rows($query_run);
                      echo $row;
                      ?></h3>
                  <p>Pacientes</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-friends"></i>
                </div>
                <a href="../patients" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php
                      $sql = "SELECT id FROM tblappointment WHERE schedtype='Walk-in Schedule' ORDER BY id";
                      $query_run = mysqli_query($conn, $sql);

                      $row = mysqli_num_rows($query_run);
                      echo $row;
                      ?></h3>
                  <p>Citas Medicas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-calendar-check"></i>
                </div>
                <a href="../appointments" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php
                      $sql = "SELECT id FROM tblappointment WHERE schedtype='Online Schedule' ";
                      $query_run = mysqli_query($conn, $sql);

                      $row = mysqli_num_rows($query_run);
                      echo $row;
                      ?></h3>
                  <p>Citas Virtuales</p>
                </div>
                <div class="icon">
                  <i class="fas fa-globe"></i>
                </div>
                <a href="../online-appointments" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php
                      $sql = "SELECT id FROM prescription ORDER BY id";
                      $query_run = mysqli_query($conn, $sql);

                      $row = mysqli_num_rows($query_run);
                      echo $row;
                      ?>
                  </h3>
                  <p>Prescripciones</p>
                </div>
                <div class="icon">
                  <i class="fad fa-prescription"></i>
                </div>
                <a href="../prescriptions" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-gray color-palette">
                <div class="inner">
                  <h3><?php
                      $sql = "SELECT id FROM treatment ORDER BY id";
                      $query_run = mysqli_query($conn, $sql);

                      $row = mysqli_num_rows($query_run);
                      echo $row;
                      ?>
                  </h3>
                  <p>Paciente tratado</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-check"></i>
                </div>
                <a href="../treated" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('../../includes/scripts.php'); ?>
  <?php include('../../includes/footer.php'); ?>