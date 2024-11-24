<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/curso.css">
</head>

<?php include("header.php") ?>

<?php
include('conectarBD.php');
$database = new db();
$conexion = $database->conectarBD();

include("controladores/ObtenerCurso.php"); ?>

<body>
    <main>
        <header class="curso-hero">
            <img src="/media/curso1.png">
            <div class="hero-content">
                <h1 class="mt-4">
                    <?php echo $curso->nombre ?>
                </h1>
                <p> <?php echo $curso->descripcion ?></p>
                <h2 class="mb-4"> $<?php echo $curso->costoGeneral ?></h2>
                <p class="fw-bold text-white">Calificación <?php echo $curso->calificacion ?>/5</p>
                <a href="#detalle-curso" class="color-btn">Mas detalles</a>
                <div class="mt-3">
                    <a href="#" class="">Inteligencia Artificial</a>,
                    <a href="#" class="">Programacion</a>
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
                            <tr>
                                <td><a href="#html-css">Fundamentos de HTML y CSS</a></td>
                                <td>✔️</td>
                                <td>✔️</td>
                            </tr>
                            <tr>
                                <td><a href="#javascript-react">JavaScript y React</a></td>
                                <td>✔️</td>
                                <td>✔️</td>
                            </tr>
                            <tr>
                                <td><a href="#wordpress">Integración con WordPress</a></td>
                                <td>❌</td>
                                <td><a href="#" class="transparent-btn" data-bs-toggle="modal"
                                        data-bs-target="#purchaseModal">Comprar 5$</a></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="width: 100%; text-align:center">
                        <?php if ($usuarioLoggeado) { ?>
                            <a type="button" href="#" class="mt-4 transparent-btn" style="display:block"
                                data-bs-toggle="modal" data-bs-target="#purchaseModal">Comprar todo el curso 25$</a>
                            <a type="button" href="/diploma.php" class="mt-4 color-btn" style="display:block">Curso
                                completado!</a>
                        <?php } ?>
                    </div>
                </div>

                <div class="texto mt-5">
                    <h2>Comentarios</h2>
                    <?php if ($usuarioLoggeado) { ?>
                        <form id="commentForm" class="mb-4">
                            <div class="mb-3 mt-4">
                                <label for="rating" class="form-label">Calificación</label>

                                <select id="rating" name="rating" required>
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
                                <textarea class="form-control" id="commentContent" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn color-btn">Agregar Comentario</button>
                        </form>
                    <?php } ?>
                    <div id="comentarios">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="/media/curso2.png" alt="Juan Pérez" class="rounded-circle me-3" width="50"
                                        height="50">
                                    <h5 class="card-title mb-0">Juan Pérez</h5>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">Calificación: 4/5</h6>
                                <p class="card-text">Muy buen curso</p>
                                <p class="card-text"><small class="text-muted">Fecha: 20/09/2024</small></p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="/media/curso3.png" alt="Ana Gómez" class="rounded-circle me-3" width="50"
                                        height="50">
                                    <h5 class="card-title mb-0">Ana Gómez</h5>
                                </div>
                                <h6 class="card-subtitle mb-2 text-muted">Calificación: 5/5</h6>
                                <p class="card-text">Excelente curso!, muy claro y conciso.</p>
                                <p class="card-text"><small class="text-muted">Fecha: 19/09/2024</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="purchaseModalLabel">Comprar Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="purchaseForm">
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Método de Pago</label>
                            <select class="form-select" id="paymentMethod" required>
                                <option value="">Selecciona una opción</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="purchaseDetails" class="form-label">Datos de Compra</label>
                            <input type="text" class="form-control" id="purchaseDetails"
                                placeholder="Ej. Número de tarjeta, correo de PayPal" required>
                        </div>
                        <button type="submit" class="btn color-btn">Comprar 5$</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>


<script>
    document.getElementById('purchaseForm').addEventListener('submit', function (event) {
        event.preventDefault();
        alert('Compra completada');
        window.location.href = '/curso.php';
    });
</script>
<?php include("footer.php") ?>

</html>