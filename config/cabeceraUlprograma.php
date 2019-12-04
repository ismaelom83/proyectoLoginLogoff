

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
                <a class="nav-link" href="../../proyectoTema5/tema5.php">VOLVER</a>
            </li>           
            <form action="../config/idiomas.php" method="post">
    <select name="lang">
        <option value="ninguno" selected disabled hidden >Idiomas</option>
        <option value="Español"<?php if(isset($_COOKIE["idioma"]) == "Español" ) { echo ""; } ?>>Español</option>
        <option value="English"<?php if( isset($_COOKIE["idioma"]) == "English" ) { echo ""; } ?>>Ingles</option>
        <option value="Francaise"<?php if( isset($_COOKIE["idioma"]) == "Francaise" ) { echo ""; } ?>>Frances</option>
    </select>
    <input type="submit" value="Selecione Idioma">
</form>
        </ul >
    </div>
</nav>




