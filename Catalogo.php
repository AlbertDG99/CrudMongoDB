<?php
require "modelo/Videojuego.php";
require "modelo/funciones.php";
require "modelo/DAOVideojuegos.php";


session_start();
if(empty($_SESSION['nombre'])){
    header('Location: login.php');
}

$busqueda = "";
$catalogo = new listaVideojuegos();
if (isset($_POST) && !empty($_POST)) {
    $busqueda = $_POST['buscar'];
}
$catalogo->obtenerLista($busqueda);
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles/IndexStyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <link rel="icon" href="./img/logo.png">
    <title>CRUD Videogames - Catálogo</title>
</head>
<body>
<?php
include "includes/navbar.php";
?>
<!--<form id="Buscador" class="form-inline d-flex  justify-content-center md-form form-sm mt-2 mb-4"
      action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"> -->
<div class="form-inline d-flex  justify-content-center md-form form-sm mt-2 mb-4">
    <input id="buscador" name="buscar" class="form-control form-control-sm mr-3 w-25" type="text" placeholder="Search"
           aria-label="Search">
    <button type="button" onclick="limpiarBuscador()" class="btn btn-light btn-sm font-weight-bold">Mostrar Todos
    </button>
</div>
<div id="catalogo" class='cards-columns d-flex w-75 flex-wrap justify-content-around mx-auto mb-5'>
    <?php
    echo $catalogo->mostrarVideojuegos();
    ?>
</div>


</body>
