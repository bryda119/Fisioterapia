<?php
session_start();
include('../admin/config/dbconn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

date_default_timezone_set("America/Guayaquil");

if (isset($_POST['logout_btn'])) {
    session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);

    $_SESSION['status'] = "Cerró sesión exitosamente";
    header('Location: ../login.php');
    exit(0);
}

if (isset($_POST['userid'])) {
    $s_id = $_POST['userid'];

    $sql = "SELECT * FROM tblpatient WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="data-label"><?php echo $row['fname']; ?></p>
                        <label>Dirección</label>
                        <p class="data-label"><?php echo $row['address']; ?></p>
                        <label>Teléfono</label>
                        <p class="data-label"><?php echo $row['phone']; ?></p>
                    </div>
                </div>
                <div class="col-sm-6 auto">
                    <div class="form-group">
                        <label>Fecha de nacimiento</label>
                        <p class="data-label"><?php echo $row['dob']; ?></p>
                        <label>Género</label>
                        <p class="data-label"><?php echo $row['gender']; ?></p>
                        <label>Correo electrónico</label>
                        <p class="data-label"><?php echo $row['email']; ?></p>
                    </div>
                </div>
            </div>
<?php
        }
    } else {
        echo $return = "<h5> No se encontraron registros</h5>";
    }
}


if (isset($_POST['checking_editbtn'])) {
    $s_id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM tblpatient WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        echo $return = "<h5> No se encontraron registros</h5>";
    }
}

if (isset($_POST['updatedata'])) {
    $id = $_POST['edit_id'];
    $fname  = $_POST['fname'];
    $address = $_POST['address'];
    $dob = $_POST['birthday'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkemail = "SELECT email FROM tbladmin WHERE email='$email' 
        UNION ALL SELECT email FROM tblstaff WHERE email='$email'
        UNION ALL SELECT email FROM tblpatient WHERE email='$email' AND id !='$id'
        UNION ALL SELECT email FROM tbldoctor WHERE email='$email' ";
    $checkemail_run = mysqli_query($conn, $checkemail);

    if (mysqli_num_rows($checkemail_run) > 0) {
        $_SESSION['error'] = "El correo electrónico ya existe";
        header('Location:patients.php');
    } else {
        $sql = "UPDATE tblpatient set fname='$fname',address='$address',dob='$dob', gender='$gender', phone='$phone', email='$email', password='$password' WHERE id='$id' ";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['success'] = "Paciente actualizado exitosamente";
            header('Location:patients.php');
        } else {
            $_SESSION['error'] = "Error al actualizar el paciente";
        }
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM tblpatient WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Paciente eliminado exitosamente";
        header('Location:patients.php');
    } else {
        $_SESSION['error'] = "Error al eliminar el paciente";
    }
}
?>
