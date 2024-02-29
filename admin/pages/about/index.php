<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="modal fade" id="EditAboutModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Acerca de Nosotros</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="about_action.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="edit_id" id="edit_id">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Título del Artículo</label><span class="text-danger">*</span>
                                        <input type="text" name="art_title" id="edit_art-title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Contenido</label>
                                        <textarea name="content" id="edit_content"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Subir Imagen</label><span class="text-danger">*</span>
                                        <input type="file" id="edit_simage" name="files">
                                        <input type="hidden" name="old_image" id="old_image" />
                                        <div id="uploaded_image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" name="update_about" class="btn btn-primary">Enviar</button>
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
                            <h1>Acerca de Nosotros</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Acerca de Nosotros</li>
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
                                    <h3 class="card-title">Información Acerca de Nosotros</h3>
                                </div>
                                <!-- /.cards-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-borderless table-hover" style="width:100%;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="30">Imagen</th>
                                                <th>Título del Artículo</th>
                                                <th>Contenido</th>
                                                <th width="50">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM about";
                                            $query_run = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_array($query_run)) {
                                            ?>
                                                <tr>
                                                    <td><img src="../../../upload/<?= $row['image'] ?>" class="img-fluid img-thumbnail" width="100" alt=""></td>
                                                    <td><?= $row['title'] ?></td>
                                                    <td><?= $row['content'] ?></td>
                                                    <td>
                                                        <button data-id="<?= $row['id'] ?>" class="btn btn-sm btn-info editAboutbtn"><i class="fas fa-edit"></i></button>
                                                        <input type="hidden" name="del_image" value="<?= $row['image']; ?>">
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

            $('#edit_content').summernote({
                placeholder: 'Raleway para el Título y Open Sans 16 para el cuerpo',
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Open Sans', 'Raleway'],
                fontNamesIgnoreCheck: ['Open Sans', 'Raleway'],
            })

            $('#edit_content').summernote('fontName', 'Open Sans');


            $(document).on('click', '.editAboutbtn', function() {
                var userid = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "about_action.php",
                    data: {
                        'checking_about': true,
                        'user_id': userid,
                    },
                    success: function(response) {
                        $.each(response, function(key, value) {
                            $('#edit_id').val(value['id']);
                            $('#edit_art-title').val(value['title']);
                            $('#edit_content').summernote('code', value['content']);
                            $('#uploaded_image').html('<img src="../../../upload/' + value['image'] + '" class="img-fluid img-thumbnail" width="200" />');
                            $('#old_image').val(value['image']);
                            $('#EditAboutModal').modal('show');
                        });

                    }
                });
            });

        });
    </script>
    <?php include('../../includes/footer.php'); ?>