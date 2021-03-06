<?php
require "../modelo/Videojuego.php";
require_once "../modelo/DAOVideojuegos.php";

$busqueda = $_GET['busqueda'];

$lista = new listaVideojuegos();

//Pido de nuevo la lista de elementos y la envio a ajax

$lista->obtenerLista($busqueda);

echo $lista->mostrarVideojuegos();