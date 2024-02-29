<?php

include("logics-builder-pdf.php");
include('../admin/config/dbconn.php');

$reportTitle = "Patients Treated";
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

$titlesArr = array('No', 'Date Visit', 'Patient Name', 
'Treatment','Teeth', 'Description','Doctor');

$pdf->SetWidths(array(10, 25, 45, 60, 20, 50, 45));
$pdf->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L', 'L'));
// $pdf->Ln();
// $pdf->Ln();
 $pdf->Ln(15);

$pdf->AddTableHeader($titlesArr);

$sql= "SELECT CONCAT(fname,' ',lname) as fullname, s.day, t.teeth,t.treatment, d.name ,t.complaint
FROM tblpatient p 
INNER JOIN treatment t ON t.patient_id = p.id
INNER JOIN tbldoctor d ON d.id = t.doc_id
LEFT JOIN schedule s ON s.id = t.visit
where t.created_at between '$fromMysql' and '$toMysql'order by t.id asc";
$results = mysqli_query($conn,$sql);
$i = 0;
while($row = mysqli_fetch_assoc($results))
{
        $i++;
        $data = array($i, 
        date('Y-m-d',strtotime($row['day'])),
            $row['fullname'],
            $row['treatment'],
            $row['teeth'],
            $row['complaint'],
            $row['name']
        );

	$pdf->AddRow($data);           
}

$pdf->Output('print-patient-treated.pdf', 'I');
?>