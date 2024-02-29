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
                            <h1>Copia de seguridad de la base de datos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Copia de seguridad de la base de datos</li>
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
                                    <h3 class="card-title">Detalles de la base de datos</h3>
                                </div>
                                <form action="database_backup.php" method="post" id="" onsubmit="return validateForm();">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="">Host</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="server" id="server" placeholder="Ingrese el nombre del servidor Ej: Localhost" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Nombre de usuario de la base de datos</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Ingrese el nombre de usuario de la base de datos Ej: root" required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Contraseña de la base de datos</label>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese la contraseña de la base de datos">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="">Nombre de la base de datos</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" name="dbname" id="dbname" placeholder="Ingrese el nombre de la base de datos" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" name="backupnow" class="btn btn-primary" onClick="return checkForm(this);">Iniciar copia de seguridad</button>
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
