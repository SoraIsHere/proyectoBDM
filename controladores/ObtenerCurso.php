<?php
include('modelos/Curso.php');

$database = new db();
$conexion = $database->conectarBD();

// Obtener el cursoID de los parámetros del URL
$cursoID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($cursoID > 0) {
    // Llamar al procedimiento almacenado para obtener el curso por ID
    $sqlSelect = "CALL ObtenerCurso({$cursoID})";

    $result = mysqli_query($conexion, $sqlSelect);

    if (!$result) {
        die('Error: ' . mysqli_error($conexion));
    }

    $curso = "";
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
    }

    mysqli_free_result($result);
} else {
    echo 'ID del curso no válido';
}

mysqli_close($conexion);

// Puedes imprimir el curso o redirigir a otra página
/* foreach ($cursos as $curso) {
    echo 'CursoID: ' . $curso->cursoID . '<br>';
    echo 'BorradoLogico: ' . $curso->borradoLogico . '<br>';
} */

?>