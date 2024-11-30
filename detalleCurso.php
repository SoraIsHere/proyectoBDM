<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de curso</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/curso.css">
</head>

<?php include("header.php") ?>

<?php
include('conectarBD.php');
$database = new db();
$conexion = $database->conectarBD();

include("controladores/ObtenerCurso.php"); ?>


<!-- Initialize the JS-SDK -->
<script
    src="https://www.paypal.com/sdk/js?client-id=ASSKtoTPhEkdDT5eQLUGlYmZkiOE0oN2_tAXMqIvRnzGx3GMtW-fIoW7oW-UiENI_RkzLX-GCpH4bUDo&currency=MXN&disable-funding=paylater"
    data-sdk-integration-source="developer-studio"></script>


<body>
    <main>
        <header class="curso-hero">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($curso->imagen); ?>"
                alt="<?php echo htmlspecialchars($curso->nombre); ?>"
                style="max-height: 400px; width: 600px; object-fit: cover; object-position: top;">
            <div class="hero-content">
                <h1 class="mt-4">
                    <?php echo $curso->nombre ?>
                </h1>
                <p> <?php echo $curso->descripcion ?></p>
                <h2 class="mb-4"> $<?php echo $curso->costoGeneral ?></h2>
                <p class="fw-bold text-white">Calificación <?php echo $curso->calificacion ?>/5</p>
                <a href="#detalle-curso" class="color-btn">Mas detalles</a>
                <div class="mt-3">
                    <a href="/busquedas.php?cat=<?php echo $curso->categoriaID; ?>"
                        class=""><?php echo $curso->categoriaNombre; ?></a>
                </div>
            </div>
        </header>
        <section class="detalle-curso" id="detalle-curso">
            <div class="container">
                <h2>Informacion</h2>
                <div class="texto">

                    <table>
                        <thead>
                            <tr>
                                <th>Tema</th>
                                <th>Estado</th>
                                <th>Comprado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lecciones as $leccion): ?>
                                <?php
                                $leccionComprada = false;
                                $leccionCompletada = false;
                                foreach ($leccionesUsuario as $leccionU) {
                                    if ($leccionU['LeccionID'] == $leccion->leccionID) {
                                        $leccionComprada = true;
                                        if ($leccionU['Leido']) {
                                            $leccionCompletada = true;
                                        }
                                        break;
                                    }
                                }
                                ?>
                                <tr>
                                    <td style="width: 33%;"><a>
                                            <?php echo $leccion->nombre ?></a></td>
                                    <td style="width: 33%;">
                                        <?php if ($usuarioLoggeado) { ?>
                                            <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") {
                                                if ($leccionCompletada) {
                                                    echo ("✔️");
                                                } else {
                                                    echo ("❌");
                                                }
                                            }
                                        } ?>
                                    </td>
                                    <td style="width: 33%;">
                                        <?php if ($usuarioLoggeado) { ?>

                                            <?php if (!$leccionComprada) {
                                                ?>
                                                <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") { ?> <a href="#"
                                                        class="transparent-btn" data-bs-toggle="modal"
                                                        data-bs-target="#purchaseModal-<?php echo $leccion->leccionID ?>">Comprar
                                                        <?php echo $leccion->costo ?>$</a>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="purchaseModal-<?php echo $leccion->leccionID ?>"
                                                        tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="purchaseModalLabel">Comprar Curso</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="purchaseForm" method="post"
                                                                        action="/controladores/cursoUsuario.php"
                                                                        id="cursoForm-<?php echo $leccion->leccionID ?>">
                                                                        <div class="mb-3">
                                                                            <label for="paymentMethod" class="form-label">Método de
                                                                                Pago</label>
                                                                            <select class="form-select d-none" name="paymentMethod"
                                                                                id="paymentMethod" required>
                                                                                <option value="paypal" selected>PayPal</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <input type="hidden" name="purchaseDetails"
                                                                                class="form-control"
                                                                                id="purchaseDetails-<?php echo $leccion->leccionID ?>"
                                                                                placeholder="Ej. Número de tarjeta, correo de PayPal"
                                                                                required>
                                                                            <input type="hidden" name="leccionID"
                                                                                value="<?php echo $leccion->leccionID ?>">
                                                                            <input type="hidden" name="cursoID"
                                                                                value="<?php echo $leccion->cursoID ?>">
                                                                            <input type="hidden" name="completo" value="false">
                                                                            <input type="hidden" name="userID"
                                                                                value="<?php echo $usuarioID = $usuarioLoggeado->usuarioID; ?>">
                                                                        </div>
                                                                        <button type="submit" class="btn color-btn d-none">
                                                                            Comprar $<?php echo $leccion->costo ?>
                                                                        </button>
                                                                        <div
                                                                            id="paypal-button-container-<?php echo $leccion->leccionID ?>">
                                                                        </div>
                                                                        <p id="result-message"></p>
                                                                        <script>
                                                                            paypal.Buttons({
                                                                                style: {
                                                                                    color: 'blue',
                                                                                    shape: 'pill'
                                                                                },
                                                                                createOrder: function (data, actions) {
                                                                                    return actions.order.create({
                                                                                        purchase_units: [{
                                                                                            amount: {
                                                                                                value: <?php echo $leccion->costo ?>
                                                                                            }
                                                                                        }]
                                                                                    });
                                                                                },
                                                                                onApprove: function (data, actions) {
                                                                                    actions.order.capture().then(function (detalles) {
                                                                                        alert('Compra completada');
                                                                                        document.querySelector("#purchaseDetails-<?php echo $leccion->leccionID ?>").value = detalles.id;
                                                                                        document.getElementById('cursoForm-<?php echo $leccion->leccionID ?>').submit();
                                                                                    });
                                                                                },
                                                                                onCancel: function (data) {
                                                                                    alert("Pago cancelado");
                                                                                    console.log(data);
                                                                                }
                                                                            }).render('#paypal-button-container-<?php echo $leccion->leccionID ?>');
                                                                        </script>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } else { ?>
                                                <a href="/curso.php?id=<?php echo $leccion->cursoID ?>&nivel=<?php echo $leccion->leccionID ?>"
                                                    class="transparent-btn">Ver Leccion</a>
                                            <?php } ?>

                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <div style="width: 100%; text-align:center">
                        <?php if ($usuarioLoggeado) { ?>

                            <?php if ($usuarioLoggeado->tipoUsuario == "Estudiante") { ?>
                                <?php
                                if (!$cursoComprado) {
                                    ?>
                                    <a type="button" href="#" class="mt-4 transparent-btn" style="display:block"
                                        data-bs-toggle="modal" data-bs-target="#purchaseModal-full">Comprar todo el curso
                                        <?php echo $curso->costoGeneral ?>$</a>
                                    <?php
                                }
                                ?>
                                <!-- Modal -->
                                <div class="modal fade" id="purchaseModal-full" tabindex="-1"
                                    aria-labelledby="purchaseModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="purchaseModalLabel">Comprar Curso</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="cursoForm" class="purchaseForm" method="post"
                                                    action="/controladores/cursoUsuario.php">
                                                    <div class="mb-3">
                                                        <label for="paymentMethod" class="form-label">Método de
                                                            Pago</label>
                                                        <select class="form-select d-none" name="paymentMethod"
                                                            id="paymentMethod" required>
                                                            <option selected value="tarjeta">Tarjeta</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 ">
                                                        <input type="hidden" name="purchaseDetails" class="form-control"
                                                            id="purchaseDetails"
                                                            placeholder="Ej. Número de tarjeta, correo de PayPal" required>
                                                        <input type="hidden" name="cursoID" value="<?php echo $cursoID ?>">
                                                        <input type="hidden" name="completo" value="true">
                                                        <input type="hidden" name="userID"
                                                            value="<?php echo $usuarioID = $usuarioLoggeado->usuarioID; ?>">

                                                    </div>
                                                    <button type="submit" class="btn color-btn d-none">Comprar
                                                        $<?php echo $curso->costoGeneral ?>
                                                    </button>

                                                    <div id="paypal-button-container"></div>
                                                    <p id="result-message"></p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($cursoTerminado) { ?>
                                    <a type="button" href="/diploma.php?cursoId=<?php echo $cursoID ?>"
                                        data-curso="<?php $cursoID ?>" class="mt-4 color-btn" style="display:block">Curso
                                        completado!</a>
                                <?php } ?>
                            <?php }
                        } ?>
                    </div>
                </div>

                <div class="texto mt-5" id="comentarios">

                    <?php include("controladores/ObtenerComentarios.php"); ?>
                    <h2 class="mb-4">Comentarios</h2>
                    <?php if ($usuarioLoggeado) {
                        $comentado = false;
                        foreach ($comentarios as $item):
                            if ($item->usuarioID == $usuarioID) {
                                $comentado = true;
                                break;
                            }
                        endforeach;

                        if ($usuarioLoggeado->tipoUsuario == "Estudiante" && $cursoComprado && !$comentado) { ?>
                            <form id="commentForm" class="mb-4" method="post" action="/controladores/insertarComentario.php">
                                <div class="mb-3 mt-4">
                                    <label for="rating" class="form-label">Calificación</label>
                                    <select id="rating" name="calificacion" required>
                                        <option disabled selected value="">Selecciona una calificación</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="commentContent" class="form-label">Comentario</label>
                                    <textarea class="form-control" name="comentario" id="commentContent" rows="3"
                                        required></textarea>
                                </div>
                                <input type="hidden" value="<?php echo $cursoID ?>" name="curso">
                                <input type="hidden" value="<?php echo $usuarioLoggeado->usuarioID ?>" name="usuario">
                                <button type="submit" class="btn color-btn">Agregar Comentario</button>
                            </form>
                        <?php } ?> <?php } ?>
                    <div id="comentarios">
                        <?php foreach ($comentarios as $comentario): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="card-title mb-0">
                                            <?php echo htmlspecialchars($comentario->usuarioNombre); ?>
                                        </h5>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-muted">Calificación:
                                        <?php echo htmlspecialchars($comentario->calificacion); ?>/5
                                    </h6>
                                    <p class="card-text"><?php echo htmlspecialchars($comentario->texto); ?></p>
                                    <p class="card-text"><small class="text-muted">Fecha:
                                            <?php echo htmlspecialchars($comentario->fechaCreacion); ?></small></p>
                                    <?php ?>

                                    <?php if ($usuarioLoggeado->tipoUsuario == "Administrador") { ?>
                                        <a class="btn color-btn float-right"
                                            href="/controladores/borrarComentario.php?comentario=<?php echo $comentario->comentarioID ?>">Borrar
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>


</body>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const forms = document.querySelectorAll('.purchaseForm');

        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                alert('Compra completada');
            });
        });
    });

</script>


<script>
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill'
        },
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $curso->costoGeneral ?>
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            actions.order.capture().then(function (detalles) {
                alert('Compra completada');
                console.log(detalles);
                document.querySelector("#purchaseDetails").value = detalles.id;
                document.getElementById('cursoForm').submit();
            });
        },
        onCancel: function (data) {
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
</script>
<?php include("footer.php") ?>

</html>