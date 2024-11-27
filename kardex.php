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

<?php
include('conectarBD.php');
include('modelos/Curso.php');
include('modelos/Categorias.php');

$database = new db();
$conexion = $database->conectarBD();
// Obtener categorías
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
mysqli_free_result($result);
mysqli_next_result($conexion);

// Verifica si el usuario está loggeado 
if (!isset($_SESSION['usuarioLoggeado'])) {
    header("Location: login.php?error=usuario_no_loggeado");
    exit;
}

$usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
$usuarioID = $usuarioLoggeado->usuarioID;
// Obtener los parámetros del formulario 

$fechaInicio = isset($_GET['fecha-inicio']) && $_GET['fecha-inicio'] !== '' ? $_GET['fecha-inicio'] : null;
$fechaFin = isset($_GET['fecha-fin']) && $_GET['fecha-fin'] !== '' ? $_GET['fecha-fin'] : null;
$categoriaID = isset($_GET['categoria']) && $_GET['categoria'] !== '' && $_GET['categoria'] !== 'todas' ? intval($_GET['categoria']) : null;
$estado = isset($_GET['estado']) && $_GET['estado'] !== '' ? $_GET['estado'] : 'todos';
$soloTerminados = $estado === 'terminados' ? TRUE : FALSE;
$soloActivos = $estado === 'activos' ? TRUE : FALSE;

// Llamar al procedimiento almacenado para obtener el kardex 
$sqlObtenerKardex = "CALL ObtenerKardex(?, ?, ?, ?, ?, ?)";
$stmtObtenerKardex = $conexion->prepare($sqlObtenerKardex);
$stmtObtenerKardex->bind_param('issiii', $usuarioID, $fechaInicio, $fechaFin, $categoriaID, $soloTerminados, $soloActivos);
$stmtObtenerKardex->execute();
$resultObtenerKardex = $stmtObtenerKardex->get_result();
$cursos = [];
while ($row = $resultObtenerKardex->fetch_assoc()) {
    $cursos[] = $row;
}
$stmtObtenerKardex->close();
mysqli_close($conexion);
?>

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
                    <a type="button" style="margin: 0px 5px" id="borrarCuenta" href="/controladores/BorrarMiCuenta.php"
                        class="color-btn" onclick="return confirmarBorrado()">Borrar mi cuenta</a>
                    <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") { ?>
                        <a type="button" style="margin: 0px 5px" class="color-btn"
                            href="/api/userInfo.php?usuarioID=<?php echo $usuarioLoggeado->usuarioID ?>"
                            target="_blank">Bajar mi
                            informacion</a>

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
                    <form action="kardex.php#kardex" method="get">
                        <label for="fecha-inicio">Fecha de Inscripción (Inicio):</label>
                        <input type="date" id="fecha-inicio" name="fecha-inicio">

                        <label for="fecha-fin">Fecha de Inscripción (Fin):</label>
                        <input type="date" id="fecha-fin" name="fecha-fin">

                        <label for="categoria">Categoría:</label>
                        <select id="categoria" name="categoria">
                            <option value="todas">Todas</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->categoriaID; ?>">
                                    <?php echo htmlspecialchars($categoria->nombre); ?>
                                </option>
                            <?php endforeach; ?>
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

            <section class="kardex" id="kardex">
                <div class="container">
                    <h2 class="mb-5">Mis Cursos</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Categoría</th>
                                <th>Fecha de Inscripción</th>
                                <th>Última Fecha de Ingreso</th>
                                <th>Progreso</th>
                                <th>Estado</th>
                                <th>Fecha de finalización</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cursos)): ?>
                                <?php foreach ($cursos as $curso): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($curso['NombreCurso']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['Categoria']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['FechaInscripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['UltimaVisitaDeLeccion']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['ProgresoCurso']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['EstadoCurso']); ?></td>
                                        <td><?php echo htmlspecialchars($curso['FechaFinalizacion'] ? $curso['FechaFinalizacion'] : '-'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No se encontraron resultados para los filtros aplicados.</td>
                                </tr>
                            <?php endif; ?>
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