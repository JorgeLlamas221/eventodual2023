<?php
if(!empty($_POST)){
    $serverName = "tcp:eventodual2023.database.windows.net,1433";
    $connectionInfo = array("Database"=>"BDdual2023");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    $tipoVisitante = $_POST["tipoVisitante"];
    $nombres = $_POST["nombres"];
    $aPaterno = $_POST["aPaterno"];
    $aMaterno = $_POST["aMaterno"];
    $sexo = $_POST["sexo"];
    $correoElectronico = $_POST["correoElectronico"];
    
    $guardarRegistro = "INSERT INTO inscripcion (tipoVisitante, nombres, apellidoPaterno, apellidoMaterno, sexo, correoElectronico) VALUES ('$tipoVisitante', '$nombres', '$aPaterno', '$aMaterno', '$sexo', '$correoElectronico')";

    $sql = sqlsrv_prepare($conn, $guardarRegistro);


    if(sqlsrv_execute($sql)){
        //echo 'El Registro Se Almaceno De Forma Exitosa';
    }
    else{
        echo 'ERROR!!! El Registro NO SE PUDO REGISTRAR EN LA BD';
    }


    $consulta = "SELECT id_inscripcion FROM inscripcion WHERE nombres= '$nombres' AND apellidoPaterno= '$aPaterno' AND apellidoMaterno= '$aMaterno'";
    $sql_2 = sqlsrv_query($conn, $consulta);

    while($asignarID=sqlsrv_fetch_array($sql_2)){
        echo "<b><h1>Ingresaste Los Siguientes Datos:</h1></b>";
        echo "<b><br>Su Folio De Inscripcion Asignado Por El Sistema Es:</br></b>".$asignarID[0];
        echo "<br><b>Tipo De Visitante:</b><br>".$tipoVisitante;
        echo "<br><b>Nombre:</b><br>".$nombres;
        echo "<br><b>Apellido Paterno:</b><br>".$aPaterno;
        echo "<br><b>Apellido Materno:</b><br>".$aMaterno;
        echo "<br><b>Sexo:</b><br>".$sexo;
        echo "<br><b>Correo Electronico:</b><br>".$correoElectronico;
    }
}
?>

<html>
    <title>Confirmar Registro</title>
    <body bgcolor="#f0f0f0">
        <form action="GenerarGafete.php" method="POST" target="_blank">
            <br>
            <b>Para Finalizar Tu Registro, Introduzca El Numero De Folio Que Se Le Fue Asignado Por El Sistema y De Click En El Boton "Finalizar Registro" y Obtendras Tu Pase Al Evento Dual 2023 Por Correo.<br><input type="number" name="id_inscripcion" value="" placeholder="Folio"></br></b>         
            <br><input type="submit" name="boton_pdf" value="Finalizar Registro"></br>
         </form>
         <META HTTP-EQUIV="REFRESH" CONTENT="30;URL=index.html">
    </body>
    </html>
       