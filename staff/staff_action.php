<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');

    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['logout_btn']))
    {
        session_destroy();
        unset($_SESSION['auth']);
        unset($_SESSION['auth_role']);
        unset($_SESSION['auth_user']);

        $_SESSION['success'] = "Logged out successfully";
        header('Location: ../login.php');
        exit(0);
    }
