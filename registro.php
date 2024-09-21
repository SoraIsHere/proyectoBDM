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
                <form id="registerForm" class ="login-card-form">

                    <div class="campos">
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Nombre" id="nameForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Apellido paterno" id="lastNameForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input type="text" placeholder="Apellido materno" id="middleNameForm" required>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">mail</span>
                            <input type="text" placeholder="Email" id="emailForm" required>
                        </div>
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
                            <label for="roleForm">Selecciona el rol con el que quieras interactuar</label>
                            <select id="roleForm" required>
                                <option value="student">Estudiante</option>
                                <option value="teacher">Profesor</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="genderForm">Género</label>
                            <select id="genderForm" required>
                                <option value="male">Hombre</option>
                                <option value="female">Mujer</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        <div class="form-item">
                            <span class="form-item-icon material-symbols-rounded">calendar_today</span>
                            <input type="date" id="dobForm" required>
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