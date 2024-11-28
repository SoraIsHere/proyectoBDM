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
$usuarioActualID = $usuarioLoggeado->usuarioID;

$receptorID = $_POST['receptorID'] ?? 0;

if ($receptorID == 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID de receptor no válido']);
    exit();
}

$database = new db();
$conexion = $database->conectarBD();

$sql = "CALL ObtenerMensajesChat(?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('ii', $usuarioActualID, $receptorID);
$stmt->execute();
$result = $stmt->get_result();

$mensajes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $mensajes[] = $row;
}

echo json_encode(['status' => 'success', 'mensajes' => $mensajes]);

$stmt->close();
mysqli_close($conexion);
?>