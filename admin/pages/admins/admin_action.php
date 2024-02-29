<?php
include('../../authentication.php');
include('../../config/dbconn.php');
date_default_timezone_set("America/Guayaquil");
if (isset($_POST['change_status'])) {
    $id = $_POST['user_id'];
    $status = $_POST['next_status'];
    $new_status = '';

    if ($status == "Inactive") {
        $new_status = 0;
    }
    if ($status == "Active") {
        $new_status = 1;
    }

    $sql = "UPDATE tbladmin set status='$new_status' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $_SESSION['success'] = "Admin Status Change Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Admin Status Change Unsuccessfully";
        header('Location:index.php');
    }
}

if (isset($_POST['deletedata'])) {
    $id = $_POST['delete_id'];
    $del_image = $_POST['del_image'];

    $check_img_query = " SELECT * FROM tbladmin WHERE id='$id' LIMIT 1";
    $img_res = mysqli_query($conn, $check_img_query);
    $res_data = mysqli_fetch_array($img_res);
    $image = $res_data['image'];

    $sql = "DELETE FROM tbladmin WHERE id='$id' LIMIT 1";
    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        if ($image != NULL) {
            if (file_exists('../../../upload/admin/' . $image)) {
                unlink("../../../upload/admin/" . $image);
            }
        }
        $_SESSION['success'] = "Admin Deleted Successfully";
        header('Location:index.php');
    } else {
        $_SESSION['error'] = "Admin Deleted Unsuccessfully";
        header('Location:index.php');
    }
}

if (isset($_POST['updateadmin'])) {
    $id = $_POST['edit_id'];
    $fname  = $_POST['fname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $admin_email = $_POST['email'];
    $password = $_POST['edit_password'];
    $confirmPassword = $_POST['edit_confirmPassword'];

    $old_image = $_POST['old_image'];
    $image = $_FILES['edit_docimage']['name'];

    $checkemail = "SELECT email FROM tbladmin WHERE email='$admin_email'
        AND id != '$id'  
        UNION ALL SELECT email FROM tblstaff WHERE email='$admin_email'
        UNION ALL SELECT email FROM tblpatient WHERE email='$admin_email'
        UNION ALL SELECT email FROM tbldoctor WHERE email='$admin_email' ";
    $checkemail_run = mysqli_query($conn, $checkemail);

    if ($password == $confirmPassword) {
        if (mysqli_num_rows($checkemail_run) > 0) {
            $_SESSION['error'] = "Email Already Exist";
            header('Location:index.php');
        } else {
            $update_filename = " ";

            if ($image != NULL) {

                $allowed_file_format = array('jpg', 'png', 'jpeg');

                $image_extension = pathinfo($image, PATHINFO_EXTENSION);

                if (!in_array($image_extension, $allowed_file_format)) {
                    $_SESSION['error'] = "Upload valiid file. jpg, png";
                    header('Location:index.php');
                } else if (($_FILES["edit_docimage"]["size"] > 5000000)) {
                    $_SESSION['error'] = "File size exceeds 5MB";
                    header('Location:index.php');
                } else {
                    $filename = time() . '.' . $image_extension;
                    $update_filename = $filename;
                }
            } else {
                $update_filename = $old_image;
            }
            if ($_SESSION['error'] == '') {
                $sql = "UPDATE tbladmin set name='$fname',address='$address', phone='$phone', email='$admin_email', password='$password', image='$update_filename' WHERE id='$id' ";
                $query_run = mysqli_query($conn, $sql);

                if ($query_run) {
                    if ($image != NULL) {
                        if (file_exists('../../../upload/admin/' . $old_image)) {
                            unlink("../../../upload/admin/" . $old_image);
                        }
                        move_uploaded_file($_FILES['edit_docimage']['tmp_name'], '../../../upload/admin/' . $update_filename);
                    }
                    $_SESSION['success'] = "Admin Updated Successfully";
                    header('Location:index.php');
                } else {
                    $_SESSION['error'] = "Admin Updated Unsuccessfully";
                    header('Location:index.php');
                }
            }
        }
    } else {
        $_SESSION['error'] = "Password does not match";
        header('Location:index.php');
    }
}

if (isset($_POST['checking_editAdminbtn'])) {
    $s_id = $_POST['user_id'];
    $result_array = [];

    $sql = "SELECT * FROM tbladmin WHERE id='$s_id' ";
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

if (isset($_POST['checking_viewAdmintbtn'])) {
    $s_id = $_POST['user_id'];

    $sql = "SELECT * FROM tbladmin WHERE id='$s_id' ";
    $query_run = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
?>
            <div class="text-center">
                <img src="../../../upload/admin/<?= $row['image'] ?>" class="img-thumbnail img-fluid img-circle" width="120" alt="Admin Image">
            </div>
            <h3 class="profile-username text-center"><?php echo $row['name']; ?></h3>
            <p class="text-muted text-center"><?php echo $row['specialty']; ?></p>
            <ul class="list-group list-group-unbordered mb-2">
                <li class="list-group-item">
                    <b>Email</b>
                    <p class="float-right text-muted"><?php echo $row['email']; ?></p>
                </li>
                <li class="list-group-item">
                    <b>Phone</b>
                    <p class="float-right text-muted"><?php echo $row['phone']; ?></p>
                </li>
                <li class="list-group-item">
                    <b>Address</b>
                    <p class="float-right text-muted"><?php echo $row['address']; ?></p>
                </li>
            </ul>
<?php
        }
    } else {
        echo $return = "<h5> No Record Found</h5>";
    }
}

