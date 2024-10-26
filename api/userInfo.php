<?php
header('Content-Type: application/json'); // Configura el encabezado para JSON

session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');
$database = new db();
$conexion = $database->conectarBD();

$usuarioID = $_GET['usuarioID'];
$query = "CALL GetUsuarioInfo($usuarioID);";

$response = []; // Array para almacenar todos los conjuntos de resultados

if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);


    if ($usuarioLoggeado->usuarioID == $usuarioID) {
        if (mysqli_multi_query($conexion, $query)) {
            $setIndex = 1;
            do {
                if ($resultSet = mysqli_store_result($conexion)) {
                    $data = [];
                    while ($row = mysqli_fetch_assoc($resultSet)) {
                        unset($row['Foto']); // Eliminamos la columna 'Foto' de los resultados
                        $data[] = $row; // Añadimos la fila al conjunto de datos
                    }
                    $response["Conjunto_$setIndex"] = $data; // Guardamos el conjunto de datos en el array de respuesta
                    mysqli_free_result($resultSet);
                    $setIndex++;
                }
            } while (mysqli_next_result($conexion));
        }
    } else {
        $response = "No tienes acceso a esta ruta";
    }

    mysqli_close($conexion);

    // Imprimimos el JSON con los resultados obtenidos
    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>