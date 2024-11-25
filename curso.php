<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/paginaCurso.css">
</head>

<?php include("header.php") ?>

<?php
include('conectarBD.php');
$database = new db();
$conexion = $database->conectarBD();

include("controladores/ObtenerCurso.php");

$leccion = isset($_GET['nivel']) ? intval($_GET['nivel']) : false;
?>
<style>
    .tema-container {
        margin-top: -100px;
        padding-top: 100px !important;
        opacity: 0;
        position: absolute;
        pointer-events: none;
        transition: all 200ms;
        display: none;
    }

    .tema-container.active {
        opacity: 1;
        display: block;
        position: static;
        pointer-events: all;
    }

    .color-btn.leccion-link {
        width: fit-content;
    }
</style>

<body>
    <div class="contenedor-curso">
        <aside class="barra-lateral">
            <a href="/detalleCurso.php?id=<?php echo $curso->cursoID ?>" class="mb-4 d-block">volver</a>
            <h2>Temas del Curso</h2>
            <ul class="lista-temas">
                <?php foreach ($lecciones as $leccion): ?>
                    <li>
                        <a href="#tema-<?php echo $leccion->leccionID ?>" class="leccion-link">
                            <?php echo $leccion->nombre ?> <span class="completado">✔️</span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </aside>
        <main class="contenido-tema">
            <?php $count = 1;
            $max = count($lecciones);
            foreach ($lecciones as $leccion): ?>
                <section class="tema-container <?php echo $count == 1 ? "active" : "" ?>"
                    id="tema-<?php echo $leccion->leccionID ?>">
                    <h2><?php echo $leccion->nombre ?></h2>
                    <p><?php echo $leccion->descripcion ?></p>
                    <h3 class="mt-4">Video</h3>
                    <div class="videos"> <?php if (!empty($leccion->video)): ?> <video controls>
                                <source src="data:video/mp4;base64,<?php echo base64_encode($leccion->video); ?>"
                                    type="video/mp4"> Tu navegador no soporta el elemento de video.
                            </video> <?php else: ?>
                            <p>No hay video disponible para esta lección.</p> <?php endif; ?>
                    </div>
                    <div class="" style="width:100%; text-align:right">
                        <?php if ($count != $max) { ?>
                            <a class="color-btn leccion-link d-flex mt-4 float-end"
                                href="#tema-<?php echo $lecciones[$count]->leccionID ?>">Terminar Leccion
                            </a>
                        <?php } else { ?>
                            <a class="color-btn d-flex mt-4 float-end" href="diploma.php?id=<?php echo $cursoID ?>">Terminar Curso
                            </a>
                        <?php } ?>
                    </div>
                </section>
                <?php $count++; endforeach ?>
        </main>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const links = document.querySelectorAll('.leccion-link');
        links.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); // Prevenir el comportamiento por defecto del enlace

                // Remover la clase 'active' de todos los elementos de contenido
                const contenido = document.querySelectorAll('.tema-container');
                contenido.forEach(c => c.classList.remove('active'));

                const videos = document.querySelectorAll('video'); videos.forEach(video => video.pause());

                // Obtener el elemento al que apunta el href
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.classList.add('active');
                }
            });
        });
    });
</script>


<?php include("footer.php") ?>

</html>