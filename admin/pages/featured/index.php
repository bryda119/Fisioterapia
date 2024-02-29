<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');

$ruta_directorio = '../../assets/dist/img/featured-dentist/';

// Verificar si el directorio de imágenes existe, si no existe, créalo
if (!file_exists($ruta_directorio)) {
    if (!mkdir($ruta_directorio, 0777, true)) {
        die('No se pudo crear el directorio de imágenes...');
    }
}

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="AddDentistModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Fisioterapeuta Destacado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="featured_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Fisioterapeuta</label><span class="text-danger">*</span>
                                        <select class="form-control select2 dentist" name="select_dentist" style="width: 100%;" required>
                                            <option selected disabled value="">Seleccionar Fisioterapeuta</option>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                echo $id = $_GET['id'];
                                            }
                                            $sql = "SELECT * FROM tbldoctor WHERE status='1'";
                                            $query_run = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>

                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['name']; ?></option>
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
                                        <label>Descripción</label>
                                        <textarea class="form-control" rows="4" name="description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Subir Imagen</label><span class="text-danger">*</span>
                                        <input type="file" name="img_profile" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="insert_dentist" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EditDentistModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Fisioterapeuta Destacado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="featured_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" id="edit_id" name="edit_id">
                                    <div class="form-group">
                                        <label>Fisioterapeuta</label><span class="text-danger">*</span>
                                        <select class="form-control select2 dentist" id="edit_dentist" name="select_dentist" style="width: 100%;" required>
                                            <option selected disabled value="">Seleccionar Fisioterapeuta</option>
                                            <?php
                                            if (isset($_GET['id'])) {
                                                echo $id = $_GET['id'];
                                            }
                                            $sql = "SELECT * FROM tbldoctor WHERE status='1'";
                                            $query_run = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>

                                                    <option value="<?php echo $row['id']; ?>">
                                                        <?php echo $row['name']; ?></option>
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
                                        <label>Descripción</label>
                                        <textarea class="form-control" rows="4" name="description" id="edit_description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Subir Imagen</label><span class="text-danger">*</span>
                                        <input type="file" id="edit_image" name="img_profile">
                                        <input type="hidden" name="old_image" id="old_image" />
                                        <div id="uploaded_image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="update_dentist" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DeleteServiceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Fisioterapeuta Destacado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="featured_action.php" method="POST">
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
                            <h1>Fisioterapeuta Destacado</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Fisioterapeuta Destacado</li>
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
                                    <h3 class="card-title">Lista de Fisioterapeuta Destacados</h3>
                                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddDentistModal">
                                        <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Fisioterapeuta Destacado</button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Imagen</th>
                                                <th>Fisioterapeuta</th>
                                                <th>Descripción</th>
                                                <th width="50">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT f.id,f.dentist_id,f.description,f.image,d.name,d.specialty FROM featured f INNER JOIN tbldoctor d ON f.dentist_id = d.id";
                                            $query_run = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_array($query_run)) {
                                            ?>
                                                <tr>
                                                    <td><img src="../../assets/dist/img/featured-dentist/<?= $row['image'] ?>" class="img-fluid img-thumbnail" width="100" alt=""></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $row['description'] ?></td>
                                                    <td>
                                                        <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-info editFeaturedbtn"><i class="fas fa-edit"></i></button>
                                                        <input type="hidden" name="del_image" value="<?= $row['image']; ?>">
                                                        <button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-sm deleteFeaturedbtn"><i class="far fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>
                                            <?php
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
            $(".dentist").select2({
                placeholder: "Seleccionar Fisioterapeuta",
                allowClear: true
            });
            $(document).on('click', '.editFeaturedbtn', function() {
                var dentistid = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "featured_action.php",
                    data: {
                        'checking_featured': true,
                        'dentist_id': dentistid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#edit_dentist').val(value['dentist_id']);
                            $('#edit_dentist').select2().trigger('change');
                            $('#edit_description').val(value['description']);
                            $('#uploaded_image').html('<img src="../../assets/dist/img/featured-dentist/' + value['image'] + '" class="img-fluid img-thumbnail" width="200" />');
                            $('#old_image').val(value['image']);
                            $('#EditDentistModal').modal('show');
                        });

                    }
                });
            });

            $(document).on('click', '.deleteFeaturedbtn', function() {
                var user_id = $(this).data('id');
                $('#delete_id').val(user_id);
                $('#DeleteServiceModal').modal('show');
            });

        });
    </script>
    <?php include('../../includes/footer.php'); ?>
