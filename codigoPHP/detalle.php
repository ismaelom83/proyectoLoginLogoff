


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
    </head>
    <body>
        <h1>Conexion correcta</h1>
         <?php
           /**
             * @author Ismael Heras 
             * @since 28/11/2019
             */
            echo 'Variables Superglobales';
            echo '<h3>Variable $Server</h3>';
            echo "<pre style='text-align:left;'>";
            print_r($_SERVER) . '<br>';
            echo "</pre>";
            echo '<h3>Variable Env</h3>';
            print_r($_ENV) . '<br>';
            echo '<h3>Variable Files</h3>';
            print_r($_FILES) . '<br>';
            echo '<h3>Variable Get</h3>';
            print_r($_GET) . '<br>';
            echo '<h3>Variable Post</h3>';
            print_r($_POST) . '<br>';
            echo '<h3>Variable Request</h3>';
            print_r($_REQUEST) . '<br>';
            echo '<h3>Variable Session</h3>';
            print_r($_SESSION);
           
            ?>
    </body>
</html>