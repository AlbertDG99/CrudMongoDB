<?php
require "../modelo/Videojuego.php";
require_once "../modelo/Bd.php";

$id = intval($_GET['id']);

//borro el elemento de la BD y su foro
$juego = new Videojuego();
$juego->borrarVideojuego($id);


//Pido de nuevo la lista de elementos y la envio a ajax

$juego->obtenerVideojuegos("");


echo $juego->mostrarVideojuegos();