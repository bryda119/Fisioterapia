<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');

// Consulta SQL para obtener los montos de los pagos
$sql = "SELECT a.patient_name, p.amount, DATE(p.created_at) AS payment_date FROM payments p INNER JOIN tblappointment a ON a.id = p.patient_id";
$result = mysqli_query($conn, $sql);

// Inicializar arrays para almacenar los montos de los pagos por día, semana, mes y año
$paymentAmountsDaily = array();
$paymentAmountsWeekly = array();
$paymentAmountsMonthly = array();
$paymentAmountsYearly = array();

// Obtener la fecha actual
$currentDate = date('Y-m-d');

// Iterar sobre los resultados y almacenar los montos en los arrays correspondientes
while ($row = mysqli_fetch_assoc($result)) {
    $paymentDate = $row['payment_date'];
    $paymentAmount = $row['amount'];

    // Calcula la diferencia en días entre la fecha actual y la fecha del pago
    $daysDifference = floor((strtotime($currentDate) - strtotime($paymentDate)) / (60 * 60 * 24));

    // Almacena los montos de los pagos diarios
    $paymentAmountsDaily[$paymentDate] = isset($paymentAmountsDaily[$paymentDate]) ? $paymentAmountsDaily[$paymentDate] + $paymentAmount : $paymentAmount;

    // Almacena los montos de los pagos semanales
    if ($daysDifference <= 7) {
        $paymentAmountsWeekly[$paymentDate] = isset($paymentAmountsWeekly[$paymentDate]) ? $paymentAmountsWeekly[$paymentDate] + $paymentAmount : $paymentAmount;
    }

    // Almacena los montos de los pagos mensuales
    if (date('Y-m', strtotime($currentDate)) == date('Y-m', strtotime($paymentDate))) {
        $paymentAmountsMonthly[$paymentDate] = isset($paymentAmountsMonthly[$paymentDate]) ? $paymentAmountsMonthly[$paymentDate] + $paymentAmount : $paymentAmount;
    }

    // Almacena los montos de los pagos anuales
    if (date('Y', strtotime($currentDate)) == date('Y', strtotime($paymentDate))) {
        $paymentAmountsYearly[$paymentDate] = isset($paymentAmountsYearly[$paymentDate]) ? $paymentAmountsYearly[$paymentDate] + $paymentAmount : $paymentAmount;
    }
}

// Convertir los arrays a formato JSON para pasar los datos al gráfico
$paymentDataDaily = json_encode($paymentAmountsDaily);
$paymentDataWeekly = json_encode($paymentAmountsWeekly);
$paymentDataMonthly = json_encode($paymentAmountsMonthly);
$paymentDataYearly = json_encode($paymentAmountsYearly);

