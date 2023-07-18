<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewpor" content="witdh=device-witdh, initial-scale=1.0">
    <title>Inicio Sesion</title>
    <script src="https://kit.fontawesome.com/81ce64fc29.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/estilologin.css">
   
</head>
<body>
    <header>
  <div class="container__header">

    <div class="logo">
        <img src="media/logo.png" alt="">
    </div>

    <div class="menu">
       <nav><ul>
        <li><a href="index.html">Inicio</a></li>
        <!--<li><a href="login.html">login Administrativos</a></li>-->
        
       </ul></nav> 
    </div>
    <i class="fa-solid fa-bars" id="icon_menu"></i>
    <div class="header__register">
       
    </div>
  </div>

    </header>
    
    <main>
    <div class="contenedor__todo">
        <!--Formulario completo-->
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3></h3>
                <p></p>
            <button id="btn__iniciar-sesion">Iniciar Sesión</button>
            </div>
            <div class="caja__trasera-register">
                <h3>                 Nombre de Usuario: admin</h3>
                <h3>                 Contraseña: Admin123</h3>
            </div>
        </div>
        <!--Formulario Login-->
          <div class="contenedor__login-register">
            <form action="login.php" class="formulario__login" method="POST">
                <h2>Iniciar Sesion</h2>
                <input type="text" placeholder="Usuario" name="nombreUsuario">
                <input type="password" placeholder="Contraseña" name="contrasenia">
                <input type="submit" name="entrar" value="Entrar">
                <!--<button>Entrar</button>-->
            </form>
            <!--Formulario Registro-->
            <form action="register.php" method="POST" class="formulario__register">
                <h2>Registrarse</h2>
                <input type="text" placeholder="Nombre De Usuario" name="nombreUsuario">
                <input type="text" placeholder="Nombre Completo" name="nombreCompleto">
                <input type="text" placeholder="Correo Electronico" name="correoElectronico">
                <input type="password" placeholder="Contraseña" name="contrasenia">
                <input type="submit" name="enviar" value="Registrarse">
                <!--<button>Registrarse</button> -->
            </form> 
          </div>
    </div>
    </main>
    <script src="js/loginscript.js"> </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <title>Login</title>

    </head>

</html>