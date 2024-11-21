<?php
session_start();
include('../conectarBD.php');

if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $database = new db();
    $conexion = $database->conectarBD();

    if (isset($_GET['id'])) {
        $categoriaID = $_GET['id'];
        $sqlDelete = "CALL EliminarCategoria({$categoriaID})";
        if (!mysqli_query($conexion, $sqlDelete)) {
            die('Error: ' . mysqli_error($conexion));
        }
        header("Location: /reportes.php?catEliminada=true");
    } else {
        die('Error: No se proporcionó ID de categoría.');
    }

    mysqli_close($conexion);
} else {
    echo ("No ha iniciado sesión.");
}
?>