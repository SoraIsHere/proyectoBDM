DELIMITER $$

create  PROCEDURE ObtenerInstructoresDeAlumno(
    IN p_AlumnoID INT
)
BEGIN
    SELECT 
        DISTINCT U.UsuarioID,
        U.Nombre,
        U.Apellido,
        U.Foto
    FROM 
        UsuarioCurso UC
    JOIN 
        Curso C ON UC.CursoID = C.CursoID
    JOIN 
        Usuario U ON C.CreadorID = U.UsuarioID
    WHERE 
        UC.UsuarioID = p_AlumnoID;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE ObtenerMensajesChat(
    IN p_UsuarioID1 INT,
    IN p_UsuarioID2 INT
)
BEGIN
    SELECT 
        MensajeID,
        Texto,
        EmisorID,
        ReceptorID,
        FechaEnvio,
        BorradoLogico
    FROM 
        Mensaje
    WHERE 
        (EmisorID = p_UsuarioID1 AND ReceptorID = p_UsuarioID2)
        OR (EmisorID = p_UsuarioID2 AND ReceptorID = p_UsuarioID1)
    ORDER BY 
        FechaEnvio ASC;
END$$

DELIMITER $$

CREATE PROCEDURE ObtenerUsuariosConMensajes(
    IN p_UsuarioID INT
)
BEGIN
    SELECT 
        DISTINCT U.UsuarioID,
        U.Nombre,
        U.Apellido,
        U.Foto
    FROM 
        Usuario U
    JOIN 
        Mensaje M ON (U.UsuarioID = M.EmisorID OR U.UsuarioID = M.ReceptorID)
    WHERE 
        (M.EmisorID = p_UsuarioID OR M.ReceptorID = p_UsuarioID)
        AND U.UsuarioID <> p_UsuarioID;
END$$

DELIMITER ;
