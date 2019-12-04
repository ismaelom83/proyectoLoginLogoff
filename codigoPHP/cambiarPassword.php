
<!DOCTYPE html>
<html>
    <head>
        <title>Cambiar Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosCambiarPassword.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header>

        <?php require '../config/cabeceraUlUsuario.php'; ?>

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
                echo '<h1>Cambio de password</h1>';
                echo '<br>';
                require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
                require '../config/constantes.php'; //requerimos las constantes para la conexion
                define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
                define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
                $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
                //manejo del control de errores.
                $aErrores = ['password' => null,
                    'password2' => null];
                //manejo de las variables del formulario
                $aFormulario = ['password' => null,
                    'password2' => null];
                //
                if (isset($_POST['modificar']) && $_POST['modificar'] == 'ComfirmarCambiarPassword') {
                    //La posición del array de errores recibe el mensaje de error si hubiera.
                    $aErrores['password'] = validacionFormularios::comprobarAlfaNumerico($_POST['password'], 64, 4, 1);
                    $aErrores['password2'] = validacionFormularios::comprobarAlfaNumerico($_POST['password2'], 64, 4, 1);
                    //foreach para recorrer el array de errores
                    foreach ($aErrores as $campo => $error) {
                        if (!is_null($error)) {
                            $_REQUEST[$campo] = "";
                            $entradaOK = false;
                        }
                    }
                } else {
                    $entradaOK = false; //Cambiamos el valor de la variable si no se pulsa enviar.
                }

                if ($entradaOK) {//si la variable entradaOK esta el true ejecutamos el codigo.
                    //el valor del array ahora es igual al de los campos recogidos en el formulario.
                    $passwd1 = $aFormulario['password'] = $_POST['password'];
                    $passwd2 = $aFormulario['password2'] = $_POST['password2'];

                    //extructura de control que nos dice sque si las password introducidas en los input
                    //coinciden se cambia la password en el registro y si no coinciden no se cambia.
                    if ($passwd1 === $passwd2) {

                        try {
                            //conexion a la base de datos.
                            $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            //try cacth por si falla la conexion.
                        } catch (PDOException $excepcionPDO) {
                            die("Error al conectarse a la base de datos");
                        }
                        try {
                            //guardamos en variables los datos de las variables de sesion del usuario y de la nueva clave pasada por el input.
                            $usuarioSesion = $_SESSION['usuarioDAW209AppLOginLogoff'];
                            $passwordNueva = $_POST['password'];
                            //genero el hash256 con la contraseña y el usuario con las variables de sesion de clave de usuario y de password sin cifrar.
                            $generar_password = hash('sha256', $usuarioSesion . $passwordNueva);
                            //consulta preparada para ingresar valores a la tabla y añadir un nuevo registro.
                            $sql = "UPDATE Usuario SET Password=:password WHERE CodUsuario=:usuario";
                            $oPDO = $miDB->prepare($sql);
                            //con el bind param introducimos en la sentencia preparada el valor del campo del formulario.
                            $oPDO->bindParam(":usuario", $usuarioSesion);
                            $oPDO->bindParam(":password", $generar_password);
                            //ejecutamos
                            $oPDO->execute();
                            
                            header('Location: programa.php');
                            //control de excepciones con la clase PDOException
                        } catch (PDOException $miExceptionPDO) {
                            if ($miExceptionPDO->getCode() == 23000 || $miExceptionPDO->getCode() == 2002) {
                                echo "<h3 class='rojo'>Error, Duplicado de clave primaria</h3>";
                            }
                        } finally {
                            //cierre de conexion
                            unset($miDB);
                        }
                    } else {
                        echo '<h2 style="color: red;">No coinciden las password, vuelva a introducirlas <br>hasta que coincidan</h2>';
                    }
                }     
            }
            ?> 
            <div class="wrap">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <div class="obligatorio">
                            <label for="password">Nueva Password:</label>
                            <input type="text" name="password" placeholder="Introduce nueva password" class="form-control " value="<?php
            if ($aErrores['password'] == NULL && isset($_POST['password'])) {
                echo $_POST['password'];
            }
            ?>" <!--//Si el valor es bueno, lo escribe en el campo-->
                                   <?php if ($aErrores['password'] != NULL) { ?>
                                       <div class="error">
                                           <?php echo $aErrores['password']; //Mensaje de error que tiene el array aErrores          ?>
                                </div>   
                            <?php } ?>   
                        </div>
                        <br>
                        <br>
                        <div class="obligatorio">
                            <label for="password2">Comfirmar Password:</label>
                            <input type="text" name="password2" placeholder="Comfirma nueva password" class="form-control " value="<?php
                            if ($aErrores['password2'] == NULL && isset($_POST['password2'])) {
                                echo $_POST['password2'];
                            }
                            ?>" <!--//Si el valor es bueno, lo escribe en el campo-->
                                   <?php if ($aErrores['password2'] != NULL) { ?>
                                       <div class="error">
                                           <?php echo $aErrores['password2']; //Mensaje de error que tiene el array aErrores          ?>
                                </div>   
                            <?php } ?>   
                        </div>
                        <br><br>
                        <div class="botones2">
                            <input type="submit" name="modificar"  value="ComfirmarCambiarPassword" class="form-control  btn btn-primary mb-1">
                            <li class="cancelarModificar"><a href="programa.php">CANCELAR</a></li>
                            <br><br>
                        </div>
                    </fieldset>
                </form>
            </div>
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


















