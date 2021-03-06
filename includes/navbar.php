
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="./img/logo.png" width="60px" height="30px" class="d-inline-block align-top" alt="">
        GamesAdmin
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="Insertar.php">Insertar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Catalogo.php">Catálogo</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class=" nav-link" >Sesión iniciada: <?php echo($_SESSION['nombre'])?> </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class=" nav-link" >Cerrar Sesion</a>
            </li>
        </ul>
    </div>
</nav>