<?php
session_start();
include('includes/header.php');
?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" class="h4"><b><?= $system_name ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                <?php
                include('admin/message.php');
                ?>
                <form action="password-reset-code.php" method="post">
                    <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])) {
                                                                            echo $_GET['token'];
                                                                        } ?>">
                    <div class="input-group mb-3">
                        <input type="email" name="email" value="<?php if (isset($_GET['email'])) {
                                                                    echo $_GET['email'];
                                                                } ?>" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="password" name="newPassword" id="password" class="form-control" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number and one uppercase and lowercase letter,at least one special character, and at least 8 or more characters" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row show_hide" style="display:none;">
                        <div class="col-md-12">
                            <small>Password Strength: <span id="result"> </span></small>
                        </div>
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="update_password" class="btn btn-primary btn-block">Change password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<?php include('includes/scripts.php'); ?>
<script>
    $('#password').keyup(function() {
        if ($(this).val().length == 0) {
            $('.show_hide').hide();
        } else {
            $('.show_hide').show();
        }
    }).keyup();

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