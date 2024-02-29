<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link notification" data-toggle="dropdown" href="#">
        <i class="fas fa-bell"></i>
        <span class="badge badge-danger navbar-badge count"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-notif">

      </div>
    </li>
    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <span><?php
              if (isset($_SESSION['auth'])) {
              ?>
            <img src="../upload/patients/<?= $user_image ?>" class="user-image img-circle elevation-2" alt="Doc Image">
            <span class="d-none d-md-inline">
              <?= $user_name ?>
              <input type="hidden" id="session_id" value="<?= $user_id ?>">
            </span>
          <?php } else {
                echo "Not Logged in";
              }

          ?>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item logoutbtn">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>