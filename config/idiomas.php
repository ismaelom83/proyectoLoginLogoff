<?php
//iniciamos o continuamos sesion
session_start();
//estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
//puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
if (!isset($_SESSION['usuarioDAW209AppLOginLogoff'])) {
    //si no tenemos permiso para entrar nos redirige al login
    header('Location: login.php');
    die();
} else {//si existe la sesion mostramos los datos del usuario.
    $lang = "es";
    
    if (isset($_POST["lang"])) {
        $lang = $_POST["lang"];
        setcookie('idioma', $lang, time() + 60 * 60 * 24 * 30, '/');
    }
    header("Location: ../codigoPHP/programa.php?codigo=$lang");
}
?>
