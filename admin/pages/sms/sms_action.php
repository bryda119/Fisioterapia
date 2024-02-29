<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['sms_update'])) {
    $sid = $_POST['sid'];
    $token = $_POST['token'];
    $sender = $_POST['sender'];

    $sql = "UPDATE sms_settings SET sid='$sid', token='$token', sender='$sender' WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if ($query_run) {
        $_SESSION['success'] = "Configuración de SMS actualizada correctamente";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Error al actualizar la configuración de SMS";
        header('Location:index.php');
    }
}
?>
