<?php


class DAOVideojuegos
{

    public static function insertarVideojuego($videojuego)
    {
        $connection = new MongoDB\Driver\Manager("mongodb://localhost:27017");

        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->insert(['nombre' => $videojuego->getNombre(), 'plataforma' => $videojuego->getPlataforma(), 'genero' => $videojuego->getGenero(), 'fecha' => $videojuego->getFecha(), 'valoracion' => $videojuego->getValoracion(), 'comentario' => $videojuego->getComentario(), 'imagen'=> $videojuego->getImagen()]);

        $connection->executeBulkWrite("GamesAdmin.videojuegos", $bulk);

    }

    public static function updateVideojuego(Videojuego $param)
    {



    }

    public static function listarVideojuegos()
    {
        $connection= new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $filter = [];
        $query = new MongoDB\Driver\Query($filter);
        return $connection->executeQuery("GamesAdmin.videojuegos", $query);
    }

    public static function borrarVideojuego($id)
    {
        $connection= new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;

        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $bulk->delete($filter, ['limit' => 0]);

        $connection->executeBulkWrite('GamesAdmin.videojuegos', $bulk);

    }
}