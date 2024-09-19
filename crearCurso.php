<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear/Editar Curso</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/crearCurso.css">
</head>

<?php include("header.php") ?>

<body>
    <section>
        <div class="container">
            <div class="contenedor-formulario">
                <h1>Crear Curso</h1>
                <form id="formulario-curso">
                    <label for="nombre-curso">Nombre del Curso:</label>
                    <input type="text" id="nombre-curso" name="nombre-curso" required>

                    <label for="descripcion-corta">Descripción Corta:</label>
                    <textarea id="descripcion-corta" name="descripcion-corta" required></textarea>

                    <label for="descripcion-larga">Descripción Larga:</label>
                    <textarea id="descripcion-larga" name="descripcion-larga" required></textarea>

                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" min="0" required>

                    <div id="contenedor-capitulos">
                        <h2>Capítulos</h2>
                        <div class="capitulo" id="capitulo-1">
                            <label for="capitulos[0][titulo]">Título del Capítulo:</label>
                            <input type="text" id="capitulos[0][titulo]" name="capitulos[0][titulo]" required>

                            <label for="capitulos[0][contenido]">Contenido del Capítulo:</label>
                            <textarea id="capitulos[0][contenido]" name="capitulos[0][contenido]" required></textarea>

                            <label for="capitulos[0][imagenes]">Imágenes:</label>
                            <input type="file" id="capitulos[0][imagenes]" name="capitulos[0][imagenes][]" multiple>

                            <label for="capitulos[0][videos]">Videos:</label>
                            <input type="file" id="capitulos[0][videos]" name="capitulos[0][videos][]" multiple>
                        </div>
                    </div>

                    <button type="button" class="transparent-btn" onclick="agregarCapitulo()">Agregar Capítulo</button>
                    <button type="submit" class="color-btn">Guardar Curso</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/scripts/crearCurso.js"></script>
</body>

<?php include("footer.php") ?>

</html>