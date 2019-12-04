

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
                       <form action="login.php" method="post">
    <select name="lang">
        <option value="ninguno" selected disabled hidden >Idiomas</option>
        <option value="Español"<?php if(isset($_COOKIE["idioma"]) == "Español" ) { echo ""; } ?>>Español</option>
        <option value="Ingles"<?php if( isset($_COOKIE["idioma"]) == "Ingles" ) { echo ""; } ?>>Ingles</option>
        <option value="Frances"<?php if( isset($_COOKIE["idioma"]) == "Frances" ) { echo ""; } ?>>Frances</option>
        <option value="Chino"<?php if( isset($_COOKIE["idioma"]) == "Chino" ) { echo ""; } ?>>Chino</option>
    </select>
    <input type="submit" value="Selecione Idioma">
</form>
        </ul >
    </div>
</nav>




