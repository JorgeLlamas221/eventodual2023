<?php
require ('fpdf185/fpdf.php');
$nombreHost = 'eventodual2023-server2.mysql.database.azure.com';
$nombreUsuario = 'mfuxpcdkwc';
$pwd = 'C45B8640EFBK5C2A$';
$nombreBD = 'eventoDual_2023';
$info = $_POST['id_trabajador'];

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('Imagenes/EdoMex.png',11,8,40);
    $this->Image('Imagenes/EdoMex.png',11,8,20);
    // Arial bold 15
    //$this->SetFont('Times','B',25);
    $this->SetFont('Times','B',11);
    // Movernos a la derecha
    $this->Cell(30); // 80
    // Título
    $this->Cell(30,10,'Evento Dual 2023', 0, 0, 'L');
    // Salto de línea
    $this->Ln(20);
    $this->Image('Imagenes/Logo_tese.jpg',180, 30, 20);

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
$select1 = mysqli_query($conector1, "SELECT tipoVisitante, nombreEmpresa, nombres, apellidoPaterno, apellidoMaterno, sexo  FROM inscripcion WHERE id_inscripcion = $info");

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
        $nomEmpresa = $res1["nombreEmpresa"];
        $nombre = $res1["nombres"];
        $apellidoP = $res1["apellidoPaterno"];
        $apellidoM = $res1["apellidoMaterno"];
        $sexo = $res1["sexo"];
}

/*$informacion = 'FOLIO: '.$info.'
        NOMBRE(S): '.$nombre .'
        APELLIDO PATERNO: '.$apellidoP. '
        APELLIDO MATERNO: '.$apellidoM. '
        SEXO: '.$sexo.' 
        VISITANTE: '. $tipoVisitante;*/

$informacion = '"'.$nombre.' '.$apellidoP.' '.$apellidoM.'"';
QRcode::png($informacion, $archivo, $nivel, $tamanio, $dimension);

$conector2 = mysqli_connect($nombreHost, $nombreUsuario, $pwd, $nombreBD) or die ("Error De Conexion!!!" );
$select2 = mysqli_query($conector2, "SELECT tipoVisitante, nombreEmpresa, nombres, apellidoPaterno, apellidoMaterno, sexo  from inscripcion where id_inscripcion = $info");

$horario = 'Horario: Miercoles 14 De Junio 2023 Edificio: Auditorio';

$pdf->SetTextColor(0, 0, 0); 
$pdf->SetFillColor(42, 228, 149); 
$pdf->SetFont('Arial','',15); 
$pdf->cell(85, 25, "Evento Dual 2023", 1, 0, 'C', 1);
$pdf->Ln();
while($res2 = mysqli_fetch_array($select2)){
    $pdf->SetFillColor(42, 228, 149);
    //$pdf->Ln();
    $pdf->Image('Imagenes/Logo_TECNM.png',11, 30, 20); //(x, y, tamaño)
    //$pdf->Ln();
    $pdf->Image('Imagenes/Logo_tese.jpg',75, 30, 20);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','B',13);
    $pdf->cell(85, 25, $res2['nombres']." ".$res2['apellidoPaterno']." ".$res2['apellidoMaterno'], 1, 0, 'C');
    $pdf->Ln(); 
    
    $pdf->SetFillColor(5, 12, 85); 
    $pdf->SetFont('Arial','B',13);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->cell(85, 15, $res2['nombreEmpresa'], 1, 0, 'C', 1);

    $pdf->SetFillColor(42, 228, 149);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    $pdf->SetFont('Arial','',13);
    $pdf->cell(85, 30, "Junio 2023", 1, 0, 'R', 1);
    $pdf->Image('Codigo_QR/QR.png',11, 95, 30); // 11, 85, 30
    $pdf->Ln();

    $pdf->SetFillColor(175, 34, 34);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',25);
    
    $pdf->cell(85, 20, $res2['tipoVisitante'], 1, 0, 'C', 1);

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','',15);

    $pdf->cell(185, 35, $horario, 1, 0, 'C', 1);
}
$pdf->Output();
?>