if (isset($_POST['insertadmin'])) {
    $doc_fname  = $_POST['fname'];
    $doc_address = $_POST['address'];
    $doc_phone = $_POST['phone'];
    $admin_email = $_POST['email'];
    $role = '';
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $regdate = date('Y-m-d H:i:s');

    $image = $_FILES['doc_image']['name'];

    if ($password == $confirmPassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $checkemail = "SELECT email FROM tbladmin WHERE email='$admin_email' 
            UNION ALL SELECT email FROM tblstaff WHERE email='$admin_email'
            UNION ALL SELECT email FROM tblpatient WHERE email='$admin_email'
            UNION ALL SELECT email FROM tbldoctor WHERE email='$admin_email' ";
        $checkemail_run = mysqli_query($conn, $checkemail);

        if (mysqli_num_rows($checkemail_run) > 0) {
            $_SESSION['error'] = "Email Already Exist";
            header('Location:index.php');
        } else {
            if ($image != NULL) {
                $allowed_file_format = array('jpg', 'png', 'jpeg');

                $image_extension = pathinfo($image, PATHINFO_EXTENSION);


                if (!in_array($image_extension, $allowed_file_format)) {
                    $_SESSION['error'] = "Upload valid file. jpg, png";
                    header('Location:index.php');
                } else if (($_FILES['doc_image']['size'] > 5000000)) {
                    $_SESSION['error'] = "File size exceeds 5MB";
                    header('Location:index.php');
                } else {
                    $filename = time() . '.' . $image_extension;
                    move_uploaded_file($_FILES['doc_image']['tmp_name'], '../../../upload/admin/' . $filename);
                }
            } else {
                $character = $_POST["fname"][0];
                $path = time() . ".png";
                $imagecreate = imagecreate(200, 200);
                $red = rand(0, 255);
                $green = rand(0, 255);
                $blue = rand(0, 255);
                imagecolorallocate($imagecreate, 230, 230, 230);
                $textcolor = imagecolorallocate($imagecreate, $red, $green, $blue);
                imagettftext($imagecreate, 100, 0, 55, 150, $textcolor, '../../font/arial.ttf', $character);
                imagepng($imagecreate, '../../../upload/admin/' . $path);
                imagedestroy($imagecreate);
                $filename = $path;
            }

            if ($_SESSION['error'] == '') {
                $sql = "INSERT INTO tbladmin (name,address,phone,email,image,password,role,created_at)
                    VALUES ('$doc_fname','$doc_address','$doc_phone','$admin_email','$filename','$hash','admin','$regdate')";
                $doctor_query_run = mysqli_query($conn, $sql);
                if ($doctor_query_run) {

                    $_SESSION['success'] = "Adding Admin Successfully";
                    header('Location:index.php');
                } else {
                    //$_SESSION['error'] = "Adding Admin Failed";
                    $_SESSION['error'] = mysqli_error($conn);
                    header('Location:index.php');
                }
            }
        }
    } else {
        $_SESSION['error'] = "Password does not match";
        header('Location:index.php');
    }
}
?>