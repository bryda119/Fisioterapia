<aside class="main-sidebar sidebar-dark-primary elevation-3">

  <a href="../../../index.php" class="brand-link">
    <img src="../../../upload/<?= $system_logo ?>" alt="image" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-normal text-lg text-light"><?= $system_name ?></span>
  </a>
  <?php $page = basename(dirname($_SERVER['PHP_SELF'])); ?>
  <div class="sidebar">
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="../dashboard" class="nav-link <?= $page == 'dashboard' ? 'active' : '' ?>">
            <i class="fa fa-home nav-icon"></i>
            <p>Tabla </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../admins" class="nav-link <?= $page == 'admins' ? 'active' : '' ?>">
            <i class="fas fa-user-shield nav-icon"></i>
            <p>Administrador </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../fisioterapeuta" class="nav-link <?= $page == 'dentists' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-md"></i>
            <p>Fisioterapeuta</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../staffs" class="nav-link <?= $page == 'staffs' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-nurse"></i>
            <p>Personal</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../patients" class="nav-link <?= $page == 'patients' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Paciente</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../schedules" class="nav-link <?= $page == 'schedules' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-clock"></i>
            <p>Horarios</p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'appointments' || $page == 'calendar' || $page == 'online-appointments' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'appointments' || $page == 'calendar' || $page == 'online-appointments' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
              Lista de citas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../appointments" class="nav-link <?= $page == 'appointments' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitud sin cita previa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../online-appointments" class="nav-link <?= $page == 'online-appointments' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Solicitud en línea</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../calendar" class="nav-link <?= $page == 'calendar' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Calendario de Citas</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../payments" class="nav-link <?= $page == 'payments' ? 'active' : '' ?>">
            <i class="nav-icon fab fa-cc-paypal"></i>
            <p>Pagos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../prescriptions" class="nav-link <?= $page == 'prescriptions' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-prescription"></i>
            <p>Receta</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../treated" class="nav-link <?= $page == 'treated'  ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-check"></i>
            <p>Pacientes Tratados</p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'highlight' || $page == 'about' || $page == 'services' || $page == 'mail' || $page == 'procedure-offers' || $page == 'sms' || $page == 'payment-settings' || $page == 'health-declaration' || $page == 'reviews' || $page == 'gallery' || $page == 'featured' || $page == 'system' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'highlight' || $page == 'about' || $page == 'services' || $page == 'mail' || $page == 'procedure-offers' || $page == 'sms' || $page ==  'payment-settings' || $page == 'health-declaration' || $page == 'reviews' || $page == 'gallery' || $page == 'featured' || $page == 'system' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>Sitio Web</p>
            <i class="fas fa-angle-left right "></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../highlight" class="nav-link <?= $page == 'highlight' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Contenido destacado</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../about" class="nav-link <?= $page == 'about' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Sobre nosotros</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../services" class="nav-link <?= $page == 'services' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Servicios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../procedure-offers" class="nav-link <?= $page == 'procedure-offers' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ofertas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../health-declaration" class="nav-link <?= $page == 'health-declaration' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Cuestionario</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../reviews" class="nav-link <?= $page == 'reviews' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Revisión</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../gallery" class="nav-link <?= $page == 'gallery' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Galeria</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../featured" class="nav-link <?= $page == 'featured' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Destacado</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../mail" class="nav-link <?= $page == 'mail' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Email Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../payment-settings" class="nav-link <?= $page == 'payment-settings' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Configuración de pago</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../sms" class="nav-link <?= $page == 'sms' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Configuración de SMS</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../system" class="nav-link <?= $page == 'system' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Configuración del sitio web</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../backup" class="nav-link <?= $page == 'backup' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-server"></i>
            <p>Base de datos de copia de seguridad</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../reports" class="nav-link <?= $page == 'reports' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-pdf "></i>
            <p>Reportes</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>