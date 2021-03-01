<?php
require_once("Bd.php");

/**
 * Class Videojuego
 */
class Videojuego
{
    /**
     * @var string ID del videojuego
     */
    private $id;
    /**
     * @var string Nombre del videojuego
     */
    private $nombre;
    /**
     * @var string Plataforma del videojuego
     */
    private $plataforma;
    /**
     * @var string Genero del videojuego
     */
    private $genero;
    /**
     * @var string fecha de salida del videojuego
     */
    private $fecha;
    /**
     * @var string imagen del videojuego
     */
    private $imagen;
    /**
     * @var string valoración sobre 5 del videojuego
     */
    private $valoracion;
    /**
     * @var string comentario del videojuego (max.70c)
     */
    private $comentario;
    /**
     * @var array lista de videojuegos
     */
    private $lista;
    /**
     * @var string carpeta en la que se guardarán las imagenes de los videojuegos
     */
    private $carpeta;

    /**
     * Videojuego constructor.
     * @param $id
     * @param $nombre
     * @param $plataforma
     * @param $genero
     * @param $fecha
     * @param $imagen
     * @param $valoracion
     * @param $comentario
     * @param $lista
     */
    public function __construct($id = "", $nombre = "", $plataforma = "", $genero = "", $fecha = "", $imagen = "", $valoracion = "", $comentario = "", $lista = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->plataforma = $plataforma;
        $this->genero = $genero;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
        $this->valoracion = $valoracion;
        $this->comentario = $comentario;
        $this->lista = array();
        $this->carpeta = "img/ImagenesVideojuegos/";
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getPlataforma()
    {
        return $this->plataforma;
    }

    /**
     * @param string $plataforma
     */
    public function setPlataforma($plataforma)
    {
        $this->plataforma = $plataforma;
    }

    /**
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param string $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    /**
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * @return string
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

    /**
     * @param string $valoracion
     */
    public function setValoracion($valoracion)
    {
        $this->valoracion = $valoracion;
    }

    /**
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param string $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    /**
     * Metodo para insertar un videojuego en la base de datos haciendose uso del metodo addBd de la clase Bd.
     * @param $datos $_POST con los datos del formulario de inserción de videojuego
     * @param $foto imagen del videojuego.
     */
    public function insertarVideojuego($datos, $foto)
    {
        $conexion = new Bd();

        $conexion->addBd("Videojuegos", $datos, $this->carpeta, $foto);

    }

    /**
     * Metodo para actualizar un videojuego en la base de datos haciendose uso del metodo updateBD de la clase Bd.
     * @param $datos $_POST con los datos del formulario de inserción de videojuego
     * @param $id ID del videojuego a actualizar.
     * @param $foto imagen del videojuego.
     */
    public function ActualizarVideojuego($datos, $id, $foto)
    {
        $conexion = new Bd();

        $conexion->updateBd($id, "videojuegos", $datos, $foto, "img/ImagenesVideojuegos/");

    }

    /**
     * Metodo para obtener videojuegos mediante su ID con una select a la base de datos, guardando lo obtenido en los atributos del objeto.
     * @param $id ID del videojuego a obtener.
     */
    public function obtenerVideojuegosID($id)
    {
        $sql = "select videojuegos.id, videojuegos.nombre, plataformas.nombre,videojuegos.genero,videojuegos.fecha,videojuegos.imagen,videojuegos.valoracion,videojuegos.comentario FROM videojuegos left join plataformas on videojuegos.plataforma=
plataformas.id where videojuegos.id = " . $id;
        $conexion = new Bd();
        $res = $conexion->consulta($sql);
        list($id, $nombre, $plataforma, $genero, $fecha, $imagen, $valoracion, $comentario) = mysqli_fetch_array($res);
        if ($conexion->numeroElementos() > 0) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->plataforma = $plataforma;
            $this->genero = $genero;
            $this->fecha = $fecha;
            if ($imagen != "")
                $this->imagen = $this->carpeta . $imagen;
            else
                $this->imagen = $this->carpeta . "default.jpg";
            $this->valoracion = $valoracion;
            $this->comentario = $comentario;

        }
    }

