<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Perfil del Instructor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>

<body>
    <main style="margin: 100px 0 30px">
        <section class="filtros">
            <div class="container">
                <h1>Mis Ventas de Cursos</h1>
                <a href="/crearCurso.php" class="color-btn" style="text-align:center; width:fit-content">Nuevo Curso</a>
                <h2>Filtros</h2>
                <form action="#">
                    <label for="fecha-inicio">Fecha de Creación (Inicio):</label>
                    <input type="date" id="fecha-inicio" name="fecha-inicio">

                    <label for="fecha-fin">Fecha de Creación (Fin):</label>
                    <input type="date" id="fecha-fin" name="fecha-fin">

                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="todas">Todas</option>
                        <option value="it-software">IT & Software</option>
                        <option value="marketing">Marketing</option>
                        <option value="design">Design</option>
                        <!-- Agrega más categorías según sea necesario -->
                    </select>

                    <label for="estado">Estado del Curso:</label>
                    <select id="estado" name="estado">
                        <option value="todos">Todos</option>
                        <option value="activos">Solo Activos</option>
                    </select>

                    <button type="submit" class="color-btn" style="margin-top:20px">Aplicar Filtros</button>
                </form>
            </div>
        </section>

        <section class="resumen-ventas">
            <div class="container">
                <h2>Resumen de Ventas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Alumnos Inscritos</th>
                            <th>Nivel Promedio</th>
                            <th>Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Curso de Programación</td>
                            <td>150</td>
                            <td>75%</td>
                            <td>$3,000.00</td>
                        </tr>
                        <tr>
                            <td>Marketing Digital</td>
                            <td>200</td>
                            <td>60%</td>
                            <td>$5,000.00</td>
                        </tr>
                        <!-- Agrega más cursos según sea necesario -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total de Ingresos</th>
                            <th>$8,000.00</th>
                        </tr>
                        <tr>
                            <th colspan="3">Desglose por Forma de Pago</th>
                            <th>Tarjeta: $6,000.00 | PayPal: $2,000.00</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <section class="detalle-curso">
            <div class="container">

                <h2>Detalle de Curso: Curso de Programación</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre del Alumno</th>
                            <th>Fecha de Inscripción</th>
                            <th>Nivel de Avance</th>
                            <th>Precio Pagado</th>
                            <th>Forma de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Juan Pérez</td>
                            <td>01 Ago 2024</td>
                            <td>50%</td>
                            <td>$20.00</td>
                            <td>Tarjeta</td>
                        </tr>
                        <tr>
                            <td>María López</td>
                            <td>03 Ago 2024</td>
                            <td>80%</td>
                            <td>$25.00</td>
                            <td>PayPal</td>
                        </tr>
                        <!-- Agrega más alumnos según sea necesario -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total de Ingresos</th>
                            <th>$45.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </main>


    <?php include("footer.php") ?>
</body>

</html>