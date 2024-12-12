<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("header.php") ?>
    <meta charset="UTF-8">
    <title>WebLearning</title>
</head>
<?php
include_once 'functions.php';
include 'modelos/Categorias.php';
include('conectarBD.php');
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
mysqli_close($conexion);

?>

<?php include("controladores/CursosValorados.php");
include("controladores/CursosVendidos.php");
include("controladores/CursosRecientes.php");
?>

<body>
    <header class="hero">
        <div class="hero-content">
            <h1>Aprende y crece con nuestros cursos online</h1>
            <p>Desarrolla nuevas habilidades y avanza en tu carrera con los mejores cursos en línea.</p>
            <a href="#cursos" class="color-btn">Explorar Cursos</a>
        </div>
    </header>


    <main class="main-content">
        <section id="cursos" class="courses-section">
            <div class="container">
                <h2>Nuestros Cursos</h2>
                <ul class="list-group mb-4 mt-4 d-flex flex-row">
                    <?php foreach ($categorias as $categoria): ?>
                        <li class="list-group-item bg-transparent ">
                            <a href="/busquedas.php?cat=<?php echo $categoria->categoriaID; ?>"
                                class="transparent-btn"><?php echo htmlspecialchars($categoria->nombre); ?></a>
                        </li>
                    <?php endforeach; ?>


                </ul>
                <div class="busqueda my-4">
                    <form class="d-flex" action="/busquedas.php">
                        <input type="text" id="titulo" name="titulo" placeholder="Buscar por título"><button
                            type="submit" class="transparent-btn">Buscar</button>
                    </form>
                </div>
                <h3 class="mb-4">Mejor valorados</h3>
                <div class="card-grid">
                    <?php
                    foreach ($cursosInicio as $curso) {
                        ?>
                        <div class="card">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($curso->imagen); ?>"
                                alt="<?php echo htmlspecialchars($curso->nombre); ?>">

                            <h3><?php echo $curso->nombre ?></h3>
                            <p class="text-green fw-bold">Calificacion: <?php echo CalificacionPromedio($curso->cursoID) ?></p>
                            <p><?php echo $curso->descripcion ?></p>
                            <a href="/detalleCurso.php?id=<?php echo $curso->cursoID ?>"
                                class="course-link fw-bold text-white">Ver más</a>
                            <div class="mt-3">
                                <a <?php echo !$curso->categoriaBorrada ? "href=/busquedas.php?cat=" . $curso->categoriaID : "" ?>><?php echo !$curso->categoriaBorrada ? $curso->categoriaNombre : "Sin categoria" ?></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Más cursos -->
                </div>
                <div class="text-center d-flex justify-content-center">
                    <a href="/busquedas.php" class="transparent-btn mt-4">Ver todos</a>
                </div>


                <h3 class="mb-4">Mas Recientes</h3>
                <div class="card-grid mb-5">
                    <?php
                    foreach ($cursosRecientes as $curso) {
                        ?>
                        <div class="card">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($curso->imagen); ?>"
                                alt="<?php echo htmlspecialchars($curso->nombre); ?>">

                            <h3><?php echo $curso->nombre ?></h3>
                            <p class="text-green fw-bold">Calificacion: <?php echo CalificacionPromedio($curso->cursoID) ?></p>
                            <p><?php echo $curso->descripcion ?></p>
                            <a href="/detalleCurso.php?id=<?php echo $curso->cursoID ?>"
                                class="course-link fw-bold text-white">Ver más</a>
                            <div class="mt-3">
                                <a <?php echo !$curso->categoriaBorrada ? "href=/busquedas.php?cat=" . $curso->categoriaID : "" ?>><?php echo !$curso->categoriaBorrada ? $curso->categoriaNombre : "Sin categoria" ?></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Más cursos -->
                </div>

                <h3 class="mb-4">Mas Vendidos</h3>
                <div class="card-grid">
                    <?php
                    foreach ($cursosVendidos as $curso) {
                        ?>
                        <div class="card">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($curso->imagen); ?>"
                                alt="<?php echo htmlspecialchars($curso->nombre); ?>">

                            <h3><?php echo $curso->nombre ?></h3>
                            <p class="text-green fw-bold">Calificacion: <?php echo CalificacionPromedio($curso->cursoID) ?></p>
                            <p><?php echo $curso->descripcion ?></p>
                            <a href="/detalleCurso.php?id=<?php echo $curso->cursoID ?>"
                                class="course-link fw-bold text-white">Ver más</a>
                            <div class="mt-3">
                                <a <?php echo !$curso->categoriaBorrada ? "href=/busquedas.php?cat=" . $curso->categoriaID : "" ?>><?php echo !$curso->categoriaBorrada ? $curso->categoriaNombre : "Sin categoria" ?></a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- Más cursos -->
                </div>
            </div>
        </section>

        <section id="sobre-nosotros" class="about-section bg-light text-center">
            <div class="container">
                <div class="nosotros-card">
                    <h2>Sobre Nosotros</h2>
                    <p>Somos una plataforma dedicada a facilitar a los docentes la creación y gestión de cursos en
                        línea.
                        Nuestro objetivo es proporcionar herramientas simples y eficientes para que los educadores
                        puedan
                        compartir su conocimiento de manera accesible y efectiva. Al mismo tiempo, buscamos ofrecer a
                        los
                        estudiantes la oportunidad de acceder a una amplia variedad de cursos desde cualquier lugar y en
                        cualquier momento, haciendo que el aprendizaje sea más inclusivo y al alcance de todos.</p>
                </div>
            </div>
        </section>

        <section id="testimonios sobre nuestros servicios" class="testimonials-section">
            <div class="container">
                <h2>Testimonios</h2>
                <div class="testimonials-grid">
                    <div class="card">
                        <p>"Los cursos me han ayudado a avanzar en mi carrera. La plataforma es fácil de usar y los
                            instructores son excelentes."</p>
                        <h4>- Juan Pérez</h4>
                    </div>
                    <div class="card">
                        <p>"Gracias a estos cursos, pude aprender nuevas habilidades y mejorar mis conocimientos en
                            Desarrollo de apps para dispositivos moviles."</p>
                        <h4>- Ana Rodríguez</h4>
                    </div>
                    <!-- Más testimonios -->
                </div>
            </div>
        </section>
        <?php
        include("footer.php");
        ?>
</body>

</html>