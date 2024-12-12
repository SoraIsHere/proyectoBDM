<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Cursos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>
<?php
include('conectarBD.php');
include ('functions.php');
include('modelos/Curso.php');
include 'modelos/Categorias.php';

$database = new db();
$conexion = $database->conectarBD();

// Obtener los parámetros del formulario
$categoriaID = isset($_GET['categoria']) && $_GET['categoria'] !== 'todas' ? intval($_GET['categoria']) : null;
$tituloCurso = isset($_GET['titulo']) ? $_GET['titulo'] : null;
$nombreCreador = isset($_GET['usuario']) ? $_GET['usuario'] : null;
$fechaInicio = isset($_GET['fecha-inicio']) ? $_GET['fecha-inicio'] : null;
$fechaFin = isset($_GET['fecha-fin']) ? $_GET['fecha-fin'] : null;

if ($categoriaID == "") {
    $categoriaID = null;
}

if ($tituloCurso == "") {
    $tituloCurso = null;
}

if ($nombreCreador == "") {
    $nombreCreador = null;
}

if ($fechaInicio == "") {
    $fechaInicio = null;
}
if ($fechaFin == "") {
    $fechaFin = null;
}


// Llamar al procedimiento almacenado para buscar cursos
$sqlBuscarCursos = "CALL BuscarCursos(?, ?, ?, ?, ?)";
$stmtBuscarCursos = $conexion->prepare($sqlBuscarCursos);
$stmtBuscarCursos->bind_param('issss', $categoriaID, $tituloCurso, $nombreCreador, $fechaInicio, $fechaFin);
$stmtBuscarCursos->execute();
$resultBuscarCursos = $stmtBuscarCursos->get_result();

$cursos = [];
while ($row = $resultBuscarCursos->fetch_assoc()) {
    $cursos[] = $row;
}
$stmtBuscarCursos->close();

// Obtener categorías
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
mysqli_close($conexion);
?>


<body>
    <main style="margin: 100px 0 30px">
        <section class="buscador">
            <div class="container">
                <h1>Buscador de Cursos</h1>
                <form action="#" method="GET">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="todas">Todas</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->categoriaID; ?>">
                                <?php echo htmlspecialchars($categoria->nombre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="titulo">Título del Curso:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Buscar por título">

                    <label for="usuario">Publicado por:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Buscar por usuario">

                    <label for="fecha-inicio">Fecha de Publicación (Inicio):</label>
                    <input type="date" id="fecha-inicio" name="fecha-inicio">

                    <label for="fecha-fin">Fecha de Publicación (Fin):</label>
                    <input type="date" id="fecha-fin" name="fecha-fin">

                    <button type="submit" class="color-btn mt-4">Buscar</button>
                </form>
            </div>
        </section>

        <section id="cursos" class="courses-section" style="padding-top: 100px;">
            <div class="container">
                <h2 class="mb-4">Resultados de la Búsqueda </h2>
                <div class="d-flex flex-wrap" style="gap:20px">

                    <?php if (!empty($cursos)): ?>
                        <?php foreach ($cursos as $curso): ?>
                            <div class="card" style="flex: 32%; max-width: 32%;">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($curso['Imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($curso['TituloCurso']); ?>">
                                <h3><?php echo htmlspecialchars($curso['TituloCurso']); ?></h3>
                                <p class="pb-0 mb-4"><?php echo htmlspecialchars($curso['Descripcion']); ?></p>
                                <p class="pb-0 m-0 fw-bold">Calificación:
                                    <?php echo htmlspecialchars(CalificacionPromedio(
                                                                        getCursoId($curso['TituloCurso'], $curso['NombreCreador'])
                                                                        )
                                                                ); 
                                    ?>
                                </p>
                                <p class="pb-0 m-0">Creado por: <?php echo htmlspecialchars($curso['NombreCreador']); ?></p>
                                <p class="pb-0 m-0">Fecha de Creación: <?php echo htmlspecialchars($curso['FechaCreacion']); ?>
                                </p>
                                <a href="detalleCurso.php?id=<?php echo $curso['CursoID']; ?>" class="course-link">Ver más</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No se encontraron cursos que coincidan con los criterios de búsqueda.</p>
                    <?php endif; ?>
                </div>

            </div>
        </section>


    </main>
</body>

<?php include("footer.php") ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("cursos").scrollIntoView({ behavior: 'smooth' });
    }); 
</script>

</html>