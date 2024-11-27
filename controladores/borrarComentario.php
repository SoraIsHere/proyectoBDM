<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

// Verifica si el usuario está loggeado
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $usuarioID = $usuarioLoggeado->usuarioID;

    // Verifica si el usuario es administrador
    if ($usuarioLoggeado->tipoUsuario == "Administrador") {
        // Conectar a la base de datos
        $database = new db();
        $conexion = $database->conectarBD();

        // Obtener el comentarioID del formulario
        $comentarioID = intval($_GET['comentario']);

        // Llamar al procedimiento almacenado para eliminar el comentario
        $sqlEliminarComentario = "CALL EliminarComentario(?)";
        $stmtEliminarComentario = $conexion->prepare($sqlEliminarComentario);
        $stmtEliminarComentario->bind_param('i', $comentarioID);

        // Ejecutar la eliminación
        if ($stmtEliminarComentario->execute()) {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "#comentarios");
            exit;
        } else {
            echo "Error al eliminar comentario: " . $stmtEliminarComentario->error;
        }

        $stmtEliminarComentario->close();
        mysqli_close($conexion);
    } else {
        echo "Error: Usuario no autorizado.";
    }
} else {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: " . $_SERVER['HTTP_REFERER'] . "#comentarios");
    exit;
}
?>