<?php
session_start();
include('includes/header.php');
include('admin/config/dbconn.php');
if (isset($_SESSION['auth'])) {
  if ($_SESSION['auth_role'] == "admin") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: admin/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "patient") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: patient/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "2") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: dentist/index.php');
    exit(0);
  } else if ($_SESSION['auth_role'] == "3") {
    $_SESSION['status'] = "You are already logged in";
    header('Location: staff/index.php');
    exit(0);
  }
}
?>


<body class="hold-transition register-page">
  <div class="py-3">
    <div class="container">
      <div class="row clearfix">
        <div class="col-md-12 col-md-offset-3 col-sm-6 col-sm-offset-3">
          <div class="card card-outline card-primary shadow" style="margin-top:50px;margin-bottom:50px;">
            <?php
            if (isset($_SESSION['auth_status'])) {
            ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['auth_status']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"></span>
                </button>
              </div>
            <?php
              unset($_SESSION['auth_status']);
            }
            ?>
            <div class="card-body register-card-body">
              <a href="index.php">
                <h3 class="login-box-msg text-danger font-weight-bold"><?= $system_name ?></h3>
              </a>
              <p class="login-box-msg">Registrar la Cuenta</p>
              <?php include('admin/message.php'); ?>
              <form action="register_action.php" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="fname" placeholder="Nombres" pattern="[a-zA-Z'-'\s]*" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="lname" placeholder="Apellidos" pattern="[a-zA-Z'-'\s]*" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group mb-3">
                      <input type="text" autocomplete="off" name="birthday" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-calendar"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <select class="custom-select mb-3" name="gender" required>
                      <option selected disabled value="">Genero</option>
                      <option>Mujer</option>
                      <option>Hombre</option>
                      <option>Otro</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col-sm-12 mb-3">
                    <input type="text" class="form-control" name="address" placeholder="Direccion" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-map-marker-alt"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="input-group col-sm-12 mb-3">
    <!-- Campo de selección para el código de país -->
    <select class="form-control" name="countryCode" required>
        <!-- Aquí puedes incluir opciones para diferentes códigos de país -->
        <option value="+593">+593 (Ecuador)</option>
        <option value="+44">+44 (Reino Unido)</option>
        <!-- Agrega más opciones según tus necesidades -->
    </select>

    <!-- Campo de entrada para el número de teléfono -->
    <input type="tel" autocomplete="off" class="form-control" pattern="\d{9,}" placeholder="Celular" name="phone" required>

    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-phone"></span>
        </div>
    </div>
</div>

                <div class="row">
                  <div class="input-group col-sm-12 mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col-sm-12">
                    <input type="password" class="form-control" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number and one uppercase and lowercase letter,at least one special character, and at least 8 or more characters" placeholder="Password" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="fas fa-eye" id="eye"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <p>Password Strength: <span id="result"> </span></p>
                    <div class="progress">
                      <div id="password-strength" class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      </div>
                    </div>
                    <ul class="list-unstyled">
                      <li class=""><span class="low-upper-case"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span>&nbsp; Contener minúsculas &amp; uppercase</li>
                      <li class=""><span class="one-number"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span> &nbsp;Contener Numers (0-9)</li>
                      <li class=""><span class="one-special-char"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span> &nbsp;Contener Caracteres especiales(!@#$%^&*).</li>
                      <li class=""><span class="eight-character"><i class="fal fa-exclamation-triangle" aria-hidden="true"></i></span>&nbsp; Al menos 8 caracteres</li>
                    </ul>
                  </div>
                </div>
                <div class="row">
                  <div class="input-group col-sm-12 mb-3">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6 mb-3">
                    <label for="">Profile Picture</label>
                    <input type="file" name="patient_image">
                  </div>
                  <div class="form-group col-sm-12">
                    <button type="submit" name="register_btn" id="register" class="btn btn-block btn-primary">Register</button>
                  </div>
                </div>
              </form>
              <a href="login.php" class="text-center">I already have an account</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('includes/scripts.php'); ?>
  <script>
    $('#password').keyup(function() {
      var password = $('#password').val();
      if (checkStrength(password) == false) {
        password.setCustomValidity('');

      }
    });

    function checkStrength(password) {
      var strength = 0;

      //If password contains both lower and uppercase characters, increase strength value.
      if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        strength += 1;
        $('.low-upper-case').addClass('text-success');
        $('.low-upper-case i').removeClass('fa-exclamation-triangle').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

      } else {
        $('.low-upper-case').removeClass('text-success');
        $('.low-upper-case i').addClass('fa-exclamation-triangle').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
      }

      //If it has numbers and characters, increase strength value.
      if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) {
        strength += 1;
        $('.one-number').addClass('text-success');
        $('.one-number i').removeClass('fa-exclamation-triangle').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

      } else {
        $('.one-number').removeClass('text-success');
        $('.one-number i').addClass('fa-exclamation-triangle').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
      }

      //If it has one special character, increase strength value.
      if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        strength += 1;
        $('.one-special-char').addClass('text-success');
        $('.one-special-char i').removeClass('fa-exclamation-triangle').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

      } else {
        $('.one-special-char').removeClass('text-success');
        $('.one-special-char i').addClass('fa-exclamation-triangle').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
      }

      if (password.length > 7) {
        strength += 1;
        $('.eight-character').addClass('text-success');
        $('.eight-character i').removeClass('fa-exclamation-triangle').addClass('fa-check');
        $('#popover-password-top').addClass('hide');

      } else {
        $('.eight-character').removeClass('text-success');
        $('.eight-character i').addClass('fa-exclamation-triangle').removeClass('fa-check');
        $('#popover-password-top').removeClass('hide');
      }

      // If value is less than 2

      if (strength < 2) {
        $('#result').removeClass()
        $('#password-strength').addClass('bg-danger');

        $('#result').addClass('text-danger').text('Very Weak');
        $('#password-strength').css('width', '10%');
      } else if (strength == 2) {
        $('#result').addClass('good');
        $('#password-strength').removeClass('bg-danger');
        $('#password-strength').addClass('bg-warning');
        $('#result').addClass('text-warning').text('Weak')
        $('#password-strength').css('width', '60%');
        return 'Weak'
      } else if (strength == 4) {
        $('#result').removeClass()
        $('#result').addClass('strong');
        $('#password-strength').removeClass('bg-warning');
        $('#password-strength').addClass('bg-success');
        $('#result').addClass('text-success').text('Very Strong');
        $('#password-strength').css('width', '100%');

        return 'Strong'
      }
    }
  </script>
  <script>
    $(document).ready(function() {
        $('#confirmPassword').keyup(function() {
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            if (password === confirmPassword) {
                $('#confirmPassword')[0].setCustomValidity('');
            } else {
                $('#confirmPassword')[0].setCustomValidity('Las contraseñas no coinciden');
            }
        });
    });
</script>
</body>

</html>