?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Pagos</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Pagos</li>
                            </ol>
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!--/.content-header-->

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php include('../../message.php'); ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Lista de Pagos</h3>
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#AddPaymentModal">Agregar Pago</button>
                                    <button type="button" class="btn btn-success float-right mr-2" data-toggle="modal" data-target="#ImportDataModal">Importar Datos</button>
                                </div>
                                <div class="card-body">
                                    <!-- Payment List Table -->
                                    <table id="payment-table" class="table table-striped table-hover" style="width:100%">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="export">Paciente</th>
                                                <th class="export">Fecha y Hora</th>
                                                <th class="export">Número de Referencia</th>
                                                <th class="export">Monto</th>
                                                <th class="export">Estado</th>
                                                <th class="export">Método</th>
                                                <th class="export">ID de Transacción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PHP loop for displaying payment data -->
                                            <?php
                                            $sql = "SELECT a.patient_name, p.payment_status, p.created_at, p.ref_id, p.amount, p.method, p.txn_id FROM payments p INNER JOIN tblappointment a ON a.id = p.patient_id ORDER BY p.id DESC";
                                            $query_run = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                while ($row = mysqli_fetch_assoc($query_run)) {
                                            ?>
                                                    <tr>
                                                        <td><?= $row['patient_name']; ?></td>
                                                        <td><?= date('Y-m-d h:i A', strtotime($row['created_at'])); ?></td>
                                                        <td><?= $row['ref_id'] ?></td>
                                                        <td>$ <?= $row['amount'] ?></td>
                                                        <td><?= $row['payment_status'] ?></td>
                                                        <td><span class="badge badge-warning"><?= $row['method'] ?></span></td>
                                                        <td><?= $row['txn_id'] ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No hay pagos disponibles</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="search">Paciente</th>
                                                <th class="search">Fecha y Hora</th>
                                                <th class="search">Número de Referencia</th>
                                                <th class="search">Monto</th>
                                                <th class="search">Estado</th>
                                                <th class="search">Método</th>
                                                <th class="search">ID de Transacción</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!-- End of Payment List Table -->
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Tabla de Pagos</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="paymentChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div> <!-- /.container -->
        </div> <!-- /.content-wrapper -->

    </div>
    <!-- Add Payment Modal -->
    <div class="modal fade" id="AddPaymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Pago</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Payment Form -->
                <form id="paymentForm" action="payment_action.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <!-- Patient Name -->
                        <div class="form-group">
                            <label for="patientSearch">Buscar Paciente</label>
                            <input type="text" id="patientSearch" class="form-control" placeholder="Ingrese el nombre del paciente">
                            <div id="patientList"></div> <!-- Aquí se mostrarán los resultados de la búsqueda -->
                            <input type="hidden" id="selectedPatientId" name="patient_id"> <!-- Campo oculto para almacenar el ID del paciente seleccionado -->
                        </div>

                        <!-- Date and Time -->
                        <div class="form-group">
                            <label>Fecha y Hora</label>
                            <input type="datetime-local" name="payment_datetime" class="form-control" required>
                        </div>
                        <!-- Reference Number -->
                        <div class="form-group">
                            <label>Número de Referencia</label>
                            <input type="text" name="ref_id" class="form-control" required>
                        </div>
                        <!-- Amount -->
                        <div class="form-group">
                            <label>Monto</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <!-- Payment Status -->
                        <div class="form-group">
                            <label>Estado del Pago</label>
                            <select id="paymentStatus" class="form-control" name="payment_status" required>
                                <option value="">Seleccione un estado de pago</option>
                                <option value="Pending">Pendiente</option>
                                <option value="Paid">Pagado</option>
                                <option value="Failed">Fallido</option>
                            </select>
                        </div>
                        <!-- Payment Method -->
                        <div class="form-group">
                            <label>Método de Pago</label>
                            <select class="form-control" name="payment_method" required>
                                <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                            </select>
                        </div>
                        <!-- Transaction ID -->
                        <div class="form-group">
                            <label>ID de Transacción</label>
                            <input type="text" name="transaction_id" class="form-control">
                        </div>
                        <!-- Payer ID -->
                        <input type="hidden" name="payer_id">
                        <!-- App ID -->
                        <input type="hidden" name="app_id">
                        <!-- Currency -->
                        <input type="hidden" name="currency">
                        <!-- Payer Email -->
                        <input type="hidden" name="payer_email">
                        <!-- First Name -->
                        <input type="hidden" name="first_name">
                        <!-- Last Name -->
                        <input type="hidden" name="last_name">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" name="insertpayment" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
                <!-- End of Payment Form -->
            </div>
        </div>
    </div>
    <!-- End of Add Payment Modal -->

    <!-- Import Data Modal -->
<div class="modal fade" id="ImportDataModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Importar Datos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Import Data Form -->
            <form id="importDataForm" action="payment_action.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Subir archivo</label>
                                <span class="text-danger">*</span>
                                <input type="file" name="importFile" class="form-control" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h6 class="font-weight-bold text-primary">
                                <a href="../../../upload/Payment.csv" download>Haga clic aquí para descargar el archivo de muestra</a>
                            </h6>
                            <h6 class="font-weight-bold">El siguiente campo es obligatorio en el archivo csv</h6>
                            <ul>
                                <li>Patien</li>
                                <li>Date & Time</li>
                                <li>Reference No.</li>
                                <li>Amount</li>
                                <li>Status</li>
                                <li>Method</li>
                                <li>Transaction ID</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="importSubmit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- End of Import Data Form -->
        </div>
    </div>
</div>
<!-- End of Import Data Modal -->

<!-- End of Import Data Form -->

        </div>
    </div>
</div>
<!-- End of Import Data Modal -->


<?php include('../../includes/scripts.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para el gráfico de pagos
    var paymentDataDaily = <?php echo $paymentDataDaily; ?>;
    var paymentDataWeekly = <?php echo $paymentDataWeekly; ?>;
    var paymentDataMonthly = <?php echo $paymentDataMonthly; ?>;
    var paymentDataYearly = <?php echo $paymentDataYearly; ?>;
    
    // Configuración inicial del gráfico
    var ctx = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(paymentDataDaily), // Utiliza fechas como etiquetas por defecto
            datasets: [{
                label: 'Diario',
                data: Object.values(paymentDataDaily),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                hidden: false // Visible por defecto
            },
            {
                label: 'Semanal',
                data: Object.values(paymentDataWeekly),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                hidden: true // Oculto por defecto
            },
            {
                label: 'Mensual',
                data: Object.values(paymentDataMonthly),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                hidden: true // Oculto por defecto
            },
            {
                label: 'Anual',
                data: Object.values(paymentDataYearly),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                hidden: true // Oculto por defecto
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Función para cambiar el tipo de datos mostrados en el gráfico
    function changeChartData(chartType) {
        if (chartType === 'daily') {
            paymentChart.data.datasets[0].hidden = false;
            paymentChart.data.datasets[1].hidden = true;
            paymentChart.data.datasets[2].hidden = true;
            paymentChart.data.datasets[3].hidden = true;
        } else if (chartType === 'weekly') {
            paymentChart.data.datasets[0].hidden = true;
            paymentChart.data.datasets[1].hidden = false;
            paymentChart.data.datasets[2].hidden = true;
            paymentChart.data.datasets[3].hidden = true;
        } else if (chartType === 'monthly') {
            paymentChart.data.datasets[0].hidden = true;
            paymentChart.data.datasets[1].hidden = true;
            paymentChart.data.datasets[2].hidden = false;
            paymentChart.data.datasets[3].hidden = true;
        } else if (chartType === 'yearly') {
            paymentChart.data.datasets[0].hidden = true;
            paymentChart.data.datasets[1].hidden = true;
            paymentChart.data.datasets[2].hidden = true;
            paymentChart.data.datasets[3].hidden = false;
        }
        paymentChart.update(); // Actualizar el gráfico
    }
</script>



    <script>
        $(document).ready(function() {
            $('#payment-table tfoot th.search').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" class="search-input form-control form-control-sm"/>');
            });
            var table = $('#payment-table').DataTable({
                "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "responsive": true,
                "ordering": false,
                "searching": true,
                "paging": true,
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
                initComplete: function() {
                    // Apply the search
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
                }
            });

        });
    </script>
    <script>
        // Agrega un controlador de evento para el envío del formulario
        $('#paymentForm').submit(function(event) {
            // Obtiene el valor del estado del pago seleccionado
            var paymentStatus = $('#paymentStatus').val();

            // Verifica si se ha seleccionado un estado de pago válido
            if (paymentStatus === '') {
                // Si no se ha seleccionado un estado de pago, muestra un mensaje de error
                alert('Por favor, seleccione un estado de pago.');
                // Evita que el formulario se envíe
                event.preventDefault();
            }
        });

        $('#patientSearch').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: 'search_patient.php',
                    method: 'POST',
                    data: {query: query},
                    success: function(data) {
                        $('#patientList').fadeIn();
                        $('#patientList').html(data);
                    }
                });
            }
        });

        // Cuando se hace clic en un resultado de búsqueda, se inserta el nombre del paciente en el campo y se almacena su ID
        $(document).on('click', 'li', function() {
            var patientName = $(this).text();
            var patientId = $(this).attr('data-patient-id');
            $('#patientSearch').val(patientName);
            $('#selectedPatientId').val(patientId); // Aquí asignamos el ID del paciente al campo oculto
            $('#patientList').fadeOut();
        });
    </script>
</body>
</html>