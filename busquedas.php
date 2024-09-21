<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Cursos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>

<body>
    <main style="margin: 100px 0 30px">
        <section class="buscador">
            <div class="container">
                <h1>Buscador de Cursos</h1>
                <form action="#" method="GET">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="todas">Todas</option>
                        <option value="it-software">IT & Software</option>
                        <option value="marketing">Marketing</option>
                        <option value="design">Design</option>
                        <!-- Agrega más categorías según sea necesario -->
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

        <section id="cursos" class="courses-section">
            <div class="container">
                <h2 class="mb-4">Resultados de la Búsqueda </h2>
                <div class="card-grid">
                    <div class="card">
                        <img src="media/curso1.png" alt="Curso 1">
                        <h3>Curso de Desarrollo Web</h3>
                        <p>Aprende a crear sitios web profesionales y creativos desde cero.</p>
                        <a href="#" class="course-link">Ver más</a>
                    </div>
                    <div class="card">
                        <img src="media/curso2.png" alt="Curso 2">
                        <h3>Curso de Marketing Digital</h3>
                        <p>Domina el idioma de tu preferencia y expande tu oportunidad laboral.</p>
                        <a href="#" class="course-link">Ver más</a>
                    </div>
                    <div class="card">
                        <img src="media/curso3.png" alt="Curso 3">
                        <h3>Curso de Desarrollo de Apps moviles</h3>
                        <p>Crea applicaciones útiles con herramientas profesionales.</p>
                        <a href="#" class="course-link">Ver más</a>
                    </div>
                    <!-- Más cursos -->
                </div>
            </div>
        </section>


    </main>
</body>

<?php include("footer.php") ?>

</html>