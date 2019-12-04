
<!DOCTYPE html>

<html>
    <head>
        <title>Registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header>
        <?php require '../config/cabeceraUl.php'; ?>      
    </header>
    <body>
        <main>
            <h1 class="login"><b>REGISTRO</b></h1>
            <h3>ir a <a href="login.php"><b>Login</b></a></h3>
            <?php
            /**
              @author Ismael Heras Salvador
              @since 30/11/2019
             */
            require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
            require '../config/constantes.php'; //requerimos las constantes para la conexion
            define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
            define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
            $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
            //manejo del control de errores.
            $aErrores = ['CodUsuario' => null,
                'DescUsuario' => null,
                'password' => null,
                'perfil' => null];
            //manejo de las variables del formulario
            $aFormulario = ['CodUsuario' => null,
                'DescUsuario' => null,
                'password' => null];

            //si esta pulsado el boton de enviar entra en este condicional
            if (isset($_POST['enviar']) && $_POST['enviar'] == 'AñadirRegistro') {
                //La posición del array de errores recibe el mensaje de error si hubiera.
                $aErrores['CodUsuario'] = validacionFormularios::comprobarAlfaNumerico($_POST['CodUsuario'], 15, 4, 1);
                $aErrores['DescUsuario'] = validacionFormularios::comprobarAlfaNumerico($_POST['DescUsuario'], 250, 4, 1);
                $aErrores['password'] = validacionFormularios::comprobarAlfaNumerico($_POST['password'], 64, 4, 1);

                //foreach para recorrer el array de errores
                foreach ($aErrores as $campo => $error) {
                    if (!is_null($error)) {
                        $_REQUEST[$campo] = "";
                        $entradaOK = false;
                    }
                }
            } else {
                $entradaOK = false; //mientras no se pulse el boton la variable esta el false.
            }
            if ($entradaOK) {//si el valor es true procesamos los datos recogidos
                //ahora nuestro array de valores tiene el valor de los campos recogidos en el formulario.
                $usuario = $aFormulario['CodUsuario'] = $_POST['CodUsuario'];
                $aFormulario['DescUsuario'] = $_POST['DescUsuario'];
                $password = $aFormulario['password'] = $_POST['password'];


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
                    //funcion para poner la hora en madrid
                    date_default_timezone_set("Europe/Madrid");
                    //almacenamos en una variable la instancicocion de datatime.
                    $fechaNacional = date('d-m-Y H:i:s');
                    //genero el hash256 con la contraseña y el usuario recogidos en el formulario para luego insertarlo en la tabla con el blind.
                    $generar_password = hash('sha256', $usuario . $password);
                    //consulta preparada para ingresar valores a la tabla y añadir un nuevo registro.
                    $sql = "INSERT INTO Usuario (CodUsuario,DescUsuario,Password)  VALUES(:CodUsuario, :DescUsuario, :Password)";
                    $oPDO = $miDB->prepare($sql);
                    //con el bind param introducimos en la sentencia preparada el valor del campo del formulario
                    $oPDO->bindParam(":CodUsuario", $aFormulario["CodUsuario"]);
                    $oPDO->bindParam(":DescUsuario", $aFormulario["DescUsuario"]);
                    $oPDO->bindParam(":Password", $generar_password);

                    $oPDO->execute();


                    //con este query buscamos en la base de datos
                    $SQL = "SELECT * FROM Usuario WHERE CodUsuario = :user AND Password = :hash";
                    //almacenamos en una variable (objeto PDOestatement) la consulta preparada
                    $oPDO2 = $miDB->prepare($SQL);
                    //blindeamos los parametros
                    $oPDO2->bindValue(':user', $usuario);
                    //la contraseña es paso, pero para resumirla -> sha + contraseña=concatenacion de nombre+password
                    $oPDO2->bindValue(':hash', hash('sha256', $usuario . $password));
                    $oPDO2->execute();
                    //almacenamos todos los datos de la consulta en un array para mostar por pantalla luego los datos del registro e l asesion del usuario.
                    $resultado = $oPDO2->fetch(PDO::FETCH_ASSOC);

                    //recorremos todos los campos de la base de datos y si coincide en uno ejecuta el if y nos redireciona
                    //a la pagina programa.php, si no ejecuta el else i nos dice que el usuario no es correcto
                    //que no existe el usuario.
                    if ($oPDO2->rowCount() == 1) {
                        //iniciamos la sesion
                        session_start();
                        //almacenamos en la sesion los campos que queramos mostrar de la base de datos del usuario
                        $_SESSION['usuarioDAW209AppLOginLogoff'] = $resultado['CodUsuario'];
                        $_SESSION['descripcion'] = $resultado['DescUsuario'];
                        $_SESSION['passwordSinCifrar'] = $_POST['password'];
                        $_SESSION['perfil'] = $resultado['Perfil'];
                        $_SESSION['fechaCreacion'] = $resultado['FechaHoraUltimaConexion'];
                        $_SESSION['ultimaConexion'] = $fechaNacional;
                        //con header nos redirreciona a programa.php
                        header('Location: programa.php');
                    }
                    //control de excepciones con la clase PDOException
                } catch (PDOException $miExceptionPDO) {
                    if ($miExceptionPDO->getCode() == 23000 || $miExceptionPDO->getCode() == 2002) {
                        echo "<h3 class='rojo'>Error, Duplicado de clave primaria</h3>";
                    }
                } finally {
                    //cierre de conexion
                    unset($miDB);
                }
            }
            ?>             
            <div class="wrap">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                        <div class="obligatorio">
                            <label for="CodUsuario">Codigo</label> 
                            <input type="text" name="CodUsuario" placeholder="Introduce codigo de usuario(PK)" class="form-control " value="<?php
                            if ($aErrores['CodUsuario'] == NULL && isset($_POST['CodUsuario'])) {
                                echo $_POST['CodUsuario'];
                            }
                            ?>" <!--//Si el valor es bueno, lo escribe en el campo-->
                                   <?php if ($aErrores['CodUsuario'] != NULL) { ?>
                                       <div class="error">
                                           <?php echo $aErrores['CodUsuario']; //Mensaje de error que tiene el array aErrores        ?>
                                </div>   
                            <?php } ?>                
                        </div>
                        <br>
                        <div class="obligatorio">
                            <label for="DescUsuario">Descripcion</label>
                            <input type="text" name="DescUsuario" placeholder="Introduce Descripcion" class="form-control " value="<?php
                            if ($aErrores['DescUsuario'] == NULL && isset($_POST['DescUsuario'])) {
                                echo $_POST['DescUsuario'];
                            }
                            ?>" <!--//Si el valor es bueno, lo escribe en el campo-->
                                   <?php if ($aErrores['DescUsuario'] != NULL) { ?>
                                       <div class="error">
                                           <?php echo $aErrores['DescUsuario']; //Mensaje de error que tiene el array aErrores        ?>
                                </div>   
                            <?php } ?>   
                        </div>
                        <br>
                        <label class="label2" for="password">Password</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Inserta Password" value="<?php
                        if (isset($_POST['password']) && is_null($aErrores['password'])) { //comprobamos si ha introducido algo en el campo y que el array de errores este a null
                            echo $_POST['password']; //aunque se muestre un campo mal el valor si es correcto se mantiene.
                        }
                        ?>">
                               <?php if ($aErrores['password'] != NULL) { ?>
                            <div class="error">
                                <?php echo "<p class='p1'>" . $aErrores['password'] . "</p>"; //mensaje de error que tiene el array aErrores         ?>
                            </div>   
                        <?php } ?> 
                        <br>
                        <br>
                        <div class="botones2">
                            <input type="submit" name="enviar" value="AñadirRegistro" class="form-control  btn btn-secondary mb-1">
                        </div>
                    </fieldset>
                </form>
            </div>                     
            <br/>
            <br/> 
        </main>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a href="http://daw-usgit.sauces.local/heras/ProyectoLoginLogoff/tree/developer"><img  src="../img/gitLab.png" alt=""></a>
                <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="../img/gitHub.png" alt=""></a>
                <a href="../../proyectoTema5/tema5.php">Salir De La Aplicacion</a> 
            </div>
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
