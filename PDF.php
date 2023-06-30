<?php
require('fpdf185/fpdf.php');
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(50);
    // Título
    $this->Cell(70,10,'Reporte de registros',1,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->SetFont('Arial','B',10);
    $this->cell(9,10,'Num',1,0, 'c',0);
    $this->cell(25,10,'Tipo de visita',1,0, 'c',0);
    $this->cell(25,10,'Nombres',1,0, 'c',0);
    $this->cell(30,10,'Apellido Paterno',1,0, 'c',0);
    $this->cell(30,10,'Apellido Materno',1,0, 'c',0);
    $this->cell(25,10,'Sexo',1,0, 'c',0);
    $this->cell(40,10,'Correo Electronico',1,0, 'c',0);
    $this->cell(25,10,'Asistencia',1,0, 'c',0);
    $this->cell(25,10,'Fecha',1,0, 'c',0);
    $this->cell(25,10,'Hora',1,1, 'c',0);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$con = mysqli_connect('localhost', 'root', '', 'eventoDual_2023') or die("ERROR");
/*$consulta = "SELECt * From inscripcion";
$resultado=$mysqli->query($consulta);*/

$consulta = mysqli_query($con, "SELECT * FROM inscripcion");


$pdf = new PDF('L', 'mm', 'legal');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
// Extraer los datos
while ($row=mysqli_fetch_array($consulta)){
    $pdf->cell(9,10,$row['id_inscripcion'],1,0, 'c',0);
    $pdf->cell(25,10,$row['tipoVisitante'],1,0, 'c',0);
    $pdf->cell(25,10,$row['nombres'],1,0, 'c',0);
    $pdf->cell(30,10,$row['apellidoPaterno'],1,0, 'c',0);
    $pdf->cell(30,10,$row['apellidoMaterno'],1,0, 'c',0);
    $pdf->cell(25,10,$row['sexo'],1,0, 'c',0);
    $pdf->cell(40,10,$row['correoElectronico'],1,0, 'c',0);
    $pdf->cell(25,10,$row['asistencia'],1,0, 'c',0);
    $pdf->cell(25,10,$row['fecha'],1,0, 'c',0);
    $pdf->cell(25,10,$row['hora'],1,1, 'c',0);
}

$pdf->Output();
?>