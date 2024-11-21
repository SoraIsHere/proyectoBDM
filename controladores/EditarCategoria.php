<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $database = new db();
    $conexion = $database->conectarBD();

    // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['categoriaID'], $_POST['nombre'], $_POST['descripcion'])) {
        $categoriaID = $_POST['categoriaID'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        $sqlUpdate = "CALL EditarCategoria (
            {$categoriaID},
            '{$nombre}',
            '{$descripcion}'
        )";

        if (!mysqli_query($conexion, $sqlUpdate)) {
            die('Error: ' . mysqli_error($conexion));
        }

        header("Location: /reportes.php?catEditada=true");
        mysqli_close($conexion);
        exit();
    }
}
echo ("No ha iniciado sesión.");
?>