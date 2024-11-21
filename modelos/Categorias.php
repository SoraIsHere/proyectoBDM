<?php

class Categoria
{
    public $categoriaID;
    public $nombre;
    public $descripcion;
    public $creadorID;
    public $fechaCreacion;
    public $borradoLogico;
    public $fechaEliminacion;

    // Constructor
    public function __construct(
        $categoriaID,
        $nombre,
        $descripcion,
        $creadorID,
        $fechaCreacion,
        $borradoLogico,
        $fechaEliminacion
    ) {
        $this->categoriaID = $categoriaID;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->creadorID = $creadorID;
        $this->fechaCreacion = $fechaCreacion;
        $this->borradoLogico = $borradoLogico;
        $this->fechaEliminacion = $fechaEliminacion;
    }

    // Implementar métodos de la interfaz Serializable
    public function serialize()
    {
        return serialize([
            $this->categoriaID,
            $this->nombre,
            $this->descripcion,
            $this->creadorID,
            $this->fechaCreacion,
            $this->borradoLogico,
            $this->fechaEliminacion
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->categoriaID,
            $this->nombre,
            $this->descripcion,
            $this->creadorID,
            $this->fechaCreacion,
            $this->borradoLogico,
            $this->fechaEliminacion
        ) = unserialize($data);
    }
}