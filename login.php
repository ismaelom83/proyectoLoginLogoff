
<?php
/**
  @author Ismael Heras Salvador
  @since 28/11/2019
 */
require 'core/validacionFormularios.php'; //importamos la libreria de validacion  
require 'include/config/constantes.php'; //requerimos las constantes para la conexion
define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
//manejo de las variables del formulario
$aFormulario = ['usuario' => null,
    'password' => null];

//----------------------cookies-------------------------------------------------
//si no existe la cookie la creamos en español por defecto.
if (!isset($_COOKIE['idioma'])) {
    $idiomaCookie = "castellano";
    setcookie('idioma', $idiomaCookie, time() + 60 * 60 * 24 * 30);
    header("Location: login.php");
}
//ponemos el valor a la cookie dependiendo del idioma que hemos introducido.
if (isset($_GET["idioma"])) {
    $idiomaCookie = $_GET["idioma"];
    setcookie('idioma', $idiomaCookie, time() + 60 * 60 * 24 * 30); //creamos la cooki con una duracionde 30 dias
    header("Location: login.php"); //recargamos la pagina.
}


if (isset($_POST['salir'])) {//si pulsamos volver nos devuelve al protecto tema5
    header('Location: ../proyectoTema5/tema5.php');
    die();
}
if (isset($_POST['entrar']) && $_POST['entrar'] == 'Entrar') {

    //el valor del array ahora es igual al de los campos recogidos en el formulario.
    $usuario = $aFormulario['usuario'] = $_POST['usuario'];
    $passwd = $aFormulario['password'] = $_POST['password'];

    try {
        //conexion a la base de datos.
        $miBD = new PDO(MAQUINA, USUARIO, PASSWD);
        $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //try cacth por si falla la conexion.
    } catch (PDOException $excepcionPDO) {
        die("Error al conectarse a la base de datos");
    }

    try {
        //funcion para poner la hora en madrid
        date_default_timezone_set("Europe/Madrid");
        //almacenamos en una variable la instancicocion de datatime.
        $fechaNacional = date('d-m-Y H:i:s');
        //con este query buscamos en la base de datos
        $SQL = "SELECT * FROM Usuario WHERE CodUsuario = :user AND Password = :hash";
        //almacenamos en una variable (objeto PDOestatement) la consulta preparada
        $oPDO = $miBD->prepare($SQL);
        //blindeamos los parametros
        $oPDO->bindValue(':user', $usuario);
        //la contraseña es paso, pero para resumirla -> sha + contraseña=concatenacion de nombre+password
        $oPDO->bindValue(':hash', hash('sha256', $usuario . $passwd));
        $oPDO->execute();
        //almacenamos todos los datos de la consulta en un array para mostar por pantalla luego los datos del registro e l asesion del usuario.
        $resultado = $oPDO->fetch(PDO::FETCH_ASSOC);

        //recorremos todos los campos de la base de datos y si coincide en uno ejecuta el if y nos redireciona
        //a la pagina programa.php, si no ejecuta el else i nos dice que el usuario no es correcto
        //que no existe el usuario.
        if ($oPDO->rowCount() == 1) {
            session_start();
            //almacenamos en la sesion los campos que queramos mostrar de la base de datos del usuario
            $_SESSION['usuarioDAW209AppLOginLogoff'] = $resultado['CodUsuario'];
            $_SESSION['descripcionDAW209AppLOginLogoff'] = $resultado['DescUsuario'];
            $_SESSION['perfilDAW209AppLOginLogoff'] = $resultado['Perfil'];
            $_SESSION['numeroConexiones'] = $resultado['NumConexiones'] + 1;
            
            if ($_SESSION['numeroConexiones'] > 1) {//si el numero de conexiones es mayor de una entonces mostraremos la hora de la ultima conexion si no no podriamos al ser la primera
                $_SESSION['ultimaConexion'] = $resultado['FechaHoraUltimaConexion'];        
            }
            //consulta preparada para saber el numero de conexiones y lo almacenamos en la base datos.
            $sql = "UPDATE Usuario SET NumConexiones=NumConexiones+1 WHERE CodUsuario=:codUsuario";
            //guardamos en una variable la sentencia sql
            $oPDO = $miBD->prepare($sql);
            $oPDO->bindParam(":codUsuario", $_SESSION['usuarioDAW209AppLOginLogoff']);
            $oPDO->execute();
            //con header nos redirreciona a programa.php        
            header('Location: codigoPHP/programa.php');
        }
        //cath que se ejecuta si habido un error
    } catch (PDOException $excepcion) {
        echo "<h1>Se ha producido un error</h1>";
        //nos muestra el error que ha ocurrido.
        echo $excepcion->getMessage();
    } finally {
        unset($miBD); //cerramos la conexion a la base de datos.
    }
}
//si se envia el formulario este desaparece.
?>  
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="WEBBROOT/css/estilosEjer.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light load-hidden"  style="background-color: #e3f2fd;">

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../../../index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../proyectoDWES/DWES.php">DWES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../proyectoDWEC/DWEC.php">DWEC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../proyectoDAW/DAW.php">DA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../proyectoDIW/DIW.php">DIW</a>
                    </li>  
                    <li class="nav-item">
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?idioma=english"><img src="WEBBROOT/img/eng.jpg" alt="English"></a>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?idioma=castellano"><img src="WEBBROOT/img/esp_1.jpg" alt="Castellano"></a>
                    </li>

                </ul >
            </div>
        </nav>            
    </header>
    <body>
        <main> 
            <?php
