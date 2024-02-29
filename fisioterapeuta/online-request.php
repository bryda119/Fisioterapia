<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <style>
    .select2-selection__choice__remove {
      display: contents;
      position: relative;
      padding-right: 5px !important;
    }
  </style>
  <div class="wrapper">
    <div class="modal fade" id="EditOnlineAppModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar Cita</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="online_action.php" method="POST" id="edit">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <input type="hidden" name="select_patient" id="edit_patient_id">
                    <input type="hidden" name="select_dentist" id="edit_dentist_id">
                    <input type="hidden" name="sched_id" id="sched_id">
                    <input type="hidden" id="edit_schedule">
                    <label>Seleccionar Paciente</label>
                    <span class="text-danger">*</span>
                    <select class="select2 patient" name="" id="edit_patient" style="width:100%;" required disabled>
                      <?php
                      if (isset($_GET['id'])) {
                        echo $id = $_GET['id'];
                      }
                      $sql = "SELECT * FROM tblpatient";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>
                          <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['fname'] . ' ' . $row['lname']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Fecha de la Cita</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="scheddate" id="edit_sched" style="width:100%;" required disabled>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Hora de la Cita</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2" name="schedTime" id="edit_schedTime" style="width:100%;" required disabled>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Servicio</label>
                    <span class="text-danger">*</span>
                    <select class="select2" multiple="multiple" name="service[]" id="edit_reason" style="width: 100%;" required>
                      <?php
                      $sql = "SELECT * FROM procedures ORDER BY procedures ASC";
                      $query_run = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $row) {
                      ?>
                          <option value="<?php echo $row['procedures']; ?>">
                            <?php echo $row['procedures']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Estado de la Cita</label>
                    <span class="text-danger">*</span>
                    <select class="form-control custom-select" name="status" id="edit_status" id="show-checkbox" required>
                      <option value="Confirmed">Confirmada</option>
                      <option value="Pending">Pendiente</option>
                      <option value="Cancelled">Cancelada</option>
                      <option value="Reschedule">Reprogramada</option>
                      <option value="Treated">Atendida</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="color">Color</label>
                    <select name="color" class="form-control custom-select" id="edit_color">
                      <option style="color:#f39c12;" value="#f39c12">Amarillo</option>
                      <option style="color:#00c0ef;" value="#00c0ef">Aqua</option>
                      <option style="color:#0073b7;" value="#0073b7">Azul</option>
                      <option style="color:#00a65a;" value="#00a65a">Verde</option>
                      <option style="color:#FF8C00;" value="#FF8C00">Naranja</option>
                      <option style="color:#3c8dbc;" value="#3c8dbc">Azul Claro</option>
                      <option style="color:#f56954;" value="#f56954">Rojo</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="custom-control custom-checkbox" id="show-email2">
                    <input class="custom-control-input ck" type="checkbox" id="customCheckbox3" name="send-email" disabled>
                    <label for="customCheckbox3" class="custom-control-label">Enviar Correo Electrónico</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="update_appointment" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ViewModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Formulario de Declaración de Salud</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="view_form">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="content-wrapper">
      <div class="content-header">
        <section class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Solicitud en Línea</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active">Solicitud en Línea</li>
              </ol>
            </div>
          </div>
        </section>
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
                  <h3 class="card-title">Lista de Citas de Solicitud en Línea</h3>
                </div>
                <div class="col-md-12 mt-4">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all" role="tab" aria-controls="all" aria-selected="true">Todos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pending-tab" data-toggle="tab" data-target="#pending" role="tab" aria-controls="pending" aria-selected="false">Pendientes</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="confirmed-tab" data-toggle="tab" data-target="#confirmed" role="tab" aria-controls="confirmed" aria-selected="false">Confirmadas</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="treated-tab" data-toggle="tab" data-target="#treated" role="tab" aria-controls="treated" aria-selected="false">Atendidas</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cancelled-tab" data-toggle="tab" data-target="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">Canceladas</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="reschedule-tab" data-toggle="tab" data-target="#reschedule" role="tab" aria-controls="reschedule" aria-selected="false">Reprogramadas</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div id="pending" class="tab-pane fade" role="tabpanel" aria-labelledby="pending-tab">
                      <table id="pendingtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="confirmed" class="tab-pane fade" role="tabpanel" aria-labelledby="confirmed-tab">
                      <table id="oconfirmedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="treated" class="tab-pane fade" role="tabpanel" aria-labelledby="treated-tab">
                      <table id="otreatedtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="cancelled" class="tab-pane fade" role="tabpanel" aria-labelledby="cancelled-tab">
                      <table id="ocancelledtbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="reschedule" class="tab-pane fade" role="tabpanel" aria-labelledby="reschedule-tab">
                      <table id="orescheduletbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                    <div id="all" class="tab-pane fade show active" role="tabpanel" aria-labelledby="all-tab">
                      <table id="oalltbl" class="table table-borderless table-hover" style="width: 100%;">
                        <thead class="bg-light">
                          <tr>
                            <th class="export">Paciente</th>
                            <th class="export">Fecha de Envío</th>
                            <th class="export">Fecha de la Cita</th>
                            <th class="export">Hora de Inicio</th>
                            <th class="export">Hora de Finalización</th>
                            <th class="export">Estado</th>
                            <th class="export">Estado de Pago</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>

  <?php include('includes/scripts.php'); ?>
  <script>
    var user = <?php echo $_SESSION['auth_user']['user_id'] ?>;
    console.log(user);
    $(document).ready(function() {
      var table1 = $('#pendingtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Pending'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Pending') {
                return '<span class="badge badge-warning">Pending</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
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
    });

    $(document).ready(function() {

      var table2 = $('#oconfirmedtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Confirmed'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Confirmed') {
                return '<span class="badge badge-success">Confirmed</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      var table3 = $('#otreatedtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Treated'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Treated') {
                return '<span class="badge badge-primary">Treated</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      var table4 = $('#ocancelledtbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Cancelled'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Cancelled') {
                return '<span class="badge badge-danger">Cancelled</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });
      var table5 = $('#orescheduletbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": 'Reschedule'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Reschedule') {
                return '<span class="badge badge-secondary">Reschedule</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });
      var table6 = $('#oalltbl').DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "processing": true,
        "searching": true,
        "paging": true,
        "responsive": true,
        "pagingType": "simple",
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
          "url": "online_rq_table.php",
          "type": "POST",
          "data": {
            "doctor_id": <?php echo $_SESSION['auth_user']['user_id'] ?>,
            "status": '%e%'
          },
        },
        "columns": [{
            "data": "patient_name"
          },
          {
            "data": "created_at",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "schedule",
            render: function(data, type, row) {
              return moment(data).format("DD-MMMM-YYYY")
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": 'status',
            render: function(data, type, row) {
              if (data == 'Confirmed') {
                return '<span class="badge badge-success">Confirmed</span>';
              } else if (data == 'Pending') {
                return '<span class="badge badge-warning">Pending</span>';
              } else if (data == 'Treated') {
                return '<span class="badge badge-primary">Treated</span>';
              } else if (data == 'Reschedule') {
                return '<span class="badge badge-secondary">Reschedule</span>';
              } else {
                return '<span class="badge badge-danger">Cancelled</span>';
              }
            }
          },
          {
            "data": "payment_status"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button type="button" data-id="' + row.patient_id + '" class="btn btn-sm btn-secondary viewbtn"><i class="fad fa-head-side-mask"></i></button> <button type="button" data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button>';
            }
          },
        ],
      });

      $('.nav-tabs a').on('shown.bs.tab', function(event) {
        var tabID = $(event.target).attr('data-target');
        if (tabID === '#pending') {
          table1.columns.adjust().responsive.recalc();
        }
        if (tabID === '#confirmed') {

          table2.columns.adjust().responsive.recalc();
        }
        if (tabID === '#treated') {
          table3.columns.adjust().responsive.recalc();
        }
        if (tabID === '#cancelled') {
          table4.columns.adjust().responsive.recalc();
        }
        if (tabID === '#reschedule') {
          table5.columns.adjust().responsive.recalc();
        }
        if (tabID === '#all') {
          table6.columns.adjust().responsive.recalc();
        }
      });

      $(document).ready(function() {

        $('.select2').select2()

        $("#selectedPatient").on("change", function() {
          var patientID = $('#selectedPatient').val();
          $("#preferredDentist").val('');
          $('#preferredDate').val('');
          $("#preferredDentist").select2({
            allowClear: true,
            placeholder: "Select Dentist",
            ajax: {
              url: 'appointment_action.php',
              type: 'GET',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  getDoctors: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
          $('#preferredDate').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'GET',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  doctorIdDate: selectedDentistId,
                  patientId: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        })

        $("#preferredDentist").on("change", function() {
          var selectedDentistId = $("#preferredDentist").val();
          var patientID = $("#selectedPatient").val();
          $('#preferredDate').val('');
          $('#preferredDate').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'GET',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  doctorIdDate: selectedDentistId,
                  patientId: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        });

        $("#edit_dentist").on("change", function() {
          var selectedDentistId = $("#edit_dentist").val();
          var patientID = $("#edit_patient").val();
          $("#edit_sched").empty().trigger('change');
          $("#edit_schedTime").empty().trigger('change');
          $('#edit_sched').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'GET',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  doctorIdDate: selectedDentistId,
                  patientId: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        });
        $("#edit_sched").on("change", function() {
          var selectedSchedId = $("#edit_sched").val();
          var patientID = $("#edit_patient").val();
          $("#edit_schedTime").empty().trigger('change');
          $('#edit_schedTime').select2({
            allowClear: true,
            placeholder: "Available Date",
            ajax: {
              url: 'appointment_action.php',
              type: 'POST',
              dataType: 'json',
              delay: 250,
              data: function(params) {
                return {
                  selectedDateId: selectedSchedId,
                  patientId: patientID
                };
              },
              processResults: function(response) {
                return {
                  results: response
                };
              },
              cache: true,
            }
          });
        });
        $(".select2").select2();
        $('.select2').on('select2:open', function() {
          $('.select2-selection__choice__remove').addClass('select2-remove-right');
        });
        $(".patient").select2({
          placeholder: "Select Patient",
          allowClear: true
        });
        $(".treatment").select2({
          placeholder: "Select Treatment",
          allowClear: true
        });

        $(".dentist").select2({
          placeholder: "Select Dentist",
          allowClear: true
        });

        $("#preferredDate").select2({
          placeholder: "Available Date",
          allowClear: true
        });
        $("#edit_reason").select2({
          placeholder: "Select Service",
          allowClear: true
        });

        $("#edit_sched").select2({
          placeholder: "Select Date",
          allowClear: true
        });
        $("#edit_schedTime").select2({
          placeholder: "Select Time",
          allowClear: true
        });

        const colorBox = document.getElementById('edit_color');

        colorBox.addEventListener('change', (event) => {
          const color = event.target.value;
          event.target.style.color = color;
        }, false);

        $("#edit_status").on('change', function() {
          var val = $(this).val();
          if (this.value == "Confirmed") {
            $('.ck').prop("disabled", false);
          } else {
            $('.ck').prop("disabled", true);
            $('#customCheckbox3').prop("checked", false);
          }
        });


        $(document).on('click', '.viewbtn', function() {
          var userid = $(this).data('id');
          $.ajax({
            type: "post",
            url: "online_action.php",
            data: {
              'checking_data': true,
              'user_id': userid,
            },
            success: function(response) {
              $('.view_form').html(response);
              $('#ViewModal').modal('show');
            }
          });
        });

        $(document).on('click', '.editbtn', function() {
          var schedid = $(this).data('id');
          $("#edit_sched").empty().trigger('change')
          $("#edit_schedTime").empty().trigger('change')

          $.ajax({
            type: 'post',
            url: "online_action.php",
            data: {
              'checking_editbtn': true,
              'app_id': schedid,
            },
            success: function(response) {
              $('#edit_id').val(response['id']);
              $('#edit_patient_id').val(response['patient_id']);
              $('#edit_patient').val(response['patient_id']);
              $('#sched_id').val(response['sched_id']);
              $('#edit_patient').select2().trigger('change');
              $('#edit_dentist_id').val(response['doc_id']);
              $('#edit_dentist').val(response['doc_id']);
              $('#edit_dentist').select2().trigger('change');
              var services = response['reason'].split(",");
              $('#edit_reason').val(services);
              $('#edit_reason').trigger('change');
              $('#edit_status').val(response['status']);
              $('#edit_color').val(response['bgcolor']);
              $('#edit_schedule').val(response['schedule']);
              var newOption = new Option(response['schedule'], response['sched_id'], true, false);
              $('#edit_sched').append(newOption).trigger('change');
              var newOpt = new Option(response['time'], response['time'], true, false);
              $('#edit_schedTime').append(newOpt).trigger('change');

              $('#EditOnlineAppModal').modal('show');
            }
          });
        });

        $(document).on('click', '.deletebtn', function() {
          var user_id = $(this).data('id');
          $('#delete_id').val(user_id);
          $('#deletemodal').modal('show');

        });

        $('#edit_status').on('change', function() {
          var treated = $(this).val();
          var schedDate = $("#edit_schedule").val();
          var appDate = Date.parse(schedDate);
          var todayDate = new Date().getTime();;
          if (treated == "Treated") {
            if (todayDate < appDate) {
              if (confirm('The appointment date is not today, are you sure you want to set it to Treated?')) {} else {
                this.selectedIndex = 0;
              }
            }
            return false;
          }
        });
      });
    });
  </script>

  <?php include('includes/footer.php'); ?>