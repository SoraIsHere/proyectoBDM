<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>
<?php
include('conectarBD.php');
include('modelos/Categorias.php');
$database = new db();
$conexion = $database->conectarBD();
$sql = "CALL ObtenerCategorias()";
$result = mysqli_query($conexion, $sql);
if (!$result) {
    die('Error: ' . mysqli_error($conexion));
}
$categorias = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categoria = new Categoria($row['CategoriaID'], $row['Nombre'], $row['Descripcion'], $row['CreadorID'], $row['FechaCreacion'], $row['BorradoLogico'], $row['FechaEliminacion']);
    $categorias[] = $categoria;
}
mysqli_free_result($result);
mysqli_next_result($conexion);

$reportDataInstructores = [];
$reportDataEstudiantes = [];

// Obtener el reporte de instructores
$sqlReporteInstructores = "CALL ReporteInstructores()";
$resultReporteInstructores = mysqli_query($conexion, $sqlReporteInstructores);
if (!$resultReporteInstructores) {
    die('Error: ' . mysqli_error($conexion));
}
while ($row = mysqli_fetch_assoc($resultReporteInstructores)) {
    $reportDataInstructores[] = $row;
}
mysqli_free_result($resultReporteInstructores);
mysqli_next_result($conexion);

// Obtener el reporte de estudiantes
$sqlReporteEstudiantes = "CALL ReporteEstudiantes()";
$resultReporteEstudiantes = mysqli_query($conexion, $sqlReporteEstudiantes);
if (!$resultReporteEstudiantes) {
    die('Error: ' . mysqli_error($conexion));
}
while ($row = mysqli_fetch_assoc($resultReporteEstudiantes)) {
    $reportDataEstudiantes[] = $row;
}
mysqli_free_result($resultReporteEstudiantes);
mysqli_close($conexion);
?>

<body>
    <main style="margin: 100px 0 30px">
        <section class="resultados" id="instructores">
            <div class="container">
                <h2>Resultados del Reporte de Instructor</h2>
                <table id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Cursos Ofrecidos</th>
                            <th>Total de Ganancias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportDataInstructores as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Usuario']); ?></td>
                                <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['FechaIngreso']); ?></td>
                                <td><?php echo htmlspecialchars($row['CantidadCursosOfrecidos']); ?></td>
                                <td><?php echo htmlspecialchars('$' . number_format($row['TotalGanancias'], 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="resultados" id="alumnos">
            <div class="container">
                <h2>Resultados del Reporte de Alumnos</h2>
                <table id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Cursos Inscritos</th>
                            <th>Porcentaje Cursos Terminados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportDataEstudiantes as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Usuario']); ?></td>
                                <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['FechaIngreso']); ?></td>
                                <td><?php echo htmlspecialchars($row['CantidadCursosInscritos']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($row['PorcentajeCursosTerminados'], 2) . '%'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>

<script>

    function confirmarBorrado() {
        return confirm("¿Estás seguro de que deseas borrar esta categoria?");
    }
    window.onload = function () {
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(window.location.search);
        if (params.get('catCreada') === 'true') {
            alert('Categoria creada con éxito');
        }
        if (params.get('catBorrada') === 'true') {
            alert('Categoria Eliminada');
        }
        if (params.get('catEditada') === 'true') {
            alert('Categoria Editada');
        }
    }
</script>
<?php include("footer.php") ?>

</html>