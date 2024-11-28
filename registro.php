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
                <form id="registerForm" class="login-card-form" method="POST" enctype="multipart/form-data" action="./controladores/RegistroUsuarios.php" >
                    <div class="campos">
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" name="nombre" placeholder="Nombre" id="nombre">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Apellidos" name="apellido" id="apellido">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">mail</span>
                            <input type="text" placeholder="Email" name="email" id="email">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input type="password" placeholder="Confirmar contraseña" name="contrasenaconfirm" id="contrasenaconfirm">
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">image</span>
                            <input type="file" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="form-item">
                            <label for="roleForm">Selecciona el rol con el que quieras interactuar</label>
                            <select id="rol" name="rol">
                                <option value="Estudiante">Estudiante</option>
                                <option value="Instructor">Profesor</option>
                                <!-- <option value="Administrador">Administrador</option> -->
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="genderForm">Género</label>
                            <select id="genero" name="genero">
                                <option value="M">Hombre</option>
                                <option value="F">Mujer</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">calendar_today</span>
                            <input name="fechaNacimiento" type="date" id="fechaNacimiento">
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="color-btn" type="submit">Registrarse</button>
                    </div>
                </form>
                <div class="login-card-footer text-center">
                    Ya tienes una cuenta? <a href="inisesion.php">Regístrate</a>
                </div>
            </div>
        </div>
    </main>
    <!--script src="validaciones.js"></script-->
    <script>
        document.getElementById("registerForm").onsubmit = function() {
            var nombre = document.getElementById("nombre").value.trim();
            var apellido = document.getElementById("apellido").value.trim();
            var email = document.getElementById("email").value.trim();
            var pass = document.getElementById("contrasena").value.trim();
            var confirmPass = document.getElementById("contrasenaconfirm").value.trim();
            var fechaNacimiento = new Date(document.getElementById("fechaNacimiento").value);
            var genero = document.getElementById("genero").value;
            var rol = document.getElementById("rol").value;
            var imgRuta = document.getElementById("imagen").value;

            var fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);

            var nombrePattern = /^[A-Za-z\u00C0-\u017F\s]+$/;
            var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (nombre === "" || !nombrePattern.test(nombre)) {
                alert("El nombre no puede estar vacío y solo puede tener letras.");
                return false;
            } 
            if (apellido === "" || !nombrePattern.test(apellido)) {
                alert("El apellido no puede estar vacío y solo puede tener letras.");
                return false;
            }
            if (email === "" || !emailPattern.test(email)) {
                alert("Introduce un correo electrónico válido.");
                return false;
            }
            if (pass === "" || !passwordPattern.test(pass)) {
                alert("La contraseña debe tener al menos 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial.");
                return false;
            }
            if (pass !== confirmPass) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            if (isNaN(fechaNacimiento.getTime()) || fechaNacimiento >= fechaActual) {
                alert("La fecha de nacimiento no puede ser vacía o posterior a hoy.");
                return false;
            }
            if (genero === "") {
                alert("Debes seleccionar un género.");
                return false;
            }
            if (rol === "") {
                alert("Debes seleccionar un rol.");
                return false;
            }
            if (imgRuta === "") {
                alert("Debes subir una imagen de perfil.");
                return false;
            }

            return true;
        }
    </script>

</body>

<?php include("footer.php") ?>

</html>