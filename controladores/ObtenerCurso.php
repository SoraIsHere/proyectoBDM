<?php
include('modelos/Curso.php');
include('modelos/Leccion.php');

$database = new db();
$conexion = $database->conectarBD();

// Obtener el cursoID de los parámetros del URL
$cursoID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($cursoID > 0) {
    // Llamar al procedimiento almacenado para obtener el curso por ID
    $sqlSelectCurso = "CALL ObtenerCurso({$cursoID})";
    if ($resultCurso = mysqli_query($conexion, $sqlSelectCurso)) {
        $curso = null;
        if ($row = mysqli_fetch_assoc($resultCurso)) {
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
        mysqli_free_result($resultCurso);

        // Asegurar que el siguiente resultado está disponible
        mysqli_next_result($conexion);
    } else {
        die('Error al obtener el curso: ' . mysqli_error($conexion));
    }

    // Llamar al procedimiento almacenado para obtener las lecciones del curso por ID
    $sqlSelectLecciones = "CALL ObtenerLeccionesPorCurso({$cursoID})";
    $lecciones = array();
    if ($resultLecciones = mysqli_query($conexion, $sqlSelectLecciones)) {
        while ($row = mysqli_fetch_assoc($resultLecciones)) {
            $leccion = new Leccion(
                $row['LeccionID'],
                $row['Nombre'],
                $row['Costo'],
                $row['Orden'],
                $row['Descripcion'],
                $row['Video'],
                $row['CursoID'],
                $row['BorradoLogico'],
                $row['FechaEliminacion']
            );
            $lecciones[] = $leccion;
        }
        mysqli_free_result($resultLecciones);
    } else {
        die('Error al obtener las lecciones: ' . mysqli_error($conexion));
    }

} else {
    echo 'ID del curso no válido';
}

mysqli_close($conexion);

// Puedes imprimir el curso y las lecciones o redirigir a otra página
/*
echo 'CursoID: ' . $curso->cursoID . '<br>';
echo 'Nombre: ' . $curso->nombre . '<br>';

foreach ($lecciones as $leccion) {
    echo 'LeccionID: ' . $leccion->leccionID . '<br>';
    echo 'Nombre: ' . $leccion->nombre . '<br>';
}
*/
?>