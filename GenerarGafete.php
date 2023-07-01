<?php
require ('fpdf185/fpdf.php');
$info = $_POST['id_inscripcion'];
$serverName = "Localhost";
$connectionInfo = array("Database"=>"eventoDual_2023");
$conn = sqlsrv_connect($serverName, $connectionInfo);

$consulta = "SELECT tipoVisitante, nombres, apellidoPaterno, apellidoMaterno, sexo FROM inscripcion WHERE id_inscripcion = $info";
$sql = sqlsrv_query($conn, $consulta);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('Imagenes/Logo_tese.jpg',165,8,33);
    $this->Image('Imagenes/EdoMex.png',11,8,40);
    // Arial bold 15
    $this->SetFont('Times','B',25);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Evento Dual 2023', 0, 0, 'C');
    // Salto de línea
    $this->Ln(20);
    //$this->Image('Imagenes/Logo_TECHNM.png',30,8,33);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

require 'phpqrcode/qrlib.php';
$directorio = 'Codigo_QR/';

if(!file_exists($directorio)){
    mkdir($directorio);
}
$archivo = $directorio.'QR.png';

$tamanio = 10;
$nivel = 'M';
$dimension = 3;

while($inscripcion=sqlsrv_fetch_array($sql)){
    $tipoVisitante = $inscripcion[0];
    $nombre = $inscripcion[1];
    $apellidoP = $inscripcion[2];
    $apellidoM = $inscripcion[3];
    $sexo = $inscripcion[4];
}

$informacion = 'FOLIO: '.$info.'
        NOMBRE(S): '.$nombre .'
        APELLIDO PATERNO: '.$apellidoP. '
        APELLIDO MATERNO: '.$apellidoM. '
        SEXO: '.$sexo.' 
        VISITANTE: '. $tipoVisitante;
        QRcode::png($informacion, $archivo, $nivel, $tamanio, $dimension);

$consulta_2 = "SELECT tipoVisitante, nombres, apellidoPaterno, apellidoMaterno FROM inscripcion WHERE id_inscripcion = $info";
$sql_2 = sqlsrv_query($conn, $consulta_2);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(42, 228, 149);
$pdf->SetFont('Arial','',15);
$pdf->cell(85, 25, "Evento Dual 2023", 1, 0, 'C', 1);
$pdf->Ln();
while($inscripcion_2 = sqlsrv_fetch_array($sql_2)){
    $pdf->SetFillColor(42, 228, 149);
    $pdf->Image('Imagenes/Logo_TECNM.png',11, 30, 20); //(x, y, tamaño)
    $pdf->Image('Imagenes/Logo_tese.jpg',75, 30, 20);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',13);
    $pdf->cell(85, 30, $inscripcion_2[1]." ".$inscripcion_2[2]." ".$inscripcion_2[3], 1, 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','',13);
    $pdf->cell(85, 30, "Junio 2023", 1, 0, 'R', 1);
    $pdf->Image('Codigo_QR/QR.png',11, 85, 30);
    $pdf->Ln();

    $pdf->SetFillColor(175, 34, 34);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',25);
    
    $pdf->cell(85, 20, $inscripcion_2[0], 1, 0, 'C', 1);
}
$pdf->Output();
?>
