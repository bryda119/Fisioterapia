<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_question'])) {
    $questions = $_POST['questions'];

    $sql = "INSERT INTO questionnaires (questions) VALUES ('$questions')";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Pregunta agregada exitosamente";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Error al agregar la pregunta";
        header('Location: index.php');
    }
}

if (isset($_POST['checking_question'])) {
    $s_id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM questionnaires WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        echo $return = "<h5>No se encontraron registros</h5>";
    }
}

if (isset($_POST['update_question'])) {
    $id = $_POST['edit_id'];
    $questions = $_POST['questions'];

    $sql = "UPDATE questionnaires SET questions='$questions' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Pregunta actualizada exitosamente";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Error al actualizar la pregunta";
        header('Location: index.php');
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM questionnaires WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Pregunta eliminada exitosamente";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Error al eliminar la pregunta";
        header('Location: index.php');
    }
}
?>
