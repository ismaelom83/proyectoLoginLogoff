
<!DOCTYPE html>
<!--
                       <---------------------------BORRAR DEPARTAMENTOS-------------------------------------------------->

<html>
    <head>
        <title>Borrar Usuario</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosBorrar.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <header>

     <?php require '../config/cabeceraUlUsuario.php'; ?>  

    </header>
    <body>   
        <form action="" method="post">
            <h2>¿Deseas borrar el registro?</h2>
            <br>
            <div class='container3'>
                <input class='i1' type='submit' name='si' value='SI'/>
                <input class='i2' type='submit' name='no'  value='NO'/>
            </div>   
        </form>
        <?php
        /**
          @author Ismael Heras Salvador
          @since 30/11/2019
         */
        require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
        require '../config/constantes.php'; //requerimos las constantes para la conexion
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
            
            //estructura de control que dice que si el boton si esta seteado borra el registro que le hemos pasado
            //y si no no lo borra.
             if(isset($_POST['si']) && $_POST['si'] == 'SI') {
                $sql = "DELETE FROM Usuario WHERE CodUsuario LIKE '" . $_GET['codigo'] . "' ";           
                $resultadoConsulta = $miDB->query($sql);
                echo '<br>';
                echo '<h2>Registro borrado</h2>';
                echo '<br>';
                 echo "<div class='volver1'><a  href='mantenimientoUsuarios.php'>VOLVER</a></div>";               
            }else if(isset($_POST['no']) && $_POST['no'] == 'NO'){
               echo '<br>';
                echo '<h2>Registro no  borrado</h2>';
                echo '<br>';
                 echo "<div class='volver1'><a  href='mantenimientoUsuarios.php'>VOLVER</a></div>"; 
            }

            //consulta para optener el codigo y mostar solo el campo completo de ese codigo 
            $sql = "SELECT * FROM Usuario WHERE CodUsuario LIKE '" . $_GET['codigo'] . "'";
            $resultadoConsulta = $miDB->query($sql);

            //tabla para formatear la salida en formato tabla.
            echo '<table border="1">';
            echo '<tr>';
            echo '<th>Código</th>';
            echo '<th>Descripción</th>';
            echo '<th>password</th>';
            echo '<th>Perfil</th>';
            echo '<th>Fecha Creacion</th>';
            echo '</tr>';
            //while que recorre los campos de la tabla
            while ($campoTabla = $resultadoConsulta->fetchObject()) {
                echo '<tr>';
                echo "<td>" . '<b>' . $campoTabla->CodUsuario . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescUsuario .
                "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->Password .
                "</td>" . "<td>" . '<b>' . $campoTabla->Perfil . "</td>". "<td>" . '<b>' . $campoTabla->FechaHoraUltimaConexion . "</td>";
                echo '</tr>';
            }
            //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
            //mostrar mensaje de errores
            echo'Error: ' . $miExceptionPDO->getMessage();
            echo'Código de error: ' . $miExceptionPDO->getCode();
        } finally {
            //cierre de la conexion
            unset($miDB);
        }
        ?>          
        <br/>
        <br/>
        <footer class="page-footer font-small blue load-hidden">
            <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                <a class="volver" href="MtoDepartamentosmysPDOTema4.php">volver CRUD</a>
            </div>
        </footer> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>



















