<?php

require('logics-builder-pdf.php');
require('../../config/dbconn.php');

$reportTitle = "Pacientes Registrados";
$from = $_GET['from'];
$to = $_GET['to'];

$fromArr = explode("/", $from);
$toArr = explode("/", $to);

$fromMysql = $fromArr[2] . '-' . $fromArr[0] . '-' . $fromArr[1];
$toMysql = $toArr[2] . '-' . $toArr[0] . '-' . $toArr[1];

$pdf = new CustomPDF('L', false, $reportTitle, $from, $to);
$pdf->SetMargins(15, 10);
$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 12); // Cambio de fuente a Times New Roman
$pdf->AddPage();

$titlesArr = array(
    'No', 'Fecha de Registro', 'Nombre del Paciente',
    'Direccion', 'Fecha de Nacimiento', 'Genero', 'Contacto', 'Correo Electronico'
);

$pdf->SetWidths(array(10, 25, 45, 60, 25, 20, 35, 45));
$pdf->SetAligns(array('C', 'L', 'L', 'L', 'L', 'L', 'L', 'L'));
$pdf->Ln(15);

$pdf->AddTableHeader($titlesArr);

$sql = "SELECT CONCAT(fname,' ',lname) as fullname,created_at,address,dob,gender,phone,email FROM tblpatient
where created_at between '$fromMysql' and '$toMysql' order by id asc";
$results = mysqli_query($conn, $sql);
$i = 0;
while ($row = mysqli_fetch_assoc($results)) {
    $i++;
    $data = array(
        $i,
        date('Y-m-d', strtotime($row['created_at'])),
        $row['fullname'],
        $row['address'],
        $row['dob'],
        $row['gender'],
        $row['phone'],
        $row['email']
    );

    $pdf->AddRow($data);
}

$pdf->Output('../../print-patient-registered.pdf', 'I');
?>
