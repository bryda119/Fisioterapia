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
                <section class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Payments</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Payments</li>
                            </ol>
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </section><!-- /.container-fluid -->
            </div>
            <!--/.content-header-->


            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('message.php');
                            ?>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Payment List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="payment-table" class="table table-borderless table-hover" style="width:100%">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="export">Patient</th>
                                                <th class="export">Date & Time</th>
                                                <th class="export">Reference No.</th>
                                                <th class="export">Amount</th>
                                                <th class="export">Status</th>
                                                <th class="export">Method</th>
                                                <th class="export">Transaction ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
                                                <th class="search">Patient</th>
                                                <th class="search">Date $ Time</th>
                                                <th class="search">Reference No</th>
                                                <th class="search">Amount</th>
                                                <th class="search">Status</th>
                                                <th class="search">Method</th>
                                                <th class="search">Transaction ID</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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

    <?php include('includes/footer.php'); ?>