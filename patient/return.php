<?php

include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
date_default_timezone_set("Asia/Manila");
function random_strings($length_of_string)
{
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    return substr(
        str_shuffle($str_result),
        0,
        $length_of_string
    );
}

if ($_GET['st'] == "Completed") {
    $transact_id = $_GET['tx'];
    $payer_id = $_GET['payer_id'];
    $appointment_id = $_GET['custom'];
    $amount = $_GET['amt'];
    $currency = $_GET['cc'];
    $payment_status = $_GET['st'];
    $payment_date = $_GET['payment_date'];
    $email = $_GET['payer_email'];
    $fn = $_GET['first_name'];
    $ln = $_GET['last_name'];
    $date = date('Y-m-d H:i:s');
    $patient_id = $_GET['item_number'];
    $ref_id = strtoupper(random_strings(12));
}
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php
                    $sql = "SELECT * FROM payments WHERE txn_id = '$transact_id'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '';
                        } else {
                            $sql = "INSERT INTO payments(patient_id,app_id,payer_id,ref_id,payment_status,amount,currency,txn_id,payer_email,first_name,last_name,created_at) VALUES('$patient_id','$appointment_id','$payer_id','$ref_id','$payment_status','$amount','$currency','$transact_id','$email','$fn','$ln','$date')";
                            $query_run = mysqli_query($conn, $sql);
                            if ($query_run) {

                    ?>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="h5 text-center text-primary mt-2">Your payment has been successful</div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">Reference Number:</th>
                                                    <td><?php echo $ref_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Transaction ID:</th>
                                                    <td><?php echo $transact_id ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Paid Amount:</th>
                                                    <td>₱ <?php echo $amount ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Status:</th>
                                                    <td><?php echo $payment_status ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Payer Email:</th>
                                                    <td><?php echo $email ?></td>
                                                </tr>
                                                <tr>
                                                    <th>First Name:</th>
                                                    <td><?php echo $fn ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Last Name:</th>
                                                    <td><?php echo $ln ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Date:</th>
                                                    <td><?php echo date('Y-m-d h:i A', strtotime($date)) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="text-center mb-4">
                                    <a href="index.php">return to dashboard</a>
                                </div>
                    <?php
                                $sql = "UPDATE tblappointment SET payment='1' WHERE id='$appointment_id'";
                                $query_run = mysqli_query($conn, $sql);
                            } else {
                                echo '<div class="mt-2 text-center"><h2>Payment Failed</h2></div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
<?php include('includes/scripts.php'); ?>