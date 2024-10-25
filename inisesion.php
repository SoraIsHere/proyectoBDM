<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/signin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,600,0,0" />
    <title>Login Page</title>

    <?php include("header.php") ?>
</head>

<body>
    <main>
        <div class="login-card-container">
            <div class="login-card">
                <div class="login-card-logo">
                    <img class="logo" src="media/logo.png" alt="logo">
                </div>
                <div class="login-card-header">
                    <h1>Iniciar Sesión</h1>
                    <div>Inicie sesión para poder obtener acceso completo a nuestros cursos</div>
                </div>
                <form class="login-card-form" method="POST" action="/controladores/Login.php" >
                    <div class="form-item">
                        <span class="form-item-icon material-symbols-rounded">mail</span>
                        <input type="text" name="email" placeholder="Enter Email" id="emailForm"
                            autofocus required>
                    </div>
                    <div class="form-item">
                        <span class="form-item-icon material-symbols-rounded">lock</span>
                        <input type="password" name="contraseña" placeholder="Enter Password" id="passwordForm"
                            required>
                    </div>
                    <button type="submit" class="color-btn">Sign In</button>
                </form>
                <div class="login-card-footer">
                    No tienes una cuenta? <a href="/registro.php">Crea una cuenta!.</a>
                </div>
            </div>

        </div>
    </main>

</body>

<?php include("footer.php") ?>

</html>