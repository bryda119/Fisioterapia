<?php

include('../../config/dbconn.php');

$table = 'schedule';
$primaryKey = 'id';

$columns = array(
    array('db' => 'doc_name', 'dt' => 'doc_name'),
    array('db' => 'day',  'dt' => 'day'),
    array('db' => 'starttime',  'dt' => 'starttime'),
    array('db' => 'endtime',   'dt' => 'endtime'),
    array('db' => 'duration',   'dt' => 'duration'),
    array('db' => 'id',   'dt' => 'id'),
);

require('../../config/sspconn.php');

require('../../ssp.class.php');

echo json_encode(
    SSP::complex($_POST, $sql_details, $table, $primaryKey, $columns)
);
