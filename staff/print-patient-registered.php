<?php

include("logics-builder-pdf.php");
include('../admin/config/dbconn.php');

$reportTitle = "Patients Registered";
$from = $_GET['from'];
$to = $_GET['to'];

$fromArr = explode("/", $from);
$toArr = explode("/", $to);

$fromMysql = $fromArr[2].'-'.$fromArr[0].'-'.$fromArr[1];
$toMysql = $toArr[2].'-'.$toArr[0].'-'.$toArr[1];

$pdf = new LB_PDF('L', false, $reportTitle, $from, $to);
$pdf->SetMargins(15, 10);
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();

$titlesArr = array('No', 'Date Registered', 'Patient Name', 
'Address','DOB','Gender','Contact','Email');

$pdf->SetWidths(array(10, 25, 45, 60, 25, 20, 35, 45));
$pdf->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L', 'L', 'L'));
// $pdf->Ln();
// $pdf->Ln();
 $pdf->Ln(15);

$pdf->AddTableHeader($titlesArr);

$sql= "SELECT CONCAT(fname,' ',lname) as fullname,created_at,address,dob,gender,phone,email FROM tblpatient
where created_at between '$fromMysql' and '$toMysql' order by id asc";
$results = mysqli_query($conn,$sql);
$i = 0;
while($row = mysqli_fetch_assoc($results))
{
        $i++;
        $data = array($i, 
        date('Y-m-d',strtotime($row['created_at'])),
            $row['fullname'],
            $row['address'],
            $row['dob'],
            $row['gender'],
            $row['phone'],
            $row['email']        );

	$pdf->AddRow($data);           
}

$pdf->Output('print-patient-registered.pdf', 'I');
?>