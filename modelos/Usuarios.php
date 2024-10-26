<?php
class Usuario {
    public $usuarioID;
    public $nombre;
    public $apellido;
    public $genero;
    public $fechaNacimiento;
    public $foto;
    public $email;
    public $tipoUsuario;
    public $fechaModificacion;
    public $borradoLogico;
    public $fechaEliminacion;

    // Constructor
    public function __construct($usuarioID, $nombre, $apellido, $genero, $fechaNacimiento, $foto, $email, $tipoUsuario, $fechaModificacion, $borradoLogico, $fechaEliminacion) {
        $this->usuarioID = $usuarioID;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->genero = $genero;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->foto = $foto;
        $this->email = $email;
        $this->tipoUsuario = $tipoUsuario;
        $this->fechaModificacion = $fechaModificacion;
        $this->borradoLogico = $borradoLogico;
        $this->fechaEliminacion = $fechaEliminacion;
    }

    // Implementar métodos de la interfaz Serializable
    public function serialize() {
        return serialize([
            $this->usuarioID,
            $this->nombre,
            $this->apellido,
            $this->genero,
            $this->fechaNacimiento,
            $this->foto,
            $this->email,
            $this->tipoUsuario,
            $this->fechaModificacion,
            $this->borradoLogico,
            $this->fechaEliminacion
        ]);
    }

    public function unserialize($data) {
        list(
            $this->usuarioID,
            $this->nombre,
            $this->apellido,
            $this->genero,
            $this->fechaNacimiento,
            $this->foto,
            $this->email,
            $this->tipoUsuario,
            $this->fechaModificacion,
            $this->borradoLogico,
            $this->fechaEliminacion
        ) = unserialize($data);
    }
}
