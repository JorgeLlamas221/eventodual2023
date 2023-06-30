<?php
$correoExistente = $_POST['correoElectronico'];
$nombreExistente = $_POST['nombreCompleto'];

$conexion1 = mysqli_connect('localhost', 'root', '', 'Ecojoba') or die('Error en la conexion servidor');
$verificarExistencia1 = "SELECT correoElectronico FROM Usuario WHERE correoElectronico = '$correoExistente'";
$correoEncontrado = 0;
if ($verificacion1 = $conexion1->prepare($verificarExistencia1)) {
    $verificacion1->execute();
    $verificacion1->bind_result($correoEncontrado);
    while ($verificacion1->fetch()) {}
    $verificacion1->close();
}

$conexion2 = mysqli_connect('localhost', 'root', '', 'Ecojoba') or die('Error en la conexion servidor');
$verificarExistencia2 = "SELECT nombreCompleto FROM Usuario WHERE nombreCompleto = '$nombreExistente'";
$nombreEncontrado = 0;
if ($verificacion2 = $conexion2->prepare($verificarExistencia2)) {
    $verificacion2->execute();
    $verificacion2->bind_result($nombreEncontrado);
    while ($verificacion2->fetch()) {}
    $verificacion2->close();
}

mysqli_close($conexion1);
mysqli_close($conexion2);

if($correoExistente==$correoEncontrado && $nombreExistente==$nombreEncontrado){
    require 'login.html'; 
    echo 
        '<script>
        alert("No Se Puede Crear La Cuenta Porque Ya Existe");
        </script>';
}
else{
    if($correoExistente==$correoEncontrado && $nombreExistente!=$nombreEncontrado){
        require 'login.html';
        echo 
        '<script>
        alert("No Se Puede Crear La Cuenta Ya Que El Correo Electronico Ya Esta Siendo Usada Por Otra Cuenta");
        </script>';
    }
    else{
        if($correoExistente!=$correoEncontrado && $nombreExistente==$nombreEncontrado){
            require 'login.html'; 
            echo 
            '<script>
            alert("No Se Puede Crear La Cuenta Ya Que El Nombre Ya Esta Siendo Usada Por Otra Cuenta");
            </script>';
        }
        else{
            $conexion3 = mysqli_connect('localhost', 'root', '', 'Ecojoba') or die('Error en la conexion servidor');
            $registrarUsuario = "INSERT INTO Usuario (id_usuario, nombreUsuario, nombreCompleto, correoElectronico, contrasenia) VALUES(null,'".$_POST["nombreUsuario"]."','".$_POST["nombreCompleto"]."','".$_POST["correoElectronico"]."','".$_POST["contrasenia"]."')";
            $temp = mysqli_query($conexion3, $registrarUsuario) or die("Error Al Momento De Almacenar La informacion En La Base De Datos");

            echo '<script>
                    alert("La Cuenta Se A Creado Con Exito!!!");
                </script>';
                mysqli_close($conexion3);
        }
    }
}
?>