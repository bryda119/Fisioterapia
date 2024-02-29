<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');
    
    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['add_prescription']))
    {
        $date = $_POST['date'];
        $patient = $_POST['select_patient'];
        $doctor = $_POST['select_doctor'];
        $medicine = $_POST['select_medicine'];
        $advice = $_POST['advice_note'];
        $dose = $_POST['dose'];
        $duration = $_POST['duration'];
        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO prescription (date,patient_id,doc_id,medicine,dose,duration,advice,created_at) VALUES ('$date','$patient','$doctor','$medicine','$dose','$duration','$advice','$created_at')";
        $query_run = mysqli_query($conn,$sql);

        if($query_run)
        {
            $_SESSION['success'] = "Prescription Added Successfully";
            header('Location:prescription.php');
        }
        else
        {
            $_SESSION['error'] = "Prescription Added Unsuccessfully";
            header('Location:prescription.php');
        }
    }

    if(isset($_POST['checking_prescription']))
    {
        $s_id = $_POST['user_id'];
        $result_array = [];

        $sql = "SELECT * FROM prescription WHERE id='$s_id' ";
        $query_run = mysqli_query($conn,$sql);

        if(mysqli_num_rows($query_run) > 0)
        {
            foreach($query_run as $row)
            {
               array_push($result_array, $row);              
            }
            header('Content-type: application/json');
            echo json_encode($result_array);
        }
        else{
            echo $return = "<h5> No Record Found</h5>";
        }
    }


    if(isset($_POST['update_prescription']))
    {
        $id = $_POST['edit_id'];
        $date = $_POST['date'];
        $patient_id = $_POST['select_patient'];
        $doctor_id = $_POST['select_doctor'];
        $medicine = $_POST['select_medicine'];
        $dose = $_POST['dose'];
        $duration = $_POST['duration'];
        $advice = $_POST['advice_note'];

        $sql = "UPDATE prescription set date='$date',patient_id='$patient_id',doc_id='$doctor_id',medicine='$medicine',dose='$dose',duration='$duration',advice='$advice' WHERE id='$id' ";
        $query_run = mysqli_query($conn,$sql);

        if($query_run)
        {
            $_SESSION['success'] = "Prescription Updated Successfully";
            header('Location:edit-prescription.php?id='.$id);
        }
        else
        {
            $_SESSION['error'] = "Prescription Updated Unsuccessfully";
            header('Location:edit-prescription.phpid='.$id);
        }
                
    }

    if(isset($_POST['deletedata']))
    {  
        $id = $_POST['delete_id'];
        
        $sql = "DELETE FROM prescription WHERE id='$id' ";
        $query_run = mysqli_query($conn,$sql);
        
        if ($query_run)
        {
            $_SESSION['success'] = "Prescription Deleted Successfully";
            header('Location:prescription.php');
        }
        else
        {
            $_SESSION['error'] = "Prescription Deleted Unsuccessfully";
            header('Location:prescription.php');
        }
    }

?>