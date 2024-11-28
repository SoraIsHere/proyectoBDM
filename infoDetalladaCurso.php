<?php include("header.php"); ?>
<?php include("conectarBD.php"); ?>

<?php
// Verifica si el usuario está logeado
if (!isset($_SESSION['usuarioLoggeado'])) {
    header("Location: inisesion.php?error=usuario_no_loggeado");
    exit;
}

$database = new db();
$conexion = $database->conectarBD();

if (!$conexion) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

// Verifica si se recibió el ID del curso
if (!isset($_GET['CursoID'])) {
    die("Error: No se especificó el ID del curso.");
}

$cursoID = intval($_GET['CursoID']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_curso'])) {
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);
        $costoGeneral = floatval($_POST['costoGeneral']);

        $updateCursoQuery = "UPDATE curso SET Nombre='$nombre', Descripcion='$descripcion', CostoGeneral='$costoGeneral' WHERE CursoID=$cursoID";
        if ($conexion->query($updateCursoQuery)) {
            echo "<script>alert('El curso se actualizó correctamente.'); window.location.href='/misCursos.php';</script>";
        } else {
            echo "<p>Error al actualizar el curso: " . $conexion->error . "</p>";
        }
    } elseif (isset($_POST['delete_curso'])) {
        $deleteCursoQuery = "UPDATE curso SET BorradoLogico=1 WHERE CursoID=$cursoID";
        if ($conexion->query($deleteCursoQuery)) {
            echo "<script>alert('El curso se eliminó correctamente.'); window.location.href='index.php';</script>";
        } else {
            echo "<p>Error al eliminar el curso: " . $conexion->error . "</p>";
        }
    } elseif (isset($_POST['update_leccion'])) {
        $leccionID = intval($_POST['leccionID']);
        $nombreLeccion = $conexion->real_escape_string($_POST['nombre_leccion']);
        $descripcionLeccion = $conexion->real_escape_string($_POST['descripcion_leccion']);
        $costoLeccion = floatval($_POST['costo_leccion']);

        $updateLeccionQuery = "UPDATE leccion SET Nombre='$nombreLeccion', Descripcion='$descripcionLeccion', Costo='$costoLeccion' WHERE LeccionID=$leccionID";
        if ($conexion->query($updateLeccionQuery)) {
            echo "<script>alert('La lección se actualizó correctamente.'); window.location.reload();</script>";
        } else {
            echo "<p>Error al actualizar la lección: " . $conexion->error . "</p>";
        }
    } elseif (isset($_POST['delete_leccion'])) {
        $leccionID = intval($_POST['leccionID']);
        $deleteLeccionQuery = "UPDATE leccion SET BorradoLogico=1 WHERE LeccionID=$leccionID";
        if ($conexion->query($deleteLeccionQuery)) {
            echo "<script>alert('La lección se eliminó correctamente.');</script>";
            header("Location: " . $_SERVER['PHP_SELF'] . "?CursoID=$cursoID");
            exit; 
        } else {
            echo "<p>Error al eliminar la lección: " . $conexion->error . "</p>";
        }
    }
    
}

// Obtener información del curso
$cursoQuery = "SELECT Nombre, Descripcion, CostoGeneral FROM curso WHERE CursoID=$cursoID AND BorradoLogico=0";
$cursoResult = $conexion->query($cursoQuery);

if ($cursoResult->num_rows === 0) {
    die("Error: El curso no existe o ha sido eliminado.");
}

$curso = $cursoResult->fetch_assoc();

// Obtener las lecciones
$leccionesQuery = "SELECT LeccionID, Nombre, Descripcion, Costo FROM leccion WHERE CursoID=$cursoID AND BorradoLogico=0";
$leccionesResult = $conexion->query($leccionesQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Detallada del Curso</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Estilos para el modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: #1e1e1e;
    color: #00ffc5;
    border-radius: 8px;
    padding: 20px;
    width: 400px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    font-family: Arial, sans-serif;
    position: relative;
}

.modal-content h2 {
    margin: 0;
    margin-bottom: 15px;
    font-size: 20px;
    text-align: center;
    border-bottom: 1px solid #333;
    padding-bottom: 10px;
}

.modal-content label {
    font-size: 14px;
    display: block;
    margin: 10px 0 5px;
}

.modal-content input,
.modal-content textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #333;
    border-radius: 5px;
    background-color: #2b2b2b;
    color: #fff;
}

.modal-content button {
    background-color: #00ffc5;
    border: none;
    color: #000;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    display: block;
    margin: 0 auto;
}

.modal-content button:hover {
    background-color: #00cca3; 
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 18px;
    cursor: pointer;
    color: #fff;
}

    </style>
</head>
<body>
<main style="margin: 100px 0 30px">
    <h1>Información Detallada del Curso</h1>

    <!-- Formulario para editar curso -->
    <form method="post">
        <label for="nombre">Nombre del curso:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($curso['Nombre']); ?>" required>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($curso['Descripcion']); ?></textarea>
        <label for="costoGeneral">Costo General:</label>
        <input type="number" id="costoGeneral" name="costoGeneral" value="<?php echo htmlspecialchars($curso['CostoGeneral']); ?>" required>
        <button type="submit" name="update_curso">Guardar cambios</button>
        <button type="submit" name="delete_curso" onclick="return confirm('¿Estás seguro de que deseas eliminar este curso?');">Eliminar curso</button>
    </form>

    <!-- Tabla de lecciones -->
    <h2>Lecciones</h2>
    <?php if ($leccionesResult->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($leccion = $leccionesResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($leccion['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($leccion['Descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($leccion['Costo']); ?></td>
                        <td>
                            <button onclick="mostrarModal(<?php echo htmlspecialchars(json_encode($leccion)); ?>)">Detalles</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay lecciones asociadas a este curso.</p>
    <?php endif; ?>

    <!-- Modal para editar o borrar lección -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Editar o Borrar Lección</h2>
            <form method="post">
                <input type="hidden" id="leccionID" name="leccionID">
                <label for="nombre_leccion">Nombre:</label>
                <input type="text" id="nombre_leccion" name="nombre_leccion" required>
                <label for="descripcion_leccion">Descripción:</label>
                <textarea id="descripcion_leccion" name="descripcion_leccion" required></textarea>
                <label for="costo_leccion">Costo:</label>
                <input type="number" id="costo_leccion" name="costo_leccion" required>
                <button type="submit" name="update_leccion">Guardar</button><br>
                <button type="submit" name="delete_leccion" style="background-color: red; color: white;">Eliminar</button>
            </form>
        </div>
    </div>

    <script>
        function mostrarModal(leccion) {
            document.getElementById('leccionID').value = leccion.LeccionID;
            document.getElementById('nombre_leccion').value = leccion.Nombre;
            document.getElementById('descripcion_leccion').value = leccion.Descripcion;
            document.getElementById('costo_leccion').value = leccion.Costo;
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</main>
</body>
</html>

<?php
$conexion->close();
?>
