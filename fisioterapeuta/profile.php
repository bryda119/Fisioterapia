<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Perfil</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Perfil de Usuario</li>
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
                            include('message.php');
                            ?>
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#info" data-toggle="tab">Editar Perfil</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#pass" data-toggle="tab">Cambiar Contraseña</a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="info">
                                            <form action="profile_action.php" method="post" enctype="multipart/form-data">
                                                <?php
                                                if (isset($_SESSION['auth'])) {
                                                    $sql = "SELECT * FROM tbldoctor WHERE id = '" . $_SESSION['auth_user']['user_id'] . "'";
                                                    $query_run = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_array($query_run)) {
                                                ?>
                                                        <div class="row">
                                                            <input type="hidden" name="userid" value="<?= $_SESSION['auth_user']['user_id'] ?>">
                                                            <div class="form-group col-md-6">
                                                                <label for="">Nombre Completo</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" pattern="[a-zA-Z'-'\s]*" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Dirección</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" name="address" class="form-control" value="<?= $row['address'] ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">Fecha de Nacimiento</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" autocomplete="off" id="datepicker" name="birthday" value="<?= $row['dob'] ?>" class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">Género</label>
                                                                <span class="text-danger">*</span>
                                                                <?php $array = array("Femenino", "Masculino", "Otros");
                                                                echo "<select class='custom-select' name='gender' required>";
                                                                foreach ($array as $gender) {
                                                                    if ($gender == $row['gender']) {
                                                                        echo "<option selected>$gender</option>";
                                                                    } else {
                                                                        echo "<option>$gender</option>";
                                                                    }
                                                                }
                                                                echo "</select>";
                                                                ?>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label for="">Correo Electrónico</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="email" class="form-control" value="<?= $row['email'] ?>" readonly>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label for="">Número de Contacto</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control " value="<?= substr($row['phone'], 0) ?>" name="contact" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Grado</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" name="degree" value="<?= $row['degree'] ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Especialidad</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" name="specialty" value="<?= $row['specialty'] ?>" required>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label for="">Imagen del Dentista</label>
                                                                <input type="file" name="img_url" placeholder="">
                                                                <input type="hidden" name="old_image" value="<?= $row['image'] ?>" />
                                                                <div id="uploaded_image">
                                                                    <img src="../upload/doctors/<?= $row['image'] ?>" class="img-thumbnail img-fluid" width="120" alt="Imagen del Dentista">
                                                                </div>
                                                            </div>

                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" name="profile_details" class="btn btn-danger float-right">Actualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="pass">
                                            <form action="profile_action.php" method="post">
                                                <div class="row">
                                                    <input type="hidden" name="userid" value="<?= $_SESSION['auth_user']['user_id'] ?>">
                                                    <div class="form-group col-md-6">
                                                        <label>Contraseña Actual</label>
                                                        <input type="password" autocomplete="off" name="current_pass" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Nueva Contraseña</label>
                                                        <input type="password" autocomplete="new-password" name="new_pass" id="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Debe contener al menos un número y una letra mayúscula y minúscula, al menos un carácter especial, y al menos 8 o más caracteres" required>
                                                        <div class="show_hide" style="dispplay:none;">
                                                            <small>Fuerza de la Contraseña: <span id="result"> </span></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Confirmar Contraseña</label>
                                                        <input type="password" autocomplete="new-password" name="confirm_pass" class="form-control" id="confirmPassword" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" name="change_password" class="btn btn-danger float-right">Actualizar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/scripts.php'); ?>
        <script>
            $(document).ready(function() {

                $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });
                var activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    $('.nav-pills a[href="' + activeTab + '"]').tab('show');
                }
            });
        </script>
        <?php include('includes/footer.php'); ?>
