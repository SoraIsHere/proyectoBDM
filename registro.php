<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/registro.css" />
    <title>register Page</title>

    <?php include("header.php") ?>
</head>

<body>
    <main>
        <div class="login-card-container">
            <div class="login-card" style="margin: 100px 0!important;">
                <div class="login-card-logo text-center">
                    <img src="media/logo.png" alt="logo">
                </div>
                <div class="login-card-header text-center">
                    <h1>Regístrate</h1>
                    <div>llena los formularios para unirte y disfrutar de nuestros cursos o compartir tu conocimiento si eres maestro.
                    </div>
                </div>
                <form id="registerForm" class="login-card-form" method="POST" enctype="multipart/form-data" action="/controladores/RegistroUsuarios.php" >
                    <div class="campos">
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" name="nombre" placeholder="Nombre" id="nameForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Apellidos" name="apellido" id="lastNameForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">mail</span>
                            <input type="text" placeholder="Email" name="email" id="emailForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Contraseña" name="contrasena" id="passwordForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Confirmar contraseña" id="confirmPasswordForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">image</span>
                            <input type="file" id="profileImage" name="imagen" accept="image/*">
                        </div>
                        <div class="form-item">
                            <label for="roleForm">Selecciona el rol con el que quieras interactuar</label>
                            <select id="roleForm" name="rol" required>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Instructor">Profesor</option>
                                <!-- <option value="Administrador">Administrador</option> -->
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="genderForm">Género</label>
                            <select id="genderForm" name="genero" required>
                                <option value="M">Hombre</option>
                                <option value="F">Mujer</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">calendar_today</span>
                            <input name="fechaNacimiento" type="date" id="dobForm" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="color-btn" type="submit">Registrarse</button>
                    </div>
                </form>
                <div class="login-card-footer text-center">
                    Ya tienes una cuenta? <a href="inisesion.html">Regístrate</a>
                </div>
            </div>
        </div>
    </main>
    <script src="validaciones.js"></script>
</body>

<?php include("footer.php") ?>

</html>