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
                            <h1>Configuración de correo</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Configuración de correo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            include('../../message.php');
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Información del correo</h3>
                                </div>
                                <form action="mail_action.php" method="post" onsubmit="return validateForm();">
                                    <div class="card-body">
                                        <?php
                                        $sql = "SELECT * FROM mail_settings WHERE id='1' LIMIT 1";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Host</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="host" class="form-control" value="<?= $row['host'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Usuario</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="">Contraseña</label>
                                                    <span class="text-danger">*</span>
                                                    <input type="text" name="password" class="form-control" value="<?= $row['password'] ?>" required>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" name="mail_update" class="btn btn-primary" onClick="return checkForm(this);">Actualizar</button>
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
