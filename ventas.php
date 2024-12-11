<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Perfil del Instructor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>
<?php
include('conectarBD.php');
include 'modelos/Categorias.php';
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

// Verifica si el usuario está loggeado 
if (!isset($_SESSION['usuarioLoggeado'])) {
    header("Location: inisesion.php?error=usuario_no_loggeado");
    exit;
}

$usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
$usuarioID = $usuarioLoggeado->usuarioID;

// Obtener los parámetros del formulario 
$fechaInicio = isset($_GET['fecha-inicio']) && $_GET['fecha-inicio'] !== '' ? $_GET['fecha-inicio'] : null;
$fechaFin = isset($_GET['fecha-fin']) && $_GET['fecha-fin'] !== '' ? $_GET['fecha-fin'] : null;
$categoriaID = isset($_GET['categoria']) && $_GET['categoria'] !== '' ? intval($_GET['categoria']) : null;
$estado = isset($_GET['estado']) && $_GET['estado'] !== '' ? $_GET['estado'] : 'todos';
$activo = $estado === 'activos' ? TRUE : NULL;

// Llamar al procedimiento almacenado para obtener el reporte de ventas de cursos
$sqlReporteVentas = "CALL ReporteVentasCursos(?, ?, ?, ?, ?)";
$stmtReporteVentas = $conexion->prepare($sqlReporteVentas);
$stmtReporteVentas->bind_param('issii', $usuarioID, $fechaInicio, $fechaFin, $categoriaID, $activo);
$stmtReporteVentas->execute();
$resultReporteVentas = $stmtReporteVentas->get_result();
$ventas = [];
while ($row = $resultReporteVentas->fetch_assoc()) {
    $ventas[] = $row;
}
$stmtReporteVentas->close();
mysqli_next_result($conexion);


$sqlAlumnosInscritos = "CALL SELECT contar_estudiantes(?, ?) AS total_estudiantes;";
$stmtTotalAlumnosInscritos = $conexion->prepare($sqlAlumnosInscritos);
$stmtAlumnosInscritos->bind_param('issii', $usuarioID, $cursoID);
$stmtAlumnosInscritos->execute();
$resultAlumnosInscritos = $stmtAlumnosInscritos->get_result();
$stmtAlumnosInscritos->close();

// Llamar al procedimiento almacenado para obtener el total de ventas por método de pago
$sqlTotalVentasPorMetodoPago = "CALL TotalVentasPorMetodoPago(?, ?, ?, ?, ?)";
$stmtTotalVentasPorMetodoPago = $conexion->prepare($sqlTotalVentasPorMetodoPago);
$stmtTotalVentasPorMetodoPago->bind_param('issii', $usuarioID, $fechaInicio, $fechaFin, $categoriaID, $activo);
$stmtTotalVentasPorMetodoPago->execute();
$resultTotalVentasPorMetodoPago = $stmtTotalVentasPorMetodoPago->get_result();
$metodosPago = [];
while ($row = $resultTotalVentasPorMetodoPago->fetch_assoc()) {
    $metodosPago[$row['FormaPago']] = $row['TotalIngresos'];
}
$stmtTotalVentasPorMetodoPago->close();

// Preparar variables para el desglose por forma de pago
$tarjeta = isset($metodosPago['tarjeta']) ? $metodosPago['tarjeta'] : 0;
$paypal = isset($metodosPago['paypal']) ? $metodosPago['paypal'] : 0;

// Verificación para evitar valores NULL en number_format
$totalIngresos = isset($totalIngresos) ? $totalIngresos : 0;
$tarjeta = isset($tarjeta) ? $tarjeta : 0;
$paypal = isset($paypal) ? $paypal : 0;

// Obtener los detalles del curso si se ha proporcionado el parámetro 'detalles'
$cursoIDDetalles = isset($_GET['detalles']) ? intval($_GET['detalles']) : null;
$detalles = [];
if ($cursoIDDetalles) {
    $sqlDetalleVentas = "CALL DetalleVentasCurso(?)";
    $stmtDetalleVentas = $conexion->prepare($sqlDetalleVentas);
    $stmtDetalleVentas->bind_param('i', $cursoIDDetalles);
    $stmtDetalleVentas->execute();
    $resultDetalleVentas = $stmtDetalleVentas->get_result();
    while ($row = $resultDetalleVentas->fetch_assoc()) {
        $detalles[] = $row;
    }
    $stmtDetalleVentas->close();
    mysqli_next_result($conexion);
}

