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

<body>
    <div class="contenedor-curso">
        <aside class="barra-lateral">
            <a href="/detalleCurso.php">volver</a>
            <h2>Temas del Curso</h2>
            <ul class="lista-temas">
                <li><a href="#tema1">Fundamentos de HTML y CSS <span class="completado">✔️</span></a></li>
                <li><a href="#tema2">JavaScript y React <span class="completado">✔️</span></a></li>
                <li><a href="#tema3">Integración con WordPress</a></li>
            </ul>
        </aside>
        <main class="contenido-tema">
            <section id="tema1" class="tema-container">
                <h2>Fundamentos de HTML y CSS</h2>
                <p>En este tema, aprenderás los conceptos básicos de HTML y CSS, incluyendo la estructura de un documento HTML, etiquetas comunes, y cómo aplicar estilos con CSS.</p>
                <div class="img-container-curso">
                    <img class="img-curso" src="/media/curso1.jpg">
                </div>
                <h3>Videos </h3>
                <div class="videos">
                    <video src="/media/videos/clase.mp4" controls>

                    </video>
                </div>
                <div class="" style="width:100%; text-align:right">

                    <button class="color-btn" onclick="location.href='#tema2'">Siguiente </button>
                </div>
            </section>
        </main>
    </div>
</body>

<?php include("footer.php") ?>

</html>