<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_services'])) {
    $title = $_POST['title'];
    $art_title = $_POST['art_title'];
    $description = $_POST['description'];

    $files = $_FILES['files']['name'];

    if ($files != NULL) {
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        $image_extension = pathinfo($files, PATHINFO_EXTENSION);

        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Sube un archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['files']['size'] > 5000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede 5 MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            move_uploaded_file($_FILES['files']['tmp_name'], '../../../upload/service/' . $filename);
        }
    }
    if ($_SESSION['error'] == '') {
        $sql = "INSERT INTO services (title,article_title,description,image) VALUES ('$title','$art_title','$description','$filename')";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['success'] = "Servicio añadido correctamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Error al añadir servicio";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['checking_services'])) {
    $id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM services WHERE id='$id' ";
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

if (isset($_POST['update_services'])) {
    $id = $_POST['edit_id'];
    $title = $_POST['title'];
    $art_title = $_POST['art_title'];
    $description = $_POST['description'];
    $old_image = $_POST['old_image'];
    $image = $_FILES['files']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Sube un archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['files']['size'] > 10000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede 10 MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    if ($_SESSION['error'] == '') {
        $sql = "UPDATE services SET title='$title',article_title='$art_title',description='$description',image='$update_filename' WHERE id='$id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../../upload/service/' . $old_image)) {
                    unlink("../../../upload/service/" . $old_image);
                }
                move_uploaded_file($_FILES['files']['tmp_name'], '../../../upload/service/' . $update_filename);
            }
            $_SESSION['success'] = "Servicio actualizado correctamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Error al actualizar servicio";
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
            if (file_exists('../../../upload/service/' . $image)) {
                unlink("../../../upload/service/" . $image);
            }
        }
        $_SESSION['success'] = "Servicio eliminado correctamente";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Error al eliminar servicio";
        header('Location:index.php');
    }
}
?>
