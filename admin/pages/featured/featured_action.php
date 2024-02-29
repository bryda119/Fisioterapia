<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_dentist'])) {
    $dentist_name = $_POST['select_dentist'];
    $description = $_POST['description'];
    $img = $_FILES['img_profile']['name'];

    if ($img != null) {
        $image_extension = pathinfo($img, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Sube un archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_profile']['size'] > 2000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede los 2MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../assets/dist/img/featured-dentist/' . $filename);
        }
    }
    if ($_SESSION['error'] == '') {
        $sql = "INSERT INTO featured (dentist_id,description,image) VALUES ('$dentist_name','$description','$filename')";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['success'] = "Fisioterapeuta destacado agregado exitosamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Error al agregar el fisioterapeuta destacado";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['checking_featured'])) {
    $id = $_POST['dentist_id'];
    $result_array = [];

    $sql = "SELECT * FROM featured WHERE id='$id' ";
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

if (isset($_POST['update_dentist'])) {
    $id = $_POST['edit_id'];
    $dentist_name = $_POST['select_dentist'];
    $description = $_POST['description'];
    $old_image = $_POST['old_image'];
    $image = $_FILES['img_profile']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Sube un archivo válido. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_profile']['size'] > 2000000)) {
            $_SESSION['error'] = "El tamaño del archivo excede los 2MB";
            header('Location:index.php');
        } else {
            $filename = time() . '.' . $image_extension;
            $update_filename = $filename;
        }
    } else {
        $update_filename = $old_image;
    }
    if ($_SESSION['error'] == '') {
        $sql = "UPDATE featured SET dentist_id='$dentist_name',description='$description',image='$update_filename' WHERE id='$id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../assets/dist/img/featured-dentist/' . $old_image)) {
                    unlink("../assets/dist/img/featured-dentist/" . $old_image);
                }
                move_uploaded_file($_FILES['img_profile']['tmp_name'], '../../assets/dist/img/featured-dentist/' . $update_filename);
            }
            $_SESSION['success'] = "Fisioterapeuta destacado actualizado exitosamente";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Error al actualizar el fisioterapeuta destacado";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $del_image = $_POST['del_image'];

    $check_img_query = " SELECT * FROM featured WHERE id='$id' LIMIT 1";
    $img_res = mysqli_query($conn, $check_img_query);
    $res_data = mysqli_fetch_array($img_res);
    $image = $res_data['image'];

    $sql = "DELETE FROM featured WHERE id='$id' LIMIT 1";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if ($image != NULL) {
            if (file_exists('../../assets/dist/img/featured-dentist/' . $image)) {
                unlink("../../assets/dist/img/featured-dentist/" . $image);
            }
        }
        $_SESSION['success'] = "Fisioterapeuta destacado eliminado exitosamente";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Error al eliminar el fisioterapeuta destacado";
        header('Location:index.php');
    }
}
?>
