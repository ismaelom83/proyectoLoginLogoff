<?php

$lang = "en";
if( isset( $_POST["lang"] ) ) {
    $lang = $_POST["lang"];
    setcookie ( 'idioma', $lang, time() + 60*60*24*30, '/');
}
  
header( "Location: ../codigoPHP/programa.php" );
?>
