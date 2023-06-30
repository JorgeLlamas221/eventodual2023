<?php
require ('fpdf185/fpdf.php');
$nombreHost = 'localhost';
$nombreUsuario = 'root';
$pwd = '';
$nombreBD = 'eventoDual_2023';
$info = $_POST['id_trabajador'];

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

$conector1 = mysqli_connect($nombreHost, $nombreUsuario, $pwd, $nombreBD) or die ("Error De Conexion!!!" );
$select1 = mysqli_query($conector1, "SELECT tipoVisitante, nombres, apellidoPaterno, apellidoMaterno, sexo  FROM inscripcion WHERE id_inscripcion = $info");

require 'phpqrcode/qrlib.php';
$directorio = 'Codigo_QR/';

if(!file_exists($directorio)){
    mkdir($directorio);
}
$archivo = $directorio.'QR.png';

$tamanio = 10;
$nivel = 'M';
$dimension = 3;

while($res1 = mysqli_fetch_array($select1)){
        $tipoVisitante = $res1["tipoVisitante"];
        $nombre = $res1["nombres"];
        $apellidoP = $res1["apellidoPaterno"];
        $apellidoM = $res1["apellidoMaterno"];
        $sexo = $res1["sexo"];
}

$informacion = 'FOLIO: '.$info.'
        NOMBRE(S): '.$nombre .'
        APELLIDO PATERNO: '.$apellidoP. '
        APELLIDO MATERNO: '.$apellidoM. '
        SEXO: '.$sexo.' 
        VISITANTE: '. $tipoVisitante;
        QRcode::png($informacion, $archivo, $nivel, $tamanio, $dimension);

$conector2 = mysqli_connect($nombreHost, $nombreUsuario, $pwd, $nombreBD) or die ("Error De Conexion!!!" );
$select2 = mysqli_query($conector2, "SELECT tipoVisitante, nombres, apellidoPaterno, apellidoMaterno, sexo  from inscripcion where id_inscripcion = $info");

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(42, 228, 149);
$pdf->SetFont('Arial','',15);
$pdf->cell(85, 25, "Evento Dual 2023", 1, 0, 'C', 1);
$pdf->Ln();
while($res2 = mysqli_fetch_array($select2)){
    $pdf->SetFillColor(42, 228, 149);
    $pdf->Image('Imagenes/Logo_TECNM.png',11, 30, 20); //(x, y, tamaño)
    $pdf->Image('Imagenes/Logo_tese.jpg',75, 30, 20);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',13);
    $pdf->cell(85, 30, $res2['nombres']." ".$res2['apellidoPaterno']." ".$res2['apellidoMaterno'], 1, 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','',13);
    $pdf->cell(85, 30, "Junio 2023", 1, 0, 'R', 1);
    $pdf->Image('Codigo_QR/QR.png',11, 85, 30);
    $pdf->Ln();

    $pdf->SetFillColor(175, 34, 34);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',25);
    
    $pdf->cell(85, 20, $res2['tipoVisitante'], 1, 0, 'C', 1);
}
$pdf->Output();
?>
