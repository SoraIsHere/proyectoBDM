DELIMITER //

CREATE PROCEDURE ObtenerKardex(
    IN p_UsuarioID INT,
    IN p_FechaInicio DATE,
    IN p_FechaFin DATE,
    IN p_CategoriaID INT,
    IN p_SoloTerminados BOOLEAN,
    IN p_SoloActivos BOOLEAN
)
BEGIN
    SELECT 
        c.Nombre AS NombreCurso,
        c.CostoGeneral AS CostoCurso,
        uc.FechaInscripcion,
        uc.FechaFinalizacion,
        uc.UltimaVisitaDeLeccion,
        CASE
            WHEN uc.Terminado = 1 THEN 'Terminado'
            ELSE 'Incompleto'
        END AS EstadoCurso,
        (SELECT COUNT(*) FROM Leccion l WHERE l.CursoID = c.CursoID) AS TotalNiveles,
        (SELECT COUNT(*) FROM UsuarioLeccion ul WHERE ul.UsuarioID = p_UsuarioID AND ul.Leido = TRUE AND ul.LeccionID IN (SELECT LeccionID FROM Leccion WHERE CursoID = c.CursoID)) AS NivelesCompletados,
        CONCAT(ROUND(
            (SELECT COUNT(*) FROM UsuarioLeccion ul WHERE ul.UsuarioID = p_UsuarioID AND ul.Leido = TRUE AND ul.LeccionID IN (SELECT LeccionID FROM Leccion WHERE CursoID = c.CursoID)) / 
            (SELECT COUNT(*) FROM Leccion l WHERE l.CursoID = c.CursoID) * 100, 2), '%') AS ProgresoCurso
    FROM 
        UsuarioCurso uc
    JOIN 
        Curso c ON uc.CursoID = c.CursoID
    JOIN 
        Categoria cat ON c.CategoriaID = cat.CategoriaID
    WHERE 
        uc.UsuarioID = p_UsuarioID
        AND (p_FechaInicio IS NULL OR uc.FechaInscripcion >= p_FechaInicio)
        AND (p_FechaFin IS NULL OR uc.FechaInscripcion <= p_FechaFin)
        AND (p_CategoriaID IS NULL OR cat.CategoriaID = p_CategoriaID)
        AND (p_SoloTerminados = FALSE OR uc.Terminado = TRUE)
        AND (p_SoloActivos = FALSE OR uc.Terminado = FALSE);
END //
/***/
DELIMITER $$

CREATE PROCEDURE ReporteVentasCursos(
    IN p_FechaInicio DATE,
    IN p_FechaFin DATE,
    IN p_CategoriaID INT,
    IN p_Activo BOOLEAN
)
BEGIN
    SELECT 
        C.CursoID,
        C.Nombre AS NombreCurso,
        COUNT(DISTINCT UC.UsuarioID) AS CantidadAlumnosInscritos,
        AVG(L.Orden) AS NivelPromedio,
        SUM(C.CostoGeneral) AS TotalIngresos,
        UC.FormaPago
    FROM 
        Curso C
    JOIN 
        UsuarioCurso UC ON C.CursoID = UC.CursoID
    JOIN 
        Usuario U ON UC.UsuarioID = U.UsuarioID
    JOIN 
        Categoria CAT ON C.CategoriaID = CAT.CategoriaID
    JOIN 
        UsuarioLeccion UL ON UC.UsuarioID = UL.UsuarioID
    JOIN 
        Leccion L ON UL.LeccionID = L.LeccionID
    WHERE 
        (C.FechaCreacion BETWEEN COALESCE(p_FechaInicio, '1970-01-01') AND COALESCE(p_FechaFin, '9999-12-31'))
        AND (C.CategoriaID = p_CategoriaID OR p_CategoriaID IS NULL)
        AND (C.BorradoLogico = FALSE OR p_Activo IS NULL)
    GROUP BY 
        C.CursoID, C.Nombre, UC.FormaPago;
END$$

DELIMITER ;
DELIMITER $$

