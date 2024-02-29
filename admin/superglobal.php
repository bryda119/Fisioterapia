<?php

global $system_name, $system_logo, $address, $email, $mobile, $telno, $map, $brand, $facebook;
include('config/dbconn.php');
$sql = "SELECT * FROM system_details LIMIT 1";
$query_run = mysqli_query($conn, $sql);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        $system_name = $row['name'];
        $system_logo = $row['logo'];
        $address = $row['address'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $telno = $row['telno'];
        $map = $row['map'];
        $brand = $row['brand'];
        $facebook = $row['facebook'];
    }
}

global $mail_username, $mail_host, $mail_password, $mail_link, $mail_host, $mail_username, $mail_password;
$mail_link = 'https://pedc.online';

$sql = "SELECT * FROM mail_settings LIMIT 1";
$query_run = mysqli_query($conn, $sql);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        $mail_host = $row['host'];
        $mail_username = $row['username'];
        $mail_password = $row['password'];
    }
}
