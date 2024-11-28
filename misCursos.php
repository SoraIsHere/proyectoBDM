<?php include("header.php"); ?>
<?php include("conectarBD.php"); ?>

<?php
// Verifica si el usuario está logeado
if (!isset($_SESSION['usuarioLoggeado'])) {
    header("Location: inisesion.php?error=usuario_no_loggeado");
    exit;
}

$usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
$usuarioID = $usuarioLoggeado->usuarioID;

$database = new db();
$conexion = $database->conectarBD();

if (!$conexion) {
    die('Error al conectar a la base de datos: ' . mysqli_connect_error());
}

// Consulta segura con prepared statements
$stmt = $conexion->prepare("SELECT CursoID, Nombre, Descripcion, Calificacion, CostoGeneral FROM curso WHERE CreadorID = ?");
$stmt->bind_param("i", $usuarioID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Error en la consulta: ' . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main style="margin: 100px 0 30px">
    <h1>Mis Cursos</h1>
    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Calificación</th>
                    <th>Costo General</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['Descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($row['Calificacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['CostoGeneral']); ?></td>
                        <td>
                            <!-- Botón de detalles -->
                            <form action="infoDetalladaCurso.php" method="get" style="margin: 0;">
                                <input type="hidden" name="CursoID" value="<?php echo $row['CursoID']; ?>">
                                <button type="submit">Detalles</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron cursos creados por ti.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conexion->close();
    ?>
</main>
</body>
</html>
