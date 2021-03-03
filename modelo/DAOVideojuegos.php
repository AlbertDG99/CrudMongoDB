<?php


class DAOVideojuegos
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



    public  function insertarVideojuego($videojuego)
    {

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->insert(['nombre' => $videojuego->getNombre(), 'plataforma' => $videojuego->getPlataforma(), 'genero' => $videojuego->getGenero(), 'fecha' => $videojuego->getFecha(), 'valoracion' => $videojuego->getValoracion(), 'comentario' => $videojuego->getComentario(), 'imagen' => $videojuego->getImagen()]);

        $this->connection->executeBulkWrite("GamesAdmin.videojuegos", $bulk);

    }

    public  function updateVideojuego($videojuego)
    {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($videojuego->getId())];
        $bulk = new MongoDB\Driver\BulkWrite;
        if($videojuego->getImagen()!="")
        $collation = ['$set' => ['nombre' => $videojuego->getNombre(), 'plataforma' => $videojuego->getPlataforma(), 'genero' => $videojuego->getGenero(), 'fecha' => $videojuego->getFecha(), 'valoracion' => $videojuego->getValoracion(), 'comentario' => $videojuego->getComentario(), 'imagen' => $videojuego->getImagen()]];
        else
            $collation = ['$set' => ['nombre' => $videojuego->getNombre(), 'plataforma' => $videojuego->getPlataforma(), 'genero' => $videojuego->getGenero(), 'fecha' => $videojuego->getFecha(), 'valoracion' => $videojuego->getValoracion(), 'comentario' => $videojuego->getComentario()]];
        $bulk->update($filter, $collation);
        $this->connection->executeBulkWrite('GamesAdmin.videojuegos', $bulk);
    }

    public  function listarVideojuegos()
    {
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        return $this->connection->executeQuery("GamesAdmin.videojuegos", $query);
    }

    public  function borrarVideojuego($id)
    {
        $bulk = new MongoDB\Driver\BulkWrite;

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $bulk->delete($filter, ['limit' => 0]);

        $this->connection->executeBulkWrite('GamesAdmin.videojuegos', $bulk);

    }

    public  function obtenerVideojuego($id)
    {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $query = new MongoDB\Driver\Query($filter);
        return $this->connection->executeQuery("GamesAdmin.videojuegos", $query);
    }

    public  function borrarImagen($id)
    {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $bulk = new MongoDB\Driver\BulkWrite;
        $collation = ['$set' => ['imagen' => ""]];
        $bulk->update($filter, $collation);
        $this->connection->executeBulkWrite('GamesAdmin.videojuegos', $bulk);
    }
}