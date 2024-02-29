<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Payment Settings</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Payment Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('../../message.php');
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Payment Information</h3>
                                </div>
                                <form action="payment_action.php" method="post" onsubmit="return validateForm();">
                                    <div class="card-body">
                                        <?php
                                        $sql = "SELECT * FROM payment_settings WHERE id='1' LIMIT 1";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Paypal Business Email</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="email" class="form-control" value="<?= $row['business_email'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Paypal Success URL</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="success" class="form-control" value="<?= $row['success'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Paypal Cancel URL</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="cancel" class="form-control" value="<?= $row['cancel'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Paypal IPN URL</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" value="<?= $row['ipn'] ?>" name="ipn" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Paypal Amount Fee</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="number" class="form-control" value="<?= $row['fee'] ?>" min="0" name="fee" required>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" name="payment_details" class="btn btn-primary" onClick="return checkForm(this);">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../../includes/scripts.php'); ?>
        <?php include('../../includes/footer.php'); ?>