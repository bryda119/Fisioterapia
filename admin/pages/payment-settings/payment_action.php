<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['payment_details'])) {
    $email = $_POST['email'];
    $success = $_POST['success'];
    $cancel = $_POST['cancel'];
    $ipn = $_POST['ipn'];
    $fee = $_POST['fee'];

    $sql = "UPDATE payment_settings SET business_email='$email',success='$success',cancel='$cancel',ipn='$ipn',fee='$fee' WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if ($query_run) {
        $_SESSION['success'] = "Payment Settings Updated Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Payment Settings Failed to Update";
        header('Location:index.php');
    }
}
