





<!DOCTYPE html>

<html>
    <head>
        <title>Ejercicio2 Tema5</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilosEjer.css">
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

                    <li class="nav-item">
                        <a class="nav-link" href="../../proyectoTema5/tema5.php">VOLVER  </a>
                    </li>
                </ul >
            </div>
        </nav>

    </header>
    <body>
        <main>
            <h1 class="login">LOGIN</h1>
            <?php
            /**
              @author Ismael Heras Salvador
              @since 28/11/2019
             */
            session_start();

            require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
            require '../config/constantes.php'; //requerimos las constantes para la conexion
            define('OBLIGATORIO', 1); //constante que define que un campo es obligatorio.
            define('NOOBLIGATORIO', 0); //constante que define que un campo NO es obligatorio.
            //manejo de las variables del formulario
            $aFormulario = ['usuario' => null,
                'password' => null];
            //si el boton se ha pulsado ejecutamos el else y asignamos los valores de los imputs a nuestro array.
            if (isset($_POST['entrar']) && $_POST['entrar'] == 'Entrar') {

                //el valor del array ahora es igual al de los campos recogidos en el formulario.
                $usuario = $aFormulario['usuario'] = $_POST['usuario'];
                $passwd = $aFormulario['password'] = $_POST['password'];

                //si no estan los dos campos rellenos no los manda
            } if (!empty($_POST['usuario']) && !empty($_POST['password'])) {

                try {
                    //conexion a la base de datos.
                    $miBD = new PDO(MAQUINA, USUARIO, PASSWD);
                    $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //try cacth por si falla la conexion.
                } catch (PDOException $excepcionPDO) {
                    die("Error al conectarse a la base de datos");
                }

                try {
                    //con este query buscamos en la base de datos
                    $SQL = "SELECT * FROM Usuario WHERE CodUsuario = :user AND Password = :hash";
                    //almacenamos en una variable (objeto PDOestatement) la consulta preparada
                    $oPDO = $miBD->prepare($SQL);
                    //blindeamos los parametros
                    $oPDO->bindValue(':user', $usuario);
                    //la contraseña es paso, pero para resumirla -> sha + contraseña=concatenacion de nombre+password
                    $oPDO->bindValue(':hash', hash('sha256', $usuario . $passwd));
                    $oPDO->execute();
                    //almacenamos todos los datos de la consulta en un array.
                    $resultado = $oPDO->fetch(PDO::FETCH_ASSOC);
                    //recorremos todos los campos de la base de datos y si coincide en uno ejecuta el if y nos redireciona
                    //a la pagina programa.php, si no ejecuta el else i nos dice que el usuario no es correcto
                    //que no existe el usuario.

                    if ($oPDO->rowCount() == 1) {
                        //almacenamos en la sesion el nombre del usuario.
                        $_SESSION['claveUsuario'] = $resultado['DescUsuario'];
                        //con header nos redirreciona a programa.php
                        header('Location: programa.php');
                    } else {
                        ?>
                        <h1>Usuario Incorrecto</h1><br>
                        <input type="button" class="btn btn-warning" value="ReintentarLogin" onclick="location = 'login.php'">
                        <input type="button" class="btn btn-danger" value="SalirDeLaAplicacion" onclick="location = '../../proyectoTema5/tema5.php'">
                        <?php
                    }
                    //cath que se ejecuta si habido un error
                } catch (PDOException $excepcion) {
                    echo "<h1>Se ha producido un error</h1>";
                    //nos muestra el error que ha ocurrido.
                    echo $excepcion->getMessage();
                } finally {
                    unset($miBD); //cerramos la conexion a la base de datos.
                }
            } else {

                //si se envia el formulario este desaparece.
                ?>
               
                <div class="wrap">
                    <form action="" method="post">
                        <fieldset>

                            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario:" value="<?php
                            if (isset($_POST['usuario'])) { //comprobamos si ha introducido algo en el campo y que el array de errores este a null
                                echo $_POST['usuario']; //aunque se muestre un campo mal el valor si es correcto se mantiene.
                            }
                            ?>">

                            <br>

                            <input type="text" name="password" id="password" class="form-control" placeholder="Password:" value="<?php
                            if (isset($_POST['password'])) { //comprobamos si ha introducido algo en el campo y que el array de errores este a null
                                echo $_POST['password']; //aunque se muestre un campo mal el valor si es correcto se mantiene.
                            }
                            ?>">                       
                            <br>
                            <br>
                            <div class="botones2">
                                <input type="submit" name="entrar"  value="Entrar" class="form-control  btn btn-primary mb-1">
                            </div>
                        </fieldset>
                    </form>
                </div>                       
            <?php } ?>
            <br/>
            <br/>

            <footer class="page-footer font-small blue load-hidden">
                <div class="footer-copyright text-center py-3"> <a href="../../../index.php">© 2019 Copyright: Ismael Heras Salvador</a> 
                    <a href="http://daw-usgit.sauces.local/heras/proyectoTema5/tree/master"><img  src="../img/gitLab.png" alt=""></a>
                    <a href="https://github.com/ismaelom83/proyectoLoginLogoff"><img  src="../img/gitHub.png" alt=""></a>
                    <a href="../../proyectoTema5/tema5.php">Salir De La Aplicacion</a> 
                </div>

            </footer> 
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </main>
    </body>

</html>