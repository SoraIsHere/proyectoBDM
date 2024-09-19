<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chat.css">
</head>

<?php include("header.php") ?>

<body>
    <main style="padding: 100px 0 30px">
        <section class="chat">
            <div class="container">
                <div class="contenedor-chat ">
                    <div class="barra-lateral">
                        <input type="text" placeholder="Buscar usuarios..." class="barra-busqueda">
                        <ul class="lista-usuarios">
                            <li class="usuario">Usuario 1</li>
                            <li class="usuario">Usuario 2</li>
                        </ul>
                    </div>
                    <div class="ventana-chat">
                        <div class="mensajes">
                            <div class="mensaje">Usuario 1: Hola, ¿cómo estás?</div>
                            <div class="mensaje">Usuario 2: ¡Bien, gracias! ¿Y tú?</div>
                        </div>
                        <input type="text" placeholder="Escribe un mensaje..." class="entrada-mensaje">
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

<?php include("footer.php") ?>

</html>