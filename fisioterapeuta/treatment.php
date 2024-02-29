<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!--Edit Modal-->
    <div class="modal fade" id="EditAppointmentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Tratamiento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="treatment_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <label>Seleccionar Paciente</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 patient" name="select_patient" id="edit_patient" style="width: 100%;" readonly disabled>
                      <option selected disabled value="">Seleccionar Paciente</option>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT CONCAT(p.fname,' ',p.lname) as pname,t.id,t.patient_id FROM tblappointment t INNER JOIN tblpatient p ON p.id = t.patient_id WHERE t.status='Treated'";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>

                          <option value="<?php echo $row['patient_id']; ?>">
                            <?php echo $row['pname']; ?></option>
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
                <input type="hidden" class="form-control" name="selectpatient" id="show_patient" readonly>
                <input type="hidden" class="form-control" name="sched_id" id="sched_id" readonly>
                <input type="hidden" class="form-control" name="select_dentist" id="edit_dentist" readonly>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Fecha de Visita</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" name="visit" class="form-control" id="edit_visit" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Tratamiento</label>
                    <input type="text" name="treatment" id="edit_treatment" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Tipo de tratamiento</label>
                    <input type="text" name="teeth" id="edit_teeth" min="0" class="form-control">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Descripción</label>
                    <span class="text-danger">*</span>
                    <textarea class="form-control" rows="2" name="description" id="edit_complaint" placeholder="Ingrese ..."></textarea>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Tarifas</label>
                    <input type="text" name="fees" id="edit_fees" min="0" class="form-control">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Cargar Archivo</label>
                    <input type="file" name="uploadedFile" class="form-control">
                    <input type="hidden" name="old_file" id="old_file" />
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="">Observaciones</label>
                    <input type="text" name="remarks" id="edit_remarks" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="update_treatment" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/modal de edición-->

    <!-- modal de eliminación -->
    <div class="modal fade" id="deletemodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Tratamiento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="treatment_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p>¿Desea eliminar estos datos?</p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="deletedata" class="btn btn-primary ">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/modal de eliminación -->

    <!-- Contenedor de contenido. Contiene el contenido de la página -->
    <div class="content-wrapper">
      <!-- Encabezado del contenido (encabezado de página) -->
      <div class="content-header">
        <section class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Tratamiento</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Tratamiento</li>
              </ol>
            </div> <!-- /.col -->
          </div> <!-- /.row -->
        </section><!-- /.container-fluid -->
      </div> <!--/.content-header-->

      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php
              include('message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Lista de Tratamientos</h3>
                </div>
                <div class="card-body">
                  <table id="treatment_table" class="table table-borderless table-hover" style="width:100%">
                    <thead class="bg-light">
                      <tr>
                        <th class="export">Paciente</th>
                        <th class="export">Fecha de Visita</th>
                        <th class="export">Tratamiento</th>
                        <th class="export">Tipo de tratamiento</th>
                        <th class="export">Descripción</th>
                        <th class="export">Tarifas</th>
                        <th class="export">Observaciones</th>
                        <th>Adjunto</th>
                        <th>Descargar</th>
                        <th width="10%">Acción</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="search">Paciente</th>
                        <th class="search">Fecha de Visita</th>
                        <th class="search">Tratamiento</th>
                        <th class="search">Tipo de tratamiento</th>
                        <th class="search">Descripción</th>
                        <th class="search">Tarifas</th>
                        <th class="search">Observaciones</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </tfoot>
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

  <?php include('includes/scripts.php'); ?>

  <script>
    $(document).ready(function() {

      var table = $('#treatment_table').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
        "bLengthChange": true,
        "buttons": [{
            extend: 'copyHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-clipboard"></i>  Copy',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'csvHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-csv"></i>  CSV',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-excel"></i>  Excel',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'pdfHtml5',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="far fa-file-pdf"></i>  PDF',
            exportOptions: {
              columns: '.export'
            }
          },
          {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm',
            text: '<i class="fas fa-print"></i>  Print',
            exportOptions: {
              columns: '.export'
            }
          }
        ],
        "order": [
          [1, "asc"]
        ],
        "async": true,
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "treatment_table.php",
          "type": "GET",
          "data": {
            "doc_id": <?= $_SESSION['auth_user']['user_id'] ?>
          }
        },
        "columns": [{
            "data": 'fname',
            render: function(data, type, row) {
              return row.lname + ", " + row.fname;
            }
          },
          {
            "data": "day",
            render: function(data, type, row) {
              return moment(data).format("DD-MMM-YYYY")
            }
          },
          {
            "data": "treatment"
          },
          {
            "data": "teeth"
          },
          {
            "data": "complaint"
          },
          {
            "data": "fees"
          },
          {
            "data": "remarks"
          },
          {
            "data": "attachment",
            render: function(data, type, row) {
              if (row.attachment != "") {
                return '<a href = "../upload/documents/' + row.attachment + '" target="_blank"> View </a>';
              } else {
                return "N/A";
              }
            }
          },
          {
            "data": "download",
            render: function(data, type, row) {
              if (row.attachment != "") {
                return '<a href = "../upload/documents/' + row.attachment + '" download> Download </a>';
              } else {
                return "N/A";
              }
            }
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <button type="button" data-id="' + data + '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>';
            }
          },
        ],
        "initComplete": function() {
          this.api().columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        },
      });
      $('#treatment_table tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });

      $('#scheddate1').datepicker({});
      $('#scheddate2').datepicker({});

      $('.select2').select2()

      $(".patient").select2({
        placeholder: "Select Patient",
        allowClear: true
      });

      $(".dentist").select2({
        placeholder: "Select Dentist",
        allowClear: true
      });



      $(document).on('click', '.editbtn', function() {
        var treatment = $(this).data('id');

        $.ajax({
          type: 'post',
          url: "treatment_action.php",
          data: {
            'checking_editbtn': true,
            'treatment_id': treatment,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#show_patient').val(value['patient_id']);
              $('#edit_patient').val(value['patient_id']);
              $('#edit_patient').select2().trigger('change');
              $('#edit_dentist').val(value['doc_id']);
              $('#sched_id').val(value['visit']);
              $('#edit_visit').val(value['visit']);
              $('#edit_teeth').val(value['teeth']);
              $('#edit_complaint').val(value['complaint']);
              $('#edit_treatment').val(value['treatment']);
              $('#edit_fees').val(value['fees']);
              $('#edit_amount').val(value['amount']);
              $('#edit_remarks').val(value['remarks']);
              $('#old_file').val(value['file_name']);
            });

            $('#EditAppointmentModal').modal('show');
          }
        });
      });

      $(document).on('click', '.deletebtn', function() {
        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#deletemodal').modal('show');

      });

      $('#patient').on('change', function() {
        var user_id = $(this).val();
        console.log(user_id);
        $.ajax({
          type: 'post',
          url: "treatment_action.php",
          data: {
            user_id: user_id
          },
          dataType: "JSON",
          success: function(response) {
            $('#dentist').val(response.doc_id);
            $('#visit').val(response.visit);
            $('#treatment').val(response.treatment);
          }
        })

      });
      $('#edit_patient').on('change', function() {
        var user_id = $(this).val();
        console.log(user_id);
        $.ajax({
          type: 'post',
          url: "treatment_action.php",
          data: {
            user_id: user_id
          },
          dataType: "JSON",
          success: function(response) {
            $('#edit_dentist').val(response.doc_id);
            $('#edit_visit').val(response.visit);
            $('#edit_treatment').val(response.treatment);
          }
        })

      });

    });
  </script>

  <?php include('includes/footer.php'); ?>