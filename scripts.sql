CREATE DATABASE bdm;
USE bdm;

CREATE TABLE Usuario (
    UsuarioID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Genero varchar(50) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    Foto LONGBLOB,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Contrasena VARCHAR(255) NOT NULL,
    TipoUsuario ENUM('Instructor', 'Estudiante', 'Administrador') NOT NULL,
    FechaModificacion TIMESTAMP NOT NULL,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaEliminacion TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE Categoria (
    CategoriaID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    CreadorID INT NOT NULL,
    FechaCreacion TIMESTAMP NOT NULL,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaEliminacion TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (CreadorID) REFERENCES Usuario(UsuarioID)
);

CREATE TABLE Curso (
    CursoID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    CostoGeneral DECIMAL(10,2) NOT NULL,
    Descripcion TEXT NOT NULL,
    Calificacion INT DEFAULT 1 CHECK (Calificacion BETWEEN 1 AND 5) NOT NULL,
    CategoriaID INT NOT NULL,
    CreadorID INT NOT NULL, -- Nuevo campo para identificar al creador del curso
    Imagen LONGBLOB,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaCreacion TIMESTAMP,
    FechaEliminacion TIMESTAMP NULL,
    FOREIGN KEY (CategoriaID) REFERENCES Categoria(CategoriaID),
    FOREIGN KEY (CreadorID) REFERENCES Usuario(UsuarioID) -- Clave foránea al usuario creador
);


CREATE TABLE Leccion (
    LeccionID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Costo DECIMAL(10,2) NOT NULL,
    Orden INT NOT NULL,
    Descripcion TEXT,
    Video LONGBLOB,
    CursoID INT NOT NULL,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaEliminacion TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (CursoID) REFERENCES Curso(CursoID)
);

CREATE TABLE Mensaje (
    MensajeID INT PRIMARY KEY AUTO_INCREMENT,
    Texto TEXT NOT NULL,
    EmisorID INT NOT NULL,
    ReceptorID INT NOT NULL,
    FechaEnvio TIMESTAMP NOT NULL,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaEliminacion TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (EmisorID) REFERENCES Usuario(UsuarioID),
    FOREIGN KEY (ReceptorID) REFERENCES Usuario(UsuarioID)
);

CREATE TABLE Comentario (
    ComentarioID INT PRIMARY KEY AUTO_INCREMENT,
    Texto TEXT NOT NULL,
    UsuarioID INT NOT NULL,
    Calificacion INT DEFAULT 1 CHECK (Calificacion BETWEEN 1 AND 5) NOT NULL,
    CursoID INT NOT NULL,
    BorradoLogico BOOLEAN DEFAULT FALSE NOT NULL,
    FechaEliminacion TIMESTAMP NULL DEFAULT NULL,
    FechaCreacion TIMESTAMP NOT NULL,
    FOREIGN KEY (UsuarioID) REFERENCES Usuario(UsuarioID),
    FOREIGN KEY (CursoID) REFERENCES Curso(CursoID)
);

CREATE TABLE UsuarioCurso (
    UsuarioID INT NOT NULL,
    CursoID INT NOT NULL,
    Terminado BOOLEAN NOT NULL,
    FechaFinalizacion DATE,
    FechaInscripcion DATE,
    UltimaVisitaDeLeccion DATE,
    FormaPago VARCHAR(50),
    PRIMARY KEY (UsuarioID, CursoID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuario(UsuarioID),
    FOREIGN KEY (CursoID) REFERENCES Curso(CursoID)
);

CREATE TABLE UsuarioLeccion (
    UsuarioID INT NOT NULL,
    LeccionID INT NOT NULL,
    Leido BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY (UsuarioID, LeccionID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuario(UsuarioID),
    FOREIGN KEY (LeccionID) REFERENCES Leccion(LeccionID)
);
/***********************************************************************************/
/*PROCEDURES*/
DELIMITER $$

CREATE PROCEDURE InsertarUsuario(
    IN p_Nombre VARCHAR(100),
    IN p_Apellido VARCHAR(100),
    IN p_Genero ENUM('M', 'F', 'Otro'),
    IN p_FechaNacimiento DATE,
    IN p_Foto LONGBLOB,
    IN p_Email VARCHAR(100),
    IN p_Contrasena VARCHAR(255),
    IN p_TipoUsuario ENUM('Instructor', 'Estudiante', 'Administrador')
)
BEGIN
    INSERT INTO Usuario (Nombre,Apellido,Genero, FechaNacimiento, Foto, Email, Contrasena, TipoUsuario, FechaModificacion, BorradoLogico)
    VALUES (p_Nombre, p_Apellido ,p_Genero, p_FechaNacimiento, p_Foto, p_Email, p_Contrasena, p_TipoUsuario, CURRENT_TIMESTAMP, FALSE);
END$$

DELIMITER $$

CREATE PROCEDURE InsertarCategoria(
    IN p_Nombre VARCHAR(100),
    IN p_Descripcion TEXT,
    IN p_CreadorID INT
)
BEGIN
    INSERT INTO Categoria (Nombre, Descripcion, CreadorID, FechaCreacion, BorradoLogico)
    VALUES (p_Nombre, p_Descripcion, p_CreadorID, CURRENT_TIMESTAMP, FALSE);
END$$

DELIMITER $$
CREATE PROCEDURE InsertarCurso(
    IN p_Nombre VARCHAR(100),
    IN p_CostoGeneral DECIMAL(10,2),
    IN p_Descripcion TEXT,
    IN p_CategoriaID INT,
    IN p_CreadorID INT,
    IN p_Imagen LONGBLOB,
    OUT p_CursoID INT
)
BEGIN
    INSERT INTO Curso (Nombre, CostoGeneral, Descripcion, Calificacion, CategoriaID, CreadorID, Imagen, FechaCreacion, BorradoLogico)
    VALUES (p_Nombre, p_CostoGeneral, p_Descripcion, 1, p_CategoriaID, p_CreadorID, p_Imagen, CURRENT_DATE, FALSE);
    SET p_CursoID = LAST_INSERT_ID();
END$$

DELIMITER $$
CREATE PROCEDURE InsertarLeccion(
    IN p_Nombre VARCHAR(100),
    IN p_Costo DECIMAL(10,2),
    IN p_Orden INT,
    IN p_Descripcion TEXT,
    IN p_Video LONGBLOB,
    IN p_CursoID INT
)
BEGIN
    INSERT INTO Leccion (Nombre, Costo, Orden, Descripcion, Video, CursoID, BorradoLogico)
    VALUES (p_Nombre, p_Costo, p_Orden, p_Descripcion, p_Video, p_CursoID, FALSE);
END$$

DELIMITER $$

CREATE PROCEDURE InsertarMensaje(
    IN p_Texto TEXT,
    IN p_EmisorID INT,
    IN p_ReceptorID INT
)
BEGIN
    INSERT INTO Mensaje (Texto, EmisorID, ReceptorID, FechaEnvio, BorradoLogico)
    VALUES (p_Texto, p_EmisorID, p_ReceptorID, CURRENT_TIMESTAMP, FALSE);
END$$

DELIMITER $$
CREATE PROCEDURE InsertarComentario(
    IN p_Texto TEXT,
    IN p_UsuarioID INT,
    IN p_Calificacion INT,
    IN p_CursoID INT
)
BEGIN
    INSERT INTO Comentario (Texto, UsuarioID, Calificacion, CursoID, BorradoLogico, FechaCreacion)
    VALUES (p_Texto, p_UsuarioID, p_Calificacion, p_CursoID, FALSE, CURRENT_TIMESTAMP);
END$$
DELIMITER $$

create  PROCEDURE InsertarUsuarioCurso(
    IN p_UsuarioID INT,
    IN p_CursoID INT,
    IN p_Terminado BOOLEAN,
    IN p_FormaPago VARCHAR(50)
)
BEGIN
    INSERT INTO UsuarioCurso (UsuarioID, CursoID, Terminado, FechaFinalizacion, FechaInscripcion, FormaPago)
    VALUES (p_UsuarioID, p_CursoID, p_Terminado, null, CURRENT_DATE, p_FormaPago);
END$$

DELIMITER $$

CREATE PROCEDURE InsertarUsuarioLeccion(
    IN p_UsuarioID INT,
    IN p_LeccionID INT,
    IN p_Leido BOOLEAN
)
BEGIN
    INSERT INTO UsuarioLeccion (UsuarioID, LeccionID, Leido)
    VALUES (p_UsuarioID, p_LeccionID, p_Leido);
END$$


/*edicion*/
DELIMITER $$
CREATE PROCEDURE EditarUsuario(
    IN p_UsuarioID INT,
    IN p_Nombre VARCHAR(100),
    IN p_Apellido VARCHAR(100),
    IN p_Genero VARCHAR(100),
    IN p_FechaNacimiento DATE,
    IN p_Foto LONGBLOB,
    IN p_Contrasena VARCHAR(255)
)
BEGIN
    UPDATE Usuario
    SET 
        Nombre = COALESCE(p_Nombre, Nombre),
        Apellido = COALESCE(p_Apellido, Apellido),
        Genero = COALESCE(p_Genero, Genero),
        FechaNacimiento = COALESCE(p_FechaNacimiento, FechaNacimiento),
        Foto = COALESCE(p_Foto,Foto), -- Usamos IFNULL para evitar sobreescribir con NULL
        Contrasena = COALESCE(p_Contrasena, Contrasena),
        FechaModificacion = CURRENT_TIMESTAMP
    WHERE UsuarioID = p_UsuarioID;
END$$

DELIMITER $$
CREATE PROCEDURE EditarCategoria(
    IN p_CategoriaID INT,
    IN p_Nombre VARCHAR(100),
    IN p_Descripcion TEXT
)
BEGIN
    UPDATE Categoria
    SET 
        Nombre = COALESCE(p_Nombre, Nombre),
        Descripcion = COALESCE(p_Descripcion, Descripcion)
    WHERE CategoriaID = p_CategoriaID;
END$$

DELIMITER $$

CREATE PROCEDURE EditarCurso(
    IN p_CursoID INT,
    IN p_Nombre VARCHAR(100),
    IN p_CostoGeneral DECIMAL(10,2),
    IN p_Descripcion TEXT,
    IN p_Calificacion INT,
    IN p_CategoriaID INT,
    IN p_Imagen LONGBLOB
)
BEGIN
    UPDATE Curso
    SET 
        Nombre = COALESCE(p_Nombre, Nombre),
        CostoGeneral = COALESCE(p_CostoGeneral, CostoGeneral),
        Descripcion = COALESCE(p_Descripcion, Descripcion),
        Calificacion = COALESCE(p_Calificacion, Calificacion),
        CategoriaID = COALESCE(p_CategoriaID, CategoriaID),
        Imagen = COALESCE(p_Imagen, Imagen)
    WHERE CursoID = p_CursoID;
END$$




DELIMITER $$

CREATE PROCEDURE EditarLeccion(
    IN p_LeccionID INT,
    IN p_Nombre VARCHAR(100),
    IN p_Costo DECIMAL(10,2),
    IN p_Orden INT,
    IN p_Descripcion TEXT,
    IN p_Video LONGBLOB
)
BEGIN
    UPDATE Leccion
    SET 
        Nombre = COALESCE(p_Nombre, Nombre),
        Costo = COALESCE(p_Costo, Costo),
        Orden = COALESCE(p_Orden, Orden),
        Descripcion = COALESCE(p_Descripcion, Descripcion),
        Video = COALESCE(p_Video, Video)
    WHERE LeccionID = p_LeccionID;
END$$

DELIMITER ;

/*borrar*/
DELIMITER $$

CREATE PROCEDURE EliminarUsuario(
    IN p_UsuarioID INT
)
BEGIN
    UPDATE Usuario
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE UsuarioID = p_UsuarioID;
END$$

DELIMITER $$

CREATE PROCEDURE EliminarCategoria(
    IN p_CategoriaID INT
)
BEGIN
    UPDATE Categoria
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE CategoriaID = p_CategoriaID;
END$$

DELIMITER ;
DELIMITER $$

CREATE PROCEDURE EliminarCurso(
    IN p_CursoID INT
)
BEGIN
    UPDATE Curso
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE CursoID = p_CursoID;
END$$

DELIMITER ;
DELIMITER $$

CREATE PROCEDURE EliminarLeccion(
    IN p_LeccionID INT
)
BEGIN
    UPDATE Leccion
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE LeccionID = p_LeccionID;
END$$

DELIMITER ;
DELIMITER $$

CREATE PROCEDURE EliminarMensaje(
    IN p_MensajeID INT
)
BEGIN
    UPDATE Mensaje
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE MensajeID = p_MensajeID;
END$$

DELIMITER ;
DELIMITER $$

CREATE PROCEDURE EliminarComentario(
    IN p_ComentarioID INT
)
BEGIN
    UPDATE Comentario
    SET 
        BorradoLogico = TRUE,
        FechaEliminacion = CURRENT_TIMESTAMP
    WHERE ComentarioID = p_ComentarioID;
END$$

/**Login**/
DELIMITER $$

CREATE PROCEDURE LoginUsuario(
    IN p_Email VARCHAR(100),
    IN p_Contrasena VARCHAR(255)
)
BEGIN
    SELECT 
        UsuarioID, Nombre, Apellido, Email, Genero, FechaNacimiento, Foto, TipoUsuario, FechaModificacion, BorradoLogico, FechaEliminacion
    FROM 
        Usuario
    WHERE 
        Email = p_Email 
        AND Contrasena = p_Contrasena
        AND BorradoLogico = FALSE;
END$$

DELIMITER ;

/**cosas del curso**/

DELIMITER $$

CREATE PROCEDURE ActualizarTerminado(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    UPDATE UsuarioCurso
    SET 
        Terminado = TRUE,
        FechaFinalizacion = CURRENT_DATE
    WHERE UsuarioID = p_UsuarioID AND CursoID = p_CursoID;
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE ActualizarUltimaVisitaDeLeccion(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    UPDATE UsuarioCurso
    SET 
        UltimaVisitaDeLeccion = CURRENT_DATE
    WHERE UsuarioID = p_UsuarioID AND CursoID = p_CursoID;
END$$

DELIMITER ;



/**Triggers**/
DELIMITER $$

CREATE TRIGGER ActualizarCalificacionCursoInsert
AFTER INSERT ON Comentario
FOR EACH ROW
BEGIN
    DECLARE promedio DECIMAL(5,2);

    SELECT CEIL(AVG(Calificacion))
    INTO promedio
    FROM Comentario
    WHERE CursoID = NEW.CursoID
    AND BorradoLogico = FALSE;

    UPDATE Curso
    SET Calificacion = promedio
    WHERE CursoID = NEW.CursoID;
END$$

DELIMITER $$
CREATE TRIGGER ActualizarCalificacionCursoUpdate
AFTER UPDATE ON Comentario
FOR EACH ROW
BEGIN
    DECLARE promedio DECIMAL(5,2);

    SELECT CEIL(AVG(Calificacion))
    INTO promedio
    FROM Comentario
    WHERE CursoID = OLD.CursoID
    AND BorradoLogico = FALSE;

    UPDATE Curso
    SET Calificacion = promedio
    WHERE CursoID = OLD.CursoID;
END$$

DELIMITER $$
CREATE PROCEDURE ObtenerCursosInicio(
    IN p_Criterio INT,
    IN p_Limit INT
)
BEGIN
    IF p_Limit IS NULL OR p_Limit = 0 THEN
        SET p_Limit = 3; 
    END IF;

    IF p_Criterio = 0 THEN /* mejor calificados */
        SELECT Curso.CursoID, Curso.Nombre, Curso.CostoGeneral, Curso.Descripcion, Curso.Calificacion, Curso.CategoriaID, Curso.CreadorID, Curso.Imagen, Curso.BorradoLogico, Curso.FechaCreacion, Curso.FechaEliminacion, Categoria.BorradoLogico AS categoriaBorrada, Categoria.Nombre AS categoriaNombre
        FROM Curso
        JOIN Categoria ON Curso.CategoriaID = Categoria.CategoriaID
        WHERE Curso.BorradoLogico = FALSE
        ORDER BY Curso.Calificacion DESC
        LIMIT p_Limit;
    ELSEIF p_Criterio = 1 THEN /* más ventas */
        SELECT Curso.CursoID, Curso.Nombre, Curso.CostoGeneral, Curso.Descripcion, Curso.Calificacion, Curso.CategoriaID, Curso.CreadorID, Curso.Imagen, Curso.BorradoLogico, Curso.FechaCreacion, Curso.FechaEliminacion, Categoria.BorradoLogico AS categoriaBorrada, Categoria.Nombre AS categoriaNombre, COUNT(UsuarioCurso.CursoID) AS Ventas
        FROM Curso
        JOIN UsuarioCurso ON Curso.CursoID = UsuarioCurso.CursoID
        JOIN Usuario ON UsuarioCurso.UsuarioID = Usuario.UsuarioID
        JOIN Categoria ON Curso.CategoriaID = Categoria.CategoriaID
        WHERE Curso.BorradoLogico = FALSE
        AND Usuario.BorradoLogico = FALSE
        GROUP BY Curso.CursoID, Curso.Nombre, Curso.CostoGeneral, Curso.Descripcion, Curso.Calificacion, Curso.CategoriaID, Curso.CreadorID, Curso.Imagen, Curso.BorradoLogico, Curso.FechaCreacion, Curso.FechaEliminacion, Categoria.BorradoLogico, Categoria.Nombre
        HAVING Ventas > 0
        ORDER BY Ventas DESC
        LIMIT p_Limit;
    ELSEIF p_Criterio = 2 THEN /* más recientes */
        SELECT Curso.CursoID, Curso.Nombre, Curso.CostoGeneral, Curso.Descripcion, Curso.Calificacion, Curso.CategoriaID, Curso.CreadorID, Curso.Imagen, Curso.BorradoLogico, Curso.FechaCreacion, Curso.FechaEliminacion, Categoria.BorradoLogico AS categoriaBorrada, Categoria.Nombre AS categoriaNombre
        FROM Curso
        JOIN Categoria ON Curso.CategoriaID = Categoria.CategoriaID
        WHERE Curso.BorradoLogico = FALSE
        ORDER BY Curso.FechaCreacion DESC
        LIMIT p_Limit;
    ELSE
        SELECT 'Criterio no válido' AS Mensaje;
    END IF;
END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE ObtenerCategorias()
BEGIN
    SELECT CategoriaID, Nombre, Descripcion, CreadorID, FechaCreacion, BorradoLogico, FechaEliminacion
    FROM Categoria
    WHERE BorradoLogico = FALSE;
END$$

DELIMITER $$

CREATE TRIGGER MarcarCursosYComentariosBorradosAlBorrarUsuario
AFTER UPDATE ON Usuario
FOR EACH ROW
BEGIN
    IF OLD.BorradoLogico = FALSE AND NEW.BorradoLogico = TRUE THEN
        -- Marcar cursos como borrados
        UPDATE Curso 
        SET BorradoLogico = TRUE 
        WHERE CreadorID = OLD.UsuarioID;

        -- Marcar comentarios como borrados
        UPDATE Comentario 
        SET BorradoLogico = TRUE 
        WHERE UsuarioID = OLD.UsuarioID;
    END IF;
END$$

DELIMITER $$

CREATE PROCEDURE ObtenerCategoriasUsuario(
 IN p_Usuario INT)
BEGIN
    SELECT CategoriaID, Nombre, Descripcion, CreadorID, FechaCreacion, BorradoLogico, FechaEliminacion
    FROM Categoria
    WHERE BorradoLogico = FALSE and CreadorID = p_Usuario;
END$$

DELIMITER $$

create  PROCEDURE ObtenerCategoria(
 IN p_idCat INT)
BEGIN
    SELECT CategoriaID, Nombre, DescripcionCategoriaID, Nombre, Descripcion, CreadorID, FechaCreacion, BorradoLogico, FechaEliminacion
    FROM Categoria
    WHERE CategoriaID = p_idCat;
END$$

DELIMITER $$
CREATE PROCEDURE ObtenerCurso(
    IN p_CursoID INT
)
BEGIN
    SELECT Curso.CursoID, Curso.Nombre, Curso.CostoGeneral, Curso.Descripcion, Curso.Calificacion, Curso.CategoriaID, Curso.CreadorID, Curso.Imagen, Curso.BorradoLogico, Curso.FechaCreacion, Curso.FechaEliminacion, Categoria.BorradoLogico AS categoriaBorrada, Categoria.Nombre AS categoriaNombre
    FROM Curso
    JOIN Categoria ON Curso.CategoriaID = Categoria.CategoriaID
    WHERE Curso.CursoID = p_CursoID
      AND Curso.BorradoLogico = FALSE;
END$$

DELIMITER $$
CREATE PROCEDURE ObtenerLeccionesPorCurso(
    IN p_CursoID INT
)
BEGIN
    SELECT Leccion.LeccionID, Leccion.Nombre, Leccion.Costo, Leccion.Orden, Leccion.Descripcion, Leccion.Video, Leccion.CursoID, Leccion.BorradoLogico, Leccion.FechaEliminacion
    FROM Leccion
    WHERE Leccion.CursoID = p_CursoID
      AND Leccion.BorradoLogico = FALSE;
END$$

DELIMITER $$
CREATE PROCEDURE ObtenerComentariosPorCurso(
    IN p_CursoID INT
)
BEGIN
    SELECT 
        C.ComentarioID,
        C.Texto,
        C.UsuarioID,
        U.Nombre AS UsuarioNombre,
        C.Calificacion,
        C.CursoID,
        C.BorradoLogico,
        C.FechaEliminacion,
        C.FechaCreacion
    FROM 
        Comentario C
        INNER JOIN Usuario U ON C.UsuarioID = U.UsuarioID
    WHERE 
        C.CursoID = p_CursoID AND C.BorradoLogico = FALSE
    ORDER BY 
        C.FechaCreacion DESC;
END$$

DELIMITER $$

CREATE PROCEDURE completarLeccion(
    IN p_UsuarioID INT,
    IN p_LeccionID INT
)
BEGIN
    UPDATE UsuarioLeccion
    SET 
        Leido = TRUE
    WHERE 
        UsuarioID = p_UsuarioID 
        AND LeccionID = p_LeccionID;
END$$

DELIMITER $$

CREATE PROCEDURE completarCurso(
    IN p_UsuarioID INT,
    IN p_CursoID INT
)
BEGIN
    UPDATE UsuarioCurso
    SET 
        Terminado = TRUE,
        FechaFinalizacion = CURRENT_DATE
    WHERE 
        UsuarioID = p_UsuarioID 
        AND CursoID = p_CursoID;
END$$