    /**
     * Metodo para obtener todos los videojuegos o los deseados mediante la busqueda
     * @param $busqueda nombre del videojuego a buscar.
     */
    public function obtenerVideojuegos($busqueda)
    {
        $sql = "select videojuegos.id, videojuegos.nombre, plataformas.nombre,videojuegos.genero,videojuegos.fecha,videojuegos.imagen,videojuegos.valoracion,videojuegos.comentario FROM videojuegos left join plataformas on videojuegos.plataforma=
plataformas.id where videojuegos.nombre like '%" . $busqueda . "%'";
        $conexion = new Bd();
        $res = $conexion->consulta($sql);

        while (list($id, $nombre, $plataforma, $genero, $fecha, $imagen, $valoracion, $comentario) = mysqli_fetch_array($res)) {
            if ($imagen == "")
                $juego = new Videojuego($id, $nombre, $plataforma, $genero, $fecha, "default.jpg", $valoracion, $comentario);
            else
                $juego = new Videojuego($id, $nombre, $plataforma, $genero, $fecha, $imagen, $valoracion, $comentario);
            array_push($this->lista, $juego);
        }
    }

    /**
     * Borra la imagen de un videojuego de la base de datos buscandola por ID
     * @param $id ID del videojuego del que queremos borrar la imagen
     */
    public function borrarImagen($id)
    {
        $conexion = new Bd();
        $sql = "UPDATE videojuegos SET imagen='' WHERE id=" . $id;
        $conexion->consulta($sql);
        $conexion->borrarFoto($id, "videojuegos");

    }

    /**
     * Metodo para borrar un videojuego de la base de datos y su imagen correspondiente del servidor.
     * @param $id ID del videojuego a borrar
     */
    public function borrarVideojuego($id)
    {
        $conexion = new Bd();
        $sql = "DELETE from videojuegos WHERE id=" . $id;
        $conexion->consulta($sql);
        $conexion->borrarFoto($id, "videojuegos");

    }

    /**
     * Metodo para mostrar todos los videojuegos previamente obtenidos en html usando la función.
     * @return string HTML Con los videojuegos bien mostrados.
     */
    public function mostrarVideojuegos()
    {

        $html = "";
        for ($i = 0; $i < sizeof($this->lista); $i++) {
            $html .= $this->lista[$i]->imprimeteEnTr();
        }

        return $html;
    }

    /**
     * Metodo para crear la 'card' de cada videojuego con sus atributos correspondientes y bien cumplimentadas.
     * @return string devuelve la tarjeta con todo su html.
     */
    public function imprimeteEnTr()
    {
        $html = "
    <div class='card bg-dark text-white border-secondary mx-auto mb-3' style='width:16rem'>
      <div id='" . $this->id . "A' class='card-body d-flex flex-column'>
    <img class='card-img-top img-thumbnail bg-secondary mb-4 border-dark d-block mx-auto' src='" . $this->carpeta . $this->imagen . "'>
    <h5 class='card-title font-weight-bold border-bottom mr-auto'>" . $this->nombre . "</h5>
    <a href='javascript:void();' class='btn btn-secondary align-self-end mt-auto mr-auto' onclick='masInformacion(" . $this->id . ")'>Más Información</a>
    </div >
      <div id='" . $this->id . "B' class='card-body flex-column' style='display:none'>
    <h5 class='card-title font-weight-bold border-bottom mr-auto'>" . $this->nombre . "</h5>
        <p class='card-text text-wrap' style='max.height:1rem'>Comentario: " . $this->comentario . "</p>
    <p class='card-text'>Genero: " . $this->genero . "</p>
    <p class='card-text'>Lanzamiento: " . $this->fecha . "</p>
    <p class='card-text'>Plataforma: " . $this->plataforma . "</p>
    <p class='card-text font-weight-bold'>Valoracion: " . $this->valoracion . "/5</p>
    <div class='btn-toolbar align-self-end mt-auto mr-auto'>
    <a href='javascript:void();' class='btn btn-secondary  mx-2 d-inline-block' onclick='cerrarInformacion(" . $this->id . ")'>Cerrar</a>
    <a href='Insertar.php?id=" . $this->id . "' class='btn btn-secondary  mx-2 d-inline-block'><img class='pb-1' style='width:1rem' src='img/editar.png'></a>
    <a href='javascript:borrarJuego(" . $this->id . ")' class='btn btn-secondary  mx-2 d-inline-block'><img class='pb-1' style='width:1rem' src='img/eliminar.png'></a>
    </div>
    </div> 
</div >
";
        return $html;
    }
}