<?php
session_start();
include('admin/config/dbconn.php');
include('superglobal.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Manila");

function sendmail_verify($fname, $email, $verify_token, $system_name, $mail_link, $mail_host, $mail_username, $mail_password)
{
    // $mail->SMTPDebug = 2;	
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_username;
    $mail->Password   = $mail_password;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($mail_username, $fname);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email verification from ' . $system_name;

    $email_template = "	
            <h2> You have registered with $system_name </h2> 	
            <p> Please click the link below to verify your email address and complete the registration process.</p>	
            <p> You will be automatically redirected to sign in page.</p>	
            <p>Please click below to activate your account:</p>	
            <a href='$mail_link/verify_email.php?token=$verify_token'> Click Here </a>	
            ";
    $mail->Body = $email_template;
    try {
        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if (isset($_POST['register_btn'])) {
    $fname  = $_POST['fname'];
    $lname  = $_POST['lname'];
    $address = $_POST['address'];
    $dob = $_POST['birthday'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $regdate = date('Y-m-d H:i:s');
    $verify_token = md5(rand());

    $image = $_FILES['patient_image']['name'];

    if ($password == $confirmPassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $checkemail = "SELECT * FROM users WHERE email='$email'";
        $checkemail_run = mysqli_query($conn, $checkemail);

        if (mysqli_num_rows($checkemail_run) > 0) {
            $_SESSION['error'] = "Email Already Exist";
            header('Location:register.php');
        } else {
            if ($image != NULL) {
                $allowed_file_format = array('jpg', 'png', 'jpeg');

                $image_extension = pathinfo($image, PATHINFO_EXTENSION);


                if (!in_array($image_extension, $allowed_file_format)) {
                    $_SESSION['error'] = "Upload valid file. jpg, png";
                    header('Location:register.php');
                } else if (($_FILES['patient_image']['size'] > 5000000)) {
                    $_SESSION['error'] = "File size exceeds 5MB";
                    header('Location:register.php');
                } else {
                    $filename = time() . '.' . $image_extension;
                    move_uploaded_file($_FILES['patient_image']['tmp_name'], 'upload/patients/' . $filename);
                }
            } else {
                $character = $_POST["fname"][0];
                $path = time() . ".png";
                $imagecreate = imagecreate(200, 200);
                $red = rand(0, 255);
                $green = rand(0, 255);
                $blue = rand(0, 255);
                imagecolorallocate($imagecreate, 230, 230, 230);
                $textcolor = imagecolorallocate($imagecreate, $red, $green, $blue);
                imagettftext($imagecreate, 100, 0, 55, 150, $textcolor, 'admin/font/arial.ttf', $character);
                imagepng($imagecreate, 'upload/patients/' . $path);
                imagedestroy($imagecreate);
                $filename = $path;
            }

            if ($_SESSION['error'] == '') {
                $sql = "INSERT INTO tblpatient (fname,lname,address,dob,gender,phone,email,image,password,role,verify_token,created_at)
                    VALUES ('$fname','$lname','$address','$dob','$gender','$phone','$email','$filename','$hash','patient','$verify_token','$regdate')";
                $patient_query_run = mysqli_query($conn, $sql);
                if ($patient_query_run) {
                    sendmail_verify("$fname", "$email", "$verify_token", $system_name, $mail_link, $mail_host, $mail_username, $mail_password);
                    $_SESSION['info'] = "We've sent an email to <b>$email</b> please check your email and click the link to verify.";
                    header('Location:login.php');
                } else {
                    $_SESSION['warning'] = "Registration Failed";
                    header('Location:register.php');
                }
            }
        }
    } else {
        $_SESSION['error'] = "Password does not match";
        header('Location:register.php');
    }
}
