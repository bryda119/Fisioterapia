<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Modal para añadir paciente -->
    <div class="modal fade" id="AddPatientModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Añadir Paciente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="patient_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Apellido</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="lname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" name="birthday" class="form-control" id="datepicker" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Género</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="gender" required>
                      <option selected disabled value="">Elegir</option>
                      <option>Femenino</option>
                      <option>Masculino</option>
                      <option>Otros</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Dirección</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 mb-2">
                  <div class="form-group">
                    <label>Número de Contacto</label>
                    <span class="text-danger">*</span>
                    <input type="text" class="form-control js-phone" name="phone" pattern="^(09|\+639)\d{9}$" required>
                  </div>
                </div>
                <div class="col-sm-6 mb-2 auto">
                  <div class="form-group">
                    <label>Correo Electrónico</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" class="form-control" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="patient_image">Subir Imagen</label>
                    <input type="file" name="patient_image" id="patient_image">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" name="insertpatient" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal para ver paciente -->
    <div class="modal fade" id="ViewPatientModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Información del Paciente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="patient_viewing_data">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para editar paciente -->
    <div class="modal fade" id="EditPatientModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Paciente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="patient_action.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6 mb-2">
                  <input type="hidden" name="edit_id" id="edit_id">
                  <div class="form-group">
                    <label>Nombre</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="fname" id="edit_fname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
                <div class="col-sm-6 mb-2">
                  <div class="form-group">
                    <label>Apellido</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="lname" id="edit_lname" class="form-control" pattern="[a-zA-Z'-'\s]*" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 mb-2 auto">
                  <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <span class="text-danger">*</span>
                    <input type="text" autocomplete="off" id="edit_dob" name="birthday" class="form-control" id="datepicker" required>
                  </div>
                </div>
                <div class="col-sm-6 mb-2">
                  <div class="form-group">
                    <label>Género</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="gender" id="edit_gender" required>
                      <option selected disabled value="">Elegir</option>
                      <option>Femenino</option>
                      <option>Masculino</option>
                      <option>Otros</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Dirección</label>
                    <span class="text-danger">*</span>
                    <input type="text" name="address" id="edit_address" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Número de Contacto</label>
                    <span class="text-danger">*</span>
                    <input type="text" id="edit_phone" class="form-control js-phone" name="phone">
                  </div>
                </div>
                <div class="col-sm-6 mb-2">
                  <div class="form-group">
                    <label>Correo Electrónico</label>
                    <span class="text-danger">*</span>
                    <input type="email" name="email" id="edit_email" class="form-control" pattern="^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$" required>
                    <span class="email_error text-danger"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="">Subir Imagen</label>
                    <input type="file" id="edit_patimage" name="edit_patimage" />
                    <input type="hidden" name="old_image" id="old_image" />
                    <div id="uploaded_image"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <input type="hidden" id="edit_password" name="password" class="form-control" required>
                <input type="hidden" id="edit_cpassword" name="confirmPassword" class="form-control" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="updatedata" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Modal para editar paciente -->

    <!-- Modal de confirmación para eliminar paciente -->
    <div class="modal fade" id="deletemodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Paciente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="patient_action.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="delete_id" id="delete_id">
              <p>¿Deseas eliminar estos datos?</p>
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
              <h1 class="m-0">Pacientes</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Pacientes</li>
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
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Lista de Pacientes</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddPatientModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Añadir Paciente</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="patienttbl" class="table table-borderless table-hover" style="width: 100%;">
                    <thead class="bg-light">
                      <tr>
                        <th class="text-center">Foto</th>
                        <th class="export">Paciente</th>
                        <th class="export">Fecha de Nacimiento</th>
                        <th class="export">Género</th>
                        <th class="export">Contacto</th>
                        <th class="export">Correo Electrónico</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th class="text-center"></th>
                        <th class="search">Paciente</th>
                        <th class="search">Fecha de Nacimiento</th>
                        <th class="search">Género</th>
                        <th class="search">Contacto</th>
                        <th class="search">Correo Electrónico</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
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
    var table = $('#patienttbl').DataTable({
      "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "processing": true,
      "searching": true,
      "paging": true,
      "responsive": true,
      "pagingType": "simple",
      "autoWidth": false,
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
      "language": {
        'search': '',
        'searchPlaceholder': "Search...",
        'emptyTable': "No results found",
      },
      "ajax": {
        "url": "patient_table.php",
      },
      "columns": [{
          "data": 'image',
          render: function(data, type) {
            return '<img src="../upload/patients/' + data + '" class="img-thumbnail img-circle" width="50" alt="">';
          }
        },
        {
          "data": 'fname',
          render: function(data, type, row) {
            return row.lname + ", " + row.fname;
          }
        },
        {
          "data": "dob",
          render: function(data, type, row) {
            return moment(data).format("DD-MMM-YYYY")
          }
        },
        {
          "data": "gender"
        },
        {
          "data": "phone"
        },
        {
          "data": "email"
        },
        {
          "data": 'id',
          render: function(data, type, row) {
            return '<a href="patient-details.php?id=' + data + '" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a> <button data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <input type="hidden" name="del_image" value="' + row.image + '"><button data-id="' + data + '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>';
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
    $('#patienttbl tfoot th.search').each(function() {
      var title = $(this).text();
      $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
    });

    $(document).ready(function() {

      $(document).on('click', '.viewbtn', function() {
        var userid = $(this).data('id');

        $.ajax({
          url: 'patient_action.php',
          type: 'post',
          data: {
            userid: userid
          },
          success: function(response) {

            $('.patient_viewing_data').html(response);
            $('#ViewPatientModal').modal('show');
          }
        });
      });

      $(document).on('click', '.editbtn', function() {
        var user_id = $(this).data('id');

        $.ajax({
          type: 'post',
          url: "patient_action.php",
          data: {
            'checking_editbtn': true,
            'user_id': user_id,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#edit_fname').val(value['fname']);
              $('#edit_lname').val(value['lname']);
              $('#edit_address').val(value['address']);
              $('#edit_dob').val(value['dob']);
              $('#edit_gender').val(value['gender']);
              $('#edit_phone').val(value['phone'].substring(3));
              $('#edit_email').val(value['email']);
              $('#uploaded_image').html('<img src="../upload/patients/' + value['image'] + '" class="img-fluid img-thumbnail" width="120" />');
              $('#old_image').val(value['image']);
              $('#edit_password').val(value['password']);
              $('#edit_cpassword').val(value['password']);
            });

            $('#EditPatientModal').modal('show');
          }
        });
      });

      $(document).on('click', '.deletebtn', function() {
        var user_id = $(this).data('id');
        $('#delete_id').val(user_id);
        $('#deletemodal').modal('show');

      });
    });
  </script>

  <?php include('includes/footer.php'); ?>