<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<?php include("header.php") ?>

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
                    <button class="color-btn mt-4" type="submit" >Generar Reporte</button>
                </form>
            </div>
        </section>

        <section class="resultados">
            <div class="container">
                <h2>Resultados del Reporte</h2>
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
        </section>
    </main>

</body>

<?php include("footer.php") ?>

</html>