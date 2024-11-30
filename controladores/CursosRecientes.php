<?php

$database = new db();
$conexion = $database->conectarBD();

// Llamar al procedimiento almacenado para obtener las publicaciones
$criterio = 2; // Más recientes
$sqlSelect = "CALL ObtenerCursosInicio({$criterio}, NULL)";

$result = mysqli_query($conexion, $sqlSelect);

if (!$result) {
    die('Error: ' . mysqli_error($conexion));
}

$cursosRecientes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $curso = new Curso(
        $row['CursoID'],
        $row['Nombre'],
        $row['CostoGeneral'],
        $row['Descripcion'],
        $row['Calificacion'],
        $row['CategoriaID'],
        $row['CreadorID'],
        $row['Imagen'],
        $row['BorradoLogico'],
        $row['FechaCreacion'],
        $row['FechaEliminacion'],
        $row['categoriaBorrada'],
        $row['categoriaNombre']
    );
    $cursosRecientes[] = $curso;
}

mysqli_free_result($result);
mysqli_close($conexion);

// Puedes imprimir los cursos o redirigir a otra página
/* foreach ($cursosInicio as $curso) {
    echo 'CursoID: ' . $curso->cursoID . '<br>';
    echo 'BorradoLogico: ' . $curso->borradoLogico . '<br>';
} */

?>