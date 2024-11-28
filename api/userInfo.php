<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');
$database = new db();
$conexion = $database->conectarBD();

// Habilitar la visualización de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$usuarioID = $_GET['usuarioID'];

$response = []; // Array para almacenar todos los resultados

if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);

    if ($usuarioLoggeado->usuarioID == $usuarioID) {
        // Información del Usuario
        $queryUsuario = "SELECT UsuarioID, Nombre, Apellido, Genero, FechaNacimiento, Email, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion FROM Usuario WHERE UsuarioID = ?";
        if ($stmt = $conexion->prepare($queryUsuario)) {
            $stmt->bind_param('i', $usuarioID);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $response['Usuario'] = $resultSet->fetch_assoc();
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al preparar la consulta de usuario';
        }

        // Cursos en los que está inscrito el Usuario
        $queryCursos = "SELECT C.CursoID, C.Nombre AS CursoNombre, C.CostoGeneral, C.Descripcion, C.Calificacion, C.CategoriaID, C.CreadorID, C.BorradoLogico, C.FechaCreacion, C.FechaEliminacion,
                        UC.Terminado, UC.FechaFinalizacion, UC.FechaInscripcion, UC.UltimaVisitaDeLeccion, UC.FormaPago
                        FROM UsuarioCurso UC
                        JOIN Curso C ON UC.CursoID = C.CursoID
                        WHERE UC.UsuarioID = ?";
        if ($stmt = $conexion->prepare($queryCursos)) {
            $stmt->bind_param('i', $usuarioID);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $response['Cursos'] = $resultSet->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al preparar la consulta de cursos';
        }

        // Lecciones de los cursos en los que está inscrito el Usuario
        $queryLecciones = "SELECT L.LeccionID, L.Nombre AS LeccionNombre, L.Costo, L.Orden, L.Descripcion, L.CursoID, L.BorradoLogico, L.FechaEliminacion,
                           UL.Leido
                           FROM UsuarioLeccion UL
                           JOIN Leccion L ON UL.LeccionID = L.LeccionID
                           WHERE UL.UsuarioID = ?";
        if ($stmt = $conexion->prepare($queryLecciones)) {
            $stmt->bind_param('i', $usuarioID);
            $stmt->execute();
            $resultSet = $stmt->get_result();
            $response['Lecciones'] = $resultSet->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al preparar la consulta de lecciones';
        }

        mysqli_close($conexion);

        // Cabeceras para la descarga del archivo JSON
        header('Content-Disposition: attachment; filename="datos_usuario.json"');
        header('Content-Type: application/json');

        // Imprimimos el JSON con los resultados obtenidos
        echo json_encode($response, JSON_PRETTY_PRINT);

        // Redirigir a /kardex después de la descarga
        echo '<script type="text/javascript">
            setTimeout(function() {
                window.location.href = "/kardex";
            }, 1000);
        </script>';

        exit();
    } else {
        $response = ['status' => 'error', 'message' => 'No tienes acceso a esta ruta'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Usuario no autenticado'];
}

mysqli_close($conexion);

// Cabeceras para la descarga del archivo JSON
header('Content-Disposition: attachment; filename="error.json"');
header('Content-Type: application/json');

// Imprimimos el JSON con los resultados obtenidos
echo json_encode($response, JSON_PRETTY_PRINT);

// Redirigir a /kardex después de la descarga
echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "/kardex";
    }, 1000);
</script>';

exit();
?>