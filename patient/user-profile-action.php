<?php
    include('authentication.php');
    include('../admin/config/dbconn.php');

    if(isset($_POST['update_user']))
    {
        $id = $_POST['userid'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $dob = $_POST['birthday'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $old_image = $_POST['old_image'];
        $image = $_FILES['img_url']['name'];

        
        $update_filename ="";
        if($image!=null)
        {
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_file_format = array('jpg', 'png','jpeg');
            if(!in_array($image_extension, $allowed_file_format))
            {
                $_SESSION['error'] = "Sube un archivo válido. jpg, png";
                header('Location:user-profile.php');
            }
            else if (($_FILES['img_url']['size'] > 5000000))
            {
                $_SESSION['error'] = "El tamaño del archivo supera los 5MB";
                header('Location:user-profile.php');
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
            $sql = "UPDATE tblpatient SET fname='$fname',lname='$lname',dob='$dob',gender='$gender',address='$address',phone='$contact',image='$update_filename' WHERE id='$id'";
            $query_run = mysqli_query($conn,$sql);

            if($query_run)
            {
                if($image != NULL)
                {
                    if(file_exists('../upload/patients/'.$old_image))
                    {
                        unlink("../upload/patients/".$old_image);
                    }
                    move_uploaded_file($_FILES['img_url']['tmp_name'], '../upload/patients/'.$update_filename);
                }
                $_SESSION['success'] = "Perfil actualizado con éxito";
                header('Location: user-profile.php');
            }
            else
            {
                $_SESSION['error'] = "Error al actualizar el perfil";
                header('Location: user-profile.php');
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
            $sql = "SELECT password FROM tblpatient WHERE id='$id'";
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
                            $update_password = "UPDATE tblpatient SET password='$hash' WHERE id='$id' LIMIT 1";
                            $update_password_run = mysqli_query($conn,$update_password);

                            if($update_password_run)
                            {
                                $_SESSION['success'] = "La contraseña ha sido cambiada";
                                header("Location:user-profile.php");
                            }
                        }
                        else
                        {
                            $_SESSION['error'] = "La contraseña y la confirmación de contraseña no coinciden";
                            header("Location:user-profile.php");
                        }

                    }           
                    else
                    {
                        $_SESSION['error'] = "Tu contraseña actual no coincide. Por favor, inténtalo de nuevo.";
                        header("Location:user-profile.php");
                    }
                }
            }
              
        }
        else
        {
            $_SESSION['error'] = "Por favor completa todos los campos";
            header("Location:user-profile.php");
        }
    }


?>
