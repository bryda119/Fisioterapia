<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');

    date_default_timezone_set("Asia/Manila");

    if(isset($_POST['insertpatient']))
    {  
        $fname  = $_POST['fname'];
        $lname  = $_POST['lname'];
        $address = $_POST['address'];
        $dob = $_POST['birthday'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $role ='';
        $password = 'feliz123';
        $confirmPassword = 'feliz123';
        $verify_status ='';
        $regdate = date('Y-m-d H:i:s');

        $image = $_FILES['patient_image']['name'];
        
        if($password == $confirmPassword)
        {
            $hash = password_hash($password,PASSWORD_DEFAULT);
            $checkemail = "SELECT email FROM tbladmin WHERE email='$email' 
            UNION ALL SELECT email FROM tblstaff WHERE email='$email'
            UNION ALL SELECT email FROM tblpatient WHERE email='$email'
            UNION ALL SELECT email FROM tbldoctor WHERE email='$email' ";
            $checkemail_run = mysqli_query($conn, $checkemail);

            if(mysqli_num_rows($checkemail_run) > 0)
            {           
                $_SESSION['error'] = "Email Already Exist";
                header('Location:patients.php');
            }
            else
            {
                if($image!= NULL)
                {
                    $allowed_file_format = array('jpg', 'png','jpeg');

                    $image_extension = pathinfo($image, PATHINFO_EXTENSION);


                    if(!in_array($image_extension, $allowed_file_format))
                    {
                        $_SESSION['error'] = "Upload valid file. jpg, png";
                        header('Location:patients.php');
                    }
                    else if (($_FILES['patient_image']['size'] > 2000000))
                    {
                        $_SESSION['error'] = "File size exceeds 2MB";
                        header('Location:patients.php');
                    }
                    else
                    {
                        $filename = time().'.'.$image_extension;
                        move_uploaded_file($_FILES['patient_image']['tmp_name'], '../upload/patients/'.$filename);  
                    }
                }
                else
                {
                    $character = $_POST["fname"][0];
                    $path = time() . ".png";
                    $imagecreate = imagecreate(200, 200);
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);
                    imagecolorallocate($imagecreate, 230, 230, 230);  
                    $textcolor = imagecolorallocate($imagecreate, $red, $green, $blue);
                    imagettftext($imagecreate, 100, 0, 55, 150, $textcolor, '../admin/font/arial.ttf', $character);
                    imagepng($imagecreate, '../upload/patients/'.$path);
                    imagedestroy($imagecreate);
                    $filename = $path;
                }

                if($_SESSION['error'] == '')
                {
                    $sql = "INSERT INTO tblpatient (fname,lname,address,dob,gender,phone,email,image,password,role,verify_status,created_at)
                    VALUES ('$fname','$lname','$address','$dob','$gender','$phone','$email','$filename','$hash','patient','1','$regdate')";
                    $patient_query_run = mysqli_query($conn,$sql);
                    if ($patient_query_run)
                    {      
                        $_SESSION['success'] = "Adding Patient Successfully";
                        header('Location:patients.php');
                    }
                    else
                    {
                        $_SESSION['error'] = "Adding Patient Failed";
                        header('Location:patients.php');
                    }
                }                                
            }                      
        }
        else
        {
            $_SESSION['error'] = "Password does not match";
            header('Location:patients.php');
        }
         
    }

    if(isset($_POST['userid']))
    {
        $id = $_POST['userid'];
        //echo $return = $s_id;

        $sql = "SELECT * FROM tblpatient WHERE id='$id' ";
        $query_run = mysqli_query($conn,$sql);

        if(mysqli_num_rows($query_run) > 0)
        {
            foreach($query_run as $row)
            {
                ?>
                <div class="text-center">
                        <img src="../upload/patients/<?= $row['image']?>" class="img-thumbnail" width="120" alt="Doctor Image">                       
                    </div>
                <h3 class="profile-username text-center"><?php echo $row['fname'].' '.$row['lname']; ?></h3>
                <p class="text-muted text-center">Patient</p>
                <ul class="list-group list-group-unbordered mb-2">
                    <li class="list-group-item">
                        <b>Email</b> <p class="float-right text-muted"><?php echo $row['email']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <b>Phone</b> <p class="float-right text-muted"><?php echo $row['phone']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <b>Address</b> <p class="float-right text-muted"><?php echo $row['address']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <b>Birthday</b> <p class="float-right text-muted"><?php echo $row['dob']; ?></p>
                    </li>
                    <li class="list-group-item">
                        <b>Gender</b> <p class="float-right text-muted"><?php echo $row['gender']; ?></p>
                    </li>  
                </ul>                 
                   <?php
            }
        }
        else{
            echo $return = "<h5> No Record Found</h5>";
        }
    }
    
        
    if(isset($_POST['checking_editbtn']))
    {
        $id = $_POST['user_id'];
        $result_array = [];

        $sql = "SELECT * FROM tblpatient WHERE id='$id' ";
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

    if(isset($_POST['updatedata']))
    {
        $id = $_POST['edit_id'];
        $fname  = $_POST['fname'];
        $lname  = $_POST['lname'];
        $address = $_POST['address'];
        $dob = $_POST['birthday'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $old_image = $_POST['old_image'];
        $image = $_FILES['edit_patimage']['name'];

        if($password == $confirmPassword)
        {
            $checkemail = "SELECT email FROM tbladmin WHERE email='$email' 
            UNION ALL SELECT email FROM tblstaff WHERE email='$email'
            UNION ALL SELECT email FROM tblpatient WHERE email='$email' AND id != '$id'  
            UNION ALL SELECT email FROM tbldoctor WHERE email='$email' ";
            $checkemail_run = mysqli_query($conn, $checkemail);
    
            if(mysqli_num_rows($checkemail_run) > 0)
            {           
                $_SESSION['error'] = "Email Already Exist";
                header('Location:patients.php');
            }
            else
            {
                $update_filename =" ";

                if($image!=NULL)
                {
                    
                    $allowed_file_format = array('jpg', 'png','jpeg');
    
                    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    
                    if(!in_array($image_extension, $allowed_file_format))
                    {
                        $_SESSION['error'] = "Upload valiid file. jpg, png";
                        header('Location:patients.php');
                    }
                    else if (($_FILES["edit_patimage"]["size"] > 2000000))
                    {
                        $_SESSION['error'] = "File size exceeds 2MB";
                        header('Location:patients.php');
                    }
                    else 
                    {
                        $filename = time().'.'.$image_extension;
                        $update_filename = $filename;
                    }
                }
                else
                {
                    $update_filename = $old_image;
                }
                if($_SESSION['error'] == '')
                {
                    $sql = "UPDATE tblpatient set fname='$fname',lname='$lname',address='$address',dob='$dob', gender='$gender', phone='$phone', email='$email', password='$password',image='$update_filename'  WHERE id='$id' ";
                    $query_run = mysqli_query($conn,$sql);
        
                    if ($query_run)
                    {                   
                        if($image != NULL)
                        {
                            if(file_exists('../upload/patients/'.$old_image))
                            {
                                unlink("../upload/patients/".$old_image);
                            }
                            move_uploaded_file($_FILES['edit_patimage']['tmp_name'], '../upload/patients/'.$update_filename);
                        }     
                        $_SESSION['success'] = "Patient Updated Successfully";
                        header('Location:patients.php');
                    }
                    else
                    {
                        $_SESSION['error'] = "Patient Updated Unsuccessfully";
                        header('Location:patients.php');
                    }
                }     
            }
    
        }
        else
        {
            $_SESSION['error'] = "Password does not match";
            header('Location:patients.php');
        }
       
    }

    if(isset($_POST['deletedata']))
    {  
        $id = $_POST['delete_id'];
        $del_image = $_POST['del_image'];

        $check_img_query = " SELECT * FROM tblpatient WHERE id='$id' LIMIT 1";
        $img_res = mysqli_query($conn,$check_img_query);
        $res_data = mysqli_fetch_array($img_res);
        $image = $res_data['image'];
        
        $sql = "DELETE FROM tblpatient WHERE id='$id' ";
        $query_run = mysqli_query($conn,$sql);
        
        if ($query_run)
        {
            if($image != NULL)
            {
                if(file_exists('../upload/patients/'.$image))
                {
                    unlink("../upload/patients/".$image);
                }
            }   
            $_SESSION['success'] = "Patient Deleted Successfully";
            header('Location:patients.php');
        }
        else
        {
            $_SESSION['error'] = "Patient Deleted Unsuccessfully";
        }
    }


?>                                                                   
