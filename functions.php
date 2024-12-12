<?php

function CalificacionPromedio($id){
    $database = new db();
    $conexion = $database->conectarBD();
    $sql = "select ObtenerPromedioCalificacionCurso(?) as Promedio";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $promedio = $result->fetch_assoc()['Promedio'];
    $result->free();
    $stmt->close();
    $conexion->close();
    return $promedio;
}

function getCursoId($tituloCurso, $nombreCreador)  {
    $database = new db();
    $conexion = $database->conectarBD();
    $sql = "select C.CursoID from Curso C join Usuario U on C.CreadorID = U.UsuarioID where C.Nombre = ? and U.Nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ss', $tituloCurso, $nombreCreador);
    $stmt->execute();
    $result = $stmt->get_result();
    $id = $result->fetch_assoc()['CursoID'];
    
    $result->free();
    $stmt->close();
    $conexion->close();

    return $id;
}