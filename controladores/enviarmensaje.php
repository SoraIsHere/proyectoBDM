<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

// Verificar si el usuario está loggeado
if (!isset($_SESSION['usuarioLoggeado'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
    exit();
}
$usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
$emisorID = $usuarioLoggeado->usuarioID;

$texto = $_POST['texto'] ?? '';
$receptorID = $_POST['receptorID'] ?? 0;

if (empty($texto) || $receptorID == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Datos del mensaje no validos']);
    exit();
}

$database = new db();
$conexion = $database->conectarBD();

$sql = "CALL InsertarMensaje(?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('sii', $texto, $emisorID, $receptorID);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje']);
}

$stmt->close();
mysqli_close($conexion);
?>