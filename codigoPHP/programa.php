
<!DOCTYPE html>
<html>
    <head>
        <title>Programa</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header>
        <?php
        require '../config/cabeceraUlprograma.php';?>
    </header>
    <body>
        <main>
            <br>
            
            <br>        
            <?php
            //Iniciar una nueva sesión o reanudar la existente
            session_start();
            //estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
            //puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
            if (!isset($_SESSION['claveUsuario'])) {
                echo '<h1>No tienes autorizacion de entrada,Debes de logearte primero</h1>';
                echo '<h1>'.'<a href="login.php">Ir_Login</a>'.'</h1>';
                die();
            } else {//si existe la sesion mostramos los datos del usuario.
               echo '<h1>Usuario Correcto, Bienvenido</h1>';
                //muestra por pantalla los datos que queramos del la sesion del usuario.
                echo "<br>";
                echo "<h2>Hola " . '<b class="b1">' . $_SESSION['claveUsuario'] . '</b>' . " Gracia por logearte en nuestra pagina</h2>";
                echo "<br>";
                echo "<h2>Tu rol o perfil es<br></h2>";
                if($_SESSION['perfil'] == 'usuario'){
                    echo '<h3>Al tener un rol de usuario no tienes acceso a administarrlos registros solo a verlos y al ve rel detalle<a href="login.php">Ir a FuncionalidadUsuario</a></h3>';
                } else {
                   echo '<h3>Al tener un rol de administrador puedes insertar modificar crear exportarb he importar<a href="login.php">Ir a FuncionalidadAdministrador</a></h3>';
                }
                echo "<br>";
                echo "<h2>La fecha y hora de la crecion del registro es :" . '<b>' . $_SESSION['fecha'], "</h2>";
                echo '<br>';
                echo "<h2>La fecha de la ultima conexion es :" . '<b>' . $_SESSION['ultimaConexion'], "</h2>";
            }
            ?> 
            <br>
            <input type="button" class="btn btn-danger" value="CerrarSesion" onclick="location = 'borrarSesion.php'">
            <input type="button" class="btn btn-warning" value="Detalle" onclick="location = 'detalle.php'">
            <br/>
            <br/>
            <footer class="page-footer font-small blue load-hidden">
                <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                    <a href="http://daw-usgit.sauces.local/heras/proyectoTema5/tree/master"><img  src="../img/gitLab.png" alt=""></a>
                    <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="../img/gitHub.png" alt=""></a>
                </div>               
            </footer> 
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </main>
    </body>
</html>
