<?php

    include('../../config/dbconn.php');

    $status = $_POST['status'];
    $table = 'tblappointment';
    $primaryKey = 'id';

    $columns = array(
        array( 'db' => 'patient_name', 'dt' => 'patient_name' ),
        array( 'db' => 'created_at',  'dt' => 'created_at' ),
        array( 'db' => 'schedule',   'dt' => 'schedule' ),
        array( 'db' => 'starttime',  'dt' => 'starttime' ),
        array( 'db' => 'endtime',   'dt' => 'endtime' ),
        array( 'db' => 'status',   'dt' => 'status' ),
        array( 'db' => 'id',   'dt' => 'id' ),
    );
    
    require('../../config/sspconn.php');

    require('../../ssp.class.php');
    $where = "schedtype ='Walk-in Schedule' AND status LIKE '$status'";
    echo json_encode(
        SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
    );
