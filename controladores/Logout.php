<?php
session_start();

// Almacenar el objeto Usuario en la sesión
$_SESSION['usuarioLoggeado'] = null;

// Redirigir al índice
header("Location:../inisesion.php");

