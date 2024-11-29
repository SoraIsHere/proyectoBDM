<?php
include('modelos/Curso.php');
include('modelos/Leccion.php');

$database = new db();
$conexion = $database->conectarBD();

// Obtener el cursoID de los parámetros del URL
$cursoID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($cursoID > 0) {
    // Obtener el usuario loggeado
    $usuarioLoggeado = isset($_SESSION['usuarioLoggeado']) ? unserialize($_SESSION['usuarioLoggeado']) : null;
    $usuarioID = $usuarioLoggeado ? $usuarioLoggeado->usuarioID : 0;

    // Validar que el usuario esté loggeado
    if ($usuarioID === 0) {
        die('Usuario no loggeado.');
    }

    // Llamar al procedimiento almacenado para obtener el curso por ID
    $sqlSelectCurso = "CALL ObtenerCurso(?)";
    $stmtSelectCurso = $conexion->prepare($sqlSelectCurso);
    $stmtSelectCurso->bind_param('i', $cursoID);

    if ($stmtSelectCurso->execute()) {
        $resultCurso = $stmtSelectCurso->get_result();
        $curso = null;
        if ($row = $resultCurso->fetch_assoc()) {
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
        $resultCurso->free();
        $stmtSelectCurso->close();

        // Asegurar que el siguiente resultado está disponible
        mysqli_next_result($conexion);
    } else {
        die('Error al obtener el curso: ' . mysqli_error($conexion));
    }

    // Validar si el usuario está inscrito en el curso y si está terminado
    $sqlCheckCurso = "CALL ValidarInscripcion(?, ?)";
    $stmtCheckCurso = $conexion->prepare($sqlCheckCurso);
    $stmtCheckCurso->bind_param('ii', $usuarioID, $cursoID);
    $cursoTerminado = false;
    $cursoComprado = false;

    if ($stmtCheckCurso->execute()) {
        $resultCheckCurso = $stmtCheckCurso->get_result();
        if ($row = $resultCheckCurso->fetch_assoc()) {
            $cursoComprado = true;
            $cursoTerminado = $row['Terminado'];
        }
        $resultCheckCurso->free();
    }

    $stmtCheckCurso->close();

    // Llamar al procedimiento almacenado para obtener las lecciones del curso por ID
    $sqlSelectLecciones = "CALL ObtenerLeccionesPorCurso(?)";
    $stmtSelectLecciones = $conexion->prepare($sqlSelectLecciones);
    $stmtSelectLecciones->bind_param('i', $cursoID);
    $lecciones = array();
    $leccionesUsuario = array();

    if ($stmtSelectLecciones->execute()) {
        $resultLecciones = $stmtSelectLecciones->get_result();
        while ($row = $resultLecciones->fetch_assoc()) {
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
        $resultLecciones->free();
    } else {
        die('Error al obtener las lecciones: ' . mysqli_error($conexion));
    }
    $stmtSelectLecciones->close();

    // Asegurar que el siguiente resultado está disponible
    mysqli_next_result($conexion);

    // Obtener las lecciones que el usuario ha comprado
    $sqlSelectLeccionesUsuario = "CALL ObtenerLeccionesUsuario(?, ?)";
    $stmtLeccionesUsuario = $conexion->prepare($sqlSelectLeccionesUsuario);
    $stmtLeccionesUsuario->bind_param('ii', $usuarioID, $cursoID);
    if ($stmtLeccionesUsuario->execute()) {
        $resultLeccionesUsuario = $stmtLeccionesUsuario->get_result();
        while ($row = $resultLeccionesUsuario->fetch_assoc()) {
            $leccionesUsuario[] = ['LeccionID' => $row['LeccionID'], 'Leido' => $row['Leido']];
        }
        $resultLeccionesUsuario->free();
    }
    $stmtLeccionesUsuario->close();

    // Actualizar la última visita de lección
    $sqlActualizarVisita = "CALL ActualizarUltimaVisitaDeLeccion(?, ?)";
    $stmtActualizarVisita = $conexion->prepare($sqlActualizarVisita);
    $stmtActualizarVisita->bind_param('ii', $usuarioID, $cursoID);
    $stmtActualizarVisita->execute();
    $stmtActualizarVisita->close();

} else {
    echo 'ID del curso no válido';
}
?>