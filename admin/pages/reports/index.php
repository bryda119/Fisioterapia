<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('report_action.php');
include('../../config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <style>
    .card {
      margin-bottom: 20px;
    }
    .btn-generate-pdf {
      width: 100%;
      padding: 10px 15px;
    }
    .date-picker {
      margin-bottom: 15px;
    }
  </style>
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reportes</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard">Inicio</a></li>
                <li class="breadcrumb-item active">Reportes </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <?php include('../../message.php'); ?>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pacientes Registrados</h3>
                </div>
                <div class="card-body">
                  <div class="row date-picker">
                    <?php
                    echo getDateTextBox('Desde', 'patients_from');
                    echo getDateTextBox('Hasta', 'patients_to');
                    ?>
                    <div class="col-md-12">
                      <button type="button" id="print_visits" class="btn btn-success btn-generate-pdf">Generar PDF</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Pacientes Tratados</h3>
                </div>
                <div class="card-body">
                  <div class="row date-picker">
                    <?php
                    echo getDateTextBox('Desde', 'treated_from');
                    echo getDateTextBox('Hasta', 'treated_to');
                    ?>
                    <div class="col-md-12">
                      <button type="button" id="print_treated" class="btn btn-success btn-generate-pdf">Generar PDF</button>
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
  <?php include('../../includes/scripts.php'); ?>
  <script>
    $(document).ready(function() {
      var table = $('#transact-table').DataTable({
        "responsive": true,
        "ordering": false,
        "searching": true,
        "paging": true,
        initComplete: function() {
          var api = this.api();
          $(api.row(':eq(0)').node()).addClass('Highlight');
        }
      });

      $('#patients_from, #patients_to, #treated_from, #treated_to').datetimepicker({
        format: 'L'
      });

      $("#print_visits").click(function() {
        var from = $("#patients_from").val();
        var to = $("#patients_to").val();
        if (from !== '' && to !== '') {
          var win = window.open("print-patient-registered.php?from=" + from + "&to=" + to, "_blank");
          if (win) {
            win.focus();
          } else {
            showCustomMessage('Por favor, permita las ventanas emergentes.');
          }
        }
      });
      $("#print_treated").click(function() {
        var from = $("#treated_from").val();
        var to = $("#treated_to").val();
        if (from !== '' && to !== '') {
          var win = window.open("print-patient-treated.php?from=" + from + "&to=" + to, "_blank");
          if (win) {
            win.focus();
          } else {
            showCustomMessage('Por favor, permita las ventanas emergentes.');
          }
        }
      });
    });
  </script>
  <?php include('../../includes/footer.php'); ?>
