
<?php
/**
 * @author Ismael Heras 
 * @since 28/11/2019
 */
//Iniciar una nueva sesión o reanudar la existente
session_start();
if (!isset($_SESSION['usuarioDAW209AppLOginLogoff'])) {   //estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
    //puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe  
    header('Location: ../login.php'); //si no tenemos permiso para entrar nos redirige al login
    die();//con die() terminamos inmediatamente la ejecución del script, evitando que se envíe más salida al cliente.
}
//formateeo  de las variables superglobales $_sesion $_cookie y $_server, tambien mostramos el phpinfo().
echo 'Variables Superglobales';
echo '<br>';
echo '<div style="margin-left: 30px";>';
echo "<pre style='text-align:left;'>";
echo "<h2 style='text-align:left;'>Variable SESSION<br><br></h2>";
print_r($_SESSION) . '<br>';
echo "</pre>";

echo "<pre style='text-align:left;'>";
echo "<h2 style='text-align:left;'>Variable COOKIE<br><br></h2>";
print_r($_COOKIE) . '<br>';
echo "</pre>";

echo "<pre style='text-align:left; margin-left:20px;'>";
echo "<h2 style='text-align:left;'>Variable SERVER<br><br></h2>";
print_r($_SERVER) . '<br>';
echo "</pre>";
echo '</div>';

phpinfo();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pagina de detalle</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
    </head>
    <body>
        <a href="programa.php"><img src="../WEBBROOT/img/volver.png" alt="" style="position: fixed; bottom: 0; right: 0;"></a>      
    </body>
</html>