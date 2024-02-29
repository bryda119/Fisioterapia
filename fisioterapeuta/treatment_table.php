<?php
include('../admin/config/dbconn.php');
$id = $_GET["doc_id"];

$table = <<<EOT
        (
            SELECT 
                p.fname,
                p.lname,
                s.day,
                t.teeth,
                t.treatment,
                t.file_name,
                t.complaint,
                t.fees,
                t.remarks,
                t.id 
            FROM treatment t 
            INNER JOIN tblpatient p ON t.patient_id = p.id
            INNER JOIN schedule s ON s.id = t.visit
            WHERE t.doc_id='$id'
        ) temp
        EOT;


$primaryKey = 'id';



$columns = array(
    array('db' => 'fname', 'dt' => 'fname'),
    array('db' => 'lname', 'dt' => 'lname'),
    array('db' => 'day',  'dt' => 'day'),
    array('db' => 'treatment',  'dt' => 'treatment'),
    array('db' => 'teeth',  'dt' => 'teeth'),
    array('db' => 'complaint',  'dt' => 'complaint'),
    array('db' => 'fees',  'dt' => 'fees'),
    array('db' => 'remarks',   'dt' => 'remarks'),
    array('db' => 'file_name',   'dt' => 'attachment'),
    array('db' => 'file_name',   'dt' => 'download'),
    array('db' => 'id',   'dt' => 'id'),
);

require('../admin/config/sspconn.php');

require('ssp2.class.php');
$where = "t.doc_id='$id'";

echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
);
