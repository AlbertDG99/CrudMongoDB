<?php
require "../modelo/Videojuego.php";
require_once "../modelo/Bd.php";


$id= intval($_GET['id']);

//borro la foto de la BD y su foto
$videojuego= new Videojuego();
$videojuego->borrarImagen($id);

$imagen="";


$imagen="<img class='card-img-top img-thumbnail bg-secondary mt-4 border-dark d-block mx-auto' src='img/ImagenesVideojuegos/default.jpg'>";


echo $imagen;