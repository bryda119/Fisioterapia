<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<div class="modal fade" id="ViewPatientModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Información del Paciente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
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
<div class="content-wrapper">
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Paciente</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active">Paciente</li>
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
          </div>
        </div>
      </div>
  </div>
</div>
</div>

<?php include('includes/scripts.php');?>
<script>
    var table = $('#patienttbl').DataTable( {
      "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "processing": true,
      "searching": true,
      "paging": true,
      "responsive":true,
      "pagingType": "simple",
      "autoWidth": false,
      "buttons": [
            {
                extend: 'copyHtml5',
                className: 'btn btn-outline-secondary btn-sm',
                text: '<i class="fas fa-clipboard"></i>  Copiar',
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
                text: '<i class="fas fa-print"></i>  Imprimir',
                exportOptions: {
                    columns: '.export'
                }
            }
        ],
      "order": [[ 1, "asc" ]],
      "language": {
        'search': '',
        'searchPlaceholder': "Buscar...",
        'emptyTable': "No se encontraron resultados",
      },
      "ajax": {
        "url": "patient_table.php",
      },
      "columns": [
        {
          "data": 'image',
          render: function(data, type) {
            return '<img src="../upload/patients/'+ data + '" class="img-thumbnail img-circle" width="50" alt="">';
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
          render: function(data,type,row){
            return moment(data).format("DD-MMM-YYYY")
          }
        },
        { "data": "gender" },
        { "data": "phone" },
        { "data": "email" },
        {
          "data": 'id',
          render: function(data, type,row) {
            return '<a href="patient-details.php?id='+ data +'" class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a>';
          }
        },
      ],
      "initComplete": function () {
        this.api().columns().every( function () {
          var that = this;
          $( 'input', this.footer() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
              that
                .search( this.value )
                .draw();
            }
          });
        });
      },
    });
    $('#patienttbl tfoot th.search').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" class="search-input form-control form-control-sm"/>' );
    } );

    $(document).ready(function () {

      $(document).on('click', '.viewbtn', function() {       
        var userid = $(this).data('id');

        $.ajax({
        url: 'patient_action.php',
        type: 'post',
        data: {userid: userid},
        success: function(response){ 
          
          $('.patient_viewing_data').html(response);
          $('#ViewPatientModal').modal('show'); 
        }
      });
    });

});
</script>

<?php include('includes/footer.php');?>
