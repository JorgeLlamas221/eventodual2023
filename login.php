<?php
$nombreServidor = 'eventodual2023-server2.mysql.database.azure.com';
$usuarioDB = 'mfuxpcdkwc';
$pwd = 'C45B8640EFBK5C2A$';
$db = 'eventoDual_2023';

$usuario = $_POST['nombreUsuario'];
$contraseña = $_POST['contrasenia'];
session_start();
$_SESSION['usuario'] = $usuario;

$conexion = mysqli_connect($nombreServidor, $usuarioDB, $pwd, $db);

$consulta = "SELECT*FROM usuario WHERE nombreUsuario='$usuario' AND contrasenia='$contraseña'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if($filas){
    header("location:descargarApp.php");
}
else{
    ?>
    <?php
    include("loginP.php");
    echo "<script>
    alert('Error De Autenticacion');
        </script>";
    ?>
    <!--<h4 class="bad">Error De Autenticacion</h4>-->
    <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);