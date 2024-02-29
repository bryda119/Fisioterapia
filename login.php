<?php
session_start();
include('includes/header.php');
include('admin/config/dbconn.php');
if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth_role'] == "admin") {
        $_SESSION['status'] = "You are already logged in";
        header('Location: admin/pages/dashboard');
        exit(0);
    } else if ($_SESSION['auth_role'] == "patient") {
        $_SESSION['status'] = "You are already logged in";
        header('Location: patient/index.php');
        exit(0);
    } else if ($_SESSION['auth_role'] == "2") {
        $_SESSION['status'] = "You are already logged in";
        header('Location: fisioterapeuta/index.php');
        exit(0);
    } else if ($_SESSION['auth_role'] == "3") {
        $_SESSION['status'] = "You are already logged in";
        header('Location: staff/index.php');
        exit(0);
    }
}
?>

<body class="hold-transition login-page">
    <div class="login-box">
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
        <!-- /.login-logo -->
        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body">
                <a href="index.php">
                    <h3 class="login-box-msg text-danger font-weight-bold"><?php echo $system_name ?></h3>
                </a>
                <p class="login-box-msg">Sign in</p>
                <?php
                include('admin/message.php');
                ?>
                <form action="logincode.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" required />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye" id="eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login_btn" class="btn btn-primary btn-block">Log In</button>
                    </div>
                </form>

                <p class="mb-1 ">
                    <a href="password-reset.php">Forgot password?</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Create Account</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    </div>
</body>

</html>
<?php include('includes/scripts.php'); ?>