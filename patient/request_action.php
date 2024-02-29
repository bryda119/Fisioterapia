<?php
include('authentication.php');
include('../admin/config/dbconn.php');
include('payment_config.php');


date_default_timezone_set("America/Guayaquil");

if (isset($_POST['insertdata'])) {
    $services = '';
    $patient_name = $_SESSION['auth_user']['user_fname'];
    $patient_id = $_POST['userid'];
    $doctor_id = $_POST['preferredDentist'];
    $sched_id = $_POST['preferredDate'];
    $selectedTime = $_POST['preferredTime'];
    $preferredTime = explode("-", $selectedTime);
    $schedStart = $preferredTime[0];
    $schedEnd = $preferredTime[1];
    $service = $_POST['service'];
    foreach ($service as $selectedService) {
        $services .= $selectedService . ",";
    }
    $preferredServices = rtrim($services, ", ");
    $status = 'Pending';
    $schedtype = "Online Schedule";
    $subject = 'Request An Appointment';
    $date_submitted = date('Y-m-d H:i:s');

    $schedSQL = "SELECT * FROM schedule WHERE id='$sched_id'";
    $schedRes = mysqli_query($conn, $schedSQL);

    if (mysqli_num_rows($schedRes) > 0) {
        while ($schedRow = mysqli_fetch_assoc($schedRes)) {
            $schedDate = $schedRow['day'];
        }
    }

    $sql = "SELECT * FROM health_declaration WHERE patient_id = '$patient_id'";
    $query_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        $sql = "DELETE FROM health_declaration WHERE patient_id='$patient_id'";
        $query_run = mysqli_query($conn, $sql);
        foreach ($_POST as $key => $val) {
            if (substr($key, 0, 3) == 'ans') {
                $key = substr($key, 4);
                $sql2 = "INSERT INTO health_declaration (patient_id,question_id,answer) VALUES ('$patient_id','$key','$val') ";
                $query_run1 = mysqli_query($conn, $sql2);
            }
        }
    } else {
        foreach ($_POST as $key => $val) {
            if (substr($key, 0, 3) == 'ans') {
                $key = substr($key, 4);
                $sql2 = "INSERT INTO health_declaration (patient_id,question_id,answer) VALUES ('$patient_id','$key','$val') ";
                $query_run1 = mysqli_query($conn, $sql2);
            }
        }
    }

    $sql = "INSERT INTO tblappointment (patient_id,patient_name,doc_id,schedule,sched_id,starttime,endtime,reason,schedtype,status,payment_option,created_at)
        VALUES ('$patient_id','$patient_name','$doctor_id','$schedDate','$sched_id','$schedStart','$schedEnd','$preferredServices','$schedtype','$status','Agendada','$date_submitted')";
    $query_run = mysqli_query($conn, $sql);
    $last_id = mysqli_insert_id($conn);

    if ($query_run) {
        // Operaciones adicionales después de la inserción exitosa de la cita
        header('Location: index.php'); // Redirige a alguna página de confirmación o a donde sea necesario
    } else {
        $_SESSION['error'] = "Appointment Submission Failed";
        header('Location: index.php'); // Redirige a alguna página de error o a donde sea necesario
    }

    $sql = "INSERT INTO notification (patient_id,doc_id,subject,created_at) VALUES ('$patient_id','$doctor_id','$subject','$date_submitted')";
    $query_run = mysqli_query($conn, $sql);
}

if (isset($_POST['cancel-appointment'])) {
    $id = $_POST['app_id'];
    $sql = "UPDATE tblappointment SET status='Cancelled' WHERE id='$id'";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Appointment Cancelled Successfully";
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Appointment Failed to Cancelled";
        header('Location: index.php');
    }
}

if (isset($_GET['doctorIdDate'])) {
    $doc_id = $_GET['doctorIdDate'];
    $pat_id = $_GET['patientId'];
    $today = date("Y-m-d");

    $data = array();

    $sql = "SELECT * FROM schedule WHERE doc_id='$doc_id' AND day > CURDATE()";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $day = date('F d, Y', strtotime($row['day']));
            $startTime = strtotime($row['starttime']);
            $endTime = strtotime($row['endtime']);
            $duration = $row['duration'];

            $minuteDiff = round(abs($endTime - $startTime) / 60, 2);

            $getApptSql = "SELECT count(*) as numberOfappt FROM tblappointment WHERE doc_id='$doc_id' AND schedule='$day'";
            $getApptRes = mysqli_query($conn, $getApptSql);
            $getApptRow = mysqli_fetch_assoc($getApptRes);
            $numberOfAppt =  $getApptRow['numberOfappt'];

            if ($duration <= ($minuteDiff - ($numberOfAppt * 60))) {
                $chkApptSql = "SELECT count(*) as appt FROM tblappointment WHERE patient_id='$pat_id' AND schedule='$day' AND status!='Cancelled'";
                $chkApptRes = mysqli_query($conn, $chkApptSql);
                $chkApptRow = mysqli_fetch_assoc($chkApptRes);
                $appt =  $chkApptRow['appt'];
                $text = $day . " " . date('h:i A', $startTime) . " - " . date('h:i A', $endTime);
                if ($appt == 0) {
                    $data[] = array('id' => $id, 'text' => $day, 'info' => $duration);
                }
            }
        }
    } else {
        $data[] = array('id' => 0, 'text' => 'No dates found', 'disabled' => true);
    }

    echo json_encode($data);
}

if (isset($_POST['selectedDateId'])) {
    $schedId = $_POST['selectedDateId'];
    $today = date("Y-m-d");
    $conflict = 0;
    $previousEndTime = '';
    $lunchbreak = false;

    $data = array();

    $sql = "SELECT * FROM schedule WHERE id='$schedId'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $day = date('F d, Y', strtotime($row['day']));
            $startTime = $row['starttime'];
            $endTime = $row['endtime'];
            $duration = $row['duration'];

            $totalNoOfMins = round(abs(strtotime($endTime) - strtotime($startTime)) / 60, 2);

            $noOfAppt = ($totalNoOfMins - 60) / $duration;

            $currentStartTime = date('h:i A', strtotime($startTime));
            $currentEndTime = date('h:i A', strtotime($startTime . " " . $duration . " minutes"));

            do {
                $apptSQL = "SELECT * FROM tblappointment WHERE sched_id = '$schedId' AND starttime='$currentStartTime' AND endtime='$currentEndTime'";
                $apptResult = mysqli_query($conn, $apptSQL);
                if (mysqli_num_rows($apptResult) == 0) {

                    $timeSched = $currentStartTime . "-" . $currentEndTime;
                    if (date('H', strtotime($currentStartTime)) != 12) {
                        $data[] = array('id' => $timeSched, 'text' => $timeSched);
                    }
                }

                if (date('H', strtotime($currentEndTime)) == 12 && $lunchbreak == false) {
                    $currentStartTime = date('h:i A', strtotime($currentEndTime));
                    $currentEndTime = date('h:i A', strtotime($currentEndTime . " +60 minutes"));

                    $lunchbreak = true;
                } else {
                    $currentStartTime = date('h:i A', strtotime($currentEndTime));
                    $currentEndTime = date('h:i A', strtotime($currentEndTime . " +" . $duration . " minutes"));
                }

                $noOfAppt--;
            } while ($noOfAppt >= 1);
        }
    } else {
        $data[] = array('id' => 0, 'text' => 'No dates found', 'disabled' => true);
    }

    echo json_encode($data);
}
?>
