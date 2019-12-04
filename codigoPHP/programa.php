<?php
//iniciamos sesion
session_start();
require '../config/cabeceraUlprograma.php';
//estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
//puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
if (!isset($_SESSION['usuarioDAW209AppLOginLogoff'])) {
    //si no tenemos permiso para entrar nos redirige al login
    header('Location: login.php');
    die();
} else {//si existe la sesion mostramos los datos del usuario. 
    //almacenamos en una variable la sesion.
    $sesion = $_SESSION['usuarioDAW209AppLOginLogoff'];
    //estructura de control para sacar por pantalla dependiendo del idioma que allamos elegido.
    if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "Español") {
        echo '<h1 style="color:green;">'."Bienvenido  $sesion  estas logeado en Español".'</h1>'; //si no existe la cooki lo mostramos en español por defecto       
    }
    if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "Ingles") {
        echo '<h1 style="color:green;">'."Welcome  $sesion  You are logged in English".'</h1>';
    } if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "Frances") {
         echo '<h1 style="color:green;">'."Bienvenue  $sesion  Vous êtes connecté en Français".'</h1>';
    }if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "Chino") {
         echo '<h1 style="color:green;">'."欢迎你  $sesion  您用中文登录".'</h1>';
    }
    
   
    echo "<br>";
     //muestra por pantalla los datos que queramos del la sesion del usuario.
    echo "<h2>Tu rol o perfil es:<br></h2>";
    if ($_SESSION['perfil'] == 'usuario') {
        echo '<p>Al tener un rol de usuario solo tienes acceso acambiar tu password y borrar la cuenta <a href="editarPerfil.php">Ir a Cambio de password</a></p>';
    } else {
        echo '<p>Al tener un rol de administrador tienes todas las funcionalidades de mantenimiento usuarios <a href="mantenimientoUsuarios.php">Ir a MantenimientoUsuarios</a></p>';
    }
    echo "<br>";
    echo "<p>La fecha de la ultima conexion es:" . '<b>' . $_SESSION['ultimaConexion'], "<p>";
    echo '<br>';
    echo "<p>El numero de Conexiones es :" . '<b>' . $_SESSION['numeroConexiones'], "</p>";
}
?> 
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Programa</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header> 
    </header>
    <body>
        <main>
            <br>
            <input type="button" class="btn btn-danger" value="SALIR" onclick="location = 'borrarSesion.php'">
            <input type="button" class="btn btn-warning" value="Detalle" onclick="location = 'detalle.php'">
            <br/>
            <br/>
        </main>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a href="http://daw-usgit.sauces.local/heras/ProyectoLoginLogoff/tree/developer"><img  src="../img/gitLab.png" alt=""></a>
                <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="../img/gitHub.png" alt=""></a>
            </div>               
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
