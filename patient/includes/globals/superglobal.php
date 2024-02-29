<?php


global $system_name;
global $system_logo;
global $user_image;
global $user_name;
global $user_id;


include('../admin/config/dbconn.php');
$sql = "SELECT * FROM system_details";
$query_run = mysqli_query($conn, $sql);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        $system_name = $row['name'];
        $system_logo = $row['logo'];
    }
}

$sql = "SELECT * FROM tblpatient WHERE id = '" . $_SESSION['auth_user']['user_id'] . "'";
$query_run = mysqli_query($conn, $sql);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        $user_id = $row['id'];
        $user_image = $row['image'];
        $user_name = $row['fname'] . ' ' . $row['lname'];
    }
}
