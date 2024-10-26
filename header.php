<?php
session_start();
include 'modelos/Usuarios.php';

$usuarioLoggeado = false;
if (isset($_SESSION['usuarioLoggeado'])) {
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    // Convertir el BLOB de la imagen a base64
    $fotoBase64 = base64_encode($usuarioLoggeado->foto);
    // Obtener el tipo MIME de la imagen (asumiendo que es png en este ejemplo)
    $mimeType = 'image/png';
    // Crear la URL de datos base64
    $fotoUrl = 'data:' . $mimeType . ';base64,' . $fotoBase64;
}
?>



<!--BOOTSTRAP-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!--**-->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,600,0,0" />
<link rel="icon" type="image/x-icon" href="media/logo.png">
<link rel="stylesheet" href="css/style.css">
<nav class="nav-menu">
    <div class="nav-container">
        <a href="/" class="logo-container" style="margin: 0; display: flex">
            <img src="media/logo.png" alt="Logo de WebLearning" class="logo-footer"
                style="height: 70px; width:70px; aspect-ratio: 1; margin: 0px;">
        </a>
        <ul class="nav-links">
            <li><a href="/">Inicio</a></li>
        </ul>
        <div class="nav-buttons">
            <?php if ($usuarioLoggeado == null) { ?>
                <a href="inisesion.php" class="color-btn">Iniciar Sesión</a>
                <a href="registro.php" class="transparent-btn">Registrarse</a>
            <?php } else {
                echo ($usuarioLoggeado->nombre);
            } ?>
            <div class="icon-menu">
                <?php if ($usuarioLoggeado) {
                    echo '<img src="' . $fotoUrl . '" alt="Foto del Usuario" class="logo-footer" style="height: 50px; width:50px; aspect-ratio: 1; margin: 0px;object-fit:cover">';
                    ?>
                    <div class="menu-flotante">
                        <a href="/kardex.php">
                            Perfil
                        </a>
                        <?php if ($usuarioLoggeado->tipoUsuario == "Administrador") { ?>
                            <a href="/reportes.php">
                                Reportes
                            </a>
                        <?php } ?>

                        <?php if ($usuarioLoggeado->tipoUsuario == "Instructor") { ?>
                            <a href="/ventas.php">
                                Ventas
                            </a>
                        <?php } ?>

                        <?php ?>
                        <a href="/mensajes.php">
                            Mensajes
                        </a>
                        <a href="/controladores/logout.php">
                            Cerrar Sesion
                        </a>
                    </div>
                    <?php
                } ?>
            </div>

        </div>
    </div>
</nav>