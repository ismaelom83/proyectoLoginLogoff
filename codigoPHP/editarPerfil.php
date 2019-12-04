
<!DOCTYPE html>
<html>
    <head>
        <title>Editar Perfil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosCambiarPassword.css">
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
                        <a class="nav-link" href="../../../proyectoDAW/DAW.php">DAW</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../../proyectoDIW/DIW.php">DIW</a>
                    </li>                       
                </ul >
            </div>
        </nav>
    </header>
    <body>           
        <main>

            <?php
            /**
              @author Ismael Heras Salvador
              @since 2/12/2019
             */
            //Iniciar una nueva sesión o reanudar la existente
            session_start();
            //estructura de control que nos permite controlar que si alguien quiere entrar directamente a el contenido no
            //puede por que no se ha logeado y por lo tanto la variable de sesion de clave de usuario no existe
            if (!isset($_SESSION['usuarioDAW209AppLOginLogoff'])) {
                echo '<h1>No tienes autorizacion de entrada,Debes de logearte primero</h1>';
                echo '<h1>' . '<a href="login.php">Ir_Login</a>' . '</h1>';
                die();
            } else {//si existe la sesion mostramos los datos del usuario.
                echo '<h2>Estos son los datos del registro<br>que quieres cambiar la Password o borrar</h2>';
                echo '<br>';
                require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
                require '../config/constantes.php'; //requerimos las constantes para la conexion
                define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
                define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
                $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
                //manejo del control de errores.
                $aErrores = ['CodUsuario' => null,
                    'DescUsuario' => null,
                    'password' => null];
                //manejo de las variables del formulario
                $aFormulario = ['CodUsuario' => null,
                    'DescUsuario' => null,
                    'password' => null];
                //
                if (isset($_POST['modificar']) && $_POST['modificar'] == 'cambiarPassword') {
                    header('Location: cambiarPassword.php');
                }
                //el valor del array ahora es igual al de los campos recogidos en el formulario.
                //ahora nuestro array de valores tiene el valor de los campos recogidos en el formulario.
                $usuario = $_SESSION['usuarioDAW209AppLOginLogoff'];
                $descripcion = $_SESSION['descripcion'];
                $password = $_SESSION['passwordSinCifrar'];
                if (isset($_POST['modificar2']) && $_POST['modificar2'] == 'EliminarCuenta') {
                   
                    try {
                        //conexion a la base de datos.
                        $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        //try cacth por si falla la conexion.
                    } catch (PDOException $excepcionPDO) {
                        die("Error al conectarse a la base de datos");
                    }
                    try {

                        $sql = "DELETE FROM Usuario WHERE CodUsuario LIKE '" . $_SESSION['usuarioDAW209AppLOginLogoff'] . "' ";
                        $oPDO = $miDB->prepare($sql);
                        $oPDO->execute();
                        //control de excepciones con la clase PDOException
                    } catch (PDOException $miExceptionPDO) {
                        if ($miExceptionPDO->getCode() == 23000 || $miExceptionPDO->getCode() == 2002) {
                            echo "<h3 class='rojo'>Error, no existe el registro</h3>";
                        }
                    } finally {
                        //cierre de conexion
                        unset($miDB);
                    }
                    header('Location: borrarSesion.php');
                }
            }
            ?>
            <div class="wrap">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <div class="obligatorio">
                            <label for="CodUsuario">Codigo</label> 
                            <input type="text" name="CodUsuario" placeholder="" disabled class="form-control " value=" <?php echo $usuario; ?> ">                                              
                        </div>
                        <br>
                        <div class="obligatorio">
                            <label for="DescUsuario">Descripcion</label>
                            <input type="text" name="DescUsuario" placeholder="Introduce Descripcion" disabled class="form-control " value=" <?php echo $descripcion; ?> ">  
                        </div>
                        <br>
                        <label class="label2" for="password">Password</label>
                        <input type="text" name="password" id="password" class="form-control" disabled  value=" <?php echo $password; ?>  ">

                        <br>
                        <div class="botones2">
                            <input type="submit" name="modificar" value="cambiarPassword" class="form-control  btn btn-primary mb-1">
                            <input type="submit" name="modificar2" value="EliminarCuenta" class="form-control  btn btn-secondary mb-1">                   
                            <br><br>
                            <li class="cancelarModificar2"><a href="programa.php">Cancelar</a></li> 
                        </div>
                    </fieldset>
                </form>
            </div>
            <br/>
            <br/>
        </main>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a class="volver" href="borrarSesion.php">Salir Aplicacion</a>
            </div>
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

















