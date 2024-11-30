DELIMITER $$
CREATE PROCEDURE ValidarInscripcion(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    SELECT usuarioID, cursoID, Terminado, FechaFinalizacion, FechaInscripcion, UltimaVisitaDeLeccion, FormaPago
    FROM UsuarioCurso
    WHERE UsuarioID = p_UsuarioID AND CursoID = p_CursoID;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ObtenerLeccionesUsuario(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    SELECT UL.LeccionID, UL.Leido
    FROM UsuarioLeccion UL
    JOIN Leccion L ON UL.LeccionID = L.LeccionID
    WHERE UL.UsuarioID = p_UsuarioID AND L.CursoID = p_CursoID;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE ObtenerUsuarioPorID(
    IN p_UsuarioID INT
)
BEGIN
    SELECT UsuarioID, Nombre, Apellido, Email, Genero, FechaNacimiento, Foto, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion
    FROM Usuario
    WHERE UsuarioID = p_UsuarioID;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE VerificarLeccionesIncompletas(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    SELECT COUNT(*) as Incompletas
    FROM UsuarioLeccion UL
    INNER JOIN Leccion L ON UL.LeccionID = L.LeccionID
    WHERE UL.UsuarioID = p_UsuarioID AND L.CursoID = p_CursoID AND UL.Leido = FALSE;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE VerificarUsuarioCurso(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
     SELECT usuarioID, cursoID, Terminado, FechaFinalizacion, FechaInscripcion, UltimaVisitaDeLeccion, FormaPago
    FROM UsuarioCurso
    WHERE UsuarioID = p_UsuarioID AND CursoID = p_CursoID;
END$$

DELIMITER $$
CREATE PROCEDURE ObtenerUsuarioLecciones(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    SELECT UL.UsuarioID, UL.LeccionID, UL.Leido
    FROM UsuarioLeccion UL
    INNER JOIN Leccion L ON UL.LeccionID = L.LeccionID
    WHERE UL.UsuarioID = p_UsuarioID AND L.CursoID = p_CursoID;
END$$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE ObtenerInformacionUsuario(
    IN p_UsuarioID INT
)
BEGIN
    SELECT UsuarioID, Nombre, Apellido, Genero, FechaNacimiento, Email, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion
    FROM Usuario
    WHERE UsuarioID = p_UsuarioID;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE ObtenerCursosUsuario(
    IN p_UsuarioID INT
)
BEGIN
    SELECT C.CursoID, C.Nombre AS CursoNombre, C.CostoGeneral, C.Descripcion, C.Calificacion, C.CategoriaID, C.CreadorID, C.BorradoLogico, C.FechaCreacion, C.FechaEliminacion,
           UC.Terminado, UC.FechaFinalizacion, UC.FechaInscripcion, UC.UltimaVisitaDeLeccion, UC.FormaPago
    FROM UsuarioCurso UC
    JOIN Curso C ON UC.CursoID = C.CursoID
    WHERE UC.UsuarioID = p_UsuarioID;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE ObtenerLeccionesPorUsuario(
    IN p_UsuarioID INT
)
BEGIN
    SELECT L.LeccionID, L.Nombre AS LeccionNombre, L.Costo, L.Orden, L.Descripcion, L.CursoID, L.BorradoLogico, L.FechaEliminacion,
           UL.Leido
    FROM UsuarioLeccion UL
    JOIN Leccion L ON UL.LeccionID = L.LeccionID
    WHERE UL.UsuarioID = p_UsuarioID;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ObtenerCursosCreador(
    IN p_CreadorID INT
)
BEGIN
    SELECT CursoID, Nombre, Descripcion, Calificacion, CostoGeneral
    FROM Curso
    WHERE CreadorID = p_CreadorID and BorradoLogico = false;
END$$

DELIMITER $$
CREATE PROCEDURE VerificarCursoCompletado(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    SELECT Terminado, FechaFinalizacion
    FROM UsuarioCurso
    WHERE UsuarioID = p_UsuarioID AND CursoID = p_CursoID AND Terminado = TRUE;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ObtenerCreador(
    IN p_CreadorID INT
)
BEGIN
    SELECT Nombre, Apellido
    FROM Usuario
    WHERE UsuarioID = p_CreadorID;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE ObtenerInformacionCurso(
    IN p_CursoID INT
)
BEGIN
    SELECT Nombre, Descripcion, CostoGeneral
    FROM Curso
    WHERE CursoID = p_CursoID AND BorradoLogico = 0;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE ActualizarCurso(
    IN p_CursoID INT,
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_CostoGeneral DECIMAL(10,2)
)
BEGIN
    UPDATE Curso
    SET Nombre = p_Nombre, Descripcion = p_Descripcion, CostoGeneral = p_CostoGeneral
    WHERE CursoID = p_CursoID;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE ActualizarLeccion(
    IN p_LeccionID INT,
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_Costo DECIMAL(10,2)
)
BEGIN
    UPDATE Leccion
    SET Nombre = p_Nombre, Descripcion = p_Descripcion, Costo = p_Costo
    WHERE LeccionID = p_LeccionID;
END$$
DELIMITER ;
