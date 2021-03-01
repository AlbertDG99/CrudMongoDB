<?php

class Bd
{

    /**
     * @var Servidor al que nos conectaremos
     */
    private $server = "localhost";
    /**
     * @var Usuario del servidor
     */
    private $usuario = "root";
    /**
     * @var Contraseña del servidor
     */
    private $pass = "";
    /**
     * @var nombre de la base de datos del servidor
     */
    private $basedatos = "crudvideogames";
    /**
     * @var conexión a la base ded atos
     */
    private $conexion;
    /**
     * @var resultado de las distintas querys de la base de datos.
     */
    private $resultado;

    /**
     * Bd constructor.
     * Constructor de la base de datos, que servirá para realizar todas las llamadas.
     */
    public function __construct()
    {
        $this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->basedatos);
        $this->conexion->select_db($this->basedatos);
        $this->conexion->query("SET NAMES 'utf8'");
    }

    //añade datos a la Base de datos
    // tabla es el nombre de la tabla donde vamos a hacer el select
    // datos es el formulario que pasamos por el post

    /**
     * Este metodo añade los elementos pasados por el post y la foto a la base de datos, y guarda la imagen en la carpeta correspondiente despues de realizar la validación.
     * @param $tabla tabla de la base de datos en la que queremos almacenar los datos.
     * @param $datos elementos pasados por $_POST que serán extraidos en claves y valores para la inserción en BD.
     * @param $carpeta Carpeta en la que se insertarán las imagenes.
     * @param $foto Imagen de la cual se guardará el nombre en la Base de datos y el archivo en el servidor
     * @return bool|mysqli_result Retornará true si todo ha ido bien o false si ha fallado la inserción.
     */
    public function addBd($tabla, $datos, $carpeta,$foto)
    {
        $claves = array();
        $valores = array();

        //Recojemos todas las claves y valores insertandolas en los arraylist de claves y valores
        foreach ($datos as $clave => $valor) {

            $claves[] = $clave;
            $valores[] = "'" . $valor . "'";

        }

        if($foto['name'] !=""){
            $ruta=subirFoto($foto,$carpeta);
            $claves[] ="imagen";
                $valores[]="'".$ruta."'";
        }

        //Sentencia Sql de la insercion de datos.
        $sql = "INSERT INTO " . $tabla . " (" . implode(',', $claves) . ") VALUES  (" . implode(',', $valores) . ")";

        $this->resultado = $this->conexion->query($sql);
        $res = $this->resultado;

        return $res;

    }

    /**
     * Este metodo actualiza los elementos pasados por el post y la foto a la base de datos, y guarda la imagen en la carpeta correspondiente despues de realizar la validación, borrando la imagen a la que reemplazará.
     * @param $id ID del elemento del que se quieren actualizar los datos.
     * @param $tabla Nombre de la tabla en la que se quieren insertar los elementos
     * @param $datos elementos pasados por $_POST que serán extraidos en claves y valores para la inserción en BD.
     * @param string $foto Imagen de la cual se guardará el nombre en la Base de datos y el archivo en el servidor, borrando del servidor a la que reemplaza.
     * @param string $carpeta Carpeta en la que se guardarán las fotos en el servidor ftp.
     */
    public function updateBD($id, $tabla, $datos, $foto = "", $carpeta = "")
    {

        $sentencias = array();

        foreach ($datos as $campo => $valor) {
                $sentencias[] = $campo . "='" . addslashes($valor) . "'";
                //UPDATE tabla SET nombreCampo = 'valor1', nombreCampo='valor'....
            }



        if (strlen($foto['name']) > 0) {

            $this->borrarFoto($id, $tabla);


            $ruta = subirFoto($foto, $carpeta);
            $sentencias[] = "imagen='" . $ruta . "'";
        }


        $campos = implode(",", $sentencias);
        $sql = "UPDATE ".$tabla." SET " . $campos . " WHERE id= " . $id;
        echo($sql);
        $conexion = new Bd();
        //echo $sql;
        $conexion->consulta($sql);
    }


    /**
     * Metodo para eliminar las imagenes del servidor realizando una llamada a la base de datos para obtener el nombre de dicha imagen asociada al ID proporcionado.
     * @param $id ID de la imaagen a eliminar
     * @param $tabla Tabla en la que se encuentra el nombre de la imagen a eliminar.
     */
    public function borrarFoto($id, $tabla)
    {

        $sql = "select imagen from " . $tabla . " WHERE id = " . $id;

        $this->resultado = $this->conexion->query($sql);

        if ($this->numeroElementos() > 0) {

            $res = mysqli_fetch_assoc($this->resultado);
            if (file_exists("img/ImagenesVideojuegos/".$res['imagen'])) {
                $rutaAborrar ='img/ImagenesVideojuegos/'.$res['imagen'];
                if (!unlink($rutaAborrar)) {
                    echo("Error de escritura en el servidor, contacte con su administrador en el mail ......");
                }

            }
        }

    }

    /**
     * Función que registra al usuario con su usuario, contraseña, email y nivel de permisos
     * @param $tabla Tabla en la que se guardarán los datos enviados.
     * @param $datos Datos y credenciales del usuario a guardar en la base de datos
     * @return bool|mysqli_result Devuelve true si todo es correcto o false si se produce algun error para evitar falsos registros.
     */
    public function registro($tabla, $datos)
    {
        $claves  = array();
        $valores = array();

        //Recojemos todas las claves y valores insertandolas en los arraylist de claves y valores
        foreach ($datos as $clave => $valor) {

            $claves[] .= $clave;
            $valores[] .= "'" . $valor . "'";
        }

        //$valores[1] = "'".md5($valores[1])."'";

        //Sentencia Sql de la insercion de datos.
        $sql = "INSERT INTO " . $tabla . " (" . implode(',', $claves) . ") VALUES  (" . implode(',', $valores) . ")";


        $this->resultado =   $this->conexion->query($sql);
        $res = $this->resultado;

        return $res;
    }

    /**
     * Metodo usado por las demás clases para realizar llamadas a la base de datos
     * @param $consulta consulta en MYSQL que se realizará a la bd.
     * @return bool|mysqli_result Retrorna lo encontrado.
     */
    public function consulta ($consulta){
        $this->resultado = $this->conexion->query($consulta);
        $res = $this->resultado;
        return $res;
    }

    /**
     * Metodo usado por las demás clases para realizar consultas a la base de datos y retornar varios datos en un array
     * @param $consulta consulta en MYSQL que se realizará a la bd.
     * @return string[]|null elementos retornados de la BD.
     */
    public function consultaOneRow($consulta)
    {

        //echo $consulta;

        $this->resultado =   $this->conexion->query($consulta);
        $res = mysqli_fetch_assoc($this->resultado);

        return $res;
    }

    /**
     * Método usado para comprobar si ya existe un elemento en la base de datos, para evitar repeticiones.
     * @param $campo 1er dato a comparar
     * @param $dato 2ndo dato a comparar
     * @return bool devuelve true si no ha encontrado ninguna coincidencia o false si si.
     */
    public function disponibilidad($campo, $dato)
    {
        $ok = false;

        $sql = "SELECT id FROM usuarios where " . $campo . " = '" . $dato . "'";
        $this->resultado = $this->conexion->query($sql);
        $res = $this->resultado;
        if ($res != "") {
            if ($res->num_rows == 0)
                $ok = true;
        }

        return $ok;
    }


    /**
     * Metodo para contar el numero de elementos de un array.
     * @return mixed Retorna el numero de elementos.
     */
    public function numeroElementos()
    {
        $num = $this->resultado->num_rows;
        return $num;
    }

    //Esta funcion comprueba si existe algun usuario en la base de datos
    //el email y el nombre coincide con los que el usuario ha introducido en el formulario de registro

    /**
     * Metodo que comprueba la disponibilidad del usuario y el email para la gente que se quiera registrar
     * @param $nombre Nombre a comprobar en la base de datos
     * @param $email Email a comprobrar en la base de datos.
     * @return bool retorna true si no ha encontrado coincidencias o false si si.
     */
    public function todoOk($nombre, $email)
    {

        $ok = true;

        if (!($this->disponibilidad("nombre", $nombre))) {
            $ok = false;
            echo ("Ese nombre de usuario ya existe");
        }

        if (!($this->disponibilidad("email", $email))) {
            $ok = false;
            echo ("Ya existe un usuario con ese email");
        }

        return $ok;
    }
}
