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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Prescripción</h3>
                        <a href="prescription.php" class="btn  btn-outline-danger btn-sm float-right">
                        <i class="fas fa-long-arrow-left"></i> &nbsp;&nbsp;Volver</a>
                    </div>
                    <div class="card-body">
                        <form action="prescription_action.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" autocomplete="off" name="date" class="form-control" id="presdate" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Seleccionar Paciente</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control select2 patients" name="select_patient" style="width: 100%;" required>
                                    <option selected disabled value="">Seleccionar Paciente</option>
                                    <?php
                                        if(isset($_GET['id']))
                                        {
                                            echo $id = $_GET['id'];
                                        } 
                                        $sql = "SELECT * FROM tblpatient";
                                        $query_run = mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            foreach($query_run as $row)
                                            {
                                            ?>

                                            <option value="<?php echo $row['id'];?>">
                                            <?php echo $row['fname'].' '.$row['lname'];?></option>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <option value="">No se encontraron registros"</option>
                                            <?php
                                        }
                                        ?>     
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="select_doctor" value="<?php echo $_SESSION['auth_user']['user_id']?>">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Medicina</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="select_medicine" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dosis</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="dose" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duración</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="duration" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Consejo</label>
                                    <textarea id="advice_note" name="advice_note">                                
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_prescription">Guardar Prescripción</button>
                            </div>
                        </div>                       
                        </form>
                    </div>
                </div>
            <!-- /.card-body -->
            </div>
          <!-- /.card -->
        </div>

    </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>

</div>
<?php include('includes/scripts.php');?>
<script>
     $(function () {
    $('#advice_note').summernote({
        height: 150,
    })

    $('.select2').select2()

      $(".patients").select2({
      placeholder: "Seleccionar Paciente",
      allowClear: true
      });

      $(".doctor").select2({
      placeholder: "Seleccionar Médico",
      allowClear: true
      });

    $('#presdate').datepicker({
      todayHighlight: true,
      clearBtn: true,
    })
  })
</script>
<?php include('includes/footer.php');?>
