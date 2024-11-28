<?php
class db {
    public function conectarBD() {
        $conexion = mysqli_connect("localhost:3306", "root", "localhost");

        if (!$conexion) {
            die('Error al conectarse con la base de datos: ' . mysqli_connect_error());
        }

        mysqli_select_db($conexion, "bdm");
        return $conexion;
    }
}
