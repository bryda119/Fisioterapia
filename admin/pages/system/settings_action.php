<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['system_details'])) {
    $name = $_POST['name'];
    $day = $_POST['day'];
    $opening_hours = $_POST['opening_hours'];
    $closing_hours = $_POST['closing_hours'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $facebook = $_POST['fblink'];
    $map = $_POST['map'];
    $days = implode(',', $day);

    $old_image = $_POST['old_image'];
    $image = $_FILES['img_url']['name'];

    $old_image_brand = $_POST['old_image_brand'];
    $image_brand = $_FILES['img_brand']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Subir archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_url']['size'] > 5000000)) {
            $_SESSION['error'] = "El tamaño del archivo supera los 5 MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    $update_brandname = "";
    if ($image_brand != null) {
        $image_extension = pathinfo($image_brand, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Subir archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_brand']['size'] > 5000000)) {
            $_SESSION['error'] = "El tamaño del archivo supera los 5 MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_brandname = $filename;
        }
    } else {
        $update_brandname = $old_image_brand;
    }
    if ($_SESSION['error'] == '') {
        $sql = "UPDATE system_details SET name='$name', days='$days', openhr='$opening_hours', closehr='$closing_hours', address='$address', telno='$telephone', email='$email', mobile='$mobile', facebook='$facebook', map='$map', logo='$update_filename', brand='$update_brandname' WHERE id='1'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../../upload/' . $old_image)) {
                    unlink("../../../upload/" . $old_image);
                }
                move_uploaded_file($_FILES['img_url']['tmp_name'], '../../../upload/' . $update_filename);
            }
            if ($image_brand != NULL) {
                if (file_exists('../../../upload/' . $old_image_brand)) {
                    unlink("../../../upload/" . $old_image_brand);
                }
                move_uploaded_file($_FILES['img_brand']['tmp_name'], '../../../upload/' . $update_brandname);
            }
            $_SESSION['success'] = "Configuración actualizada correctamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Error al actualizar la configuración";
            header('Location: index.php');
        }
    }
}
?>
