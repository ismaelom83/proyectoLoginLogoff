
<?php

//Iniciar una nueva sesión o reanudar la existente
session_start();
//estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
//puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
if (!isset($_SESSION['claveUsuario'])) {
    echo '<h1>No tienes autorizacion de entrada,Debes de logearte primero</h1>';
    echo '<h1>' . '<a href="login.php">Ir_Login</a>' . '</h1>';
    die();
} else {//si existe la sesion mostramos los datos del usuario.
    // Borra todas las variables de sesión 
    $_SESSION = array();
    // Borra la cookie que almacena la sesión 
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    // Finalmente, destruye la sesión 
    session_destroy();

    //nos redirige al login
    header('Location: ../../proyectoTema5/tema5.php');
}
    ?>

