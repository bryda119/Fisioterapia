<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Add Modal -->
    <div class="modal fade" id="AddScheduleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Agregar Horario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Seleccionar Doctor</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 dentist" name="select_dentist" style="width: 100%;" required>
                      <option selected disabled value="">Seleccionar Doctor</option>
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
                        <option value="">No Record Found"</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Dia</label>
                    <span class="text-danger">*</span>
                    <input type="date" name="select_day" id="select_day_sched" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Hora de inicio de la cita</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="starttime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="start_time" class="form-control datetimepicker-input" required data-target="#starttime" />
                      <div class="input-group-append" data-target="#starttime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Hora de finalización de la cita</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="endtime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="end_time" class="form-control datetimepicker-input" required data-target="#endtime" />
                      <div class="input-group-append" data-target="#endtime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Duración de la cita</label>
                    <span class="text-danger">*</span>
                    <select class="form-control" name="select_duration" required>
                      <option value="15">15 minutes</option>
                      <option value="20">20 minutes</option>
                      <option value="30">30 minutes</option>
                      <option value="45">45 minutes</option>
                      <option value="60">60 minutes</option>
                      <option value="80">80 minutes</option>
                      <option value="120">120 minutes</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" name="insert_schedule" class="btn btn-primary submit">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <!--Edit Modal-->
    <div class="modal fade" id="EditScheduleModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Editar horario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
            <div class="modal-body">
              <div class="row">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Seleccionar médico</label>
                    <span class="text-danger">*</span>
                    <select class="form-control select2 dentist" name="select_dentist" id="edit_dentist" style="width: 100%;" required readonly>
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
                        <option value="">No se encontró ningún registro"</option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Day</label>
                    <span class="text-danger">*</span>
                    <input type="date" name="select_day" id="edit_day" class="form-control" required readonly>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Hora de inicio de la cita</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="edit_stime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="start_time" class="form-control datetimepicker-input" required data-target="#edit_stime" />
                      <div class="input-group-append" data-target="#edit_stime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Hora de finalización de la cita</label>
                    <span class="text-danger">*</span>
                    <div class="input-group date" id="edit_etime" data-target-input="nearest">
                      <input type="text" autocomplete="off" name="end_time" class="form-control datetimepicker-input" required data-target="#edit_etime" />
                      <div class="input-group-append" data-target="#edit_etime" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Duración de la cita</label>
                    <span class="text-danger">*</span>
                    <select class="form-control" name="select_duration" id="edit_duration" required>
                      <option value="15">15 minutes</option>
                      <option value="20">20 minutes</option>
                      <option value="30">30 minutes</option>
                      <option value="45">45 minutes</option>
                      <option value="60">60 minutes</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="update_sched" class="btn btn-primary submit1">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/edit modal -->

    <!-- delete modal pop up modal -->
    <div class="modal fade" id="deletemodal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar programación</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form action="schedule_action.php" method="POST">
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
              <h1 class="m-0">Horario</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard">Inicio</a></li>
                <li class="breadcrumb-item active">Horario</li>
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
              include('../../message.php');
              ?>
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Lista de horarios</h3>
                  <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#AddScheduleModal">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar horario</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="sched_tbl" class="table table-borderless table-hover" style="width: 100%;">
                    <thead class="bg-light">
                      <tr>
                        <th class="export">Fisioterapeuta</th>
                        <th class="export" data-sort='AAAAMMDD'>Day</th>
                        <th class="export">Hora de inicio</th>
                        <th class="export">Hora de finalización</th>
                        <th class="export">Duration</th>
                        <th width="15%">Acción</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                      <th class="search">Fisioterapeuta</th>
                        <th class="search">Day</th>
                        <th class="search">Hora de inicio</th>
                        <th class="search">Hora de finalización</th>
                        <th class="search">Duration</th>
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

  <?php include('../../includes/scripts.php'); ?>
  <script>
    $(document).ready(function() {
      var table = $('#sched_tbl').DataTable({
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
        "language": {
          'search': '',
          'searchPlaceholder': "Search...",
          'emptyTable': "No results found",
        },
        "ajax": {
          "url": "schedule_table.php",
        },
        "columns": [{
            "data": 'doc_name',
          },
          {
            "data": "day",
            render: function(data, type, row) {

              // var options = { year: 'numeric', month: 'short', day: 'numeric' };
              // var date  = new Date(data);
              return moment(data).format("DD-MMM-YYYY")
              // return  date.toLocaleDateString("en-US", options)
            }
          },
          {
            "data": "starttime"
          },
          {
            "data": "endtime"
          },
          {
            "data": "duration"
          },
          {
            "data": 'id',
            render: function(data, type, row) {
              return '<button data-id="' + data + '" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></button> <input type="hidden" name="del_image" value="' + data + '"><button data-id="' + data + '" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>';
            }
          },
        ],
        "order": [
          [0, 'asc'],
          [1, 'desc'],
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
      $('#sched_tbl tfoot th.search').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
      });
    });

    let getTime = (m) => {
      return m.minutes() + m.hours() * 60;
    }

    $('.submit').on('click', () => {
      let timeFrom = $('input[name=start_time]').val(),
        timeTo = $('input[name=end_time]').val();

      if (!timeFrom || !timeTo) {
        alert('Select time');
        return
      }
      timeFrom = moment(timeFrom, 'hh:mm a');
      timeTo = moment(timeTo, 'hh:mm a');

      if (getTime(timeFrom) >= getTime(timeTo)) {
        alert('Start time must not greater than or equal to End time');
        return false;
      } else {
        return true;
      }
    });
    $('.submit1').on('click', () => {
      let timeFrom = $('#edit_stime').find("input").val(),
        timeTo = $('#edit_etime').find("input").val();

      if (!timeFrom || !timeTo) {
        alert('Select time');
        return
      }

      timeFrom = moment(timeFrom, ["h:mm A"]).format("HH:mm");
      timeTo = moment(timeTo, ["h:mm A"]).format("HH:mm");
      if (timeFrom >= timeTo) {
        alert('Start time must not greater than or equal to End time');
        return false;
      } else {
        return true;
      }
    });

    //MIN DATE TOMMOROW
    var today = new Date();
    var dd = today.getDate() + 1;
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd
    }
    if (mm < 10) {
      mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("select_day_sched").setAttribute("min", today);
    $(document).ready(function() {

      $(".dentist").select2({
        placeholder: "Select Dentist",
        allowClear: true
      });

      var starttime = document.getElementById('starttime');
      var endtime = document.getElementById('endtime');

      $('#scheddate').datepicker({
        startDate: new Date()
      });

      $(starttime).datetimepicker({
        format: 'LT'
      });
      $(endtime).datetimepicker({
        format: 'LT'
      });
      $('#edit_stime').datetimepicker({
        format: 'LT'
      });
      $('#edit_etime').datetimepicker({
        format: 'LT'
      });

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
        var schedid = $(this).data('id');

        $.ajax({
          type: 'post',
          url: "schedule_action.php",
          data: {
            'checking_editbtn': true,
            'sched_id': schedid,
          },
          success: function(response) {
            $.each(response, function(key, value) {
              $('#edit_id').val(value['id']);
              $('#edit_dentist').val(value['doc_id']);
              $('#edit_dentist').select2().trigger('change');
              $("#edit_dentist").select2({
                disabled: 'readonly'
              });
              $('#edit_day').val(value['day']);
              $('#edit_stime').find("input").val(value['starttime']);
              $("#edit_etime").find("input").val(value['endtime']);
              $('#edit_duration').val(value['duration']);
            });

            $('#EditScheduleModal').modal('show');
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
  <?php include('../../includes/footer.php'); ?>