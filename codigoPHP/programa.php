<?php
//iniciamos sesion o la mantenemos.
session_start();

if (!isset($_SESSION['usuarioDAW209AppLOginLogoff'])) {//estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
//puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
    header('Location: ../login.php'); //si no tenemos permiso para entrar nos redirige al login
    die();//con die() terminamos inmediatamente la ejecución del script, evitando que se envíe más salida al cliente.
}

if (isset($_POST['cerrar'])) { //si pulsamos el boton de cerrar sesion destruye la sesion y nos redirige al login
    session_destroy(); //destruye la sesion
    header('Location: ../login.php'); //nos redirige al login
    die();//con die() terminamos inmediatamente la ejecución del script, evitando que se envíe más salida al cliente.
}

if (isset($_POST['detalle'])) {//si pulsamos detalle nos lleva al detalle 
    header('Location: detalle.php'); //nos redirige al detalle
    die();//con die() terminamos inmediatamente la ejecución del script, evitando que se envíe más salida al cliente.
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
        <?php require '../include/config/cabecera.php'; ?>
    </header>
    <body>
        <main>
            <?php
            echo "<br>";
            if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "castellano") {//estructura de control para sacar por pantalla dependiendo del idioma que allamos elegido.
                echo '<h1 style="color:green;">' . "Bienvenido" . " " . $_SESSION['descripcionDAW209AppLOginLogoff'] . " " . "estas logeado en Castellano" . '</h1>'; //si no existe la cooki lo mostramos en español por defecto       
            } else {
                echo '<h1 style="color:green;">' . "Welcome" . " " . $_SESSION['descripcionDAW209AppLOginLogoff'] . " " . "You are logged in English" . '</h1>'; //si no lo ponemos en ingles
            }
            //muestra por pantalla los datos que queramos del la sesion del usuario.
            if ($_SESSION['perfilDAW209AppLOginLogoff'] == 'usuario') {
                echo '<h3>'."Tu rol o perfil es : ".$_SESSION['perfilDAW209AppLOginLogoff'] . '</h3';
                echo '<br>';
            } else {
                echo '<h3>' ."Tu rol o perfil es : ".$_SESSION['perfilDAW209AppLOginLogoff'] . '</h3>';
            }
            echo '<br>';
             echo '<br>';

            //estructura de control que nos indica que si es la primera conexion nos mostrara un mesaje y no mostrara la fecha de la ultica
            //conexion pero si no es la primera si nos muestra que numero de veces nos hemos conectado y la fecha de la ultima conexion. 
            if ($_SESSION['numeroConexiones'] == 1) {
                echo "<h3>" . $_SESSION['descripcionDAW209AppLOginLogoff'] . ' Esta es la primera vez que te conectas'."</h3>";
            } else {
                echo "<p>" . $_SESSION['descripcionDAW209AppLOginLogoff'] . " Esta es la " . '<b>' . $_SESSION['numeroConexiones'] . "º vez que te conectas" . "</p>";
                echo "<br>";
                echo "<p>La Ultima vez que te conectaste fue el : " . '<b>' . $_SESSION['ultimaConexion'], "<p>";
            }
            ?> 
            <br>
            <form action="<?php echo 'programa.php' ?>" method="post">
                <input type="submit" class="btn btn-danger" value="Cerrar Sesion" name="cerrar">
                <input type="submit" class="btn btn-warning" value="Detalle" name="detalle" >
            </form>
            <br/>
            <br/>
        </main>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a href="http://daw-usgit.sauces.local/heras/ProyectoLoginLogoff/tree/developer"><img  src="../WEBBROOT/img/gitLab.png" alt="GitLab"></a>
                <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="../WEBBROOT/img/gitHub.png" alt="GitHub"></a>
            </div>               
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
