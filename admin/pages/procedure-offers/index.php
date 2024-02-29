<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="AddProceduresModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Procedimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="procedures_action.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Servicio</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control services" name="select_services" style="width: 100%;" required>
                                            <option selected disabled value="">Seleccionar Servicios Dentales</option>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                echo $id = $_GET['id'];
                                            }
                                            $sql = "SELECT * FROM services";
                                            $query_run = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>

                                                    <option value="<?= $row['id']; ?>">
                                                        <?= $row['title'] ?></option>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="">No se encontraron registros</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Procedimiento</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="procedure" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" autocomplete="off" name="price" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="insert_procedures" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EditProcedureModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Procedimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="procedures_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="edit_id" id="edit_id">
                                    <div class="form-group">
                                        <label>Servicio</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control services" name="select_services" id="edit_services" style="width: 100%;" required>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                echo $id = $_GET['id'];
                                            }
                                            $sql = "SELECT * FROM services";
                                            $query_run = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>

                                                    <option value="<?= $row['id']; ?>">
                                                        <?= $row['title'] ?></option>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="">No se encontraron registros</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Procedimiento</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="procedure" id="edit_procedure" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" autocomplete="off" id="edit_price" name="price" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="update_procedures" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DeleteProcedureModdal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Procedimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="procedures_action.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p> ¿Desea eliminar estos datos?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="deletedata" class="btn btn-primary ">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ofertas de Procedimientos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Tratamientos</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include('../../message.php'); ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Lista de Tratamientos</h3>
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddProceduresModal">
                                        <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Tratamiento</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="" method="GET">
                                        <div class="row">
                                            <div class="w-100 d-flex">
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="form-group">
                                                        <select class="custom-select" name="service" style="width: 100%;" required>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                echo $id = $_GET['id'];
                                                            }
                                                            $sql = "SELECT * FROM services";
                                                            $query_run = mysqli_query($conn, $sql);
                                                            if (mysqli_num_rows($query_run) > 0) {
                                                                foreach ($query_run as $row) {
                                                            ?>
                                                                    <option value="<?= $row['id']; ?>" <?php echo (isset($_GET['service']) && $_GET['service'] == $row['id']) ? 'selected' : ''; ?>>
                                                                        <?= $row['title'] ?></option>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <option value="">No se encontraron registros</option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                    <a href="index.php" type="button" class="btn btn-secondary"><i class="fad fa-sync-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Servicios</th>
                                                <th>Tratamiento</th>
                                                <th>Precios</th>
                                                <th width="50">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_GET['service'])) {
                                                $service = $_GET['service'];
                                                $sql = "SELECT s.title,p.id,p.procedures,p.price FROM services s INNER JOIN procedures p ON s.id = p.service_id WHERE p.service_id = '$service' ";
                                                $query_run = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $row) {
                                            ?>
                                                        <tr>
                                                            <td><?= $row['title'] ?></td>
                                                            <td><?= $row['procedures'] ?></td>
                                                            <td>$ <?= $row['price'] ?></td>
                                                            <td>
                                                                <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-info editProcedurebtn"><i class="fas fa-edit"></i></button>
                                                                <button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-sm deleteServicebtn"><i class="far fa-trash-alt"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                            } else {
                                                $sql = "SELECT s.title,p.id,p.procedures,p.price FROM services s INNER JOIN procedures p ON s.id = p.service_id";
                                                $query_run = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $row) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $row['title'] ?></td>
                                                            <td><?= $row['procedures'] ?></td>
                                                            <td>$ <?= $row['price'] ?></td>
                                                            <td>
                                                                <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-info editProcedurebtn"><i class="fas fa-edit"></i></button>
                                                                <button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-sm deleteServicebtn"><i class="far fa-trash-alt"></i></button>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div> <!-- /.container -->
        </div> <!-- /.content-wrapper -->
    </div>

    <?php include('../../includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {
            $(".services").select2({
                placeholder: "Seleccionar Servicio Dental",
                allowClear: true
            });

            $(document).on('click', '.editProcedurebtn', function() {
                var userid = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "procedures_action.php",
                    data: {
                        'checking_procedures': true,
                        'user_id': userid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#edit_services').val(value['service_id']);
                            $('#edit_services').select2().trigger('change');
                            $('#edit_procedure').val(value['procedures']);
                            $('#edit_price').val(value['price']);
                            $('#EditProcedureModal').modal('show');
                        });

                    }
                });
            });

            $(document).on('click', '.deleteServicebtn', function() {
                var user_id = $(this).data('id');
                $('#delete_id').val(user_id);
                $('#DeleteProcedureModdal').modal('show');
            });

        });
    </script>
    <?php include('../../includes/footer.php'); ?>
