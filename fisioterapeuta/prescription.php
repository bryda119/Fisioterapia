<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <div class="modal fade" id="deletemodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar Prescripción</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> 
        <form action="prescription_action.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" id="delete_id">
            <p> ¿Desea eliminar estos datos?</p>                          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="deletedata" class="btn btn-primary">Enviar</button>
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
            <h1>Prescripción</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">Prescripción</li>
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
                  <h3 class="card-title">Lista de Prescripciones</h3>
                    <a href="add-prescription.php" class="btn btn-primary btn-sm float-right">
                    <i class="fa fa-plus"></i> &nbsp;&nbsp;Agregar Prescripción</a>
                </div>
                <div class="card-body">
                  <table id="pres" class="table table-borderless table-hover">
                    <thead class="bg-light">
                      <tr>
                        <th class="export">Paciente</th>
                        <th class="export">Fecha</th>
                        <th class="export">Medicina</th>
                        <th class="export">Dosis</th>
                        <th class="export">Duración</th>
                        <th class="export">Consejo</th>
                        <th width="15%">Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i = 1;
                        $user_id = $_SESSION['auth_user']['user_id'];
                        $sql = "SELECT CONCAT(pat.lname,', ',pat.fname) as pname,
                                  doc.name,
                                  pres.medicine,
                                  pres.advice,
                                  pres.date,
                                  pres.dose,
                                  pres.duration,
                                  pres.id 
                                FROM prescription pres 
                                JOIN tblpatient pat ON pat.id = pres.patient_id 
                                JOIN tbldoctor doc ON doc.id = pres.doc_id 
                                WHERE pres.doc_id='$user_id'";
                                $query_run = mysqli_query($conn, $sql);
                        
                        while($row = mysqli_fetch_array($query_run)){
                      ?>
                        <tr>
                          <td><?php echo $row['pname']; ?></td>
                          <td width="15%"><?php echo date('d-M-Y',strtotime($row['date'])); ?></td>
                          <td><?php echo $row['medicine']; ?></td>
                          <td><?php echo $row['dose']; ?></td>
                          <td><?php echo $row['duration']; ?></td>
                          <td><?php echo $row['advice']; ?></td>
                          <td>
                            <a href="view-prescription.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-secondary viewbtn"><i class="fa fa-eye"></i></a>
                            <a href="edit-prescription.php?id=<?php echo $row['id'];?>" class="btn btn-sm btn-info editbtn"><i class="fas fa-edit"></i></a>
                            <button type="button" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm deletebtn"><i class="far fa-trash-alt"></i></button>
                          </td>
                        </tr>
                        <?php
                        }
                      ?>
                    </tbody>
                    <tfoot>
                        <tr>
                        <th class="search">Fecha</th>
                        <th class="search">Paciente</th>
                        <th class="search">Medicina</th>
                        <th class="search">Dosis</th>
                        <th class="search">Duración</th>
                        <th class="search">Consejo</th>
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
</div>
<?php include('includes/scripts.php');?>
<script>
    $(document).ready(function () {
     $('#pres tfoot th.search').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" class="search-input form-control form-control-sm"/>' );
        } );
     
        // DataTable
        var table = $('#pres').DataTable({
            "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "responsive":true,
            "searching": true,
            "paging": true,
            "buttons": [
            {
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
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        });
    $(document).on('click','.deletebtn', function(){     
      var user_id = $(this).data('id');
      
      $('#delete_id').val(user_id);
      $('#deletemodal').modal('show');
      
      });
});
</script>

<?php include('includes/footer.php');?>