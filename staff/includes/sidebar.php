<aside class="main-sidebar sidebar-dark-primary elevation-3">
  <a href="../index.php" class="brand-link">
    <img src="../upload/<?= $system_logo ?>" alt="image" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-normal text-lg text-light"><?= $system_name ?></span>
  </a>
  <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
  <div class="sidebar">
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= $page == 'index.php' ? 'active' : '' ?>">
            <i class="fa fa-home nav-icon "></i>
            <p>Panel de Control </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="patients.php" class="nav-link <?= $page == 'patients.php' || $page == 'patient-details.php' ? 'active' : '' ?>">
            <i class="nav-icon fa fa-users-medical "></i>
            <p>Pacientes</p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'appointment.php' || $page == 'calendar.php' || $page == 'online-request.php' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'appointment.php' || $page == 'calendar.php' || $page == 'online-request.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar "></i>
            <p>
            Citas
              <i class="fas fa-angle-left right"></i>
              <?php
              $sql = "SELECT * FROM tblappointment WHERE status='Pending'";
              $query_run = mysqli_query($conn, $sql);
              $row = mysqli_num_rows($query_run);
              if ($row > 0) {
                echo '<span class="right badge badge-danger">New</span>';
              }
              ?>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="appointment.php" class="nav-link <?= $page == 'appointment.php' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitud de Consulta</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="online-request.php" class="nav-link <?= $page == 'online-request.php' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitud en Línea</p>
                <?php
                $sql = "SELECT * FROM tblappointment WHERE schedtype='Online Schedule' AND status='Pending'";
                $query_run = mysqli_query($conn, $sql);
                $row = mysqli_num_rows($query_run);
                if ($row > 0) {
                  echo '<span class="badge badge-warning right">' . $row . '</span>';
                }
                ?>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="payments.php" class="nav-link <?= $page == 'payments.php' ? 'active' : '' ?>">
            <i class="nav-icon fab fa-cc-paypal"></i>
            <p>Pagos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="reports.php" class="nav-link <?= $page == 'reports.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-pdf "></i>
            <p>Informes</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="profile.php" class="nav-link <?= $page == 'profile.php' ? 'active' : '' ?>">
            <i class="nav-icon fa fa-user-alt "></i>
            <p>Perfil</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>