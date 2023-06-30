<?php
require ('fpdf185/fpdf.php');
$info = $_POST['id_trabajador'];

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('Imagenes/logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Times','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'ECOJOBA', 0, 0, 'C');
    // Salto de línea
    $this->Ln(20);
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
$pdf->SetFont('Helvetica','',12);
$pdf->SetFillColor(15, 165, 31);
$pdf->SetTextColor(255, 255, 255);

$conector1 = mysqli_connect('localhost', 'root', '', 'db_3mpr3s4_w3b') or die ("Error De Conexion!!!" );
$select1 = mysqli_query($conector1, "select nombres, apellidoPaterno, apellidoMaterno, areaDeTrabajo, puesto from trabajador where id_trabajador = $info");

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
        $nombre = $res1["nombres"];
        $apellidoP = $res1["apellidoPaterno"];
        $apellidoM = $res1["apellidoMaterno"];
        $area = $res1["areaDeTrabajo"];
        $puesto = $res1["puesto"];
}

$informacion = 'FOLIO: '.$info.'
        NOMBRE(S): '.$nombre .'
        APELLIDO PATERNO: '.$apellidoP. '
        APELLIDO MATERNO: '.$apellidoM. '
        AREA: '.$area.' 
        PUESTO: '. $puesto;
        QRcode::png($informacion, $archivo, $nivel, $tamanio, $dimension);

$conector2 = mysqli_connect('localhost', 'root', '', 'db_3mpr3s4_w3b') or die ("Error De Conexion!!!" );
$select2 = mysqli_query($conector2, "select nombres, apellidoPaterno, apellidoMaterno, areaDeTrabajo, puesto from trabajador where id_trabajador = $info");

$pdf->cell(190, 10, "Informacion Del Trabajador", 1, 0, 'C', 1);
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
while($res2 = mysqli_fetch_array($select2)){
    $pdf->SetFillColor(182, 193, 178);
    $pdf->cell(39, 10, "Folio Trabajador:", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $info, 1, 0, 'I');
    $pdf->Ln();
    $pdf->Image('Imagenes/foto.jpg',160, 40, 40);

    $pdf->cell(39, 10, "Nombre(s):", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $res2['nombres'], 1, 0, 'I');
    $pdf->Ln();
    
    $pdf->cell(39, 10, "A.Paterno:", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $res2['apellidoPaterno'], 1, 0, 'I');
    $pdf->Ln();
    
    $pdf->cell(39, 10, "A.Materno:", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $res2['apellidoMaterno'], 1, 0, 'I');
    $pdf->Ln();
    
    $pdf->cell(39, 10, "Area De Trabajo:", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $res2['areaDeTrabajo'], 1, 0, 'I');
    $pdf->Ln();
    
    $pdf->cell(39, 10, "Puesto:", 1, 0, 'I', 1);
    $pdf->cell(75, 10, $res2['puesto'], 1, 0, 'I');

    $pdf->SetFillColor(15, 165, 31);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Ln();
    $pdf->cell(190, 10, "Codigo QR", 1, 0, 'C', 1);
    $pdf->Image('Codigo_QR/QR.png', 60, 115, 90);
}
$pdf->Output();
?>
