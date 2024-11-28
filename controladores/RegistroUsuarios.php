<?php
include('../conectarBD.php');

$database = new db();
$conexion = $database->conectarBD();

$imagenContenido = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $fileTmpPath = $_FILES['imagen']['tmp_name'];
    $imagenContenido = addslashes(file_get_contents($fileTmpPath));
}

$sqlInsert = "CALL InsertarUsuario (
    '{$_POST['nombre']}',
    '{$_POST['apellido']}',
    '{$_POST['genero']}',
    '{$_POST['fechaNacimiento']}',
    '{$imagenContenido}',
    '{$_POST['email']}',
    '{$_POST['contrasena']}',
    '{$_POST['rol']}'
)";

if (!mysqli_query($conexion, $sqlInsert)) {
    die('Error: ' . mysqli_error($conexion));
}

header("Location: /inisesion.php");
mysqli_close($conexion);
?>
