<?php
include('../admin/config/dbconn.php');
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">
      <div class="modal fade" id="CancelModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Cancelar Cita</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>

               <form action="request_action.php" method="POST">
                  <div class="modal-body">
                     <input type="hidden" name="app_id" id="app_id">
                     <p>¿Desea cancelar la cita?</p>
                  </div>

                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                     <button type="submit" name="cancel-appointment" class="btn btn-primary ">Enviar</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="content-wrapper">
         <div class="content-header">

         </div>
         <section class="content">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12">
                     <?php
                     include('../admin/message.php');
                     ?>
                  </div>
                  <div class="col-md-3">
                     <div class="card card-primary card-outline">
                        <div class="card-header">
                           <h5 class="card-title m-0">Información del Paciente</h5>
                        </div>
                        <div class="card-body box-profile">
                           <div class="text-center">
                              <?php
                              if (isset($_SESSION['auth'])) {
                                 $sql = "SELECT * FROM tblpatient WHERE id = '" . $_SESSION['auth_user']['user_id'] . "'";
                                 $query_run = mysqli_query($conn, $sql);
                                 while ($row = mysqli_fetch_array($query_run)) {
                              ?>

                                    <img class="profile-user-img img-fluid img-circle" src="../upload/patients/<?= $row['image'] ?>" alt="Foto de perfil del usuario">
                           </div>
                           <h3 class="profile-username text-center"><?= $row['fname'] . ' ' . $row['lname'] ?></h3>
                           <p class="text-muted text-center"><?= $row['email'] ?></p>
                           <ul class="list-group list-group-unbordered mb-3">
                              <li class="list-group-item">
                                 <b>Género</b>
                                 <p class="float-right text-muted m-0"><?= $row['gender'] ?></p>
                              </li>
                              <li class="list-group-item">
                                 <b>Fecha de Nacimiento</b>
                                 <p class="float-right text-muted m-0"><?= $row['dob'] ?></p>
                              </li>
                              <li class="list-group-item">
                                 <b>Teléfono</b>
                                 <p class="float-right text-muted m-0"><?= $row['phone'] ?></p>
                              </li>
                              <li class="list-group-item">
                                 <b>Dirección</b>
                                 <p class="float-right text-muted m-0"><?= $row['address'] ?></p>
                              </li>
                           </ul>
                     <?php
                                 }
                              } else {
                                 echo "No ha iniciado sesión";
                              }

                     ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-9">
                     <div class="card">
                        <div class="card-header p-2">
                           <ul class="nav nav-pills" id="custom-tabs-three-tab" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link active" href="request-tab" data-toggle="tab" data-target="#request" role="tab" aria-controls="request" aria-selected="true">Solicitar Cita</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="payment-tab" data-toggle="tab" data-target="#payment" role="tab" aria-controls="payment" aria-selected="false">Pagos</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="appointment-tab" data-toggle="tab" data-target="#appointment" role="tab" aria-controls="appointment" aria-selected="false">Citas</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="prescription-tab" data-toggle="tab" data-target="#prescription" role="tab" aria-controls="prescription" aria-selected="false">Prescripción</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="treatment-tab" data-toggle="tab" data-target="#treatment" role="tab" aria-controls="treatment" aria-selected="false">Tratamiento</a>
                              </li>
                           </ul>
                        </div>
                        <div class="card-body">
                           <div class="tab-content" id="custom-tabs-three-tabContent">
                              <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="request-tab">
                                 <div class="row">
                                    <div class="col-sm-12 mb-2">
                                       <a class="btn btn-outline-success float-left" href="request-appointment.php">
                                          <i class="fa fa-plus-circle"> </i> Solicitar una Cita
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-sm-12 mb-2">
                                    <table id="request" class="table table-borderless table-sm" style="width:100%;">
                                       <?php
                                       $id = $_SESSION['auth_user']['user_id'];
                                       $sql = "SELECT * FROM tblappointment WHERE patient_id = '$id' ORDER BY created_at DESC LIMIT 1";
                                       $query_run = mysqli_query($conn, $sql);

                                       while ($row = mysqli_fetch_array($query_run)) {
                                       ?>
                                          <p class="lead text-success">Detalles de su cita</p>
                                          <tr>
                                             <th>Fecha de la Cita</th>
                                             <td><?php echo date('l, d M Y', strtotime($row['schedule'])); ?></td>
                                          </tr>
                                          <tr>
                                             <th>Hora:</th>
                                             <td><?php
                                                   if ($row['starttime'] == '') {
                                                      echo '--';
                                                   } else {
                                                      echo $row['starttime'];
                                                   }
                                                   ?></td>
                                          </tr>
                                          <tr>
                                             <th>Estado:</th>
                                             <td>
                                                <?php
                                                if ($row['status'] == 'Treated') {
                                                   echo $row['status'] = '<span class="badge badge-primary">Tratada</span>';
                                                } else if ($row['status'] == 'Confirmed') {
                                                   echo $row['status'] = '<span class="badge badge-success">Confirmada</span>';
                                                } else if ($row['status'] == 'Pending') {
                                                   echo $row['status'] = '<span class="badge badge-warning">Pendiente</span>';
                                                } else if ($row['status'] == 'Cancelled') {
                                                   echo $row['status'] = '<span class="badge badge-danger">Cancelada</span>';
                                                } else {
                                                   echo $row['status'] = '<span class="badge badge-secondary">Reprogramar</span>';
                                                }

                                                ?>
                                             </td>
                                          </tr>
                                       <?php } ?>
                                    </table>
                                 </div>
                              </div>




                              <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
    <table id="payment-table" class="table table-hover" style="width:100%;">
        <thead>
            <tr>
                <th class="bg-light">Fecha y Hora</th>
                <th class="bg-light">Número de Referencia</th>
                <th class="bg-light">Cantidad</th>
                <th class="bg-light">Número de Transacción</th>
                <th class="bg-light">Método</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_SESSION['auth_user']['user_id'];
            $sql = "SELECT p.created_at, p.ref_id, p.amount, p.txn_id, p.method 
                    FROM payments p 
                    INNER JOIN tblappointment a ON a.id = p.patient_id 
                    WHERE a.patient_id = '$id' 
                    ORDER BY p.id DESC";
            $query_run = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_array($query_run)) {
            ?>
                    <tr>
                        <td><?= date('Y-m-d h:i A', strtotime($row['created_at'])); ?></td>
                        <td><?= $row['ref_id'] ?></td>
                        <td>$ <?= $row['amount'] ?></td>
                        <td><?= $row['txn_id'] ?></td>
                        <td><span class="badge badge-warning"><?= $row['method'] ?></span></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron pagos para este usuario.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>






                              
                              <div class="tab-pane fade" id="appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                 <table id="appointment-table" class="table table-hover" style="width:100%;">
                                    <thead>
                                       <tr>
                                          <th class="bg-light">Fecha</th>
                                          <th class="bg-light">Hora</th>
                                          <th class="bg-light">Doctor</th>
                                          <th class="bg-light">Pago</th>
                                          <th class="bg-light">Estado</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $id = $_SESSION['auth_user']['user_id'];
                                       $sql = "SELECT a.schedule,a.starttime,a.status,a.endtime,a.payment_option,d.name as dname FROM tbldoctor d INNER JOIN tblappointment a WHERE a.doc_id = d.id AND a.patient_id ='$id' ORDER BY a.id DESC";
                                       $query_run = mysqli_query($conn, $sql);
                                       while ($row = mysqli_fetch_array($query_run)) {
                                       ?>
                                          <tr>
                                             <td><?php echo date('F j, Y', strtotime($row['schedule'])); ?></td>
                                             <td><?php echo $row['starttime'] . ' - ' . $row['endtime']; ?></td>
                                             <td><?php echo $row['dname']; ?></td>
                                             <td><span class="badge badge-primary"><?php echo $row['payment_option']; ?></span></td>
                                             <td>
                                                <?php
                                                if ($row['status'] == 'Treated') {
                                                   echo $row['status'] = '<span class="badge badge-primary">Tratada</span>';
                                                } else if ($row['status'] == 'Confirmed') {
                                                   echo $row['status'] = '<span class="badge badge-success">Confirmada</span>';
                                                } else if ($row['status'] == 'Pending') {
                                                   echo $row['status'] = '<span class="badge badge-warning">Pendiente</span>';
                                                } else if ($row['status'] == 'Cancelled') {
                                                   echo $row['status'] = '<span class="badge badge-danger">Cancelada</span>';
                                                } else {
                                                   echo $row['status'] = '<span class="badge badge-secondary">Reprogramar</span>';
                                                }

                                                ?>
                                             </td>

                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                                 <table id="prescription-table" class="table table-hover" style="width:100%;">
                                    <thead>
                                       <tr>
                                          <th class="bg-light">Nombre del Doctor</th>
                                          <th class="bg-light">Fecha</th>
                                          <th class="bg-light">Medicina</th>
                                          <th class="bg-light">Dosis</th>
                                          <th class="bg-light">Duración</th>
                                          <th class="bg-light">Consejo</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $id = $_SESSION['auth_user']['user_id'];
                                       $sql = "SELECT d.name,
                                                            p.date,
                                                            p.dose,
                                                            p.duration,
                                                            p.medicine,
                                                            p.advice,
                                                            p.id 
                                                      FROM tbldoctor d 
                                                      INNER JOIN prescription p 
                                                      ON d.id = p.doc_id 
                                                      WHERE p.patient_id ='$id' ORDER BY p.id DESC";
                                       $query_run = mysqli_query($conn, $sql);
                                       while ($row = mysqli_fetch_array($query_run)) {
                                       ?>
                                          <tr>
                                             <td><?= $row['name'] ?></td>
                                             <td><?= date('F j, Y', strtotime($row['date'])) ?></td>
                                             <td><?= $row['medicine'] ?></td>
                                             <td><?= $row['dose'] ?></td>
                                             <td><?= $row['duration'] ?></td>
                                             <td><?= $row['advice'] ?></td>
                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="tab-pane fade" id="treatment" role="tabpanel" aria-labelledby="treatment-tab">
                                 <table id="treatment-table" class="table table-hover" style="width:100%;">
                                    <thead>
                                       <tr>
                                          <th class="bg-light">Fecha de la Visita</th>
                                          <th class="bg-light">Tratamiento</th>
                                          <th class="bg-light">Diente/s</th>
                                          <th class="bg-light">Descripción</th>
                                          <th class="bg-light">Honorarios</th>
                                          <th class="bg-light">Observaciones</th>
                                          <th class="bg-light">Adjunto</th>
                                          <th class="bg-light">Descargar</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $id = $_SESSION['auth_user']['user_id'];
                                       $sql = "SELECT CONCAT(p.fname,'',p.lname) as pname,t.id,t.teeth,t.complaint,t.treatment,t.fees,t.remarks,t.file_name,s.day FROM treatment t INNER JOIN tblpatient p ON t.patient_id = p.id INNER JOIN schedule s ON s.id = t.visit WHERE patient_id ='$id' ORDER BY id DESC";
                                       $query_run = mysqli_query($conn, $sql);
                                       while ($row = mysqli_fetch_array($query_run)) {
                                       ?>
                                          <tr>
                                             <td><?= date('F j, Y', strtotime($row['day'])); ?></td>
                                             <td><?= $row['treatment'] ?></td>
                                             <td><?= $row['teeth'] ?></td>
                                             <td><?= $row['complaint'] ?></td>
                                             <td><?= $row['fees'] ?></td>
                                             <td><?= $row['remarks'] ?></td>
                                             <?php if (empty($row['file_name'])) {
                                                echo '<td>N/A</td><td>N/A</td>';
                                             } else {
                                                echo '<td><a href="../upload/documents/' . $row['file_name'] . '" target="_blank">Ver</a></td>
<td><a href="../upload/documents/' . $row['file_name'] . '" download>Descargar</a></td>';
                                             }
                                             ?>
                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <!-- /.card -->
                     </div>
                  </div>
                  <!-- /.container-fluid -->
         </section>
         <!-- /.content -->
      </div>
      <?php include('includes/footer.php'); ?>
      <?php include('includes/scripts.php'); ?>
      <script>
         var table1 = $('#appointment-table').DataTable({
            responsive: true,
            searching: false,
            paging: true,
            info: true,
         });
         var table2 = $('#prescription-table').DataTable({
            responsive: true,
            searching: false,
            paging: true,
            info: true,
         });
         var table3 = $('#treatment-table').DataTable({
            responsive: true,
            searching: false,
            paging: true,
            info: true,
         });
         var table4 = $('#payment-table').DataTable({
            responsive: true,
            searching: false,
            paging: true,
            info: true,
         });

         $('.nav-pills a').on('shown.bs.tab', function(event) {
            var tabID = $(event.target).attr('data-target');
            if (tabID === '#appointment') {
               table1.columns.adjust().responsive.recalc();
            }
            if (tabID === '#prescription') {
               table2.columns.adjust().responsive.recalc();
            }
            if (tabID === '#treatment') {
               table3.columns.adjust().responsive.recalc();
            }
            if (tabID === '#payment') {
               table4.columns.adjust().responsive.recalc();
            }
         });

         $(document).on('click', '.cancelbtn', function() {
            var userid = $(this).data('id');
            console.log(userid);
            $('#app_id').val(userid);
            $('#CancelModal').modal('show');
         })
      </script>
