<?php
include('../../authentication.php');
include('../../config/dbconn.php');

if (isset($_POST['profile_details'])) {
    $id = $_POST['userid'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $old_image = $_POST['old_image'];
    $image = $_FILES['img_url']['name'];

    $update_filename = "";
    if ($image != null) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_file_format = array('jpg', 'png', 'jpeg');
        if (!in_array($image_extension, $allowed_file_format)) {
            $_SESSION['error'] = "Upload valid file. jpg, png";
            header('Location:index.php');
        } else if (($_FILES['img_url']['size'] > 5000000)) {
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
        $sql = "UPDATE tbladmin SET name='$name',address='$address',phone='$contact',image='$update_filename' WHERE id='$id'";
        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            if ($image != NULL) {
                if (file_exists('../../../upload/admin/' . $old_image)) {
                    unlink("../../../upload/admin/" . $old_image);
                }
                move_uploaded_file($_FILES['img_url']['tmp_name'], '../../../upload/admin/' . $update_filename);
            }
            $_SESSION['success'] = "Profile Updated Successfully";
            header('Location: index.php');
        } else {
            $_SESSION['error'] = "Profile Update Failed";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['change_password'])) {
    $id = $_POST['userid'];
    $current_pass = $_POST['current_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (!empty($current_pass) && !empty($new_pass) && !empty($confirm_pass)) {
        $sql = "SELECT password FROM tbladmin WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($current_pass, $row['password'])) {
                    if ($new_pass == $confirm_pass) {
                        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                        $update_password = "UPDATE tbladmin SET password='$hash' WHERE id='$id' LIMIT 1";
                        $update_password_run = mysqli_query($conn, $update_password);

                        if ($update_password_run) {
                            $_SESSION['success'] = "Password has been changed";
                            header("Location:index.php");
                        }
                    } else {
                        $_SESSION['error'] = "Password and Confirm Password does not match";
                        header("Location:index.php");
                    }
                } else {
                    $_SESSION['error'] = "Your current password does not match. Please try again.";
                    header("Location:index.php");
                }
            }
        }
    } else {
        $_SESSION['error'] = "Please Complete All Fields";
        header("Location:index.php");
    }
}
