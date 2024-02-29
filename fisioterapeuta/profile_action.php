<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');

    if(isset($_POST['logout_btn']))
    {
        session_destroy();
        unset($_SESSION['auth']);
        unset($_SESSION['auth_role']);
        unset($_SESSION['auth_user']);

        $_SESSION['success'] = "Logged out successfully";
        header('Location: ../login.php');
        exit(0);
    }

    if(isset($_POST['profile_details']))
    {
        $id = $_POST['userid'];
        $name = $_POST['name'];
        $dob = $_POST['birthday'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $degree = $_POST['degree'];
        $specialty = $_POST['specialty'];

        $old_image = $_POST['old_image'];
        $image = $_FILES['img_url']['name'];

        
        $update_filename ="";
        if($image!=null)
        {
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_file_format = array('jpg', 'png','jpeg');
            if(!in_array($image_extension, $allowed_file_format))
            {
                $_SESSION['error'] = "Upload valid file. jpg, png";
                header('Location:profile.php');
            }
            else if (($_FILES['img_url']['size'] > 5000000))
            {
                $_SESSION['error'] = "File size exceeds 5MB";
                header('Location:profile.php');
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
            $sql = "UPDATE tbldoctor SET name='$name',dob='$dob',gender='$gender',address='$address',phone='$contact',degree='$degree',specialty='$specialty',image='$update_filename' WHERE id='$id'";
            $query_run = mysqli_query($conn,$sql);

            if($query_run)
            {
                if($image != NULL)
                {
                    if(file_exists('../upload/doctors/'.$old_image))
                    {
                        unlink("../upload/doctors/".$old_image);
                    }
                    move_uploaded_file($_FILES['img_url']['tmp_name'], '../upload/doctors/'.$update_filename);
                }
                $_SESSION['success'] = "Profile Updated Successfully";
                header('Location: profile.php');
            }
            else
            {
                $_SESSION['error'] = "Profile Update Failed";
                header('Location: profile.php');
            }
        }
    }

    if(isset($_POST['change_password']))
    {
        $id = $_POST['userid'];
        $current_pass = $_POST['current_pass'];
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];

        if(!empty($current_pass) && !empty($new_pass) && !empty($confirm_pass))
        {
            $sql = "SELECT password FROM tbldoctor WHERE id='$id'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    if(password_verify($current_pass,$row['password']))
                    {
                        if($new_pass == $confirm_pass)
                        {
                            $hash = password_hash($new_pass,PASSWORD_DEFAULT);
                            $update_password = "UPDATE tbldoctor SET password='$hash' WHERE id='$id' LIMIT 1";
                            $update_password_run = mysqli_query($conn,$update_password);

                            if($update_password_run)
                            {
                                $_SESSION['success'] = "Password has been changed";
                                header("Location:profile.php");
                            }
                        }
                        else
                        {
                            $_SESSION['error'] = "Password and Confirm Password does not match";
                            header("Location:profile.php");
                        }

                    }           
                    else
                    {
                        $_SESSION['error'] = "Your current password does not match. Please try again.";
                        header("Location:profile.php");
                    }
                }
            }
              
        }
        else
        {
            $_SESSION['error'] = "Please Complete All Fields";
            header("Location:profile.php");
        }
    }