mysqli_close($conexion);
?>

<body>
    <main style="margin: 100px 0 30px">
        <section class="filtros">
            <div class="container">
                <div class="mb-5">
                    <h1 class="m-0">Mis Ventas de Cursos</h1>
                    <a href="./crearCurso.php" class="color-btn mt-4 d-block"
                        style="text-align:center; width:fit-content">Nuevo Curso</a>

                        <a href="./misCursos.php" class="color-btn mt-4 d-block"
                        style="text-align:center; width:fit-content">Mis Cursos</a>

                </div>
                <h2>Filtros</h2>
                <form action="./ventas.php">
                    <label for="fecha-inicio">Fecha de Creación (Inicio):</label>
                    <input type="date" id="fecha-inicio" name="fecha-inicio">

                    <label for="fecha-fin">Fecha de Creación (Fin):</label>
                    <input type="date" id="fecha-fin" name="fecha-fin">

                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="">Todas</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->categoriaID; ?>">
                                <?php echo htmlspecialchars($categoria->nombre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="estado">Estado del Curso:</label>
                    <select id="estado" name="estado">
                        <option value="todos">Todos</option>
                        <option value="activos">Solo Activos</option>
                    </select>

                    <button type="submit" class="color-btn mt-4">Aplicar Filtros</button>
                </form>
            </div>
        </section>

        <section class="resumen-ventas" id="resumen-ventas">
            <div class="container">
                <h2>Resumen de Ventas</h2>


                <!-- Llenar la tabla de resumen de ventas -->
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Alumnos Inscritos</th>
                            <th>Nivel Promedio</th>
                            <th>Ingresos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ventas)): ?>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($venta['NombreCurso']); ?></td>
                                    <td><?php echo htmlspecialchars($venta['CantidadAlumnosInscritos']); ?></td>
                                    <td><?php echo htmlspecialchars($venta['NivelPromedio']); ?></td>
                                    <td><?php echo htmlspecialchars('$' . number_format($venta['TotalIngresos'], 2)); ?></td>
                                    <td><a href="ventas.php?detalles=<?php echo $venta['CursoID']; ?>" class="color-btn">Ver
                                            Detalles</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No se encontraron resultados para los filtros aplicados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total de Ingresos</th>
                            <th>
                                <?php
                                $totalIngresos = array_sum(array_column($ventas, 'TotalIngresos'));
                                echo '$' . number_format($totalIngresos, 2);
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="4">Desglose por Forma de Pago</th>
                            <th>
                                Tarjeta: $<?php echo number_format($tarjeta, 2); ?> | PayPal:
                                $<?php echo number_format($paypal, 2); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>


            </div>
        </section>

        <!-- Tabla de detalles del curso --> <?php if ($cursoIDDetalles && !empty($detalles)): ?>
            <section class="detalle-curso">
                <div class="container">
                    <h2>Detalle de Curso:
                        <?php echo htmlspecialchars($ventas[array_search($cursoIDDetalles, array_column($ventas, 'CursoID'))]['NombreCurso']); ?>
                    </h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre del Alumno</th>
                                <th>Fecha de Inscripción</th>
                                <th>Nivel de Avance</th>
                                <th>Precio Pagado</th>
                                <th>Forma de Pago</th>
                            </tr>
                        </thead>
                        <tbody> <?php foreach ($detalles as $detalle): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detalle['NombreAlumno']); ?></td>
                                    <td><?php echo htmlspecialchars($detalle['FechaInscripcion']); ?></td>
                                    <td><?php echo htmlspecialchars($detalle['NivelAvance']); ?></td>
                                    <td><?php echo htmlspecialchars('$' . number_format($detalle['PrecioPagado'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($detalle['FormaPago']); ?></td>
                                </tr> <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total de Ingresos</th>
                                <th> <?php $totalIngresosDetalles = array_sum(array_column($detalles, 'PrecioPagado'));
                                echo '$' . number_format($totalIngresosDetalles, 2); ?>
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section> <?php endif; ?>
    </main>


    <?php include("footer.php") ?>
</body>
<script>window.onload = function () {
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(window.location.search);

        // Verificar si el parámetro 'creado' existe y es igual a 'true'
        if (params.get('creado') === 'true') {
            alert('Curso creado con éxito');
        }
    }
</script>

</html>
