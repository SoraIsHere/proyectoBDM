<?php
class Leccion
{
    public $leccionID;
    public $nombre;
    public $costo;
    public $orden;
    public $descripcion;
    public $video;
    public $cursoID;
    public $borradoLogico;
    public $fechaEliminacion;

    // Constructor
    public function __construct($leccionID, $nombre, $costo, $orden, $descripcion, $video, $cursoID, $borradoLogico, $fechaEliminacion)
    {
        $this->leccionID = $leccionID;
        $this->nombre = $nombre;
        $this->costo = $costo;
        $this->orden = $orden;
        $this->descripcion = $descripcion;
        $this->video = $video;
        $this->cursoID = $cursoID;
        $this->borradoLogico = $borradoLogico;
        $this->fechaEliminacion = $fechaEliminacion;
    }

    // Implementar métodos de la interfaz Serializable
    public function serialize()
    {
        return serialize([
            $this->leccionID,
            $this->nombre,
            $this->costo,
            $this->orden,
            $this->descripcion,
            $this->video,
            $this->cursoID,
            $this->borradoLogico,
            $this->fechaEliminacion
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->leccionID,
            $this->nombre,
            $this->costo,
            $this->orden,
            $this->descripcion,
            $this->video,
            $this->cursoID,
            $this->borradoLogico,
            $this->fechaEliminacion
        ) = unserialize($data);
    }
}
?>