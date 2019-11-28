<!DOCTYPE html>

<html>
    <head>
        <title>Ejercicio0 Tema5</title>
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
                        <a class="nav-link" href="../login.php">VOLVER  </a>
                    </li>
                </ul >

            </div>
        </nav>

    </header>
    <body>
        <main>
            <br>
            <h1>Usuario Correcto, Estas en la pagina programa.php</h1>
            <br>
             <input type="button" class="btn btn-warning" value="VolverLogin" onclick="location = 'login.php'">
            <?php
            
            //Iniciar una nueva sesión o reanudar la existente
           session_start();
             require '../config/constantes.php'; //requerimos las constantes para la conexion
             try {
                    //conexion a la base de datos.
                    $miBD = new PDO(MAQUINA, USUARIO, PASSWD);
                    $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 //try cacth por si falla la conexion.
            } catch (PDOException $excepcionPDO) {
                die("Error al conectarse a la base de datos");
            }
          
            try {
      
                //si existe la variable que antes hemos definido en login.php preparamos la consulta para saber todos los datos de usuario
                //almacenados en el array que preparamos en login.php
             if (isset($_SESSION['claveUsuario'])) {                
                        //query para saber los datos de la sesion del usuario con una consulta preparada ya que en la variable sesion 
                 //almacenamos el DescUsuario del usuario preguntamos por ese campo y sacamos todos los campos de ese registro que queramos.
                        $oPDO = $miBD->prepare('SELECT * FROM Usuario WHERE DescUsuario =:id');
                        $oPDO->bindParam(':id',$_SESSION['claveUsuario']);
                        $oPDO->execute();                     
                        $user = null;
                        //obtenemos un array de los datos que pedimos en el query anterior.                   
                       $resultado = $oPDO->fetch(PDO::FETCH_ASSOC);
                       //si ha habido algun resultado entonces con la variable que antes inicializamos a null 
                       //introducimos en esa variable cada uno de los campos del array para luego utilizarla para sacar el campo que queramos.
                       if(count($resultado) > 0){
                           $user = $resultado;
                       }
                    }
                    
                    //muestra por pantalla los datos que queramos del la sesion del usuario.
                    echo "<br>";
                    echo "<br>";
                    echo "Hola ".$user['DescUsuario']." Te has logeado correctamente";
                    echo "<br>";
                    echo "Tu clave es :".$user['Password'];
                    echo "<br>";
                     echo "Tu perfil de usuario es :".$user['Perfil'];
                     echo "<br>";
                    echo "La fecha y hora de la crecion del registro es :".$user['FechaHoraUltimaConexion'];
                    
                         //cath que se ejecuta si habido un error
                } catch (PDOException $excepcion) {
                    echo "<h1>Se ha producido un error</h1>";
                    //nos muestra el error que ha ocurrido.
                    echo $excepcion->getMessage();
                } finally {
                    unset($miBD); //cerramos la conexion a la base de datos.
                }
            ?> 
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
