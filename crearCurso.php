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
mysqli_close($conexion);

?>

<body>
    <section>
        <div class="container">
            <div class="contenedor-formulario">
                <h1>Crear Curso</h1>
                <form id="formulario-curso" action="/controladores/CrearCurso.php" method="POST"
                    enctype="multipart/form-data">
                    <label for="nombre-curso">Nombre del Curso:</label>
                    <input type="text" id="nombre-curso" name="nombre" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>

                    <label for="precio">Costo:</label>
                    <input type="number" id="costo" name="precio" min="0" required>
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="profileImage" name="imagen" accept="image/*" required>
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" required>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo $categoria->categoriaID; ?>">
                                <?php echo htmlspecialchars($categoria->nombre); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div id="contenedor-capitulos">
                        <h2>Capítulos</h2>
                        <div class="capitulo" id="capitulo-1">
                            <label for="capitulos[0][titulo]">Título del Capítulo:</label>
                            <input type="text" id="capitulos[0][titulo]" name="capitulos[0][titulo]" required>
                            <label for="capitulos[0][Descripcion]">Descripcion:</label>
                            <textarea id="capitulos[0][Descripcion]" name="capitulos[0][contenido]" required></textarea>
                            <label for="capitulos[0][video]">Video:</label>
                            <input type="file" id="capitulos[0][video]" name="capitulos[0][video]" required>
                            <label for="capitulos[0][precio]">Costo:</label>
                            <input type="number" id="costo" name="capitulos[0][precio]" min="0" required>
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