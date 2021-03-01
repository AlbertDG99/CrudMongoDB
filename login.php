<?php

require_once("modelo/Bd.php");
require_once("modelo/Usuario.php");

//login
if (isset($_POST['login']) && !empty($_POST['login'])) {

    $nombre = addslashes($_POST['nombre']);
    $password = addslashes($_POST['password']);


    $usuario = new Usuario();
    if ($usuario->logearse($nombre, $password)) {
        //el usuario existe
        session_start([
            'cookie_lifetime' => 86400,
        ]);
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['permiso'] = $usuario->getPermiso();
        session_write_close();
        header('Location:Catalogo.php');
    } else {
        echo "Le dijiste UwU a mi novia? D:<";
    }
}

//Registro
if (isset($_POST['registro']) && !empty($_POST['registro'])) {
    $usuario = new Usuario();
    $conexion = new Bd();

    if ($conexion->todoOk($_POST['nombre'], $_POST['email'])) {
        unset($_POST['registro']);
        $usuario->registrarse($_POST);
    }
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
    <title>CRUD Videogames</title>
</head>

<body>
<img class="img-fluid mx-auto d-block my-3 mb-5" src="img/logoTexto.png">
<div id="registro" class="mx-auto w-25 bg-dark text-white rounded p-4 border border-light d-none">
    <h2 class="text-center">¡Registrate!</h2>
    <form id="formularioRegistro" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label>Nombre de usuario</label>
        <input type="text"  class="form-control" name="nombre" placeholder="Usuario" required>
        </div>
            <div class="form-group">
                <label>Contraseña (Min.8 caracteres 1 Mayuscula y 1 Número)</label>
        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
                <div class="form-group">
                    <label>Email</label>
        <input type="email" class="form-control" name="email" placeholder="Correo Electronico" required>
                </div>
        <input type="hidden" name="registro" value="registro">
        <button type="button" class="btn btn-light" name="registro" onclick="validarRegistro()">Registrarse</button>
        <button type="button" class="btn btn-light float-right" onclick="CerrarRegistro()">Salir</button>
    </form>
</div>
<div id="FormuLogin" class="mx-auto w-25 bg-dark text-white rounded p-4 border border-light">

    <form id="formularioLogin" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label>Nombre de usuario</label>
            <input type="text " class="form-control" placeholder="Nombre de usuario" name="nombre" required>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
        </div>
        <input type="hidden" name="login" value="login">
        <button type="button" name="login" class="btn btn-light" onclick="validarLogin()">Login</button>
        <button type="button" class="btn btn-light float-right" onclick="AbrirRegistro()">Registrate</button>
</div>
</form>


</div>


</body>

</html>