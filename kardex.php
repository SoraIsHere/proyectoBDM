<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
                        <img src="<?php echo $fotoUrl; ?>" alt="Perfil de Juan Pérez">
                    </div>
                    <h2> <?php echo "$usuarioLoggeado->nombre $usuarioLoggeado->apellido"; ?></h2>
                    <p>Fecha de Nacimiento:
                        <?php  // Configurar la localización en español
                        $locale = 'es_ES';
                        $fechaNacimiento = $usuarioLoggeado->fechaNacimiento;
                        $date = new DateTime($fechaNacimiento);

                        // Crear el formateador de fecha
                        $formatter = new IntlDateFormatter(
                            $locale,
                            IntlDateFormatter::LONG,
                            IntlDateFormatter::NONE,
                            'UTC',
                            IntlDateFormatter::GREGORIAN
                        );

                        // Formatear la fecha
                        $fechaFormateada = $formatter->format($date);

                        echo $fechaFormateada; // Salida esperada: 30 de octubre del 2024
                        ?>
                    </p>
                    <p>Género: <?php echo $usuarioLoggeado->genero ?></p>
                    <p>Email: <?php echo $usuarioLoggeado->email ?></p>
                    <a type="button" style="margin: 0px 5px" href="#editarDatos" class="color-btn">Editar datos</a>
                    <a type="button" style="margin: 0px 5px" class="color-btn"
                        href="/api/userInfo?id=<?php echo $usuarioLoggeado->usuarioID ?>" target="_blank">Bajar mi
                        informacion</a>
                    <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") { ?>
                        <a type="button" style="margin: 0px 5px" id="borrarCuenta" href="/controladores/BorrarMiCuenta.php"
                            class="color-btn" onclick="return confirmarBorrado()">Borrar mi cuenta</a>
                    <?php } ?>
                </div>
            </div>
        </section>
        <section class="editar" id="editarDatos">
            <div class="container">
                <h2>Editar</h2>
                <p>Dejar vacío si no lo desea editar</p>
                <form class="login-card-form" method="POST" action="/controladores/EditarUsuario.php"
                    enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    <div class="campos">
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Contraseña" name="password" id="passwordForm"
                                name="password">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Confirmar contraseña" id="confirmPasswordForm"
                                name="confirmPassword">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">image</span>
                            <input type="file" id="profileImage" name="imagen" accept="image/*">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Nombre" id="usernameForm" name="nombre">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Apellidos" id="lastNameForm" name="apellido">
                        </div>
                        <div class="form-item">
                            <label for="genderForm">Género</label>
                            <select name="genero" id="genderForm">
                                <option value="" selected>Elige tu género</option>
                                <option value="M">Hombre</option>
                                <option value="F">Mujer</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <input type="hidden" name="usuarioID" value="<?php echo $usuarioLoggeado->usuarioID; ?>" />
                        <div class="text-center">
                            <button class="color-btn" type="submit">Editar datos</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") { ?>
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
        <?php } ?>
    </main>
</body>

<script>
    function confirmarBorrado() {
        return confirm("¿Estás seguro de que deseas borrar tu cuenta? Esta acción no se puede deshacer.");
    }
    function validarFormulario() {
        const password = document.getElementById('passwordForm').value;
        const confirmPassword = document.getElementById('confirmPasswordForm').value;
        const profileImage = document.getElementById('profileImage').value;
        const nombre = document.getElementById('usernameForm').value;
        const apellido = document.getElementById('lastNameForm').value;
        const genero = document.getElementById('genderForm').value;

        if (!password && !confirmPassword && !profileImage && !nombre && !apellido && !genero) {
            alert("Llene algún campo");
            return false;
        }

        if (password || confirmPassword) {
            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            if (!validatePassword(password)) {
                return false;
            }
        }
        return confirm("¿Está seguro de que desea actualizar la información?");
    }

    function validatePassword(password) {
        const minLength = 8;
        const hasUpperCase = /[A-Z]/.test(password); // Al menos una mayúscula
        const hasNumber = /\d/.test(password); // Al menos un número
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Al menos un carácter especial

        if (password.length < minLength) {
            alert("La contraseña debe tener al menos 8 caracteres.");
            return false;
        }
        if (!hasUpperCase) {
            alert("La contraseña debe tener al menos una letra mayúscula.");
            return false;
        }
        if (!hasNumber) {
            alert("La contraseña debe tener al menos un número.");
            return false;
        }
        if (!hasSpecialChar) {
            alert("La contraseña debe tener al menos un carácter especial.");
            return false;
        }
        return true;
    }
</script>
<?php include("footer.php") ?>

</html>