<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio MtoUsuarios</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/funcionalidadUsuarios.css">
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
                require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
                require '../config/constantes.php'; //requerimos las constantes para la conexion
                $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
                //manejo del control de errores.
                //manejo de las variables del formulario
                $aFormulario ['DescUsuarios'] = null;
                //hacemos la conexion a la base de datos.
                try {
                    //conexion a la base de datos
                    $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                    //mensaje por pantalla que todo ha ido bien
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $excepcionPDO) {
                    die("Error al conectarse a la base de datos");
                }
                ?>

                <!-enlaces a añadir usuario exportar he importar->
                <li><a href="registro.php">AÑADIR</a></li>
                <li><a href="#">EXPORTAR</a></li>
                <li><a href="#">IMPORTAR</a></li> 
                <br>
                <br>
                <!-formulario para buscar la descripcion de el Usuario->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>                  
                        BUSCAR DEPARTAMENTOS: 
                        <input type="text" name="DescUsuarios" placeholder="Introduce coincidencia con descripcion de usuarios" id="buscar" value="<?php
                        if (isset($_POST['DescUsuarios'])) {
                            echo $_POST['DescUsuarios'];
                        }
                        ?>"> 
                        <input type="submit" name="enviar" value="Buscar" id="enviar">       

                    </fieldset>
                </form> 
                <?php
                if (isset($_POST['DescUsuarios'])) {//si esta definida la variable i no es null decimos que nuestro array es igual al valor que recogemos en el campo buscar 
                    $aFormulario ['DescUsuarios'] = $_POST['DescUsuarios'];
                }
                //si el array es diferente de null entonces ejecutamos la consulta para decir si lo introducido en el campo
                // de buscar coincide con la descripcion de alguno de los registros.
                if ($aFormulario['DescUsuarios'] != null) {
                    try {
                        //instruccion sql para saber las coincidencias
                        $sql = "SELECT * FROM Usuario where DescUsuario LIKE '%" . $aFormulario["DescUsuarios"] . "%'";
                        $sentencia = $miDB->prepare($sql);
                        //ejecutamos la sentencia
                        $sentencia->execute();
                        //guardamos en una variable la instruccion sql
                        $resultadoConsulta = $miDB->query($sql);

                        //control de excepciones con la clase PDOException
                    } catch (PDOException $miExceptionPDO) {
                        //mostrar mensaje de errores
                        echo'Error: ' . $miExceptionPDO->getMessage();
                        echo'Código de error: ' . $miExceptionPDO->getCode();
                    } finally {

                        //cierre de la conexion
                        unset($miDB2);
                    }
                    //si no se ha introducido nada el el campo de busqueda (por defecto al principio) y pulsamos cuando
                    //el input de buscar esta vacio nos ejecutara una consulta de todos los campos de la tabla(en este caso le hemos puesto un limit 7,es decir solo mostrara 7)
                } else {
                    try {

                        //select con un limit de 7 campos para mostar en la tabla.
                        $sql = "SELECT * FROM Usuario";
                        $resultadoConsulta = $miDB->query($sql);
                        //control de excepciones con la clase PDOException
                    } catch (PDOException $miExceptionPDO) {
                        //mostrar mensaje de errores
                        echo'Error: ' . $miExceptionPDO->getMessage();
                        echo'Código de error: ' . $miExceptionPDO->getCode();
                    } finally {

                        //cierre de la conexion
                        unset($miDB);
                    }
                }
                //tabla para formatear la salida en formato tabla
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>Código</th>';
                echo '<th>Descripción</th>';

                echo '</tr>';
                //muestra los registros que coinciden en la sentencia sql que sera dependiendo de el condicional de arriba 
                //(si hay algo en el input ejecutara la sentencia de de comparar (like) y si no hara un select de todos los campos(limit 7)) y da formato
                // a nuestra tabla con los td y tr de modificar borrar etc...
                while ($campoTabla = $resultadoConsulta->fetchObject()) {
                    echo '<tr>';
                    echo "<td>" . '<b>' . $campoTabla->CodUsuario . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescUsuario .
                    "</td>" . "<td>" . '<b>' . "<a href='mostrarUsuarios.php?codigo=$campoTabla->CodUsuario'><img src='../WEBBROOT/img/ver2.png'/></a>" . "</td>" .
                    "</td>" . "<td>" . '<b>' . "<a href='modificarUsuarios.php?codigo=$campoTabla->CodUsuario'><img src='../WEBBROOT/img/modificar.png'/></a>" . "</td>" .
                    "</td>" . "<td>" . '<b>' . "<a href='borrarUsuario.php?codigo=$campoTabla->CodUsuario'><img src='../WEBBROOT/img/borrar2.png'/></a>" . "</td>" .
                    "<td>" . '<b>' . "<a href='#'><img src='../WEBBROOT/img/flecha-hacia-abajo.png'/></a>" . "</td>" .
                    "<td>" . '<b>' . "<a href='#'><img src='../WEBBROOT/img/flecha-hacia-arriba.png'/></a>" . "</td>";
                    echo '</tr>';
                }
            }
            ?> 
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

