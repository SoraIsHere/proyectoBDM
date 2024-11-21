<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
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
mysqli_close($conexion);

?>

<body>
    <main style="margin: 100px 0 30px">

        <section class="filtros-reporte">
            <div class="container">
                <h1>Reporte de Usuarios</h1>
                <form action="#" method="GET">
                    <label for="tipo-usuario">Tipo de Usuario:</label>
                    <select id="tipo-usuario" name="tipo-usuario">
                        <option value="instructor">Instructor</option>
                        <option value="estudiante">Estudiante</option>
                    </select>
                    <button class="color-btn mt-4" type="submit">Generar Reporte</button>
                </form>
            </div>
        </section>

        <section class="resultados" id="instructores">
            <div class="container">
                <h2>Resultados del Reporte de Instructor</h2>
                <table id="tabla-usuarios">
                    <!-- Ejemplo de tabla para instructores -->
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Cursos Ofrecidos</th>
                            <th>Total de Ganancias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>jperez</td>
                            <td>Juan Pérez</td>
                            <td>15 Jul 2022</td>
                            <td>5</td>
                            <td>$12,345.67</td>
                        </tr>
                        <tr>
                            <td>mlopez</td>
                            <td>María López</td>
                            <td>10 Ago 2023</td>
                            <td>3</td>
                            <td>$8,765.43</td>
                        </tr>
                        <!-- Agrega más filas según los resultados obtenidos -->
                    </tbody>
                    <!-- Ejemplo de tabla para estudiantes -->
                    <!-- Cambia el contenido de la tabla según el tipo de usuario seleccionado -->
                </table>
            </div>

            <div class="container mt-4" id="alumnos">
                <h2>Resultados del Reporte de Alumnos</h2>
                <table id="tabla-usuarios">
                    <!-- Ejemplo de tabla para instructores -->
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Cursos Inscrutos</th>
                            <th>Cursos terminados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>jperez</td>
                            <td>Juan Pérez</td>
                            <td>15 Jul 2022</td>
                            <td>5</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>mlopez</td>
                            <td>María López</td>
                            <td>10 Ago 2023</td>
                            <td>3</td>
                            <td>0</td>
                        </tr>
                        <!-- Agrega más filas según los resultados obtenidos -->
                    </tbody>
                    <!-- Ejemplo de tabla para estudiantes -->
                    <!-- Cambia el contenido de la tabla según el tipo de usuario seleccionado -->
                </table>
            </div>
        </section>

        <section class="categorias my-4">
            <div class="container d-block">
                <h1>Categorias</h1>
                <!-- Botón para abrir el modal -->
                <button type="button" class="color-btn mt-2 mb-2" data-bs-toggle="modal"
                    data-bs-target="#crearCategoriaModal">
                    Crear Categoría
                </button>

                <!-- Modal -->
                <div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark">
                            <div class="modal-header">
                                <h5 class="modal-title" id="crearCategoriaLabel">Crear Categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formCrearCategoria" method="post" action="controladores/CrearCategoria.php">
                                    <div class="mb-3">
                                        <label for="nombreCategoria" class="form-label">Nombre</label>
                                        <input type="text" class="form-control px-3" id="nombreCategoria" name="nombre"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcionCategoria" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcionCategoria" name="descripcion"
                                            rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="color-btn">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <ul class="categorias list-group mb-2">
                        <?php foreach ($categorias as $categoria): ?>
                            <li id="cat-<?php echo $categoria->categoriaID; ?>"
                                class="mb-2 categoria list-group-item bg-transparent text-white d-flex border-1 border-white">
                                <div class="text-wrapper flex-grow-1">
                                    <h3> <?php echo htmlspecialchars($categoria->nombre); ?></h3>
                                    <p class="m-0"> <?php echo htmlspecialchars($categoria->descripcion); ?></p>
                                </div>
                                <div class="boton align-items-center d-flex">
                                    <button data-id="<?php echo $categoria->categoriaID; ?>" class="color-btn  mx-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editarCategoriaModal-<?php echo $categoria->categoriaID; ?>">Editar</button>
                                    <a onclick="return confirmarBorrado()"
                                        href="controladores/borrarCategoria.php?id=<?php echo $categoria->categoriaID; ?>"
                                        class="color-btn">Borrar
                                    </a>
                                </div>
                            </li>

                            <div class="modal fade" id="editarCategoriaModal-<?php echo $categoria->categoriaID; ?>"
                                tabindex="-1" aria-labelledby="editarCategoriaModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-dark">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarCategoriaLabel">Editar Categoría</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formEditarCategoria" method="post"
                                                action="controladores/EditarCategoria.php?">
                                                <input type="hidden" name="categoriaID"
                                                    value="<?php echo $categoria->categoriaID; ?>">
                                                <div class="mb-3">
                                                    <label for="nombreCategoria" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control px-3" id="nombreCategoria"
                                                        name="nombre" required value="<?php echo $categoria->nombre; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcionCategoria" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcionCategoria"
                                                        name="descripcion" rows="3"
                                                        required><?php echo $categoria->descripcion; ?></textarea>
                                                </div>
                                                <button type="submit" class="color-btn">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>
    </main>

</body>

<script>

    function confirmarBorrado() {
        return confirm("¿Estás seguro de que deseas borrar esta categoria?");
    }
    window.onload = function () {
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(window.location.search);
        if (params.get('catCreada') === 'true') {
            alert('Categoria creada con éxito');
        }
        if (params.get('catBorrada') === 'true') {
            alert('Categoria Eliminada');
        }
        if (params.get('catEditada') === 'true') {
            alert('Categoria Editada');
        }
    }
</script>
<?php include("footer.php") ?>

</html>