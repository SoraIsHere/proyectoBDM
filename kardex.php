<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex - Perfil del Alumno</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/kardex.css">

    <?php include("header.php") ?>
</head>



<body>

    <main>
        <section class="datos-usuario">
            <div class="container">
                <div class="perfil">
                    <div class="img-perfil">
                        <img src="media/curso1.jpg" alt="Perfil de Juan Pérez">
                    </div>
                    <h2>Nombre: Juan Pérez</h2>
                    <p>Fecha de Nacimiento: 15 de marzo de 1990</p>
                    <p>Género: Masculino</p>
                    <p>Email: juan.perez@example.com</p>
                    <a type="button" href="#editarDatos" class="color-btn">Editar datos</a>
                </div>
            </div>
        </section>
        <section class="editar" id="editarDatos">
            <div class="container">
                <form class="login-card-form">
                    <div class="campos">
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Contraseña" id="passwordForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Confirmar contraseña" id="confirmPasswordForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">image</span>
                            <input type="file" id="profileImage" accept="image/*">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Nombre de usuario" id="usernameForm" required>
                        </div>
                        <div class="form-item">
                            <label for="genderForm">Género</label>
                            <select id="genderForm" required>
                                <option value="male">Hombre</option>
                                <option value="female">Mujer</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button class="color-btn" type="submit">Editar datos</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>


        <section class="filtros">
            <div class="container">
                <h2>Filtros</h2>
                <form action="#">
                    <label for="fecha-inicio">Fecha de Inscripción (Inicio):</label>
                    <input type="date" id="fecha-inicio" name="fecha-inicio">

                    <label for="fecha-fin">Fecha de Inscripción (Fin):</label>
                    <input type="date" id="fecha-fin" name="fecha-fin">

                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria">
                        <option value="todas">Todas</option>
                        <option value="it-software">IT & Software</option>
                        <option value="marketing">Marketing</option>
                        <option value="design">Design</option>
                    </select>

                    <label for="estado">Estado del Curso:</label>
                    <select id="estado" name="estado">
                        <option value="todos">Todos</option>
                        <option value="terminados">Solo Terminados</option>
                        <option value="activos">Solo Activos</option>
                    </select>

                    <button type="submit" class="color-btn">Aplicar Filtros</button>
                </form>
            </div>
        </section>

        <section class="kardex">
            <div class="container">
                <h2>Mis Cursos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Categoría</th>
                            <th>Fecha de Inscripción</th>
                            <th>Última Fecha de Ingreso</th>
                            <th>Progreso</th>
                            <th>Estado</th>
                            <th>Fecha de finalizacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Curso de Programación</td>
                            <td>IT & Software</td>
                            <td>01/08/2024</td>
                            <td>15/08/2024</td>
                            <td>50%</td>
                            <td>En Progreso</td>
                            <td> - </td>
                        </tr>
                        <tr>
                            <td>Marketing Digital</td>
                            <td>Marketing</td>
                            <td>10/07/2024</td>
                            <td>22/07/2024</td>
                            <td>100%</td>
                            <td>Completado</td>
                            <td>22/07/2024</td>
                        </tr>
                        <!-- Agrega más cursos según sea necesario -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

<?php include("footer.php") ?>

</html>