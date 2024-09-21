<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("header.php") ?>
    <meta charset="UTF-8">
    <title>WebLearning</title>
</head>

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
                    <li class="list-group-item bg-transparent ">
                        <a href="#" class="transparent-btn">Desarrollo Web</a>
                    </li>
                    <li class="list-group-item bg-transparent">
                        <a href="#" class="transparent-btn">Diseño UX/UI</a>
                    </li>
                    <li class="list-group-item bg-transparent">
                        <a href="#" class="transparent-btn">Marketing Digital</a>
                    </li>
                    <li class="list-group-item bg-transparent">
                        <a href="#" class="transparent-btn">Programación</a>
                    </li>
                    <li class="list-group-item bg-transparent">
                        <a href="#" class="transparent-btn">Bases de Datos</a>
                    </li>
                    <li class="list-group-item bg-transparent">
                        <a href="#" class="transparent-btn">Inteligencia Artificial</a>
                    </li>
                </ul>
                <div class="busqueda my-4">
                    <form class="d-flex" action="/busquedas.php">
                        <input type="text" id="titulo" name="titulo" placeholder="Buscar por título"><button type="submit" class="transparent-btn">Buscar</button>
                    </form>
                </div>
                <div class="card-grid">
                    <div class="card">
                        <img src="media/curso1.png" alt="Curso 1">
                        <h3>Curso de Desarrollo Web</h3>
                        <p>Aprende a crear sitios web profesionales y creativos desde cero.</p>
                        <a href="/detalleCurso.php" class="course-link fw-bold text-white">Ver más</a>
                        <div class="mt-3">
                            <a href="#" class="">Inteligencia Artificial</a>,
                            <a href="#" class="">Programacion</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="media/curso2.png" alt="Curso 2">
                        <h3>Curso de Marketing Digital</h3>
                        <p>Domina el idioma de tu preferencia y expande tu oportunidad laboral.</p>
                        <a href="/detalleCurso.php" class="course-link fw-bold text-white">Ver más</a>
                        <div class="mt-3">
                            <a href="#" class="">Inteligencia Artificial</a>,
                            <a href="#" class="">Programacion</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="media/curso3.png" alt="Curso 3">
                        <h3>Curso de Desarrollo de Apps moviles</h3>
                        <p>Crea applicaciones útiles con herramientas profesionales.</p>
                        <a href="/detalleCurso.php" class="course-link fw-bold text-white">Ver más</a>
                        <div class="mt-3">
                            <a href="#" class="">Inteligencia Artificial</a>,
                            <a href="#" class="">Programacion</a>
                        </div>
                    </div>
                    <!-- Más cursos -->
                </div>
                <div class="text-center d-flex justify-content-center">
                    <a href="/busquedas.php" class="transparent-btn mt-4">Ver todos</a>
                </div>
            </div>
        </section>

        <section id="sobre-nosotros" class="about-section bg-light text-center">
            <div class="container">
                <div class="nosotros-card">
                    <h2>Sobre Nosotros</h2>
                    <p>Somos una plataforma dedicada a facilitar a los docentes la creación y gestión de cursos en línea.
                        Nuestro objetivo es proporcionar herramientas simples y eficientes para que los educadores puedan
                        compartir su conocimiento de manera accesible y efectiva. Al mismo tiempo, buscamos ofrecer a los
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