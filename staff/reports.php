<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('report_action.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<style>
    .table#transact-table.dataTable tbody tr.Highlight {
        background-color: #74b9ff;
        color:#fff;
    }
</style>
<div class="wrapper">

<div class="content-wrapper">
    <div class="content-header">
        <section class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Reports</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Reports </li>
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
                    <h3 class="card-title">Patient Registered</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php 
                    echo getDateTextBox('From', 'patients_from');

                    echo getDateTextBox('To', 'patients_to');
                    ?>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="button" id="print_visits" class="btn btn-success btn-sm btn-flat btn-block">Generate  PDF</button>
                    </div>
                </div>
              </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Patient Treated</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php 
                    echo getDateTextBox('From', 'treated_from');

                    echo getDateTextBox('To', 'treated_to');
                    ?>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="button" id="print_treated" class="btn btn-success btn-sm btn-flat btn-block">Generate  PDF</button>
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

<?php include('includes/scripts.php');?>
<script>
    $(document).ready(function () {
      var table = $('#transact-table').DataTable({
            "responsive":true,
            "ordering":false,
            "searching": true,
            "paging": true,

            initComplete: function () {
                // Apply the search
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
          
          if(from !== '' && to !== '') {
            var win = window.open("print-patient-registered.php?from=" + from 
              +"&to=" + to, "_blank");
            if(win) {
              win.focus();
            } else {
              showCustomMessage('Please allow popups.');
            }
          }
        });
        $("#print_treated").click(function() {
          var from = $("#treated_from").val();
          var to = $("#treated_to").val();
          
          if(from !== '' && to !== '') {
            var win = window.open("print-patient-treated.php?from=" + from 
              +"&to=" + to, "_blank");
            if(win) {
              win.focus();
            } else {
              showCustomMessage('Please allow popups.');
            }
          }
        });

});

</script>

<?php include('includes/footer.php');?>