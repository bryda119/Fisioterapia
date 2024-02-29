<?php
session_start();
include('admin/config/dbconn.php');
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token,verify_status FROM tblpatient WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if ($row['verify_status'] == "0") {
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE tblpatient SET verify_status='1' WHERE verify_token='$clicked_token' limit 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if ($update_query_run) {
                $_SESSION['success'] = "Account has been verified!";
                header("Location:login.php");
                exit(0);
            } else {
                $_SESSION['error'] = "Verification Failed";
                header("Location:login.php");
                exit(0);
            }
        } else {
            $_SESSION['info'] = "Email already verified. Please login to continue";
            header("Location:login.php");
            exit(0);
        }
    } else {
        $_SESSION['error'] = "This token does not exist";
        header("Location:login.php");
    }
} else {
    $_SESSION['error'] = "Not Allowed";
    header("Location:login.php");
}
