<?php


/**
 * Class Plataforma
 */
class Plataforma
{
    /**
     * @var ID|string
     */
    private $id;
    /**
     * @var Nombre|string
     */
    private $nombre;
    /**
     * @var Icono|string
     */
    private $icono;
    /**
     * @var Descripción|string
     */
    private $descripción;
    /**
     * @var array de plataformas
     */
    private $lista;

    /**
     * Plataforma constructor.
     * @param $id ID de la plataforma
     * @param $nombre Nombre de la plataforma
     * @param $icono Icono de la plataforma
     * @param $descripción Descripción de la plataorma
     * @param $lista Lista de plataformas.
     */
    public function __construct($id="", $nombre="", $icono="", $descripción="", $lista="")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->icono = $icono;
        $this->descripción = $descripción;
        $this->lista = array();
    }

    /**
     *Metodo para obtener plataformas mediante una llamada a la base de datos y el uso de la función consulta de Bd, las cuales se guardarán en la lista.
     */
    public function obtenerPlataformas()
    {
        $sql = "SELECT * FROM plataformas";
        $conexion = new Bd();
        $res = $conexion->consulta($sql);

        while (list($id, $nombre, $icono, $descripcion) = mysqli_fetch_array($res)) {
            $plataforma = new Plataforma($id, $nombre, $icono, $descripcion);
            array_push($this->lista, $plataforma);
        }
    }


    /**
     * Muestra las plafatormas usando el metodo imprimeOpciones almacenadas en la lista, las cuales hemos obtenido del metodo ObtenerPlataformas
     * @return string retorna el HTML con las plataformas para mostrarse en la web como options.
     */
    public function mostrarPlataformas()
    {
        $html="";
        for ($i = 0; $i < sizeof($this->lista); $i++) {
            $html .= $this->lista[$i]->imprimeOpciones();
        }
        return $html;
    }

    /**
     * Metodo que crea texto html con las distintas plataformas de la Plataforma.
     * @return string retorna el html de cada plataforma
     */
    public function imprimeOpciones()
    {
        $html ="<option value='".$this->id."'>".$this->nombre."</option>";

        return $html;


    }
}

