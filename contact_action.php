<?php
date_default_timezone_set("Asia/Manila");
include('superglobal.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["subject"]) && !empty($_POST["message"])) {

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $mail_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mail_username;
    $mail->Password   = $mail_password;

    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($_POST["email"], $_POST["name"]);
    $mail->addAddress($mail_username);
    $mail->addReplyTo($_POST["email"], $_POST["name"]);
    $mail->isHTML(true);
    $mail->Subject = 'Contact Form | ' . $_POST["subject"];
    $mail->Body = '<p>Name: ' . $_POST["name"] . '<br> 
                            Email: ' . $_POST["email"] . '<br>
                            Message: ' . $_POST["message"] . '</h3>';

    try {
        $mail->send();
        print "Thanks for contacting us. We'll get back soon to you";
    } catch (Exception $e) {
        print "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
$success = "";

if (isset($_POST['submit'])) {
    $results = '';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if ($success == '') {
        $data =  'Thanks';
        header('Location: contact-us.php');
    }
}
