
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
            <?php; ?>
            <h1 class="login"><b>REGISTRO</b></h1>
            <h3>ir a <a href="login.php"><b>Login</b></a></h3><br>
            <?php
         
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
                            <br>
                            <div class="botones2">
                                <input type="submit" name="entrar"  value="Entrar" class="form-control  btn btn-primary mb-1">
                            </div>
                        </fieldset>
                    </form>
                </div>                       
        
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