//estructura de control para sacar por pantalla dependiendo del idioma que allamos elegido.
            if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "castellano") {
                echo '<h1 class="login"><b>Inicio Sesion</b></h1>';
            }
            if (isset($_COOKIE['idioma']) && $_COOKIE['idioma'] == "english") {
                echo '<h1 class="login"><b>Log In</b></h1>';
            }

            if (isset($_POST['salir']) && $_POST['salir'] == 'Volver') {
                header('Location: ../../proyectoTema5/tema5.php');
            }
            if (isset($_POST['entrar']) && $_POST['entrar'] == 'Entrar') {
                echo '<p class="login-error">Usuario o Password Incorrectos</p><br>';
            }
            ?>
            <div class="wrap">
                <form action="" method="post">
                    <fieldset>
                        <label for="usuario">Usuario</label><br>
                        <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Introduce Usuario:" value="<?php
                        if (isset($_POST['usuario'])) { //comprobamos si ha introducido algo en el campo y que el array de errores este a null
                            echo $_POST['usuario']; //aunque se muestre un campo mal el valor si es correcto se mantiene.
                        }
                        ?>">
                        <br>
                        <label for="password">Password</label><br>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Introduce Password:" value="<?php
                        if (isset($_POST['password'])) { //comprobamos si ha introducido algo en el campo y que el array de errores este a null
                            echo $_POST['password']; //aunque se muestre un campo mal el valor si es correcto se mantiene.
                        }
                        ?>">                       
                        <br>
                        <div class="botones2">
                            <input type="submit" name="entrar"  value="Entrar" class="form-control  btn btn-primary mb-1">
                            <br><br>
                            <input type="submit" name="salir"  value="Volver" class="form-control  btn btn-danger mb-1">
                        </div>
                    </fieldset>
                </form>
            </div>                       
            <br/>
            <br/>         
        </main>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a href="http://daw-usgit.sauces.local/heras/ProyectoLoginLogoff/tree/developer"><img  src="WEBBROOT/img/gitLab.png" alt=GitLab""></a>
                <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="WEBBROOT/img/gitHub.png" alt="GitHub"></a>
                <a href="../proyectoTema5/tema5.php">Salir De La Aplicacion</a> 
            </div>
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
