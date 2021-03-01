<?php


/**
 * Class Usuario
 */
class Usuario
{
    /**
     * @var ID|string ID del usuario
     */
    private $id;
    /**
     * @var nombre|string Nombre del usuario
     */
    private $nombre;
    /**
     * @var contraseña|string Contraseña del usuario
     */
    private $password;
    /**
     * @var email|string Email del usuario
     */
    private $email;
    /**
     * @var string Permiso del usuario
     */
    private $permiso;
    /**
     * @var string Tabla de usuarios.
     */
    private $tabla;

    /**
     * Usuario constructor.
     * @param $id ID del usuario
     * @param $nombre nombre del usuario
     * @param $password contraseña del usuario
     * @param $email email del usuario
     */
    public function __construct($nombre="", $password="", $email="", $permiso="", $id="")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->email = $email;
        $this->permiso = $permiso;
        $this->tabla = "usuarios";

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * @return mixed
     */
    public function getPermiso()
    {
        return $this->permiso;
    }

    /**
     * @param mixed $permiso
     */

    public function setPermiso($permiso)
    {
        $this->permiso = $permiso;
    }

    /**
     * Metodo para logearse en la aplicación que comprueba que el usuario y la contraseña introducidos sean correctos.
     * @param $nombre nombre a comprobar en la bd
     * @param $password contraseña correspondiente a ese nombre en la bd
     * @return bool retorna true si es correcto o falso si falla.
     */
    public function logearse($nombre, $password){
        $ok =false;
        $sql = "SELECT nombre, `password`, email, permiso FROM ".$this->tabla." 
                WHERE nombre='".$nombre."' AND password='".$password."'";

        $conexion = new Bd();
        $res = $conexion->consultaOneRow($sql);
        if($conexion->numeroElementos()>0){
            $ok = true;
            $this->nombre = $res['nombre'];
            $this->password = $res['password'];
            $this->permiso = $res['permiso'];
            $this->email = $res['email'];
        }else{
            $ok = false;
        }

        return $ok;


    }

    // Registra un usuario siempre y cuando el nombre y el email no esten previamente en la base de datos

    /**
     * Metodo que usa la clase bd para insertar el registro.
     * @param $datos $_POST enviado por el formulario con los datos de registro.
     */
    public function registrarse($datos){


        $conexion = new Bd();

        $conexion->registro($this->tabla,$datos);

    }

    /**
     *  Metodo que usa la base bd para actualizar un usuario
     * @param $datos $_POST enviado por el formulario con los datos actualizados
     * @param $avatar Imagen avatar del usuario a actualizar
     * @param $banner Imagen banner del usuario a actualizar.
     */
    public function editarPerfil($datos, $avatar, $banner){

        $conexion =  new Bd();
        $conexion-> updateBd($this->tabla,$datos,$this->nombre);
    }


}


