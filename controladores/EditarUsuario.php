<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

$database = new db();
$conexion = $database->conectarBD();

$imagenContenido = NULL;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0 && $_FILES['imagen'] !== "") {
    $fileTmpPath = $_FILES['imagen']['tmp_name'];
    $imagenContenido = addslashes(file_get_contents($fileTmpPath));
} else {
    $imagenContenido = null;
}

$usuarioID = $_POST['usuarioID'];
$nombre = $_POST['nombre'] != "" ? $_POST['nombre'] : null;
$apellido = $_POST['apellido'] != "" ? $_POST['apellido'] : null;
$genero = $_POST['genero'] != "" ? $_POST['genero'] : null;
$contrasena = $_POST['password'] != "" ? $_POST['password'] : null;
$sqlUpdate = "CALL EditarUsuario (
    '$usuarioID',
    " . ($nombre !== null ? "'$nombre'" : "NULL") . ",
    " . ($apellido !== null ? "'$apellido'" : "NULL") . ",
    " . ($genero !== null ? "'$genero'" : "NULL") . ",
    NULL,
    " . ($imagenContenido !== null ? "'$imagenContenido'" : "NULL") . ",
    " . ($contrasena !== null ? "'$contrasena'" : "NULL") . "
)";

if (mysqli_query($conexion, $sqlUpdate)) {
    // Actualizar el objeto Usuario en la sesión
    $sqlSelectUsuario = "CALL ObtenerUsuarioPorID(?)";
    $stmtSelectUsuario = $conexion->prepare($sqlSelectUsuario);
    $stmtSelectUsuario->bind_param('i', $usuarioID);
    $stmtSelectUsuario->execute();
    $result = $stmtSelectUsuario->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Inicializar el objeto Usuario actualizado
        $usuario = new Usuario(
            $user["UsuarioID"],
            $user["Nombre"],
            $user["Apellido"],
            $user["Genero"],
            $user["FechaNacimiento"],
            $user["Foto"],
            $user["Email"],
            $user["TipoUsuario"],
            $user["FechaModificacion"],
            $user["BorradoLogico"],
            $user["FechaEliminacion"]
        );

        // Almacenar el objeto Usuario en la sesión
        $_SESSION['usuarioLoggeado'] = serialize($usuario);
    }

    $stmtSelectUsuario->close();

    header("Location: /kardex.php");
    exit;
} else {
    echo 'Error: ' . mysqli_error($conexion);
}

mysqli_close($conexion);
?>