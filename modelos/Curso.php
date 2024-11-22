<?php
class Curso
{
    public $cursoID;
    public $nombre;
    public $costoGeneral;
    public $descripcion;
    public $calificacion;
    public $categoriaID;
    public $creadorID;
    public $imagen;
    public $borradoLogico;
    public $fechaCreacion;
    public $fechaEliminacion;
    public $categoriaBorrada; // Campo para la información de borrado de la categoría
    public $categoriaNombre;  // Nuevo campo para el nombre de la categoría

    // Constructor
    public function __construct($cursoID, $nombre, $costoGeneral, $descripcion, $calificacion, $categoriaID, $creadorID, $imagen, $borradoLogico, $fechaCreacion, $fechaEliminacion, $categoriaBorrada, $categoriaNombre)
    {
        $this->cursoID = $cursoID;
        $this->nombre = $nombre;
        $this->costoGeneral = $costoGeneral;
        $this->descripcion = $descripcion;
        $this->calificacion = $calificacion;
        $this->categoriaID = $categoriaID;
        $this->creadorID = $creadorID;
        $this->imagen = $imagen;
        $this->borradoLogico = $borradoLogico;
        $this->fechaCreacion = $fechaCreacion;
        $this->fechaEliminacion = $fechaEliminacion;
        $this->categoriaBorrada = $categoriaBorrada; 
        $this->categoriaNombre = $categoriaNombre;  
    }

    // Implementar métodos de la interfaz Serializable
    public function serialize()
    {
        return serialize([
            $this->cursoID,
            $this->nombre,
            $this->costoGeneral,
            $this->descripcion,
            $this->calificacion,
            $this->categoriaID,
            $this->creadorID,
            $this->imagen,
            $this->borradoLogico,
            $this->fechaCreacion,
            $this->fechaEliminacion,
            $this->categoriaBorrada,
            $this->categoriaNombre
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->cursoID,
            $this->nombre,
            $this->costoGeneral,
            $this->descripcion,
            $this->calificacion,
            $this->categoriaID,
            $this->creadorID,
            $this->imagen,
            $this->borradoLogico,
            $this->fechaCreacion,
            $this->fechaEliminacion,
            $this->categoriaBorrada,
            $this->categoriaNombre  
        ) = unserialize($data);
    }
}
