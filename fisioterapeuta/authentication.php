<?php
session_start();
include('../admin/config/dbconn.php');
if(!isset($_SESSION['auth']))
{   
    header('Location: ../login.php');
    exit(0);
}
else if($_SESSION['auth_role'] == "3")
{
    header('Location: ../login.php');
    exit(0);
}
else if($_SESSION['auth_role'] == "patient")
{
    header('Location: ../login.php');
    exit(0);
}
else if($_SESSION['auth_role'] == "admin")
{
    header('Location: ../login.php');
    exit(0);
}
else
{
    
}
?>