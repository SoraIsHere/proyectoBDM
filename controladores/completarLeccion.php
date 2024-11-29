<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

// Verifica si el usuario está loggeado
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $usuarioID = $usuarioLoggeado->usuarioID;

    // Verifica si la solicitud es GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Conectar a la base de datos
        $database = new db();
        $conexion = $database->conectarBD();

        // Obtener los datos de la URL
        $leccionID = intval($_GET['leccion']);
        $cursoID = intval($_GET['curso']);

        // Llamar al procedimiento almacenado para completar la lección
        $sqlCompletarLeccion = "CALL completarLeccion(?, ?)";
        $stmtCompletarLeccion = $conexion->prepare($sqlCompletarLeccion);
        $stmtCompletarLeccion->bind_param('ii', $usuarioID, $leccionID);

        // Ejecutar la actualización de la lección
        if ($stmtCompletarLeccion->execute()) {
            $stmtCompletarLeccion->close();

            // Verificar si todas las lecciones del curso están completadas
            $sqlVerificarLecciones = "CALL VerificarLeccionesIncompletas(?, ?)";
            $stmtVerificarLecciones = $conexion->prepare($sqlVerificarLecciones);
            $stmtVerificarLecciones->bind_param('ii', $usuarioID, $cursoID);
            $stmtVerificarLecciones->execute();
            $resultVerificarLecciones = $stmtVerificarLecciones->get_result();
            $row = $resultVerificarLecciones->fetch_assoc();
            $stmtVerificarLecciones->close();

            if ($row['Incompletas'] == 0) {
                // Si todas las lecciones están completadas, llamar al procedimiento para completar el curso
                $sqlCompletarCurso = "CALL completarCurso(?, ?)";
                $stmtCompletarCurso = $conexion->prepare($sqlCompletarCurso);
                $stmtCompletarCurso->bind_param('ii', $usuarioID, $cursoID);
                $stmtCompletarCurso->execute();
                $stmtCompletarCurso->close();

                // Redirigir a la página de diploma
                header("Location: /diploma.php?cursoId={$cursoID}");
                exit;
            } else {
                // Redirigir a la página de detalles del curso
                header("Location: /detalleCurso.php?id={$cursoID}");
                exit;
            }
        } else {
            echo "Error al completar la lección: " . $stmtCompletarLeccion->error;
            $stmtCompletarLeccion->close();
        }

        // Cerrar la conexión
        mysqli_close($conexion);
    }
} else {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: /inisesion.php?error=usuario_no_loggeado");
    exit;
}
?>