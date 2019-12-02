
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Pagina de detalle</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
    </head>
    <body>
        <a href="programa.php"><img src="../WEBBROOT/img/volver.png" alt="" style="position: fixed; bottom: 0; right: 0;"></a>
         <?php
       /**
             * @author Ismael Heras 
             * @since 28/11/2019
             */
            session_start();
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
        
    </body>
</html>