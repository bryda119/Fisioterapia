<?php
include('../../authentication.php');
include('../../includes/header.php');
include('../../includes/topbar.php');
include('../../includes/sidebar.php');
include('../../config/dbconn.php');
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
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            include('../../message.php');
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card card-primary card-outline">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            $user_id = $_GET['id'];
                                            $user = "SELECT * FROM tbldoctor WHERE id='$user_id'";
                                            $users_run = mysqli_query($conn, $user);

                                            if (mysqli_num_rows($users_run) > 0) {
                                                foreach ($users_run as $user) {
                                        ?>
                                                    <div class="card-body box-profile">
                                                        <div class="text-center">
                                                            <img class="profile-user-img img-fluid img-circle" src="../../../upload/doctors/<?= $user['image'] ?>" alt="User profile picture">
                                                        </div>
                                                        <h4 class="profile-username text-center"><?= $user['name'] ?></h4>
                                                        <p class="text-muted text-center"><?= $user['specialty'] ?></p>
                                                        <ul class="list-group list-group-unbordered mb-3">
                                                            <li class="list-group-item">
                                                                <b>Gender</b>
                                                                <p class="float-right text-muted m-0"><?= $user['gender'] ?></p>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Birthdate</b>
                                                                <p class="float-right text-muted m-0"><?= $user['dob'] ?></p>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Phone</b>
                                                                <p class="float-right text-muted m-0"><?= $user['phone'] ?></p>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Address</b>
                                                                <p class="float-right text-muted m-0"><?= $user['address'] ?></p>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Degree</b>
                                                                <p class="float-right text-muted m-0"><?= $user['degree'] ?></p>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <b>Email</b>
                                                                <p class="float-right text-muted m-0"><?= $user['email'] ?></p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <!-- /.card-body -->
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-header p-2">
                                            <ul class="nav nav-pills" id="custom-tabs-three-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="appointment-tab" data-toggle="tab" data-target="#appointment" role="tab" aria-controls="appointment" aria-selected="true">Appointment</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="schedule-tab" data-toggle="tab" data-target="#schedule" role="tab" aria-controls="schedule" aria-selected="false">Schedule</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="prescription-tab" data-toggle="tab" data-target="#prescription" role="tab" aria-controls="prescription" aria-selected="false">Prescription</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="treatment-tab" data-toggle="tab" data-target="#treatment" role="tab" aria-controls="treatment" aria-selected="false">Treatment</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                                <div class="tab-pane fade show active" id="appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                                    <!-- Appointment-->
                                                    <table id="appointmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th>Patient</th>
                                                                <th>Date</th>
                                                                <th>Time</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $user_id = $_GET['id'];
                                                                $user = "SELECT CONCAT(p.lname,', ',p.fname) as pname,a.schedule,a.id,a.starttime,a.status,a.endtime FROM tblpatient p INNER JOIN tblappointment a WHERE a.patient_id = p.id AND a.doc_id ='$user_id' ORDER BY a.schedule";
                                                                $users_run = mysqli_query($conn, $user);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $user) {
                                                            ?>

                                                                        <tr>
                                                                            <td><?= $user['pname'] ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($user['schedule'])) ?></td>
                                                                            <td><?= $user['starttime'] . ' - ' . $user['endtime'] ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($user['status'] == 'Treated') {
                                                                                    echo $user['status'] = '<span class="badge badge-primary">Treated</span>';
                                                                                } else if ($user['status'] == 'Confirmed') {
                                                                                    echo $user['status'] = '<span class="badge badge-success">Confirmed</span>';
                                                                                } else if ($user['status'] == 'Pending') {
                                                                                    echo $user['status'] = '<span class="badge badge-warning">Pending</span>';
                                                                                } else if ($user['status'] == 'Cancelled') {
                                                                                    echo $user['status'] = '<span class="badge badge-danger">Cancelled</span>';
                                                                                } else {
                                                                                    echo $user['status'] = '<span class="badge badge-secondary">Reschedule</span>';
                                                                                }

                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                                                    <table id="scheduletable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th class="bg-light">Day</th>
                                                                <th class="bg-light">Start Time</th>
                                                                <th class="bg-light">End Time</th>
                                                                <th class="bg-light">Duration</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $user_id = $_GET['id'];
                                                                $user = "SELECT * FROM schedule WHERE doc_id='$user_id'";
                                                                $users_run = mysqli_query($conn, $user);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $user) {
                                                            ?>

                                                                        <tr>
                                                                            <td><?= date('d-M-Y', strtotime($user['day'])) ?></td>
                                                                            <td><?= $user['starttime'] ?></td>
                                                                            <td><?= $user['endtime'] ?></td>
                                                                            <td><?= $user['duration'] ?></td>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                                                    <table id="prescriptiontable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th class="bg-light">Patient</th>
                                                                <th class="bg-light">Date</th>
                                                                <th class="bg-light">Medicine</th>
                                                                <th class="bg-light">Dose</th>
                                                                <th class="bg-light">Duration</th>
                                                                <th class="bg-light">Advise</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $i = 1;
                                                                $user_id = $_GET['id'];
                                                                $user = "SELECT CONCAT(pat.lname,', ',pat.fname) as pname,pre.date,pre.medicine,pre.advice,pre.dose,pre.duration 
                                                        FROM prescription pre 
                                                        INNER JOIN tblpatient pat 
                                                        WHERE pre.patient_id = pat.id AND pre.doc_id='$user_id'";

                                                                $users_run = mysqli_query($conn, $user);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $user) {
                                                            ?>

                                                                        <tr>
                                                                            <td><?= $user['pname'] ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($user['date'])) ?></td>
                                                                            <td><?= $user['medicine'] ?></td>
                                                                            <td><?= $user['dose'] ?></td>
                                                                            <td><?= $user['duration'] ?></td>
                                                                            <td><?= $user['advice'] ?></td>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="treatment" role="tabpanel" aria-labelledby="treatment-tab">
                                                    <table id="treatmenttable" class="table table-hover table-borderless" style="width:100%;">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th class="bg-light">Patient</th>
                                                                <th class="bg-light">Date Visit</th>
                                                                <th class="bg-light">Treatment</th>
                                                                <th class="bg-light">Teeth No./s</th>
                                                                <th class="bg-light">Description</th>
                                                                <th class="bg-light">Fees</th>
                                                                <th class="bg-light">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($_GET['id'])) {
                                                                $i = 1;
                                                                $user_id = $_GET['id'];
                                                                $user = "SELECT CONCAT(pat.lname,', ',pat.fname) as pname,t.complaint,t.treatment,t.fees,t.teeth,t.remarks,s.day FROM treatment t INNER JOIN tblpatient pat INNER JOIN schedule s ON s.id=t.visit WHERE t.patient_id = pat.id AND t.doc_id='$user_id'";

                                                                $users_run = mysqli_query($conn, $user);

                                                                if (mysqli_num_rows($users_run) > 0) {
                                                                    foreach ($users_run as $user) {
                                                            ?>

                                                                        <tr>
                                                                            <td><?= $user['pname'] ?></td>
                                                                            <td><?= date('d-M-Y', strtotime($user['day'])) ?></td>
                                                                            <td><?= $user['treatment'] ?></td>
                                                                            <td><?= $user['teeth'] ?></td>
                                                                            <td><?= $user['complaint'] ?></td>
                                                                            <td><?= $user['fees'] ?></td>
                                                                            <td><?= $user['remarks'] ?></td>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
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
            </div>
        </div>
    </div>
    <?php include('../../includes/scripts.php'); ?>
    <script>
        $(document).ready(function() {

            var table1 = $('#appointmenttable').DataTable({
                responsive: true,
                searching: true,
                paging: true,
                info: true,
            });
            var table2 = $('#prescriptiontable').DataTable({
                responsive: true,
            });
            var table3 = $('#treatmenttable').DataTable({
                responsive: true,
            });
            var table4 = $('#scheduletable').DataTable({
                responsive: true
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
                if (tabID === '#schedule') {
                    table4.columns.adjust().responsive.recalc();
                }
            });

        });
    </script>
    <?php include('../../includes/footer.php'); ?>