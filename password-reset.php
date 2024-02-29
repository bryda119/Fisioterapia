<?php
session_start();
include('includes/header.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <?php
        if(isset($_SESSION['auth_status']))
        {
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['auth_status'];?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div> 
            <?php
            unset($_SESSION['auth_status']);
        }
        ?>
        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <?php
                include('admin/message.php');
                ?>
                <form action="password-reset-code.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="password_reset_link" class="btn btn-primary btn-block">Send Password Reset Link</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.php">Login</a>
                </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('includes/scripts.php'); ?>