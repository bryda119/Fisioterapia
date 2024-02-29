<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['insert_schedule'])) {
    $doc_id = $_POST['select_dentist'];
    $day = $_POST['select_day'];
    $s_time = $_POST['start_time'];
    $e_time = $_POST['end_time'];
    $duration = $_POST['select_duration'];

    $sql = "SELECT name FROM tbldoctor WHERE id = '$doc_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doc_name = $row['name'];
        }
    }

    $validate_sql = "SELECT * FROM schedule WHERE doc_id='$doc_id' AND day='$day'";
    $validate_result = mysqli_query($conn, $validate_sql);

    if (mysqli_num_rows($validate_result) > 0) {
        $_SESSION['error'] = "The doctor selected already have a schedule on that day";
        header('Location:index.php');
    } else {
        $sql = "INSERT INTO schedule (doc_id,doc_name,day,starttime,endtime,duration) VALUES ('$doc_id','$doc_name','$day','$s_time','$e_time','$duration')";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            $_SESSION['success'] = "Your schedule is successfully added.";
            header('Location:index.php');
        } else {
            $_SESSION['error'] = "Failed to add your schedule.";
            header('Location:index.php');
        }
    }
}

if (isset($_POST['checking_editbtn'])) {
    $s_id = $_POST['sched_id'];
    $result_array = [];

    $sql = "SELECT * FROM schedule WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    } else {
        echo $return = "<h5> No Record Found</h5>";
    }
}

if (isset($_POST['update_sched'])) {
    $id = $_POST['edit_id'];

    $day = $_POST['select_day'];
    $s_time = $_POST['start_time'];
    $e_time = $_POST['end_time'];
    $duration = $_POST['select_duration'];

    $sql = "UPDATE schedule set day='$day',starttime='$s_time',endtime='$e_time', duration='$duration' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Dentist Schedule Updated Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Dentist Schedule Failed to Update";
        header('Location:index.php');
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $sql = "DELETE FROM schedule WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Dentist Schedule Deleted Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Dentist Schedule Failed to Delete";
        header('Location:index.php');
    }
}
