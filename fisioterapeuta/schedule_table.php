<?php

    include('../admin/config/dbconn.php');

    $doctor_id = $_POST['doctor_id'];

    $table = 'schedule';
    $primaryKey = 'id';
    
    $columns = array(
        array( 'db' => 'day',  'dt' => 'day' ),
        array( 'db' => 'starttime',  'dt' => 'starttime' ),
        array( 'db' => 'endtime',   'dt' => 'endtime' ),
        array( 'db' => 'duration',   'dt' => 'duration' ),
        array( 'db' => 'id',   'dt' => 'id' ),
    );
    
    require( '../admin/config/sspconn.php' );
    
    require( 'ssp.class.php' );
    $where = "doc_id ='".$doctor_id."'";
    echo json_encode(
        SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
    );

?>