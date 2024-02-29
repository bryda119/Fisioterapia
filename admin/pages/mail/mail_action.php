<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['mail_update'])) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE mail_settings SET host='$host',username='$username',password='$password' WHERE id='1'";
    $query_run = mysqli_query($conn, $sql);
    if ($query_run) {
        $_SESSION['success'] = "Configuración de correo actualizada exitosamente";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Error al actualizar la configuración de correo";
        header('Location:index.php');
    }
}
?>