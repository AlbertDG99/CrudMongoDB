<?php
require_once "modelo/Videojuego.php";
require "modelo/funciones.php";
require "modelo/Plataforma.php";
require "modelo/DAOVideojuegos.php";

session_start();
if (empty($_SESSION['nombre'])) {
    header('Location: login.php');
}
$botonBorrar = "";
$id = "";
$enviar = "Insertar Videojuego";
$plataforma = new Plataforma();
$videojuego = new Videojuego();
//$plataforma->obtenerPlataformas();
if (isset($_POST) && !empty($_POST)) {
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $videojuego->llenarObj($_POST);
        $videojuego->ActualizarVideojuego($id, $_FILES['imagen']);
        header('location:Catalogo.php');
    } else {
        $_POST['idUsu']=$_SESSION['id'];
        $videojuego->llenarObj($_POST);
        $videojuego->insertarVideojuego($_FILES['imagen']);
        header('location:Catalogo.php');
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];
    $videojuego->obtenerVideojuegosID($id);

    if ($videojuego->getImagen() == $videojuego->getCarpeta() . "default.jpg")
        $botonBorrar = "<div id='imagen'><img  class='card-img-top img-thumbnail bg-secondary mt-4 border-dark d-block mx-auto' src='" . $videojuego->getImagen() . "'></div>";
    else
        $botonBorrar = "<div id='imagen'><img  class='card-img-top img-thumbnail bg-secondary mt-4 border-dark d-block mx-auto' src='" . $videojuego->getImagen() . "'></div><input type='button' class='btn btn-dark marginado btn-outline-light mt-2' value='Borrar Imagen' onclick='BorrarImagen(`" . $id . "`)'>";

    $enviar = "Editar Videojuego";


}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles/IndexStyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"/>
    <script type="text/javascript" src="scripts/scripts.js"></script>
    <link rel="icon" href="./img/logo.png">
    <title>CRUD Videogames - Insertar</title>
</head>
<body>
<?php
include "includes/navbar.php";
?>

<div class="container-fluid mx-auto animated zoomIn ">
    <h1 class="text-center mt-4  mr-4 ">¡Inserta un Videojuego!</h1>
    <form id="Form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-3 ml-auto">
                <label class="font-weight-bold text-light">Titulo</label>
                <input name="nombre" type="text" class="form-control" placeholder="Titulo del Videojuego"
                       value="<?php echo($videojuego->getNombre()) ?>">
            </div>
            <div class="form-group col-md-3 mr-auto">
                <div class="form-row">
                    <div class="form-group col-md-11 mr-auto">
                        <label class="font-weight-bold text-light">Plataforma</label>
                        <select name="plataforma" class="custom-select">
                            <option value="<?php if ($videojuego->getPlataforma() != "") echo($videojuego->getPlataforma()); else echo("PC") ?>"
                                    selected><?php if ($videojuego->getPlataforma() != "") echo($videojuego->getPlataforma()); else echo("PC") ?></option>
                            <?php
                            echo $plataforma->mostrarPlataformas();
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1 mt-auto">
                        <button type="button" class="btn btn-light">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3 ml-auto">
                <label class="font-weight-bold text-light">Género</label>
                <input name="genero" type="text" class="form-control" value="<?php echo($videojuego->getGenero()) ?>"
                       placeholder="Género del Videojuego">
            </div>
            <div class="form-group col-md-3 mr-auto">
                <label class="font-weight-bold text-light">Fecha de Lanzamiento</label>
                <input name="fecha" type="date" value="<?php echo($videojuego->getFecha()) ?>" class="form-control"
                       placeholder="Fecha de Lanzamiento">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 mx-auto">
                <label class="font-weight-bold text-light">Comentarios</label>
                <textarea id="comentario" name="comentario" class="form-control h-100"
                          placeholder="Inserta tus comentarios Max 70c. (Opcional)"><?php echo($videojuego->getComentario()) ?></textarea>
            </div>
        </div>
        <div class="form-row mt-5">
            <div class="form-group  col-md-3  ml-auto">
                <label class="font-weight-bold text-center text-light">Valoración</label>
                <div class="star-rating form-group px-auto">
                    <fieldset id="Estrellas">
                        <input name="valoracion" <?php if ($videojuego->getValoracion() == 5) echo("checked") ?>
                               type="radio" id="star5" name="rating" value="5"/><label for="star5"
                                                                                       title="Fantastico!">5
                            stars</label>
                        <input name="valoracion"<?php if ($videojuego->getValoracion() == 4) echo("checked") ?>
                               type="radio" id="star4" name="rating" value="4"/><label for="star4"
                                                                                       title="Muy Bueno">4
                            stars</label>
                        <input name="valoracion"<?php if ($videojuego->getValoracion() == 3) echo("checked") ?>
                               type="radio" id="star3" name="rating" value="3"/><label for="star3"
                                                                                       title="Bueno">3
                            stars</label>
                        <input name="valoracion"<?php if ($videojuego->getValoracion() == 2) echo("checked") ?>
                               type="radio" id="star2" name="rating" value="2"/><label for="star2"
                                                                                       title="Malo">2
                            stars</label>
                        <input name="valoracion"<?php if ($videojuego->getValoracion() == 1) echo("checked") ?>
                               type="radio" id="star1" name="rating" value="1"/><label for="star1"
                                                                                       title="Muy Malo">1
                            star</label>
                    </fieldset>
                </div>
            </div>
            <div class="form-group  col-md-3  mr-auto">
                <label class="font-weight-bold text-light">Caratula del Juego</label>
                <div class="custom-file">
                    <input name="imagen" type="file" class="custom-file-input">
                    <label class="custom-file-label">Elige un Archivo</label>
                </div>
                <?php echo($botonBorrar) ?>
            </div>
        </div>
        <div class="form-group  col-md-2 mx-auto ">
            <input type="button" class="btn btn-dark  btn-outline-light" onclick="validar('Form')"
                   value="<?php echo($enviar) ?>">

        </div>
        <input type="hidden" name="id" value="<?php echo($videojuego->getID()) ?>">
    </form>
    <div class="container bg-light text-dark rounded p-2 my-4 font-weight-bold" style="display: none"
         id="listaErrores"></div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</body>
</html>