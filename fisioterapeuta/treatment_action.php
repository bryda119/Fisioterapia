
<?php
include('authentication.php');
include('../admin/config/dbconn.php');

date_default_timezone_set("Asia/Manila");

if (isset($_POST['checking_editbtn'])) {
    $s_id = $_POST['treatment_id'];
    $result_array = [];

    $sql = "SELECT * FROM treatment WHERE id='$s_id' ";
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

if (isset($_POST['update_treatment'])) {
    $id = $_POST['edit_id'];

    $patient_id = $_POST['selectpatient'];
    $doctor_id = $_POST['select_dentist'];
    $visit = $_POST['sched_id'];
    $teeth = $_POST['teeth'];
    $description = $_POST['description'];
    $treatment = $_POST['treatment'];
    $fees = $_POST['fees'];
    $remarks = $_POST['remarks'];
    $old_file = $_POST['old_file'];
    $file = $_FILES["uploadedFile"];

    $uploaded_file = '';
    if ($file["name"]) {
        $file_name = md5(time() . $file["name"]) . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'pdf'];
        if (in_array(pathinfo($file["name"], PATHINFO_EXTENSION), $allowed_extensions)) {
            $upload_dir = '../upload/documents/';
            if (move_uploaded_file($file["tmp_name"], $upload_dir . $file_name)) {
                $uploaded_file = $file_name;
            } else {
                $message = 'Error moving file to upload directory. Make sure the directory is writable.';
            }
        } else {
            $message = 'Upload failed. Allowed file types: ' . implode(',', $allowed_extensions);
        }
    } else {
        $uploaded_file = $old_file;
    }

    if (!$message) {
        $query = "UPDATE treatment SET patient_id=?,doc_id=?,visit=?,teeth=?,complaint=?,treatment=?,fees=?,file_name=?,uploaded_on=NOW(),remarks=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssi", $patient_id, $doctor_id, $visit, $teeth, $description, $treatment, $fees, $uploaded_file, $remarks, $id);
        if (mysqli_stmt_execute($stmt)) {
            if ($file["name"]) {
                unlink("../upload/documents/" . $old_file);
            }
            $_SESSION['success'] = "Treatment Updated Successfully";
        } else {
            $_SESSION['error'] = "Treatment Failed to Update";
        }
    } else {
        $_SESSION['error'] = $message;
    }
    header('Location:treatment.php');
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];

    $check_file_query = " SELECT * FROM treatment WHERE id='$id' LIMIT 1";
    $file_res = mysqli_query($conn, $check_file_query);
    $file_data = mysqli_fetch_array($file_res);
    $file = $file_data['file_name'];

    $sql = "DELETE FROM treatment WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if ($file != NULL) {
            if (file_exists('../upload/documents/' . $file)) {
                unlink("../upload/documents/" . $file);
            }
        }
        $_SESSION['success'] = "Treatment Deleted Successfully";
        header('Location:treatment.php');
    } else {
        $_SESSION['error'] = "Treatment Failed to Delete";
        header('Location:treatment.php');
    }
}

if (isset($_POST['user_id'])) {
    $sql = "SELECT * FROM tblappointment WHERE patient_id='" . $_POST["user_id"] . "' ORDER BY id DESC";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_array($query_run)) {
            $data["doc_id"] = $row["doc_id"];
            $data["visit"] = $row["schedule"];
            $data["treatment"] = $row["reason"];
        }
        echo json_encode($data);
    } else {
        echo 'No Record Found';
    }
}

?>
