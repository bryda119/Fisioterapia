<?php
session_start();
include('admin/config/dbconn.php');
include('superglobal.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token, $mail_link, $mail_host, $mail_username, $mail_password)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_username;
    $mail->Password   = $mail_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($mail_username, $get_name);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject = 'Reset Password Notification';

    $email_template = "
            <h2> Hello </h2> 
            <h3> You are receiving this email because we received a password reset request for your account.</h3>
            <p>Please click below to reset your password</p>
            <a href='$mail_link/password-change.php?token=$token&email=$get_email'> Click Here </a>
            ";
    $mail->Body = $email_template;
    try {
        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];
        $get_status = $row['status'];

        $sql = "SELECT role FROM users WHERE email='$email' ";
        $query_run = mysqli_query($conn, $sql);
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $row) {
                $role = $row['role'];
            }
        }
        if ($role == 'admin') {
            $update_token = "UPDATE tbladmin SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn, $update_token);
        } else if ($role == '2') {
            $update_token = "UPDATE tbldoctor SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn, $update_token);
        } else if ($role == '3') {
            $update_token = "UPDATE tblstaff SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn, $update_token);
        } else if ($role == 'patient') {
            $update_token = "UPDATE tblpatient SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($conn, $update_token);
        }

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token, $mail_link, $mail_host, $mail_username, $mail_password);
            $_SESSION['info'] = "We emailed you a password reset link";
            header("Location:password-reset.php");
        } else {
            $_SESSION['error'] = "Something went wrong";
            header("Location:password-reset.php");
        }
    } else {
        $_SESSION['error'] = "No Email Found";
        header("Location:password-reset.php");
    }
}

if (isset($_POST['update_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password =   mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirm_password =  mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run)) {
                if ($new_password == $confirm_password) {
                    $hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $sql = "SELECT role FROM users WHERE email='$email' ";
                    $query_run = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                            $role = $row['role'];
                        }
                    }
                    if ($role == 'admin') {
                        $update_password = "UPDATE tbladmin SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == '2') {
                        $update_password = "UPDATE tbldoctor SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == '3') {
                        $update_password = "UPDATE tblstaff SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    } else if ($role == 'patient') {
                        $update_password = "UPDATE tblpatient SET password='$hash' WHERE verify_token='$token' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);
                    }

                    if ($update_password_run) {
                        $new_token = md5(rand()) . "feliztooth";

                        if ($role == 'admin') {
                            $update_to_new_token = "UPDATE tbladmin SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == '2') {
                            $update_to_new_token = "UPDATE tbldoctor SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == '3') {
                            $update_to_new_token = "UPDATE tblstaff SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        } else if ($role == 'patient') {
                            $update_to_new_token = "UPDATE tblpatient SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                            $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        }

                        $_SESSION['success'] = "Password has been changed";
                        header("Location:login.php");
                    } else {
                        $_SESSION['error'] = "Did not update password. Something went wrong!";
                        header("Location:password-change.php?token=$token&email=$email");
                    }
                } else {
                    $_SESSION['error'] = "Password and Confirm Password does not match";
                    header("Location:password-change.php?token=$token&email=$email");
                }
            } else {
                $_SESSION['error'] = "Invalid Token";
                header("Location:password-change.php?token=$token&email=$email");
            }
        } else {
            $_SESSION['error'] = "Please Complete All Fields";
            header("Location:password-change.php?token=$token&email=$email");
        }
    } else {
        $_SESSION['error'] = "No Token Available";
        header("Location:password-change.php");
    }
}
