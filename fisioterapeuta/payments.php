<?php
include('authentication.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('../admin/config/dbconn.php');
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
                            <h1>Payments</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Payments</li>
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
                            <?php include('message.php'); ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Payment List</h3>
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
    <?php include('includes/scripts.php'); ?>
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

    <?php include('includes/footer.php'); ?>