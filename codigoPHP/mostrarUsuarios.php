
<!DOCTYPE html>
<!--
                                    <---------------------------MOSTAR  DEPARTAMENTOS-------------------------------------------------->

<html>
    <head>
        <title>Mostrar Departamentos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosmostrar.css">
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
        } else {
            require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
            require '../config/constantes.php'; //requerimos las constantes para la conexion
            try {
               echo '<h1 class="mostrar1">Mostramos todos los campos del registro</h1>';
                echo '<br>';
                echo "<div class='volver1'><a  href='mantenimientoUsuarios.php'>VOLVER</a></div>";
                //conexion a la base de datos
                $miDB2 = new PDO(MAQUINA, USUARIO, PASSWD);
                //mensaje por pantalla que todo ha ido bien
                $miDB2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //try cacth por si falla la conexion.
            } catch (PDOException $excepcionPDO) {
                die("Error al conectarse a la base de datos");
            }

            try {
                //consulta para optener el codigo y mostar solo el campo completo de ese codigo 
                $sql = "SELECT * FROM Usuario WHERE CodUsuario LIKE '" . $_GET['codigo'] . "'";
                $resultadoConsulta = $miDB2->query($sql);

                //tabla para formatear la salida en formato tabla.
                echo '<table border="1">';
                echo '<tr>';
                echo '<th>Código</th>';
                echo '<th>Descripción</th>';
                echo '<th>Password</th>';
                echo '<th>Perfil</th>';
                echo '<th>FechaCreacion</th>';
                echo '</tr>';

                //while que recorre los campos de la tabla
                while ($campoTabla = $resultadoConsulta->fetchObject()) {
                    echo '<tr>';
                    echo "<td>" . '<b>' . $campoTabla->CodUsuario . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescUsuario .
                    "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->Password.
                    "</td>" . "<td>" . '<b>' . $campoTabla->Perfil . "</td>"."<td>" . '<b>' . $campoTabla->FechaHoraUltimaConexion . "</td>";;
                    echo '</tr>';
                }


                //control de excepciones con la clase PDOException
            } catch (PDOException $miExceptionPDO) {
                //mostrar mensaje de errores
                echo'Error: ' . $miExceptionPDO->getMessage();
                echo'Código de error: ' . $miExceptionPDO->getCode();
            } finally {

                //cierre de la conexion
                unset($miDB2);
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

















