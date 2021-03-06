<?php


class DAOUsuario
{
    private $connection;
    private static $instance = null;

    /**
     * DAOVideojuegos constructor.
     * @param $connection
     */
    public function __construct()
    {
        $this->connection = new MongoDB\Driver\Manager("mongodb://localhost:27017");;
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function todoOk($nombre, $email)
    {
        $ok = true;

        if (!$this->disponibilidad("nombre", $nombre)) {
            $ok = false;
            echo("<script>alert('Ya existe un usuario con este Nombre')</script>");
        }

        if (!$this->disponibilidad("email", $email)) {
            $ok = false;
            echo("<script>alert('Ya existe un usuario con este Email')</script>");
        }

        return $ok;

    }

    public function disponibilidad($campo, $valor)
    {
        $ok = true;

        $filter = [$campo => $valor];
        $query = new MongoDB\Driver\Query($filter);
        $rows = $this->connection->executeQuery("GamesAdmin.usuarios", $query);

        foreach ($rows as $document) {
            $ok = false;
        }

        return $ok;
    }


    public function insertarUsuario($usuario){

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->insert(['nombre' => $usuario["nombre"], 'email' => $usuario["email"], 'password' => $usuario["password"]]);

        $this->connection->executeBulkWrite("GamesAdmin.usuarios", $bulk);
    }

    public function loginUsuario($nombre, $password){
        $filter = ['nombre' => $nombre, 'password'=>$password];
        $query = new MongoDB\Driver\Query($filter);
        return $this->connection->executeQuery("GamesAdmin.usuarios", $query);
    }
}