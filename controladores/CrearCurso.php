<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

$usuarioLoggeado = false;
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $userId = $usuarioLoggeado->usuarioID;
    $database = new db();
    $conexion = $database->conectarBD();

    $imagenContenido = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $imagenContenido = file_get_contents($fileTmpPath);
    }


    // Preparamos la consulta para insertar el curso
    $sqlInsert = "CALL InsertarCurso(?, ?, ?, ?, ?, ?, @curso_id)";
    $stmt = $conexion->prepare($sqlInsert);


    // Usamos send_long_data para enviar el contenido binario 
    if ($imagenContenido) {
        $stmt->send_long_data(5, $imagenContenido);
        // 5 es el índice del parámetro para la imagen 
    }

    // Vinculamos los parámetros
    $stmt->bind_param(
        "sdsiis",
        $_POST['nombre'],
        $_POST['precio'],
        $_POST['descripcion'],
        $_POST['categoria'],
        $userId,
        $imagenContenido
    );

    // Ejecutamos la consulta
    if (!$stmt->execute()) {
        die('Error: ' . $stmt->error);
    }

    // Obtenemos el ID del curso recién creado
    $result = $conexion->query("SELECT @curso_id AS curso_id");
    if ($result) {
        $row = $result->fetch_assoc();
        $cursoID = $row['curso_id'];
    } else {
        die('Error al obtener el ID del curso: ' . mysqli_error($conexion));
    }

    foreach ($_POST['capitulos'] as $orden => $capitulo) {
        echo $capitulo['precio'];
        echo "-------------------";
        $nombre = $capitulo['titulo'];
        $descripcion = $capitulo['contenido'];
        $costo = $capitulo['precio'];
        $videoContenido = null;
        $ordenLeccion = $orden + 1;
        if (isset($_FILES['capitulos']['tmp_name'][$orden]['video']) && $_FILES['capitulos']['error'][$orden]['video'] == 0) {
            $fileTmpPath = $_FILES['capitulos']['tmp_name'][$orden]['video'];
            $videoContenido = addslashes(file_get_contents($fileTmpPath));
        }

        $sqlInsertLeccion = "CALL InsertarLeccion( '{$nombre}', '{$costo}', '{$ordenLeccion}', '{$descripcion}', '{$videoContenido}', '{$cursoID}' )";
        if (!mysqli_query($conexion, $sqlInsertLeccion)) {
            die('Error: ' . mysqli_error($conexion));
        }
    }

    
    header("Location: /ventas.php?creado=true");
    $stmt->close();
    mysqli_close($conexion);
}
?>