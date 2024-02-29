<?php

include('../admin/config/dbconn.php');

$status = $_POST['status'];
$table = <<<EOT
    (
        SELECT
            a.patient_id,
            a.patient_name,
            a.created_at,
            a.schedule,
            a.starttime,
            a.endtime,
            a.status,
            p.payment_status,
            a.id
        FROM tblappointment a 
        LEFT JOIN payments p ON a.id = p.app_id
        WHERE a.schedtype ='Online Schedule' AND a.status LIKE '$status'
    ) temp
    EOT;
$primaryKey = 'id';

$columns = array(
    array('db' => 'patient_id', 'dt' => 'patient_id'),
    array('db' => 'patient_name', 'dt' => 'patient_name'),
    array('db' => 'created_at',  'dt' => 'created_at'),
    array('db' => 'schedule',   'dt' => 'schedule'),
    array('db' => 'starttime',  'dt' => 'starttime'),
    array('db' => 'endtime',   'dt' => 'endtime'),
    array('db' => 'status',   'dt' => 'status'),
    array('db' => 'payment_status',   'dt' => 'payment_status'),
    array('db' => 'id',   'dt' => 'id'),
);

require('../admin/config/sspconn.php');

require('ssp.class.php');
echo json_encode(
    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns)
);
