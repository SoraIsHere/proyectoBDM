<?php
session_start();
include '../conectarBD.php';
include '../modelos/Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['contraseña'];

    $db = new db();
    $conexion = $db->conectarBD();

    // Obtener el usuario mediante el procedimiento almacenado
    $query = "CALL LoginUsuario('$email', '$password');";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Inicializar el objeto Usuario
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

            // Redirigir al índice
            header("Location:../index.php");
            exit;
        } else {
            // Redirigir a la página de inicio de sesión con mensaje de error
            header("Location:/inisesion.php?error=contraseña_incorrecta");
            exit;
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
