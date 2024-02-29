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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="invoice p-3 mb-3" id="prescription">
                <h2 class="text-center text-uppercase font-weight-bold text-primary mb-4"><?= $system_name ?></h2>
                <div class="row">
                  <div class="col-md-9">
                    <address class="text-left text-dark">
                      <p><strong>Dirección:</strong> <?= $address ?></p>
                      <p><strong>Teléfono:</strong> <?= $telno ?></p>
                      <p><strong>Celular:</strong> <?= $mobile ?></p>
                      <p><strong>Email:</strong> <?= $email ?></p>
                    </address>
                  </div>
                  <div class="col-md-3 d-flex justify-content-end">
                    <img src="../upload/<?= $system_logo ?>" height="130" alt="Logo">
                  </div>
                </div>
                <hr style="border-top: 3px solid black;">
                <?php
                if (isset($_GET['id'])) {
                  $user_id = $_GET['id'];
                  $user = "SELECT pres.*, CONCAT(p.fname,' ',p.lname) AS pname, p.gender, p.address, p.dob, d.name AS doctor_name,
                  DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),STR_TO_DATE(p.dob, '%c/%e/%Y'))), '%Y')+0 AS Age 
                  FROM prescription pres 
                  INNER JOIN tblpatient p ON p.id = pres.patient_id 
                  INNER JOIN tbldoctor d ON d.id = pres.doc_id 
                  WHERE pres.id='$user_id' LIMIT 1";
                  $users_run = mysqli_query($conn, $user);

                  if (mysqli_num_rows($users_run) > 0) {
                    foreach ($users_run as $user) {
                ?>
                      <div class="row mb-4">
                        <div class="col-md-12 text-center">
                          <h4 class="text-uppercase font-weight-bold">Datos del Paciente</h4>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <div class="col-md-4">
                          <p><strong>Nombre:</strong> <?= $user['pname']; ?></p>
                        </div>
                        <div class="col-md-8">
                          <p><strong>Dirección:</strong> <?= $user['address']; ?></p>
                        </div>
                      </div>
                      <hr style="border-top: 3px solid black;">
                      <div class="row mb-2">
                        <div class="col-md-3">
                          <p><strong>Género:</strong> <?= $user['gender']; ?></p>
                        </div>
                        <div class="col-md-3">
                          <p><strong>Edad:</strong> <?= $user['Age']; ?> años</p>
                        </div>
                        <div class="col-md-3">
                            <?php
                            // Obtenemos la fecha de nacimiento del usuario
                            $dob = $user['dob'];
                            
                            // Convertimos la fecha de la base de datos al formato español manualmente
                            $meses = array(
                                'January' => 'enero',
                                'February' => 'febrero',
                                'March' => 'marzo',
                                'April' => 'abril',
                                'May' => 'mayo',
                                'June' => 'junio',
                                'July' => 'julio',
                                'August' => 'agosto',
                                'September' => 'septiembre',
                                'October' => 'octubre',
                                'November' => 'noviembre',
                                'December' => 'diciembre'
                            );
                            
                            // Formateamos la fecha en español
                            $fecha_nacimiento = date('j', strtotime($dob)) . ' de ' . $meses[date('F', strtotime($dob))] . ' de ' . date('Y', strtotime($dob));
                            ?>
                            <p><strong>Fecha de Nacimiento:</strong> <br> <?= $fecha_nacimiento; ?></p>
                        </div>
                        <div class="col-md-3">
                          <p><strong>Médico:</strong> <?= $user['doctor_name']; ?></p>
                        </div>
                      </div>
                      <hr style="border-top: 3px solid black;">
                      <div class="row mb-4">
                        <div class="col-md-12 text-center">
                          <h4 class="text-uppercase font-weight-bold">Prescripción Médica</h4>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <img src="assets/dist/img/prescriptionLogo.png" height="70" alt="">
                          <div class="table-responsive">
                            <table class="table table-borderless">
                              <tbody>
                                <tr>
                                  <td>
                                    <strong>Medicamento:</strong> 
                                    <br>
                                    <?= $user['medicine'] ?>
                                    <br>
                                    <strong>Indicación:</strong> 
                                    <br>
                                    Dosis: <?= $user['dose'] ?><br>
                                    Duración: <?= $user['duration'] ?>
                                    <br>
                                    <strong>Consejo:</strong>
                                    <br>
                                    <?= $user['advice'] ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-md-12 text-center">
                          <p><strong>Firma</strong></p>
                          <p><strong>Número de Licencia:</strong></p>
                          <p><strong>Número PTR:</strong></p>
                        </div>
                      </div>
                      <div class="row no-print mt-4">
                        <div class="col-md-4 offset-md-4">
                          <a href="print-prescription.php?id=<?= $user['id'] ?>" rel="noopener" target="_blank" class="btn btn-default btn-block"><i class="fas fa-print"></i> Imprimir</a>
                        </div>
                      </div>
                <?php
                    }
                  } else {
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>