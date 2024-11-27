<?php

class Comentario
{
    public $comentarioID;
    public $texto;
    public $usuarioID;
    public $calificacion;
    public $cursoID;
    public $borradoLogico;
    public $fechaEliminacion;
    public $fechaCreacion;
    public $usuarioNombre;

    // Constructor
    public function __construct(
        $comentarioID,
        $texto,
        $usuarioID,
        $calificacion,
        $cursoID,
        $borradoLogico,
        $fechaEliminacion,
        $fechaCreacion,
        $usuarioNombre
    ) {
        $this->comentarioID = $comentarioID;
        $this->texto = $texto;
        $this->usuarioID = $usuarioID;
        $this->calificacion = $calificacion;
        $this->cursoID = $cursoID;
        $this->borradoLogico = $borradoLogico;
        $this->fechaEliminacion = $fechaEliminacion;
        $this->fechaCreacion = $fechaCreacion;
        $this->usuarioNombre = $usuarioNombre;
    }

    // Implementar métodos de la interfaz Serializable
    public function serialize()
    {
        return serialize([
            $this->comentarioID,
            $this->texto,
            $this->usuarioID,
            $this->calificacion,
            $this->cursoID,
            $this->borradoLogico,
            $this->fechaEliminacion,
            $this->fechaCreacion,
            $this->usuarioNombre
        ]);
    }

    public function unserialize($data)
    {
        list(
            $this->comentarioID,
            $this->texto,
            $this->usuarioID,
            $this->calificacion,
            $this->cursoID,
            $this->borradoLogico,
            $this->fechaEliminacion,
            $this->fechaCreacion,
            $this->usuarioNombre
        ) = unserialize($data);
    }
}
?>