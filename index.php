<?php
session_start();
if(empty($_SESSION['nombre'])){
    header('Location: login.php');
}
else{
    header('Location: Catalogo.php');
}


