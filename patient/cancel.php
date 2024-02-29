<?php

include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="mt-4 text-center">
                        <h2>Pago Cancelado</h2>
                        <?php
                        $id = $_SESSION['auth_user']['user_id'];
                        $sql = "DELETE FROM tblappointment WHERE payment='0' AND patient_id='$id' ORDER BY id DESC LIMIT 1";
                        $query_run = mysqli_query($conn, $sql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
    <?php include('includes/scripts.php'); ?>
