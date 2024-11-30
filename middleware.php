<?php
session_start();
include_once 'modelos/Usuarios.php';
function authMiddleware() //este alomejor no cuenta xD
{
    if (!isset($_SESSION['usuarioLoggeado'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
        header("Location: /inisesion.php?");
    }
}

//estos si cuentan deseguro! 
function alumnoMiddleware()
{
    if (!isset($_SESSION['usuarioLoggeado'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
        header("Location: /inisesion.php?creado=true");
    }
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    if ($usuarioLoggeado->tipoUsuario != "Estudiante") {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no apto']);
        header("Location: /index.php");
    }
}

function adminMiddleware()
{
    if (!isset($_SESSION['usuarioLoggeado'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
        header("Location: /inisesion.php?creado=true");
    }
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);
    if ($usuarioLoggeado->tipoUsuario != "Administrador") {
        header("Location: /index.php");
        echo json_encode(['status' => 'error', 'message' => 'Usuario no apto']);
    }
}
function instructorMiddleware()
{
    if (!isset($_SESSION['usuarioLoggeado'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
        header("Location: /inisesion.php?");
    }
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);

    if ($usuarioLoggeado->tipoUsuario != "Instructor") {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no apto']);
        header("Location: /index.php");
    }
}

function chatMiddleware()
{
    if (!isset($_SESSION['usuarioLoggeado'])) {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no loggeado']);
        header("Location: /inisesion.php?");
    }
    $usuarioLoggeado = unserialize($_SESSION['usuarioLoggeado']);

    if ($usuarioLoggeado->tipoUsuario == "Administrador") {
        echo json_encode(['status' => 'error', 'message' => 'Usuario no apto']);
        header("Location: /index.php");
    }
}