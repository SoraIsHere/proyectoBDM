<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

// Verifica si el usuario está loggeado
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $usuarioID = $usuarioLoggeado->usuarioID;

    // Verifica si la solicitud es POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Conectar a la base de datos
        $database = new db();
        $conexion = $database->conectarBD();

        // Obtener los datos del formulario
        $cursoID = intval($_POST['curso']);
        $calificacion = intval($_POST['calificacion']);
        $comentario = $_POST['comentario'];

        // Llamar al procedimiento almacenado para insertar el comentario
        $sqlInsertComentario = "CALL InsertarComentario(?, ?, ?, ?)";
        $stmtInsertComentario = $conexion->prepare($sqlInsertComentario);
        $stmtInsertComentario->bind_param('siii', $comentario, $usuarioID, $calificacion, $cursoID);

        // Ejecutar la inserción
        if ($stmtInsertComentario->execute()) {
            // Redirigir al usuario a la página del curso con un mensaje de éxito
            header("Location: /detalleCurso.php?id={$cursoID}#comentarios");
            exit;
        } else {
            echo "Error al insertar comentario: " . $stmtInsertComentario->error;
        }

        $stmtInsertComentario->close();
        mysqli_close($conexion);
    }
} else {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: /login.php?error=usuario_no_loggeado");
    exit;
}
?>