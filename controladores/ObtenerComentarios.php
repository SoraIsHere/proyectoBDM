<?php
include('modelos/Comentario.php');

// Conectar a la base de datos
$database = new db();
$conexion = $database->conectarBD();


if ($cursoID > 0) {
    // Llamar al procedimiento almacenado para obtener los comentarios del curso
    $sqlSelectComentarios = "CALL ObtenerComentariosPorCurso(?)";
    $stmtSelectComentarios = $conexion->prepare($sqlSelectComentarios);
    $stmtSelectComentarios->bind_param('i', $cursoID);

    // Ejecutar la consulta y almacenar los resultados en un array
    $comentarios = array();

    if ($stmtSelectComentarios->execute()) {
        $resultComentarios = $stmtSelectComentarios->get_result();
        while ($row = $resultComentarios->fetch_assoc()) {
            $comentarios[] = new Comentario(
                $row['ComentarioID'],
                $row['Texto'],
                $row['UsuarioID'],
                $row['Calificacion'],
                $row['CursoID'],
                $row['BorradoLogico'],
                $row['FechaEliminacion'],
                $row['FechaCreacion'],
                $row['UsuarioNombre']
            );
        }
        $resultComentarios->free();
    } else {
        echo "Error al obtener comentarios: " . $stmtSelectComentarios->error;
    }

    $stmtSelectComentarios->close();
} else {
    echo 'ID del curso no válido';
}

// Cerrar la conexión
mysqli_close($conexion);

// Echo del contenido del array comentarios para ver los resultados
/* echo '<pre>';
print_r($comentarios);
echo '</pre>'; */
?>