CREATE PROCEDURE ReporteDetallesCurso(
    IN p_CursoID INT,
    IN p_FechaInicio DATE,
    IN p_FechaFin DATE
)
BEGIN
    SELECT 
        C.CursoID,
        C.Nombre AS NombreCurso,
        U.UsuarioID,
        U.Nombre AS NombreAlumno,
        UC.FechaInscripcion,
        MAX(L.Orden) AS NivelAvance,  -- Obtener el orden más grande como nivel de avance
        C.CostoGeneral AS PrecioPagado,
        UC.FormaPago
    FROM 
        Curso C
    JOIN 
        UsuarioCurso UC ON C.CursoID = UC.CursoID
    JOIN 
        Usuario U ON UC.UsuarioID = U.UsuarioID
    JOIN 
        UsuarioLeccion UL ON UC.UsuarioID = UL.UsuarioID
    JOIN 
        Leccion L ON UL.LeccionID = L.LeccionID
    WHERE 
        C.CursoID = p_CursoID
        AND (UC.FechaInscripcion BETWEEN COALESCE(p_FechaInicio, '1970-01-01') AND COALESCE(p_FechaFin, '9999-12-31'))
    GROUP BY 
        C.CursoID, C.Nombre, U.UsuarioID, U.Nombre, UC.FechaInscripcion, UC.FormaPago
    ORDER BY 
        U.Nombre;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE BuscarCursos(
    IN p_CategoriaID INT,
    IN p_TituloCurso VARCHAR(100),
    IN p_CreadorID INT,
    IN p_FechaInicio DATE,
    IN p_FechaFin DATE
)
BEGIN
    SELECT 
        C.CursoID,
        C.Nombre AS TituloCurso,
        C.CostoGeneral,
        C.Descripcion,
        C.Calificacion,
        C.FechaCreacion,
        U.Nombre AS NombreCreador,
        CAT.Nombre AS Categoria
    FROM 
        Curso C
    JOIN 
        Usuario U ON C.CreadorID = U.UsuarioID
    JOIN 
        Categoria CAT ON C.CategoriaID = CAT.CategoriaID
    WHERE 
        C.BorradoLogico = FALSE
        AND (C.CategoriaID = p_CategoriaID OR p_CategoriaID IS NULL)
        AND (C.Nombre LIKE CONCAT('%', p_TituloCurso, '%') OR p_TituloCurso IS NULL)
        AND (C.CreadorID = p_CreadorID OR p_CreadorID IS NULL)
        AND (C.FechaCreacion BETWEEN COALESCE(p_FechaInicio, '1970-01-01') AND COALESCE(p_FechaFin, '9999-12-31'))
    ORDER BY 
        C.FechaCreacion DESC;
END$$
DELIMITER $$

CREATE PROCEDURE ReporteInstructores()
BEGIN
    SELECT 
        U.UsuarioID AS Usuario,
        U.Nombre,
        U.FechaModificacion AS FechaIngreso,
        COUNT(DISTINCT C.CursoID) AS CantidadCursosOfrecidos,
        SUM(L.Costo) AS TotalGanancias
    FROM 
        Usuario U
    JOIN 
        Curso C ON U.UsuarioID = C.CreadorID
    JOIN 
        Leccion L ON C.CursoID = L.CursoID
    JOIN 
        UsuarioLeccion UL ON L.LeccionID = UL.LeccionID
    WHERE 
        U.TipoUsuario = 'Instructor'
        AND U.BorradoLogico = FALSE
    GROUP BY 
        U.UsuarioID, U.Nombre, U.FechaModificacion;
END$$

DELIMITER $$

CREATE PROCEDURE ReporteEstudiantes()
BEGIN
    SELECT 
        U.UsuarioID AS Usuario,
        U.Nombre,
        U.FechaModificacion AS FechaIngreso,
        COUNT(UC.CursoID) AS CantidadCursosInscritos,
        (COUNT(CASE WHEN UC.Terminado = TRUE THEN 1 END) / COUNT(UC.CursoID)) * 100 AS PorcentajeCursosTerminados
    FROM 
        Usuario U
    JOIN 
        UsuarioCurso UC ON U.UsuarioID = UC.UsuarioID
    WHERE 
        U.TipoUsuario = 'Estudiante'
        AND U.BorradoLogico = FALSE
    GROUP BY 
        U.UsuarioID, U.Nombre, U.FechaModificacion;
END$$

DELIMITER ;

/*Este es para la otra materia del api*/
DELIMITER $$
CREATE PROCEDURE GetUsuarioInfo(
    IN p_UsuarioID INT
)
BEGIN
    -- Información del Usuario
    SELECT 
        UsuarioID, Nombre, Apellido, Genero, FechaNacimiento, Foto, Email, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion
    FROM 
        Usuario 
    WHERE 
        UsuarioID = p_UsuarioID;

    -- Cursos en los que está inscrito el Usuario
    SELECT 
        C.CursoID, C.Nombre AS CursoNombre, C.CostoGeneral, C.Descripcion, C.Calificacion, C.CategoriaID, C.CreadorID, C.Imagen, C.BorradoLogico, C.FechaCreacion, C.FechaEliminacion,
        UC.Terminado, UC.FechaFinalizacion, UC.FechaInscripcion, UC.UltimaVisitaDeLeccion, UC.FormaPago
    FROM 
        UsuarioCurso UC
    JOIN 
        Curso C ON UC.CursoID = C.CursoID
    WHERE 
        UC.UsuarioID = p_UsuarioID;

    -- Lecciones de los cursos en los que está inscrito el Usuario
    SELECT 
        L.LeccionID, L.Nombre AS LeccionNombre, L.Costo, L.Orden, L.Descripcion, L.Video, L.CursoID, L.BorradoLogico, L.FechaEliminacion,
        UL.Leido
    FROM 
        UsuarioLeccion UL
    JOIN 
        Leccion L ON UL.LeccionID = L.LeccionID
    WHERE 
        UL.UsuarioID = p_UsuarioID;
END$$

DELIMITER ;
call GetUsuarioInfo(
    2
);