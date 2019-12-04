
<!DOCTYPE html>

<html>
    <head>
        <title>Modificar Usuarios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosModificar.css">
    </head>
    <header>

        <?php require '../config/cabeceraUlUsuario.php'; ?>  

    </header>
    <body>           
        

        <?php
        /**
          @author Ismael Heras Salvador
          @since 30/11/2019
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
          echo  '<h1>Modificar los campos del registro<br>descripcion y perfil</h1>';
            require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
            require '../config/constantes.php'; //requerimos las constantes para la conexion
            define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
            define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
            $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
            //manejo del control de errores.
            $aErrores = ['DescUsuarios' => null,
                'Perfil' => null,
                'CodUsuarios' => null];
            //manejo de las variables del formulario
            $aFormulario = ['DescUsuarios' => null,
                'Perfil' => null,
                'CodUsuarios' => null];
            //
            if (isset($_POST['modificar']) && $_POST['modificar'] == 'ModificarUsuarios') {
                //La posición del array de errores recibe el mensaje de error si hubiera.
                $aErrores['DescUsuarios'] = validacionFormularios::comprobarAlfaNumerico($_POST['DescUsuarios'], 255, 1, 1);
                if (!isset($_POST['perfil'])) {
                    $aErrores['perfil'] = "Debe marcarse un valor";
                } //para los radio buttons
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
                $aFormulario['DescUsuarios'] = $_POST['DescUsuarios'];
                $aFormulario['perfil'] = $_POST['perfil'];

                echo "<br>";
                try {
                    //conexion a la base de datos
                    $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                    //mensaje por pantalla que todo ha ido bien
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //try cacth por si falla la conexion.
                } catch (PDOException $excepcionPDO) {
                    die("Error al conectarse a la base de datos");
                }

                try {

                    //realizamos una consulta preparada que es un update de los campos descripcion y volumen 
                    //del  registro con codigo recojido por $_GET.
                    $sql = "UPDATE Usuario SET DescUsuario=:descUsuario, Perfil=:perfil WHERE CodUsuario=:codUsuario";
                    //guardamos en una variable la sentencia sql
                    $sentencia = $miDB->prepare($sql);
                    //blindeamos los parametros.
                    $sentencia->bindParam(":codUsuario", $_GET['codigo']);
                    $sentencia->bindParam(":descUsuario", $_POST['DescUsuarios']);
                    $sentencia->bindParam(":perfil",  $_POST['perfil']);
                    $sentencia->execute();
                       echo '<h2 style="color:green;">Update realizado con exito</h2>';
                    //cath donde nos salta las excepcion si introducimos mal los datos
                } catch (Exception $excepcion) {
                    die("Datos introducidos erroneamente:<br> " . $excepcion->getMessage());
                }
            }
            //si esta definida la variable y no es null almacenamos en una variable el codigo del registro recogido con $_SESSION
            //y realizamos una consulta de todos los campos con ese codigo.
            if (isset($_GET['codigo'])) {
                $codigo = $_GET['codigo'];
                try {
                    //conexion a la base de datos
                    $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                    //consulta preparada que nos devuelve todos los campos del registro recojido por el $_GET  anterior
                    $sql = "SELECT * FROM Usuario WHERE CodUsuario=:codigo";
                    //guardamos en una variable la sentencia sql.
                    $sentencia = $miDB->prepare($sql);
                    //blindeamos los parametros.
                    $sentencia->bindParam(":codigo", $codigo);
                    $sentencia->execute();

                    //con la siguiente instruccion guardamos los datos de la consulta en un array
                    $aresultados = $sentencia->fetch(PDO::FETCH_ASSOC);
                    //almacenamos en una variable un campo concreto del array de la consulta para introducirlo por defecto 
                    //mediante los values en cada input de los campos que queremos modificar.
                    $descripcion = $aresultados ['DescUsuario'];  
                 
                    //cath que salta cuando a fallado la conexion a la base de datos.
                } catch (Exception $excepcion) {
                    die("Conexion a la base de datos fallida:<br> " . $excepcion->getMessage());
                }
            }
        }
        ?>
        <div class="wrap">
            <form action="<?php echo $_SERVER['PHP_SELF'];
        echo "?codigo=" . $_GET['codigo']; ?>" method="post">
                <fieldset>
                    <div class="obligatorio">
                        CODIGO: 
                        <input type="text" name="CodUsuarios" placeholder="" class="form-control " disabled value="<?php echo $codigo ?>" 
                        <?php if ($aErrores['CodUsuarios'] != NULL) { ?>
                                   <div class="error">
                                       <?php echo $aErrores['CodUsuarios']; //Mensaje de error que tiene el array aErrores ?>
                            </div>   
                        <?php } ?>                
                    </div>
                    <br>
                    <div class="obligatorio">
                        DESCRIPCION: 
                        <input type="text" name="DescUsuarios"  class="form-control " value="<?php echo $descripcion ?>" 
                        <?php if ($aErrores['DescUsuarios'] != NULL) { ?>
                                   <div class="error">
                                       <?php echo $aErrores['DescUsuarios']; //Mensaje de error que tiene el array aErrores         ?>
                            </div> 
                               
                        <?php } ?>   
                               <br><br>
                   <label for="perfil">Perfil De Usuario</label><br>
                    <input type="radio" class="" id="r1" name="perfil" checked value="usuario" <?php
                        if (isset($_POST['perfil']) && $_POST['perfil'] == "Opcion 1") {
                            echo 'checked';
                        }
                        ?>
                        <label class="label1" for="perfil">Usuario</label>
                        <input type="radio" class="" id="r2" name="perfil" value="administrador" <?php
                        if (isset($_POST['perfil']) && $_POST['perfil'] == "Opcion 2") {
                            echo 'checked';
                        }?>
                       <label for="perfil">Administrador</label>
                    
                        <br>
                    </div>
                    <br>
                    <br>
                    <div class="botones2">
                        <input type="submit" name="modificar"  value="ModificarUsuarios" class="form-control  btn btn-primary mb-1">
                        <li class="cancelarModificar"><a href="programa.php">VOLVER</a></li>  
                    </div>
                </fieldset>
            </form>
        </div>

        <br/>
        <br/>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a class="volver" href="borrarSesion.php">salir aplicacion</a>
            </div>
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>



















