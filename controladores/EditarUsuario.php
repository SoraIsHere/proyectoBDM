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
    $query = "SELECT UsuarioID, Nombre, Apellido, Email, Genero, FechaNacimiento, Foto, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion FROM Usuario WHERE UsuarioID = '$usuarioID'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

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

    header("Location: /kardex.php");
    exit;
} else {
    echo 'Error: ' . mysqli_error($conexion);
}

mysqli_close($conexion);
?>