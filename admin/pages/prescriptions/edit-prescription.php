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
                                    <h3 class="card-title">Editar Prescripción</h3>
                                    <a href="index.php" class="btn  btn-outline-danger btn-sm float-right">
                                        <i class="fas fa-long-arrow-left"></i> &nbsp;&nbsp;Atrás</a>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $user_id = $_GET['id'];
                                        $user = "SELECT * FROM prescription WHERE id='$user_id'";
                                        $users_run = mysqli_query($conn, $user);

                                        if (mysqli_num_rows($users_run) > 0) {
                                            foreach ($users_run as $user) {
                                    ?>
                                                <form action="prescription_action.php" method="post">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Fecha</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="hidden" id="edit_id" name="edit_id" value="<?= $user['id']; ?>">
                                                                <input type="text" autocomplete="off" name="date" class="form-control" id="presdate" value="<?= $user['date']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Seleccionar Paciente</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-control select2 patient" id="edit_patient" name="select_patient" style="width: 100%;" required>
                                                                    <?php
                                                                    if (isset($_GET['id'])) {
                                                                        echo $id = $_GET['id'];
                                                                    }
                                                                    $sql = "SELECT * FROM tblpatient";
                                                                    $patient_query_run = mysqli_query($conn, $sql);
                                                                    if (mysqli_num_rows($query_run) > 0) {
                                                                        foreach ($patient_query_run as $row) {
                                                                    ?>
                                                                            <option value="<?php echo $row['id']; ?>">
                                                                                <?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <option value="">No se encontraron registros"</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Seleccionar Dentista</label>
                                                                <span class="text-danger">*</span>
                                                                <select class="form-control select2 doctor" id="edit_doctor" name="select_doctor" style="width: 100%;" required>
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
                                                                        <option value="">No se encontraron registros"</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Medicina</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" name="select_medicine" id="edit_medicine" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Dosis</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" name="dose" id="edit_dose" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Duración</label>
                                                                <span class="text-danger">*</span>
                                                                <input type="text" class="form-control" name="duration" id="edit_duration" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Consejo</label>
                                                                <textarea class="summernote" id="edit_advice" name="advice_note"><?php echo $user['advice']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-primary" name="update_prescription">Guardar Cambios</button>
                                                        </div>
                                                    </div>
                                                </form>
                                    <?php
                                            }
                                        } else {
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

    </div>
    <?php include('../../includes/scripts.php'); ?>
    <script>
        $(function() {
            $('.summernote').summernote({
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
                ]
            })
            $('#advice_note').summernote({
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
                ]
            })

            $('.select2').select2()

            $(".patient").select2({
                placeholder: "Seleccionar Paciente",
                allowClear: true
            });

            $(".doctor").select2({
                placeholder: "Seleccionar Dentista",
                allowClear: true
            });

            $('#presdate').datepicker({
                todayHighlight: true,
                clearBtn: true,
            })

            var userid = $('#edit_id').val();
            //console.log(userid);
            $.ajax({
                type: "POST",
                url: "prescription_action.php",
                data: {
                    'checking_prescription': true,
                    'user_id': userid,
                },
                success: function(response) {
                    $.each(response, function(key, value) {
                        $('#edit_patient').val(value['patient_id']);
                        $('#edit_patient').select2().trigger('change');
                        $('#edit_doctor').val(value['doc_id']);
                        $('#edit_medicine').val(value['medicine']);
                        $('#edit_dose').val(value['dose']);
                        $('#edit_qty').val(value['qty']);
                        $('#edit_duration').val(value['duration']);
                        $('#edit_doctor').select2().trigger('change');
                    });
                }
            });
        })
    </script>
    <?php include('../../includes/footer.php'); ?>
