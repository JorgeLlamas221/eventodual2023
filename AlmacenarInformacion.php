<?php
$nombreHost = 'localhost';
$nombreUsuario = 'root';
$pwd = '';
$nombreBD = 'eventoDual_2023';

$conexionBD = mysqli_connect($nombreHost, $nombreUsuario, $pwd, $nombreBD) or die("ERROR!!!! No Se Pudo Conectar Al Servidor :(");
$guardarRegistro = "INSERT INTO inscripcion (tipoVisitante, nombres, apellidoPaterno, apellidoMaterno, sexo, correoElectronico) VALUES ('".$_POST["tipoVisitante"]."','".$_POST["nombres"]."','".$_POST["aPaterno"]."','".$_POST["aMaterno"]."','".$_POST["sexo"]."','".$_POST["correoElectronico"]."')";
$tmp = mysqli_query($conexionBD, $guardarRegistro) or die ("ERROR !!! No Se Pudo Tener Conexion Con La BD :(");
$asignarID = "SELECT id_inscripcion FROM inscripcion WHERE nombres= '".$_POST["nombres"]."' AND apellidoPaterno= '".$_POST["aPaterno"]."' AND apellidoMaterno= '".$_POST["aMaterno"]."'";

if ($stmt = $conexionBD->prepare($asignarID)) {
    $stmt->execute();
    $stmt->bind_result($id_inscripcion);
    while ($stmt->fetch()) {
        echo "<b><h1>Ingresaste Los Siguientes Datos:</h1></b>";
        echo "<b><br>Su Folio De Inscripcion Asignado Por El Sistema Es:</br></b>".$id_inscripcion;
        echo "<br><b>Tipo De Visitante:</b><br>".$_POST["tipoVisitante"];
        echo "<br><b>Nombre:</b><br>".$_POST["nombres"];
        echo "<br><b>Apellido Paterno:</b><br>".$_POST["aPaterno"];
        echo "<br><b>Apellido Materno:</b><br>".$_POST["aMaterno"];
        echo "<br><b>Sexo:</b><br>".$_POST["sexo"];
        echo "<br><b>Correo Electronico:</b><br>".$_POST["correoElectronico"];
        // XAMPP: Modificar (php.ini) ;extension=gd por extension=gd
    }
    $stmt->close();
}


mysqli_close($conexionBD); 
?>

<html>
    <title>Confirmar Registro</title>
    <body bgcolor="#f0f0f0">
        <form action="GenerarGafete.php" method="POST" target="_blank">
            <br>
            <b>Para Finalizar Tu Registro, Introduzca El Numero De Folio Que Se Le Fue Asignado Por El Sistema y De Click En El Boton "Finalizar Registro" y Obtendras Tu Pase Al Evento Dual 2023 Por Correo.<br><input type="number" name="id_trabajador" value="" placeholder="Folio"></br></b>         
            <br><input type="submit" name="boton_pdf" value="Finalizar Registro"></br>
         </form>
         <META HTTP-EQUIV="REFRESH" CONTENT="30;URL=index.html">
    </body>
    </html>
       