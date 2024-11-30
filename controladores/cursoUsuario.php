<?php
session_start();
include('../conectarBD.php');
include('../modelos/Usuarios.php');

// Función para limpiar resultados pendientes y cerrar la conexión
function limpiarResultadosYCerrar($conexion)
{
    while ($conexion->more_results()) {
        $conexion->next_result();
        if ($result = $conexion->store_result()) {
            $result->free();
        }
    }
    mysqli_close($conexion);
}

// Verifica si el usuario está loggeado y obtiene el usuarioID de la sesión
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    $usuarioID = $usuarioLoggeado->usuarioID;

    // Verifica si la solicitud es POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Obtener los datos del formulario
        $cursoID = intval($_POST['cursoID']);
        $leccionID = isset($_POST['leccionID']) ? intval($_POST['leccionID']) : null;
        $completo = isset($_POST['completo']) ? $_POST['completo'] === 'true' : false;
        $formaPago = $_POST['paymentMethod'];
        $datosCompra = $_POST['purchaseDetails'];

        // Verificar si faltan valores
        if (($leccionID === null || $cursoID === "") && !$completo) {
            header("Location: /detalleCurso.php?id={$cursoID}&error=valores_incompletos");
            echo "Redirigiendo a detalleCurso.php: Valores incompletos.";
            exit;
        }

        // Conectar a la base de datos
        $database = new db();
        $conexion = $database->conectarBD();

        // Verificar si el usuario ya está inscrito en el curso
        $sqlCheck = "CALL VerificarUsuarioCurso(?, ?)";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->bind_param('ii', $usuarioID, $cursoID);

        if ($stmtCheck->execute()) {
            $resultCheck = $stmtCheck->get_result();
            if ($resultCheck->num_rows > 0) {
                $_SESSION['comprado'] = true;
                $row = $resultCheck->fetch_assoc();
                $_SESSION['terminado'] = $row['Terminado'];
                echo "El usuario ya está inscrito en este curso.";
            } else {
                // Cerrar el statement antes de realizar cualquier otra operación
                $stmtCheck->close();
                limpiarResultadosYCerrar($conexion);

                // Reabrir la conexión
                $conexion = $database->conectarBD();

                // Insertar en UsuarioCurso
                $sqlInsert = "CALL InsertarUsuarioCurso(?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($sqlInsert);
                $terminado = 0;
                $stmtInsert->bind_param('iiss', $usuarioID, $cursoID, $terminado, $formaPago);

                if ($stmtInsert->execute()) {
                    $_SESSION['comprado'] = true;
                    $_SESSION['terminado'] = $terminado;
                    echo "UsuarioCurso registrado exitosamente.";
                } else {
                    echo "Error al insertar UsuarioCurso: " . $stmtInsert->error;
                }

                $stmtInsert->close();
                limpiarResultadosYCerrar($conexion);
            }
        } else {
            echo "Error al verificar UsuarioCurso: " . $stmtCheck->error;
        }

        // Reabrir la conexión
        $conexion = $database->conectarBD();

        // Obtener las lecciones del curso actual asociadas al usuario
        $usuarioLecciones = [];
        $sqlUsuarioLecciones = "CALL ObtenerUsuarioLecciones(?, ?)";
        $stmtUsuarioLecciones = $conexion->prepare($sqlUsuarioLecciones);
        $stmtUsuarioLecciones->bind_param('ii', $usuarioID, $cursoID);

        if ($stmtUsuarioLecciones->execute()) {
            $resultUsuarioLecciones = $stmtUsuarioLecciones->get_result();
            while ($row = $resultUsuarioLecciones->fetch_assoc()) {
                $usuarioLecciones[] = $row['LeccionID'];
            }
            $resultUsuarioLecciones->free();
        }

        $stmtUsuarioLecciones->close();
        limpiarResultadosYCerrar($conexion);

        // Insertar lecciones dependiendo de si el curso es completo o no
        if ($completo) {
            // Reabrir la conexión
            $conexion = $database->conectarBD();

            $sqlLeccionesCurso = "CALL ObtenerLeccionesPorCurso(?)";
            $stmtLeccionesCurso = $conexion->prepare($sqlLeccionesCurso);
            $stmtLeccionesCurso->bind_param('i', $cursoID);

            if ($stmtLeccionesCurso->execute()) {
                $resultLeccionesCurso = $stmtLeccionesCurso->get_result();
                while ($row = $resultLeccionesCurso->fetch_assoc()) {
                    $leccionID = $row['LeccionID'];
                    if (!in_array($leccionID, $usuarioLecciones)) {
                        // Cerrar y reabrir la conexión para cada inserción
                        limpiarResultadosYCerrar($conexion);
                        $conexion = $database->conectarBD();

                        $sqlInsertLeccion = "CALL InsertarUsuarioLeccion(?, ?, ?)";
                        $stmtInsertLeccion = $conexion->prepare($sqlInsertLeccion);
                        $leido = 0;
                        $stmtInsertLeccion->bind_param('iii', $usuarioID, $leccionID, $leido);
                        $stmtInsertLeccion->execute();
                        $stmtInsertLeccion->close();
                    }
                }
                $resultLeccionesCurso->free();
            }
            $stmtLeccionesCurso->close();
            limpiarResultadosYCerrar($conexion);
        } else {
            if (!in_array($leccionID, $usuarioLecciones)) {
                // Reabrir la conexión para inserción individual
                $conexion = $database->conectarBD();

                $sqlInsertLeccion = "CALL InsertarUsuarioLeccion(?, ?, ?)";
                $stmtInsertLeccion = $conexion->prepare($sqlInsertLeccion);
                $leido = 0;
                $stmtInsertLeccion->bind_param('iii', $usuarioID, $leccionID, $leido);
                $stmtInsertLeccion->execute();
                $stmtInsertLeccion->close();
                limpiarResultadosYCerrar($conexion);
                echo "Lección {$leccionID} registrada exitosamente.";
            }
        }

        header("Location: /curso.php?id={$cursoID}");
        exit;

    }
} else {
    echo "Error: Usuario no loggeado.";
    header("Location: /inisesion.php?error=usuario_no_loggeado");
    exit;
}
?>