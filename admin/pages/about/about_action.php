<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['checking_about'])) {
    $id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM about LIMIT 1";
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

if (isset($_POST['update_about'])) {
    $id = $_POST['edit_id'];
    $art_title = $_POST['art_title'];
    $content = $_POST['content'];
    $old_image = $_POST['old_image'];
    $image = $_FILES['files']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Subir archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['files']['size'] > 10000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede 10MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    if ($_SESSION['error'] == '') {
        $sql = "UPDATE about SET title='$art_title',image='$update_filename',content='$content' WHERE id='$id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../../upload/' . $old_image)) {
                    unlink("../../../upload/" . $old_image);
                }
                move_uploaded_file($_FILES['files']['tmp_name'], '../../../upload/' . $filename);
            }
            $_SESSION['success'] = "Información de Acerca de Nosotros actualizada exitosamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "No se pudo actualizar la información de Acerca de Nosotros";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $del_image = $_POST['del_image'];

    $check_img_query = " SELECT * FROM services WHERE id='$id' LIMIT 1";
    $img_res = mysqli_query($conn, $check_img_query);
    $res_data = mysqli_fetch_array($img_res);
    $image = $res_data['image'];

    $sql = "DELETE FROM services WHERE id='$id' LIMIT 1";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if ($image != NULL) {
            if (file_exists('../../../upload/' . $image)) {
                unlink("../../../upload/" . $image);
            }
        }
        $_SESSION['success'] = "Servicio eliminado exitosamente";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Error al eliminar el servicio";
        header('Location:index.php');
    }
}

if (isset($_POST['update_header'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $image = $_FILES['files']['name'];
    $old_image = $_POST['old_image'];
    $file_extension = pathinfo($files, PATHINFO_EXTENSION);
    $filename = time() . '.' . $file_extension;

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Subir archivo válido. jpg, png";
            header('Location:../highlight');
        } else if (($_FILES['files']['size'] > 10000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede 10MB";
            header('Location:../highlight');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    if ($_SESSION['error'] == '') {

        $sql = "UPDATE header SET title='$title',content='$content',image='$update_filename' WHERE id='1' LIMIT 1";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../../upload/' . $old_image)) {
                    unlink("../../../upload/" . $old_image);
                }
            }
            move_uploaded_file($_FILES['files']['tmp_name'], '../../../upload/' . $update_filename);
            $_SESSION['success'] = "Contenido destacado actualizado exitosamente";
            header('Location: ../highlight');
        } else {
            $_SESSION['error'] = "Error al actualizar el contenido destacado";
            header('Location: ../highlight');
        }
    }
}
?>