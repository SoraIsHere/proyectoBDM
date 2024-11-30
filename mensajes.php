<?php include 'middleware.php'; ?>
<?php chatMiddleware(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chat.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php include("header.php") ?>
<?php
include('conectarBD.php');
// Verificar si el usuario está loggeado
if (!isset($_SESSION['usuarioLoggeado'])) {
    header("Location: iniciosesion.php");
    exit();
}

$usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
$usuarioActualID = $usuarioLoggeado->usuarioID;
$tipoUsuario = $usuarioLoggeado->tipoUsuario;

$database = new db();
$conexion = $database->conectarBD();

if ($tipoUsuario === 'Instructor') {
    $sql = "CALL ObtenerUsuariosConMensajes(?)";
} else {
    $sql = "CALL ObtenerInstructoresDeAlumno(?)";
}

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $usuarioActualID);
$stmt->execute();
$result = $stmt->get_result();
$usuarios = array();
while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}
$stmt->close();
mysqli_close($conexion);
?>
<style>
    .mensaje {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }

    .mensaje img.foto-mensaje {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }

    .mensaje.actual {
        justify-content: flex-end;
    }

    .mensaje.receptor {
        justify-content: flex-start;
    }

    .texto-mensaje {
        max-width: 70%;
        padding: 10px;
        border-radius: 8px;
        background-color: #f1f1f1;
        display: inline-block;
        background: black;
    }

    .fechaMensaje {
        font-size: 10px;
    }
</style>

<body>
    <main style="padding: 100px 0 30px">
        <section class="chat">
            <div class="container">
                <div class="contenedor-chat">
                    <div class="barra-lateral">
                        <ul class="lista-usuarios">
                            <?php foreach ($usuarios as $usuario): ?>
                                <li class="usuario" data-id="<?php echo $usuario['UsuarioID'] ?>"
                                    data-name="<?php echo htmlspecialchars($usuario['Nombre'] . ' ' . $usuario['Apellido']); ?>">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($usuario['Foto']); ?>"
                                        alt="Foto de <?php echo htmlspecialchars($usuario['Nombre'] . ' ' . $usuario['Apellido']); ?>"
                                        class="foto-usuario px-2" width="50" height="30"
                                        style="border-radius: 100px; aspect-ratio: 1;">
                                    <?php echo htmlspecialchars($usuario['Nombre'] . ' ' . $usuario['Apellido']); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="ventana-chat">
                        <div class="mensajes" data-user="" data-name="">
                            <!-- Mensajes de chat se mostrarán aquí -->
                        </div>
                        <input type="text" name="mensaje" user-id="<?php echo $usuarioActualID; ?>"
                            placeholder="Escribe un mensaje..." class="entrada-mensaje">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .mensajes {
            height: 200px;
        }
    </style>
    <script>
        function cargarMensajes(receptorID) {
            $.ajax({
                url: 'controladores/obtenermensajes.php',
                type: 'POST',
                data: {
                    receptorID: receptorID
                },
                success: function (response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            // Obtener las imágenes
                            var fotoActual = $("#navbar-foto-usuario").attr("src"); // Imagen del usuario actual
                            var fotoOtro = $(".usuario.selected img").attr("src"); // Imagen del receptor seleccionado

                            // Construir mensajes
                            var usuarioActualID = document.querySelector(".entrada-mensaje").getAttribute("user-id");
                            var nombreOtro = document.querySelector(".mensajes").getAttribute("data-name");
                            var mensajesHTML = '';

                            jsonResponse.mensajes.forEach(function (mensaje) {
                                console.log(mensaje)
                                var esActual = mensaje.EmisorID == usuarioActualID; // Verifica si el mensaje es del usuario actual
                                var emisor = esActual ? 'Tú' : nombreOtro;
                                var fotoEmisor = esActual ? fotoActual : fotoOtro;

                                mensajesHTML += `
                            <div class="mensaje ${esActual ? 'actual' : 'receptor'}">
                                <img src="${fotoEmisor}" alt="${emisor}" class="foto-mensaje">
                                <div class="texto-mensaje">
                                    <strong>${emisor}:</strong> ${mensaje.Texto}
                                    <p class="fechaMensaje m-0">${mensaje.FechaEnvio}</p>
                                </div>
                            </div>`;
                            });

                            // Insertar mensajes en la ventana
                            document.querySelector(".mensajes").innerHTML = mensajesHTML;
                            document.querySelector(".mensajes").scrollTop = document.querySelector(".mensajes").scrollHeight;
                        } else {
                            console.log("Error al obtener los mensajes: " + jsonResponse.message);
                        }
                    } catch (e) {
                        console.log("Error al parsear la respuesta JSON: ", e);
                    }
                },
                error: function () {
                    console.log('Error al obtener los mensajes');
                }
            });
        }

        $(document).ready(function () {
            function iniciarActualizacionMensajes() {
                var receptorID = document.querySelector(".mensajes").getAttribute("data-user");
                if (receptorID) {
                    cargarMensajes(receptorID);
                }
            }

            $(".entrada-mensaje").keypress(function (event) {
                if (event.which == 13) {
                    event.preventDefault();
                    var mensaje = $(this).val();
                    var receptorID = document.querySelector(".mensajes").getAttribute("data-user");

                    if (receptorID) {
                        $.ajax({
                            url: 'controladores/enviarmensaje.php',
                            type: 'POST',
                            data: {
                                texto: mensaje,
                                receptorID: receptorID
                            },
                            success: function (response) {
                                console.log(response);
                                var jsonResponse = JSON.parse(response);
                                if (jsonResponse.status == 'success') {
                                    console.log("Mensaje enviado correctamente");
                                    cargarMensajes(receptorID); // Recargar mensajes
                                    document.querySelector(".mensajes").scrollTop = document.querySelector(".mensajes").scrollHeight;
                                } else {
                                    console.log("Error al enviar el mensaje: " + jsonResponse.message);
                                }
                            },
                            error: function () {
                                console.log('Error al enviar el mensaje');
                            }
                        });
                        $(this).val("");
                    } else {
                        alert("Selecciona un usuario para enviar el mensaje");
                    }
                }
            });

            $(".usuario").click(function () {
                $(".usuario").removeClass("selected");
                $(this).addClass("selected");
                var usuarioID = $(this).data("id");
                var nombreUsuario = $(this).data("name");
                document.querySelector(".mensajes").setAttribute("data-user", usuarioID);
                document.querySelector(".mensajes").setAttribute("data-name", nombreUsuario);
                cargarMensajes(usuarioID); // Cargar mensajes al seleccionar un usuario
                document.querySelector(".mensajes").scrollTop = document.querySelector(".mensajes").scrollHeight;
            });

            setInterval(iniciarActualizacionMensajes, 2000); // Llamar a cargarMensajes cada 2 segundos
        });
    </script>

</body>

<?php include("footer.php") ?>

</html>