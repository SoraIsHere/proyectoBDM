<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $database = new db();
    $conexion = $database->conectarBD();
    echo($usuarioLoggeado->usuarioID);
    $sqlInsert = "CALL InsertarCategoria (
    '{$_POST['nombre']}',
    '{$_POST['descripcion']}',
    '{$usuarioLoggeado->usuarioID}'
)";

    if (!mysqli_query($conexion, $sqlInsert)) {
        die('Error: ' . mysqli_error($conexion));
    }

    header("Location: /reportes.php?catCreada=true");
    mysqli_close($conexion);
}
echo ("no a iniciado sesion");
?>