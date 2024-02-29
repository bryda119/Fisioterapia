<?php

    include('../admin/config/dbconn.php');

    $table = 'tblpatient';
    $primaryKey = 'id';
    
    $columns = array(
        array( 'db' => 'image', 'dt' => 'image' ),
        array( 'db' => 'fname',  'dt' => 'fname' ),
        array( 'db' => 'lname',  'dt' => 'lname' ),
        array( 'db' => 'dob',  'dt' => 'dob' ),
        array( 'db' => 'gender',  'dt' => 'gender' ),
        array( 'db' => 'phone',   'dt' => 'phone' ),
        array( 'db' => 'email',  'dt' => 'email' ),
        array( 'db' => 'id',   'dt' => 'id' ),
    );
    
    require( '../admin/config/sspconn.php' );
    
    require( 'ssp.class.php' );
    
    echo json_encode(
        SSP::complex( $_POST, $sql_details, $table, $primaryKey, $columns)
    );

?>