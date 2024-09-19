<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/curso.css">
</head>

<?php include("header.php") ?>

<body>
    <main>
        <header class="curso-hero">
            <img src="/media/curso1.png">
            <div class="hero-content">
                <h1>Curso de Desarrollo Web</h1>
                <p>Aprende a crear sitios web profesionales y creativos desde cero. </p>
                <a href="#detalle-curso" class="color-btn">Mas detalles</a>
            </div>
        </header>
        <section class="detalle-curso" id="detalle-curso">
            <div class="container">
                <h2>Informacion</h2>
                <div class="texto">
                    <p>
                        En este curso de Desarrollo Web Completo, aprenderás a crear sitios web modernos y dinámicos desde cero. Comenzaremos con los fundamentos de HTML y CSS, avanzando hacia técnicas más avanzadas como Flexbox y Grid Layout. También exploraremos JavaScript y sus frameworks más populares, como React y Next.js, para construir aplicaciones web interactivas y eficientes. Además, te familiarizarás con la integración de sistemas de gestión de contenido como WordPress y Contentful, y aprenderás a optimizar el rendimiento y la seguridad de tus proyectos web. Al finalizar el curso, estarás preparado para enfrentar desafíos reales en el desarrollo web y crear sitios y aplicaciones que destaquen por su funcionalidad y diseño.
                    </p>

                    <table>
                        <thead>
                            <tr>
                                <th>Tema</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#html-css">Fundamentos de HTML y CSS</a></td>
                                <td>✔️</td>
                            </tr>
                            <tr>
                                <td><a href="#javascript-react">JavaScript y React</a></td>
                                <td>✔️</td>
                            </tr>
                            <tr>
                                <td><a href="#wordpress">Integración con WordPress</a></td>
                                <td>❌</td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="width: 100%; text-align:center">
                        <a type="button" href="/curso.php" class="transparent-btn" style="margin-top:20px; display:block">Comprar todo el curso</a>
                        <a type="button" href="/diploma.php" class="color-btn" style="margin-top:20px; display:block">Curso completado!</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<?php include("footer.php") ?>

</html>